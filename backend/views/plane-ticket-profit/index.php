<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PlaneTicketSupplierQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '机票费用及收益';
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
            <?= Html::beginForm(['plane-ticket-profit/index'], 'get', ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal']) ?>
            <div class="search-item" style="float: left">
                <div class="input-group">
                    <?= Html::activeInput('text', $searchModel, 'supplier_name', ['class' => 'form-control input', 'placeholder' => '请输入供应商名称']) ?>
                </div>
            </div>
            <div class="search-item search-model">
                <div class="input-group">
                    <?php
                    echo \kartik\daterange\DateRangePicker::widget([
                        'model' => $searchModel,
                        'attribute' => 'order_create_time',
                        'convertFormat' => true,
                        'language' => 'zh-CN',
                        'options' => [
                            'placeholder' => '请选择筛选时间',
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
                    <?= Html::submitButton('搜索', ['class' => 'btn btn-sm btn-primary']) ?>&nbsp;
                </div>
            </div>
            <?= Html::endForm() ?>
        </div>
    </div>
    <?php
    $gridColumns = [
        ['class' => 'yii\grid\SerialColumn', 'header' => '序号'],
        'name',
        [
            'label' => '总票量',
            'value' => function($model){
                return \backend\controllers\PlaneTicketProfitController::AllRefundNum($model->order);
            }
        ],
        [
            'label' => '未退票量',
            'value' => function($model){
                return \backend\controllers\PlaneTicketProfitController::NoRefundNum($model->order);
            }
        ],
        [
            'label' => '退票量',
            'value' => function($model){
                return \backend\controllers\PlaneTicketProfitController::RefundNum($model->order);
            }
        ],
        [
            'label' => '流量费用',
            'value' => function($model){
                return '待开发...';
            }
        ],
        [
            'label' => '佣金收入',
            'value' => function($model){
                return \backend\controllers\PlaneTicketProfitController::TotalProfit($model->order);
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => '操作',
            'template' => '<div class="dropdown profile-element group-btn-edit">
                                    {look}
                                </div> ',
            'buttons' => [
                'look' => function ($url, $model, $key) {
                    return Html::a('查看佣金详情', "#", ['class' => 'delnode  btn-primary btn-sm look_profit_detail', 'style' => 'color:white', 'MyAttr'=> $model->id]);
                },
            ]
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
<script>
    $(".look_profit_detail").click(function () {
        var id = $(this).attr("MyAttr");
        location.href = "<?= \yii\helpers\Url::to(['plane-ticket-profit/detail'])?>?sid="+id;
    });
</script>
