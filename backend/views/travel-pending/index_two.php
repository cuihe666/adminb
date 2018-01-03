<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\daterange\DateRangePicker;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BookingQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '旅游订单列表';
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
    #top_select ul li{
        float: left;
        margin-left: 30px;
        height: 40px;
        width: 156px;
    }
    #top_select ul{
        margin-left: -25px;
    }
    .top_select
    {
        width: 167px;
        height: 53px;
        line-height: 41px;
        font-size: 18px;
        border: solid 1px white;
    }
     input::-webkit-outer-spin-button,
     input::-webkit-inner-spin-button {
         -webkit-appearance: none;
     }
    input[type="number"]{
        -moz-appearance: textfield;
    }
</style>
<?php
if($order_type==0)
    $action = "index";
if($order_type==2)
    $action = "local";
if($order_type==3)
    $action = "theme";
if($order_type==5)
    $action = "guide";
?>
<div class="row" style="margin-top: 20px;">
    <div class="col-xs-12">
        <div class="col-xs-12 table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <div class="search-item" id="top_select">
                    <ul>
                        <li><a href="<?= Url::to(['travel-pending/index'])?>" class='btn btn-sm btn-primary top_select' <?= $order_type==0 ? "style='background: teal;'" : ''; ?>>全部订单</a></li>
                        <li><a href="<?= Url::to(['travel-pending/theme'])?>" class='btn btn-sm btn-primary top_select' <?= $order_type==3 ? "style='background: teal;'" : ''; ?>>主题线路</a></li>
                        <li><a href="<?= Url::to(['travel-pending/local'])?>" class='btn btn-sm btn-primary top_select' <?= $order_type==2 ? "style='background: teal;'" : ''; ?>>当地活动</a></li>
                        <li><a href="<?= Url::to(['travel-pending/guide'])?>" class='btn btn-sm btn-primary top_select' <?= $order_type==5 ? "style='background: teal;'" : ''; ?>>当地向导</a></li>
                    </ul>
                </div>
            </table>
        </div>
    </div>
    <!-- /.col -->
