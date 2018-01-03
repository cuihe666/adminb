<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PlaneTicketSupplierQuery */
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
<div class="plane-ticket-supplier-index">
    <div class="search-box clearfix" style="padding-bottom: 10px;">
        <div class="search-item">
            <?= Html::beginForm(['plane-insurance-profit/index'], 'get', ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal']) ?>
            <div class="search-item" style="float: left">
                <div class="input-group">
                    <?= Html::activeDropDownList($searchModel, 'supplier_name', isset($supplierList) ? $supplierList : [], ['class' => 'form-control', 'prompt' => '请输入供应商名称']) ?>
                </div>
            </div>
            <div class="search-item search-model">
                <div class="input-group">
                    <?php
                    echo \kartik\daterange\DateRangePicker::widget([
                        'model' => $searchModel,
                        'attribute' => 'order_pay_time',
                        'convertFormat' => true,
                        'language' => 'zh-CN',
                        'options' => [
                            'placeholder' => '请输入下单时间',
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
                <div class="input-group">
                    <?= Html::activeDropDownList($searchModel, 'insurance_type', [1 => '航意险', 2 => '航延险'], ['class' => 'form-control', 'prompt' => '保险类型','style'=>'width: 150px !important;']) ?>
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
    <div style="padding-bottom: 10px;">
        <span>
            保单合计：
            <b>
                <?= empty($totalInfo['total_num']) ? 0 : $totalInfo['total_num']?>
            </b>
        </span>
        <span style="padding-left: 50px;">
            佣金合计：
            <b>
                <?= empty($totalInfo['insurance_total']) ? 0 : $totalInfo['insurance_total']?>
            </b>
        </span>
    </div>
    <?php
    $gridColumns = [
        ['class' => 'yii\grid\SerialColumn', 'header' => '序号'],
        [
            'label' => '供应商名称',
            'value' => function($model){
                return $model->supplier->name;
            }
        ],
        [
            'label' => '保险类型',
            'value' => function($model){
                return Yii::$app->params['plane_emplane_insurance_type'][$model->type];
            }
        ],
        [
            'label' => '保费',
            'value' => function($model){
                return $model->price;
            }
        ],
        [
            'label' => '保单总数',
            'value' => function($model){
                return \backend\controllers\PlaneInsuranceProfitController::NoRefundNum($model->order, $model->type);
            }
        ],
        [
            'label' => '退保数',//退保成功的，即refund_insurance_status = 2
            'value' => function($model){
                return \backend\controllers\PlaneInsuranceProfitController::EmplaneInsuranceRefundNum($model->order, $model->type);
            }
        ],
        [
            'label' => '佣金比例',
            'value' => function($model){
                return ($model->ratio.'%');
            }
        ],
        [
            'label' => '佣金收入',
            'value' => function($model){
                return \backend\controllers\PlaneInsuranceProfitController::TotalProfit($model->order, $model->type);
            }
        ],


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
        'pager' => [
            'firstPageLabel' => '首页',
            'lastPageLabel' => '尾页',
        ],
    ]); ?>
</div>
