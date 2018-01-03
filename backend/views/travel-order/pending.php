<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\daterange\DateRangePicker;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BookingQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '旅游待处理订单';
$this->params['breadcrumbs'][] = $this->title;

?>
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/css/common.min.css">
<link rel="stylesheet" href="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="<?= Yii::$app->request->baseUrl ?>/js/jquery.min.js"></script>
<script src="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/layer/layer.js"></script>
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
    }
</style>
<div class="booking-index">
    <div class="wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox">
                    <div class="ibox-content" style="margin-bottom: 20px;">
                        <div class="search-box clearfix" style="margin: -65px 0 0 20px;">
                            <div class="search-item">
                                <?= Html::beginForm('', 'get', ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal', 'id' => 'addForm']) ?>
<!--                                <div class="search-item">-->
<!--                                    <div class="input-group" style="width: 200px;margin-right: 5px;">-->
<!--                                        --><?php
//                                        echo DateRangePicker::widget([
//                                            'model' => $searchModel,
//                                            'attribute' => 'activity_date',
//                                            'convertFormat' => true,
//                                            'language' => 'zh-CN',
//                                            'options' => [
//                                                'placeholder' => '请输入起始时间',
//                                                'class' => 'form-control',
//                                                'readonly' => true,
//                                            ],
//                                            'pluginOptions' => [
//                                                'timePicker' => false,
//                                                'timePickerIncrement' => 30,
//                                                'locale' => [
//                                                    'format' => 'Y.m.d'
//                                                ]
//                                            ]
//                                        ]);
//
//                                        ?>
<!--                                    </div>-->
<!--                                </div>-->
                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeDropDownList($searchModel, 'is_confirm',['1' => '无需确认', '2' => '需要确认'], ['class' => 'form-control', 'prompt' => '订单类型']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeDropDownList($searchModel, 'pay_platform',Yii::$app->params['pay_type'], ['class' => 'form-control', 'prompt' => '支付方式']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 200px;margin-right: 5px;">
                                        <?= Html::activeInput('text', $searchModel, 'order_no', ['class' => 'form-control input', 'placeholder' => '请输入订单号']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 200px;margin-right: 5px;">
                                        <?= Html::activeInput('text', $searchModel, 'travel_name', ['class' => 'form-control input', 'placeholder' => '请输入商品名称']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 200px;margin-right: 5px;">
                                        <?= Html::activeInput('text', $searchModel, 'user_mobile', ['class' => 'form-control input', 'placeholder' => '请输入用户手机号']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 200px;margin-right: 5px;">
                                        <?= Html::activeInput('text', $searchModel, 'user_name', ['class' => 'form-control input', 'placeholder' => '请输入用户名']) ?>
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
                            'activity_date',//出发日期
                            [//总人数
                                'attribute' => 'total_num',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return ($model->adult + $model->child);
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
                                        return Yii::$app->params['status_order'][$model->state];
                                    } else {//退款流程
                                        return "<fond style='color: red;'>".Yii::$app->params['stauts_refund'][$model->refund_stauts]."</fond>";
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
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => '操作',
                                'template' => '<div>
                            {view}&nbsp;|&nbsp;
                            {ssr}
                          </div> ',
                                'buttons' => [
                                    'view' => function ($url, $model, $key) {
                                        return Html::a('查看', "$url", ['class' => '', 'style' => 'color:navy']);
                                    },
                                    'ssr' => function ($url, $model, $key) {
                                        if ($model->is_audit == '0') {
//                                            return '<a class="btn-default btn-xs audit"  data-toggle="modal" data-target="audit" style="color:blueviolet" href="#">退款审核</a>';
                                            return Html::a('退款审核', "#", ['class' => 'btn-default btn-xs audit', 'style' => 'color:blueviolet', 'data-toggle' => 'modal','data-target' => 'audit' ,'id' => $model->id]);
                                        } else {
                                            return Html::a('完成退款', "#", ['class' => 'complete-return', 'style' => 'color:green', 'id' => $model->id]);
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
                                $(".complete-return").click(function () {
                                    var id = $(this).attr("id");
                                    $.post("<?= Url::to(['travel-order/settlement_info'])?>", {
                                        "PHPSESSID": "<?php echo session_id();?>",
                                        "<?=Yii::$app->request->csrfParam?>": "<?=Yii::$app->request->getCsrfToken()?>",
                                        "datatype":'json',
                                        data: id
                                    }, function (msg) {
                                        var info = jQuery.parseJSON(msg);
                                        layer.confirm(
                                            "<div style='margin-left: 40px;'>" +
                                            "<table height=145px>" +
                                            "<tr>" +
                                            "<td width='80px'>订单号：</td>" +
                                            "<td width='250px'>"+ info.order_no +"</td>" +
                                            "</tr>" +
                                            "<tr>" +
                                            "<td>用户名：</td>" +
                                            "<td>"+ info.nickname +"</td>" +
                                            "</tr>" +
                                            "<tr>" +
                                            "<td>用户账号：</td>" +
                                            "<td>"+ info.mobile +"</td>" +
                                            "</tr>" +
                                            "<tr>" +
                                            "<td>退款方式：</td>" +
                                            "<td>"+ info.pay_platform +"</td>" +
                                            "</tr>" +
                                            "<tr>" +
                                            "<td>退款金额：</td>" +
                                            "<td>"+ info.pay_amount +"元</td>" +
                                            "</tr>" +
                                            "</table>" +
                                            "</div>",
                                            {btn: ['确定','取消'], //按钮
                                                area: ['450px', '270px'],
                                                title:'退款信息',
                                            }, function(){//确认回调
                                                layer.closeAll();
                                                $.post("<?= Url::to(['travel-order/complete_refund'])?>", {
                                                    "PHPSESSID": "<?php echo session_id();?>",
                                                    "<?=Yii::$app->request->csrfParam?>": "<?=Yii::$app->request->getCsrfToken()?>",
                                                    "datatype":'json',
                                                    data: id
                                                }, function (msg) {
//                                                    console.log(msg);
                                                    var info = jQuery.parseJSON(msg);
//                                                    console.log(info);
                                                    if (info.code === '0') {
                                                        window.location.reload();
                                                    } else {
//                                                console.log(info.msg);
                                                        layer.alert(info.msg);
                                                    }
                                                });
                                            }, function(){//取消回调
                                            });
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

<!-- 审核订单 -->
<div class="modal fade" id="audit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    退款审核
                </h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="audit_refund" value="">
                审核状态：<span style="margin-left: 10px;"><input id="audit_y" name="audit_ssr" type="radio" checked="checked" value="y"/>&nbsp;同意退款 <input id="audit_n" name="audit_ssr" type="radio" style="margin-left: 15px;" value="n"/>&nbsp;拒绝退款</span>
                <input type="hidden" id="audit_note" value="y">
                <script>
                    $(function () {
                        $("#audit_y").click(function () {
                            $("#audit_note").val($("#audit_y").val());
                        });
                        $("#audit_n").click(function () {
                            $("#audit_note").val($("#audit_n").val());
                        });
                    });
                </script>
                <br><br>
                <span style="vertical-align: top">审核备注：</span><textarea name="" id="audit_content" cols="60" rows="5" maxlength="300" placeholder="最多不超过300字！"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-xs" id="audit_cl">
                    确定
                </button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" id="cancel">
                    取消
                </button>
            </div>
            <script>
                $(function () {
                    $("#cancel").click(function(){
                        $("#audit_content").val("");
                    });
                    $("#audit_cl").click(function () {
                        var audit_note = $("#audit_note").val();
                        var audit_content = $("#audit_content").val();
                        var id = $("#audit_refund").val();
                        $.ajax({
                            type:'get',
                            url:"<?= Url::to(['travel-order/audit'])?>?audit_note="+ audit_note +"&content="+ audit_content +"&id="+ id,
                            success: function (msg)
                            {
                                if (msg == 123) {
                                    window.location.reload();
                                }
                            }
                        })
                    });
                })
            </script>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<script>
    $('.audit').click(function () {
        $("#audit_refund").val($(this).attr("id"));
        $('#audit').modal();
    })
</script>


