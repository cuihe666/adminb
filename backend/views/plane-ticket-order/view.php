<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\PlaneTicketOrder */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Plane Ticket Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plane-ticket-order-view">

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
            'order_no',
            'order_uid',
            'ticket_supplier_id',
            'insurance_supplier_id',
            'order_source',
            'pay_platform',
            'pay_status',
            'order_status',
            'process_status',
            'dis_amount',
            'pay_amount',
            'total_amount',
            'payment_time',
            'city_start_id',
            'city_end_id',
            'airline_company_id',
            'flight_number',
            'flight_model',
            'fly_start_time',
            'fly_end_time',
            'fly_start_airport',
            'fly_end_airport',
            'have_meals',
            'stop_over_city',
            'contacts',
            'contacts_phone',
            'express_money',
            'express_addressee',
            'express_addressee_address',
            'express_addressee_tel',
            'guest_num',
            'insurance_num',
            'create_time',
            'update_time',
            'admin_id',
        ],
    ]) ?>

</div>
