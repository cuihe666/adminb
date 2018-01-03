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
    .reminder p{
        color:#999;
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
                <li class="col-sm-8 current"><a href="###">酒店政策</a></li>
                <li class="col-sm-8"><a href="<?php echo \yii\helpers\Url::to(['hotel/three','id'=>$model->id]) ?>">服务设施</a></li>
                <li class="col-sm-8"><a href="<?php echo \yii\helpers\Url::to(['hotel/four','id'=>$model->id]) ?>">房型管理</a></li>
                <li class="col-sm-8"><a href="<?php echo \yii\helpers\Url::to(['hotel/set-price','hotel_id'=>$model->id]) ?>">房态房价设置</a></li>
                <li class="col-sm-8"><a href="<?php echo \yii\helpers\Url::to(['hotel/hotel-pic','id'=>$model->id]) ?>">图片管理</a></li>
                <li class="col-sm-8"><a href="<?php echo \yii\helpers\Url::to(['hotel/supplier','id'=>$model->id]) ?>">关联供应商</a></li>
                <li class="col-sm-8"><a href="<?php echo \yii\helpers\Url::to(['hotel/contact','id'=>$model->id]) ?>">联系人信息</a></li>
            </ul>
            <?= Html::beginForm('', 'post', ['enctype' => 'multipart/form-data',"class"=>'hotel-form']) ?>
            <div class="rummery_con">
                <div class="rummery_item rummery_policy">
                    <div class="xhh_conent">
                        <ul class="conent-time">
                            <li>
                                <i>*&nbsp;&nbsp;</i>
                                <span>最早入住时间：</span>
                                <?= Html::activeDropDownList($model, 'in_time', Yii::$app->params['in_time'], ['class' => '']) ?>

                            </li>
                            <li>
                                <i>*&nbsp;&nbsp;</i>
                                <span>最晚退房时间：</span>
                                <?= Html::activeDropDownList($model, 'out_time', Yii::$app->params['out_time'], ['class' => '']) ?>
                            </li>
                            <li>
                                <i>*&nbsp;&nbsp;</i>
                                <span>售卖时段：</span>
                                <?= Html::activeDropDownList($model, 'sale_time', Yii::$app->params['sale_time'], ['class' => '']) ?>
                            </li>
                            <li style="height:auto;">
                                <p class="left">
                                    <i style="color:red;">*&nbsp;&nbsp;</i>
                                    <span>发票提示：</span>
                                </p>
                                <textarea class="bill" onblur="gys_hinese()" id="gys_hinese" name="Hotel[prompt]" rows="" cols=""><?php echo $model->prompt?></textarea><i class="gys_hinese_b bill_i"></i>
                            </li>
                            <style>
                                .reminder{
                                    -moz-user-select: none;
                                    -webkit-user-select: none;
                                    -ms-user-select: none;
                                    -khtml-user-select: none;
                                    user-select:text;
                                }
                            </style>
                            <li style="height:auto;">
<!--                                2017年5月11日14:44:17 xhh‘特别提示’字体颜色修改-->
                                <div class="reminder">
                                    <p>
                                        <i style="color:red;">特别提示：</i>&nbsp;目前发票政策有以下两种，请根据酒店签约实际情况谨慎选择：
                                    </p>
                                    <p class="indent">
                                        1、如需发票（仅限服务费），请致电客服电话400-6406-111
                                    </p>
                                    <p class="indent">
                                        2、如需发票，请至酒店前台领取
                                    </p>
                                </div>
                            </li>
                            <!--2.0开始-->
                            <li style="height:auto;margin-top: 8px">
                                <p class="left">
                                    <i style="color:red;">&nbsp;&nbsp;&nbsp;&nbsp;</i>
                                    <span>酒店政策：</span>
                                </p>
                                <div>
                                    <div class="policy-item-left">酒店提示</div>
                                    <div class="policy-item-right">
                                        <input type="checkbox" name="Hotel[hotel_tips]" style="margin-top: 2px" value="目前<?=$city->name ?>全城禁烟，均为无烟房"
                                               <?= $model->hotel_tips == '目前'.$city->name.'全城禁烟，均为无烟房'? 'checked=checked' : ''?>/>
                                        <label>目前<?=$city->name ?>全城禁烟，均为无烟房</label>
                                    </div>
                                </div>
                                <div>
                                    <i>&nbsp;&nbsp;&nbsp;&nbsp;</i>
                                    <div class="policy-item-left policy-common">儿童及加床</div>
                                    <div class="policy-item-right">
                                            <input type="checkbox" name="Hotel[child_in]" style="margin-top: 2px" value="1"
                                                <?= $model->child_in == 1 ? 'checked=checked' : ''?>/>
                                            <label>不接受18岁以下的客人单独入住。</label>
                                    </div>
                                </div>
                                <div>
                                    <i>&nbsp;&nbsp;&nbsp;&nbsp;</i>
                                    <div class="policy-item-right" style="margin-left: 174px">
                                        <input type="checkbox" name="Hotel[child_charge]" value="1"
                                            <?= $model->child_charge == 1 ? 'checked=checked' : ''?>/>
                                        <label>18岁以下儿童加床收费，每晚<input type="text" name="Hotel[child_price]" style="width: 37px" value="<?= $model->child_price == 0 ? '' : $model->child_price ?>"/>          元，不含儿童早餐。</label>
                                        <span <?= $error_note == 'child_charge' ? 'style="color: red;"' : 'style="display: none;"'?>>请填写加床费用!</span>
                                    </div>
                                </div>
                                <div>
                                    <i>&nbsp;&nbsp;&nbsp;&nbsp;</i>
                                    <div class="policy-item-left policy-common">宠物</div>
                                    <div class="policy-item-right">
                                        <input type="checkbox" name="Hotel[pet_in]" style="margin-top: 2px" value="1"
                                            <?= $model->pet_in == 1 ? 'checked=checked' : ''?>/>
                                        <label>不可携带宠物</label>
                                    </div>
                                </div>
                                <div>
                                    <i>&nbsp;&nbsp;&nbsp;&nbsp;</i>
                                    <div class="policy-item-left policy-common">膳食安排</div>
                                    <div class="policy-item-right">
                                        <input type="checkbox" name="Hotel[buffet_break]" value="1"
                                            <?= $model->buffet_break == 1 ? 'checked=checked' : ''?>/>
                                        <label>自助早餐<input type="text" name="Hotel[buffet_break_price]" style="width: 37px" value="<?= $model->buffet_break_price == 0 ? '' : $model->buffet_break_price ?>"/>元</label>
                                        <span <?= $error_note == 'buffet_break' ? 'style="color: red;"' : 'style="display: none;"'?>>请填写早餐费用!</span>
                                    </div>
                                </div>
                                <div>
                                    <i>&nbsp;&nbsp;&nbsp;&nbsp;</i>
                                    <div class="policy-item-left policy-common">其他</div>
                                    <div class="policy-item-right">
                                        <input type="checkbox" name="Hotel[hotel_rule_note]" value="1"
                                            <?= empty($model->hotel_rule) ? '' : 'checked=checked'?>/>
                                        <input type="text" name="Hotel[hotel_rule]" style="width: 243px" placeholder="请填写酒店政策，将在前台展示" value="<?= empty($model->hotel_rule) ? '' : $model->hotel_rule ?>">
                                        <span <?= $error_note == 'hotel_rule_note' ? 'style="color: red;"' : 'style="display: none;"'?>>请填写政策内容!</span>
                                    </div>
                                </div>
                            </li>
                            <!--2.0结束-->

                            <div class="policy-footer">
                                <input type="hidden" name="Hotel[id]" value="<?=$model->id?>" />
                                <input class="policy-footer-save message-footer-save" type="button" name="" onclick="reminder_btn()" id="" value="保存并继续">
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

