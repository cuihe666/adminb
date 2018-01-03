<?php

namespace backend\controllers;

use Yii;
use backend\models\HotelSupplierSettlement;
use backend\models\HotelSupplierSettlementQuery;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * HotelSettlementController implements the CRUD actions for HotelSupplierSettlement model.
 */
class HotelSettlementController extends Controller
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
     * Lists all HotelSupplierSettlement models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new HotelSupplierSettlementQuery();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//        echo '<pre>';
//        print_r($dataProvider->getModels());die;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single HotelSupplierSettlement model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new HotelSupplierSettlement model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new HotelSupplierSettlement();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing HotelSupplierSettlement model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
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
     * Deletes an existing HotelSupplierSettlement model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the HotelSupplierSettlement model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return HotelSupplierSettlement the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HotelSupplierSettlement::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @param $id
     * @return false|null|string
     * user:ys
     * time:2017/7/25
     * 酒店名称
     */
    public static function HotelName($id)
    {
        $sql ="SELECT `complete_name` FROM `hotel` WHERE `id`=:id";
        return Yii::$app->db->createCommand($sql)->bindValues([':id' => $id])->queryScalar();
    }
}
