<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\daterange\DateRangePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\UserBackend */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-backend-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'theme_name')->textInput() ?>
    <?= $form->field($model, 'theme_url')->textInput() ?>
    <?php
    if($model->start_date !="" && $model->end_date != ""):
    ?>
    <?= $form->field($model, 'stime')->widget(DateRangePicker::className(),[
        'model' => $model,
        'attribute' => 'stime',
        'convertFormat' => true,
        'language' => 'zh-CN',
        'options' => [
            'placeholder' => '请选择开始日期—结束日期',
            'class' => 'form-control',
            'readonly' => true,
        ],
        'pluginOptions' => [
            'timePicker' => false,
            'timePickerIncrement' => 30,
            'locale' => [
                'format' => 'Y-m-d'
            ]
        ]
    ]) ?>
    <?= $form->field($model, 'status')->dropDownList(Yii::$app->params['status'], ['prompt'=> '==请选择状态==']) ?>

        <?php
    endif;
    ?>
    <div class="form-group submit-1">
        <?= Html::submitButton($method, ['class' => 'btn btn-success']) ?>
        <?= Html::a("返回",$url = ['active-theme/index'],$options = ['class' => 'btn btn-sm btn-primary',"style"=>"line-height:22px;"]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
