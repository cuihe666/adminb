<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\daterange\DateRangePicker;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BookingQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '旅游结算表';
$this->params['breadcrumbs'][] = $this->title;

?>
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/css/common.min.css">
<script src="<?= Yii::$app->request->baseUrl ?>/js/jquery.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/layer/layer.js"></script>
<style>
    .btn-group, .btn-group-vertical
    {
        margin-top: 10px;
    }
    .btn-primary{
        margin-right:0;
    }
</style>
<div class="booking-index">
    <div class="wrapper-content animated fadeInRight">
        <div class="row">
            <input type="hidden" id="admin_note" value="<?= $admin_note?>">
            <script>
                $(function () {
                    var note = $("#admin_note").val();
                    if (note == 'y') {
                        $(".action-column").css("display","none");
                        $(".pay_detail").parent().parent().css("display","none");
                        $(".alipay_play_money").parent().parent().css("display","none");
                        $(".change_status").parent().parent().css("display","none");
                        $(".gang").parent().parent().css("display","none");
                    }
                })
            </script>
            <div class="col-sm-12">
                <div class="ibox">
                    <div class="ibox-content" style="margin-bottom: 20px;">
                        <div class="search-box clearfix" style="margin: -65px 0 0 20px;">
                            <div class="search-item">
                                <?= Html::beginForm('', 'get', ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal', 'id' => 'addForm']) ?>
                                <div class="search-item">
                                    <div class="input-group" style="width: 200px;margin-right: 5px;">
                                        <?php


                                        echo DateRangePicker::widget([
                                            'model' => $searchModel,
                                            'attribute' => 'create_time',
                                            'convertFormat' => true,
                                            'language' => 'zh-CN',
                                            'options' => [
                                                'placeholder' => '请输入申请结算日期',
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
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeDropDownList($searchModel, 'status',Yii::$app->params['play_money'], ['class' => 'form-control', 'prompt' => '打款状态']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 200px;margin-right: 5px;">
                                        <?= Html::activeInput('text', $searchModel, 'Alipay_num', ['class' => 'form-control input', 'placeholder' => '请输入支付账号']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 200px;margin-right: 5px;">
                                        <?= Html::activeInput('text', $searchModel, 'user_name', ['class' => 'form-control input', 'placeholder' => '请输入联系人']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 200px;margin-right: 5px;">
                                        <?= Html::activeInput('text', $searchModel, 'user_mobile', ['class' => 'form-control input', 'placeholder' => '请输入联系电话']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 200px;margin-right: 5px;">
                                        <?= Html::activeInput('text', $searchModel, 'settle_id', ['class' => 'form-control input', 'placeholder' => '请输入申请结算ID']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 200px;margin-right: 5px;">
                                        <?= Html::submitButton('搜索', ['class' => 'btn btn-sm btn-primary']) ?>
                                    </div>
                                </div>

                                <?= Html::endForm() ?>
                            </div>
                        </div>

                        <?php
                        use kartik\export\ExportMenu;

                        $gridColumns = [
                            ['class' => 'yii\grid\SerialColumn', 'header' => '序号'],
                            [//结算ID
                                'attribute' => 'settle_id',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return "<a href='#' class='settle_id' id='". $model->id ."'>". $model->settle_id ."</a>";
                                },
                            ],
                            'uid',//结算人ID
                            [//支付宝账号
                                'attribute' => 'Alipay_num',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return \backend\controllers\FinanceTravelController::actionAlipay_data($model->uid);
                                },
                            ],
                            [//联系人
                                'attribute' => 'user_name',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return \backend\controllers\FinanceTravelController::actionUser_name($model->uid);
                                },
                            ],
                            [//联系电话
                                'attribute' => 'user_mobile',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return \backend\controllers\FinanceTravelController::actionUser_mobile($model->uid);
                                },
                            ],
                            [//申请结算日期
                                'attribute' => 'create_time',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return date('Y-m-d H:i:s', $model->create_time);
                                },
                            ],
                            'total',//实际支付金额
                            'order_total',//订单总额
                            'settle_price',//结算总金额
                            'coupon_total',//优惠券总额
                            //'tangguo_total',//
                            [//棠果收入
                                'attribute' => 'tangguo_total',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    if($model->tangguo_total<0)
                                        return '0.00';
                                    else
                                        return $model->tangguo_total;
                                },
                            ],
                            [//打款状态
                                'attribute' => 'status',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return Yii::$app->params['play_money'][$model->status];
                                },
                            ],
                            [//打款时间
                                'attribute' => 'pay_time',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    if ($model->pay_time == '0') {
                                        return '-';
                                    } else {
                                        return date('Y-m-d H:i:s', $model->pay_time);
                                    }
                                },
                            ],
                            ['class' => 'yii\grid\ActionColumn',
                                'header' => '操作',
                                'template' => '<div class="dropdown profile-element group-btn-edit">{operation}</div> ',
                                'buttons' => [
                                    'operation' => function ($url, $model, $key) {
                                            switch ($model->status)
                                            {
                                                case 0://未打款
                                                    if (\backend\controllers\FinanceTravelController::actionAlipay_data($model->uid) == '-') {
                                                        return "<span class='gang'>-</span>";
                                                    } else {
                                                        return "<a href='#' class='operation_status alipay_play_money' id='". $model->id ."' style='color: #00aa00;'>打款到支付宝</a>";
                                                    }
                                                    break;
                                                case 1://已打款
                                                    return "<a href='#' class='operation_status pay_detail' style='color: midnightblue;' id='". $model->id ."'>付款详情</a>";
                                                    break;
                                                case 2://打款失败
                                                    return "<a href='#' class='operation_status alipay_play_money' id='". $model->id ."' style='color: #00aa00;'>打款到支付宝</a>";
                                                    break;
                                                default:
                                                    break;
                                            }
                                    },
                                ],
                            ],
                            ['class' => 'yii\grid\ActionColumn',
                                'header' => '状态操作（不打款）',
                                'template' => '<div class="dropdown profile-element group-btn-edit">{status}</div> ',
                                'buttons' => [
                                    'status' => function ($url, $model, $key) {
                                        if ($model->status == 0) {
                                            return "<a href='#' class='operation_status change_status' id='". $model->id ."' style='color: midnightblue;'>打款完毕</a>";
                                        } else {
                                            return "<span class='gang'>-</span>";
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
                    </div>
                    <script>
                        $(function() {
                            $(".settle_id").click(function () {
                                var settle_id = $(this).attr("id");
                                window.location.href = "<?= Url::to(['travel-settle-detail/index'])?>?id="+settle_id;
                            });
                        })
                    </script>
                    <script>
                        $(function () {
                            $(".alipay_play_money").click(function () {
                                var id = $(this).attr("id");
                                layer.confirm('您确定要打款吗？', {
                                    btn: ['确定','取消'] //按钮
                                }, function(){
                                    layer.closeAll();
                                    $.post("<?= Url::to(['finance-travel/operation'])?>", {
                                        "PHPSESSID": "<?php echo session_id();?>",
                                        "<?=Yii::$app->request->csrfParam?>": "<?=Yii::$app->request->getCsrfToken()?>",
                                        "datatype":'json',
                                        data: id
                                    }, function (data) {
                                        var info = jQuery.parseJSON(data);
                                        if (info.code === '0') {
                                            window.location.reload();
                                        } else {
//                                            console.log(info.msg);
                                            layer.alert(info.msg);
                                        }
                                    });
                                }, function(){

                                });

                            });
                            //付款详情
                            $(".pay_detail").click(function () {
                                var id = $(this).attr("id");
                                $.post("<?= Url::to(['finance-travel/pay_detail'])?>", {
                                    "PHPSESSID": "<?php echo session_id();?>",
                                    "<?=Yii::$app->request->csrfParam?>": "<?=Yii::$app->request->getCsrfToken()?>",
                                    "datatype":'json',
                                    data: id
                                }, function (data) {
                                    var info = jQuery.parseJSON(data);
//                                    console.log(info);
                                    layer.open({
                                        type: 1,
                                        title:'<span style="font-weight: bold;">打款信息</span>',
                                        skin: 'layui-layer-rim', //加上边框
                                        area: ['420px', '260px'], //宽高
                                        content: "<div style='margin-left: 20px; margin-top: 20px;'>打款金额：<span style='margin-left: 10px;'>"+info.total+"</span></div><div style='margin-left: 20px; margin-top: 10px;'>打款方式：<span style='margin-left: 10px;'>"+info.pay_type+"</span></div><div style='margin-left: 20px; margin-top: 10px;'>打款人：<span style='margin-left: 10px;'>"+info.name+"</span></div><div style='margin-left: 20px; margin-top: 10px;'>打款时间：<span style='margin-left: 10px;'>"+info.pay_time+"</span></div><div style='margin-left: 20px; margin-top: 10px;'>打款订单号：<span style='margin-left: 10px;'>"+info.order_no+"</span></div>"
                                    });
                                });
                            });
                            $(".change_status").click(function () {
                                var id = $(this).attr("id");
                                layer.confirm('您确定要改变打款状态吗？', {
                                    btn: ['确定','取消'] //按钮
                                }, function(){
                                    layer.closeAll();
                                    $.post("<?= Url::to(['finance-travel/change-status'])?>", {
                                        "PHPSESSID": "<?php echo session_id();?>",
                                        "<?=Yii::$app->request->csrfParam?>": "<?=Yii::$app->request->getCsrfToken()?>",
                                        "datatype":'json',
                                        data: id
                                    }, function (data) {
                                        var info = jQuery.parseJSON(data);
//                                        console.log(info);
                                        if (info.code === '0') {
                                            window.location.reload();
                                        } else {
//                                            console.log(info.msg);
                                            layer.alert(info.msg);
                                        }
                                    });
                                }, function(){

                                });
                            });
                        })
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>

