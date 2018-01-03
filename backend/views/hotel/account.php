<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model backend\models\UserBackend */

$this->title = '账号信息';
/*$this->params['breadcrumbs'][] = ['label' => 'User Backends', 'url' => ['index']];*/
$this->params['breadcrumbs'][] = $this->title;
\backend\assets\ScrollAsset::register($this);
?>

<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<!-- Bootstrap 3.3.6 -->
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/bootstrap/css/bootstrap-datetimepicker.min.css">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/dist/css/AdminLTE.min.css">
<!-- AdminLTE Skins. We have chosen the skin-blue for this starter
      page. However, you can choose any other skin. Make sure you
      apply the skin class to the body tag so the changes take effect.
-->
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/dist/css/skins/skin-blue.min.css">
<!--new link-->
<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/dist/css/rummery.css"/>
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/dist/css/gobal.css" />
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/dist/css/xhhgrogshop.css" />
<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/layer/skin/default/layer.css"/>
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<style>
    .hotel_information_tips,.hostshort_b{
        color:red;
    }
    .reminder p{
        color:#999;
    }
    #account_type{
        margin-top:-18px;
        margin-left: 104px;
    }
    #account_type label{
        margin-left:15px;
    }
</style>

<script>
    $(function () {
        var settle_obj = <?= $model->account_type?>;
        if (settle_obj == 0) {
            $(".hotel_account_info").hide();
        }
    });
</script>

<body class="hold-transition skin-blue sidebar-mini">


