<?php

use kartik\daterange\DateRangePicker;
use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BookingQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '商家列表';
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

                                <?= Html::beginForm(['shop-supplier/index'], 'get', ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal', 'id' => 'addForm']) ?>
                                <div class="search-item">
                                    <div class="input-group" style="width: 200px; float: left;margin-right: 18px;">
                                        <?php


                                        echo DateRangePicker::widget([
                                            'model' => $searchModel,
                                            'attribute' => 'start_time',
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
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeInput('text', $searchModel, 'admin_username', ['class' => 'form-control input', 'placeholder' => '卖家账号']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeInput('text', $searchModel, 'company_name', ['class' => 'form-control input', 'placeholder' => '公司名称']) ?>
                                    </div>
                                </div>


                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeInput('text', $searchModel, 'principal', ['class' => 'form-control input', 'placeholder' => '姓名']) ?>
                                    </div>
                                </div>

                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeInput('text', $searchModel, 'principal_phone', ['class' => 'form-control input', 'placeholder' => '手机号']) ?>
                                    </div>
                                </div>


                                <div class="search-item">
                                    <div class="input-group"
                                         style="width: 280px; float: left;margin-right: 18px;">

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

                $gridColumns = [['class' => 'yii\grid\SerialColumn',
                    'header' => '序号'],
                    'admin_username',
                    'company_name',
                    'info.name',
                    'info.principal',
                    'info.principal_phone',
                    'legal_id_code',
                    'created_at',


                    ['class' => 'yii\grid\ActionColumn',
                        'header' => '操作',
                        'template' => '<div class="dropdown profile-element group-btn-edit">
                                     {view}
                                </div> ',

//                        0 => 未认证\n1 => 待审核\n2 => 已认证\n3 => 已禁用\n10 => 已拒绝'
                        'buttons' => ['view' => function ($url, $model, $key) {

                            if ($model->status == 0) {
                                return Html::a('未认证', ['view', 'id' => $key]);
                            }

                            if ($model->status == 1) {
                                return Html::a('审核', ['view', 'id' => $key]);
                            }


                            if ($model->status == 2) {
                                return Html::a('查看', ['view', 'id' => $key]);
                            }
                            if ($model->status == 3) {
                                return Html::a('查看', ['view', 'id' => $key]);
                            }
                            if ($model->status == 10) {
                                return Html::a('已拒绝', ['view', 'id' => $key]);
                            }


                        },],],];
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


