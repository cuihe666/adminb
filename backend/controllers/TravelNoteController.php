<?php

namespace backend\controllers;

use backend\service\AsyncRequestService;
use backend\service\TravelOperationLogService;
use backend\service\UserIdentityService;
use Yii;
use backend\models\TravelNote;
use backend\models\TravelNoteQuery;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TravelNoteController implements the CRUD actions for TravelNote model.
 */
class TravelNoteController extends Controller
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
     * Lists all TravelNote models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TravelNoteQuery();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TravelNote model.
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
        //获取相应的操作日志
        $logs = TravelOperationLogService::getLogList($id,6);
        $this->layout = 'view';
        return $this->render('view', [
            'id' => $id,
            'model' => $this->findModel($id),
            'logs' => $logs
        ]);
    }

    /**
     * Creates a new TravelNote model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TravelNote();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TravelNote model.
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
     * Deletes an existing TravelNote model.
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
     * Finds the TravelNote model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TravelNote the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TravelNote::findOne($id)) !== null) {
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
            //@2017-7-21 10:52:36 fuyanfei to add transaction
            $trans = Yii::$app->db->beginTransaction();
            try{
                $uid = Yii::$app->db->createCommand("select uid from `travel_note` WHERE id ={$id} ")->queryScalar();
                //当游记审核通过时
                if ($status == 1) {
                    //将游记所属的会员设置为达人会员
                    Yii::$app->db->createCommand("UPDATE  `user_common` SET is_daren = 1  WHERE  uid ={$uid}  ")->execute();
                    //将游记所涉及到的城市设置为显示状态
                    $citycodes = Yii::$app->db->createCommand("select city1,city2,city3 from `travel_note` WHERE id = {$id}")->queryOne();
                    if ($citycodes) {
                        foreach ($citycodes as $k => $v) {
                            if ($v) {
                                Yii::$app->db->createCommand("update `dt_city_seas` set display = 1 WHERE code = {$v}")->execute();
                            }
                        }
                    }
                    //获取发布当前游记的用户身份信息
                    $identity = UserIdentityService::getUserIdentityInfo($uid);
                    //判断用户身份信息的状态是否为已通过的状态，如果用户身份信息审核通过，并且游记审核通过时才会调取java接口推送消息
                    if($identity['status']==1){
                        //审核通过时-调取java接口， 推送消息
                        //$url = Yii::$app->params['http_url']['url']."/api/travelnote/releaseNote";
                        $url = Yii::$app->params['http_url'][Yii::$app->request->hostInfo]."/api/travelnote/releaseNote";
                        $res = AsyncRequestService::send_request($url,['tid'=>$id]);
                    }
                }
                //修改游记的审核信息
                Yii::$app->db->createCommand("UPDATE  `travel_note` SET status = {$status}, remarks = '{$des}',reason = '{$reason}'  WHERE  id ={$id}  ")->execute();
                //记录操作日志
                TravelOperationLogService::insertLog(6,$id,$status,$reason,$des);
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
            $bool = Yii::$app->db->createCommand("UPDATE  `travel_note` SET  status  =2  WHERE id ={$id}")->execute();
            if ($bool) {
                echo 1;
            }
        }

    }

    public function actionOnline()
    {
        if (Yii::$app->request->isAjax) {//是否ajax请求
            $id = Yii::$app->request->post()['data']['id'];
            $bool = Yii::$app->db->createCommand("UPDATE  `travel_note` SET  status  =1  WHERE id ={$id}")->execute();
            if ($bool) {
                echo 1;
            }
        }

    }
}
