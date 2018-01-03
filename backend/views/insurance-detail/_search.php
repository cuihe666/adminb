<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\PlaneTicketOrderEmplaneQuery */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="plane-ticket-order-emplane-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'order_id') ?>

    <?= $form->field($model, 'ticket_supplier_id') ?>

    <?= $form->field($model, 'insurance_supplier_id') ?>

    <?= $form->field($model, 'ticket_type') ?>

    <?php // echo $form->field($model, 'pre_price') ?>

    <?php // echo $form->field($model, 'insurance_type') ?>

    <?php // echo $form->field($model, 'insurance_money') ?>

    <?php // echo $form->field($model, 'mb_fuel') ?>

    <?php // echo $form->field($model, 'name') ?>

    <?php // echo $form->field($model, 'phone') ?>

    <?php // echo $form->field($model, 'card_type') ?>

    <?php // echo $form->field($model, 'card_no') ?>

    <?php // echo $form->field($model, 'refund_ticket_status') ?>

    <?php // echo $form->field($model, 'refund_insurance_status') ?>

    <?php // echo $form->field($model, 'ticket_no') ?>

    <?php // echo $form->field($model, 'insurance_no') ?>

    <?php // echo $form->field($model, 'ticket_commision') ?>

    <?php // echo $form->field($model, 'insurance_commision') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <?php // echo $form->field($model, 'update_time') ?>

    <?php // echo $form->field($model, 'admin_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
