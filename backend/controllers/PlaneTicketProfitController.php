<?php

namespace backend\controllers;

use backend\models\PlaneTicketOrder;
use backend\models\PlaneTicketOrderEmplane;
use backend\models\PlaneTicketOrderEmplaneQuery;
use backend\models\PlaneTicketOrderQuery;
use backend\models\SearchSql;
use Qiniu\Auth;
use Yii;
use backend\models\PlaneTicketSupplier;
use backend\models\PlaneTicketSupplierQuery;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PlaneSupplierController implements the CRUD actions for PlaneTicketSupplier model.
 */
class PlaneTicketProfitController extends Controller
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
     * @机票供应商管理列表
     *
     */
    public function actionIndex()
    {
        $searchModel = new PlaneTicketSupplierQuery();
        $searchModel['profit'] = 'profit';
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//        dd($dataProvider->getModels());

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * @佣金明细详情页
     */
    public function actionDetail()
    {
        $supplier_id = Yii::$app->request->get('sid', '');
        if (empty($supplier_id)) {
            return $this->redirect(['plane-ticket-profit/index']);
        }
        $searchModel = new PlaneTicketOrderEmplaneQuery();
        $searchModel['ticket_supplier_id'] = $supplier_id;
        $searchModel['profit_detail'] = 'profit_detail';
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//        dd($dataProvider->getModels());

        return $this->render('detail', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PlaneTicketSupplier model.
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
     * Deletes an existing PlaneTicketSupplier model.
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
     * Finds the PlaneTicketSupplier model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PlaneTicketSupplier the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PlaneTicketSupplier::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    /**
     * @总票量
     */
    public static function AllRefundNum($data)
    {
        $total_num = 0;
        if (empty($data)) {
            return $total_num;
        }
        foreach ($data as $k => $v) {
            $total_num += $v['guest_num'];
        }
        return $total_num;
    }
    /**
     * @退票量
     */
    public static function RefundNum($data)
    {
        $total = 0;
        if (empty($data)) {
            return $total;
        }
        foreach ($data as $value) {
            $num = PlaneTicketOrderEmplane::find()
                ->where(['order_id' => $value['id']])//订单ID
                ->andWhere(['refund_ticket_status' => 2])//退票
                ->select([
                    'id'
                ])
                ->count();
            $total += $num;
        }
        return $total;
    }
    /**
     * @未退票量
     */
    public static function NoRefundNum($data)
    {
        $total = 0;
        if (empty($data)) {
            return $total;
        }
        foreach ($data as $value) {
            $num = PlaneTicketOrderEmplane::find()
                ->where(['order_id' => $value['id']])//订单ID
                ->andWhere(['<>', 'refund_ticket_status', 2])//未退票
                ->select([
                    'id'
                ])
                ->count();
            $total += $num;
        }
        return $total;
    }
    /**
     * @算取总佣金数
     */
    public static function TotalProfit($data)
    {
//        dd($data);
        $total = 0;
        if (empty($data)) {
            return $total;
        }
        foreach ($data as $value) {
            $sum = PlaneTicketOrderEmplane::find()
                ->where(['order_id' => $value['id']])//订单ID
                ->andWhere(['<>', 'refund_ticket_amount_status', 2])//不包含机票退款成功的
                ->sum('ticket_commision');
            $total += $sum;
        }
        return $total;
    }
    /**
     * @获取机票供应商名称
     */
    public static function ToSupplierName($id)
    {
        $supplier_name = PlaneTicketSupplier::find()
            ->where(['id' => $id])
            ->select(['name'])
            ->scalar();
        return $supplier_name;
    }

}
