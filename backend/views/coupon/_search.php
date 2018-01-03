<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CouponBatchQuery */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="coupon-batch-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'type') ?>

    <?= $form->field($model, 'is_forever') ?>

    <?= $form->field($model, 'mode') ?>

    <?php // echo $form->field($model, 'amount') ?>

    <?php // echo $form->field($model, 'num') ?>

    <?php // echo $form->field($model, 'max_num') ?>

    <?php // echo $form->field($model, 'rule') ?>

    <?php // echo $form->field($model, 'start_time') ?>

    <?php // echo $form->field($model, 'end_time') ?>

    <?php // echo $form->field($model, 'create_name') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'update_time') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
