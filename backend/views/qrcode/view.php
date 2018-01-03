<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model backend\models\UserBackend */

$this->title = '查看二维码';
/*$this->params['breadcrumbs'][] = ['label' => 'User Backends', 'url' => ['index']];*/
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    <!--
    .submit-1{ margin:20px auto;}
    .user-backend-form .form-div{ overflow: hidden; line-height: 38px; margin-bottom:15px;}
    .user-backend-form .form-div .form-label{ width:120px; float: left; text-align: right; padding-right:10px;}
    .user-backend-form .form-div .form-span{ min-width:400px; width: auto; float:left;}
    .submit-1{ width:100px; margin:0 auto;}
    -->
</style>
<div class="user-backend-create">

    <div class="user-backend-form">

        <?php $form = ActiveForm::begin(); ?>
        <div class="form-div">
            <label class="form-label">活动主题：</label>
            <span class="form-span">
                <?= \backend\models\Qrcode::getActiveTheme()[$model->theme_id]; ?>
            </span>
        </div>
        <div class="form-div">
            <label class="form-label">城市：</label>
            <span class="form-span">
                <?= \backend\models\Qrcode::getRegionName($model->city_code); ?>
            </span>
        </div>
        <div class="form-div">
            <label class="form-label">扫描量：</label>
            <span class="form-span">
                <?= $model->scan_num; ?>
            </span>
        </div>
        <div class="form-div">
            <label class="form-label">添加时间：</label>
            <span class="form-span">
                <?= date("Y-m-d H:i:s",$model->create_time); ?>
            </span>
        </div>
        <div class="form-div">
            <label class="form-label">二维码url：</label>
            <span class="form-span">
                <?=$model->qrcode_url?>
            </span>
        </div>
        <div class="form-div">
            <label class="form-label">二维码：</label>
            <span class="form-span">
                <img src="<?= \yii\helpers\Url::to(['qrcode/buildqrcode','url' => $model->qrcode_url])?>" />
            </span>
        </div>
        <div class="form-group submit-1">
            <?= Html::a("返回",$url = ['qrcode/index'],$options = ['class' => 'btn btn-sm btn-primary',"style"=>"line-height:30px;"]) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
