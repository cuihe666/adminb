<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\HotelSupplier */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Hotel Suppliers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hotel-supplier-view">

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
            'name',
            'city',
            'province',
            'country',
            'address',
            'postcode',
            'type',
            'brand',
            'settle_type',
            'status',
            'invoice_status',
            'start_time',
            'end_time',
            'business_license',
            'license',
            'agreement',
            'other',
            'create_time',
        ],
    ]) ?>

</div>
