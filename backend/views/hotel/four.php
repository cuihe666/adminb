<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model backend\models\UserBackend */

$this->title = '房型管理';
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
    .manage_massage p{ height: 29px; overflow: hidden;}
</style>



<body class="hold-transition skin-blue sidebar-mini">


    <!-- Content Wrapper. Contains page content -->
    <div class="wrapper-content animated fadeInRight" style="background-color: #F2F2F2;">
        <!-- Content Header (Page header) -->

        <?= \backend\widgets\ElementAlertWidget::widget() ?>
        <!-- Main content -->
        <section class="content">
            <ul class="rummery_tab clearfix">
                <li class="col-sm-8"><a href="<?php echo \yii\helpers\Url::to(['hotel/update','id'=>$id]) ?>">酒店信息</a></li>
                <!-- 酒店2.1 添加酒店账户信息 ↓ admin:ys time:2017/11/3 -->
                <li class="col-sm-8"><a href="<?php echo \yii\helpers\Url::to(['hotel/hotel-account','id'=>$id]) ?>">账号信息</a></li>
                <!-- 完 ↑ -->
                <li class="col-sm-8"><a href="<?php echo \yii\helpers\Url::to(['hotel/two','id'=>$id]) ?>">酒店政策</a></li>
                <li class="col-sm-8"><a href="<?php echo \yii\helpers\Url::to(['hotel/three','id'=>$id]) ?>">服务设施</a></li>
                <li class="col-sm-8 current"><a href="###">房型管理</a></li>
                <li class="col-sm-8"><a href="<?php echo \yii\helpers\Url::to(['hotel/set-price','hotel_id'=>$id]) ?>">房态房价设置</a></li>
                <li class="col-sm-8"><a href="<?php echo \yii\helpers\Url::to(['hotel/hotel-pic','id'=>$id]) ?>">图片管理</a></li>
                <li class="col-sm-8"><a href="<?php echo \yii\helpers\Url::to(['hotel/supplier','id'=>$id]) ?>">关联供应商</a></li>
                <li class="col-sm-8"><a href="<?php echo \yii\helpers\Url::to(['hotel/contact','id'=>$id]) ?>">联系人信息</a></li>
            </ul>
            <?= Html::beginForm('', 'post', ['enctype' => 'multipart/form-data',"class"=>'hotel-form']) ?>
            <div class="rummery_con">
                <div class="rummery_item rummery_house">
                    <?php
                    if(!empty($house)){
                        foreach($house as $key=>$val){

                    ?>
                    <div class="manage">
                        <a href="<?php echo \yii\helpers\Url::to(['hotel/update-house','house_id'=>$val['id']]) ?>" class="clearfix">
                        <div class="pic_bbox"><img class="manage_img" src="<?= Yii::$app->params['imgUrl'].$val['cover_img'] ?>" alt="" /></div>
                        <div class="manage_massage">
                            <p class="bed">
                                <?//=substr($val['name'], 0, 10)?>
                                <?php
                                echo \backend\helper\StringHelper::truncate_utf8_string($val['name'],10);
                                ?>
                            </p>
                            <p>
                                <?=Yii::$app->params['hotel_bed_type'][$val['type']]?>/<?=$val['room_size']?>㎡<!--20㎡-->
                            </p>
                            <p>
                                <?=Yii::$app->params['hotel_breakfast'][$val['breakfast']]?>/<?=Yii::$app->params['hotel_refund_type'][$val['refund_type']]?>
                                <!--双早/不可取消-->
                            </p>
                        </div>
                        </a>
                    </div>
                    <?php
                        }
                    }
                    ?>
                    <a href="<?php echo \yii\helpers\Url::to(['hotel/add-house','id'=>$id]) ?>" style="display: block;float:left;">
                        <div class="add_manage">
                            <div style="width:130px;margin:auto;padding-right:6px;">
                                <img class="plus" src="<?= Yii::$app->request->baseUrl ?>/dist/images/jiahao_03.png" alt="" />
                                <span>添加房型</span>
                                </span>
                            </div>
                        </div>
                    </a>
                    <div style="clear: both;"></div>
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

