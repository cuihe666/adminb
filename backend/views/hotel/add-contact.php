<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model backend\models\UserBackend */

$this->title = '联系人信息';
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
        <!-- Main content -->
        <section class="content">
            <ul class="rummery_tab clearfix">
                <li class="col-sm-8"><a href="<?php echo \yii\helpers\Url::to(['hotel/update','id'=>$id]) ?>">酒店信息</a></li>
                <!-- 酒店2.1 添加酒店账户信息 ↓ admin:ys time:2017/11/3 -->
                <li class="col-sm-8"><a href="<?php echo \yii\helpers\Url::to(['hotel/hotel-account','id'=>$id]) ?>">账号信息</a></li>
                <!-- 完 ↑ -->
                <li class="col-sm-8"><a href="<?php echo \yii\helpers\Url::to(['hotel/two','id'=>$id]) ?>">酒店政策</a></li>
                <li class="col-sm-8"><a href="<?php echo \yii\helpers\Url::to(['hotel/three','id'=>$id]) ?>">服务设施</a></li>
                <li class="col-sm-8"><a href="<?php echo \yii\helpers\Url::to(['hotel/four','id'=>$id]) ?>">房型管理</a></li>
                <li class="col-sm-8"><a href="<?php echo \yii\helpers\Url::to(['hotel/set-price','hotel_id'=>$id]) ?>">房态房价设置</a></li>
                <li class="col-sm-8"><a href="<?php echo \yii\helpers\Url::to(['hotel/hotel-pic','id'=>$id]) ?>">图片管理</a></li>
                <li class="col-sm-8"><a href="<?php echo \yii\helpers\Url::to(['hotel/supplier','id'=>$id]) ?>">关联供应商</a></li>
                <li class="col-sm-8 current"><a href="###">联系人信息</a></li>
            </ul>
           <!--<?/*= Html::beginForm('', 'post', ['enctype' => 'multipart/form-data',"class"=>'hotel-form']) */?> -->
            <div class="rummery_con">
                <div class="rummery_item rummery_contact">
                    <button class="btn btn-primary add_person">添加联系人</button>
                    <div class="contact_box">
                        <dl class="contact_title content_item clearfix">
                            <dd class="type">联系人</dd>
                            <dd class="name">姓名</dd>
                            <dd class="job">职务</dd>
                            <dd class="mobile">手机号码</dd>
                            <dd class="email">E-mail</dd>
                            <dd class="phone">电话</dd>
                            <dd class="status">接受订单</dd>
                            <dd class="operate">操作</dd>
                        </dl>
                        <?php
                        if(!empty($contact)){
                            foreach($contact as $key=>$val) {
                                ?>
                                <ul class="content_item content_con clearfix">
                                    <li class="li_item"><span><?=$val['type']?></span><input type="text" placeholder="请输入联系人" name="type" value="<?=$val['type']?>" /></li>
                                    <li class="li_item"><span><?=$val['name']?></span><input type="text" placeholder="请输入姓名" name="name" value="<?=$val['name']?>" /></li>
                                    <li class="li_item"><span><?=$val['job']?></span><input type="text" placeholder="请输入职务" name="job" value="<?=$val['job']?>" /></li>
                                    <li class="li_item"><span><?=$val['mobile']?></span><input type="text" placeholder="请输入手机号码" maxlength="11" name="mobile" value="<?=$val['mobile']?>" /></li>
                                    <li class="li_item"><span><?=$val['email']?></span><input type="text" placeholder="请输入E-mail" name="email" value="<?=$val['email']?>" /></li>
                                    <li class="li_item"><span><?=$val['landline']?></span><input type="text" placeholder="请输入电话" name="landline" value="<?=$val['landline']?>" /></li>
                                    <li class="li_item">
                                        <span>
                                            <?= Yii::$app->params['hotel_contact_sms_status'][$val['sms_status']]?>
                                        </span>
                                        <!-- 编辑状态，应该显示的选择按钮 -->
                                        <input type="text" name="sms_status" readonly="readonly" class="select_sms_status"
                                               value="<?= ($val['sms_status'] == 0) ? '已开启' : '已关闭'?>" myAttr="<?= $val['sms_status'] ? $val['sms_status'] : 0?>">
                                    </li>
                                    <li class="li_item">
                                        <div class="op_eds"><p class="edit" data="<?=$val['id']?>">编辑</p>
                                            <p class="save" data="<?=$val['id']?>">保存</p></div>
                                        <p class="delete" data="<?=$val['id']?>">删除</p></li>
                                </ul>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <?/*= Html::endForm();*/?>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


    <div class="control-sidebar-bg"></div>

<script>
    var contact = '<?php echo json_encode($contact);?>';
    var hotel_id = '<?php echo $id;?>'
    var save_url = '<?php echo \yii\helpers\Url::to(['save-contact']) ?>';
    var update_url = '<?php echo \yii\helpers\Url::to(['update-contact']) ?>';
    var del_url = '<?php echo \yii\helpers\Url::to(['del-contact']) ?>';
</script>
<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.2.3 -->
<script src="<?= Yii::$app->request->baseUrl ?>/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?= Yii::$app->request->baseUrl ?>/bootstrap/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= Yii::$app->request->baseUrl ?>/dist/js/app.min.js"></script>
<!--new link-->
<script src="<?= Yii::$app->request->baseUrl ?>/dist/js/gobal.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/layer/layer.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/My97DatePicker/WdatePicker.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/dist/js/rummery.js"></script>


<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. Slimscroll is required when using the
     fixed layout. -->
</body>
</html>

