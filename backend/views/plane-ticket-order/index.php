<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PlaneTicketOrderQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */

if (isset($action)) {
    if ($action == 'post') {
        $this->title = '邮寄行程单管理';
    } else if ($action == 'index'){
        $this->title = '机票订单管理';
    } else if ($action == 'abnormal'){
        $this->title = '异常订单管理';
    }else {
        $this->title = '机票订单管理';
    }
} else {
    $this->title = '异常订单管理';
}
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .search-model{
        float: left;
        padding-left: 10px;
        margin-top: 8px;
    }
    #top_select ul li {
        float: left;
        margin-left: 30px;
        height: 40px;
        width: 156px;
        list-style:none;
    }

    #top_select ul {
        margin-left: -75px;
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
<div class="row" <?= ($action == 'abnormal')?'':'style="display:none"'?>>
    <div class="col-xs-12">
        <div class="col-xs-12 table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <div class="search-item" id="top_select">
                    <ul>
                        <li><a href="<?= \yii\helpers\Url::to(['plane-ticket-order/abnormal']) ?>?note=two"
                               class='btn btn-sm btn-primary top_select' <?= $top_css == 'two' ? "style='background: teal;'" : ''; ?>>出票超时</a>
                        </li>
                        <li><a href="<?= \yii\helpers\Url::to(['plane-ticket-order/abnormal']) ?>?note=three"
                               class='btn btn-sm btn-primary top_select' <?= $top_css == 'three' ? "style='background: teal;'" : ''; ?>>退款失败</a>
                        </li>
                        <li><a href="<?= \yii\helpers\Url::to(['plane-ticket-order/abnormal']) ?>?note=four"
                               class='btn btn-sm btn-primary top_select' <?= $top_css == 'four' ? "style='background: teal;'" : ''; ?>>出票失败</a>
                        </li>
                        <!-- 大交通1.1 ys -->
                        <li><a href="<?= \yii\helpers\Url::to(['plane-ticket-order/abnormal']) ?>?note=five"
                               class='btn btn-sm btn-primary top_select' <?= $top_css == 'five' ? "style='background: teal;'" : ''; ?>>已出票未出保</a>
                        </li>
                        <li><a href="<?= \yii\helpers\Url::to(['plane-ticket-order/abnormal']) ?>?note=six"
                               class='btn btn-sm btn-primary top_select' <?= $top_css == 'six' ? "style='background: teal;'" : ''; ?>>已退票未退保</a>
                        </li>
                    </ul>
                </div>
            </table>
        </div>
    </div>
    <!-- /.col -->
