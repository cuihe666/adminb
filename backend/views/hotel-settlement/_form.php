<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\HotelSupplierSettlement */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="hotel-supplier-settlement-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'settle_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'hotel_id')->textInput() ?>

    <?= $form->field($model, 'supplier_id')->textInput() ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <?= $form->field($model, 'total')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'order_total')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'coupon_total')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'pay_time')->textInput() ?>

    <?= $form->field($model, 'agent_total')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tangguo_total')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fail_cause')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'serial_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'start_time')->textInput() ?>

    <?= $form->field($model, 'end_time')->textInput() ?>

    <?= $form->field($model, 'invoice')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