<!-- Content Wrapper. Contains page content -->
<div class="wrapper-content animated fadeInRight" style="background-color: #F2F2F2;">
    <!-- Content Header (Page header) -->

    <?= \backend\widgets\ElementAlertWidget::widget() ?>
    <!-- Main content -->
    <section class="content">
        <ul class="rummery_tab clearfix">
            <li class="col-sm-8"><a href="<?php echo \yii\helpers\Url::to(['hotel/update','id'=>$model->hotel_id]) ?>">酒店信息</a></li>
            <li class="col-sm-8 current"><a href="###">账号信息</a></li>
            <li class="col-sm-8"><a href="<?php echo \yii\helpers\Url::to(['hotel/two','id'=>$model->hotel_id]) ?>">酒店政策</a></li>
            <li class="col-sm-8"><a href="<?php echo \yii\helpers\Url::to(['hotel/three','id'=>$model->hotel_id]) ?>">服务设施</a></li>
            <li class="col-sm-8"><a href="<?php echo \yii\helpers\Url::to(['hotel/four','id'=>$model->hotel_id]) ?>">房型管理</a></li>
            <li class="col-sm-8"><a href="<?php echo \yii\helpers\Url::to(['hotel/set-price','hotel_id'=>$model->hotel_id]) ?>">房态房价设置</a></li>
            <li class="col-sm-8"><a href="<?php echo \yii\helpers\Url::to(['hotel/hotel-pic','id'=>$model->hotel_id]) ?>">图片管理</a></li>
            <li class="col-sm-8"><a href="<?php echo \yii\helpers\Url::to(['hotel/supplier','id'=>$model->hotel_id]) ?>">关联供应商</a></li>
            <li class="col-sm-8"><a href="<?php echo \yii\helpers\Url::to(['hotel/contact','id'=>$model->hotel_id]) ?>">联系人信息</a></li>
        </ul>
        <input type="hidden" id="top_account_type_val" value="<?= isset($settle_obj) ? $settle_obj : 0 ?>">
        <?= Html::beginForm('', 'post', ['enctype' => 'multipart/form-data',"class"=>'hotel-form', 'id' => 'account-form']) ?>
        <div class="rummery_con">
            <div class="rummery_item rummery_policy">
                <div class="xhh_conent">
                    <ul class="conent-time">
                        <li style="margin-top: 10px;">
                            <i>*&nbsp;&nbsp;</i>
                            <span>打款方式：</span>
                            <?= Html::activeRadioList($model, 'account_type', [0 => '打款至酒店供应商账户', 1 => '打款至酒店账户'], ['id' => 'account_type'])?>
                        </li>
                        <script>
                            $('body').on('change', "#account_type", function () {
                                var account_type=$('input:radio[name="HotelSupplierAccount[account_type]"]:checked').val();
                                if (account_type == 0) {//用户选择了打款至供应商，此时隐藏下面的酒店账户信息
                                    $("#top_account_type_val").val("0");
                                    $(".hotel_account_info").hide();
                                } else {//用户选择了打款至酒店，此时显示下面的酒店账户信息
                                    $("#top_account_type_val").val("1");
                                    $(".hotel_account_info").show();
                                }
                            });
                        </script>
                        <li class="hotel_account_info">
                            <i>*&nbsp;&nbsp;</i>
                            <span>财务联系人：</span>
                            <?= Html::activeInput('text',$model,'user_name',['id' => 'hinese']) ?>
                            <i class="hinese_b"></i>
                        </li>
                        <li class="hotel_account_info">
                            <i>*&nbsp;&nbsp;</i>
                            <span>联系人手机：</span>
                            <?= Html::activeInput('text',$model,'mobile',['id' => 'cellNumber']) ?>
                            <i class="cellNumber_b"></i>
                        </li>
                        <li class="hotel_account_info">
                            <i>&nbsp;&nbsp;&nbsp;</i>
                            <span>联系人邮箱：</span>
                            <?= Html::activeInput('text',$model,'email',['id' => 'checkMail']) ?>
                            <i class="checkMail_b"></i>
                        </li>
                        <li class="hotel_account_info">
                            <i>*&nbsp;&nbsp;</i>
                            <span>银行名称：</span>
                            <?= Html::activeInput('text',$model,'bank_name',['id' => 'bankname']) ?>
                            <i class="bankname_b" style="color:#999;">请确保开户银行名称填写正确，否则无法正常打款</i>
                        </li>
                        <li class="hotel_account_info">
                            <i>*&nbsp;&nbsp;</i>
                            <span>开户支行名称：</span>
                            <?= Html::activeInput('text',$model,'bank_detail',['id' => 'openingbank']) ?>
                            <i class="openingbank_b" style="color:#999;">请确保支行名称填写正确，否则无法正常打款</i>
                        </li>
                        <li class="hotel_account_info">
                            <i>*&nbsp;&nbsp;</i>
                            <span>户名：</span>
                            <?= Html::activeInput('text',$model,'account_name',['id' => 'username']) ?>
                            <i class="username"></i>
                        </li>
                        <li class="hotel_account_info">
                            <i>*&nbsp;&nbsp;</i>
                            <span>银行账号：</span>
                            <?= Html::activeInput('text',$model,'account_number',['id' => 'account_number']) ?>
                            <i class="account_number_b"></i>
                        </li>
                        <li class="hotel_account_info">
                            <i>&nbsp;&nbsp;&nbsp;</i>
                            <span>支付宝账号：</span>
                            <?= Html::activeInput('text',$model,'alipay_number') ?>
                        </li>
                        <li class="hotel_account_info">
                            <i>*&nbsp;&nbsp;</i>
                            <span>账户类型：</span>
                            <?= Html::activeDropDownList($model,'type',Yii::$app->params['hotel_supplier_account_type_insert']) ?>
                        </li>
                        <div class="policy-footer">
                            <!-- 酒店ID -->
                            <?= Html::activeHiddenInput($model,'hotel_id',['value' => $model->hotel_id]) ?>
                            <!-- 酒店账户信息是否存在的标记值 -->
                            <?= Html::activeHiddenInput($model,'hotel_account_note',['value' => (isset($hotel_account_note) ? $hotel_account_note : '')]) ?>
                            <?= Html::submitButton('保存并继续',['class' => 'message-footer-save']) ?>
                        </div>
                    </ul>
                </div>
            </div>
        </div>
        <?= Html::endForm();?>

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<div class="control-sidebar-bg"></div>


<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.2.3 -->
<script src="<?= Yii::$app->request->baseUrl ?>/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?= Yii::$app->request->baseUrl ?>/bootstrap/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= Yii::$app->request->baseUrl ?>/dist/js/app.min.js"></script>
<!--new link-->
<script src="<?= Yii::$app->request->baseUrl ?>/dist/js/rummery.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/dist/js/gobal.js"></script>
<!-- 酒店2.1 填写账户信息前端验证 ↓ -->
<script src="<?= Yii::$app->request->baseUrl ?>/hotel/js/gobal.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/hotel/js/rummery.js"></script>
<!-- 酒店2.1 ↑ -->
<script src="<?= Yii::$app->request->baseUrl ?>/layer/layer.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/My97DatePicker/WdatePicker.js"></script>

<script src="http://webapi.amap.com/ui/1.0/main.js"></script>
<script type="text/javascript" src="http://webapi.amap.com/demos/js/liteToolbar.js"></script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. Slimscroll is required when using the
     fixed layout. -->
</body>
</html>

