<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PlaneTicketInsuranceGoodsManageQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '保险产品管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .search-model{
        float: left;
        padding-left: 10px;
    }
</style>
<div class="plane-ticket-insurance-goods-manage-index">
    <p>
        <?= Html::a('新增', '#', ['class' => 'btn btn-success add_insurance_goods']) ?>
    </p>
    <div class="search-box clearfix" style="padding-bottom: 10px;">
        <div class="search-item">
            <?= Html::beginForm(['insurance-manage/index'], 'get', ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal']) ?>
            <div class="search-item" style="float: left">
                <div class="input-group" style="width: 220px; float: left;">
                    <?= Html::activeDropDownList($searchModel, 'supplier_id', $insurance_list, ['class' => 'form-control', 'prompt' => '供应商名称']) ?>
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
        [
            'label' => '供应商名称',
            'value' => function($model) {
                return $model->supplier->name;
            }
        ],
        [
            'label' => '类别',
            'value' => function($model){
                return Yii::$app->params['plane_insurance_type'][$model->supplier->insurance_genre];
            }
        ],
        [
            'label' => '产品类别',
            'value' => function($model){
                return Yii::$app->params['plane_emplane_insurance_type'][$model->type];
            }
        ],
        'price',
        'insurance_fee',
        [
            'label' => '状态',
            'value' => function($model){
                return Yii::$app->params['plane_suppler_status'][$model->status];
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
                    return Html::a('修改', "#", ['class' => 'delnode  btn-primary btn-sm edit_insurance_goods', 'style' => 'color:white', 'MyAttr'=> $model->id]);
                },
                'up' => function ($url, $model, $key) {
                    return Html::a('上线', "#", ['class' => 'delnode  btn-primary btn-sm up_goods', 'style' => 'color:white', 'MyAttr'=> $model->id]);
                },
                'low' => function ($url, $model, $key) {
                    return Html::a('下线', "#", ['class' => 'delnode  btn-primary btn-sm low_goods', 'style' => 'color:white', 'MyAttr'=> $model->id]);
                },
            ]
        ],
    ];
    ?>
    <?php
    echo \kartik\export\ExportMenu::widget([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumns
    ]);
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
    $(".up_goods").click(function () {
        var id = $(this).attr("MyAttr");
        $.post("<?= \yii\helpers\Url::to(['insurance-manage/up-goods-status'])?>",{
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
    $(".low_goods").click(function () {
        var id = $(this).attr("MyAttr");
        $.post("<?= \yii\helpers\Url::to(['insurance-manage/low-goods-status'])?>",{
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
    $(".add_insurance_goods").click(function () {
        location.href = "<?= \yii\helpers\Url::to(['insurance-manage/create'])?>";
    });
    //修改
    $(".edit_insurance_goods").click(function () {
        var id = $(this).attr("MyAttr");
        location.href = "<?= \yii\helpers\Url::to(['insurance-manage/update'])?>?id="+id;
    });
</script>
