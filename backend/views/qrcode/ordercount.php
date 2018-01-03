<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\daterange\DateRangePicker;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BookingQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '订单统计';
$this->params['breadcrumbs'][] = $this->title;

?>
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/css/common.min.css">
<style>
    <!--
    .wrapper-content {
        margin-top: 10px;
    }

    .hr-border {
        background-color: green;
        height: 2px;
        border: none;
        margin: 0;
    }

    .qrcode_div {
        margin-bottom: 20px;
    }

    .qrcode_div .qrcode_title { /* margin-top:20px;*/
        border-bottom: 1px solid #666;
        heigh: 38px;
        line-height: 38px;
        font-weight: bold;
        color: #000;
    }

    .qrcode_info {
        width: 80%;
        overflow: hidden;
        line-height: 32px;
        border-bottom: 1px solid #ccc;
    }

    .qrcode_info p {
        line-height: 32px;
    }

    .qrcode_info p span {
        display: inline-block
    }

    .qrcode_info .qrcode_p1 {
        width: 30%;
        float: left;
    }

    .qrcode_info .qrcode_p2 {
        width: 50%;
        float: left;
    }

    .qrcode_info .qrcode_p3 .qrcode_label {
        width: 12%;
    }

    .qrcode_info p .qrcode_label {
        width: 40%;
        text-align: right;
        font-weight: normal;
    }

    .btn-primary {
        margin-right: 10px;
    }

    .search-box {
        margin-top: 0;
        margin-bottom: 20px;
    }

    .ibox-content {
        margin-top: 0;
    }

    .form-horizontal {
        overflow: hidden;
    }

    -->