</div>
<div class="booking-index">
    <div class="wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox">
                    <div class="ibox-content" style="margin-bottom: 20px;">
                        <div class="search-box clearfix" style="margin: -65px 0 0 20px;">
                            <div class="search-item">
                                <?= Html::beginForm(['travel-pending/'.$action], 'get', ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal', 'id' => 'addForm']) ?>
                                <div class="search-item">
                                    <div class="input-group" style="width: 165px;">
                                        <?php
                                        echo DateRangePicker::widget([
                                            'model' => $searchModel,
                                            'attribute' => 'activity_date',
                                            'convertFormat' => true,
                                            'language' => 'zh-CN',
                                            'options' => [
                                                'placeholder' => '请选择体验时间',
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
                                    <div class="input-group" style="width: 165px;">
                                        <?php
                                        echo DateRangePicker::widget([
                                            'model' => $searchModel,
                                            'attribute' => 'create_time',
                                            'convertFormat' => true,
                                            'language' => 'zh-CN',
                                            'options' => [
                                                'placeholder' => '请选择下单时间',
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
                                    <div class="input-group" style="width: 120px; float: left;">
                                        <?= Html::activeDropDownList($searchModel, 'theme_tag',\backend\controllers\TravelPendingController::actionCity_code(), ['class' => 'form-control', 'prompt' => '搜索城市']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;">
                                        <?= Html::activeDropDownList($searchModel, 'pay_platform',[1 => '支付宝', 2 => '微信', '-' => '暂无'], ['class' => 'form-control', 'prompt' => '支付方式']) ?>
                                    </div>
                                </div>

                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;">
                                        <?= Html::activeDropDownList($searchModel, 'state',['11' => '待支付', '31' => '待确认', '51' => '待退款',], ['class' => 'form-control', 'prompt' => '订单状态']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;">
                                        <?= Html::activeDropDownList($searchModel, 'is_confirm',Yii::$app->params['is_confirm'], ['class' => 'form-control', 'prompt' => '订单类型']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;">
                                        <?= Html::activeDropDownList($searchModel, 'pay_state',['1' => '未支付', '2' => '已支付'], ['class' => 'form-control', 'prompt' => '支付状态']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 200px;">
                                        <?= Html::activeInput('number', $searchModel, 'user_mobile', ['class' => 'form-control input', 'placeholder' => '请输入用户手机号']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 200px;">
                                        <?= Html::activeInput('text', $searchModel, 'order_no', ['class' => 'form-control input', 'placeholder' => '请输入订单号']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 200px;">
                                        <?= Html::activeInput('text', $searchModel, 'user_name', ['class' => 'form-control input', 'placeholder' => '请输入用户名']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 200px;">
                                        <?= Html::activeInput('text', $searchModel, 'travel_name', ['class' => 'form-control input', 'placeholder' => '请输入商品名称']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 200px;">
                                        <?= Html::submitButton('搜索', ['class' => 'btn btn-sm btn-primary']) ?>&nbsp;
                                        <?= Html::a("清空",['travel-pending/'.$action],['class' => 'btn btn-sm btn-primary','style'=>'line-height:33px;']) ?>
                                    </div>
                                </div>

                                <?= Html::endForm() ?>
                            </div>
                        </div>


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
                            [//商品城市
                                'attribute' => 'ware_city',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return \backend\controllers\TravelOrderController::actionWare_city($model->id, $model->type);
                                },
                            ],
                            [//商品城市
                                'attribute' => 'theme_tag',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return \backend\controllers\TravelOrderController::actionTheme_type($model->id, $model->type);
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
                                    if ($model->type == 2) {//当地活动
                                        return "<a href='#' class='total_person' id='". $model->id ."'>". ($model->anum) ."</a>";
                                    } else if ($model->type == 3) {//主题higo
                                        return "<a href='#' class='total_person' id='". $model->id ."'>". ($model->adult + $model->child) ."</a>";
                                    }
                                },
                            ],
                            [//总金额
                                'attribute' => 'total',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return '￥'. $model->total;
                                },
                            ],
                            [//优惠券金额
                                'attribute' => 'coupon_amount',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return '￥'. $model->coupon_amount;
                                },
                            ],
                            [//实付金额
                                'attribute' => 'pay_amount',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return '￥'. $model->pay_amount;
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
                                        if (($model->state == 21) && ($model->is_confirm == 1)) {
                                            return '待确认';
                                        } else {
                                            return Yii::$app->params['status_order'][$model->state];
                                        }
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
                            //状态操作
                            ['class' => 'yii\grid\ActionColumn',
                                'header' => '操作',
                                'template' => '<div class="dropdown profile-element group-btn-edit">
                                     {operation}
                                </div> ',
                                'buttons' => [
                                    'operation' => function ($url, $model, $key) {
                                        if ($model->refund_stauts == 0) {//交易流程
                                            switch ($model->state)
                                            {
                                                case 11://待支付
                                                    return "-";
                                                    break;
                                                case 21://已支付
                                                    return "<a href='#' class='operation_status' style='color: #00aa00;' id='$key-y' name='$model->state'>确认</a>|<a href='#' class='operation_status' style='color: #00aa00;' id='$key-n' name='$model->state'>取消</a>";
                                                    break;
                                                case 31://待确认
                                                    return "<a href='#' class='operation_status' style='color: #00aa00;' id='$key-y' name='$model->state'>确认</a>|<a href='#' class='operation_status' style='color: #00aa00;' id='$key-n' name='$model->state'>取消</a>";
                                                    break;
                                                default:
                                                    return '-';
                                                    break;
                                            }
                                        } else {//退款流程
                                            switch ($model->refund_stauts)
                                            {
                                                case 51://待退款
                                                    return "<a href='#' class='operation_status' style='color: #00aa00;' id='$key-y' name='$model->refund_stauts'>确认退款</a>|<a href='#' class='operation_status' style='color: #00aa00;' id='$key-n' name='$model->refund_stauts'>退款驳回</a>";
                                                    break;
                                                default:
                                                    return '-';
                                                    break;
                                            }
                                        }
                                    },
                                ],
                            ],

                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => '操作',
                                'template' => '<div style="width: 50px; text-align: center;">
                            {view}
                          </div> ',
                                'buttons' => [
                                    'view' => function ($url, $model, $key) {
                                        return Html::a('查看', ['travel-order/view', 'class' => '', 'style' => 'color:navy', 'id' => $key]);
                                    },
                                ],
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => '操作',
                                'template' => '<div style="width: 50px; text-align: center;">
                            {join}
                          </div> ',
                                'buttons' => [
                                    'join' => function ($url, $model, $key) {
                                        if ($model->type == '2') {
                                            return Html::a('总联系人', "#", ['class' => 'contact_person', 'id' => $model->travel_name, 'style' => 'color:navy']);
                                        } else if ($model->type == '3') {
                                            return Html::a('总参团人', "#", ['class' => 'join_person', 'id' => $model->id, 'style' => 'color:navy']);
                                        }
                                    },
                                ],
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
                                //参团人数
//                                $(".total_person").click(function () {
//                                    var id = $(this).attr("id");
//                                    window.location.href = "<?//= Url::to(['travel-order-contacts/index'])?>//?oid="+id;
//                                });
                                //总参团人
                                $(".join_person").click(function () {
                                    var id = $(this).attr("id");
                                    window.location.href = "<?= Url::to(['travel-order-contacts/total'])?>?oid="+id;
                                });
                                $(".contact_person").click(function () {
                                    var name = $(this).attr("id");
                                    window.location.href = "<?= Url::to(['travel-order-contacts/contact'])?>?travel_name=" + name;
                                });
                            })
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

