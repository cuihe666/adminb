<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\HouseSettlement */

$this->title = 'Create House Settlement';
$this->params['breadcrumbs'][] = ['label' => 'House Settlements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="house-settlement-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
