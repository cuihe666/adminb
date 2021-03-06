<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\TravelOrder */

$this->title = 'Create Travel Order';
$this->params['breadcrumbs'][] = ['label' => 'Travel Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="travel-order-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
