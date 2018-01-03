<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\HouseSettlementQuery */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="house-settlement-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'settle_id') ?>

    <?= $form->field($model, 'uid') ?>

    <?= $form->field($model, 'create_time') ?>

    <?= $form->field($model, 'total') ?>

    <?php // echo $form->field($model, 'order_total') ?>

    <?php // echo $form->field($model, 'coupon_total') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'pay_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
