<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\HotelSupplierSettlement */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Hotel Supplier Settlements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hotel-supplier-settlement-view">

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
            'settle_id',
            'hotel_id',
            'supplier_id',
            'create_time',
            'total',
            'order_total',
            'coupon_total',
            'status',
            'pay_time',
            'agent_total',
            'tangguo_total',
            'fail_cause',
            'serial_number',
            'start_time',
            'end_time',
            'invoice',
        ],
    ]) ?>

</div>
