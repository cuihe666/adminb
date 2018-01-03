<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TravelOrderQuery */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="travel-order-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'order_uid') ?>

    <?= $form->field($model, 'travel_uid') ?>

    <?= $form->field($model, 'travel_id') ?>

    <?= $form->field($model, 'order_no') ?>

    <?php // echo $form->field($model, 'trade_no') ?>

    <?php // echo $form->field($model, 'activity_date') ?>

    <?php // echo $form->field($model, 'travel_name') ?>

    <?php // echo $form->field($model, 'title_pic') ?>

    <?php // echo $form->field($model, 'state') ?>

    <?php // echo $form->field($model, 'refund_stauts') ?>

    <?php // echo $form->field($model, 'contacts') ?>

    <?php // echo $form->field($model, 'mobile_phone') ?>

    <?php // echo $form->field($model, 'adult') ?>

    <?php // echo $form->field($model, 'child') ?>

    <?php // echo $form->field($model, 'coupon_amount') ?>

    <?php // echo $form->field($model, 'pay_amount') ?>

    <?php // echo $form->field($model, 'total') ?>

    <?php // echo $form->field($model, 'pay_platform') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'is_confirm') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <?php // echo $form->field($model, 'anum') ?>

    <?php // echo $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'confirm_time') ?>

    <?php // echo $form->field($model, 'refund_day') ?>

    <?php // echo $form->field($model, 'theme_type') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
