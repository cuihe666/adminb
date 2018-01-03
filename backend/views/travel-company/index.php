<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\daterange\DateRangePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BookingQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '公司信息';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="booking-index">
    <div class="wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox">
                    <div class="ibox-content" style="margin-bottom: 20px;">
                        <div class="search-box clearfix">
                            <div class="search-item">
                                <?= Html::beginForm(['travel-company/index'], 'get', ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal', 'id' => 'addForm']) ?>
                                <div class="search-item">
                                    <div class="input-group" style="width: 200px; float: left;margin-right: 18px;">
                                        <?php
                                        echo DateRangePicker::widget([
                                            'model' => $searchModel,
                                            'attribute' => 'start_time',
                                            'convertFormat' => true,
                                            'language' => 'zh-CN',
                                            'options' => [
                                                'placeholder' => '请选择上传时间',
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
                                        <?= Html::activeDropDownList($searchModel, 'status', [0 => '待审核', 1 => '审核已通过', 2 => '未通过审核'], ['class' => 'form-control', 'prompt' => '状态']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeInput('number', $searchModel, 'account', ['class' => 'form-control input', 'placeholder' => '按帐号查找', 'onkeyup' => "value=value.replace(/[^1234567890-]+/g,'')"]) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 150px; float: left;margin-right: 18px;">
                                        <?= Html::activeDropDownList($searchModel, 'reg_local', [1 => '大陆', 2 => '海外及港澳台'], ['class' => 'form-control', 'prompt' => '公司注册地']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 150px; float: left;margin-right: 18px;">
                                        <?= Html::activeDropDownList($searchModel, 'group_type', [1 => '旅行社', 2 => '非旅行社'], ['class' => 'form-control', 'prompt' => '类型']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeInput('text', $searchModel, 'name', ['class' => 'form-control input', 'placeholder' => '按公司名称查找']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group"  style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::submitButton('搜索', ['class' => 'btn btn-sm btn-primary']) ?>&nbsp;
                                        <?= Html::a("清空",$url = ['travel-company/index'],$options = ['class' => 'btn btn-sm btn-primary']) ?>
                                    </div>
                                </div>
                                <?= Html::endForm() ?>
                            </div>
                        </div>


                        <?php
                        use kartik\export\ExportMenu;

                        $gridColumns = [

                            ['class' => 'yii\grid\SerialColumn',
                                'header' => '序号'],
                            'create_time',
                            ['attribute' => 'account',
                                'header' => '帐号',
                                'value' => function ($model) {

                                    return \backend\models\TravelPerson::getUser($model->uid)['mobile'];
                                }],
                            'name',
                            ['header' => '主页品牌名称',
                                'value' => function ($model) {

                                    if ($model->brandname) {
                                        return $model->brandname;
                                    } else {
                                        return '暂未设置';
                                    }
                                }

                            ],
                            ['header' => '公司注册地',
                                'value' => function ($model) {

                                    if (in_array($model->reg_addr_type, [1])) {
                                        return '中国大陆';
                                    }

                                    if (in_array($model->reg_addr_type, [2, 3, 4])) {
                                        return '海外及港澳台';
                                    }
                                    return '暂未设置';

                                }

                            ],
                            ['header' => '类型',
                                'value' => function ($model) {
                                    if ($model->group_type == 1) {
                                        return '旅行社';
                                    }
                                    if ($model->group_type == 2) {
                                        return '非旅行社';
                                    }

                                }

                            ],


                            ['class' => 'yii\grid\ActionColumn',
                                'header' => '操作',
                                'template' => '<div>
                                  {view}
                                </div> ',
                                'buttons' => [
                                    'view' => function ($url, $model, $key) {
                                        return Html::a($model->status == 0 ? '审核' : '查看', $url, ['class' => 'btn btn-info']);

                                    },

                                ],
                            ],


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
