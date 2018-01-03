<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\TravelSettleDetail */

$this->title = 'Create Travel Settle Detail';
$this->params['breadcrumbs'][] = ['label' => 'Travel Settle Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="travel-settle-detail-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
