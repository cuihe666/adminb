<?php

namespace backend\controllers;

use backend\models\TravelPerson;
use backend\models\UserCommon;
use backend\models\UserQuery;
use backend\models\TravelCompany;
use backend\service\TravelOperationLogService;
use PHPUnit\Framework\Exception;
use Yii;
use Qiniu\Auth;
require_once '../../common/tools/yii2-qiniu/autoload.php';
use Qiniu\Storage\UploadManager;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use backend\models\TravelAuth;
/**
 * TravelTalentController implements the CRUD actions for TravelTalent model.
 */
class TravelTalentController extends Controller
{
    /**
     * Lists all TravelTalent models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserQuery();
        $searchModel->iscount = 1;
        $dataProvider = $searchModel->searchTalent(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TravelTalent model.
     * @param integer $id
     * @return mixed
     */
    public function actionView()
    {
        //首先判断有没有id传值
        $id = intval(trim(Yii::$app->request->get("id")));
        if($id==0){
            return $this->redirect(['error/index','code'=>1010,'msg'=>Yii::$app->params['travel_code']['1010']]);
        }
        $model = UserCommon::find()->where(['uid' => $id])->one();
        $auth = TravelAuth::getUserAuth($id);
        //查询银行账号信息
        $bankInfo = Yii::$app->db->createCommand("select * from travel_account_bank where uid = :uid")
            ->bindValue(":uid",$id)
            ->queryOne();
        if($model){
            if($model->is_daren == 1 && $auth['auth']){
                if($auth['auth'] == 1){//公司
                    //查询操作日志
                    $logs = TravelOperationLogService::getLogList($auth['model']['id'],2);
                    return $this->render('view-company',['model' => $auth['model'],'bankInfo'=>$bankInfo,'auth'=>$auth['auth'],'logs'=>$logs]);
                }else if($auth['auth'] == 2){
                    //查询操作日志
                    $logs = TravelOperationLogService::getLogList($auth['model']['id'],1);
                    $auth['model']->recommend = str_replace("<br>","\n",$auth['model']->recommend);
                    return $this->render('view-person',['model' => $auth['model'],'bankInfo'=>$bankInfo,'auth'=>$auth['auth'],'logs'=>$logs]);
                }
            }
        }
    }

    /**
     * 修改信息
     * @param string $id
     * @return string|\yii\web\Response
     */
    public function actionUpdate($id = ''){
        if(!$id){
            return $this->redirect(['error/index','code'=>1010,'msg'=>Yii::$app->params['travel_code']['1010']]);
        }
        $model = UserCommon::find()->where(['uid' => $id])->one();
        if(!$model){
            return $this->redirect(['error/index','code'=>1030,'msg'=>Yii::$app->params['travel_code']['1030']]);
        }
        $auth = TravelAuth::getUserAuth($id);
        $au = Yii::$app->params['qiniu']['access_key'];
        $sc = Yii::$app->params['qiniu']['secret_key'];
        $authModel = new Auth($au,$sc);
        $bucket = Yii::$app->params['qiniu']['bucketDef'];
        $token = $authModel->uploadToken($bucket);
        //查询银行账号信息
        $bankInfo = Yii::$app->db->createCommand("select * from travel_account_bank where uid = :uid")
            ->bindValue(":uid",$id)
            ->queryOne();

        if($model){
            if($model->is_daren == 1 && $auth['auth']){
                if($auth['auth'] == 1){//公司
                    return $this->render('company',['model' => $auth['model'],'token' => $token,'bankInfo'=>$bankInfo,'auth'=>$auth['auth']]);
                }else if($auth['auth'] == 2){
                    return $this->render('person',['model' => $auth['model'],'token' => $token,'bankInfo'=>$bankInfo,'auth'=>$auth['auth']]);
                }
            }
        }
    }

