<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\PlaneTicketOrderEmplane */

$this->title = 'Create Plane Ticket Order Emplane';
$this->params['breadcrumbs'][] = ['label' => 'Plane Ticket Order Emplanes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plane-ticket-order-emplane-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
