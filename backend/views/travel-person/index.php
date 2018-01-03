<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\daterange\DateRangePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BookingQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '个人信息';
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
                                <?= Html::beginForm(['travel-person/index'], 'get', ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal', 'id' => 'addForm']) ?>
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
                                        <?= Html::activeDropDownList($searchModel, 'status', [0 => '待审核',1=>'审核已通过', 2 => '未通过审核'], ['class' => 'form-control', 'prompt' => '按状态']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeInput('number', $searchModel, 'account', ['class' => 'form-control input', 'placeholder' => '按帐号', 'onkeyup' => "value=value.replace(/[^1234567890-]+/g,'')"]) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeInput('text', $searchModel, 'name', ['class' => 'form-control input', 'placeholder' => '按姓名']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeInput('text', $searchModel, 'nick_name', ['class' => 'form-control input', 'placeholder' => '按主页昵称']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeInput('text', $searchModel, 'card', ['class' => 'form-control input', 'placeholder' => '按身份证号查找']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeInput('text', $searchModel, 'mobile', ['class' => 'form-control input', 'placeholder' => '按电话查找']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::submitButton('搜索', ['class' => 'btn btn-sm btn-primary']) ?>&nbsp;
                                        <?= Html::a("清空",$url = ['travel-person/index'],$options = ['class' => 'btn btn-sm btn-primary']) ?>
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
                                    if ($model->uid) {
                                        return @ \backend\models\TravelPerson::getUser($model->uid)['mobile'];
                                    } else {
                                        return  '';
                                    }

                                }],
                            'name',
                            'nick_name',
                            ['attribute' => 'sex',
                                'header' => '性别',
                                'value' => function ($model) {

                                     if($model->sex == 0)
                                     {
                                         return '男';
                                     }
                                    if($model->sex == 1)
                                    {
                                        return '女';
                                    }

                                    if($model->sex == 2)
                                    {
                                        return '保密';
                                    }


                                }],
                            'card',
                            'mobile',


                            [
                                'class' => 'yii\grid\ActionColumn',
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
