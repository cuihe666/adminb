<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\PlaneTicketInsuranceGoodsManage */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="plane-ticket-insurance-goods-manage-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'supplier_id')->textInput() ?>

    <?= $form->field($model, 'type')->textInput() ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'insurance_fee')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ratio')->textInput() ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <?= $form->field($model, 'update_time')->textInput() ?>

    <?= $form->field($model, 'admin_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
