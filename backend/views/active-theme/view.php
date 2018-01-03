<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model backend\models\UserBackend */

$this->title = '查看活动主题';
/*$this->params['breadcrumbs'][] = ['label' => 'User Backends', 'url' => ['index']];*/
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    <!--
    .hr-border{background-color:green;height:2px;border:none; margin: 0;}
    .form-views{ margin-top: 20px;}
    .submit-1{ margin:20px auto;}
    .user-backend-form .form-div{ overflow: hidden; line-height: 38px; margin-bottom:15px;}
    .user-backend-form .form-div .form-label{ width:120px; float: left; text-align: right; padding-right:10px;}
    .user-backend-form .form-div .form-span{ width:400px; float:left;}
    .submit-1{ width:100px; margin:0 auto;}
    -->
</style>
<hr class="hr-border">
<div class="user-backend-create">

    <div class="user-backend-form form-views">

        <?php $form = ActiveForm::begin(); ?>
        <div class="form-div">
            <label class="form-label">活动主题：</label>
            <span class="form-span">
                <?= $model->theme_name; ?>
            </span>
        </div>
        <div class="form-div">
            <label class="form-label">活动Url：</label>
            <span class="form-span">
                <?= $model->theme_url; ?>
            </span>
        </div>
        <div class="form-div">
            <label class="form-label">开始时间：</label>
            <span class="form-span">
                <?= $model->start_date!="" ? date("Y-m-d",$model->start_date) : "未设置"; ?>
            </span>
        </div>
        <div class="form-div">
            <label class="form-label">结束时间：</label>
            <span class="form-span">
                <?= $model->end_date!="" ? date("Y-m-d",$model->end_date) : "未设置"; ?>
            </span>
        </div>
        <div class="form-div">
            <label class="form-label">状态：</label>
            <span class="form-span">
                <?= Yii::$app->params['status'][$model->status]; ?>
            </span>
        </div>
        <div class="form-div">
            <label class="form-label">添加时间：</label>
            <span class="form-span">
                <?= date("Y-m-d H:i:s",$model->create_time); ?>
            </span>
        </div>
        <div class="form-group submit-1">
            <?= Html::a("返回",$url = ['active-theme/index'],$options = ['class' => 'btn btn-sm btn-primary',"style"=>"line-height:30px;"]) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
