<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\HotelOrder */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="hotel-order-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'order_num')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'transaction_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'hotel_id')->textInput() ?>

    <?= $form->field($model, 'hotel_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'hotel_house_id')->textInput() ?>

    <?= $form->field($model, 'hotel_house_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'hotel_type')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'pay_platform')->textInput() ?>

    <?= $form->field($model, 'refund_rule')->textInput() ?>

    <?= $form->field($model, 'bed_type')->textInput() ?>

    <?= $form->field($model, 'breakfast')->textInput() ?>

    <?= $form->field($model, 'order_uid')->textInput() ?>

    <?= $form->field($model, 'order_mobile')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'prompt')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'preference')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'in_time')->textInput() ?>

    <?= $form->field($model, 'out_time')->textInput() ?>

    <?= $form->field($model, 'province')->textInput() ?>

    <?= $form->field($model, 'city')->textInput() ?>

    <?= $form->field($model, 'area')->textInput() ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mobile_area')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mobile')->textInput() ?>

    <?= $form->field($model, 'order_total')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pay_total')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'hotel_income')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tango_income')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <?= $form->field($model, 'update_time')->textInput() ?>

    <?= $form->field($model, 'is_delete')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
