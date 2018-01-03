<?php
namespace backend\controllers;

use backend\components\JdbConsts;
use backend\service\TravelOperationLogService;
use PHPUnit\Framework\Exception;
use Qiniu\Auth;
require_once '../../common/tools/yii2-qiniu/autoload.php';
use Qiniu\Storage\UploadManager;
use Yii;
use backend\models\TravelActivity;
use backend\models\TravelActivityQuery;
use yii\web\Controller;
use backend\models\TravelTag;
/**
 * TravelActivityManageController implements the CRUD actions for TravelActivity model.
 */
class TravelActivityManageController extends Controller
{
    public $enableCsrfValidation = false;
    /**
     * Lists all TravelActivity models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TravelActivityQuery();
        $searchModel->status_arr = [1,2];
        $searchModel->resource = 1;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $tags = TravelTag::find()->select(['id','title'])->where(['status' => 1,'type' => 2])->all();
        $tag = [];
        if(!empty($tags)){
            foreach($tags as $k => $v){
                $tag[$v['id']] = $v['title'];
            }
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'tag' => $tag,
        ]);
    }

    /**
     * Displays a single TravelActivity model.
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
        //查询当前的线路基本信息
        $model = TravelActivity::find()->where(['id' => $id])->one();
        //查询行程图文介绍
        $imgs = Yii::$app->db->createCommand("select * from travel_activity_imgs WHERE activity_id = {$id}")->queryAll();
        //查询操作日志
        $logs = TravelOperationLogService::getLogList($id,3);
        return $this->render('view', [
            'id'    => $id,
            'model' => $model,
            'imgs'  => $imgs,
            'logs'  => $logs
        ]);
    }


    /**
     * 修改当地活动
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        //首先判断有没有id传值
        $id = intval(trim(Yii::$app->request->get("id")));
        if($id==0){
            return $this->redirect(['error/index','code'=>1010,'msg'=>Yii::$app->params['travel_code']['1010']]);
        }

        $qiniu = new UploadManager();
        $au = '7Mz8kyvhYyyehoz1PLC93xRQtUpR5C9RTSGMG6L0';
        $sc = 'XbRaXfaFk-fokfn7yKzth5_8w-DIZWWy8Ir2OOzx';
        $auth = new Auth($au,$sc);
        $bucket = 'imgs';
        $token =$auth->uploadToken($bucket);

        $tag = TravelTag::find()->all();
        //查询当前的线路基本信息
        $model = TravelActivity::find()->where(['id' => $id])->one();
        $des_img = Yii::$app->db->createCommand("select * from `travel_activity_imgs` WHERE activity_id = {$id}")->queryAll();
        if (Yii::$app->request->isPost) {
            if(isset(Yii::$app->request->post()['TravelActivity']['type']) && Yii::$app->request->post()['TravelActivity']['type'] == 1){
                $model->scenario = 'lineupdate';
            }elseif(isset(Yii::$app->request->post()['TravelActivity']['type']) && Yii::$app->request->post()['TravelActivity']['type'] == 0){
                $model->scenario = 'onlineupdate';
            }
            if($model->load(Yii::$app->request->post()) && $model->validate()){
                //@2017-7-22 14:18:47 fuyanfei to add transaction
                $trans = Yii::$app->db->beginTransaction();
                try{
                    if(isset($_POST['pic'])){
                        $des_pics = $_POST['pic'];
                    }else{
                        $des_pics = [];
                    }
                    if(isset($_POST['pic_explain'])){
                        $pic_explain = $_POST['pic_explain'];
                    }else{
                        $pic_explain = [];
                    }
                    if(is_array($_POST['title_pic'])){
                        $pics = $_POST['title_pic'];
                        $title_pic = '';
                        $admin_uid = Yii::$app->user->getId();
                        $current_time = date("Y-m-d H:i:s",time());
                        foreach($pics as $k=>$v){
                            if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $v, $result)){
                                $houzhui = $result[2];
//                                $uid = Yii::$app->user->getId();
                                $key = 'theme_admin' . $admin_uid . '_' .microtime(true) .'.'. $houzhui;

                                $auth = new Auth(JdbConsts::QINIU_ACCESS_KEY, JdbConsts::QINIU_SECRET_KEY);
                                $bucket = 'imgs';
                                $token = $auth->uploadToken($bucket);
                                $uploadMgr = new UploadManager();
                                // 调用 UploadManager 的 putFile 方法进行文件的上传
                                list($ret, $err) = $uploadMgr->putFile($token, $key, $v);
                                if ($err !== null) {
                                    $arr = [
                                        'status' => 0,
                                        'error' => $err
                                    ];
                                } else {
                                    $arr = [
                                        'status' => 1,
                                        'imgs' => JdbConsts::DOMAIN_FACE . $ret['key']
                                    ];
                                    $title_pic .= JdbConsts::DOMAIN_FACE . $ret['key']. ',';
                                }
                            }else{
                                $title_pic .= $v.',';
                            }
                        }
                    }
                    $model->title_pic = trim($title_pic,',');
                    $model->update_time = $current_time;
                    $model->tag = implode(',',Yii::$app->request->post()['TravelActivity']['tag']);
                    $model->hot_spot = str_replace("\n","<br>",Yii::$app->request->post()['TravelActivity']['hot_spot']);
                    $model->des = str_replace("\n","<br>",Yii::$app->request->post()['TravelActivity']['des']);
                    $model->process = str_replace("\n","<br>",Yii::$app->request->post()['TravelActivity']['process']);
                    if(Yii::$app->request->post()['TravelActivity']['city_code'] != ""){
                        $cityArr = explode(",",Yii::$app->request->post()['TravelActivity']['city_code']);
                        $model->country_code = $cityArr[0];
                        $model->province_code = $cityArr[1];
                        $model->city_code = $cityArr[2];
                    }
                    $bool = $model->save();
                    // 活动行程描述
                    $des_img = Yii::$app->db->createCommand("DELETE FROM `travel_activity_imgs` WHERE activity_id = {$id}")->execute();
                    if (is_array($des_pics) && !empty($des_pics)) {
                        foreach ($des_pics as $k => $v) {
                            if (!empty($v)) {
                                $pic_explain_new = str_replace("\n", "<br>", $pic_explain[$k]);
                                Yii::$app->db->createCommand("INSERT INTO `travel_activity_imgs` SET activity_id = '{$id}', pic = '{$v}',pic_des = '".addslashes($pic_explain_new)."' ")->execute();
                            }
                        }
                    }
                    //@2017-7-22 14:20:56 fuyanfei to add opertion logs
                    $user = Yii::$app->user->identity['username'];
                    $remarks = date("Y-m-d H:i:s")."&nbsp;商品管理员：".$user."&nbsp;直接修改ID为".$id."的当地活动内容";
                    $log = TravelOperationLogService::insertLog(3,$id,8,"",$remarks);
                    $trans->commit();
                    if ($bool>=0 && $log['code']==1000) {
                        Yii::$app->session->setFlash("msg","操作成功");
                        return $this->redirect(['index']);
                    }
                    else{
                        dump($model->errors);
                        exit;
                    }
                }
                catch(Exception $e){
                    $trans->rollBack();
                    echo -1;
                }
            }else{
                $errors = $model->getErrors();
                $strArr = array();
                foreach ($errors as $k => $v) {
                    foreach ($v as $kk => $vv) {
                        $strArr[] = $vv;
                    }
                }
                $str = ''; //记录错误信息
                foreach ($strArr as $k => $v) {
                    $str .= ($k + 1) . '.' . $v;
                }
                Yii::$app->session->setFlash('success', $str);
                return $this->redirect(['update', 'id' => $id]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                'token' => $token,
                'tag' => $tag,
                'des_img' => $des_img,
            ]);
        }
    }

    /**
     * 获取当前点击的线路信息
     * @return string
     */
    public function actionGetActivityInfo()
    {
        if (Yii::$app->request->isAjax) {//是否ajax请求
            $activity_id = Yii::$app->request->post()['activity_id'];
            $info = Yii::$app->db->createCommand("SELECT id,name,status,sort,sort_start_date,sort_end_date FROM travel_activity WHERE id=:id")
                ->bindValue(":id",$activity_id)
                ->queryOne();
            return json_encode($info);
        }
    }

