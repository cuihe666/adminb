<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PlaneTicketOrderQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '收款报表';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="plane-ticket-order-index" style="overflow-x: scroll;">
    <div class="search-box clearfix" style="padding-bottom: 10px;">
        <div class="search-item">
            <?= Html::beginForm(['plane-ticket-account/receivables'], 'get', ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal']) ?>
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
                        'attribute' => 'payment_time',
                        'convertFormat' => true,
                        'language' => 'zh-CN',
                        'options' => [
                            'placeholder' => '请选择支付时间',
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
                <div class="input-group" style="padding-left: 10px;">
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
        'pay_amount',//订单支付金额
        [
            'label' => '机票金额',
            'value' => function ($model) {
                $ticket_sum = 0;
                if (!empty($model->emplane)) {
                    foreach ($model->emplane as $value) {
                        $ticket_sum += ($value['mb_airport'] + $value['mb_fuel'] + $value['pre_price']);
                    }
                }
                return $ticket_sum;
            }
        ],
        [
            'label' => '机票结算价',
            'value' => function ($model) {
                $ticket_profit_sum = \backend\controllers\PlaneTicketAccountController::PlaneTicketProift($model);
                return ($model->planeOrderPay['pay_amount'] - $ticket_profit_sum);//（票面+机建费+燃油费）- 机票利润
            }
        ],
        [
            'label' => '机票利润',
            'value' => function ($model) {
                return \backend\controllers\PlaneTicketAccountController::PlaneTicketProift($model);
            }
        ],
        [
            'label' => '保险金额',
            'value' => function ($model) {
                $insurance_sum = 0;
                if (!empty($model->emplane)) {
                    foreach ($model->emplane as $values) {
                        if (!empty($values['insurance_money'])) {
                            $insurance_sum += $values['insurance_money'];
                        }
                    }
                }
                return $insurance_sum;
            }
        ],
        [
        'label' => '保险结算价',
        'value' => function ($model) {
            return isset($model->insurance['pay_amount']) ? $model->insurance['pay_amount'] : '';
        }
        ],
        [
            'label' => '保险利润',
            'value' => function ($model) {
                $sum = 0;
                if (!empty($model->emplane)) {
                    foreach ($model->emplane as $val) {
                        if (!empty($val['insurance_commision'])) {
                            $sum += $val['insurance_commision'];
                        }
                    }
                }
                return $sum;
            }
        ],
        'express_money',//快递金额
        'payment_time',//用户支付时间
        [
            'label' => '订单状态',
            'value' => function($model){
                return Yii::$app->params['plane_ticket_backend_show_status'][$model->process_status];
            }
        ],
        [
            'label' => '用户支付方式',
            'value' => function ($model) {
                return Yii::$app->params['pay_type'][$model->pay_platform];//1.支付宝 2.微信
            }
        ],
        [
            'label' => '机票供应收款方式',
            'value' => function ($model) {
                return '支付宝';//tango向第三方支付方式都是支付宝
            }
        ],
        [
            'label' => '保险供应收款方式',
            'value' => function ($model) {
                return '支付宝';//tango向第三方支付方式都是支付宝
            }
        ],
        [
            'label' => '用户支付交易号',
            'value' => function ($model) {
                return \backend\controllers\PlaneTicketAccountController::UserToTangoPayTradeNo($model->pay_platform, $model->id);
            }
        ],
        [
            'label' => '支付机票交易号',
            'value' => function ($model) {
                return '待开发...';
            }
        ],
        [
            'label' => '支付保险交易号',
            'value' => function ($model) {
                return '待开发...';
            }
        ],

    ];
    ?>
    <?php
    echo \kartik\export\ExportMenu::widget([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumns,
        'filename' => '收款报表_'.date('Y-m-d'),
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

