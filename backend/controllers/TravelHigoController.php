<?php

namespace backend\controllers;

use backend\models\TravelTag;
use backend\service\AsyncRequestService;
use backend\service\TravelOperationLogService;
use backend\service\UserIdentityService;
use Yii;
use backend\models\TravelHigo;
use backend\models\TravelHigoQuery;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TravelHigoController implements the CRUD actions for TravelHigo model.
 */
class TravelHigoController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }


    /**
     * Lists all TravelHigo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TravelHigoQuery();
        $tags = TravelTag::find()->select(['id','title'])->where(['status' => 1,'type' => 3])->all();
        $tag = [];
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if(!empty($tags)){
            foreach($tags as $k=>$v){
                $tag[$v['id']] = $v['title'];
            }
        }
//        var_dump($tag);exit;
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
        $this->layout = 'view';
        //获取操作日志
        $logs = TravelOperationLogService::getLogList($id,4);
        $imgs = Yii::$app->db->createCommand("select * from travel_higo_content WHERE higo_id = {$id} and is_del = 0")->queryAll();
        //2017年7月7日18:47:47 付燕飞增加 用户修改之前的线路信息，用作对比
        $compari = Yii::$app->db->createCommand("SELECT * FROM travel_higo_compari WHERE higo_id = :higo_id order by id desc limit 2")
            ->bindValue(":higo_id",$id)
            ->queryAll();
        //2017年7月7日18:47:47 付燕飞增加 用户修改之前的线路行程信息，用作对比
        $compariCon = Yii::$app->db->createCommand("SELECT * FROM travel_higo_content_compari WHERE higo_id = :higo_id AND higo_compari_id = :higo_compari_id")
            ->bindValue(":higo_id",$id)
            ->bindValue(":higo_compari_id",$compari[1]['id'])
            ->queryAll();
        return $this->render('view', [
            'id' => $id,
            'model' => $this->findModel($id),
            'imgs' => $imgs,
            'logs' => $logs,
            'compari' => $compari[1],
            'oldConArr' => $compariCon,
        ]);
    }

    /**
     * Creates a new TravelHigo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TravelHigo();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TravelHigo model.
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
     * Deletes an existing TravelHigo model.
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
     * Finds the TravelHigo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TravelHigo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TravelHigo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public static function getvents($id)
    {

        $data = Yii::$app->db->createCommand("select * from travel_higo_date_price WHERE higo_id = {$id}")->queryAll();


        return $data;
    }


    public function actionCheck()
    {
        if (Yii::$app->request->isAjax) {
            $user = Yii::$app->user->identity['username'];
            $data = Yii::$app->request->post()['data'];
            $status = $data['status'];
            $des = str_replace("\n","<br>",$data['des']);
            $id = $data['id'];
            //@2017-7-18 14:46:08 fuyanfei to update. 只有审核未通过时才有原因，其他状态没有操作原因，只有备注。
            if($status==3)
                $reason = str_replace("\n","<br>",$data['reason']);
            else
                $reason = "";
            //@2017-7-20 18:29:01 fuyanfei to add transaction
            $trans = Yii::$app->db->beginTransaction();
            try{
                $uid = Yii::$app->db->createCommand("select uid from `travel_higo` WHERE id ={$id} ")->queryScalar();
                //当线路审核通过时
                if ($status == 1) {
                    //将线路所属的会员设置为达人
                    Yii::$app->db->createCommand("UPDATE  `user_common` SET is_daren = 1  WHERE  uid ={$uid}  ")->execute();
                    //将线路的开始城市和结束城市设置为显示
                    $citycodes = Yii::$app->db->createCommand("select start_city,end_city from `travel_higo` WHERE id = {$id}")->queryOne();
                    if ($citycodes) {
                        foreach ($citycodes as $k => $v) {
                            if ($v) {
                                Yii::$app->db->createCommand("update `dt_city_seas` set display = 1 WHERE code = {$v}")->execute();
                            }
                        }
                    }
                    //获取发布当前线路的用户身份信息
                    $identity = UserIdentityService::getUserIdentityInfo($uid);
                    //判断用户身份信息的状态是否为已通过的状态，如果用户身份信息审核通过，并且线路审核通过时才会调取java接口推送消息
                    if($identity['status']==1){
                        //审核通过时-调取java接口， 推送消息
//                        $url = Yii::$app->params['http_url']['url']."/api/higo/releaseHigo";
                        $url = Yii::$app->params['http_url'][Yii::$app->request->hostInfo]."/api/higo/releaseHigo";
                        $res = AsyncRequestService::send_request($url,['tid'=>$id]);
                    }
                }
                //修改线路信息
                $res = Yii::$app->db->createCommand("UPDATE  `travel_higo` SET status = :status, remarks = :remarks, reason = :reason WHERE id = :id  ")
                    ->bindValue(":status",$status)
                    ->bindValue(":remarks",$des)
                    ->bindValue(":reason",$reason)
                    ->bindValue(":id",$id)
                    ->execute();
                //记录操作日志
                $log = TravelOperationLogService::insertLog(4,$id,$status,$reason,$des);
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
            $bool = Yii::$app->db->createCommand("UPDATE  `travel_higo` SET  status  =2  WHERE id ={$id}")->execute();
            if ($bool) {
                echo 1;
            }
        }

    }

    public function actionOnline()
    {
        if (Yii::$app->request->isAjax) {//是否ajax请求
            $id = Yii::$app->request->post()['data']['id'];
            $bool = Yii::$app->db->createCommand("UPDATE  `travel_higo` SET  status  =1  WHERE id ={$id}")->execute();
            if ($bool) {
                echo 1;
            }
        }

    }
}
