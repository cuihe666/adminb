<?php

use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = "订单联系人信息";
$this->params['breadcrumbs'][] = ['label' => '专题活动', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    <!--
    .hr-border{background-color:green;height:2px;border:none; margin: 0;}



    -->
</style>
<hr class="hr-border">
<div class="user-backend-create">
    <?php
    use kartik\export\ExportMenu;
    $gridColumns = [
        [//ID
            'header' => 'ID',
            'attribute' => 'id',
            'format' => 'raw',
            'value' => function ($model) use($orderNo) {
                return $model->id;
            },
        ],

        [//ID
            'header' => '电子票号',
            'attribute' => 'id',
            'format' => 'raw',
            'value' => function ($model) use($orderNo) {
                return $model->idcard;
            },
            'visible' => $custom=='tgmusic',
        ],
        [
            'header' => '姓名',
            'attribute' => 'name',
            'format' => 'raw',
            'value' => function ($model) {
                return $model->name;
            },
        ],
        [
            'header' => '性别',
            'attribute' => 'sex',
            'format' => 'raw',
            'value' => function ($model) {
                return Yii::$app->params['sex'][$model->sex];
            },
        ],
        [
            'header' => '证件类型',
            'attribute' => 'type',
            'format' => 'raw',
            'value' => function ($model) {
                return Yii::$app->params['card_type'][$model->type];
            },
        ],
        [
            'header' => '证件号码',
            'attribute' => 'idcard',
            'format' => 'raw',
            'value' => function ($model) {
                return $model->idcard;
            },
        ],
        [
            'header' => '手机号码',
            'attribute' => 'mobile',
            'format' => 'raw',
            'value' => function ($model) {
                return $model->mobile;
            },
        ],

    ];
    echo ExportMenu::widget([
        'dataProvider' => $dataProvider
        , 'columns' => $gridColumns
    ]);
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumns,
        'pager' => [
            'firstPageLabel' => '首页',
            'lastPageLabel' => '尾页',
            'prevPageLabel' => '上一页',
            'nextPageLabel' => '下一页',
        ],
    ]);
    ?>
</div>
