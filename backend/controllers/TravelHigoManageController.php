<?php

namespace backend\controllers;

use backend\models\TravelTag;
use backend\service\TravelOperationLogService;
use Qiniu\Auth;
require_once '../../common/tools/yii2-qiniu/autoload.php';
use Qiniu\Storage\UploadManager;
use Yii;
use backend\models\TravelHigo;
use backend\models\TravelHigoQuery;
use yii\base\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\components\JdbConsts;

/**
 * TravelHigoController implements the CRUD actions for TravelHigo model.
 */
class TravelHigoManageController extends Controller
{
    public $enableCsrfValidation = false;
    /**
     * Lists all TravelHigo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TravelHigoQuery();
        $searchModel->status_arr = [1,2];
        $searchModel->resource = 1;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $tags = TravelTag::find()->select(['id','title'])->where(['status' => 1,'type' => 3])->all();
        $tag = [];
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if(!empty($tags)){
            foreach($tags as $k=>$v){
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
     * Displays a single TravelHigo model.
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
        $model = TravelHigo::find()->where(['id' => $id])->one();
        //查询行程图文介绍
        $imgs = Yii::$app->db->createCommand("select * from travel_higo_content WHERE higo_id = {$id} AND is_del=0")->queryAll();
        //查询操作日志
        $logs = TravelOperationLogService::getLogList($id,4);
        return $this->render('view', [
            'id'    => $id,
            'model' => $model,
            'imgs' => $imgs,
            'logs' => $logs
        ]);
    }

    /**
     * Displays a single TravelHigo model.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        //首先判断有没有id传值
        if (isset(Yii::$app->request->get()['id'])) {
            $id = Yii::$app->request->get()['id'];
        } else {
            return $this->redirect(['error']);
        }
        if(!Yii::$app->request->isPost) {
            $qiniu = new UploadManager();
            $au = '7Mz8kyvhYyyehoz1PLC93xRQtUpR5C9RTSGMG6L0';
            $sc = 'XbRaXfaFk-fokfn7yKzth5_8w-DIZWWy8Ir2OOzx';
            $auth = new Auth($au, $sc);
            $bucket = 'imgs';
            $token = $auth->uploadToken($bucket);

            //查询当前的线路基本信息
            $model = TravelHigo::find()->where(['id' => $id])->one();
            //查询行程图文介绍
            $imgs = Yii::$app->db->createCommand("select * from travel_higo_content WHERE higo_id = {$id} AND is_del = 0")->queryAll();
            //查询操作日志
            $logs = Yii::$app->db->createCommand("select * from `travel_operation_log` WHERE type = 4 And obj_id = {$id}")->queryAll();

            //活动主题
            $tag = TravelTag::find()->where(['type' => 3,'status' => 1])->all();
//        var_dump($tag);exit;
            return $this->render('update', [
                'model' => $model,
                'imgs' => $imgs,
                'logs' => $logs,
                'token' => $token,
                'tag' => $tag,
            ]);

        }else{
//            var_dump(Yii::$app->request->post()['TravelHigo']);exit;
            //查询当前的线路基本信息
            $model = \backend\models\TravelHigo::find()->where(['id' => $id])->one();
            $model->scenario = 'adminupdate';
            $contentModel = \backend\models\TravelHigoContent::find()->where(['higo_id'=>$id,'is_del' => 0])->all();
            $data = Yii::$app->request->post()['TravelHigo'];

            if($model->load(Yii::$app->request->post()) && $model->validate()){
                $transone = Yii::$app->db->beginTransaction();
                try{
                    if(is_array($_POST['title_pic'])){
                        $pics = $_POST['title_pic'];
                        $title_pic = '';
                        $admin_uid = Yii::$app->user->getId();
                        $current_time = date("Y-m-d H:i:s",time());
                        foreach($pics as $k=>$v){
                            if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $v, $result)){
                                $houzhui = $result[2];
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
                    $model->first_pic = Yii::$app->request->post()['TravelHigo']['first_pic'];
                    $model->tag = implode(',',Yii::$app->request->post()['TravelHigo']['tag']);
                    $model->profiles = str_replace("\n","<br>",Yii::$app->request->post()['TravelHigo']['profiles']);
                    $model->high_light = str_replace("\n","<br>",Yii::$app->request->post()['TravelHigo']['high_light']);
                    if(Yii::$app->request->post()['TravelHigo']['start_city'] != ""){
                        $startCityArr = explode(",",Yii::$app->request->post()['TravelHigo']['start_city']);
                        $model->start_country = $startCityArr[0];
                        $model->start_province = $startCityArr[1];
                        $model->start_city = $startCityArr[2];
                    }
                    if(Yii::$app->request->post()['TravelHigo']['end_city'] != ""){
                        $endCityArr = explode(",",Yii::$app->request->post()['TravelHigo']['end_city']);
                        $model->end_country = $endCityArr[0];
                        $model->end_province = $endCityArr[1];
                        $model->end_city = $endCityArr[2];
                    }
                    $model->save();

                    //行程数据开始处理
                    $title = Yii::$app->request->post()['TravelHigo']['title'];
                    $introduce = Yii::$app->request->post()['TravelHigo']['introduce'];
                    if(isset(Yii::$app->request->post()['TravelHigo']['pic'])){
                        $pic = Yii::$app->request->post()['TravelHigo']['pic'];
                    }else{
                        $pic = [];
                    }
                    if(isset(Yii::$app->request->post()['TravelHigo']['pic_explain'])){
                        $pic_explain = Yii::$app->request->post()['TravelHigo']['pic_explain'];
                    }else{
                        $pic_explain = [];
                    }
                    $title = Yii::$app->request->post()['TravelHigo']['title'];
                    $introduce = Yii::$app->request->post()['TravelHigo']['introduce'];
                    if(isset(Yii::$app->request->post()['TravelHigo']['pic'])){
                        $pic = Yii::$app->request->post()['TravelHigo']['pic'];
                    }else{
                        $pic = [];
                    }

                    $current_time = date("Y-m-d H:i:s",time());
                    //20170731 改删除旧数据为修改状态is_del=1 ++++
                    //$des_data = Yii::$app->db->createCommand("delete from `travel_higo_content` WHERE higo_id = {$id}")->execute();
                    $des_data = Yii::$app->db->createCommand("UPDATE `travel_higo_content` SET is_del=1 WHERE higo_id = {$id} AND is_del=0")->execute();
                    if (is_array($title) && !empty($title)) {
                        foreach ($title as $k => $v) {
                            if(!empty($pic)){
                                $picstr = @implode(',',$pic[$k]);
                            }else{
                                $picstr = '';
                            }
//                            var_dump($pic_explain);
                            if(!empty($pic_explain)){
                                $explain = [];
                                $pic_explain_temp = [];
                                if($pic[$k]){
                                    foreach($pic[$k] as $s=>$t){
                                        if($t == ''){
                                            $explain[] = $s;
                                        }
                                    }
                                }
                                if($pic_explain[$k]){
                                    foreach($pic_explain[$k] as $a=>$b){
                                        if(in_array($a,$explain)){
                                            unset($pic_explain[$k][$a]);
                                        }
                                    }
                                }
                                $append = 0;
                                if($pic_explain[$k]){
                                    foreach($pic_explain[$k] as $i=>$t){
                                        $pic_explain_temp[$k][$append] = $t;
                                        $append++;
                                    }
                                }
                                $pic_explain[$k] = $pic_explain_temp[$k];
                                $pic_explainstr = @implode('***',$pic_explain[$k]);
                            }else{
                                $pic_explainstr = '';
                            }
                            $pic[$k] = @array_filter($pic[$k]);
                            @sort($pic[$k]);
                            if(!empty($pic)){
                                $picstr = @implode(',',$pic[$k]);
                            }else{
                                $picstr = '';
                            }
                            if (!empty($v) && !empty($introduce[$k])) {
                                $introduce_new = str_replace("\n","<br>",$introduce[$k]);
                                $pic_explainstr_new = str_replace("\n","<br>",$pic_explainstr);
                                Yii::$app->db->createCommand("INSERT INTO `travel_higo_content` SET is_del=0, create_time = '{$current_time}',higo_id = '{$id}', title='" . addslashes($v) . "',introduce ='" . addslashes($introduce_new) . "',pic='{$picstr}',pic_explain='" . addslashes($pic_explainstr_new) . "' ")->execute();
                            }
                        }
                    }
                    Yii::$app->db->createCommand("UPDATE  `travel_higo` SET update_time = '{$current_time}'  WHERE id ={$id} ")->execute();

                    $bool =  \backend\models\TravelHigoContent::find()->where(['higo_id' => $id,'is_del' => 0])->one();
                    //添加操作日志
                    $user = Yii::$app->user->identity['username'];
                    $remarks = date("Y-m-d H:i:s")."&nbsp;商品管理员：".$user."&nbsp;直接修改ID为".$id."的主题线路内容";
                    $log = TravelOperationLogService::insertLog(4,$id,8,"",$remarks);

                    if (empty($bool)) {
                        Yii::$app->session->setFlash('error', '行程介绍信息不能为空');
                        return $this->redirect(['update', 'id' => $id]);
                    } else {
                        $transone->commit();
                        Yii::$app->session->setFlash("msg","操作成功");
                        return $this->redirect(['index']);
                    }
                    //形成数据处理结束
                }catch(\yii\db\Exception $e){
                    $errors = $e->getMessage();
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
                    Yii::$app->session->setFlash('error', $str);
                    $transone->rollBack();
//                    var_dump($e->getMessage());
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
//                var_dump($str);exit;
            }
            //查询操作日志
            $logs = Yii::$app->db->createCommand("select * from `travel_operation_log` WHERE type = 4 And obj_id = {$id}")->queryAll();
            return $this->redirect(['view','id' => $id]);
        }
    }

    /**
     * 404页面
     * @return string
     */
    public function actionError()
    {
        return $this->render('error');
    }


