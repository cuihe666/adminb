<?php

use kartik\daterange\DateRangePicker;
use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BookingQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = '订单列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/layer.js"></script>


<div class="booking-index">

    <div class="wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox">
                    <div class="ibox-content" style="margin-bottom: 20px;">
                        <div class="search-box clearfix">

                            <div class="search-item">

                                <?= Html::beginForm(['shop-order/index'], 'get', ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal', 'id' => 'addForm']) ?>
                                <div class="search-item">
                                    <div class="input-group" style="width: 200px; float: left;margin-right: 18px;">
                                        <?php


                                        echo DateRangePicker::widget([
                                            'model' => $searchModel,
                                            'attribute' => 'create_time',
                                            'convertFormat' => true,
                                            'language' => 'zh-CN',
                                            'options' => [
                                                'placeholder' => '请输入起始时间',
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

                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeDropDownList($searchModel, 'status', Yii::$app->params['shop']['order_status'], ['class' => 'form-control', 'prompt' => '订单状态']) ?>
                                    </div>
                                </div>

                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeInput('text', $searchModel, 'order_num', ['class' => 'form-control input', 'placeholder' => '订单号']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeInput('text', $searchModel, 'account', ['class' => 'form-control input', 'placeholder' => '买家帐号']) ?>
                                    </div>
                                </div>

                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeInput('text', $searchModel, 'name', ['class' => 'form-control input', 'placeholder' => '买家姓名']) ?>
                                    </div>
                                </div>


                                <div class="search-item">
                                    <div class="input-group" style="width: 280px; float: left;margin-right: 18px;">

                                        <!--                                    <button type="button" class="btn btn-sm btn-primary"> 搜索</button>-->
                                        <?= Html::submitButton('搜索', ['class' => 'btn btn-sm btn-primary']) ?>
                                    </div>
                                </div>


                                <?= Html::endForm() ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php

                $gridColumns = [
                    'id',

                    'order_num',

                    ['header' => '订单状态',
                        'value' => function ($model) {

                            return Yii::$app->params['shop']['order_status'][$model->status];
                        },


                    ],

                    ['header' => '收款单号',
                        'value' => function ($model) {

                            if ($model->receive) {
                                $receive = '';
                                foreach ($model->receive as $item) {

                                    if ($item['type'] == 1 or $item['type'] == 3 && $item['refund_id'] == 0) {
                                        $receive .= $item['receive_num'] . ',';
                                    }

                                }
                                return rtrim($receive, ',');
                            } else {
                                return '';
                            }

                        },


                    ],

                    ['header' => '订单生成时间',
                        'value' => function ($model) {

                            return date('Y-m-d H:i:s', $model->create_time);
                        },


                    ],
                    'customer.name',


                    ['class' => 'yii\grid\ActionColumn',
                        'header' => '操作',
                        'template' => '<div class="dropdown profile-element group-btn-edit">
                                    {view}
                               
                                </div> ',
                        'buttons' => [
                            'view' => function ($url, $model, $key) {
                                return Html::a('查看', "$url", ['class' => 'delnode btn btn-primary btn-sm', 'style' => 'color:white']);
                            },
                        ],],


                ];

                echo GridView::widget([
                    'export' => false,

                    'dataProvider' => $dataProvider,
                    "options" => ["class" => "grid-view", "style" => "overflow:auto", "id" => "grid"],
                    'columns' => $gridColumns,
                    'pager' => [
                        'firstPageLabel' => '首页',
                        'lastPageLabel' => '尾页',
                    ],
                ]);
                ?>

            </div>
        </div>
    </div>
</div>
<style>
    tr, th {
        text-align: center;
    }

    .pagination {
        float: right;
    }


</style>



