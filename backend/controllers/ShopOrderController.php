<?php

namespace backend\controllers;

use backend\models\ShopOrder;
use backend\models\ShopOrderQuery;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ShopOrderController implements the CRUD actions for ShopOrder model.
 */
class ShopOrderController extends Controller
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
     * Lists all ShopOrder models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ShopOrderQuery();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ShopOrder model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $url = Yii::$app->request->referrer;
        $orderData = ShopOrder::find()->where('id=:id', [':id' => $id])->asArray()->one();
        $orderDetail = Yii::$app->db->createCommand("SELECT sgo.title,sgo.price,sgo.num,sgo.spec_name,sgo.title_pic,sg.code,sgo.point,sg.goods_num FROM `shop_goods_order` As sgo  JOIN  `shop_goods` as sg on sgo.goods_id = sg.id    WHERE sgo.order_id=:id")->bindParam(":id", $id)->queryAll();
        $uid = $orderData['order_uid'];
        $account = Yii::$app->db->createCommand("SELECT mobile FROM `user` WHERE id=:uid")->bindParam(":uid", $uid)->queryScalar();
        $aid = $orderData['admin_id'];
        $supplierData = Yii::$app->db->createCommand("SELECT admin_username,company_name FROM `shop_supplier` WHERE admin_id=:aid")->bindParam(":aid", $aid)->queryOne();
        $supplierInfo = Yii::$app->db->createCommand("SELECT name FROM `shop_info` WHERE admin_id=:aid")->bindParam(":aid", $aid)->queryOne();
        $addressId = $orderData['address_id'];
        $addressInfo = Yii::$app->db->createCommand("SELECT province,city,area,name,address,mobile FROM `shop_address` WHERE id=:addid")->bindParam(":addid", $addressId)->queryOne();
//        获得付款单号
        $receiveNums = Yii::$app->db->createCommand("SELECT receive_num FROM `shop_receive` WHERE order_id = {$id} AND (type = 1 OR  type = 3)")->queryColumn();

        $logistics = Yii::$app->db->createCommand("SELECT name,number,created_at FROM `shop_order_logistics` WHERE order_id = {$id}")->queryOne();
        //发货时间
        $sendStar = Yii::$app->db->createCommand("SELECT created_at FROM `shop_order_log` WHERE  order_id = {$id} AND status = 10 ")->queryScalar();
        $sendEnd = Yii::$app->db->createCommand("SELECT created_at FROM `shop_order_log` WHERE  order_id = {$id} AND status = 20 ")->queryScalar();


        return $this->render('view', compact('url', 'orderData', 'orderDetail', 'account', 'supplierData', 'addressInfo', 'receiveNums', 'logistics', 'sendStar', 'sendEnd','supplierInfo'));

    }

    /**
     * Creates a new ShopOrder model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ShopOrder();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ShopOrder model.
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
     * Deletes an existing ShopOrder model.
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
     * Finds the ShopOrder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ShopOrder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ShopOrder::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
