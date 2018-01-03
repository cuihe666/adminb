<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\PlaneTicketBanner */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Plane Ticket Banners', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plane-ticket-banner-view">

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
            'desc',
            'img_url:url',
            'turn_type',
            'turn_data',
            'share_data:ntext',
            'start_time',
            'end_time',
            'sort',
            'status',
            'create_time',
            'update_time',
            'admin_id',
        ],
    ]) ?>

</div>
