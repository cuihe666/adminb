<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PlaneTicketOrderQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '退款报表';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="plane-ticket-order-index" style="overflow-x: scroll;">
    <div class="search-box clearfix" style="padding-bottom: 10px;">
        <div class="search-item">
            <?= Html::beginForm(['plane-ticket-account/refund'], 'get', ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal']) ?>
            <div class="search-item search-model" style="float: left;">
                <div class="input-group">
                    <?= Html::activeInput('text', $searchModel, 'order_no', ['class' => 'form-control input', 'placeholder' => '请输入订单号']) ?>
                </div>
            </div>
            <div class="search-item search-model" style="float: left; padding-left: 10px;">
                <div class="input-group">
                    <?php
                    echo \kartik\daterange\DateRangePicker::widget([
                        'model' => $searchModel,
                        'attribute' => 'refund_time_search',
                        'convertFormat' => true,
                        'language' => 'zh-CN',
                        'options' => [
                            'placeholder' => '请选择退款时间',
                            'class' => 'form-control',
                            'readonly' => true,
                        ],
                        'pluginOptions' => [
                            'timePicker' => false,
                            'timePickerIncrement' => 30,
                            'locale' => [
                                'format' => 'Y-m-d'
                            ]
                        ]
                    ]);
                    ?>
                </div>
            </div>
            <div class="search-item search-model">
                <div class="input-group" style=" padding-left: 10px;">
                    <?= Html::submitButton('搜索', ['class' => 'btn btn-sm btn-primary']) ?>
                </div>
            </div>
            <?= Html::endForm() ?>
        </div>
    </div>
    <?php
    $gridColumns = [
        ['class' => 'yii\grid\SerialColumn', 'header' => '序号'],
        'order_no',//订单号
        [
            'label' => '供应订单号',
            'value' => function ($model) {
                return $model->planeOrderPay['trade_no']. ' ';
            }
        ],
        [
            'label' => '保险订单号',
            'value' => function ($model) {
                return isset($model->insuranceOrder['out_trade_no']) ? $model->insuranceOrder['out_trade_no'] : '';
            }
        ],
        [
            'label' => '退票手续费',
            'value' => function($model){
                return '待开发...';
            }
        ],
        [
            'label' => '退票款金额',
            'value' => function($model){
                $ticket_refund_sum = 0;
                if (!empty($model->planeTicketRefundNot)) {
                    foreach ($model->planeTicketRefundNot as $val) {
                        if (!empty($val['refundment_money'])) {
                            $ticket_refund_sum += $val['refundment_money'];
                        }
                    }
                }
                return $ticket_refund_sum;
            }
        ],
        [
            'label' => '机票实退款',
            'value' => function($model){
                return \backend\controllers\PlaneTicketAccountController::PlaneTicketRefundFee($model->id, $model->pay_platform);
            }
        ],
        [
            'label' => '机票实退款时间（给用户）',
            'value' => function($model){
                return \backend\controllers\PlaneTicketAccountController::PlaneTicketRefundDateToUser($model->id, $model->pay_platform);
            }
        ],
        [
            'label' => '机票实退款时间（第三方退回）',
            'value' => function($model){
                if (!empty($model->planeTicketRefundNot)) {
                    return $model->planeTicketRefundNot[0]['create_time'];
                }
            }
        ],
        [
            'label' => '保险退款',
            'value' => function($model){
                $insurance_fee_num = 0;
                if (!empty($model->insuranceOrderDetails)) {
                    foreach ($model->insuranceOrderDetails as $vals) {
                        if ($vals['refund_insurance_status'] == 1) {//退保状态(0未退保，1退保成功，2退保失败)
                            $insurance_fee_num += 1;
                        }
                    }
                }
                // （保单支付总金额 / 总投保人数）* 退保成功人数 = 保险退款
                return isset($model->insurance['pay_amount']) ? ($model->insurance['pay_amount'] / $model->insurance_num * $insurance_fee_num) : 0;
            }
        ],
        [
            'label' => '保险实退款',
            'value' => function($model){
                return \backend\controllers\PlaneTicketAccountController::PlaneInsuranceRefundFee($model);
            }
        ],
        [
            'label' => '保险退款时间',
            'value' => function($model){
                return '待开发...';
            }
        ],
        [
            'label' => '快递退款金额',
            'value' => function ($model) {
                return $model->express_money;
            }
        ],
        [
            'label' => '实退总金额',
            'value' => function ($model) {
                $refund_ticket_fee = \backend\controllers\PlaneTicketAccountController::PlaneTicketRefundFee($model->id, $model->pay_platform);
                $refund_insurance_fee = \backend\controllers\PlaneTicketAccountController::PlaneInsuranceRefundFee($model);
                $post_refund_fee = $model->express_money;
                return ($refund_ticket_fee + $refund_insurance_fee + $post_refund_fee);
            }
        ],
        [
            'label' => '退票申请时间',
            'value' => function ($model) {
                $refund_ticket_Apply_date = '';
                if (!empty($model->planeRefundTicket)) {
                    foreach ($model->planeRefundTicket as $items) {
                        $refund_ticket_Apply_date = $items['create_time'];
                    }
                }
                return $refund_ticket_Apply_date;
            }
        ],
        [
            'label' => '供应退款方式',
            'value' => function ($model) {
                return '支付宝';
            }
        ],
        [
            'label' => '用户退款方式',
            'value' => function ($model) {
                return Yii::$app->params['pay_type'][$model->pay_platform];//1.支付宝 2.微信
            }
        ]

    ];
    ?>
    <?php
    echo \kartik\export\ExportMenu::widget([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumns,
        'filename' => '退款报表_'.date('Y-m-d'),
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

