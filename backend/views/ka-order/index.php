<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\daterange\DateRangePicker;

/* @var $this yii\web\View */
/* @var $searchModel /*app\models\BookingQuery*/
/* @var $dataProvider yii\data\ActiveDataProvider */
if($method=="index")
    $this->title = '未处理定制订单';
if($method=="indexa")
    $this->title = '已跟进定制订单';
if($method=="indexb")
    $this->title = '已完成定制订单';
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
                                <?= Html::beginForm(['ka-order/'.$method], 'get', ['class' => 'form-horizontal', 'id' => 'addForm']) ?>
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

                                        <?= Html::activeInput('text', $searchModel, 'linkman', ['class' => 'form-control input', 'placeholder' => '请输入联系人','value'=>$searchModel->linkman]) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">

                                        <?= Html::activeInput('text', $searchModel, 'tel', ['class' => 'form-control input', 'placeholder' => '请输入电话','value'=>$searchModel->tel]) ?>
                                    </div>
                                </div>

                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeDropDownList($searchModel, 'custom_type',Yii::$app->params['custom_type'], ['class' => 'form-control', 'prompt' => '定制类型','value'=>$searchModel->custom_type]) ?>
                                    </div>
                                </div>


                                <div class="search-item">
                                    <div class="input-group" style="width: 200px;margin-right: 5px;">

                                        <!--                                    <button type="button" class="btn btn-sm btn-primary"> 搜索</button>-->
                                        <?= Html::submitButton('搜索', ['class' => 'btn btn-sm btn-primary']) ?>
                                        <?= Html::a("清空",$url = ['ka-order/'.$method],$options = ['class' => 'btn btn-sm btn-primary',"style"=>"line-height:30px;"]) ?>
                                    </div>
                                </div>

                                <?= Html::endForm() ?>
                            </div>
                        </div>


                        <?php
                        use kartik\export\ExportMenu;

                        $gridColumns = [
                            ['class' => 'yii\grid\SerialColumn', 'header' => '序号'],
                            ['attribute' => 'add_time',
                                'value' => function ($model) {

                                    return date('Y-m-d H:i:s', $model->add_time);
                                }],
                            ['attribute' => 'custom_type',
                                'value' => function ($model) {
                                    return Yii::$app->params['custom_type'][$model->custom_type];
                                }],
                            /*'departure',*/
//                            'destination',
                            ['attribute' => 'destination',
                                'value' => function ($model) {
                                    if($model->destination)
                                        return $model->destination;
                                    else
                                        return "未填写";
                                }
                            ],
                            ['attribute' => 'departure_time',
                                'value' => function ($model) {
                                    if($model->departure_time)
                                        return date('Y-m-d', $model->departure_time);
                                    else
                                        return "未填写";
                                }
                            ],
                            ['attribute' => 'adult_num',
                                'header' => '出行人数',
                                'value' => function ($model) {

                                    return $model->adult_num."成人"."\n".$model->children_num."儿童";
                                }],
                            ['attribute' => 'budget',
                                'header' => '人均预算（元/人）',
                                'value' => function ($model) {

                                    return $model->budget;
                                }],
                            /*['attribute' => 'stayed_id',
                                'value' => function ($model) {
                                    return Yii::$app->params['stayed_status'][$model->stayed_id];
                                }],
                            ['attribute' => 'customized_theme',
                                'header' => '主题',
                                'value' => function ($model) {
                                    if($model->custom_type==1)
                                        $theme = Yii::$app->params['customized_theme_status'][$model->customized_theme];
                                    elseif($model->custom_type==2)
                                        $theme = Yii::$app->params['play_theme_status'][$model->play_theme];
                                    else
                                        $theme = "";
                                    return $theme;
                                    //return $model->custom_type==1 ? Yii::$app->params['customized_theme_status'][$model->customized_theme] : Yii::$app->params['play_theme_status'][$model->play_theme];
                                }],*/
                            'linkman',
                            'tel',
                            /*'email',*/
                            ['attribute' => 'follow_status',
                                'value' => function ($model) {
                                    return Yii::$app->params['follow_status'][$model->follow_status];
                                }],

                         [
                          'class' => 'yii\grid\ActionColumn',
                          'header' => '操作',
                          'template' => '<div>
                            {view}
                          </div> ',
                          'buttons' => [
                              'view' => function ($url, $model, $key) {
                                  $buttonName = "跟进";
                                  $model->follow_status == 1 ? $buttonName="继续跟进" : $buttonName;
                                  return $model->follow_status ==2 ? Html::a('查看', ['ka-order/view', 'id' => $key], ['class' => 'btn btn-info']) : Html::a($buttonName, ['ka-order/follow', 'id' => $key], ['class' => 'btn btn-danger'])."&nbsp;".Html::a('查看', ['ka-order/view', 'id' => $key], ['class' => 'btn btn-info']);
                              },

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

