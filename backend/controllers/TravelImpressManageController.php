<?php

namespace backend\controllers;

use backend\models\Qiniu;
use backend\service\TravelOperationLogService;
use backend\service\TravelTagService;
use Yii;
use backend\models\TravelImpress;
use backend\models\TravelImpressQuery;
use yii\base\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TravelImpressController implements the CRUD actions for TravelImpress model.
 */
class TravelImpressManageController extends Controller
{
    public $enableCsrfValidation = false;

    /**
     * Lists all TravelImpress models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TravelImpressQuery();
        $searchModel->status_arr = [1,2];
        //$searchModel->resource = 1;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //印象类型---暂时注释，带老数据整理好后再用
        //$tag = TravelTagService::getTagReturnKeyValue(5);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            //'tag' => $tag,
        ]);
    }

    /**
     * Displays a single TravelImpress model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        //首先判断有没有id传值
        $id = intval(trim(Yii::$app->request->get("id")));
        if($id==0){
            return $this->redirect(['error/index','code'=>1010,'msg'=>Yii::$app->params['travel_code']['1010']]);
        }
        //查询当前的线路基本信息
        $model = TravelImpress::find()->where(['id' => $id])->one();
        //查询操作日志
        $logs = TravelOperationLogService::getLogList($id,5);
        return $this->render('view', [
            'id' => $id,
            'model' => $model,
            'logs' => $logs
        ]);
    }

    /**
     * Updates an existing TravelImpress model.
     * If update is successful, the browser will be redirected to the 'view' page.
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
        //查询当前的线路基本信息
        $model = TravelImpress::find()->where(['id' => $id])->one();
        if (Yii::$app->request->isPost) {
            $trans = Yii::$app->db->beginTransaction();
            try{
                $params = Yii::$app->request->post();
                $model->load(Yii::$app->request->post());
                $uid = Yii::$app->user->getId();
                if (!isset($params['title_pic'])) {
                    Yii::$app->session->setFlash('success', '图片不能为空');
                    return $this->redirect(['impression/update', 'id' => $id]);
                }
                if (is_array($_POST['title_pic'])) {
                    $pics = $_POST['title_pic'];
                    $title_pic = '';
                    foreach ($pics as $k => $v) {
                        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $v, $result)) {
                            $houzhui = $result[2];
                            $ret = Qiniu::upload('.' . $houzhui, $uid, $v, 'impress');
                            if ($ret) {
                                $title_pic .= Yii::$app->params['imgUrl'] . $ret . ',';
                            } else {
                                Yii::$app->session->setFlash('success', '图片上传失败');
                                return $this->redirect(['travel-impress-manage/update', 'id' => $id]);
                            }
                        } else {
                            $title_pic .= $v . ',';
                        }
                    }
                }
                $model->pic = trim($title_pic, ',');
                $model->first_pic = $params['TravelImpress']['first_pic'];
                $model->update_time = date("Y-m-d H:i:s", time());
                if ($params['TravelImpress']['city1'] != "") {
                    $city1Arr = explode(",", $params['TravelImpress']['city1']);
                    $model->country1 = $city1Arr[0];
                    $model->province1 = $city1Arr[1];
                    $model->city1 = $city1Arr[2];
                }
                if ($params['TravelImpress']['city2'] != "") {
                    $city2Arr = explode(",", $params['TravelImpress']['city2']);
                    $model->country2 = $city2Arr[0];
                    $model->province2 = $city2Arr[1];
                    $model->city2 = $city2Arr[2];
                }
                if ($params['TravelImpress']['city3'] != "") {
                    $city3Arr = explode(",", $params['TravelImpress']['city3']);
                    $model->country3 = $city3Arr[0];
                    $model->province3 = $city3Arr[1];
                    $model->city3 = $city3Arr[2];
                }
                if (isset($_FILES) && !empty($_FILES['mp3'])/* && $_FILES['mp3']['error'] == '0'*/) {
                    $mp3 = $_FILES['mp3'];
                    if ($_FILES['mp3']['name'] != '' && !Qiniu::verifytype($mp3['type'])) {
                        $str = '请上传正确的文件类型';
                        Yii::$app->session->setFlash('error', $str);
                        return $this->redirect(['update', 'id' => $model->id]);
                    }
                    $mp3_name = Qiniu::upload($mp3['name'], 11, $mp3['tmp_name'], 'mp3');

                    if ($mp3_name) {
                        $music = Yii::$app->params['imgUrl'] . $mp3_name;
                    } else {
                        $music = '';
                    }
                } else if (isset($_POST['mp3'])) {
                    $music = $_POST['_mp3'];
                } else {
                    $music = '';
                }

                //暂时注释掉上传音乐的功能。------------------------------------------------------------------------
                if ($model->music != '' && $music == '') {
                    $model->music = '';
                } else if ($model->music == '' && $music == '') {
                    $model->music = '';
                } else {
                    $model->music = $music;
                }

                $model->des = str_replace("\n", "<br>", $params['TravelImpress']['des']);
                $upd = $model->save();

                //添加操作日志信息
                $user = Yii::$app->user->identity['username'];
                $remarks = date("Y-m-d H:i:s")."&nbsp;商品管理员：".$user."&nbsp;直接修改ID为".$id."的印象内容";
                $res = TravelOperationLogService::insertLog(5,$id,8,"",$remarks);
                $trans->commit();
                if ($upd>=0 && $res['code']==1000) {
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
            }
        } else {
            return $this->render('update', [
                'id' => $id,
                'model' => $model,
            ]);
        }
    }

    /**
     * 获取当前点击的印象信息
     * @return string
     */
    public function actionGetImpressInfo()
    {
        if (Yii::$app->request->isAjax) {//是否ajax请求
            $impress_id = Yii::$app->request->post()['impress_id'];
            $info = Yii::$app->db->createCommand("SELECT id,name,status,sort,sort_start_date,sort_end_date FROM travel_impress WHERE id=:id")
                ->bindValue(":id",$impress_id)
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
            $impress_id = Yii::$app->request->post()['data']['impress_id'];
            $impress_sort = Yii::$app->request->post()['data']['impress_sort'];
            $sort_start_time = Yii::$app->request->post()['data']['sort_start_time'];
            $sort_end_time = Yii::$app->request->post()['data']['sort_end_time'];
            $user = Yii::$app->user->identity['username'];
            $current_date = date("Y-m-d");
            $remarks = date("Y-m-d H:i:s")."&nbsp;商品管理员：".$user."&nbsp;将ID为".$impress_id."的印象的排序改为：".$impress_sort."&nbsp;有效期为：".$sort_start_time."&nbsp;至&nbsp;".$sort_end_time;

            $trans = Yii::$app->db->beginTransaction();
            try{
                //snowno add at 2017/07/11 如果排序有效时间是今天 直接设置sort
                if($current_date == $sort_start_time) {
                    $bool = Yii::$app->db->createCommand("UPDATE  `travel_impress` SET  sort = {$impress_sort},sort_start_date='" . $sort_start_time . "',sort_end_date='" . $sort_end_time . "'  WHERE id ={$impress_id}")->execute();
                }elseif($sort_start_time > $current_date){//加入排序准备字段
                    $bool = Yii::$app->db->createCommand("UPDATE  `travel_impress` SET  sort_prepare = {$impress_sort},sort_start_date='" . $sort_start_time . "',sort_end_date='" . $sort_end_time . "'  WHERE id ={$impress_id}")->execute();
                }
                //添加操作日志信息
                $res = TravelOperationLogService::insertLog(5,$impress_id,9,"",$remarks);
                $trans->commit();
                if ($bool && $res['code']==1000) {
                    echo 1;
                } else{
                    echo -2;
                }
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
            $impress_id = Yii::$app->request->post()['data']['impress_id'];
            $status = Yii::$app->request->post()['data']['status'];
            $remark = date("Y-m-d H:i:s")."&nbsp;商品管理员：".$user."&nbsp;将ID为".$impress_id."的印象改为【".Yii::$app->params['travel_status'][$status]."】状态";
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
                $bool = Yii::$app->db->createCommand("UPDATE `travel_impress` SET  status = :status,update_time = :update_time,remarks=:remarks,reason=:reason WHERE id =:id")
                    ->bindValue(":status",$status)
                    ->bindValue(":update_time",date("Y-m-d H:i:s",time()))
                    ->bindValue(":remarks",$remarks)
                    ->bindValue(":reason",$reason)
                    ->bindValue(":id",$impress_id)
                    ->execute();
                //添加操作日志信息
                $res = TravelOperationLogService::insertLog(5,$impress_id,$status,$reason,$remarks);
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
