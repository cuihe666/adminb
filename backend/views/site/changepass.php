<?php
$this->title = '修改密码';
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

?>


<div class="wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox">
                <div class="ibox-content">
                    <div class="member-form">

                        <?php
                        $form = ActiveForm::begin([
                            'id' => 'aritcleform',
                            'layout' => 'horizontal',
                            'fieldConfig' => [
                                'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
                                'horizontalCssClasses' => [
                                    'label' => 'col-sm-2 control-label',
                                    'wrapper' => 'wrapper',
                                    'error' => '',
                                    'hint' => ''
                                ],
                                'wrapperOptions' => [
                                    'class' => 'col-sm-3'
                                ],
                                'inputOptions' => [
                                    'class' => 'form-control'
                                ],
                                'hintOptions' => [
                                    'class' => 'Validform_checktip'
                                ],
                            ],
                            'options' => [
                                'class' => 'form-horizontal',
                                'id' => 'signupForm',
                                'enctype' => 'multipart/form-data'
                            ]
                        ]);
                        ?>

                        <?= $form->field($model, 'password_hash')->passwordInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'new_password')->passwordInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'confirm_password')->passwordInput(['maxlength' => true]) ?>


                        <div class="form-group">
                            <label class="col-sm-2 control-label btn_no"></label>
                            <div class="col-sm-6">
                                <?= Html::submitButton('确定', ['class' => 'btn btn-primary']) ?>
                            </div>
                        </div>

                        <?php ActiveForm::end(); ?>

                    </div>
                    <style>
                        .control-label:after {
                            content: "：";
                        }

                        .btn_no:after {
                            content: '';
                        }
                    </style>

                </div>
            </div>
        </div>
    </div>

