<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\daterange\DateRangePicker;
use yii\helpers\ArrayHelper;
$a = 123;
/* @var $this yii\web\View */
/* @var $searchModel /*app\models\BookingQuery*/
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '活动主题列表';

$this->params['breadcrumbs'][] = $this->title;
?>
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/css/common.min.css">
<style>
    .btn-group, .btn-group-vertical
    {
        margin-top: 10px;
    }
    .search-box .search-item{ margin-right: 0;}
    .btn-primary{ margin-right: 10px;}
</style>
<div class="booking-index">

    <div class="wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox">
                    <div class="ibox-content" style="margin-bottom: 20px;">
                        <div class="search-box clearfix" style="margin: -65px 0 0 20px;">
                            <div class="search-item">
                                <?= Html::a('新增活动主题', ['create'], ['class' => 'btn btn-success','style'=>"float:left; margin-right:20px; margin-top:10px;"]) ?>
                                <?= Html::beginForm(['active-theme/index'], 'get', ['class' => 'form-horizontal', 'id' => 'addForm','style'=>"float:left;"]) ?>
                                <!--<div class="search-item">
                                    <div class="input-group" style="width: 180px; float: left;margin-right: 18px;">
                                        <?php
/*
                                        echo DateRangePicker::widget([
                                            'model' => $searchModel,
                                            'attribute' => 'stime',
                                            'convertFormat' => true,
                                            'language' => 'zh-CN',
                                            'options' => [
                                                'placeholder' => '请选择活动结束时间区间',
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

                                        */?>
                                    </div>
                                </div>-->
                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeInput('text', $searchModel, 'theme_name', ['class' => 'form-control input', 'placeholder' => '请输入活动主题','value'=>$searchModel->theme_name]) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeDropDownList($searchModel, 'status',Yii::$app->params['status'], ['class' => 'form-control', 'prompt' => '请选择状态','value'=>$searchModel->status]) ?>
                                    </div>
                                </div>


                                <div class="search-item">
                                    <div class="input-group" style="width: 180px;margin-right: 5px;">
                                        <?= Html::submitButton('搜索', ['class' => 'btn btn-sm btn-primary']) ?>
                                        <?= Html::a("清空",$url = ['active-theme/index'],$options = ['class' => 'btn btn-sm btn-primary',"style"=>"line-height:30px;"]) ?>
                                    </div>
                                </div>

                                <?= Html::endForm() ?>
                            </div>
                        </div>


                        <?php
                        use kartik\export\ExportMenu;
                        $gridColumns = [
                            ['class' => 'yii\grid\SerialColumn', 'header' => '序号'],
                            'theme_name',
                            'theme_url',
                            ['attribute' => 'start_date',
                                'value' => function ($model) {
                                    if($model->start_date!="")
                                        return date('Y-m-d', $model->start_date);
                                    else
                                        return "未设置";
                                }
                            ],
                            ['attribute' => 'end_date',
                                'value' => function ($model) {
                                    if($model->start_date!="")
                                        return date('Y-m-d', $model->end_date);
                                    else
                                        return "未设置";
                                }
                            ],
                            ['attribute' => 'status',
                                'value' => function ($model) {
                                    return Yii::$app->params['status'][$model->status];
                                }
                            ],
                            ['attribute' => 'create_time',
                                'value' => function ($model) {

                                    return date('Y-m-d H:i:s', $model->create_time);
                                }
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => '操作',
                                'template' => '<div>{view}</div> ',
                                'buttons' => [
                                    'view' => function ($url, $model, $key) {
                                        return Html::a('查看', ['active-theme/view', 'id' => $key], ['class' => 'btn btn-info','style'=>'margin-right:10px;']);
                                    },
                                    /*'update' => function ($url, $model, $key) {
                                        return Html::a('编辑', ['active-theme/update', 'id' => $key], ['class' => 'btn btn-info','style'=>'margin-right:10px;']);
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

