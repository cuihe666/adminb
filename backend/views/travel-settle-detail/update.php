<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TravelSettleDetail */

$this->title = 'Update Travel Settle Detail: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Travel Settle Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="travel-settle-detail-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
