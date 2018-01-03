<?php

namespace backend\controllers;

use backend\models\ShopOrder;
use backend\models\ShopReceive;
use Yii;
use backend\models\ShopPurchase;
use backend\models\ShopPurchaseQuery;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ShopPurchaseController implements the CRUD actions for ShopPurchase model.
 */
class ShopPurchaseController extends Controller
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
     * Lists all ShopPurchase models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ShopPurchaseQuery();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ShopPurchase model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {

        $url = Yii::$app->request->getReferrer();
        $purchaseData = ShopPurchase::find()->where('id=:id', [':id' => $id])->one();
        $adminId = $purchaseData['admin_id'];
        //商家姓名
        $adminUserName = Yii::$app->db->createCommand("SELECT admin_username FROM `shop_supplier` WHERE admin_id = :admin_id")->bindParam(':admin_id', $adminId)->queryScalar();
        $adminInfo = Yii::$app->db->createCommand("SELECT principal_phone,name FROM `shop_info` WHERE admin_id = :admin_id")->bindParam(':admin_id', $adminId)->queryOne();
        $orderId = $purchaseData['order_id'];
//        付款单号
        $payNum =Yii::$app->db->createCommand("select pay_num  from `shop_payment` where  purchase_id = {$id} AND  type = 1")->queryScalar();


//        $payNum = Yii::$app->db->createCommand("SELECT pay_num FROM `shop_payment` WHERE order_id = {$orderId} AND TYPE  = 1")->queryScalar();
        $orderData = ShopOrder::find()->where('id=:id', [':id' => $orderId])->select(['address_id', 'order_num'])->one();
        $addressData = Yii::$app->db->createCommand("SELECT * FROM  `shop_address` WHERE id = :id")->bindParam(':id', $orderData['address_id'])->queryOne();
//        $purchaseDetails = Yii::$app->db->createCommand("SELECT sg.status,sg.cost_price,sg.code,sg.category_name,sg.price,sg.title,sg.created_at,sg.update_at,ss.admin_username,si.name,si.principal,si.principal_phone FROM `shop_purchase_goods` as sp JOIN `shop_goods` as sg ON   sg.id =sp.goods_id JOIN `shop_supplier` as ss  ON  ss.admin_id = sg.admin_id  JOIN `shop_info` as si  ON si.admin_id = sg.admin_id    WHERE purchase_id = {$id} ")->queryAll();
        $purchaseDetails = Yii::$app->db->createCommand("SELECT *,spg.price,spg.cost_price FROM `shop_purchase_goods` as spg JOIN `shop_goods` as sg ON  spg.goods_id  = sg.id WHERE order_id = {$orderId} AND purchase_id = {$id}")->queryAll();

//        物流信息

        $logistics = Yii::$app->db->createCommand("SELECT name,number,created_at FROM `shop_order_logistics` WHERE order_id = {$orderId}")->queryOne();

        $customer = ShopReceive::getUserName($orderId);
        return $this->render('view', compact('purchaseData', 'adminUserName', 'customer', 'adminInfo', 'purchaseDetails', 'addressData', 'url', 'orderData', 'payNum', 'logistics'));
    }

    /**
     * Creates a new ShopPurchase model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ShopPurchase();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ShopPurchase model.
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
     * Deletes an existing ShopPurchase model.
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
     * Finds the ShopPurchase model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ShopPurchase the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ShopPurchase::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
