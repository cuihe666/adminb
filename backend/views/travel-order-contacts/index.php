<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\daterange\DateRangePicker;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BookingQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '参团人列表';
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
                                    <div class="input-group" style="width: 200px;margin-right: 5px;">
                                        <?= Html::activeInput('text', $searchModel, 'name', ['class' => 'form-control input', 'placeholder' => '请输入用户名']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 200px;margin-right: 5px;">
                                        <?= Html::activeInput('text', $searchModel, 'idcard', ['class' => 'form-control input', 'placeholder' => '请输入证件号码']) ?>
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
                            'idcard',//证件号码
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

