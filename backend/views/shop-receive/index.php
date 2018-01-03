<?php

use kartik\daterange\DateRangePicker;
use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BookingQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '收款单列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<script src="<?= Yii::$app->request->baseUrl ?>/js/jquery.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/layer.js"></script>
<div class="booking-index">

    <div class="wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox">
                    <div class="ibox-content" style="margin-bottom: 20px;">
                        <div class="search-box clearfix">

                            <div class="search-item">

                                <?= Html::beginForm(['shop-receive/index'], 'get', ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal', 'id' => 'addForm']) ?>
                                <div class="search-item">
                                    <div class="input-group" style="width: 200px; float: left;margin-right: 18px;">
                                        <?php


                                        echo DateRangePicker::widget([
                                            'model' => $searchModel,
                                            'attribute' => 'create_time',
                                            'convertFormat' => true,
                                            'language' => 'zh-CN',
                                            'options' => [
                                                'placeholder' => '创建时间',
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
                                        <?= Html::activeInput('text', $searchModel, 'receive_num', ['class' => 'form-control input', 'placeholder' => '收款单']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeInput('text', $searchModel, 'order_num', ['class' => 'form-control input', 'placeholder' => '订单号']) ?>
                                    </div>
                                </div>

                                <div class="search-item">
                                    <div class="input-group"
                                         style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeDropDownList($searchModel, 'type', [1 => '商城应收', 2 => '商家应退', 3 => '积分兑换',4=>'积分返还'], ['class' => 'form-control', 'prompt' => '收款单类型']) ?>

                                    </div>
                                </div>

                                <div class="search-item">
                                    <div class="input-group"
                                         style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeDropDownList($searchModel, 'status', Yii::$app->params['shop']['receive_status'], ['class' => 'form-control', 'prompt' => '状态']) ?>

                                    </div>
                                </div>


                                <div class="search-item">
                                    <div class="input-group"
                                         style="width: 280px; float: left;margin-right: 18px;">

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
                    'receive_num',
                    'order_num',
                    ['header' => '收款单类型',
                        'value' => function ($model) {
                            return Yii::$app->params['shop']['shop_receive'][$model->type];
                        },],
                    ['header' => '支付方式',
                        'value' => function ($model) {
                            if($model->type ==2)
                            {
                                return '银行转帐';
                            }else
                            {
                                return Yii::$app->params['shop']['pay_type'][$model->pay_type];
                            }

                        },],

                    ['header' => '生成时间',
                        'value' => function ($model) {

                            return date('Y-m-d H:i:s', $model->create_time);
                        },


                    ],

                    ['header' => '收款单状态',
                        'value' => function ($model) {

                            return Yii::$app->params['shop']['receive_status'][$model->status];
                        },


                    ],
                    ['header' => '收款人',
                        'value' => function ($model) {

                            switch ($model->type) {
                                case    1:
                                    return '平台';
                                    break;
                                case    2:
                                    return '平台';
//                                    return \backend\models\ShopReceive::getUserName($model->order_id);
                                    break;

                                case    3:
                                    return '平台';
                                    break;

                                case    4:
                                    return '平台';
                                    break;

                            }


                        },


                    ],


                    ['class' => 'yii\grid\ActionColumn',
                        'header' => '操作',
                        'template' => '<div class="dropdown profile-element group-btn-edit">
                                     {view}
                                </div> ',
                        'buttons' => ['view' => function ($url, $model, $key) {


                            return Html::a('查看', ['view', 'id' => $key]);


                        },],],];


                // You can choose to render your own GridView separately
                // You can choose to render your own GridView separately
                echo GridView::widget(['dataProvider' => $dataProvider,
                    'columns' => $gridColumns,
                    'pager' => ['firstPageLabel' => '首页',
                        'lastPageLabel' => '尾页',],]);
                ?>

            </div>
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


