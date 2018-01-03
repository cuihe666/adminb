<?php

namespace backend\controllers;

use backend\models\TravelOrder;
use backend\models\TravelOrderContacts;
use backend\models\TravelOrderContactsQuery;
use backend\models\TravelOrderTwoQuery;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TravelOrderController implements the CRUD actions for TravelOrder model.
 */
class TravelOrderContactsController extends Controller
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
     * Lists all TravelOrder models.
     *  @订单参团人
     */
    public function actionIndex()
    {
        $searchModel = new TravelOrderContactsQuery();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all TravelOrder models.
     *  @总参团人数
     */
    public function actionTotal()
    {
        $searchModel = new TravelOrderContactsQuery();
        $searchModel['total_person'] = 'ssr';
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('total', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all TravelOrder models.
     *  @总联系人数
     */
    public function actionContact()
    {
        $searchModel = new TravelOrderTwoQuery();
        $searchModel['contact_person'] = 'contact';
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('contact', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TravelOrder model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = TravelOrderContacts::find()->WHERE(['id' => $id])->One();

        return $this->render('view', [
            'model'=> $model,
        ]);
    }

    /**
     * Creates a new TravelOrder model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TravelOrderContacts();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TravelOrder model.
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
     * Deletes an existing TravelOrder model.
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
     * Finds the TravelOrder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TravelOrder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TravelOrderContacts::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    /*******  订单号  *********/
    public static function actonOrder_no($id)
    {
        $order_info = TravelOrder::find()
            ->where(['id' => $id])
            ->select(['order_no'])
            ->asArray()
            ->one();
        return $order_info['order_no'];
    }
    /***** 联系人信息（姓名/电话） *******/
    public static function actionContact_data($order_id, $str)
    {
        $order_info = TravelOrder::find()
            ->where(['id' => $order_id])
            ->select(['contacts', 'mobile_phone', 'create_time', 'activity_date'])
            ->asArray()
            ->one();
        if ($str == 'contact_name') {//连信任姓名
            return $order_info['contacts'];
        } else if ($str == 'contact_mobile') {//联系人电话
            return $order_info['mobile_phone'];
        } else if ($str == 'create_time') {
            return $order_info['create_time'];
        } else if ($str == 'activity_date') {
            return $order_info['activity_date'];
        }
    }
    /*****  支付状态  ******/
    public static function actionPay_state($oid)
    {
        $order_info = TravelOrder::find()
            ->where(['id' => $oid])
            ->select(['trade_no'])
            ->asArray()
            ->one();
        if (empty($order_info['trade_no'])) {
            return '未支付';
        } else {
            return '已支付';
        }
    }
    /****** 订单状态 *******/
    public static function actionOrder_state($oid)
    {
        $order_info = TravelOrder::find()
            ->where(['id' => $oid])
            ->select(['state', 'refund_stauts', 'is_confirm'])
            ->asArray()
            ->one();
        if ($order_info['refund_stauts'] == 0) {//交易流程
            if (($order_info['state'] == 21) && ($order_info['is_confirm'] == 1)) {
                return '待确认';
            } else {
                return Yii::$app->params['status_order'][$order_info['state']];
            }
        } else {//退款流程
            return Yii::$app->params['stauts_refund'][$order_info['refund_stauts']];
        }
    }

}
