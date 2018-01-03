<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\HouseSettlement */

$this->title = 'Update House Settlement: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'House Settlements', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="house-settlement-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
