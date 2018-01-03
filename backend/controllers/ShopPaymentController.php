<?php

namespace backend\controllers;

use backend\models\ShopOrder;
use backend\models\ShopPayment;
use backend\models\ShopPaymentQuery;
use backend\models\ShopPurchase;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ShopPaymentController implements the CRUD actions for ShopPayment model.
 */
class ShopPaymentController extends Controller
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
     * Lists all ShopPayment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ShopPaymentQuery();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ShopPayment model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {

        $url = Yii::$app->request->referrer;
        $payData = ShopPayment::find()->where('id=:id', [':id' => $id])->asArray()->one();

        $order_id = $payData['order_id'];
        //是否有退款
        $refundOk = true;
        if (Yii::$app->db->createCommand("select * from `shop_refund` WHERE order_id = {$order_id} AND    status  NOT  IN  (20,25) ")->queryAll()) {
            $refundOk = false;

        }

        if ($payData['refund_id']) {
            $refundData = Yii::$app->db->createCommand("select refund_num,status from `shop_refund` WHERE id = {$payData['refund_id']}")->queryOne();
            $refundStatus = $refundData['status'];
        }

//       采购id
        $purchase_id = $payData['purchase_id'];

//        类型为支付供应商
        if ($payData['type'] == 1 or $payData['type'] == 3 && $purchase_id) {

            //获得采购单号
            $purchaseNum = Yii::$app->db->createCommand("SELECT `purchase_num` FROM shop_purchase WHERE  id = {$purchase_id}")->queryScalar();

            //查找商品详情
            if ($payData['type'] == 3) {
                $orderDetail = Yii::$app->db->createCommand("select *,spg.price as price,spg.cost_price,spg.point  from `shop_purchase_goods` as spg  JOIN  `shop_goods` as sg on sg.id = spg.goods_id WHERE  spg.purchase_id = {$purchase_id}  AND spg.point > 0")->queryAll();


            } else {
                $orderDetail = Yii::$app->db->createCommand("select *,spg.price as price,spg.cost_price,spg.point  from `shop_purchase_goods` as spg  JOIN  `shop_goods` as sg on sg.id = spg.goods_id WHERE  spg.purchase_id = {$purchase_id} ")->queryAll();

            }


        }

        //类型为用户退款（钱）
        if ($payData['type'] == 2 && $payData['refund_id']) {
            $orderDetail = Yii::$app->db->createCommand("select *,srg.price as price,srg.cost_price,srg.point from `shop_refund_goods` as srg  JOIN  `shop_goods` as sg on sg.id = srg.goods_id WHERE  refund_id = {$payData['refund_id']}  AND srg.price > 0")->queryAll();

        }

        //类型为用户退款(积分)
        if ($payData['type'] == 4 && $payData['refund_id']) {
            $orderDetail = Yii::$app->db->createCommand("select *,srg.price as price,srg.cost_price,srg.point from `shop_refund_goods` as srg  JOIN  `shop_goods` as sg on sg.id = srg.goods_id WHERE  refund_id = {$payData['refund_id']} AND  srg.point > 0")->queryAll();

        }


        $orderData = Yii::$app->db->createCommand("SELECT admin_id,order_uid,freight,status  FROM `shop_order` WHERE id =:oid ")->bindParam(":oid", $order_id)->queryOne();
        $adminData = [];
        if ($payData['type'] == 1) {

            $adminData = Yii::$app->db->createCommand("SELECT * FROM `shop_supplier` WHERE admin_id =:aid ")->bindParam(":aid", $orderData['admin_id'])->queryOne();
        }

        $account = Yii::$app->db->createCommand("SELECT mobile FROM `user` WHERE id=:uid")->bindParam(":uid", $orderData['order_uid'])->queryScalar();


        return $this->render('view',
            compact('payData', 'orderDetail', 'adminData', 'account', 'purchaseNum', 'url', 'orderData', 'refundData', 'refundStatus', 'refundOk')
        );
    }

    /**
     * Creates a new ShopPayment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ShopPayment();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ShopPayment model.
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
     * Deletes an existing ShopPayment model.
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
     * Finds the ShopPayment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ShopPayment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ShopPayment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCheck()
    {
        if (Yii::$app->request->isAjax) {
            $admin = Yii::$app->user->identity->username;
            $id = Yii::$app->request->post('data')['id'];
            $order_id = ShopPayment::find()->where('id=:id', [':id' => $id])->select('order_id')->scalar();
            if (ShopOrder::find()->where('id=:oid', [':oid' => $order_id])->select('status')->scalar() != 20) {
                echo -1;
                die;
            }
            ShopPurchase::updateAll(['status' => 3], ['order_id' => $order_id, 'status' => 2]);
            if (ShopPayment::updateAll(['status' => 2, 'pay_uname' => $admin], "id=:id", [':id' => $id])) {
                echo 1;
                die;
            }

        }


    }
}