    /**
     * 修改排序
     * @throws \yii\db\Exception
     */
    public function actionUpdateSort()
    {
        if (Yii::$app->request->isAjax) {//是否ajax请求
            $higo_id = Yii::$app->request->post()['data']['higo_id'];
            $higo_sort = Yii::$app->request->post()['data']['higo_sort'];
            $sort_start_time = Yii::$app->request->post()['data']['sort_start_time'];
            $sort_end_time = Yii::$app->request->post()['data']['sort_end_time'];
            $user = Yii::$app->user->identity['username'];
            $remarks = date("Y-m-d H:i:s")."&nbsp;商品管理员：".$user."&nbsp;将ID为".$higo_id."的主题线路的排序改为：".$higo_sort."&nbsp;有效期为：".$sort_start_time."&nbsp;至&nbsp;".$sort_end_time;
            $current_date = date("Y-m-d");
            $trans = Yii::$app->db->beginTransaction();
            try{
                //snowno add at 2017/07/11 如果排序有效时间是今天 直接设置sort
                if($current_date == $sort_start_time){
                    $bool = Yii::$app->db->createCommand("UPDATE  `travel_higo` SET  sort = {$higo_sort},sort_start_date='".$sort_start_time."',sort_end_date='".$sort_end_time."'  WHERE id ={$higo_id}")->execute();
                }elseif($sort_start_time > $current_date){//加入排序准备字段
                    $bool = Yii::$app->db->createCommand("UPDATE  `travel_higo` SET  sort_prepare = {$higo_sort},sort_start_date='".$sort_start_time."',sort_end_date='".$sort_end_time."'  WHERE id ={$higo_id}")->execute();
                }
                //添加操作日志信息
                $res = TravelOperationLogService::insertLog(4,$higo_id,9,"",$remarks);
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

    /**
     * 获取当前点击的线路信息
     * @return string
     */
    public function actionGetHigoInfo()
    {
        if (Yii::$app->request->isAjax) {//是否ajax请求
            $higo_id = Yii::$app->request->post()['higo_id'];
            $info = Yii::$app->db->createCommand("SELECT id,name,status,sort,sort_start_date,sort_end_date FROM travel_higo WHERE id=:id")
                ->bindValue(":id",$higo_id)
                ->queryOne();
            return json_encode($info);
        }
    }

    /**
     * 修改线路状态
     * @throws \yii\db\Exception
     */
    public function actionUpdateStatus()
    {
        if (Yii::$app->request->isAjax) {//是否ajax请求
            $user = Yii::$app->user->identity['username'];
            $higo_id = Yii::$app->request->post()['data']['higo_id'];
            $status = Yii::$app->request->post()['data']['status'];
            $remark = date("Y-m-d H:i:s")."&nbsp;商品管理员：".$user."&nbsp;将ID为".$higo_id."的主题线路改为【".Yii::$app->params['travel_status'][$status]."】状态";
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
                $bool = Yii::$app->db->createCommand("UPDATE `travel_higo` SET  status = :status,update_time = :update_time,remarks=:remarks,reason=:reason WHERE id =:id")
                    ->bindValue(":status",$status)
                    ->bindValue(":update_time",date("Y-m-d H:i:s",time()))
                    ->bindValue(":remarks",$remarks)
                    ->bindValue(":reason",$reason)
                    ->bindValue(":id",$higo_id)
                    ->execute();

                //添加操作日志信息
                $res = TravelOperationLogService::insertLog(4,$higo_id,$status,$reason,$remarks);
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
