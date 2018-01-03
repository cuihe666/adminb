<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\PlaneTicketOrder */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="plane-ticket-order-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'order_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'order_uid')->textInput() ?>

    <?= $form->field($model, 'ticket_supplier_id')->textInput() ?>

    <?= $form->field($model, 'insurance_supplier_id')->textInput() ?>

    <?= $form->field($model, 'pay_platform')->textInput() ?>

    <?= $form->field($model, 'pay_status')->textInput() ?>

    <?= $form->field($model, 'order_status')->textInput() ?>

    <?= $form->field($model, 'process_status')->textInput() ?>

    <?= $form->field($model, 'dis_amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pay_amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'total_amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payment_time')->textInput() ?>

    <?= $form->field($model, 'city_start_id')->textInput() ?>

    <?= $form->field($model, 'city_end_id')->textInput() ?>

    <?= $form->field($model, 'airline_company_id')->textInput() ?>

    <?= $form->field($model, 'flight_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'flight_model')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fly_start_time')->textInput() ?>

    <?= $form->field($model, 'fly_end_time')->textInput() ?>

    <?= $form->field($model, 'fly_start_airport')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fly_end_airport')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'have_meals')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'stop_over_city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contacts')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contacts_phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'express_money')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'express_addressee')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'express_addressee_address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'express_addressee_tel')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'guest_num')->textInput() ?>

    <?= $form->field($model, 'insurance_num')->textInput() ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <?= $form->field($model, 'update_time')->textInput() ?>

    <?= $form->field($model, 'admin_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
