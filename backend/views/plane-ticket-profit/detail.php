<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PlaneTicketOrderQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '佣金明细详情页';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="plane-ticket-order-index">
    <?php
    $gridColumns = [
        ['class' => 'yii\grid\SerialColumn', 'header' => '序号'],
        [
            'label' => '供应商名称',
            'value' => function ($model) {
//                return \backend\controllers\PlaneTicketProfitController::TotalProfit($model->ticket_supplier_id);
                return $model->supplier->name;
            }
        ],
        'ticket_no',//票号
        [
            'label' => '订单编号',
            'value' => function ($model) {
                return $model->order->order_no;
            }
        ],
        [
            'label' => '出发',
            'value' => function ($model) {
                return \backend\models\PlaneTicketOrder::CityName($model->order->city_start_code);
            }
        ],
        [
            'label' => '到达',
            'value' => function ($model) {
                return (\backend\models\PlaneTicketOrder::CityName($model->order->city_end_code));
            }
        ],
        [
            'label' => '航班',
            'value' => function ($model) {
                return $model->order->flight_number;
            }
        ],
        [
            'label' => '下单时间',
            'value' => function ($model) {
                return $model->order->create_time;
            }
        ],
        [
            'label' => '支付时间',
            'value' => function ($model) {
                return $model->order->payment_time;
            }
        ],
        [
            'label' => '乘机人',
            'value' => function ($model) {
                return $model->name;
            }
        ],
        [
            'label' => '乘机人类型',
            'value' => function ($model) {
                return Yii::$app->params['emplane_ticket_type'][$model->ticket_type];
            }
        ],
        [
            'label' => '佣金状态',
            'value' => function ($model) {
                if ($model->refund_ticket_amount_status == 2) {//机票钱退款成功
                    return '已退还';
                } else {
                    return '在账';
                }
            }
        ],
        [
            'label' => '票面价',
            'value' => function ($model) {
                return $model->pre_price;
            }
        ],
        [
            'label' => '基建+燃油费',
            'value' => function ($model) {
                return ($model->mb_airport + $model->mb_fuel);
            }
        ],
        [
            'label' => '结算价',
            'value' => function ($model) {
                return ($model->ticket_settle_price);
            }
        ],
        [
            'label' => '佣金',
            'value' => function ($model) {
                return $model->ticket_commision;
            }
        ],
    ];
    ?>
    <?php
    echo \kartik\export\ExportMenu::widget([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumns,
    ]);
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumns,
        'pager' => [
            'firstPageLabel' => '首页',
            'lastPageLabel' => '尾页',
        ],
    ]); ?>
</div>
