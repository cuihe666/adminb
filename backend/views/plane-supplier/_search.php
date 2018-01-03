<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\PlaneTicketSupplierQuery */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="plane-ticket-supplier-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'ticket_genre') ?>

    <?= $form->field($model, 'insurance_genre') ?>

    <?= $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'contacts') ?>

    <?php // echo $form->field($model, 'contacts_phone') ?>

    <?php // echo $form->field($model, 'is_use') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <?php // echo $form->field($model, 'update_time') ?>

    <?php // echo $form->field($model, 'admin_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
