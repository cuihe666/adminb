<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\PlaneTicketOrder */

$this->title = 'Update Plane Ticket Order: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Plane Ticket Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="plane-ticket-order-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
