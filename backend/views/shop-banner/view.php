<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\ShopBanner */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Shop Banners', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shop-banner-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'img_url:url',
            'is_home',
            'type',
            'goods_id',
            'cid',
            'sort',
        ],
    ]) ?>

</div>
