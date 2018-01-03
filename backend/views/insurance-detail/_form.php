<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\PlaneTicketOrderEmplane */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="plane-ticket-order-emplane-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'order_id')->textInput() ?>

    <?= $form->field($model, 'ticket_supplier_id')->textInput() ?>

    <?= $form->field($model, 'insurance_supplier_id')->textInput() ?>

    <?= $form->field($model, 'ticket_type')->textInput() ?>

    <?= $form->field($model, 'pre_price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'insurance_type')->textInput() ?>

    <?= $form->field($model, 'insurance_money')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mb_fuel')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'card_type')->textInput() ?>

    <?= $form->field($model, 'card_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'refund_ticket_status')->textInput() ?>

    <?= $form->field($model, 'refund_insurance_status')->textInput() ?>

    <?= $form->field($model, 'ticket_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'insurance_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ticket_commision')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'insurance_commision')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <?= $form->field($model, 'update_time')->textInput() ?>

    <?= $form->field($model, 'admin_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