    /**
     * 修改排序
     * @throws \yii\db\Exception
     */
    public function actionUpdateSort()
    {
        if (Yii::$app->request->isAjax) {//是否ajax请求
            $activity_id = Yii::$app->request->post()['data']['activity_id'];
            $activity_sort = Yii::$app->request->post()['data']['activity_sort'];
            $sort_start_time = Yii::$app->request->post()['data']['sort_start_time'];
            $sort_end_time = Yii::$app->request->post()['data']['sort_end_time'];
            $user = Yii::$app->user->identity['username'];
            $remarks = date("Y-m-d H:i:s")."&nbsp;商品管理员：".$user."&nbsp;将ID为".$activity_id."的当地活动的排序改为：".$activity_sort."&nbsp;有效期为：".$sort_start_time."&nbsp;至&nbsp;".$sort_end_time;
            $current_date = date("Y-m-d");
            $trans = Yii::$app->db->beginTransaction();
            try{
                //snowno add at 2017/07/11 如果排序有效时间是今天 直接设置sort
                if($current_date == $sort_start_time){
                    $bool = Yii::$app->db->createCommand("UPDATE  `travel_activity` SET  sort = {$activity_sort},sort_start_date='".$sort_start_time."',sort_end_date='".$sort_end_time."'  WHERE id ={$activity_id}")->execute();
                }elseif($sort_start_time > $current_date){//加入排序准备字段
                    $bool = Yii::$app->db->createCommand("UPDATE  `travel_activity` SET  sort_prepare = {$activity_sort},sort_start_date='".$sort_start_time."',sort_end_date='".$sort_end_time."'  WHERE id ={$activity_id}")->execute();
                }
                //添加操作日志信息
                $res = TravelOperationLogService::insertLog(3,$activity_id,9,"",$remarks);
                $trans->commit();
                if ($bool>=0 && $res['code']==1000) {
                    echo 1;
                };
            }
            catch(Exception $e){
                $trans->rollBack();
                echo -1;
            }
        }
    }

