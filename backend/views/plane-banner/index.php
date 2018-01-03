<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PlaneTicketBannerQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '机票广告管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .search-model{
        float: left;
        padding-left: 10px;
    }
</style>
<div class="plane-ticket-banner-index">
    <p>
        <?= Html::a('新增', '#', ['class' => 'btn btn-success add_plane_banner']) ?>
    </p>
    <div class="search-box clearfix" style="padding-bottom: 10px;">
        <div class="search-item">
            <?= Html::beginForm(['plane-banner/index'], 'get', ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal']) ?>
            <div class="search-item" style="float: left">
                <div class="input-group">
                    <?= Html::activeInput('text', $searchModel, 'desc', ['class' => 'form-control input', 'placeholder' => '请输入广告名称']) ?>
                </div>
            </div>
            <div class="search-item search-model">
                <div class="input-group">
                    <?= Html::submitButton('搜索', ['class' => 'btn btn-sm btn-primary']) ?>&nbsp;
                </div>
            </div>
            <?= Html::endForm() ?>
        </div>
    </div>
    <?php
    $gridColumns = [
        ['class' => 'yii\grid\SerialColumn', 'header' => '序号'],
        'desc',
        ['class' => 'yii\grid\SerialColumn', 'header' => '位置'],
        [
            'label' => '位置数字',
            'value' => function($model){
                return $model->sort;
            }
        ],
        [
            'label' => '状态',
            'value' => function($model){
                return Yii::$app->params['plane_banner_status'][$model->status];
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => '操作',
            'template' => '<div class="dropdown profile-element group-btn-edit">
                                    {edit} {up} {low}
                                </div> ',
            'buttons' => [
                'edit' => function ($url, $model, $key) {
                    return Html::a('修改', "#", ['class' => 'delnode  btn-primary btn-sm edit_plane_banner', 'style' => 'color:white', 'MyAttr'=> $model->id]);
                },
                'up' => function ($url, $model, $key) {
                    return Html::a('上线', "#", ['class' => 'delnode  btn-primary btn-sm up_banner', 'style' => 'color:white', 'MyAttr'=> $model->id]);
                },
                'low' => function ($url, $model, $key) {
                    return Html::a('下线', "#", ['class' => 'delnode  btn-primary btn-sm low_banner', 'style' => 'color:white', 'MyAttr'=> $model->id]);
                },
            ]
        ],
    ];
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumns,
        'pager' => [
            'firstPageLabel' => '首页',
            'lastPageLabel' => '尾页',
        ],
    ]); ?>
</div>
<script>
    //上线
    $(".up_banner").click(function () {
        var id = $(this).attr("MyAttr");
        $.post("<?= \yii\helpers\Url::to(['plane-banner/up-banner-status'])?>",{
            "<?= Yii::$app->request->csrfParam?>": "<?= Yii::$app->request->getCsrfToken()?>",
            data:{id:id}
        },function (data) {
            if (data == 'success') {
                location.reload();
            } else {
                layer.alert("修改失败！");
            }
        });
    });
    //下线
    $(".low_banner").click(function () {
        var id = $(this).attr("MyAttr");
        $.post("<?= \yii\helpers\Url::to(['plane-banner/low-banner-status'])?>",{
            "<?= Yii::$app->request->csrfParam?>": "<?= Yii::$app->request->getCsrfToken()?>",
            data:{id:id}
        },function (data) {
            if (data == 'success') {
                location.reload();
            } else {
                layer.alert("修改失败！");
            }
        });
    });
    //新增
    $(".add_plane_banner").click(function () {
        location.href = "<?= \yii\helpers\Url::to(['plane-banner/create'])?>";
    });
    //新增或者修改
    $(".edit_plane_banner").click(function () {
        var id = $(this).attr("MyAttr");
        location.href = "<?= \yii\helpers\Url::to(['plane-banner/update'])?>?id="+id;
    });
</script>
