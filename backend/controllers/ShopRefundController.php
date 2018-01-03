<?php

namespace backend\controllers;

use backend\models\ShopOrder;
use backend\models\ShopPurchase;
use backend\models\ShopRefund;
use backend\models\ShopRefundGoods;
use backend\models\ShopRefundLog;
use backend\models\ShopRefundQuery;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ShopRefundController implements the CRUD actions for ShopRefund model.
 */
class ShopRefundController extends Controller
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
     * Lists all ShopRefund models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ShopRefundQuery();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ShopRefund model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $url = Yii::$app->request->referrer;
        //退款主表
        $refundData = ShopRefund::find()->where('id=:id', [':id' => $id])->asArray()->one();
        //退款详情表
        $refundDetailData = ShopRefundGoods::find()->where('refund_id=:id', [':id' => $id])->asArray()->all();
        //退款日志表
        $refundLogs = ShopRefundLog::find()->where(['refund_id' => $id])->andWhere('type=:type', [':type' => 1])->select(['create_time', 'reason', 'detail'])->asArray()->all();

        $AdminRefundLogs = ShopRefundLog::find()->where('refund_id=:id', [':id' => $id])->andWhere('type=:type', [':type' => 2])->select(['create_time', 'reason', 'detail'])->asArray()->all();
//        订单信息
        $orderData = ShopOrder::find()->where('id=:id', [':id' => $refundData['order_id']])->select(['status', 'order_num', 'address_id', 'status', 'point_total', 'price_total', 'admin_id'])->asArray()->one();

        //发货时间
        $sendStar = Yii::$app->db->createCommand("SELECT created_at FROM `shop_order_log` WHERE  order_id = {$refundData['order_id']} AND status = 10 ")->queryScalar();
        $sendEnd = Yii::$app->db->createCommand("SELECT created_at FROM `shop_order_log` WHERE  order_id = {$refundData['order_id']} AND status = 20 ")->queryScalar();
//        采购数据
        $purchaseData = ShopPurchase::find()->where('order_id=:id', [':id' => $refundData['order_id']])->select(['purchase_num', 'total', 'status'])->asArray()->one();

        $goodsData = Yii::$app->db->createCommand("SELECT sg.id,sg.operate_category,sr.price,sr.point,sg.status,sg.created_at,sg.title,ss.admin_username,si.principal,si.principal_phone,sg.goods_num,sr.num FROM `shop_refund_goods` as sr  LEFT JOIN `shop_goods` as sg ON sr.goods_id = sg.id  LEFT JOIN  `shop_supplier` as ss on ss.admin_id = sg.admin_id LEFT JOIN `shop_info`as si  ON si.admin_id = sg.admin_id WHERE sr.refund_id =:id ")->bindParam(':id', $id)->queryAll();


        $customerUid = $refundData['uid'];
        $customerAccount = Yii::$app->db->createCommand("SELECT mobile from `user` WHERE id = :id ")->bindParam(':id', $customerUid)->queryScalar();

//        //物流信息
        $address_id = $orderData['address_id'];
        $addressData = Yii::$app->db->createCommand("SELECT * from `shop_address` WHERE id = :address_id ")->bindParam(':address_id', $address_id)->queryOne();

//       买家收款
        $receiveData = Yii::$app->db->createCommand("SELECT receive_num FROM `shop_receive` WHERE order_id = {$refundData['order_id']} AND  ( type = 1 or type = 3)")->queryAll();

//        对应的付款单号
        $customerPayNum = Yii::$app->db->createCommand("SELECT pay_num FROM `shop_payment` WHERE ( type = 2 or  type = 4 )  AND  refund_id = {$id }")->queryColumn();

//        对于商家的付款单号

        $agentPayNum = Yii::$app->db->createCommand("SELECT pay_num FROM `shop_payment` WHERE type =1 AND   order_id = {$refundData['order_id']}")->queryScalar();


        $oldAgentPaymentStatus = Yii::$app->db->createCommand("select status from `shop_payment` WHERE  type = 1 AND  status = 2   AND refund_id ={$id}  AND order_id = {$refundData['order_id']}")->queryScalar();

//        向商家收款



        $agentReceive = Yii::$app->db->createCommand("SELECT receive_num FROM `shop_receive` WHERE order_id = {$refundData['order_id']} AND refund_id = {$id} AND type = 2 ")->queryScalar();


        $supplierData = Yii::$app->db->createCommand("SELECT si.principal_phone,ss.admin_username,si.principal,si.name FROM  `shop_info` as si  JOIN `shop_supplier` as ss  ON  si.admin_id = ss.admin_id   WHERE ss.admin_id = :aid ")->bindParam(':aid', $orderData['admin_id'])->queryOne();
//        查找新生成的采购单

        $newPurchaseNum = Yii::$app->db->createCommand("select purchase_num from `shop_purchase` WHERE order_id  ={$refundData['order_id']} AND  refund_id = {$id}")->queryScalar();

        return $this->render('view', compact('refundData', 'refundDetailData', 'refundLogs', 'orderData', 'purchaseData', 'goodsData', 'customerAccount', 'addressData', 'receiveData', 'AdminRefundLogs', 'supplierData', 'url', 'customerPayNum', 'agentPayNum', 'agentReceive', 'sendStar', 'sendEnd', 'oldAgentPaymentStatus', 'newPurchaseNum'));
    }

    /**
     * Creates a new ShopRefund model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ShopRefund();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ShopRefund model.
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
     * Deletes an existing ShopRefund model.
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
     * Finds the ShopRefund model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ShopRefund the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ShopRefund::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCheck()
    {
        if (Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post('data');
            $result = $post['result'];
            $desc = $post['desc'];


        }

    }
}
