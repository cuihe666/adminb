<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\OrderDetailStatic */

$this->title = 'Create Order Detail Static';
$this->params['breadcrumbs'][] = ['label' => 'Order Detail Statics', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-detail-static-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
