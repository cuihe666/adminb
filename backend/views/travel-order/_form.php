<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TravelOrder */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="travel-order-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'order_uid')->textInput() ?>

    <?= $form->field($model, 'travel_uid')->textInput() ?>

    <?= $form->field($model, 'travel_id')->textInput() ?>

    <?= $form->field($model, 'order_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'trade_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'activity_date')->textInput() ?>

    <?= $form->field($model, 'travel_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title_pic')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'state')->textInput() ?>

    <?= $form->field($model, 'refund_stauts')->textInput() ?>

    <?= $form->field($model, 'contacts')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mobile_phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'adult')->textInput() ?>

    <?= $form->field($model, 'child')->textInput() ?>

    <?= $form->field($model, 'coupon_amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pay_amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'total')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pay_platform')->textInput() ?>

    <?= $form->field($model, 'type')->textInput() ?>

    <?= $form->field($model, 'is_confirm')->textInput() ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <?= $form->field($model, 'anum')->textInput() ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'confirm_time')->textInput() ?>

    <?= $form->field($model, 'refund_day')->textInput() ?>

    <?= $form->field($model, 'theme_type')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
