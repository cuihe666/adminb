<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\PlaneTicketOrderEmplane */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Plane Ticket Order Emplanes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plane-ticket-order-emplane-view">

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
            'order_id',
            'ticket_supplier_id',
            'insurance_supplier_id',
            'ticket_type',
            'pre_price',
            'insurance_type',
            'insurance_money',
            'mb_fuel',
            'name',
            'phone',
            'card_type',
            'card_no',
            'refund_ticket_status',
            'refund_insurance_status',
            'ticket_no',
            'insurance_no',
            'ticket_commision',
            'insurance_commision',
            'create_time',
            'update_time',
            'admin_id',
        ],
    ]) ?>

</div>
