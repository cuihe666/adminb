<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PlaneTicketSupplierQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '机票供应商列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .search-model{
        float: left;
        padding-left: 10px;
    }
</style>
<div class="plane-ticket-supplier-index">
    <p>
        <?= Html::a('添加', '#', ['class' => 'btn btn-success add_plane_insurance']) ?>
    </p>
    <div class="search-box clearfix" style="padding-bottom: 10px;">
        <div class="search-item">
            <?= Html::beginForm(['plane-supplier/index'], 'get', ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal']) ?>
            <div class="search-item" style="float: left">
                <div class="input-group">
                    <?= Html::activeInput('text', $searchModel, 'name', ['class' => 'form-control input', 'placeholder' => '请输入供应商名称']) ?>
                </div>
            </div>
            <div class="search-item search-model">
                <div class="input-group">
                    <?= Html::activeInput('text', $searchModel, 'contacts', ['class' => 'form-control input', 'placeholder' => '请输入联系人姓名']) ?>
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
        'name',
        'contacts',
        'contacts_phone',
        [
            'label' => '类别',
            'value' => function($model){
                return Yii::$app->params['plane_insurance_type'][$model->insurance_genre];
            }
        ],
        [
            'label' => '状态',
            'value' => function($model){
                return Yii::$app->params['plane_suppler_status'][$model->is_use];
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
                    return Html::a('修改', "#", ['class' => 'delnode  btn-primary btn-sm edit_plane_insurance', 'style' => 'color:white', 'MyAttr'=> $model->id]);
                },
                'up' => function ($url, $model, $key) {
                    return Html::a('上线', "#", ['class' => 'delnode  btn-primary btn-sm up_insurance', 'style' => 'color:white', 'MyAttr'=> $model->id]);
                },
                'low' => function ($url, $model, $key) {
                    return Html::a('下线', "#", ['class' => 'delnode  btn-primary btn-sm low_insurance', 'style' => 'color:white', 'MyAttr'=> $model->id]);
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
    $(".up_insurance").click(function () {
        var id = $(this).attr("MyAttr");
        $.post("<?= \yii\helpers\Url::to(['plane-insurance/up-insurance-status'])?>",{
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
    $(".low_insurance").click(function () {
        var id = $(this).attr("MyAttr");
        $.post("<?= \yii\helpers\Url::to(['plane-insurance/low-insurance-status'])?>",{
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
    $(".add_plane_insurance").click(function () {
        location.href = "<?= \yii\helpers\Url::to(['plane-insurance/create'])?>";
    });
    //修改
    $(".edit_plane_insurance").click(function () {
        var id = $(this).attr("MyAttr");
        location.href = "<?= \yii\helpers\Url::to(['plane-insurance/update'])?>?id="+id;
    });
</script>
