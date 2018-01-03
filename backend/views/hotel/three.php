<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model backend\models\UserBackend */

$this->title = '基本信息';
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
</style>



<body class="hold-transition skin-blue sidebar-mini">


    <!-- Content Wrapper. Contains page content -->
    <div class="wrapper-content animated fadeInRight" style="background-color: #F2F2F2;">
        <!-- Content Header (Page header) -->
        <?= \backend\widgets\ElementAlertWidget::widget() ?>
        <!-- Main content -->
        <section class="content">
            <ul class="rummery_tab clearfix">
                <li class="col-sm-8"><a href="<?php echo \yii\helpers\Url::to(['hotel/update','id'=>$model->id]) ?>">酒店信息</a></li>
                <!-- 酒店2.1 添加酒店账户信息 ↓ admin:ys time:2017/11/3 -->
                <li class="col-sm-8"><a href="<?php echo \yii\helpers\Url::to(['hotel/hotel-account','id'=>$model->id]) ?>">账号信息</a></li>
                <!-- 完 ↑ -->
                <li class="col-sm-8"><a href="<?php echo \yii\helpers\Url::to(['hotel/two','id'=>$model->id]) ?>">酒店政策</a></li>
                <li class="col-sm-8 current"><a href="###">服务设施</a></li>
                <li class="col-sm-8"><a href="<?php echo \yii\helpers\Url::to(['hotel/four','id'=>$model->id]) ?>">房型管理</a></li>
                <li class="col-sm-8"><a href="<?php echo \yii\helpers\Url::to(['hotel/set-price','hotel_id'=>$model->id]) ?>">房态房价设置</a></li>
                <li class="col-sm-8"><a href="<?php echo \yii\helpers\Url::to(['hotel/hotel-pic','id'=>$model->id]) ?>">图片管理</a></li>
                <li class="col-sm-8"><a href="<?php echo \yii\helpers\Url::to(['hotel/supplier','id'=>$model->id]) ?>">关联供应商</a></li>
                <li class="col-sm-8"><a href="<?php echo \yii\helpers\Url::to(['hotel/contact','id'=>$model->id]) ?>">联系人信息</a></li>
            </ul>
            <?= Html::beginForm('', 'post', ['enctype' => 'multipart/form-data',"class"=>'hotel-form']) ?>
            <div class="rummery_con">
                <div class="rummery_item rummery_sevice">
                    <div class="conent-time cont-facility">
                        <div class="xhh_conent">
                            <!--核心设施-->
                            <div class="cont-facility-one">
                                <i class="reddot">*&nbsp;&nbsp;</i>
                                <p>
                                    设施服务
                                </p>
                                <p class="kernel" style="text-indent: 10px;">
                                    核心设施
                                </p>
                                <ul class="check" id="check">
                                    <?php
                                    if($facilities[1] != null){
                                        foreach($facilities[1] as $key=>$val){
                                            $check = "";
                                            if(in_array($key,$ser_fac))
                                                $check = "checked";
                                            else
                                                $check = "";
                                    ?>
                                    <li>
                                        <span><?=$val?>：</span>
                                        <input type="checkbox" id="one_checkbox_a1" value="<?=$key?>" <?=$check?> class="chk_1 core" name="facilities[]"/>
                                        <label for="one_checkbox_a1" ></label>

                                    </li>
                                    <?php
                                        }
                                    }
                                    ?>

                                </ul>
                                <div style="clear: both;"></div>
                            </div>
                            <i class="sheshi_i red"></i>
                            <!--房间设施-->
                            <div class="cont-facility-two">
                                <i class="reddot">*&nbsp;&nbsp;</i>
                                <p class="kernel kernel-top">
                                    房间设施
                                </p>
                                <ul class="check" id="check">
                                    <?php
                                    if($facilities[2] != null){
                                        foreach($facilities[2] as $key=>$val){
                                            $check = "";
                                            if(in_array($key,$ser_fac))
                                                $check = "checked";
                                            else
                                                $check = "";
                                    ?>
                                    <li>
                                        <span><?=$val?>：</span>
                                        <input type="checkbox" id="two_checkbox_a1" value="<?=$key?>" <?=$check?> class="chk_1 house" name="facilities[]" />
                                        <label for="two_checkbox_a1"></label>
                                    </li>
                                    <?php
                                        }
                                    }
                                    ?>
                                </ul>
                                <div style="clear: both;"></div>
                            </div>
                            <i class="home_i red"></i>
                            <!--酒店服务-->
                            <div class="cont-facility-three">
                                <i class="reddot">*&nbsp;&nbsp;</i>
                                <p class="kernel kernel-top">
                                    酒店服务
                                </p>
                                <ul class="check" id="check">
                                    <?php
                                    if($facilities[3] != null){
                                    foreach($facilities[3] as $key=>$val){
                                        $check = "";
                                        if(in_array($key,$ser_fac))
                                            $check = "checked";
                                        else
                                            $check = "";
                                    ?>
                                    <li>
                                        <span><?=$val?>：</span>
                                        <input type="checkbox" id="th_checkbox_a1" value="<?=$key?>" <?=$check?> class="chk_1 service" name="facilities[]" />
                                        <label for="th_checkbox_a1"></label>
                                    </li>
                                    <?php
                                        }
                                    }
                                    ?>
                                </ul>
                                <div style="clear: both;"></div>
                            </div>
                            <i class="th_checkbox_i red"></i>
                            <!--酒店设施-->
                            <div class="cont-facility-four">
                                <i class="reddot">*&nbsp;&nbsp;</i>
                                <p class="kernel kernel-top">
                                    酒店设施
                                </p>
                                <ul class="check" id="check">
                                    <?php
                                    if($facilities[4] != null){
                                    foreach($facilities[4] as $key=>$val){
                                        $check = "";
                                        if(in_array($key,$ser_fac))
                                            $check = "checked";
                                        else
                                            $check = "";
                                    ?>
                                    <li>
                                        <span><?=$val?>：</span>
                                        <input type="checkbox" id="for_checkbox_a1" value="<?=$key?>" <?=$check?> class="chk_1 facilities" name="facilities[]" />
                                        <label for="for_checkbox_a1"></label>
                                    </li>
                                    <?php
                                        }
                                    }
                                    ?>
                                </ul>
                                <div style="clear: both;"></div>
                            </div>
                            <i class="for_checkbox_i red"></i>
                        </div>
                        <div class="policy-footer">
                            <input type="hidden" name="id" value="<?=$model->id?>" />
                            <input type="hidden" name="type" value="3" />
                            <input class="policy-footer-save message-footer-save" style="margin-right: 45px;" type="button" name="" onclick="policyBtn()" id="" value="保存并继续" />
                        </div>
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
<script src="<?= Yii::$app->request->baseUrl ?>/layer/layer.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/My97DatePicker/WdatePicker.js"></script>


<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. Slimscroll is required when using the
     fixed layout. -->
</body>
</html>