</style>
<hr class="hr-border">
<div class="booking-index" style="padding:0;">
    <div class="wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12" style="padding-left: 0; padding-right: 0;">
                <div class="ibox">
                    <div class="qrcode_div">
                        <h4 class="qrcode_title">二维码信息</h4>
                        <div class="qrcode_info">
                            <p class="qrcode_p1">
                                <label class="qrcode_label">活动主题：</label>
                                <span><?= \backend\models\Qrcode::getActiveTheme()[$model->theme_id]; ?></span>
                            </p>
                            <p class="qrcode_p2">
                                <label class="qrcode_label">城市：</label>
                                <span><?= \backend\models\Qrcode::getRegionName($model->city_code); ?></span>
                            </p>
                        </div>
                        <div class="qrcode_info">
                            <p class="qrcode_p3">
                                <label class="qrcode_label">二维码url：</label>
                                <span><?= $model->qrcode_url; ?></span>
                            </p>
                        </div>
                        <div class="qrcode_info">
                            <p class="qrcode_p3">
                                <label class="qrcode_label">二维码扫描量：</label>
                                <span><?= $model->scan_num; ?></span>
                            </p>
                        </div>
                        <div class="qrcode_info">
                            <p class="qrcode_p0" style="width:30%; float: left;">
                                <label class="qrcode_label">总下单量：</label>
                                <span><?= $orderCount; ?>【单】</span>
                            </p>
                            <p class="qrcode_p1" style="width:30%;">
                                <label class="qrcode_label">支付成功订单量：</label>
                                <span><?= $orderCountSu; ?>【单】</span>
                            </p>
                            <!--<p class="qrcode_p2" style="width:30%;">
                                <label class="qrcode_label">首单使用优惠券量：</label>
                                <span><?/*= $orderCountFirst; */?>【单】</span>
                            </p>-->
                        </div>
                        <div class="qrcode_info">
                            <p class="qrcode_p3">
                                <label class="qrcode_label">二维码：</label>
                                <span><img
                                        src="<?= \yii\helpers\Url::to(['qrcode/buildqrcode', 'url' => $model->qrcode_url]) ?>"/></span>
                            </p>
                        </div>
                    </div>
                    <hr class="hr-border">

                    <div class="ibox-content" style="margin-bottom: 20px;">
                        <div class="search-box clearfix">
                            <div class="search-item">
                                <?= Html::beginForm('', 'post', ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal', 'id' => 'addForm']) ?>

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
                                        <?= Html::activeDropDownList($searchModel, 'pay_platform', Yii::$app->params['pay_type'], ['class' => 'form-control', 'prompt' => '支付方式']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeDropDownList($searchModel, 'close_account', Yii::$app->params['close_account'], ['class' => 'form-control', 'prompt' => '结算状态']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeDropDownList($searchModel, 'pay_state', Yii::$app->params['pay_status'], ['class' => 'form-control', 'prompt' => '支付状态']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeDropDownList($searchModel, 'state', ['s.3' => '已取消', 's.11' => '待支付', 's.21' => '已支付', 's.31' => '待确认', 's.32' => '已确认', 's.50' => '已完成', 'r.51' => '待退款', 'r.52' => '退款中', 'r.53' => '已退款', 'r.54' => '退款失败'], ['class' => 'form-control', 'prompt' => '订单状态']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeDropDownList($searchModel, 'is_confirm', Yii::$app->params['is_confirm'], ['class' => 'form-control', 'prompt' => '订单类型']) ?>
                                    </div>
                                </div>
                                <!--<div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                        <?/*= Html::activeDropDownList($searchModel, 'is_first', Yii::$app->params['is_status'], ['class' => 'form-control', 'prompt' => '是否为首单']) */?>
                                    </div>
                                </div>-->
                                <div class="search-item">
                                    <div class="input-group" style="width: 200px;margin-right: 5px;">
                                        <?= Html::activeInput('text', $searchModel, 'mobile_phone', ['class' => 'form-control input', 'placeholder' => '请输入用户手机号']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 200px;margin-right: 5px;">
                                        <?= Html::activeInput('text', $searchModel, 'order_no', ['class' => 'form-control input', 'placeholder' => '请输入订单号']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 200px;margin-right: 5px;">
                                        <?= Html::activeInput('text', $searchModel, 'contacts', ['class' => 'form-control input', 'placeholder' => '请输入用户名']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 200px;margin-right: 5px;">
                                        <?= Html::activeInput('text', $searchModel, 'travel_name', ['class' => 'form-control input', 'placeholder' => '请输入商品名称']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 330px;margin-right: 5px;">
                                        <?= Html::submitButton('搜索', ['class' => 'btn btn-sm btn-primary']) ?>
                                        <?= Html::a("清空", $url = ['qrcode/ordercount?id=' . $id], $options = ['class' => 'btn btn-sm btn-primary', "style" => "line-height:30px;"]) ?>
                                        <?= Html::a("返回列表", $url = ['qrcode/index'], $options = ['class' => 'btn btn-sm btn-primary', "style" => "line-height:30px;"]) ?>
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
                                    return $model->contacts . '/' . $model->mobile_phone;
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
                                    if($model->type==2){
                                        return ($model->anum);
                                    }
                                    elseif($model->type==3){
                                        return ($model->adult + $model->child);
                                    }
                                },
                            ],
                            [//总金额
                                'attribute' => 'total',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return '￥' . $model->total;
                                },
                            ],
                            [//优惠券金额
                                'header' => '优惠金额',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->is_first == 1 ? '￥20.00' : '￥' . $model->coupon_amount;
                                },
                            ],
                            [//实付金额
                                'attribute' => 'pay_amount',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return '￥' . $model->pay_amount;
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
                                    //return Yii::$app->params['status_order'][$model->state];
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
                            /*[//是否首单
                                'attribute' => 'is_first',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return Yii::$app->params['is_status'][$model->is_first];
                                },
                            ],*/
                            [//结算状态
                                'attribute' => 'close_account',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return Yii::$app->params['close_account'][$model->close_account];
                                },
                            ],

                            /*[
                                'class' => 'yii\grid\ActionColumn',
                                'header' => '操作',
                                'template' => '<div style="width: 50px; text-align: center;">
                            {view}
                          </div> ',
                                'buttons' => [
                                    'view' => function ($url, $model, $key) {
                                        return Html::a('查看', ['travel-order/view', 'id' => $key,'qrcodeid'=>Yii::$app->request->queryParams[id]], ['class' => '', 'style' => 'color:navy']);
                                    },

                                ],
                            ],*/


                        ];

                        // Renders a export dropdown menu
                        echo ExportMenu::widget([
                            'dataProvider' => $dataProvider
                            , 'columns' => $gridColumns
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
                                        data: {"id": id, "status": name}
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

