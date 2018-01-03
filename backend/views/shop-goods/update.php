<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ShopGoods */

$this->title = 'Update Shop Goods: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Shop Goods', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="shop-goods-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