</div>
<div class="plane-ticket-order-index" style="overflow-x: scroll;">
    <div class="search-box clearfix" style="padding-bottom: 10px;">
        <div class="search-item">
            <?= Html::beginForm(['plane-ticket-order/'.$action], 'get', ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal']) ?>
            <input type="hidden" name="note" value="<?= isset($top_css)?$top_css:''?>">
            <div class="search-item" style="float: left; margin-top: 8px;">
                <div class="input-group">
                    <?= Html::activeInput('text', $searchModel, 'order_no', ['class' => 'form-control input', 'placeholder' => '请输入订单号']) ?>
                </div>
            </div>
            <div class="search-item search-model">
                <div class="input-group">
                    <?= Html::activeInput('text', $searchModel, 'contacts', ['class' => 'form-control input', 'placeholder' => '请输入联系人姓名']) ?>
                </div>
            </div>
            <div class="search-item search-model">
                <div class="input-group">
                    <?= Html::activeInput('number', $searchModel, 'contacts_phone', ['class' => 'form-control input', 'placeholder' => '请输入联系人手机号']) ?>
                </div>
            </div>
            <div class="search-item search-model">
                <div class="input-group">
                    <?= Html::activeInput('text', $searchModel, 'ticket_note', ['class' => 'form-control input', 'placeholder' => '请输入票号']) ?>
                </div>
            </div>
            <div class="search-item search-model">
                <div class="input-group">
                    <?= Html::activeInput('text', $searchModel, 'emplane_name', ['class' => 'form-control input', 'placeholder' => '请输入乘机人姓名']) ?>
                </div>
            </div>
            <div class="search-item search-model" <?= ($action == 'index')?'':'style="display:none"'?>>
                <div class="input-group">
                    <?= Html::activeDropDownList($searchModel, 'process_status', Yii::$app->params['plane_ticket_backend_status'], ['class' => 'form-control', 'prompt' => '订单状态']) ?>
                </div>
            </div>
            <div class="search-item search-model" <?= ($action == 'index')?'':'style="display:none"'?>>
                <div class="input-group">
                    <?= Html::activeDropDownList($searchModel, 'ys_insurance_status', \backend\controllers\traits\PlaneTicketInfo::InsuranceSelectOptions(), ['class' => 'form-control', 'prompt' => '保险状态']) ?>
                </div>
            </div>
            <div class="search-item search-model">
                <div class="input-group">
                    <?= Html::activeDropDownList($searchModel, 'supplier_name', isset($list_info)?$list_info:'', ['class' => 'form-control', 'prompt' => '查询机票供应商']) ?>
                </div>
            </div>
            <?php if ($action == 'post') {?>
            <!-- 快递公司 -->
            <div class="search-item search-model">
                <div class="input-group">
                    <?= Html::activeDropDownList($searchModel, 'express_id', isset($express_list)?$express_list:'', ['class' => 'form-control', 'prompt' => '查询快递公司']) ?>
                </div>
            </div>
            <!-- 邮寄单号 -->
            <div class="search-item search-model">
                <div class="input-group">
                    <?= Html::activeInput('text', $searchModel, 'express_code', ['class' => 'form-control input', 'placeholder' => '请输入邮寄单号']) ?>
                </div>
            </div>
            <!-- 邮寄状态 -->
            <div class="search-item search-model">
                <div class="input-group">
                    <?= Html::activeDropDownList($searchModel, 'express_status', [1 => '已邮寄', 2 => '未邮寄'], ['class' => 'form-control', 'prompt' => '邮寄状态']) ?>
                </div>
            </div>
            <?php }?>
            <div class="search-item search-model">
                <div class="input-group">
                    <?php
                    echo \kartik\daterange\DateRangePicker::widget([
                        'model' => $searchModel,
                        'attribute' => 'order_create_time',
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
                                'format' => 'Y-m-d'
                            ]
                        ]
                    ]);
                    ?>
                </div>
            </div>
            <div class="search-item search-model">
                <div class="input-group">
                    <?= Html::submitButton('搜索', ['class' => 'btn btn-sm btn-primary']) ?>
                </div>
            </div>
            <?= Html::endForm() ?>
        </div>
    </div>
    <?php
    $gridColumns = [
        ['class' => 'yii\grid\SerialColumn', 'header' => '序号'],
        'order_no',//订单号
        [
            'label' => '第三方单号',
            'value' => function ($model) {
                return \backend\controllers\PlaneTicketOrderController::GetOtherTradeOrderNo($model->id);
            }
        ],
        'create_time',//生单时间
        'payment_time',//支付时间
        'total_amount',//订单总金额
        [
            'label' => '单价 × 数量',
            'value' => function ($model) {
                return ($model->emplane[0]->total_amount.' × '.$model->guest_num);
            }
        ],
        [
            'label' => '起始 -> 终点',
            'value' => function ($model) {
                return (\backend\models\PlaneTicketOrder::CityName($model->city_start_code).' - '.\backend\models\PlaneTicketOrder::CityName($model->city_end_code));
            }
        ],
        [
            'label' => '航空公司',
            'value' => function($model) {
                return $model->company->name;
            }
        ],
        'flight_number',
        [
            'label' => '起飞机场 - 降落机场',
            'value' => function($model) {
                return ($model->fly_start_airport.$model->fly_start_jetquay.' - '.$model->fly_end_airport.$model->fly_end_jetquay);
            }
        ],
        [
            'label' => '起飞时间 / 降落时间',
            'value' => function($model) {
                return ($model->fly_start_time.' / '.$model->fly_end_time);
            }
        ],
        [
            'label' => '乘机人',
            'value' => function ($model) {
                if (!empty($model->emplane)) {
                    $emplane_str = '';
                    for ($i = 0; $i < count($model->emplane); $i++) {
                        $emplane_str .= '/'.$model->emplane[$i]->name;
                    }
                    return trim($emplane_str, '/');
                } else {
                    return '';
                }
            }
        ],
        [
            'label' => '状态',
            'value' => function($model){
                return Yii::$app->params['plane_ticket_backend_show_status'][$model->process_status];
            }
        ],
        [
            'label' => '投保状态',
            'value' => function($model){
                return \backend\controllers\PlaneTicketOrderController::JudgeOrderInsuranceStatus($model->id);
            }
        ],
        [
            'label' => '邮递公司',
            'visible' => ($action == 'post')?true:false,
            'value' => function($model) {
                return \backend\controllers\PlaneTicketOrderController::PostName($model->express_id);
            }
        ],
        [
            'label' => '邮递单号',
            'visible' => ($action == 'post')?true:false,
            'value' => function($model) {
                return $model->express_code;
            }
        ],
        [
            'label' => '邮递状态',
            'visible' => ($action == 'post')?true:false,
            'value' => function($model) {
                if (empty($model->express_code)) {
                    return '未邮寄';
                } else {
                    return '已邮寄';
                }
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => '操作',
            'template' => '<div class="dropdown profile-element group-btn-edit">
                                    {look}
                                    {handle}
                                </div> ',
            'buttons' => [
                'look' => function ($url, $model, $key) {
                    return Html::a('查看详情', "#", ['class' => 'delnode  btn-primary btn-sm look_order_detail', 'style' => 'color:white', 'MyAttr'=> $model->id]);
                },
                'handle' => function ($url, $model, $key) {
                    return Html::a('操作', "#", ['class' => 'delnode  btn-primary btn-sm handle_order_detail', 'style' => 'color:white', 'MyAttr'=> $model->id]);
                },
            ]
        ],
    ];
    ?>
    <?php
    echo \kartik\export\ExportMenu::widget([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumns,
    ]);
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumns,
        'pager' => [
            'firstPageLabel' => '首页',
            'lastPageLabel' => '尾页',
        ],
    ]); ?>
    <input type="hidden" id="jump_note" value="<?= isset($action)?$action:''?>">
</div>
<script>
$(".look_order_detail").click(function () {
    var id = $(this).attr("MyAttr");
    var action = $("#jump_note").val();
    location.href = "<?= \yii\helpers\Url::to(['plane-ticket-order/detail'])?>?oid="+id+"&action="+action;
});
$(".handle_order_detail").click(function () {
    var id = $(this).attr("MyAttr");
    var action = $("#jump_note").val();
    location.href = "<?= \yii\helpers\Url::to(['plane-ticket-order/detail'])?>?oid="+id+"&note=handle&action="+action;
});
</script>
