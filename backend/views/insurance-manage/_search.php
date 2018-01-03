<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\PlaneTicketInsuranceGoodsManageQuery */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="plane-ticket-insurance-goods-manage-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'supplier_id') ?>

    <?= $form->field($model, 'type') ?>

    <?= $form->field($model, 'price') ?>

    <?= $form->field($model, 'insurance_fee') ?>

    <?php // echo $form->field($model, 'ratio') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <?php // echo $form->field($model, 'update_time') ?>

    <?php // echo $form->field($model, 'admin_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