    /**
     * 驳回-修改达人状态
     * @return int
     * @throws \yii\db\Exception
     */
    public function actionUpdateStatus()
    {
        if (Yii::$app->request->isAjax) {//是否ajax请求
            $user = Yii::$app->user->identity['username'];
            $params = Yii::$app->request->post()['data'];
            $remark = date("Y-m-d H:i:s")."&nbsp;商品管理员：".$user."&nbsp;将ID为".$params['user_id']."的用户改为【".Yii::$app->params['person_status'][$params['status']]."】状态";
            $reason = $params['reason'] ? $params['reason'] : $remark;

            $remarks =  $params['remarks'] ? $params['remarks'] : $remark;
            $trans = Yii::$app->db->beginTransaction();
            try{
                //个人资质
                $person = Yii::$app->db->createCommand("SELECT * FROM travel_person WHERE uid = :uid")
                    ->bindValue(":uid",$params['user_id'])
                    ->queryOne();
                //公司资质
                $company = Yii::$app->db->createCommand("SELECT * FROM travel_company WHERE uid = :uid")
                    ->bindValue(":uid",$params['user_id'])
                    ->queryOne();
                //如果个人资质不为空，公司资质为空
                if($person && !$company){
                    $bool = $this->updatePersonStatus($params['status'],$remark,$reason,$params['user_id']);
                    $log_type = 1;
                    $obj_id = $person['id'];
                }
                //公司资质不为空，个人资质为空
                elseif($company && !$person){
                    //修改公司资质审核信息
                    $bool = $this->updateCompanyStatus($params['status'],$remarks,$reason,$params['user_id']);
                    $log_type = 2;
                    $obj_id = $company['id'];
                }
                //公司资质和个人资质都不为空的时候，以最新的时间为准
                elseif($company && $person){
                    if($company['create_time'] > $person['create_time']){
                        //修改公司资质审核信息
                        $bool = $this->updateCompanyStatus($params['status'],$remarks,$reason,$params['user_id']);
                        $log_type = 2;
                        $obj_id = $company['id'];
                    } else{
                        //修改个人资质审核信息
                        $bool = $this->updatePersonStatus($params['status'],$remark,$reason,$params['user_id']);
                        $log_type = 1;
                        $obj_id = $person['id'];
                    }
                }
                //添加操作日志信息
                $res = TravelOperationLogService::insertLog($log_type,$obj_id,$params['status'],$reason,$remarks);
                $trans->commit();
            } catch(\Exception $e){
                $trans->rollBack();
            }
            return $bool;
        }
    }

