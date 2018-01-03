<?php

namespace backend\controllers;

use backend\models\TravelTag;
use backend\service\AsyncRequestService;
use backend\service\TravelOperationLogService;
use backend\service\UserIdentityService;
use Yii;
use backend\models\TravelActivity;
use backend\models\TravelActivityQuery;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


/**
 * TravelActivityController implements the CRUD actions for TravelActivity model.
 */
class TravelActivityController extends Controller
{
    /**
     * Lists all TravelActivity models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TravelActivityQuery();
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
    public function actionView($id)
    {
        //首先判断有没有id传值
        $id = intval(trim(Yii::$app->request->get("id")));
        if($id==0){
            return $this->redirect(['error/index','code'=>1010,'msg'=>Yii::$app->params['travel_code']['1010']]);
        }
        $this->layout = 'view';
        //获取相应的操作记录
        $logs = TravelOperationLogService::getLogList($id,3);
        $imgs = Yii::$app->db->createCommand("select * from travel_activity_imgs WHERE activity_id = {$id}")->queryAll();
        //2017年7月8日14:25:29 付燕飞增加 用户修改之前的活动信息，用作对比
        $compari = Yii::$app->db->createCommand("SELECT * FROM travel_activity_compari WHERE activity_id = :activity_id order by id desc limit 2")
            ->bindValue(":activity_id",$id)
            ->queryAll();
        //2017年7月8日14:26:57 付燕飞增加 用户修改之前的活动描述信息，用作对比
        $compariImgs = Yii::$app->db->createCommand("SELECT * FROM travel_activity_imgs_compari WHERE activity_id = :activity_id AND activity_compari_id = :activity_compari_id")
            ->bindValue(":activity_id",$id)
            ->bindValue(":activity_compari_id",$compari[1]['id'])
            ->queryAll();
        return $this->render('view', [
            'id' => $id,
            'model' => $this->findModel($id),
            'imgs' => $imgs,
            'logs' => $logs,
            'compari' => $compari[1],
            'oldConArr' => $compariImgs,
        ]);
    }

    /**
     * Creates a new TravelActivity model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TravelActivity();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TravelActivity model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing TravelActivity model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the TravelActivity model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TravelActivity the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TravelActivity::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public static function getvents($id)
    {
        $data = Yii::$app->db->createCommand("select * from travel_activity_date_price WHERE activity_id = {$id}")->queryAll();
        return $data;
    }

    public function actionCheck()
    {
        $user = Yii::$app->user->identity['username'];
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post()['data'];
            $status = $data['status'];
            $des = str_replace("\n","<br>",$data['des']);
            $id = $data['id'];
            //@2017-7-18 14:46:08 fuyanfei to update. 只有审核未通过时才有原因，其他状态没有操作原因，只有备注。
            if($status==3)
                $reason = str_replace("\n","<br>",$data['reason']);
            else
                $reason = "";
            //@2017-7-20 18:44:01 fuyafnei to add transaction
            $trans = Yii::$app->db->beginTransaction();
            try{
                $uid = Yii::$app->db->createCommand("select uid from `travel_activity` WHERE id ={$id} ")->queryScalar();
                //如果当地活动审核通过
                if ($status == 1) {
                    //将当地活动所属的会员设置为达人
                    Yii::$app->db->createCommand("UPDATE  `user_common` SET is_daren = 1  WHERE  uid ={$uid}  ")->execute();
                    //将当地活动的城市设置为显示
                    $citycode = Yii::$app->db->createCommand("select city_code from `travel_activity` WHERE id = {$id}")->queryScalar();
                    if ($citycode) {
                        Yii::$app->db->createCommand("update `dt_city_seas` set display = 1 WHERE code = {$citycode}")->execute();
                    }
                    //获取发布当前活动的用户身份信息
                    $identity = UserIdentityService::getUserIdentityInfo($uid);
                    //判断用户身份信息的状态是否为已通过的状态，如果用户身份信息审核通过，并且活动审核通过时才会调取java接口推送消息
                    if($identity['status']==1){
                        //审核通过时-调取java接口， 推送消息
                        //$url = Yii::$app->params['http_url']['url']."/api/activity/releaseActivity";
                        $url = Yii::$app->params['http_url'][Yii::$app->request->hostInfo]."/api/activity/releaseActivity";
                        $res = AsyncRequestService::send_request($url,['tid'=>$id]);
                    }

                }
                //添加操作日志
                $log = TravelOperationLogService::insertLog(3,$id,$status,$reason,$des);
                //修改当地活动信息
                $res = Yii::$app->db->createCommand("UPDATE `travel_activity` SET status = :status, remarks = :remarks, reason = :reason WHERE id =:id")
                    ->bindValue(":status",$status)
                    ->bindValue(":remarks",$des)
                    ->bindValue(":reason",$reason)
                    ->bindValue(":id",$id)
                    ->execute();
                $trans->commit();
                echo 1;
            }
            catch(\Exception $e){
                $trans->rollBack();
                echo -1;
            }
        }

    }


    public function actionDrop()
    {
        if (Yii::$app->request->isAjax) {//是否ajax请求
            $id = Yii::$app->request->post()['data']['id'];
            $bool = Yii::$app->db->createCommand("UPDATE  `travel_activity` SET  status  =2  WHERE id ={$id}")->execute();
            if ($bool) {
                echo 1;
            }
        }

    }

    public function actionOnline()
    {
        if (Yii::$app->request->isAjax) {//是否ajax请求
            $id = Yii::$app->request->post()['data']['id'];
            $bool = Yii::$app->db->createCommand("UPDATE  `travel_activity` SET  status  =1  WHERE id ={$id}")->execute();
            if ($bool) {
                echo 1;
            }
        }

    }


    public static function getcountry()
    {
        return Yii::$app->db->createCommand("select name,code from dt_city_seas where level = 0")->queryAll();

    }

    public function actionGetprovince($id = 0)
    {
        if ($id == '') {
            return '<option value="0">请选择省份</option>';
        }

        $prolist = Yii::$app->db->createCommand("select name,code from dt_city_seas where parent={$id}")->queryAll();
        ?>
        <option value="0">请选择省份</option>
        <?php

        foreach ($prolist as $v) {
            ?>
            <option value="<?= $v['code'] ?>"><?= $v['name'] ?></option>
            <?php

        }

    }


    public function actionGetcity($id = 0)
    {
        if ($id == '') {
            return '<option value="0">请选择城市</option>';
        }

        $prolist = Yii::$app->db->createCommand("select name,code from dt_city_seas where parent={$id}")->queryAll();
        ?>

        <?php

        foreach ($prolist as $v) {
            ?>
            <option value="<?= $v['code'] ?>"><?= $v['name'] ?></option>
            <?php

        }

    }
}
