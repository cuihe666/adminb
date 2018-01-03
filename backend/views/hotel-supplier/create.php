<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\HotelSupplier */

$this->title = 'Create Hotel Supplier';
$this->params['breadcrumbs'][] = ['label' => 'Hotel Suppliers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hotel-supplier-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
