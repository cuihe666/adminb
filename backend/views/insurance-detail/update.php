<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\PlaneTicketOrderEmplane */

$this->title = 'Update Plane Ticket Order Emplane: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Plane Ticket Order Emplanes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="plane-ticket-order-emplane-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
