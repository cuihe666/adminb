<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PlaneTicketOrderEmplaneQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '保险收益';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .search-model{
        float: left;
        padding-left: 10px;
    }
</style>
<div class="search-box clearfix" style="padding-bottom: 10px;">
    <div class="search-item">
        <?= Html::beginForm(['insurance-detail/index'], 'get', ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal']) ?>
        <div class="search-item" style="float: left;">
            <div class="input-group" style="width:165px;">
                <?= Html::activeDropDownList($searchModel, 'supplier_name', $insurance_list, ['class' => 'form-control', 'prompt' => '供应商名称']) ?>
            </div>
        </div>
        <div class="search-item search-model">
            <div class="input-group" style="width:165px;">
                <?php
                echo \kartik\daterange\DateRangePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'order_date',
                    'convertFormat' => true,
                    'language' => 'zh-CN',
                    'options' => [
                        'placeholder' => '请选择订单时间',
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
            <div class="input-group" style="width:165px;">
                <?= Html::activeDropDownList($searchModel, 'refund_insurance_status', ['' => '全部', 2 => '已退保', 1 => '已承保'], ['class' => 'form-control', 'prompt' => '保单状态']) ?>
            </div>
        </div>
        <div class="search-item search-model">
            <div class="input-group">
                <?= Html::submitButton('搜索', ['class' => 'btn btn-sm btn-primary']) ?>&nbsp;
            </div>
        </div>
        <?= Html::endForm() ?>
    </div>
</div>
<div class="plane-ticket-order-emplane-index" style="overflow:auto;">
    <?php
    $gridColumns = [
        [
            'class' => 'yii\grid\SerialColumn',
            'header' => '序号',
        ],
        [
            'label' => '供应商',
            'value' => function ($model) {
                return $model->supplier->name;
            }
        ],
        [
            'label' => '保险类型',
            'value' => function ($model) {
                return Yii::$app->params['plane_emplane_insurance_type'][$model->insurance_type];
            }
        ],
        [
            'label' => '订单号',
            'value' => function ($model) {
                return $model->order->order_no;
            }
        ],
        [
            'label' => '保单号',
            'value' => function ($model) {
                return $model->insurance_no;
            }
        ],
        [
            'label' => '保费',
            'value' => function ($model) {
                return $model->insurance_money;
            }
        ],
        [
            'label' => '被保人姓名',
            'value' => function ($model) {
                return $model->name;
            }
        ],
        [
            'label' => '被保人证件类型',
            'value' => function ($model) {
                return Yii::$app->params['plane_card_type'][$model->card_type];
            }
        ],
        [
            'label' => '被保人证件号码',
            'value' => function ($model) {
                return $model->card_no;
            }
        ],
        [
            'label' => '保单状态',
            'value' => function ($model) {
                return ($model->refund_insurance_status == 2 ?'已退保':'已承保');//2.申请退保成功
            }
        ],
        [
            'label' => '交易流水号',
            'value' => function ($model) {
                return '待开发';
            }
        ],
        [
            'label' => '航班号',
            'value' => function ($model) {
                return $model->order->flight_number;
            }
        ],
        [
            'label' => '起飞日期',
            'value' => function ($model) {
                return $model->order->fly_start_time;
            }
        ]
    ];
    ?>
    <?php
    echo \kartik\export\ExportMenu::widget([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumns
    ]);
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumns,
    ]); ?>
</div>
