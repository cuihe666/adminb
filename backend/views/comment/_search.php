<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CommentQuery */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="comment-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'uid') ?>

    <?= $form->field($model, 'obj_id') ?>

    <?= $form->field($model, 'order_id') ?>

    <?= $form->field($model, 'obj_type') ?>

    <?php // echo $form->field($model, 'state') ?>

    <?php // echo $form->field($model, 'content') ?>

    <?php // echo $form->field($model, 'pic') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <?php // echo $form->field($model, 'update_time') ?>

    <?php // echo $form->field($model, 'is_delete') ?>

    <?php // echo $form->field($model, 'is_read') ?>

    <?php // echo $form->field($model, 'child_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
