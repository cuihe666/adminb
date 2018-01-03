<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\daterange\DateRangePicker;


/* @var $this yii\web\View */
/* @var $model backend\models\UserBackend */

$this->title = '创建活动主题';
/*$this->params['breadcrumbs'][] = ['label' => 'User Backends', 'url' => ['index']];*/
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    <!--
    .hr-border{background-color:green;height:2px;border:none; margin: 0;}
    .form-views{ margin-top: 20px;}
    .submit-1{ margin:20px auto;}
    .user-backend-form .form-div{ overflow: hidden; height:38px; line-height: 38px; margin-bottom:15px;}
    .user-backend-form .form-div .form-label{ width:160px; float: left; text-align: right; padding-right:10px;}
    .user-backend-form .form-div .form-span{ width:300px; float:left;}
    -->
</style>

<hr class="hr-border">
<div class="user-backend-create form-views">

    <?= $this->render('_form', [
        'model' => $model,
        'method' => '创建',
    ]) ?>


</div>
