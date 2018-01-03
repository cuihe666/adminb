<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\PlaneTicketOrderQuery */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="plane-ticket-order-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'order_no') ?>

    <?= $form->field($model, 'order_uid') ?>

    <?= $form->field($model, 'ticket_supplier_id') ?>

    <?= $form->field($model, 'insurance_supplier_id') ?>

    <?php // echo $form->field($model, 'order_source') ?>

    <?php // echo $form->field($model, 'pay_platform') ?>

    <?php // echo $form->field($model, 'pay_status') ?>

    <?php // echo $form->field($model, 'order_status') ?>

    <?php // echo $form->field($model, 'process_status') ?>

    <?php // echo $form->field($model, 'dis_amount') ?>

    <?php // echo $form->field($model, 'pay_amount') ?>

    <?php // echo $form->field($model, 'total_amount') ?>

    <?php // echo $form->field($model, 'payment_time') ?>

    <?php // echo $form->field($model, 'city_start_id') ?>

    <?php // echo $form->field($model, 'city_end_id') ?>

    <?php // echo $form->field($model, 'airline_company_id') ?>

    <?php // echo $form->field($model, 'flight_number') ?>

    <?php // echo $form->field($model, 'flight_model') ?>

    <?php // echo $form->field($model, 'fly_start_time') ?>

    <?php // echo $form->field($model, 'fly_end_time') ?>

    <?php // echo $form->field($model, 'fly_start_airport') ?>

    <?php // echo $form->field($model, 'fly_end_airport') ?>

    <?php // echo $form->field($model, 'have_meals') ?>

    <?php // echo $form->field($model, 'stop_over_city') ?>

    <?php // echo $form->field($model, 'contacts') ?>

    <?php // echo $form->field($model, 'contacts_phone') ?>

    <?php // echo $form->field($model, 'express_money') ?>

    <?php // echo $form->field($model, 'express_addressee') ?>

    <?php // echo $form->field($model, 'express_addressee_address') ?>

    <?php // echo $form->field($model, 'express_addressee_tel') ?>

    <?php // echo $form->field($model, 'guest_num') ?>

    <?php // echo $form->field($model, 'insurance_num') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <?php // echo $form->field($model, 'update_time') ?>

    <?php // echo $form->field($model, 'admin_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
