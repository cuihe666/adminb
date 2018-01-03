<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\daterange\DateRangePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BookingQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '房源待处理订单';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .alert-success {
        position: relative;
        z-index: 100;
    }
    .notification {
        position: fixed !important;
    }
</style>
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/css/common.min.css">
<script src="<?= Yii::$app->request->baseUrl ?>/yulan/js/jquery-1.9.1.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/layer.js"></script>
<div class="booking-index">

    <div class="wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox">
                    <div class="ibox-content" style="margin-bottom: 20px;">
                        <div class="search-box clearfix" style="margin: -65px 0 0 20px;">
                            <div class="search-item">
                                <div class="search-item">


                                    <?= Html::beginForm(['order-detail-static/pending'], 'get', ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal', 'id' => 'addForm']) ?>
                                    <div class="search-item" style="width: 200px;margin-right: 5px;">

                                        <?= Html::activeDropDownList($searchModel, 'search_type', Yii::$app->params['search_type'], ['class' => 'form-control']) ?>
                                    </div>
                                    <div class="search-item">
                                        <div class="input-group" style="width: 200px;margin-right: 5px;">
                                            <?php


                                            echo DateRangePicker::widget([
                                                'model' => $searchModel,
                                                'attribute' => 'start_time',
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
                                                        'format' => 'Y.m.d'
                                                    ]
                                                ]
                                            ]);

                                            ?>
                                        </div>
                                    </div>
                                    <div class="search-item">
                                        <div class="input-group" style="width: 200px;margin-right: 5px;">
                                            <?= Html::activeInput('text', $searchModel, 'user_account', ['class' => 'form-control input', 'placeholder' => '按下单人手机号搜索']) ?>
                                        </div>
                                    </div>
                                    <div class="search-item">
                                        <div class="input-group" style="width: 200px;margin-right: 5px;">
                                            <?= Html::activeInput('text', $searchModel, 'land_account', ['class' => 'form-control input', 'placeholder' => '按房东手机号搜索']) ?>
                                        </div>
                                    </div>
                                    <div class="search-item">
                                        <div class="input-group" style="width: 200px;margin-right: 5px;">
                                            <?= Html::activeInput('text', $searchModel, 'city_name', ['class' => 'form-control input', 'placeholder' => '按城市名搜索']) ?>
                                        </div>
                                    </div>
                                    <div class="search-item">
                                        <div class="input-group" style="width: 200px;margin-right: 5px;">
                                            <?= Html::activeInput('text', $searchModel, 'order_num', ['class' => 'form-control input', 'placeholder' => '按订单号搜索']) ?>
                                        </div>
                                    </div>
                                    <div class="search-item" style="width: 200px;margin-right: 5px;">

                                        <?= Html::activeDropDownList($searchModel, 'pay_type', Yii::$app->params['pay_type'], ['class' => 'form-control', 'prompt' => '支付方式']) ?>
                                    </div>
                                    <div class="search-item" style="width: 200px;margin-right: 5px;">

                                        <?= Html::activeDropDownList($searchModel, 'pay_status', Yii::$app->params['pay_status'], ['class' => 'form-control', 'prompt' => '支付状态']) ?>
                                    </div>
                                    <div class="search-item">
                                        <div class="input-group" style="width: 200px;margin-right: 5px;">

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
                    use kartik\export\ExportMenu;

                    $gridColumns = [

                        'id',
                        ['attribute' => 'house_city_id',
                            'value' => function ($model) {
//                                dump($model);
                                return \backend\service\CommonService::get_city_name($model->house_city_id);
                                //                                                return $model->status;
                            },],
                        ['attribute' => 'create_time',
                            'value' => function ($model) {
                                $time = strtotime($model->create_time);
                                return date("Y-m-d: H:i:s", $time);
                            },],
                        ['attribute' => 'order.pay_time',
                            'value' => function ($model) {
                                $time = strtotime($model->order['pay_time']);
                                return $time ? date("Y-m-d H:i:s", $time) : '暂无';
                            },],
                        'house_id',
                        ['attribute' => 'total',
                            'value' => function ($model) {
                                if($model->national!=10001){
                                    if($model->is_over_fee==3){
                                        $order_total=$model->clean_fee+$model->over_man_fee+$model->seas_total;
                                    }else{
                                        $order_total=$model->seas_total+$model->clean_fee;
                                    }
                                }else{
                                    $order_total=$model->total;
                                }
                                return $order_total;
                            },],
                        'order.pay_amount',
                        ['attribute' => 'refund_money',
                            'value' => function ($model) {
                                $refund_money=\backend\models\OrderRefund::getmoney($model->id);
                                return $refund_money?$refund_money:0;
                            },],
                        ['attribute' => 'in_time',
                            'value' => function ($model) {
                                $time = strtotime($model->in_time);
                                return date("Y-m-d", $time);
                            },],
                        ['attribute' => 'out_time',
                            'value' => function ($model) {
                                $time = strtotime($model->out_time);
                                return date("Y-m-d", $time);
                            },],
                        'really_name',
                        'order_num',
//                        ['attribute' => 'order.transaction_id',
//                            'value' => function ($model) {
//                                return $model->order['transaction_id']?$model->order['transaction_id']:'暂无';
//                            },],
                        ['attribute' => 'order.order_stauts',
                            'value' => function ($model) {
                                return $model->order['refund_stauts'] ? Yii::$app->params['refund_status'][$model->order['refund_stauts']] : Yii::$app->params['order_status'][$model->order['order_stauts']];
                                //                                                return $model->status;
                            },],

                        ['attribute' => 'order.pay_platform',
                            'header' => '支付方式',
                            'value' => function ($model) {
                                if($model->order['pay_platform']==1){
                                    return '支付宝';
                                }
                                if($model->order['pay_platform']==2){
                                    return '微信';
                                }
                                return '空';
                                //                                                return $model->status;
                            },],
                        ['class' => 'yii\grid\ActionColumn',
                            'header' => '操作',
                            'template' => '<div class="dropdown profile-element group-btn-edit">
                                    {view}
                                    {confirm}
                                </div> ',
                            'buttons' => [
                                'view' => function ($url, $model, $key) {
                                    return Html::a('查看', "$url",['target'=>'_blank']);
                                },
                                'confirm' => function ($url, $model, $key) {
                                    if ($model->order['order_stauts'] == 1) {
                                        return Html::a('取消', ['order-detail-static/cancel', 'order_id' => $model->order['order_id']]) . Html::a('确认订单', ['order-detail-static/confirm', 'order_id' => $model->order['order_id']]);
                                    }
                                    if ($model->order['order_stauts'] == 11) {
                                        return Html::a('取消', ['order-detail-static/cancel', 'order_id' => $model->order['order_id']]);
                                    }
                                    if ($model->order['refund_stauts'] == 1) {
                                        return Html::a('确认退款', "javascript:alt($key);") . Html::a('退款驳回', "javascript:refuse($key);");
                                    }
                                },
                            ],],
                    ];

                    // Renders a export dropdown menu
                    echo ExportMenu::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => $gridColumns
                    ]);

                    // You can choose to render your own GridView separately
                    // You can choose to render your own GridView separately
                    echo GridView::widget([
                        'dataProvider' => $dataProvider,
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
</div>
<script>
    function alt(id) {
        layer.confirm('确认要执行此操作吗？', {icon: 3, title: '友情提示'}, function (index) {
            $.ajax({
                type: 'post',
                url: "<?php echo \yii\helpers\Url::to(['order-detail-static/refund']) ?>",
                data: {order_id: id},
                success: function (data) {
                    if (data == 0) {
                        layer.alert('订单异常', {icon: 2});
//                        location.reload();
                    }else {
                        layer.alert('确认退款成功', {icon: 1});
                    }
                }
            })
            layer.close(index);
        });
    }

    function refuse(id) {
        layer.confirm('确认要执行此操作吗？', {icon: 3, title: '友情提示'}, function (index) {
            $.ajax({
                type: 'post',
                url: "<?php echo \yii\helpers\Url::to(['order-detail-static/refund-refuse']) ?>",
                data: {order_id: id},
                success: function (data) {
                    if (data == 0) {
                        layer.alert('订单异常', {icon: 2});
                    }else {
                        layer.alert('退款驳回成功', {icon: 1});
                    }
                }
            })
            layer.close(index);
        });
    }
</script>

