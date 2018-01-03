<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\daterange\DateRangePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BookingQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '订单列表';
$this->params['breadcrumbs'][] = $this->title;
?>
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
                            </div>
                        </div>
                    </div>

                    <?php
                    use kartik\export\ExportMenu;

                    $gridColumns = [

                        'id',
                        ['attribute' => 'order.pay_time',
                            'value' => function ($model) {
                                $time = strtotime($model->order['pay_time']);
                                return $time ? date("Y-m-d", $time) : '暂无';
                            },],
                        'house_title',
                        'house_id',
                        'total',
                        'order.pay_amount',
                        'order.coupon_amount',
                        'order.agent_income',
                        'order.landlady_income',
                        'order.tangguo_income',
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
                        'username.name',
                        ['attribute' => 'order_num',
                            'value' => function ($model) {
                                return ' ' . $model->order_num;
                            },],
                        ['attribute' => 'house_city_id',
                            'value' => function ($model) {
                                return \backend\service\CommonService::get_city_name($model->house_city_id);
                            },],
                        ['attribute' => 'order.order_stauts',
                            'value' => function ($model) {
                                return $model->order['refund_stauts'] ? Yii::$app->params['refund_status'][$model->order['refund_stauts']] : Yii::$app->params['order_status'][$model->order['order_stauts']];
                                //                                                return $model->status;
                            },],
                        ['class' => 'yii\grid\ActionColumn',
                            'header' => '操作',
                            'template' => '<div class="dropdown profile-element group-btn-edit">
                                    {view}
                                </div> ',
                            'buttons' => [
                                'view' => function ($url, $model, $key) {
                                    return Html::a('查看', ['order-detail-static/view', 'id' => $model->id]);
                                },
                            ],],
                    ];

                    echo ExportMenu::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => $gridColumns
                    ]);
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
                    } else {
                        layer.alert('确认退款成功', {icon: 1});
                    }
                }
            })
            layer.close(index);
        });
    }
</script>