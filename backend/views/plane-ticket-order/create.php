<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\PlaneTicketOrder */

$this->title = 'Create Plane Ticket Order';
$this->params['breadcrumbs'][] = ['label' => 'Plane Ticket Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plane-ticket-order-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
