<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\HotelSupplierSettlement */

$this->title = 'Create Hotel Supplier Settlement';
$this->params['breadcrumbs'][] = ['label' => 'Hotel Supplier Settlements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hotel-supplier-settlement-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
