<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\daterange\DateRangePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BookingQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户统计';
?>
<!--<link rel="stylesheet" href="<?/*= Yii::$app->request->baseUrl */?>/css/common.min.css">-->
<style>
    <!--
    .hr-border{background-color:green;height:2px;border:none; margin: 0;}
    .qrcode_div{ margin-bottom: 20px;}
    .qrcode_div .qrcode_title{ margin-top:20px; border-bottom: 1px solid #666; heigh:38px; line-height:38px; font-weight:bold;}
    .qrcode_info{ width:80%; overflow: hidden; line-height: 38px; border-bottom:1px solid #ccc;}
    .qrcode_info p{ line-height: 38px; margin-bottom: 0;}
    .qrcode_info p span{ display: inline-block}
    .qrcode_info .qrcode_p1{ width:30%; float: left;}
    .qrcode_info .qrcode_p2{ width:50%; float: left;}
    .qrcode_info .qrcode_p3 .qrcode_label{ width: 12%;}
    .qrcode_info p .qrcode_label{ width:40%; text-align: right; font-weight:normal;}
    -->
</style>
<hr class="hr-border">
<div class="booking-index">
    <div class="wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12"> <!--style="padding-left: 0; padding-right: 0;"-->
                <div class="ibox">
                    <!--<div class="ibox-title"><h5>用户列表</h5></div>-->
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
                        </div> <div class="qrcode_info">
                            <p class="qrcode_p1">
                                <label class="qrcode_label">新增用户总量：</label>
                                <span><?= $userCount; ?>【个】</span>
                            </p>
                        </div>
                        <div class="qrcode_info">
                            <p class="qrcode_p3">
                                <label class="qrcode_label">二维码：</label>
                                <span><img src="<?= \yii\helpers\Url::to(['qrcode/buildqrcode','url' => $model->qrcode_url])?>" /></span>
                            </p>
                        </div>
                    </div>
                    <hr class="hr-border" style="margin-bottom: 20px;">
                    <div class="ibox-content" style="margin-bottom: 20px;">
                        <div class="search-box clearfix">

                            <div class="search-item">

                                <?= Html::beginForm('', 'get', ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal', 'id' => 'addForm']) ?>
                                <div class="search-item">


                                    <?= Html::beginForm('', 'get', ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal', 'id' => 'addForm']) ?>
                                    <div class="search-item">
                                        <div class="input-group" style="width: 280px; float: left;margin-right: 18px;">
                                            <?php


                                            echo DateRangePicker::widget([
                                                'model' => $searchModel,
                                                'attribute' => 'start_time',
                                                'convertFormat' => true,
                                                'language' => 'zh-CN',
                                                'options' => [
                                                    'placeholder' => '请输入注册时间',
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
                                        <div class="input-group" style="width: 280px; float: left;margin-right: 18px;">
                                            <?= Html::activeInput('text', $searchModel, 'mobile', ['class' => 'form-control input', 'placeholder' => '请输入帐号搜索']) ?>
                                        </div>
                                    </div>

                                    <div class="search-item">
                                        <div class="input-group" style="width: 280px; float: left;margin-right: 18px;">
                                            <?= Html::submitButton('搜索', ['class' => 'btn btn-sm btn-primary']) ?>
                                            <?= Html::a("清空",$url = ['qrcode/usercount?id='.$id],$options = ['class' => 'btn btn-sm btn-primary',"style"=>"margin-left:10px;"]) ?>
                                            <?= Html::a("返回列表",$url = ['qrcode/index'],$options = ['class' => 'btn btn-sm btn-primary',"style"=>"margin-left:10px;"]) ?>
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
                        'mobile',
                        'common.nickname',
                        'create_time',
//                    'common.age'

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