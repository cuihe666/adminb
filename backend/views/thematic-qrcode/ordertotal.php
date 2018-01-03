<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\daterange\DateRangePicker;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BookingQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */


$thematicQrcodeCustomParams = isset($thematicQrcodeInfo['custom_params']) ? $thematicQrcodeInfo['custom_params'] : '';
$thematicQrcodeCustomParams=='default' && ( $thematicQrcodeCustomParams='默认' );

$this->title = '订单统计-'.$thematicQrcodeCustomParams;
$this->params['breadcrumbs'][] = $this->title;

?>
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/css/common.min.css">
<script src="<?= Yii::$app->request->baseUrl ?>/js/jquery.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/layer.js"></script>
<style>
    .btn-group, .btn-group-vertical {
        margin-top: 10px;
    }

    .btn-primary {
        margin-right: 0;
    }

    #top_select ul li {
        float: left;
        margin-left: 30px;
        height: 40px;
        width: 156px;
    }

    #top_select ul {
        margin-left: -25px;
    }

    .top_select {
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

    input[type="number"] {
        -moz-appearance: textfield;
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
                                <?= Html::beginForm($refreshUrl, 'get', ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal', 'id' => 'addForm']) ?>
                                <div class="search-item">
                                    <div class="input-group" style="width: 280px;">
                                        <?php
                                        echo DateRangePicker::widget([
                                            'model' => $searchModel,
                                            'attribute' => 'activity_date',
                                            'convertFormat' => true,
                                            'language' => 'zh-CN',
                                            'options' => [
                                                'placeholder' => '请输入体验时间',
                                                'class' => 'form-control',
                                                'readonly' => true,
                                            ],
                                            'pluginOptions' => [
                                                'timePicker' => false,
                                                'timePickerIncrement' => 30,
                                                'locale' => [
                                                    'format' => 'Y-m-d',
                                                    //'separator' => '~',
                                                ]
                                            ]
                                        ]);

                                        ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 280px;">
                                        <?php
                                        echo DateRangePicker::widget([
                                            'model' => $searchModel,
                                            'attribute' => 'create_time',
                                            'convertFormat' => true,
                                            'language' => 'zh-CN',
                                            'options' => [
                                                'placeholder' => '请输入下单时间',
                                                'class' => 'form-control',
                                                'readonly' => true,
                                            ],
                                            'pluginOptions' => [
                                                'timePicker' => false,
                                                'timePickerIncrement' => 30,
                                                'locale' => [
                                                    'format' => 'Y-m-d',
                                                    //'separator' => '~',
                                                ]
                                            ]
                                        ]);

                                        ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeDropDownList($searchModel, 'theme_tag', \backend\controllers\TravelOrderController::actionCity_code(), ['class' => 'form-control', 'prompt' => '搜索城市']) ?>
                                    </div>
                                </div>
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
                                        <?= Html::activeDropDownList($searchModel, 'state', ['s.3' => '已取消', 's.11' => '待支付', 's.21' => '已支付', 's.31' => '待确认', 's.32' => '已确认', 's.50' => '已完成', 'r.51' => '待退款', 'r.52' => '退款中', 'r.53' => '已退款', 'r.54' => '退款失败'], ['class' => 'form-control', 'prompt' => '订单状态']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeDropDownList($searchModel, 'is_confirm', [1 => '无需确认', 2 => '需要确认'], ['class' => 'form-control', 'prompt' => '订单类型']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeDropDownList($searchModel, 'pay_state',['1' => '未支付', '2' => '已支付'], ['class' => 'form-control', 'prompt' => '支付状态']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 200px;margin-right: 5px;">
                                        <?= Html::activeInput('number', $searchModel, 'travel_id', ['class' => 'form-control input', 'placeholder' => '请输入商品ID']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 200px;margin-right: 5px;">
                                        <?= Html::activeInput('number', $searchModel, 'user_mobile', ['class' => 'form-control input', 'placeholder' => '请输入用户手机号']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 200px;margin-right: 5px;">
                                        <?= Html::activeInput('text', $searchModel, 'order_no', ['class' => 'form-control input', 'placeholder' => '请输入订单号']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 200px;margin-right: 5px;">
                                        <?= Html::activeInput('text', $searchModel, 'user_name', ['class' => 'form-control input', 'placeholder' => '请输入用户名']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 200px;margin-right: 5px;">
                                        <?= Html::activeInput('text', $searchModel, 'travel_name', ['class' => 'form-control input', 'placeholder' => '请输入商品名称']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 200px;margin-right: 5px;">
                                        <?= Html::activeInput('text', $searchModel, 'travel_account', ['class' => 'form-control input', 'placeholder' => '请输入发布账号']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 200px;margin-right: 5px;">
                                        <?= Html::activeDropDownList($searchModel, 'theme_type', [0 => 'App', 1 => 'H5活动'], ['class' => 'form-control', 'prompt' => '订单来源']) ?>
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
                            [//发布账号
                                'attribute' => '发布账号',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return \backend\controllers\TravelOrderController::actionUser_info($model->travel_uid);;
                                },
                            ],
                            'travel_name',//商品名称
                            'travel_id',
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
                                'value' => function ($model) use($thematicQrcodeInfo) {
                                    if ($model->type == 2) {//当地活动
                                        return "<a href=".Url::toRoute(['thematic-qrcode/ordercontact','oid'=>$model->id,'custom'=>$thematicQrcodeInfo['custom_params']])." class='total_person' id='" . $model->id . "'>" . ($model->anum) . "</a>";
                                    } else if ($model->type == 3) {//主题higo
                                        return "<a href=".Url::toRoute(['thematic-qrcode/ordercontact','oid'=>$model->id,'custom'=>$thematicQrcodeInfo['custom_params']])." class='total_person' id='" . $model->id . "'>" . ($model->adult + $model->child) . "</a>";
                                    }
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
                            [//订单来源
                                'attribute' => '订单来源',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->theme_type==0 ? "App" : "H5活动";
                                },
                            ],
                            //操作
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
                                'prevPageLabel' => '上一页',
                                'nextPageLabel' => '下一页',
                            ],
                        ]);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

