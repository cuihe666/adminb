<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\CouponBatch */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Coupon Batches', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="coupon-batch-view">

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
            'title',
            'type',
            'is_forever',
            'mode',
            'amount',
            'num',
            'max_num',
            'rule',
            'start_time',
            'end_time',
            'create_name',
            'status',
            'update_time',
            'create_time',
        ],
    ]) ?>

</div>
