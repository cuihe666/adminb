<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\HotelSupplier */

$this->title = 'Update Hotel Supplier: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Hotel Suppliers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="hotel-supplier-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
