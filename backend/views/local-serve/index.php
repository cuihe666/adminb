<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\daterange\DateRangePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BookingQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = '当地服务列表';
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

                                <?= Html::beginForm(['local-serve/index'], 'get', ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal', 'id' => 'addForm']) ?>
                                <div class="search-item" style="width: 200px;margin-right: 5px;">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeDropDownList($searchModel, 's', [3 => '审核中', 0 => '在售', 1 => '未售'], ['class' => 'form-control', 'prompt' => '请选择区域']) ?>
                                    </div>
                                </div>

                                <div class="search-item">
                                    <div class="input-group"
                                         style="width: 120px; float: left;margin-right: 18px;">

                                        <?= Html::activeDropDownList($searchModel, 'serve_type_id', ArrayHelper::map(\backend\models\LocalServe::getCategory(), 'id', 'name'), ['class' => 'form-control', 'prompt' => '服务类型']) ?>
                                    </div>
                                </div>

                                <div class="search-item">
                                    <div class="input-group" style="width: 180px; float: left;margin-right: 18px;">
                                        <?= Html::activeInput('text', $searchModel, 'serve_name', ['class' => 'form-control input', 'placeholder' => '按标题搜索']) ?>
                                    </div>
                                </div>

                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeInput('text', $searchModel, 'mobile', ['class' => 'form-control input', 'placeholder' => '按手机号搜索']) ?>
                                    </div>
                                </div>


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

                $gridColumns = ['id',
                    'user.mobile',
                    'serve_name',
                    'servicecategory.name',
                    ['header' => '服务方式',
                        'value' => function ($model) {
                            if ($model->serve_way == 0) {
                                return '免费';
                            }
                            if ($model->serve_way == 1) {
                                return '收费';
                            }


                        },],
                    'create_time',
                    'update_time',

                    ['header' => '审核状态',
                        'value' => function ($model) {
                            $array = [-1 => '保存状态', 0 => '在售', 1 => '未售', 2 => '待完善', 3 => '审核中', 4 => ' 审核未通过', 5 => '待提交'];
                            return $array[$model->status];

                            //                            if (in_array($model->status, $array)) {
                            //                                return $array[$model->status];
                            //                            } else {
                            //                                return '未定义';
                            //                            }


                        },],

                    ['class' => 'yii\grid\ActionColumn',
                        'header' => '操作',
                        'template' => '<div class="dropdown profile-element group-btn-edit">
                                    {view}
                                
                                 
                                </div> ',
                        'buttons' => ['view' => function ($url, $model, $key) {
                            return Html::a('查看', "$url", ['class' => 'delnode btn btn-primary btn-sm', 'style' => 'color:white']);
                        },],],];

                // Renders a export dropdown menu
                echo ExportMenu::widget(['dataProvider' => $dataProvider,
                    'columns' => $gridColumns]);

                // You can choose to render your own GridView separately
                // You can choose to render your own GridView separately
                echo GridView::widget(['dataProvider' => $dataProvider,
                    'columns' => $gridColumns,
                    'pager' => ['firstPageLabel' => '首页',
                        'lastPageLabel' => '尾页',],]);
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
