<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model backend\models\UserBackend */

$this->title = '创建二维码';
/*$this->params['breadcrumbs'][] = ['label' => 'User Backends', 'url' => ['index']];*/
$this->params['breadcrumbs'][] = $this->title;
?>
<script src="<?= Yii::$app->request->baseUrl ?>/js/jquery.min.js"></script>

<style>
    <!--
    .submit-1{ margin:20px auto;}
    .form-group{ overflow: hidden}
    .form-group .control-label{ width:120px; float: left; text-align: right; padding-right:10px;}
    .form-group .form-control{ display: inline-block; width:200px; float: left;}
    -->
</style>
<div class="user-backend-create">

    <div class="user-backend-form">

        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'theme_id')->dropDownList(\backend\models\Qrcode::getActiveTheme(), ['prompt'=> '==请选择活动主题==']) ?>
        <?= $form->field($model, 'city_code')->dropDownList($country, ['prompt'=> '==请选择区域==','class' => 'form-control region','level'=>1]) ?>
<!--
        <?/*= $form->field($model, 'custom1')->dropDownList(Yii::$app->params['qrcode_custom1'], ['prompt'=> '==请选择自定义参数==','class' => 'form-control region','level'=>1]) */?>
        -->
        <div class="form-group field-qrcode-custom1">
            <label class="control-label" for="qrcode-custom1">自定义参数1</label>
            <input type="text" id="qrcode-custom1" class="form-control" name="Qrcode[custom1]" maxlength="5">
            <b style="font-weight: normal; color: red; display: inline-block; height: 34px; line-height: 34px; margin-left:8px;">最多输入5个字</b>
            <div class="help-block"></div>
        </div>
        <div class="form-group submit-1">
            <?= Html::submitButton('创建', ['class' => 'btn btn-success']) ?>
            <?= Html::a("返回",$url = ['qrcode/index'],$options = ['class' => 'btn btn-sm btn-primary',"style"=>"line-height:22px;"]) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
<script>
$(".user-backend-form").on("change",".region",function(){
    //alert(0);
    var code = $(this).val();
    var level = $(this).attr("level");
    var _this = $(this);
    var nextLevel = parseInt(level)+1;
    if(code==""){
        $(this).nextAll().remove();
    }
    $.ajax({
        type: 'GET',
        url: '<?= \yii\helpers\Url::toRoute(["region/getregion"])?>',
        data: {"level": level,"code":code},
        dataType: 'json',
        success: function (data) {
            if(data || data.length>0){
                console.log(data);
                var html = '<select id="region_name" style="margin-left:15px;" class="form-control region" name="Qrcode[city_code'+level+']" level='+nextLevel+'></span><option value="">====请选择====</option>';
                $.each(data, function(index, content){
                    html += '<option value="'+index+'">'+content+'</option>';
                });
                html += '</select>';
                _this.nextAll().remove();
                _this.after(html);
            }
        },/*
        error: function (XMLHttpRequest, textStatus, errorThrown) {

        }*/
    });
});
function selectNext(level){
    var code = $(this).val();
    alert(code);
    exit;
    $.ajax({
        type: 'GET',
        url: '<?= \yii\helpers\Url::toRoute(["region/getregion"])?>',
        data: {"level": level},
        dataType: 'json',
        success: function (data) {
            console.log(data);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {

        }
    });
}

</script>
