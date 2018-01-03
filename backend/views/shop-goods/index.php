<?php

use kartik\daterange\DateRangePicker;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BookingQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '商品列表';
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

                                <?= Html::beginForm(['shop-goods/index'], 'get', ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal', 'id' => 'addForm']) ?>


                                <div class="search-item">
                                    <div class="input-group" style="width: 200px; float: left;margin-right: 18px;">
                                        <?php


                                        echo DateRangePicker::widget([
                                            'model' => $searchModel,
                                            'attribute' => 'created_at',
                                            'convertFormat' => true,
                                            'language' => 'zh-CN',
                                            'options' => [
                                                'placeholder' => '上传时间',
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
                                        <?= Html::activeInput('text', $searchModel, 'goods_num', ['class' => 'form-control input', 'placeholder' => '商品编号']) ?>
                                    </div>
                                </div>


                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeInput('text', $searchModel, 'title', ['class' => 'form-control input', 'placeholder' => '商品名称']) ?>
                                    </div>
                                </div>

                                <div class="search-item">
                                    <div class="input-group"
                                         style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeDropDownList($searchModel, 'operate_category', Yii::$app->params['shop']['goods_category'], ['class' => 'form-control', 'prompt' => '分类']) ?>
                                    </div>
                                </div>

                                <div class="search-item">
                                    <div class="input-group"
                                         style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeDropDownList($searchModel, 'status', Yii::$app->params['shop']['goods_status'], ['class' => 'form-control', 'prompt' => '商品状态']) ?>

                                    </div>
                                </div>


                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeInput('text', $searchModel, 'principal', ['class' => 'form-control input', 'placeholder' => '卖家姓名']) ?>
                                    </div>
                                </div>

                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeInput('text', $searchModel, 'admin_username', ['class' => 'form-control input', 'placeholder' => '卖家帐号']) ?>
                                    </div>
                                </div>


                                <div class="search-item">
                                    <div class="input-group"
                                         style="width: 120px; float: left;margin-right: 18px;">


                                        <div class="search-item">
                                            <div class="input-group"
                                                 style="width: 280px; float: left;margin-right: 18px;">

                                                <!--                                    <button type="button" class="btn btn-sm btn-primary"> 搜索</button>-->
                                                <?= Html::submitButton('搜索', ['class' => 'btn btn-sm btn-primary']) ?>


                                                &nbsp;&nbsp;&nbsp;&nbsp; <p class="btn btn-sm btn-info "><a href="<?php echo Url::to(['shop-goods/show_recommend']) ?>" target="_blank" class="'btn btn-sm btn-primary'" style="color: white;">查看商品推荐位详情</a></p>
                                            </div>
                                        </div>


                                        <?= Html::endForm() ?>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <?php

                        $gridColumns = [
                            'id',
                            'goods_num',
                            'title',

                            ['header' => '分类',
                                'value' => function ($model) {

                                    return Yii::$app->params['shop']['operate_category'][$model->operate_category];


                                }],

                            [
                                'attribute' => 'sort',
                                'headerOptions' => ['width' => '20px'],
                                'value' => 'sort',
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

                            ['header' => '状态',
                                'value' => function ($model) {

                                    return Yii::$app->params['shop']['goods_status'][$model->status];


                                }],
                            'stocks',

                            ['header' => '店铺名称',
                                'value' => function ($model) {

                                    return $model->info->name;


                                }],


                            'created_at',


                            ['class' => 'yii\grid\ActionColumn',
                                'header' => '操作',
                                'template' => '<div class="dropdown profile-element group-btn-edit">
                                     {view}
                                </div> ',
                                'buttons' => ['view' => function ($url, $model, $key) {

                                    if ($model->status == 0) {
                                        return Html::a('查看', ['view', 'id' => $key]);
                                    }
                                    if ($model->status == 10) {
                                        return Html::a('审核', ['view', 'id' => $key]) . '&nbsp;&nbsp;&nbsp;&nbsp;' . Html::a('查看', ['view', 'id' => $key]);
                                    }

                                    if ($model->status == 11) {
                                        return Html::a('已驳回', ['view', 'id' => $key]) . '&nbsp;&nbsp;&nbsp;&nbsp;' . Html::a('查看', ['view', 'id' => $key]);
                                    }
                                    if ($model->status == 12) {
                                        return Html::a('待上架', ['view', 'id' => $key]) . '&nbsp;&nbsp;&nbsp;&nbsp;' . Html::a('查看', ['view', 'id' => $key]);
                                    }

                                    if ($model->status == 20) {
                                        return Html::a('下架', ['view', 'id' => $key]) . '&nbsp;&nbsp;&nbsp;&nbsp;' . Html::a('查看', ['view', 'id' => $key]) .
                                            '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;' . Html::a('添加到推荐位', "javascript:addRecommend($key);", ['id' => $key]);


                                    }


                                    if ($model->status == 30) {
                                        return Html::a('上架', ['view', 'id' => $key]) . '&nbsp;&nbsp;&nbsp;&nbsp;' . Html::a('查看', ['view', 'id' => $key]);
                                    }


                                },],],];

                        echo GridView::widget(['dataProvider' => $dataProvider,
                            'columns' => $gridColumns,
                            'pager' => ['firstPageLabel' => '首页',
                                'lastPageLabel' => '尾页',],]);
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

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">添加到推荐位</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputPassword1">所在位置:</label>
                        <select class="form-control" id="position" disabled>
                            <option value="1">首页</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">排序值:</label>
                        <input type="hidden" id="goods_id">
                        <select class="form-control" id="sort">
                            <option value="100">排序一</option>
                            <option value="99">排序二</option>
                            <option value="98">排序三</option>
                            <option value="97">排序四</option>
                            <option value="96">排序五</option>
                            <option value="95">排序六</option>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary ">保存</button>
                </div>
            </div>
        </div>
    </div>

    <script>


        function addRecommend($key) {

            $('#goods_id').val($key);
            $('#myModal').modal()


        }


        $('.btn-primary').on('click', function () {

            var position = $('#position').val();
            var sort = $('#sort').val();
            var key = $('#goods_id').val();
            $.post("<?=Url::to(["shop-goods/recommend"])?>", {
                "PHPSESSID": "<?php echo session_id();?>",
                "<?=Yii::$app->request->csrfParam?>": "<?=Yii::$app->request->getCsrfToken()?>",
                data: {id: key, position: position, sort: sort},
            }, function (data) {
                if (data == -1) {
                    layer.alert('此推荐位已存在此商品');
                    return;
                }
                if (data == -2) {
                    layer.confirm('此位置上已存在商品，是否继续', {icon: 3, btn: ['替换', '取消'], title: '友情提示'}, function (index) {

                        $.post("<?=Url::to(["true_sort"])?>", {
                            "PHPSESSID": "<?php echo session_id();?>",
                            "<?=Yii::$app->request->csrfParam?>": "<?=Yii::$app->request->getCsrfToken()?>",
                            data: {goods_id: key, position: position, sort: sort},
                        }, function (data) {
                            if (data == 1) {

                                layer.alert('操作成功');
                                $('#myModal').modal('hide')

                                return;

                            }


                        });
                    });

                }

                if (data == 1) {
                    $('#myModal').modal('hide')
                    layer.alert('操作成功！ ');
                    return;

                }


            });


        })

    </script>



