<?php

namespace backend\controllers;

use backend\models\ShopOrder;
use backend\models\ShopReceive;
use backend\models\ShopReceiveQuery;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ShopReceiveController implements the CRUD actions for ShopReceive model.
 */
class ShopReceiveController extends Controller
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
     * Lists all ShopReceive models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ShopReceiveQuery();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ShopReceive model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $receiveData = ShopReceive::findOne($id);
        $order_id = $receiveData['order_id'];
        //查找商品详情
        $url = Yii::$app->request->referrer;
        //        订单号
        $orderData = ShopOrder::find()->where('id=:oid', [':oid' => $order_id])->select(['order_num', 'admin_id'])->asArray()->one();
        $adminUser = Yii::$app->db->createCommand("select admin_username from `shop_supplier` WHERE  admin_id ={$orderData['admin_id']}")->queryScalar();
        $adminPhone = Yii::$app->db->createCommand("select returns_phone from `shop_info` WHERE admin_id = {$orderData['admin_id']}")->queryScalar();
        $refundNum = '';
        if ($receiveData['refund_id']) {
            $refundNum = Yii::$app->db->createCommand("select refund_num from `shop_refund` WHERE id = {$receiveData['refund_id']}")->queryScalar();
            $orderDetail = Yii::$app->db->createCommand("SELECT * FROM `shop_refund_goods` as srg  JOIN `shop_goods` as sg on sg.id = srg.goods_id    WHERE order_id={$order_id} AND refund_id  = {$receiveData['refund_id']}")->queryAll();

        } else {

            if ($receiveData->type == 3 && $receiveData->pay_type == 3) {
                $orderDetail = Yii::$app->db->createCommand("SELECT * FROM `shop_goods_order` as sgo  JOIN `shop_goods` as sg on sg.id = sgo.goods_id    WHERE order_id=:id AND pay_type = 1")->bindParam(":id", $order_id)->queryAll();
            } else {
                $orderDetail = Yii::$app->db->createCommand("SELECT *,sgo.price,sgo.cost_price FROM `shop_goods_order`  as sgo  JOIN `shop_goods` as sg on sg.id = sgo.goods_id   WHERE order_id=:id AND pay_type =2 ")->bindParam(":id", $order_id)->queryAll();
            }

        }


        return $this->render('view', compact('receiveData', 'orderDetail', 'url', 'orderData', 'refundNum', 'adminUser', 'adminPhone'));
    }

    /**
     * Creates a new ShopReceive model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ShopReceive();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ShopReceive model.
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
     * Deletes an existing ShopReceive model.
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
     * Finds the ShopReceive model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ShopReceive the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ShopReceive::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCheck()
    {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('data')['id'];
            if (ShopReceive::updateAll(['status' => 2], 'id=:id', [':id' => $id])) {
                echo 1;
                die;
            }

        }

    }
}
