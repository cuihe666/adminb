<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\LocalServeQuery */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="local-serve-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'serve_price') ?>

    <?= $form->field($model, 'serve_name') ?>

    <?= $form->field($model, 'serve_content') ?>

    <?= $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <?php // echo $form->field($model, 'update_time') ?>

    <?php // echo $form->field($model, 'is_delete') ?>

    <?php // echo $form->field($model, 'serve_way') ?>

    <?php // echo $form->field($model, 'cover_img') ?>

    <?php // echo $form->field($model, 'serve_img') ?>

    <?php // echo $form->field($model, 'serve_type_id') ?>

    <?php // echo $form->field($model, 'uid') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
