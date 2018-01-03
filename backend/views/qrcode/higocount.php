<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\daterange\DateRangePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BookingQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '活动线路统计';
$this->params['breadcrumbs'][] = $this->title;
?>
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/css/common.min.css">
<script src="<?= Yii::$app->request->baseUrl ?>/js/jquery.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/layer.js"></script>
<style>
    <!--
    .wrapper-content{margin-top:10px;}
    .hr-border{background-color:green;height:2px;border:none; margin: 0;}
    .qrcode_div{ margin-bottom: 20px;}
    .qrcode_div .qrcode_title{/* margin-top:20px;*/ border-bottom: 1px solid #666; heigh:38px; line-height:38px; font-weight:bold; color: #000;}
    .qrcode_info{ width:80%; overflow: hidden; line-height: 32px; border-bottom:1px solid #ccc;}
    .qrcode_info p{ line-height: 32px;}
    .qrcode_info p span{ display: inline-block}
    .qrcode_info .qrcode_p1{ width:20%; float: left;}
    .qrcode_info .qrcode_p2{ width:50%; float: left;}
    .qrcode_info .qrcode_p3 .qrcode_label{ width: 8%;}
    .qrcode_info p .qrcode_label{ width:40%; text-align: right; font-weight:normal;}
    .btn-primary{ margin-right: 10px;}
    .form-horizontal{ overflow: hidden;}
    .search-box .search-item{ margin-top: 0;}
    .search-box{ margin-top: 0; margin-bottom: 20px;}
    -->
</style>
<hr class="hr-border">
<div class="booking-index" style="padding:0;">

    <div class="wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox">
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
                                    <div class="input-group" style="width: 120px; float: left;">
                                        <?= Html::activeInput('text', $searchModel, 'name', ['class' => 'form-control input', 'placeholder' => '标题']) ?>
                                    </div>
                                </div>

                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;">
                                        <?= Html::activeInput('text', $searchModel, 'scity', ['class' => 'form-control input', 'placeholder' => '出发城市']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;">
                                        <?= Html::activeInput('text', $searchModel, 'ecity', ['class' => 'form-control input', 'placeholder' => '结束城市']) ?>
                                    </div>
                                </div>

                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;">
                                        <?= Html::activeDropDownList($searchModel, 'tag',Yii::$app->params['tag'], ['class' => 'form-control', 'prompt' => '按标签']) ?>
                                    </div>
                                </div>


                                <div class="search-item">
                                    <div class="input-group"
                                         style="width: 120px; float: left;margin-right: 18px;">


                                        <div class="search-item">
                                            <div class="input-group" style="width: 280px; float: left;margin-right: 18px;">

                                                <!--                                    <button type="button" class="btn btn-sm btn-primary"> 搜索</button>-->
                                                <?= Html::submitButton('搜索', ['class' => 'btn btn-sm btn-primary']) ?>
                                                <?= Html::a("清空",$url = ['qrcode/higocount?id='.$id],$options = ['class' => 'btn btn-sm btn-primary',"style"=>"line-height:30px;"]) ?>
                                                <?= Html::a("返回列表",$url = ['qrcode/index'],$options = ['class' => 'btn btn-sm btn-primary',"style"=>"line-height:30px;"]) ?>

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
                            ['attribute' => 'name',
                                'header' => '标题',
                                'value' => function ($model) {

                                    return $model->name;
                                }],

                            ['attribute' => 'start_city',
                                'header' => '出发城市',
                                'value' => function ($model) {

                                    return  \backend\models\TravelActivity::getcity($model->start_city);
                                }],
                            ['attribute' => 'end_city',
                                'header' => '目的地城市',
                                'value' => function ($model) {

                                    return \backend\models\TravelActivity::getcity($model->end_city);
                                }],

                            ['attribute' => 'tag',
                                'header' => '主题标签',
                                'value' => function ($model) {

                                    return \backend\models\TravelActivity::gettag($model->tag);
                                }],

                            ['attribute' => 'click_num',
                                'header' => '浏览量',
                                'value' => function ($model) {

                                    return \backend\service\HigoService::getClickNum($model->id,Yii::$app->request->queryParams['id']);
                                }],
                            /*'click.click_num',*/
                            /*['class' => 'yii\grid\ActionColumn',
                                'header' => '操作',
                                'template' => '<div class="dropdown profile-element group-btn-edit">
                                     {view}
                                </div> ',
                                'buttons' => [
                                    'view' => function ($url, $model, $key) {

                                            return Html::a('查看', ['travel-higo/view', 'id' => $key], ['class' => 'btn btn-info']) ;

                                    },
                                ],
                            ],*/


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


    <script>


        function drop($key) {
            layer.confirm('确认要下线吗', {icon: 3, title: '友情提示'}, function (index) {
                $.post("<?=Url::to(["travel-higo/drop"])?>", {
                    "PHPSESSID": "<?php echo session_id();?>",
                    "<?=Yii::$app->request->csrfParam?>": "<?=Yii::$app->request->getCsrfToken()?>",
                    data: {id: $key},
                }, function (data) {
                    if (data == 1) {
                        layer.alert('操作成功');
                        window.location.reload();


                    }


                });
            });
        }

        function online($key) {
            layer.confirm('确认要上线吗', {icon: 3, title: '友情提示'}, function (index) {
                $.post("<?=Url::to(["travel-higo/online"])?>", {
                    "PHPSESSID": "<?php echo session_id();?>",
                    "<?=Yii::$app->request->csrfParam?>": "<?=Yii::$app->request->getCsrfToken()?>",
                    data: {id: $key},
                }, function (data) {
                    if (data == 1) {
                        layer.alert('操作成功');
                        window.location.reload();


                    }


                });
            });
        }

    </script>

