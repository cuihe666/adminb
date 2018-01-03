<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\LocalServe */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="local-serve-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'serve_price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'serve_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'serve_content')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <?= $form->field($model, 'update_time')->textInput() ?>

    <?= $form->field($model, 'is_delete')->textInput() ?>

    <?= $form->field($model, 'serve_way')->textInput() ?>

    <?= $form->field($model, 'cover_img')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'serve_img')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'serve_type_id')->textInput() ?>

    <?= $form->field($model, 'uid')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
