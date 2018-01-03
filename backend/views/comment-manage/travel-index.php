<?php

use yii\helpers\Html;
use kartik\daterange\DateRangePicker;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CommentQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '评论列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/layer.js"></script>
<div class="booking-index">

    <div class="wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox">
                    <div class="ibox-content" style="margin-bottom: 20px;">
                        <div class="search-box clearfix">

                            <div class="search-item">

                                <?= Html::beginForm(['comment-manage/travel-index'], 'get', ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal', 'id' => 'addForm']) ?>
                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group"
                                         style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeInput('text', $searchModel, 'order_no', ['class' => 'form-control','id'=>'', 'placeholder' => '订单号']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group"
                                         style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeInput('text', $searchModel, 'id', ['class' => 'form-control','id'=>'', 'placeholder' => '点评id']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group"
                                         style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeInput('text', $searchModel, 'uid', ['class' => 'form-control','id'=>'', 'placeholder' => '用户id']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group"
                                         style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeInput('text', $searchModel, 'nickname', ['class' => 'form-control','id'=>'', 'placeholder' => '用户名']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group"
                                         style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeInput('text', $searchModel, 'mobile', ['class' => 'form-control','id'=>'', 'placeholder' => '手机号']) ?>
                                    </div>
                                </div>
                                <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                    <?= Html::activeDropDownList($searchModel, 'obj_sub_type', Yii::$app->params['comment_type'], ['class' => 'form-control', 'prompt' => '二级品类']) ?>
                                </div>
                                <div class="search-item">
                                    <div class="input-group"
                                         style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeInput('text', $searchModel, 'obj_id', ['class' => 'form-control','id'=>'', 'placeholder' => '产品id']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group"
                                         style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeInput('text', $searchModel, 'obj_name', ['class' => 'form-control','id'=>'', 'placeholder' => '产品名称']) ?>
                                    </div>
                                </div>
                                <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                    <?= Html::activeDropDownList($searchModel, 'state',  Yii::$app->params['comment_status'], ['class' => 'form-control']) ?>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 200px; float: left;margin-right: 18px;">
                                        <?php


                                        echo DateRangePicker::widget([
                                            'model' => $searchModel,
                                            'attribute' => 'order_create_time',
                                            'convertFormat' => true,
                                            'language' => 'zh-CN',
                                            'options' => [
                                                'placeholder' => '请输入下单时间',
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
                                    <div class="input-group" style="width: 200px; float: left;margin-right: 18px;">
                                        <?php
                                        echo DateRangePicker::widget([
                                            'model' => $searchModel,
                                            'attribute' => 'create_time',
                                            'convertFormat' => true,
                                            'language' => 'zh-CN',
                                            'options' => [
                                                'placeholder' => '请输入点评时间',
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
                                        <?= Html::submitButton('搜索', ['class' => 'btn btn-sm btn-primary', 'style' => 'width:140px;height:34px;']) ?>
                                    </div>
                                </div>


                                <?= Html::endForm() ?>
                            </div>
                        </div>
                    </div>
                </div>


                <?= GridView::widget(['dataProvider' => $dataProvider,
                    "options" => ["class" => "grid-view", "style" => "overflow:auto", "id" => "grid"],
                    'columns' => [
                            'order_id',
                        ['attribute' => 'order_no',
                            'value' => function ($model) {
                                return $model->travelorder->order_no;
                            },],
                            'id',
                        ['attribute' => 'nickname',
                            'value' => function ($model) {
                                return  ($model->nickname)?(mb_strlen($model->nickname))>5?mb_substr($model->nickname,0,5).'...':($model->nickname):$model->user->common->nickname;
                            },],

                            'obj_id',
                            'grade',
                            'create_time',
//                        ['attribute' => 'housedetails.title',
//                            'value' => function ($model) {
//                                return $model->housedetails['title'];
//                            },],
                        ['attribute' => 'img_num',
                            'value' => function ($model) {
                                return ($model->pic)?count(explode(',',$model->pic)):0;
                            },],
                        [
                            'header' => '内容',
                            'value' => function ($model) {
                                return (mb_strlen($model->content))>9?mb_substr($model->content,0,9).'...':($model->content);
                            },],
                        ['class' => 'yii\grid\ActionColumn',
                            'header' => '操作',
                            'template' => '<div class="dropdown profile-element group-btn-edit">
                                    {view}
                                    {update-one}
                                </div> ',
                            'buttons' => [
                                'view' => function ($url, $model, $key) {
                                    if($model->state != 0) {
                                        return Html::a('查看', ['comment-manage/travel-review', 'comment_id' => $key,'type' =>2], ['class' => 'delnode btn btn-primary btn-sm', 'style' => 'color:white']);
                                    }
                                },
                                'update-one' => function ($url, $model, $key) {
                                    if($model->state == 0){
                                        return Html::a('审核', ['comment-manage/travel-review', 'comment_id' => $key], ['class' => 'delnode btn btn-primary btn-sm', 'style' => 'color:white']);
                                    }
                                },
                            ],],


                    ],
                    'tableOptions' => ['class' => 'table table-striped table-bordered table-hover table-checkable order-column dataTable no-footer'],
                    'summaryOptions' => ['class' => 'pagination'],
                    'pager' => [

                        'options' => ['class' => 'pagination', 'style' => 'visibility: visible;'],


                        'nextPageLabel' => '下页',

                        'prevPageLabel' => '上页',

                        'firstPageLabel' => '首页',

                        'lastPageLabel' => '末页'

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


<script>
    $('.check').click(function () {
        var keys = $("#grid").yiiGridView("getSelectedRows");
        if (keys.length == 0) {
            layer.alert("请先选择要删除的数据");
            return false;
        }
        layer.confirm('审核通过后，将在前台显示,是否继续？', {icon: 3, title: '友情提示'}, function (index) {
            $.post("<?=Url::to(["comment/changestatus"])?>", {
                    "PHPSESSID": "<?php echo session_id();?>",
                    "<?=Yii::$app->request->csrfParam?>": "<?=Yii::$app->request->getCsrfToken()?>",
                    data: keys,
                    dataType: "json",
                },
                function (data) {
                    if (data == 1) {
                        layer.alert("审核成功！");
                        location.reload();
                    }
                }
            )

        })
        ;

    })

    $('.del').click(function () {
        var keys = $("#grid").yiiGridView("getSelectedRows");
        if (keys.length == 0) {
            layer.alert("请先选择要删除的数据");
            return false;
        }
        layer.confirm('删除后数据不可恢复，您确定吗？', {icon: 3, title: '友情提示'}, function (index) {
            $.post("<?=Url::to(["comment/del"])?>", {
                    "PHPSESSID": "<?php echo session_id();?>",
                    "<?=Yii::$app->request->csrfParam?>": "<?=Yii::$app->request->getCsrfToken()?>",
                    data: keys,
                    dataType: "json",
                },
                function (data) {
                    if (data == 1) {
                        layer.alert("删除成功！");
                        location.reload();
                    }
                }
            )

        })
        ;

    })
</script>
