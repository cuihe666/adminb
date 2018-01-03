<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\daterange\DateRangePicker;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BookingQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '总参团人列表';
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
                                <div class="search-item">
                                    <div class="input-group" style="width: 280px;">
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
                                    <div class="input-group" style="width: 280px;">
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
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeDropDownList($searchModel, 'pay_state',[1 => '已支付', 2 => '未支付'], ['class' => 'form-control', 'prompt' => '支付状态']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeDropDownList($searchModel, 'order_state',['s.3' => '已取消', 's.11' => '待支付', 's.21' => '已支付', 's.31' => '待确认', 's.32' => '已确认', 's.50' => '已完成', 'r.51' => '待退款', 'r.52' => '退款中', 'r.53' => '已退款', 'r.54' => '退款失败'], ['class' => 'form-control', 'prompt' => '订单状态']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 200px;margin-right: 5px;">
                                        <?= Html::activeInput('text', $searchModel, 'order_no', ['class' => 'form-control input', 'placeholder' => '请输入订单号']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 200px;margin-right: 5px;">
                                        <?= Html::activeInput('text', $searchModel, 'name', ['class' => 'form-control input', 'placeholder' => '请输入参团人姓名']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 200px;margin-right: 5px;">
                                        <?= Html::activeInput('text', $searchModel, 'idcard', ['class' => 'form-control input', 'placeholder' => '请输入证件号码']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 200px;margin-right: 5px;">
                                        <?= Html::activeInput('text', $searchModel, 'contact_name', ['class' => 'form-control input', 'placeholder' => '请输入联系人姓名']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 200px;margin-right: 5px;">
                                        <?= Html::activeInput('text', $searchModel, 'contact_mobile', ['class' => 'form-control input', 'placeholder' => '请输入联系人电话']) ?>
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
                            [//订单号
                                'attribute' => 'order_no',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return \backend\controllers\TravelOrderContactsController::actonOrder_no($model->order_id);
                                },
                            ],
                            [//联系人
                                'attribute' => 'contact_name',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return \backend\controllers\TravelOrderContactsController::actionContact_data($model->order_id, 'contact_name');
                                },
                            ],
                            [//联系电话
                                'attribute' => 'contact_mobile',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return \backend\controllers\TravelOrderContactsController::actionContact_data($model->order_id, 'contact_mobile');
                                },
                            ],
                            [//下单时间
                                'attribute' => 'create_time',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return \backend\controllers\TravelOrderContactsController::actionContact_data($model->order_id, 'create_time');
                                },
                            ],
                            [//体验日期
                                'attribute' => 'activity_date',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return \backend\controllers\TravelOrderContactsController::actionContact_data($model->order_id, 'activity_date');
                                },
                            ],
                            'name',//姓名
                            [//性别
                                'attribute' => 'sex',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return Yii::$app->params['sex'][$model->sex];
                                },
                            ],
                            [//证件类型
                                'attribute' => 'type',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return Yii::$app->params['IDcard_type'][$model->type];
                                },
                            ],
                            [//证件号码
                                'attribute' => 'idcard',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return ' '. $model->idcard;
                                },
                            ],
                            [//支付状态
                                'attribute' => 'pay_state',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return \backend\controllers\TravelOrderContactsController::actionPay_state($model->order_id);
                                },
                            ],
                            [//订单状态
                                'attribute' => 'order_state',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return \backend\controllers\TravelOrderContactsController::actionOrder_state($model->order_id);
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