    /**
     * 修改当地活动状态
     * @throws \yii\db\Exception
     */
    public function actionUpdateStatus()
    {
        if (Yii::$app->request->isAjax) {//是否ajax请求
            $user = Yii::$app->user->identity['username'];
            $activity_id = Yii::$app->request->post()['data']['activity_id'];
            $status = Yii::$app->request->post()['data']['status'];
            $remark = date("Y-m-d H:i:s")."&nbsp;商品管理员：".$user."&nbsp;将ID为".$activity_id."的当地活动改为【".Yii::$app->params['travel_status'][$status]."】状态";
            if($status==1 || $status==2){
                $reason = "";
            }
            if($status==3){
                $reason = Yii::$app->request->post()['data']['reason'] ? Yii::$app->request->post()['data']['reason'] : $remark;
            }
            $remarks =  Yii::$app->request->post()['data']['remarks'] ? Yii::$app->request->post()['data']['remarks'] : $remark;
            $trans = Yii::$app->db->beginTransaction();
            try{
                //修改线路信息
                $bool = Yii::$app->db->createCommand("UPDATE `travel_activity` SET  status = :status,update_time = :update_time,remarks=:remarks,reason=:reason  WHERE id =:id")
                    ->bindValue(":status",$status)
                    ->bindValue(":update_time",date("Y-m-d H:i:s",time()))
                    ->bindValue(":remarks",$remarks)
                    ->bindValue(":reason",$reason)
                    ->bindValue(":id",$activity_id)
                    ->execute();

                //添加操作日志信息
                $res = TravelOperationLogService::insertLog(3,$activity_id,$status,$reason,$remarks);
                $trans->commit();
                if ($bool && $res['code']==1000) {
                    echo 1;
                };
            }
            catch(Exception $e){
                $trans->rollBack();
                echo -1;
            }
        }
    }
}
