<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\daterange\DateRangePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BookingQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '印象';
$this->params['breadcrumbs'][] = $this->title;
?>
<script src="<?= Yii::$app->request->baseUrl ?>/js/jquery.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/layer.js"></script>
<div class="booking-index">
    <div class="wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox">
                    <div class="ibox-content" style="margin-bottom: 20px;">
                        <div class="search-box clearfix">
                            <div class="search-item">
                                <?= Html::beginForm(['travel-impress/index'], 'get', ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal', 'id' => 'addForm']) ?>
                                <div class="search-item">
                                    <div class="input-group" style="width: 165px; float: left;margin-right: 10px;">
                                        <?php
                                        echo DateRangePicker::widget([
                                            'model' => $searchModel,
                                            'attribute' => 'stime',
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
                                    <div class="input-group" style="width: 110px; float: left;margin-right: 10px;">
                                        <?= Html::activeInput('text', $searchModel, 'scity', ['class' => 'form-control input', 'placeholder' => '按相关城市']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 10px;">
                                        <?= Html::activeInput('number', $searchModel, 'account', ['class' => 'form-control input', 'placeholder' => '按帐号查找','onkeyup'=>"value=value.replace(/[^1234567890-]+/g,'')"]) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 110px; float: left;margin-right: 10px;">
                                        <?= Html::activeInput('number', $searchModel, 'id', ['class' => 'form-control input', 'placeholder' => '按ID']) ?>
                                    </div>
                                </div>

                                <div class="search-item">
                                    <div class="input-group" style="width: 110px; float: left;margin-right: 10px;">
                                        <?= Html::activeInput('text', $searchModel, 'name', ['class' => 'form-control input', 'placeholder' => '按标题']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 110px; float: left;margin-right: 10px;">
                                        <?= Html::activeInput('text', $searchModel, 'nature', ['class' => 'form-control input', 'placeholder' => '按资质名称']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 110px; float: left;margin-right: 10px;">
                                        <?= Html::activeDropDownList($searchModel, 'type', Yii::$app->params['impress_type'], ['class' => 'form-control', 'prompt' => '按类型']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 110px; float: left;margin-right: 10px;">
                                        <?= Html::activeDropDownList($searchModel, 'identity', Yii::$app->params['impress_identity'], ['class' => 'form-control', 'prompt' => '按性质']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 110px; float: left;margin-right: 10px;">
                                        <?= Html::activeDropDownList($searchModel, 'status', Yii::$app->params['higo_status'], ['class' => 'form-control', 'prompt' => '按状态']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 110px; float: left;margin-right: 10px;">
                                        <?= Html::submitButton('搜索', ['class' => 'btn btn-sm btn-primary']) ?>&nbsp;
                                        <?= Html::a("清空",$url = ['travel-impress/index'],$options = ['class' => 'btn btn-sm btn-primary']) ?>
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
                            'id',
                            ['attribute' => 'account',
                                'header' => '发布帐号',
                                'value' => function ($model) {
                                    //2017年6月23日15:59:48   付燕飞加判断。如果$model->uid不为空的时候再调用下面获取账号名称的方法。
                                    if($model->uid){
                                        return \backend\models\TravelPerson::getUser($model->uid)['mobile'] . '(' . \backend\models\TravelPerson::getUserCommon($model->uid)['nickname'] . ')';
                                    }
                                }
                            ],
                            ['attribute' => 'identity',
                                'header' => '性质',
                                'value' => function ($model) {
                                    switch ($model->identity) {
                                        case 0;
                                            return "公司" . '(' . \backend\models\TravelCompany::getCompany($model->uid)['name'] . ')';
                                            break;
                                        case 1;
                                            return "个人" . '(' . \backend\models\TravelPerson::getPerson($model->uid)['name'] . ')';
                                            break;
                                        case 2;
                                            return "无";
                                            break;
                                    }
                                }
                            ],
                            ['attribute' => 'create_time',
                                'header' => '上传时间',
                                'value' => function ($model) {
                                    return substr($model->create_time,0,10);
                                }
                            ],
                            ['attribute' => 'name',
                                'header' => '标题',
                                'value' => function ($model) {
                                    return $model->name;
                                }
                            ],
                            ['attribute' => 'city',
                                'header' => '城市',
                                'value' => function ($model) {
                                    return  ltrim(rtrim(\backend\models\TravelActivity::getcity($model->city1).','.\backend\models\TravelActivity::getcity($model->city2).','.\backend\models\TravelActivity::getcity($model->city3),','),',');
                                }],

                            ['attribute' => 'type',
                                'header' => '类型',
                                'value' => function ($model) {
                                    return Yii::$app->params['impress_type'][$model->type];
                                }],

                            ['class' => 'yii\grid\ActionColumn',
                                'header' => '操作',
                                'template' => '<div class="dropdown profile-element group-btn-edit">
                                     {view}
                                </div> ',
                                'buttons' => [
                                    'view' => function ($url, $model, $key) {
                                        if( $model->status == 0){
                                            return Html::a('审核', ['travel-impress/view', 'id' => $key], ['class' => 'btn btn-info']);
                                        }
                                        if( $model->status == 3){
                                            return Html::a('查看', ['travel-impress/view', 'id' => $key], ['class' => 'btn btn-info']);
                                        }
                                        if($model->status == 1){
                                            return  Html::a('下线', "javascript:drop($key);", ['class' => 'btn btn-danger', 'id' => $key]).Html::a('查看', ['travel-impress/view', 'id' => $key], ['class' => 'btn btn-info']);
                                        }
                                        if($model->status ==2){
                                            return  Html::a('上线', "javascript:online($key);", ['class' => 'btn btn-danger', 'id' => $key]).Html::a('查看', ['travel-impress/view', 'id' => $key], ['class' => 'btn btn-info']);
                                        }
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
    <script>
        function drop($key) {
            layer.confirm('确认要下线吗', {icon: 3, title: '友情提示'}, function (index) {
                $.post("<?=Url::to(["travel-impress/drop"])?>", {
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
                $.post("<?=Url::to(["travel-impress/online"])?>", {
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