<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TravelSettleDetail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="travel-settle-detail-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'settle_id')->textInput() ?>

    <?= $form->field($model, 'order_id')->textInput() ?>

    <?= $form->field($model, 'order_num')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'travel_id')->textInput() ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <?= $form->field($model, 'type')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
