<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\daterange\DateRangePicker;
use yii\helpers\ArrayHelper;
$a = 123;
/* @var $this yii\web\View */
/* @var $searchModel /*app\models\BookingQuery*/
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '二维码管理';

$this->params['breadcrumbs'][] = $this->title;
?>
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/css/common.min.css">
<style>
    .btn-group, .btn-group-vertical
    {
        margin-top: 10px;
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
                                <?= Html::a('创建二维码', ['create'], ['class' => 'btn btn-success','style'=>"float:left; margin-right:20px; margin-top:10px;"]) ?>
                                <?= Html::beginForm(['qrcode/index'], 'get', ['class' => 'form-horizontal', 'id' => 'addForm','style'=>"float:left;"]) ?>
                                <div class="search-item">
                                    <div class="input-group" style="width: 200px; float: left;margin-right: 18px;">
                                        <?php


                                        echo DateRangePicker::widget([
                                            'model' => $searchModel,
                                            'attribute' => 'stime',
                                            'convertFormat' => true,
                                            'language' => 'zh-CN',
                                            'options' => [
                                                'placeholder' => '请选择提交时间',
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
                                        <?= Html::activeDropDownList($searchModel, 'theme_id',\backend\models\Qrcode::getActiveTheme(), ['class' => 'form-control', 'prompt' => '活动主题','value'=>$searchModel->theme_id]) ?>
                                    </div>
                                </div>
<!--
                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                        <?/*= Html::activeDropDownList($searchModel, 'city_code',\backend\models\Qrcode::getCity(), ['class' => 'form-control', 'prompt' => '城市','value'=>$searchModel->city_code]) */?>
                                    </div>
                                </div>-->


                                <div class="search-item">
                                    <div class="input-group" style="width: 200px;margin-right: 5px;">

                                        <!--                                    <button type="button" class="btn btn-sm btn-primary"> 搜索</button>-->
                                        <?= Html::submitButton('搜索', ['class' => 'btn btn-sm btn-primary']) ?>
                                        <?= Html::a("清空",$url = ['qrcode/index'],$options = ['class' => 'btn btn-sm btn-primary',"style"=>"line-height:30px;"]) ?>
                                    </div>
                                </div>

                                <?= Html::endForm() ?>
                            </div>
                        </div>


                        <?php
                        use kartik\export\ExportMenu;
                        $gridColumns = [
                            ['class' => 'yii\grid\SerialColumn', 'header' => '序号'],
                            ['attribute' => 'theme_id',
                                'value' => function ($model) {
                                    return \backend\models\Qrcode::getActiveTheme()[$model->theme_id];
                                }
                            ],
                            ['attribute' => 'city_code',
                                'value' => function ($model) {
                                    return \backend\models\Qrcode::getRegionName($model->city_code);
                                }
                            ],
                            'scan_num',

                            ['attribute' => 'create_time',
                                'value' => function ($model) {

                                    return date('Y-m-d H:i:s', $model->create_time);
                                }
                            ],
                            [
                                'attribute' => 'qrcode_url',
                                'format' => [
                                    'image',
                                    [
                                        'width'=>'84',
                                        'height'=>'84'
                                    ]
                                ],
                                'value' => function ($model) {
                                    return \yii\helpers\Url::to(['qrcode/buildqrcode','url' => $model->qrcode_url]);
                                }
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => '操作',
                                'template' => '<div>{view}{user}{order}</div> ',
                                'buttons' => [
                                    'view' => function ($url, $model, $key) {
                                        return Html::a('查看', ['qrcode/view', 'id' => $key], ['class' => 'btn btn-info','style'=>'margin-right:10px;']);
                                    },
                                    'user' => function($url, $model, $key){
                                        return Html::a('用户统计', ['qrcode/usercount', 'id' => $key,'theme_id'=>$model->theme_id], ['class' => 'btn btn-info','style'=>'margin-right:10px;']);
                                    },
                                    'order' => function($url, $model, $key){
                                        return Html::a('订单统计', ['qrcode/ordercount', 'id' => $key,'theme_id'=>$model->theme_id], ['class' => 'btn btn-info','style'=>'margin-right:10px;']);
                                    },
                                    /*'higo' => function($url, $model, $key){
                                        return Html::a('活动统计', ['qrcode/higocount', 'id' => $key], ['class' => 'btn btn-info','style'=>'margin-right:10px;']);
                                    },*/

                                ],
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

