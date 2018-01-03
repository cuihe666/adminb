<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\daterange\DateRangePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BookingQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '房源列表';
$this->params['breadcrumbs'][] = $this->title;
?>

<script>
    function city(obj) {
        $.get("<?=Url::to(["house-details/getcity"])?>" + "&id=" + $(obj).val(), function (data) {
            $("#bank_city").html(data);
        });

    }

    function area(obj) {
        $.get("<?=Url::to(["house-details/getarea"])?>" + "&id=" + $(obj).val(), function (data) {
            $("#bank_area").html(data);
        });

    }

</script>

<div class="booking-index">

    <div class="wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox">
                    <div class="ibox-content" style="margin-bottom: 20px;">
                        <div class="search-box clearfix">

                            <div class="search-item">

                                <?= Html::beginForm(['house-details/index'], 'get', ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal', 'id' => 'addForm']) ?>
                                <div class="search-item">
                                    <div class="input-group" style="width: 200px; float: left;margin-right: 18px;">
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
                                                    'format' => 'Y-m-d'
                                                ]
                                            ]
                                        ]);

                                        ?>
                                    </div>
                                </div>

                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeInput('text', $searchModel, 'city_name', ['class' => 'form-control input', 'placeholder' => '按城市名搜索']) ?>
                                    </div>
                                </div>

                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeInput('text', $searchModel, 'title', ['class' => 'form-control input', 'placeholder' => '按房源标题搜索']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeInput('text', $searchModel, 'mobile', ['class' => 'form-control input', 'placeholder' => '按手机号搜索']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group"
                                         style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeDropDownList($searchModel, 'province', ArrayHelper::map(\backend\service\CommonService::get_province(), 'code', 'name'), ['class' => 'form-control', 'prompt' => '请选择省', 'onchange' => "city(this)"]) ?>
                                    </div>
                                </div>
                                <?php if (isset(Yii::$app->request->queryParams['HouseDetailsQuery']['province']) && Yii::$app->request->queryParams['HouseDetailsQuery']['province'] > 0): ?>
                                    <?php $city_id = Yii::$app->request->queryParams['HouseDetailsQuery']['province']; ?>

                                    <div class="search-item">
                                        <div class="input-group"
                                             style="width: 120px; float: left;margin-right: 18px;">
                                            <?= Html::activeDropDownList($searchModel, 'city', ArrayHelper::map(\backend\service\CommonService::get_city($city_id), 'code', 'name'), ['class' => 'form-control', 'prompt' => '请选择城市', 'id' => 'bank_city', 'onchange' => "area(this)"]) ?>
                                        </div>
                                    </div>

                                <?php else: ?>
                                    <div class="search-item">
                                        <div class="input-group"
                                             style="width: 120px; float: left;margin-right: 18px;">
                                            <?= Html::activeDropDownList($searchModel, 'city', [], ['class' => 'form-control', 'prompt' => '请选择城市', 'id' => 'bank_city', 'onchange' => "area(this)"]) ?>
                                        </div>
                                    </div>
                                <?php endif ?>

                                <?php if (isset(Yii::$app->request->queryParams['HouseDetailsQuery']['city']) && Yii::$app->request->queryParams['HouseDetailsQuery']['city'] > 0): ?>
                                    <?php $area_id = Yii::$app->request->queryParams['HouseDetailsQuery']['city']; ?>
                                    <div class="search-item">
                                        <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                            <?= Html::activeDropDownList($searchModel, 'area', ArrayHelper::map(\backend\service\CommonService::get_city($area_id), 'code', 'name'), ['class' => 'form-control', 'prompt' => '请选择区域', 'id' => 'bank_area']) ?>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="search-item">
                                        <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                            <?= Html::activeDropDownList($searchModel, 'area', [], ['class' => 'form-control', 'prompt' => '请选择区域', 'id' => 'bank_area']) ?>
                                        </div>
                                    </div>
                                <?php endif ?>


                                <div class="search-item">
                                    <div class="input-group" style="width: 280px; float: left;margin-right: 18px;">

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
                    'user.mobile',
                    'title',
                    ['attribute' => 'houseserach.city',
                        'value' => function ($model) {
                            return \backend\service\CommonService::get_city_name($model->houseserach['city']);
                            //                                                return $model->status;
                        },],
                    'houseserach.price',
                    'houseserach.comment_count',
                    'houseserach.tango_weight',
                    ['attribute' => 'houseserach.status',
                        'value' => function ($model) {

                            return Yii::$app->params['house_status'][$model->houseserach['status']];
                        }],

                    ['class' => 'yii\grid\ActionColumn',
                        'header' => '操作',
                        'template' => '<div class="dropdown profile-element group-btn-edit">
                                    {view}
                                    {showpic}
                                </div> ',
                        'buttons' => [
                            'view' => function ($url, $model, $key) {
                                return Html::a('查看', "$url", ['class' => 'delnode btn btn-primary btn-sm', 'style' => 'color:white']);
                            },

                            'showpic' => function ($url, $model, $key) {
                                return Html::a('修改首图', "$url", ['class' => 'delnode btn btn-primary btn-sm', 'style' => 'color:white']);
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
<style>
    tr, th {
        text-align: center;
    }

    .pagination {
        float: right;
    }

</style>
