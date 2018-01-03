<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\daterange\DateRangePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\editable\Editable;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\HouseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = '批量下架房源列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="booking-index">
    <div class="wrapper-content animated fadeInRight">

        <div class="row">
            <?php echo Html::a("返回房源列表页", Url::to(['house-details/index']), ["class" => "btn btn-primary"]) ?>
            <div class="col-sm-12">
                <?php
                use kartik\export\ExportMenu;
                $gridColumns = [
                    [
                        "class" => 'yii\grid\CheckboxColumn',
                        "name" => "id",
                    ],
                    'id',
                    ['attribute' => 'user.mobile',
                        'header' => '房东帐号',
                        'format' => 'raw',
                        'value' => function ($model) {
                            //超链接
                            return Html::a($model->user['mobile'], ['house-details/userview', 'id' => $model->uid]);
                        },
                    ],
                    [
                        'header' => '标题',
                        'format' => 'raw',
                        'value' => function ($model) {
                            //超链接
                            return Html::a($model->title, ['house-details/view', 'id' => $model->id]);
                        },
                    ],
                    ['attribute' => 'houseserach.city',
                        'value' => function ($model) {
                            return \backend\service\CommonService::get_city_name($model->houseserach['city'] ? $model->houseserach['city'] : $model->houseserach['province']);
                        },],
                    'houseserach.price',
                    'houseserach.comment_count',
                    [
                        'attribute' => 'tango_weight',
                        'headerOptions' => ['width' => '20px'],
                        'value' => 'houseserach.tango_weight',
                        'class' => 'kartik\grid\EditableColumn',
                        'options' => ['class' => 'form-control',],
                        'editableOptions' => [
                            'asPopover' => true,
                            'buttonsTemplate' => '{submit}',
                            'submitButton' => [
                                'icon' => '<span class="">保存</span>'
                            ],
                            'formOptions' => [
                            ],
                        ],
                    ],
                    ['attribute' => 'houseserach.status',
                        'value' => function ($model) {
                            if ($model->houseserach['status'] == 1 && $model->houseserach['online'] == 0) {
                                return '已下架';
                            }

                            if ($model->houseserach['status'] == -1) {
                                return '待完善';
                            }

                            if ($model->houseserach['status'] == 1 && $model->houseserach['online'] == 1) {
                                return '已上架';
                            }
                            if ($model->houseserach['status'] == 0) {
                                return '待审核';
                            }
                            if ($model->houseserach['status'] == 3) {
                                return '未通过';
                            }
                            if ($model->houseserach['status'] == 4) {
                                return '待提交';
                            }

                        }],

                    'create_time',
                    'update_date',
                    'salesman',

                    ['attribute' => 'check_time',
                        'header' => '审核时间',
                        'value' => function ($model) {

                            return $model->check_time ? $model->check_time : '暂无';
                        }],


                    ['attribute' => 'up_type',
                        'header' => '上传方式',
                        'value' => function ($model) {

                            return Yii::$app->params['up_type'][$model->up_type];
                        }],


                    ['class' => 'yii\grid\ActionColumn',
                        'header' => '操作',
                        'template' => '<div class="dropdown profile-element group-btn-edit">
                                    {view}
                                    {showpic}
                                    {update-one}
                                </div> ',
                        'buttons' => [
                            'view' => function ($url, $model, $key) {
                                return Html::a('查看', "$url", ['class' => 'delnode btn btn-primary btn-sm', 'style' => 'color:white']);
                            },

                            'showpic' => function ($url, $model, $key) {
                                return Html::a('修改首图', "$url", ['class' => 'delnode btn btn-primary btn-sm', 'style' => 'color:white']);
                            },
                            'update-one' => function ($url, $model, $key) {
//                                return Html::a('修改房源', "$url", ['class' => 'delnode btn btn-primary btn-sm', 'style' => 'color:white']);
                                return Html::a('修改房源', ['house/update-one', 'house_id' => $key], ['class' => 'delnode btn btn-primary btn-sm', 'style' => 'color:white']);
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
                    'export' => false,

                    'dataProvider' => $dataProvider,
                    "options" => ["class" => "grid-view", "style" => "overflow:auto", "id" => "grid"],
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
<style>
    tr, th {
        text-align: center;
    }

    .pagination {
        float: right;
    }

</style>