    /**
     * 个人资料信息的修改
     * @throws \yii\db\Exception
     */
    public function actionUpdatePerson(){
        $params = Yii::$app->request->post();
        $model = TravelPerson::findOne($params['person_id']);
        if(!$model){
            return $this->redirect(['error/index','code'=>1030,'msg'=>Yii::$app->params['travel_code']['1030']]);
        }
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $trans = Yii::$app->db->beginTransaction();
            try{
                //修改个人基本信息
                $res = $model->save();
                //修改银行账号信息
                $paramsBank = [
                    $paramsBank['bankInfoId'] = $params['bankInfoId'],
                    $paramsBank['account_type'] = $params['account_type'],
                    $paramsBank['account_name1'] = $params['account_name1'],
                    $paramsBank['account_num1'] = $params['account_num1'],
                    $paramsBank['account_bank1'] = $params['account_bank1'],
                    $paramsBank['account_name2'] = $params['account_name2'],
                    $paramsBank['account_num2'] = $params['account_num2'],
                    $paramsBank['user_id'] = $params['user_id'],
                ];
                $bRes = $this->updateBankInfo($params);

                //添加操作日志信息
                $user = Yii::$app->user->identity['username'];
                $remarks = date("Y-m-d H:i:s")."&nbsp;管理员：".$user."&nbsp;直接修改ID为".$params['person_id']."的个人性质的达人信息";
                $log = TravelOperationLogService::insertLog(1,$params['person_id'],8,"",$remarks);
                $trans->commit();
                Yii::$app->session->setFlash('succ', '操作成功');
            }catch(\Exception $e){
                $trans->rollBack();
                Yii::$app->session->setFlash('succ', '操作失败');
            }
            $this->redirect(['index']);
        }
        else{
            dump($model->errors);
        }
    }

    /**
     * 修改达人银行卡信息
     * @param $params
     * @return int
     * @throws \yii\db\Exception
     */
    public static function updateBankInfo($params){
        if($params['account_type']==1){  //银行卡
            $account_name = $params['account_name1'];
            $account_num = $params['account_num1'];
            $account_bank = $params['account_bank1'];
        }
        else{
            $account_name = $params['account_name2'];
            $account_num = $params['account_num2'];
            $account_bank = "";
        }
        if($params['bankInfoId']){
            $res = Yii::$app->db->createCommand("UPDATE travel_account_bank SET account_type = :account_type , account_name = :account_name , account_num = :account_num , account_bank = :account_bank , update_time = :update_time WHERE uid=:uid")
                ->bindValue(":account_type",$params['account_type'])
                ->bindValue(":account_name",$account_name)
                ->bindValue(":account_num",$account_num)
                ->bindValue(":account_bank",$account_bank)
                ->bindValue(":update_time",time())
                ->bindValue(":uid",$params['user_id'])
                ->execute();
        } else{
            $res = Yii::$app->db->createCommand("INSERT INTO travel_account_bank(account_type,account_name,account_num,account_bank,uid,is_del,create_time) VALUES (:account_type,:account_name,:account_num,:account_bank,:uid,:is_del,:create_time)")
                ->bindValue(":account_type",$params['account_type'])
                ->bindValue(":account_name",$account_name)
                ->bindValue(":account_num",$account_num)
                ->bindValue(":account_bank",$account_bank)
                ->bindValue(":uid",$params['user_id'])
                ->bindValue(":is_del",0)
                ->bindValue(":create_time",time())
                ->execute();
        }
        return $res;
    }

    /**
     * 修改个人资质的审核信息
     * @param $status
     * @param $remarks
     * @param $reason
     * @param $uid
     * @return int
     * @throws \yii\db\Exception
     */
    public static function updatePersonStatus($status,$remarks,$reason,$uid){
        $bool = Yii::$app->db->createCommand("UPDATE `travel_person` SET  status = :status,remarks=:remarks,reason=:reason  WHERE uid =:uid")
            ->bindValue(":status",$status)
            ->bindValue(":remarks",$remarks)
            ->bindValue(":reason",$reason)
            ->bindValue(":uid",$uid)
            ->execute();
        return $bool;
    }

    /**
     * 修改公司资质的审核信息
     * @param $status
     * @param $remarks
     * @param $reason
     * @param $uid
     * @return int
     * @throws \yii\db\Exception
     */
    public static function updateCompanyStatus($status,$remarks,$reason,$uid){
        $bool = Yii::$app->db->createCommand("UPDATE `travel_company` SET  status = :status,remarks=:remarks,reason=:reason  WHERE uid =:uid")
            ->bindValue(":status",$status)
            ->bindValue(":remarks",$remarks)
            ->bindValue(":reason",$reason)
            ->bindValue(":uid",$uid)
            ->execute();
        return $bool;
    }

    /**
     * 公司资料信息的修改
     * @throws \yii\db\Exception
     */
    public function actionUpdateCompany(){
        $params = Yii::$app->request->post();
//        var_dump($params);exit;
        $model = TravelCompany::find()->with('bank')->where(['id' => $params['company_id']])->one();
        if(!$model){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        if($model->reg_addr_type == 1){
            switch ($model->group_type){
                case 1:
                     $model->scenario = 'addtwo';
                    break;
                case 2:
                     $model->scenario = 'addtwocnnot';
                    break;
            }
        }else if(in_array($model->reg_addr_type,[2,3,4])){
            switch ($model->group_type){
                case 1:
                     $model->scenario = 'addtwoabis';
                    break;
                case 2:
                     $model->scenario = 'addtwoabroadnot';
                    break;
            }
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
//            var_dump($params['travelAccountBank']['account_bank']);exit;
            $trans = Yii::$app->db->beginTransaction();
            try{
                //修改公司基本信息
                $res = $model->save();
                //修改银行账号信息
                if($params['travelAccountBank']['account_type']==1)  //银行卡
                    $account_bank = $params['travelAccountBank']['account_bank'];
                else
                    $account_bank = "";
                Yii::$app->db->createCommand("UPDATE travel_account_bank SET account_type = :account_type , account_name = :account_name , account_num = :account_num , account_bank = :account_bank , update_time = :update_time WHERE uid=:uid")
                    ->bindValue(":account_type",$params['travelAccountBank']['account_type'])
                    ->bindValue(":account_name",$params['travelAccountBank']['account_name'])
                    ->bindValue(":account_num",$params['travelAccountBank']['account_num'])
                    ->bindValue(":account_bank",$account_bank)
                    ->bindValue(":update_time",time())
                    ->bindValue(":uid",$params['user_id'])
                    ->execute();
                //添加操作日志信息
                $user = Yii::$app->user->identity['username'];
                $remarks = date("Y-m-d H:i:s")."&nbsp;管理员：".$user."&nbsp;直接修改ID为".$params['company_id']."的公司性质的达人信息";
                $log = TravelOperationLogService::insertLog(2,$params['company_id'],8,"",$remarks);
                $trans->commit();
                Yii::$app->session->setFlash('succ', '操作成功');
            }catch(\Exception $e){
                $trans->rollBack();
                Yii::$app->session->setFlash('succ', '操作失败');
            }
            $this->redirect(['index']);
        }else{
            $err = $model->getErrors();
            if(!empty($err)){
                $error_str = '';
                $i = 1;
                foreach($err as $k => $v){
                    $error_str .= $i.$v[0].'<br/>';
                    $i++;
                }
                Yii::$app->session->setFlash('errors', $error_str);
                $this->redirect(['update','id' => $params['user_id']]);
            }
        }
    }

}
