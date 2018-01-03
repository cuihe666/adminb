<?php

namespace backend\controllers;

use backend\service\AsyncRequestService;
use backend\service\TravelOperationLogService;
use backend\service\UserIdentityService;
use Yii;
use backend\models\TravelImpress;
use backend\models\TravelImpressQuery;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TravelImpressController implements the CRUD actions for TravelImpress model.
 */
class TravelImpressController extends Controller
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
     * Lists all TravelImpress models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TravelImpressQuery();
        $searchModel['status'] != 4;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TravelImpress model.
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
        //获取相应的操作日志
        $logs = TravelOperationLogService::getLogList($id,5);
        return $this->render('view', [
            'id' => $id,
            'model' => $this->findModel($id),
            'logs' => $logs
        ]);
    }

    /**
     * Creates a new TravelImpress model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TravelImpress();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TravelImpress model.
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
     * Deletes an existing TravelImpress model.
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
     * Finds the TravelImpress model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TravelImpress the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TravelImpress::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
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
            //@2017-7-21 10:45:18 fuyanfei to add transaction
            $trans = Yii::$app->db->beginTransaction();
            try{
                $uid = Yii::$app->db->createCommand("select uid from `travel_impress` WHERE id ={$id} ")->queryScalar();
                //当印象审核通过时
                if ($status == 1) {
                    //将印象所属的会员设置为达人
                    Yii::$app->db->createCommand("UPDATE  `user_common` SET is_daren = 1  WHERE  uid ={$uid}  ")->execute();
                    //将印象涉及到的城市设为显示的状态
                    $citycodes = Yii::$app->db->createCommand("select city1,city2,city3 from `travel_impress` WHERE id = {$id}")->queryOne();
                    if ($citycodes) {
                        foreach ($citycodes as $k => $v) {
                            if ($v) {
                                echo Yii::$app->db->createCommand("update `dt_city_seas` set display = 1 WHERE code = {$v}")->execute();
                            }
                        }
                    }
                    //获取发布当前印象的用户身份信息
                    $identity = UserIdentityService::getUserIdentityInfo($uid);
                    //判断用户身份信息的状态是否为已通过的状态，如果用户身份信息审核通过，并且印象审核通过时才会调取java接口推送消息
                    if($identity['status']==1){
                        //审核通过时-调取java接口， 推送消息
                        //$url = Yii::$app->params['http_url']['url']."/api/travelimpress/releaseImpress";
                        $url = Yii::$app->params['http_url'][Yii::$app->request->hostInfo]."/api/travelimpress/releaseImpress";
                        $res = AsyncRequestService::send_request($url,['tid'=>$id]);
                    }

                }
                //修改印象基本信息
                Yii::$app->db->createCommand("UPDATE  `travel_impress` SET status = {$status}, remarks = '{$des}',reason = '{$reason}'  WHERE  id ={$id}  ")->execute();
                //记录操作日志
                TravelOperationLogService::insertLog(5,$id,$status,$reason,$des);
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
            $bool = Yii::$app->db->createCommand("UPDATE  `travel_impress` SET  status  =2  WHERE id ={$id}")->execute();
            if ($bool) {
                echo 1;
            }
        }

    }

    public function actionOnline()
    {
        if (Yii::$app->request->isAjax) {//是否ajax请求
            $id = Yii::$app->request->post()['data']['id'];
            $bool = Yii::$app->db->createCommand("UPDATE  `travel_impress` SET  status  =1  WHERE id ={$id}")->execute();
            if ($bool) {
                echo 1;
            }
        }

    }
}
