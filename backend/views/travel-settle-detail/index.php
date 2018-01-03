<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\daterange\DateRangePicker;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BookingQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '订单列表';
$this->params['breadcrumbs'][] = $this->title;

?>
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/css/common.min.css">
<script src="<?= Yii::$app->request->baseUrl ?>/js/jquery.min.js"></script>
<style>
    .btn-group, .btn-group-vertical
    {
        margin-top: 10px;
    }
    .btn-primary{
        margin-right:0;
    }
</style>
<div class="row" style="margin-top: 20px; margin-left: 6px; margin-bottom: -20px;">
    <div class="col-xs-12">
        <?= Html::Button('< 返回', ['class' => 'btn btn-sm btn-primary', 'id' => 'return_up']) ?>
        <script>
            $(function () {
                $("#return_up").click(function () {
                    window.location.href = "<?= Url::to(['finance-travel/index'])?>";
                });
            })
        </script>
    </div>
    <!-- /.col -->
</div>
<div class="booking-index">
    <div class="wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox">
                    <div class="ibox-content" style="margin-bottom: 20px;">

                        <?php
                        use kartik\export\ExportMenu;

                        $gridColumns = [
                            ['class' => 'yii\grid\SerialColumn', 'header' => '序号'],
                            //'id',
                            //'order_uid',
                            //'travel_uid',
                            //'travel_id',
                            'order_no',
                            [//用户/手机号
                                'attribute' => 'user_info',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return \backend\controllers\TravelOrderController::actionUser_info($model->order_uid);
                                },
                            ],
                            'travel_name',//商品名称
                            [//商品品类
                                'attribute' => 'type',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return Yii::$app->params['type'][$model->type];
                                },
                            ],
                            'create_time',//下单时间
                            'activity_date',//出发日期
                            [//总人数
                                'attribute' => 'total_num',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    //@2017-7-18 13:56:29 fuyanfei to update 不同的订单类型显示不同的预定人数
                                    if($model->type==2){
                                        return $model->anum;
                                    } else if($model->type==3){
                                        return ($model->adult + $model->child);
                                    } else{
                                        return "0";
                                    }
                                    //return ($model->adult + $model->child);
                                },
                            ],
                            [//总金额
                                'attribute' => 'total',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->total;
                                },
                            ],
                            [//优惠券金额
                                'attribute' => 'coupon_amount',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->coupon_amount;
                                },
                            ],
                            [//实付金额
                                'attribute' => 'pay_amount',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->pay_amount;
                                },
                            ],
                            [//棠果佣金
                                'attribute' => 'tangguo_income',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    if($model->tangguo_income < 0)
                                        return '0.00';
                                    else
                                        return $model->tangguo_income;
                                },
                            ],
                            [//支付方式
                                'attribute' => 'pay_platform',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return Yii::$app->params['pay_type'][$model->pay_platform];
                                },
                            ],
                            [//支付状态
                                'attribute' => 'pay_state',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    if (empty($model->trade_no)) {
                                        return '未支付';
                                    } else {
                                        return '已支付';
                                    }
                                },
                            ],
                            [//订单状态
                                'attribute' => 'state',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    if ($model->refund_stauts == 0) {//交易流程
                                        return Yii::$app->params['status_order'][$model->state];
                                    } else {//退款流程
                                        return Yii::$app->params['stauts_refund'][$model->refund_stauts];
                                    }
                                },
                            ],
                            [//订单类型
                                'attribute' => 'is_confirm',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return Yii::$app->params['is_confirm'][$model->is_confirm];
                                },
                            ],
                            [//结算状态
                                'attribute' => 'close_account',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return Yii::$app->params['close_account'][$model->close_account];
                                },
                            ],
                        ];

                        // Renders a export dropdown menu
                        echo ExportMenu::widget([
                            'dataProvider' => $dataProvider
                            ,'columns' => $gridColumns
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
                        <script>
                            $(function () {
                                $(".operation_status").click(function () {
                                    var id = $(this).attr("id");//订单ID + 选择
                                    var name = $(this).attr("name");//当前状态
                                    console.log(id);
                                    console.log(name);
                                    $.post("<?= Url::to(['travel-order/operation'])?>", {
                                        "PHPSESSID": "<?php echo session_id();?>",
                                        "<?=Yii::$app->request->csrfParam?>": "<?=Yii::$app->request->getCsrfToken()?>",
                                        data: {"id":id, "status":name}
                                    }, function (data) {
                                        if (data == 'success') {
                                            window.location.reload();
                                        } else {
                                            layer.alert('修改失败');
                                        }
                                    });
                                });
                            })
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

