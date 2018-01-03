<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\HotelSupplierSettlementQuery */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="hotel-supplier-settlement-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'settle_id') ?>

    <?= $form->field($model, 'hotel_id') ?>

    <?= $form->field($model, 'supplier_id') ?>

    <?= $form->field($model, 'create_time') ?>

    <?php // echo $form->field($model, 'total') ?>

    <?php // echo $form->field($model, 'order_total') ?>

    <?php // echo $form->field($model, 'coupon_total') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'pay_time') ?>

    <?php // echo $form->field($model, 'agent_total') ?>

    <?php // echo $form->field($model, 'tangguo_total') ?>

    <?php // echo $form->field($model, 'fail_cause') ?>

    <?php // echo $form->field($model, 'serial_number') ?>

    <?php // echo $form->field($model, 'start_time') ?>

    <?php // echo $form->field($model, 'end_time') ?>

    <?php // echo $form->field($model, 'invoice') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
