<?php

use kartik\daterange\DateRangePicker;
use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BookingQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '付款单列表';
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

                                <?= Html::beginForm(['shop-payment/index'], 'get', ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal', 'id' => 'addForm']) ?>
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
                                        <?= Html::activeInput('text', $searchModel, 'order_num', ['class' => 'form-control input', 'placeholder' => '订单编号']) ?>
                                    </div>
                                </div>


                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeInput('text', $searchModel, 'pay_num', ['class' => 'form-control input', 'placeholder' => '付款单']) ?>
                                    </div>
                                </div>

                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeInput('text', $searchModel, 'purchase_num', ['class' => 'form-control input', 'placeholder' => '采购单号']) ?>
                                    </div>
                                </div>

                                <div class="search-item">
                                    <div class="input-group"
                                         style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeDropDownList($searchModel, 'type', [1 => '支付供应商', 2 => '客户退款', 3 => '积分兑换', 4 => '积分返还'], ['class' => 'form-control', 'prompt' => '付款单类型']) ?>

                                    </div>
                                </div>

                                <div class="search-item">
                                    <div class="input-group"
                                         style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeDropDownList($searchModel, 'status', Yii::$app->params['shop']['pay_status'], ['class' => 'form-control', 'prompt' => '状态']) ?>

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

                $gridColumns = [['class' => 'yii\grid\SerialColumn',
                    'header' => '序号'],
                    'pay_num',
                    'order.order_num',
                    'purchase.purchase_num',

                    ['header' => '付款单类型',
                        'value' => function ($model) {
                            $arr = [1 => '支付供应商', 2 => '客户退款', 3 => '积分兑换', 4 => '积分返还'];

                            if (array_key_exists($model->type, $arr)) {

                                return $arr[$model->type];

                            }
                        },


                    ],

                    ['header' => '支付方式',
                        'value' => function ($model) {
                            $arr = [1 => '支付宝', 2 => '微信', 3 => '积分'];

                            if (array_key_exists($model->pay_type, $arr)) {

                                if ($model->pay_type) {
                                    return $arr[$model->pay_type];
                                }

                            }
                            if ($model->type == 1) {
                                return '银行转帐';
                            }
                        },


                    ],
                    'transaction_id',

                    ['header' => '状态',
                        'value' => function ($model) {
                            $arr = [0 => '待确认', 1 => '待付款', 2 => '已付款', 3 => '已取消'];

                            if (array_key_exists($model->status, $arr)) {

                                return $arr[$model->status];

                            }
                        },


                    ],
                    ['header' => '生成时间',
                        'value' => function ($model) {

                            return date('Y-m-d H:i:s', $model->create_time);
                        },


                    ],

                    ['header' => '是否可以支付',
                        'value' => function ($model) {
                            if ($model->type == 1 && $model->status == 1 && $model->order['status'] == 20 && !\backend\models\ShopPayment::getRefund($model->order_id)) {
                                return '是';

                            } else {
                                return '否';
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
<style>
    tr, th {
        text-align: center;
    }

    .pagination {
        float: right;
    }

</style>

