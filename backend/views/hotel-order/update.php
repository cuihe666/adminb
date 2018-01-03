<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\HotelOrder */

$this->title = 'Update Hotel Order: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Hotel Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="hotel-order-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
