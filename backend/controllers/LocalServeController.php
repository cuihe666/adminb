<?php

namespace backend\controllers;

use backend\models\HouseDetails;
use backend\models\HouseServe;
use backend\models\ServeImg;
use Yii;
use backend\models\LocalServe;
use backend\models\LocalServeQuery;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LocalServeController implements the CRUD actions for LocalServe model.
 */
class LocalServeController extends Controller
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
     * Lists all LocalServe models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LocalServeQuery();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single LocalServe model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = LocalServe::find()->joinWith(['user'])->joinWith(['servicecategory'])->select("local_serve.*,local_serve.id,user.id as user_id,user.mobile,service_category.id as service_category_id ,service_category.name")->where(['local_serve.id' => $id])->one();
        $houseids = HouseServe::find()->where(['serve_id' => $id])->asArray()->all();
        $logs = Yii::$app->db->createCommand("SELECT * FROM  serve_audit_log WHERE serve_id ={$id} ")->queryAll();
        $housedata = [];
        if ($houseids) {
            foreach ($houseids as $k => $v) {
                if ($data = HouseDetails::find()->where(['id' => $v])->select(['id', 'cover_img'])->asArray()->one()) {
                    $housedata[] = $data;
                }

            }

        }
        return $this->render('view', [
            'model' => $model,
            'housedata' => $housedata,
            'logs' => $logs
        ]);
    }

    /**
     * Creates a new LocalServe model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new LocalServe();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing LocalServe model.
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
     * Deletes an existing LocalServe model.
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
     * Finds the LocalServe model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LocalServe the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LocalServe::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

//    审核
    public function actionCheck()
    {
        $user = Yii::$app->user->identity['username'];
        if (Yii::$app->request->isAjax) {

            $data = Yii::$app->request->post()['data'];
            $status = $data['status'];
            $id = $data['id'];
            $reason = $data['reason'];
            $time = date("Y-m-d H:i:s");
            Yii::$app->db->createCommand("UPDATE  `local_serve` SET status = {$status}  WHERE  id ={$id}  ")->execute();
            if ($status == 0 || $status == 4) {
                if ($status == 4) {
                    Yii::$app->db->createCommand("insert into  `serve_audit_log` set  name='{$user}',result =0,reson ='{$reason}',create_time ='{$time}',serve_id = {$id} ")->execute();

                }
                if ($status == 0) {
                    Yii::$app->db->createCommand("insert into  `serve_audit_log` set  name='{$user}',result =1,reson ='',create_time ='{$time}',serve_id = {$id} ")->execute();

                }

            }


//            Yii::$app->db->createCommand("INSERT INTO `travel_operation_log` SET uname = '{$user}',type =3 ,obj_id = {$id}, status ={$status},reason='{$reason}',remarks = '{$des}'")->execute();
//            Yii::$app->db->createCommand("UPDATE  `travel_activity` SET status = {$status}, remarks = '{$des}',reason = '{$reason}'  WHERE  id ={$id}  ")->execute();

            echo 1;
        }

    }

}
