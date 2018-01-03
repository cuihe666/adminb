<?php

use yii\helpers\Html;
use kartik\grid\GridView;


/* @var $this yii\web\View */
/* @var $model backend\models\UserBackend */

$this->title = '查看基本信息';
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
<!-- 图片切换 -->
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/amaze/css/amazeui.css">
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
    .contact_box .content_item{ margin:0; padding:0;}
    .manage_massage p{margin:0; padding:0;}
    ul, ol{ padding:0;}
</style>


<body class="hold-transition skin-blue sidebar-mini">


<!-- Content Wrapper. Contains page content -->
<div class="wrapper-content animated fadeInRight" style="background-color: #F2F2F2">
    <!-- Content Header (Page header) -->

    <!-- Main content -->
    <section class="content">
        <ul class="rummery_tab clearfix">
            <li class="current col-sm-8">酒店信息</li>
            <li class="col-sm-8">酒店政策</li>
            <li class="col-sm-8">服务设施</li>
            <li class="col-sm-8">房型管理</li>
            <li class="col-sm-8">房态房价设置</li>
            <li class="col-sm-8">图片管理</li>
            <li class="col-sm-8">关联供应商</li>
            <li class="col-sm-8">联系人信息</li>
        </ul>
        <div class="rummery_con">
            <div class="rummery_item rummery_detail">
                <div class="xhh_conent hotel_information">
                    <ul class="conent-message">
                        <li>
                            <i>*&nbsp;&nbsp;</i>
                            <span>酒店名称：</span>
                            <?=$model->complete_name?>
                        </li>
                        <li>
                            <i style="width:15px;height:5px;float: left;"></i>
                            <span>酒店简称：</span>
                            <?=$model->short_name?>
                        </li>
                        <li>
                            <i>*&nbsp;&nbsp;</i>
                            <span>酒店类型：</span>
                            <?=Yii::$app->params['hotel_type'][$model->type];?>
                        </li>

                        <li class="wire"></li>
                        <li class="user-backend-form">
                            <i>*&nbsp;&nbsp;</i>
                            <span>省/市/区：</span>
                            <?=$provice[$model->province]?>
                            <?=$city[$model->city]?>
                            <?=$area[$model->area]?>
                        </li>
                        <li>
                            <i>*&nbsp;&nbsp;</i>
                            <span>酒店地址：</span>
                            <!--<input class="grogshop" type="" name="" id="" value="" />
                            <input id="grogshop_position" type="button" name="" id="" value="自动定位" />-->

                        </li>
                        <li style="height:auto;">
                            <i style="width:15px;height:5px;float: left;"></i>
                            <span style="float:left;">地理位置：</span>
                            <div style="float:left;position: relative;" class="grogshop_map">
                                <div id="map" style="width:100%;height:480px;margin:0 auto;"></div>
                                <div id="tip">
                                    <input type="text" id="pac-input" name="Hotel[address]" value="<?=$model->address?>" onblur="pacinput()" placeholder="请输入关键字：(选定后搜索)" style="width:770px" readonly />

                                    <script>
                                        function pacinput() {
                                            if ($("#pac-input").val() != "") {
                                                $(".address_tip").text("")
                                            }
                                        }
                                    </script>

                                </div>

                            </div>
                            <i class="maphint" style="margin-left:52px;"></i>

                            <div style="clear: both;"></div>
                            <input type="hidden" name="Hotel[longitude]" id="lng" style="width: 100px;" value="<?=$model->longitude?>"/>
                            <input type="hidden" name="Hotel[latitude]" id="lat" style="width: 100px;" value="<?=$model->latitude?>"/>
                            <input type="hidden" name="Hotel[address]" id="address" style="width: 100px;" value="<?=$model->address?>"/>
                        </li>
                        <li>
                            <i>*&nbsp;&nbsp;</i>
                            <span>前台电话：</span>
                            <?=$model->mobile_area?><b style="color:#ccc;">—</b><?=$model->mobile?>
                        </li>
                        <li>
                            <i style="width:15px;height:5px;float: left;"></i>
                            <span>酒店传真：</span>
                            <?=$model->fax_area?><b style="color:#ccc;">—</b><?=$model->fax?>
                        </li>
                        <li>
                            <i style="width:15px;height:5px;float: left;"></i>
                            <span>邮编：</span>
                            <?=$model->postcode?>
                        </li>
                        <li class="wire"></li>
                        <li>
                            <i>&nbsp;&nbsp;&nbsp;</i>
                            <span>开业年份：</span>
                            <?=$model->opening_year?>
                        </li>
                        <li>
                            <i>&nbsp;&nbsp;&nbsp;</i>
                            <span>最新装修：</span>
                            <?=$model->renovation_year?>
                        </li>
                        <li>
                            <i>&nbsp;&nbsp;&nbsp;</i>
                            <span>客房总数：</span>
                            <?=$model->total_stock?>
                        </li>
                        <li>
                            <i class="left">*&nbsp;&nbsp;</i>
                            <span class="left">酒店简介：</span>
                            <textarea class="text left" name="Hotel[introduction]" id="brief" onblur="brief()" rows="" cols="" readonly><?=$model->introduction?></textarea>
                            <i class="briefhint"></i>
                        </li>
                        <div style="clear: both;"></div>
                        <li>
                            <i class="left">&nbsp;&nbsp;&nbsp;</i>
                            <span class="left">酒店特色：</span>
                            <textarea class="text left" name="Hotel[feature]" rows="" cols="" readonly><?=$model->feature?></textarea>

                        </li>
                        <div style="clear: both;"></div>
                    </ul>
                    <!--<div class="message-footer">
                        <input class="message-footer-save" style="margin-bottom: 20px;" type="button" name="" onclick="save()" id="" value="保存并继续">
                    </div>-->
                </div>
            </div>
            <div class="rummery_item rummery_policy">
                <div class="xhh_conent">
                    <ul class="conent-time">
                        <li>
                            <i>*&nbsp;&nbsp;</i>
                            <span>最早入住时间：</span>
                            <?php
                                if($model->in_time!=null)
                                    echo Yii::$app->params['in_time'][$model->in_time];
                            ?>


                        </li>
                        <li>
                            <i>*&nbsp;&nbsp;</i>
                            <span>最晚退房时间：</span>
                            <?php
                                if($model->out_time!=null)
                                    echo Yii::$app->params['out_time'][$model->out_time];
                            ?>
                        </li>
                        <li>
                            <i>*&nbsp;&nbsp;</i>
                            <span>售卖时段：</span>
                            <?php
                                if($model->sale_time!=null)
                                    echo Yii::$app->params['sale_time'][$model->sale_time];
                            ?>
                        </li>
                        <li style="height:auto;">
                            <p class="left">
                                <i style="color:red;">*&nbsp;&nbsp;</i>
                                <span>发票提示：</span>
                            </p>
                            <textarea class="bill" onblur="gys_hinese()" id="gys_hinese" name="Hotel[prompt]" rows="" cols="" readonly><?php echo $model->prompt?></textarea><i class="gys_hinese_b bill_i"></i>
                        </li>

                        <li style="height:auto;">
                            <div class="reminder">
                                <p>
                                    特别提示：&nbsp;目前发票政策有以下两种，请根据酒店签约实际情况谨慎选择：
                                </p>
                                <p class="indent">
                                    1、如需发票（仅限服务费），请致电客服电话400-6406-111
                                </p>
                                <p class="indent">
                                    2、如需发票，请至酒店前台领取
                                </p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
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
                                            <input type="checkbox" id="one_checkbox_a1" value="<?=$key?>" <?=$check?> class="chk_1 core" name="facilities[]" disabled />
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
                                            <input type="checkbox" id="two_checkbox_a1" value="<?=$key?>" <?=$check?> class="chk_1 house" name="facilities[]" disabled />
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
                                            <input type="checkbox" id="th_checkbox_a1" value="<?=$key?>" <?=$check?> class="chk_1 service" name="facilities[]" disabled />
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
                                            <input type="checkbox" id="for_checkbox_a1" value="<?=$key?>" <?=$check?> class="chk_1 facilities" name="facilities[]" disabled />
                                            <label for="for_checkbox_a1"></label>
                                        </li>
                                        <?php
                                    }
                                }
                                ?>
                            </ul>
                            <div style="clear: both;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="rummery_item rummery_house">
                <?php
                if(!empty($house)){
                    foreach($house as $key=>$val){

                        ?>
                        <div class="manage">
                            <a href="<?php echo \yii\helpers\Url::to(['hotel/view-house','house_id'=>$val['id']]) ?>">
                                <img class="manage_img" src="<?= Yii::$app->params['imgUrl'].$val['cover_img'] ?>" alt="" />
                                <div class="manage_massage">
                                    <p class="bed">
                                        <?=$val['name']?>
                                    </p>
                                    <p>
                                        <?=Yii::$app->params['hotel_bed_type'][$val['type']]?>/<?=$val['room_size']?><!--20㎡-->
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

                <div style="clear: both;"></div>
            </div>
            <div class="rummery_item rummery_price">
                <ul class="house_price_tab">
                    <li class="current tab_li1">房态</li>
                    <li class="tab_li2">房价</li>
                </ul>
                <div class="house_price_con">
                    <!--房态-->
                    <div class="house_price_item fangtai">
                        <div class="house_top clearfix">
                        </div>
                        <div class="calender_con">
                            <div class="calender_right">
                                <button type="button" class="oldprev">
                                    <前31天
                                </button>
                                <div class="iDate date">
                                    <span>选择日期</span>
                                    <input type="text"
                                           value="<?php echo $_SESSION['hotel_' . $_GET['hotel_id']] ? $_SESSION['hotel_' . $_GET['hotel_id']] : date('Y-m-d'); ?>"
                                           id="date_text" class="form-control date_text" readonly="readonly"
                                           style="text-align: center;">
                                    <!--<button type="button" class="addOn"></button>-->
                                </div>
                                <button type="button" class="newprev">后31天></button>
                            </div>
                            <ul id="tab" class="cal_box cal_house">
                                <li id="top_date" class="clearfix">
                                    <div class="cal_title fx">房型</div>
                                    <?php foreach ($date as $v): ?>
                                        <div class="fangtai_day fl"
                                             date="<?php echo $v; ?>"><?php echo get_date($v); ?>
                                            <br><?php echo substr($v, -2); ?></div>
                                    <?php endforeach; ?>
                                </li>
                            </ul>
                            <ul class="cal_con cal_box cal_house">
                                <?php foreach ($hotel_house as $k => $v): ?>
                                    <li class="item_title clearfix">
                                        <div class="cal_title fx_title"><?php echo $v['name']; ?></div>
                                        <?php foreach ($v['stock'] as $kk => $vv): ?>
                                            <div class="fangtai_item fl"
                                                 hotel_house_id="<?php echo $v['id']; ?>" <?php if ($vv['status'] == 1 or $vv['status'] == 2) { ?> style="background: white;" <?php } ?>><?php if ($vv['status'] == 0) { ?>
                                                    <span
                                                        class="man">满</span><?php } ?><?php ?><?php if ($vv['status'] == 1 or $vv['status'] == 2) { ?>
                                                    <span><?php echo $vv['stock_num']; ?></span><?php } ?></div>
                                        <?php endforeach; ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    <!--房型-->
                    <style>
                        .cal_price li > div + div{ width:9%;}
                        .cal_box li > div{height: 50px}
                    </style>
                    <div class="house_price_item fangxing" style="display: none;">
                        <div class="house_top clearfix">

                        </div>
                        <div class="calender_con">
                            <div class="calender_right">
                                <button class="oldprev2">&lt; 前9天</button>
                                <div class="iDate2 date2">
                                    <span>选择日期</span>
                                    <input type="text" id="date_text2"
                                           value="<?php echo $_SESSION['hotel_' . $_GET['hotel_id']] ? $_SESSION['hotel_' . $_GET['hotel_id']] : date('Y-m-d'); ?>"
                                           class="form-control date_text" readonly="readonly"
                                           style="text-align: center;">
                                    <!--<button type="button" class="addOn"></button>-->
                                </div>
                                <button class="newprev2">后9天 &gt;</button>
                            </div>

                            <ul id="tab2" class="cal_box cal_price">
                                <li id="top_date2" class="clearfix">
                                    <div class="cal_title fx">房型</div>
                                    <div class="cal_type fx"><em>价格类型</em><br><em>RMB</em></div>
                                    <?php foreach ($price_date as $v): ?>
                                        <div class="date_div" date="<?php echo $v; ?>"><?php echo get_date($v); ?>
                                            <br><?php echo substr($v, -5); ?></div>
                                    <?php endforeach; ?>
                                    <!--<div>操作</div>-->
                                </li>
                            </ul>
                            <ul class="cal_con2 cal_box cal_price">
                                <?php foreach ($price_data as $k => $v): ?>
                                    <li class="item_title clearfix" hotel_house_id="<?php echo $v['id']; ?>">
                                        <div class="cal_title fx_title"><?php echo $v['name']; ?></div>
                                        <div class="cal_type fx_type"><em>底价</em><br><em class="yongjin">佣金</em>
                                        </div>
                                        <?php foreach ($v['date'] as $kk => $vv): ?>
                                            <div class="click_con po_re">
                                                <?php if ($vv['status'] == 0) { ?>
                                                    <div class="man po_ab">满</div><?php } ?>
                                                <div class="dijia"><?php echo $vv['money']; ?></div>
                                                <div class="dijia_input clk_ipt" style="display: none;">
                                                    <input type="number" class="hotel_price" id=""
                                                           value="<?php echo $vv['money']; ?>" autocomplete="off"
                                                    >
                                                </div>
                                                <div class="yongjin"><?php echo $vv['scale']; ?></div>
                                                <div class="yongjin_input clk_ipt" style="display: none;">
                                                    <input type="" name="" class="scale_price" id=""
                                                           value="<?php echo $vv['scale']; ?>"
                                                           autocomplete="off">
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                        <!--<div class="last_click"><em class="edit_price">修改价格</em><em
                                                class="edit_price_save">保存</em><br><em
                                                class="edit_money">修改佣金</em><em
                                                class="edit_money_save">保存</em>
                                        </div>-->
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="rummery_item rummery_pic">
                <?php
                $wgnum = 0;
                $ssnum = 0;
                $wsnum = 0;
                $ktnum = 0;
                if(!empty($hotelImg)){
                    foreach($hotelImg as $key=>$val){
                        if($val['type']==1)
                            $wgnum++;
                        if($val['type']==2)
                            $ssnum++;
                        if($val['type']==3)
                            $wsnum++;
                        if($val['type']==4)
                            $ktnum++;
                    }
                }
                ?>
                <div class="grogshop_imgs">
                    酒店图片<span>（<?php echo count($hotelImg);?>）</span>
                </div>
                <div class="imgs_top">
                    外观<span>（<?=$wgnum?>）</span>
                </div>
                <div id="wrapper" class="pic_show">
                    <ul data-am-widget="gallery" class="am-gallery am-avg-sm-2am-avg-md-3 am-avg-lg-4 am-gallery-default"
                        data-am-gallery="{ pureview: true }">
                        <?php
                        $cover_img = "";
                        ?>
                        <?php if ($hotelImg) { ?>
                            <?php foreach ($hotelImg as $k => $v):
                                if($v['type']==1) {
                                    if($v['is_cover_img'] == 1)
                                        $cover_img = $v['pic'];
                                    ?>
                                    <li class="house_imgs" <?php if($v['is_cover_img'] == 1) {
                                        echo 'cover=1';
                                    } ?> style="position: relative;">
                                        <?php if ($v['is_cover_img'] == 1) { ?>
                                            <b class='figure_first'></b><i class='figure_des'>首图</i>
                                        <?php } ?>
                                        <div class="am-gallery-item" style="position: relative;">
                                            <a href="http://img.tgljweb.com/<?php echo $v['pic']; ?>" class="">
                                                <img src="http://img.tgljweb.com/<?php echo $v['pic']; ?>"
                                                     style="height: 138px;"/>
                                            </a>
                                        </div>
                                    </li>
                                    <?php
                                }
                            endforeach ?>
                        <?php } ?>
                    </ul>
                </div>
                <div style="clear: both;"></div>
                <div class="imgs_top">
                    设施<span>（<?=$ssnum?>）</span>
                </div>
                <div id="wrapper" class="pic_show">
                    <ul data-am-widget="gallery" class="am-gallery am-avg-sm-2am-avg-md-3 am-avg-lg-4 am-gallery-default  ul_pic" data-am-gallery="{ pureview: true }">
                        <?php
                        $cover_img = "";
                        ?>
                        <?php if ($hotelImg) { ?>
                            <?php foreach ($hotelImg as $k => $v):
                                if($v['type']==2) {
                                    if($v['is_cover_img'] == 1)
                                        $cover_img = $v['pic'];
                                    ?>
                                    <li class="house_imgs" <?php if($v['is_cover_img'] == 1) {
                                        echo 'cover=1';
                                    } ?> style="position: relative;">
                                        <?php if ($v['is_cover_img'] == 1) { ?>
                                            <b class='figure_first'></b><i class='figure_des'>首图</i>
                                        <?php } ?>
                                        <div class="am-gallery-item" style="position: relative;">
                                            <a href="http://img.tgljweb.com/<?php echo $v['pic']; ?>" class="">
                                                <img src="http://img.tgljweb.com/<?php echo $v['pic']; ?>"
                                                     style="height: 138px;"/>
                                            </a>
                                        </div>
                                    </li>
                                    <?php
                                }
                            endforeach ?>
                        <?php } ?>
                    </ul>
                </div>
                <div style="clear: both;"></div>
                <div class="imgs_top">
                    卧室<span>（<?=$wsnum?>）</span>
                </div>
                <div id="wrapper" class="pic_show">
                    <ul data-am-widget="gallery" class="am-gallery am-avg-sm-2am-avg-md-3 am-avg-lg-4 am-gallery-default  ul_pic" data-am-gallery="{ pureview: true }">
                        <?php
                        $cover_img = "";
                        ?>
                        <?php if ($hotelImg) { ?>
                            <?php foreach ($hotelImg as $k => $v):
                                if($v['type']==3) {
                                    if($v['is_cover_img'] == 1)
                                        $cover_img = $v['pic'];
                                    ?>
                                    <li class="house_imgs" <?php if($v['is_cover_img'] == 1) {
                                        echo 'cover=1';
                                    } ?> style="position: relative;">
                                        <?php if ($v['is_cover_img'] == 1) { ?>
                                            <b class='figure_first'></b><i class='figure_des'>首图</i>
                                        <?php } ?>
                                        <div class="am-gallery-item" style="position: relative;">
                                            <a href="http://img.tgljweb.com/<?php echo $v['pic']; ?>" class="">
                                                <img src="http://img.tgljweb.com/<?php echo $v['pic']; ?>"
                                                     style="height: 138px;"/>
                                            </a>
                                        </div>
                                    </li>
                                    <?php
                                }
                            endforeach ?>
                        <?php } ?>
                    </ul>
                </div>
                <div style="clear: both;"></div>
                <div class="imgs_top">
                    客厅<span>（<?=$ktnum?>）</span>
                </div>
                <div id="wrapper" class="pic_show">
                    <ul data-am-widget="gallery" class="am-gallery am-avg-sm-2am-avg-md-3 am-avg-lg-4 am-gallery-default  ul_pic" data-am-gallery="{ pureview: true }">
                        <?php
                        $cover_img = "";
                        ?>
                        <?php if ($hotelImg) { ?>
                            <?php foreach ($hotelImg as $k => $v):
                                if($v['type']==4) {
                                    if($v['is_cover_img'] == 1)
                                        $cover_img = $v['pic'];
                                    ?>
                                    <li class="house_imgs" <?php if($v['is_cover_img'] == 1) {
                                        echo 'cover=1';
                                    } ?> style="position: relative;">
                                        <?php if ($v['is_cover_img'] == 1) { ?>
                                            <b class='figure_first'></b><i class='figure_des'>首图</i>
                                        <?php } ?>
                                        <div class="am-gallery-item" style="position: relative;">
                                            <a href="http://img.tgljweb.com/<?php echo $v['pic']; ?>" class="">
                                                <img src="http://img.tgljweb.com/<?php echo $v['pic']; ?>"
                                                     style="height: 138px;"/>
                                            </a>
                                        </div>
                                    </li>
                                    <?php
                                }
                            endforeach ?>
                        <?php } ?>
                    </ul>
                </div>
                <div style="clear: both;"></div>

                <style>
                    .house_save{margin:10px auto;}
                    .house_imgs{ width:10%; float: left; position: relative; display: block; margin-right: 8px;
                        border:1px solid #ccc; padding:0; margin-bottom: 5px;
                        clear: none;}
                    .am-avg-lg-4 > li:nth-of-type(4n + 1){clear: none;}
                    .cancel1 {
                        width: 35px;
                        /*height: 24px;*/
                        display: inline;
                        /*float: right;*/
                        /*text-indent: -9999px;*/
                        color: #fff;
                        overflow: hidden;
                        /*background: url(/webuploader/icons.png) no-repeat;*/
                        margin: 5px 1px 1px;
                        cursor: pointer;
                        /*background-position: -48px -24px;*/
                    }
                    .uploader .queueList{margin 20px 5px;}

                    .am-gallery{padding:5px 0 0 0;}
                    .am-avg-lg-4 > li{
                        width:196px;
                        height: 150px;
                    }
                    .am-gallery .figure_first {
                        position: absolute;
                        left: 0;
                        top: -19px;
                        z-index: 4;
                        color: red;
                        width: 0;
                        height: 0;
                        border-top: 36px solid transparent;
                        border-bottom: 36px solid transparent;
                        border-right: 36px solid red;
                        transform: rotate(46deg);
                        -webkit-transform: rotate(46deg);
                        -moz-transform: rotate(46deg);
                        -o-transform: rotate(46deg);
                        -ms-transform: rotate(46deg);
                    }

                    .am-gallery .figure_des {
                        position: absolute;
                        left: 6px;
                        top: 8px;
                        z-index: 5;
                        font-size: 14px;
                        color: #fff;
                    }

                </style>
            </div>
            <div class="rummery_item rummery_supply">
                <?php
                use kartik\export\ExportMenu;
                $gridColumns = [
                    'id',
                    'name',
                    'brand',
                    ['attribute' => 'city',
                        'header' => '城市',
                        'value' => function ($model) {
                            return $model->cityName->name;
                        }
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => '是否有效',
                        'template' => '<div>{view}</div> ',
                        'buttons' => [
                            'view' => function ($url, $model, $key)  use($HotelModel){
                                $start = strtotime($model->start_time);
                                $end = strtotime($model->end_time);
                                $curr = time();
                                if($curr<=$end && $curr>=$start){
                                    return "有效";
                                }
                                else{
                                    return "无效";
                                }
                            },
                        ],
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => '酒店名称',
                        'template' => '<div>{view}</div> ',
                        'buttons' => [
                            'view' => function ($url, $model, $key)  use($HotelModel){
                                return $HotelModel->complete_name;
                            },
                        ],
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => '酒店类型',
                        'template' => '<div>{view}</div> ',
                        'buttons' => [
                            'view' => function ($url, $model, $key)  use($HotelModel){
                                return Yii::$app->params['hotel_type'][$HotelModel->type];
                            },
                        ],
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => '关联状态',
                        'template' => '<div>{view}</div> ',
                        'buttons' => [
                            'view' => function ($url, $model, $key)  use($HotelModel){
                                return Yii::$app->params['hotel_relation_status'][$HotelModel->supplier_relation];
                            },
                        ],
                    ],
                ];

                echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => $gridColumns,
                    'pager' => [
                        'firstPageLabel' => '首页',
                        'lastPageLabel' => '尾页',
                    ],
                ]);
                ?>

            </div>
            <div class="rummery_item rummery_contact">
                <div class="contact_box">
                    <dl class="contact_title content_item clearfix">
                        <dd class="type">联系人</dd>
                        <dd class="name">姓名</dd>
                        <dd class="job">职务</dd>
                        <dd class="mobile">手机号码</dd>
                        <dd class="email">E-mail</dd>
                        <dd class="phone">电话</dd>
                    </dl>
                    <?php
                    if(!empty($contact)){
                        foreach($contact as $key=>$val) {
                            ?>
                            <style>
                                .contact_box .content_item > dd, .contact_box .content_item > li{ width:16.6%; max-width: 16.6%;}
                            </style>
                            <ul class="content_item content_con clearfix">
                                <li class="li_item"><span><?=$val['type']?></span><input type="text" placeholder="请输入联系人" name="type" value="<?=$val['type']?>" /></li>
                                <li class="li_item"><span><?=$val['name']?></span><input type="text" placeholder="请输入姓名" name="name" value="<?=$val['name']?>" /></li>
                                <li class="li_item"><span><?=$val['job']?></span><input type="text" placeholder="请输入职务" name="job" value="<?=$val['job']?>" /></li>
                                <li class="li_item"><span><?=$val['mobile']?></span><input type="text" placeholder="请输入手机号码"  maxlength="11" name="mobile" value="<?=$val['mobile']?>" /></li>
                                <li class="li_item"><span><?=$val['email']?></span><input type="text" placeholder="请输入E-mail" name="email" value="<?=$val['email']?>" /></li>
                                <li class="li_item"><span><?=$val['landline']?></span><input type="text" placeholder="请输入电话" name="landline" value="<?=$val['landline']?>" /></li>

                            </ul>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>

        <script>
            $(".rummery_tab>li").click(function () {
                var i = $(this).index();
                $(this).addClass("current").siblings(".rummery_tab>li").removeClass("current");
                $(this).parent(".rummery_tab").siblings(".rummery_con").children(".rummery_item").eq(i).show().siblings(".rummery_item").hide();
            })
        </script>
        <h3 style="margin:10px 0; border-bottom:2px solid #007BB6; padding:0 0 15px 10px;">酒店信息审核</h3>
        <div>
            <div class="modal-dialog modal-lg" role="document" style="margin:0; width:100%;">
                <div class="modal-content">
                    <div class="modal-body" style="overflow: hidden;">
                        <p>
                            <label style="float: left">审核状态：</label>
                            <?= Html::activeDropDownList($model, 'check_status',Yii::$app->params['hotel_check_status'], ['class' => 'form-control check_status','style'=>'float:left; width:120px;']) ?>
                        </p>
                        <p style="clear:both; height: 20px;"></p>
                        <p>
                            <label style="float: left">审核备注：</label>
                            <textarea name="remarks" class="remarks" cols="60" rows="5" style="border:1px solid #ccc;"></textarea>
                        </p>
                    </div>
                    <div class="modal-footer" style="text-align: left; padding-left:100px;">
                        <input type="hidden" class="before_check_status" value="<?=$model->check_status?>" />
                        <input type="hidden" class="hotel_id" value="<?=$model->id?>" />
                        <button type="button" class="btn btn-primary check_sub" id="more_fangtai_sure">确定</button>
                        <?= Html::a("返回上一页",$url = ['hotel/index'],$options = ['class' => 'btn btn-sm btn-primary',"style"=>"line-height:22px; color:#fff;"]) ?>
                        <button type="button" class="btn btn-success check_log" data-dismiss="modal">查看审核记录</button>
                    </div>
                </div>
            </div>
        </div>
<!--审核记录-->
        <div class="modal fade house_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="more_modal">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="myLargeModalLabel">查看审核记录</h4>
                    </div>
                    <style>
                        .check_table{ border-top:1px solid #ccc; border-right:1px solid #ccc; margin:0; width:100%;}
                        .check_table th{ background-color: #e0e0e0;}
                        .check_table th, .check_table td{  border-left:1px solid #ccc; border-bottom:1px solid #ccc; height:28px; line-height: 20px; text-align: center;}
                    </style>
                    <div class="modal-body" style="overflow: hidden;">
                        <table class="check_table">

                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    </div>
                </div>
            </div>
        </div>

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
<!--地图-->
<link rel="stylesheet" href="http://cache.amap.com/lbs/static/main.css?v=1.0?v=1.0" />
<!--<script src="http://cache.amap.com/lbs/static/es5.min.js"></script>-->
<script type="text/javascript" src="http://webapi.amap.com/maps?v=1.3&key=617da82831edeaf0c65e7352adf79479&plugin=AMap.ToolBar"></script>
<script type="text/javascript" src="http://webapi.amap.com/maps?v=1.3&key=617da82831edeaf0c65e7352adf79479"></script>
<script type="text/javascript"
        src="http://webapi.amap.com/maps?v=1.3&key=617da82831edeaf0c65e7352adf79479&plugin=AMap.Autocomplete,AMap.PlaceSearch,AMap.Geocoder"></script>
<script src="http://webapi.amap.com/ui/1.0/main.js"></script>

<!-- 图片切换 -->
<script src="<?= Yii::$app->request->baseUrl ?>/amaze/js/amazeui.min.js"></script>

<!-- 审核 -->
<script>

    /*点击弹出审核日志的模态框*/
    $(document).on('click', '.check_log', function () {

        var hotelCheckLog = <?= json_encode($hotelCheckLog)?>;
        $("#more_modal").modal("show");
        var html = "<tr>" +
            "<th width='5%'>序号</th>" +
            "<th width='15%'>审核之前的状态</th>" +
            "<th width='15%'>审核之后的状态</th>" +
            "<th width='40%'>审核备注信息</th>" +
            "<th width='10%'>审核人</th>" +
            "<th width='15%'>审核时间</th>" +
            "</tr>";
        var checkStatus = <?=json_encode(Yii::$app->params['hotel_check_status'])?>;
         $.each(hotelCheckLog, function(index, content){
             /*html += "<option value='"+index+"'>"+content+"</option>";*/
            html +="<tr>" +
                "<td>"+(index+1)+"</td>" +
                "<td>"+checkStatus[content.before_status]+"</td>" +
                "<td>"+checkStatus[content.after_status]+"</td>" +
                "<td>"+content.remarks+"</td>" +
                "<td>"+content.check_adminname+"</td>" +
                "<td>"+content.check_time+"</td>" +
                "</tr>";
         })
        $(".check_table").empty();
        $(".check_table").append(html);
    })

    /*点击修改审核状态*/
    $(document).on('click','.check_sub',function(){
        var parent = $(this).parent().siblings(".modal-body");
        var check_status  = parent.find(".check_status").val();
        var remarks = parent.find(".remarks").val();
        var hotel_id = $(this).siblings(".hotel_id").val();
        var before_check_status = $(this).siblings(".before_check_status").val();
        var _this = $(this);
        $.ajax({
            type: 'POST',
            url: '<?= \yii\helpers\Url::toRoute(["check-status"])?>',
            data: {
                check_status: check_status,
                remarks:remarks,
                hotel_id:hotel_id,
                before_check_status:before_check_status,
            },
            dataType: 'json',
            success: function (data) {
                if(data==1){
                    location.href = '<?php echo \yii\helpers\Url::to(['hotel/index']) ?>';
                }
                if(data==-1){
                    layer.alert("参数有误");
                }
                if(data==-2){
                    layer.alert("操作失败");
                }
            },
        });
    })
</script>


<!--高德地图-->
<script>
    $(function () {
        var listen;
        var gdclick;
        $('#pac-input').focus(function () {
            //var country_code = $('#bank_country option:selected').val();
            var prov_code = $('#region1 option:selected').val();
            var city_code = $('#region2 option:selected').val();
            var area_code = $('#region3 option:selected').val();
//                        console.log(country_code);
//                        console.log(prov_code);
            if (parseInt(prov_code) > 0 && parseInt(city_code) > 0 && parseInt(area_code) > 0) {
                var auto = new AMap.Autocomplete({
                    input: "pac-input"
                });
                listen = AMap.event.addListener(auto, "select", select);//注册监听，当选中某条记录时会触发
            }
        })

//                    $('#pac-input1').blur(function(){
//                        var country_code = $('#bank_country option:selected').val();
//                        var prov_code = $('#bank_prov option:selected').val();
//                        var city_code = $('#bank_city option:selected').val();
//                        var area_code = $('#bank_area option:selected').val();
//
//                    })

        $('#region1').change(function () {
            document.getElementById("lng").value = ''
            document.getElementById("lat").value = '';
            document.getElementById("address").value = '';
            $('#pac-input').val('');
            $('.pac1').show();
            $('.pac').hide();
            var name = $('#region1 option:selected').html();

//                            initGDmap();
            $('#map1').hide();
            map.setCity(name);
            $('#map').show();

        })
        $('#region2').change(function () {
            document.getElementById("lng").value = ''
            document.getElementById("lat").value = '';
            document.getElementById("address").value = '';
            $('.pac1').show();
            $('.pac').hide();
            var name = $('#region2 option:selected').val();

            restMap();
            $('#map1').hide();
            map.setCity(name);
            $('#map').show();

            map.setCity(name);
        })
        $('#region3').change(function () {
            document.getElementById("lng").value = ''
            document.getElementById("lat").value = '';
            document.getElementById("address").value = '';
            var name = $('#region3 option:selected').html();
            var city_name = $('#region2 option:selected').html();


            $('#pac-input').val('');
            $('#doornum').val('');
            $('.pac1').hide();
            $('.pac').show();
//                            initGDmap();
            AMap.event.addListener(map, "click", _onClick); //绑定事件，返回监听对象
            $('#map1').hide();
            map.setCity(city_name + name);
            $('#map').show();

            map.setCity(name);
        })

        $(document).on('click', '.amap-labels', function () {
            var area_code = $('#bank_area option:selected').val();
            if (area_code == 0) {
                layer.open({
                    content: '请先选择房源所在的国家-省-市-区',
                });
            }
        })

        $('#region1').change(function () {
            document.getElementById("lng").value = ''
            document.getElementById("lat").value = '';
            document.getElementById("address").value = '';
            var country_code = $('#region1 option:selected').val();
            var name = $('#region1 option:selected').html();
            if (country_code == 0) {
                $('#map').show();
                $('#map1').hide();
                initGDmap();
            }

            initGDmap(1);
            $('#map1').hide();
            map.setCity(name);
            $('#map').show();

        })
    })
    function restMap() {
        lat =<?php echo $model['latitude'] ?>;
        lng =<?php echo $model['longitude'] ?>;
        map = new AMap.Map("map", {
            resizeEnable: true,
            zoom: 15,//地图显示的缩放级别
            center: [lng, lat]
        });
        AMap.event.removeListener(gdclick);
    }
    function initGDmap() {
        lat =<?php echo $model['latitude'] ?>;
        lng =<?php echo $model['longitude'] ?>;
        map = new AMap.Map("map", {
            resizeEnable: true,
            zoom: 15,//地图显示的缩放级别
            center: [lng, lat]
        });


        marker = new AMap.Marker({
            map: map,
            position: [lng, lat],
        });


        lnglatXY = [lng, lat];
        var geocoder = new AMap.Geocoder({
            radius: 2000,
            extensions: "all"
        });
        geocoder.getAddress(lnglatXY, function (status, result) {
            if (status === 'complete' && result.info === 'OK') {
//                                console.log(result.regeocode.formattedAddress);
                var infoWindow = new AMap.InfoWindow({
                    autoMove: true,
                    offset: {x: 0, y: -30}
                });
                infoWindow.setContent(result.regeocode.formattedAddress);
                infoWindow.open(map, lnglatXY);
            }
        });
        _onClick = function (e) {
            map.clearMap();
            new AMap.Marker({
                position: e.lnglat,
                map: map
            })
            document.getElementById("lng").value = e.lnglat.getLng();
            document.getElementById("lat").value = e.lnglat.getLat();
            lnglatXY = [e.lnglat.getLng(), e.lnglat.getLat()];
            var geocoder = new AMap.Geocoder({
                radius: 1000,
                extensions: "all"
            });
            geocoder.getAddress(lnglatXY, function (status, result) {
                if (status === 'complete' && result.info === 'OK') {
//                                console.log(result.regeocode.formattedAddress);
                    var infoWindow = new AMap.InfoWindow({
                        autoMove: true,
                        offset: {x: 0, y: -30}
                    });
                    document.getElementById("address").value = result.regeocode.formattedAddress;
                    infoWindow.setContent(result.regeocode.formattedAddress);
                    infoWindow.open(map, lnglatXY);
                }
            });
        }
        gdclick = AMap.event.addListener(map, "click", _onClick); //绑定事件，返

    }

    function select(e) {
        if (e.poi && e.poi.location) {
            map.setZoom(17);
            map.setCenter(e.poi.location);
            var marker = new AMap.Marker({});
            marker.setPosition(e.poi.location);
            marker.setMap(map);
            var geocoder = new AMap.Geocoder({
                radius: 1000,
                extensions: "all"
            });
            geocoder.getAddress(e.poi.location, function (status, result) {
                if (status === 'complete' && result.info === 'OK') {
                    var infoWindow = new AMap.InfoWindow({
                        autoMove: true,
                        offset: {x: 0, y: -30}
                    });
                    document.getElementById("lng").value = e.poi.location.lng;
                    document.getElementById("lat").value = e.poi.location.lat;
                    document.getElementById("address").value = result.regeocode.formattedAddress;
                    infoWindow.setContent(result.regeocode.formattedAddress);
                    infoWindow.open(map, e.poi.location);
                }
            });
        }
    }

    //回调函数
    function placeSearch_CallBack(lnglatXY) {
        var infoWindow = new AMap.InfoWindow({
            autoMove: true,
            offset: {x: 0, y: -30}
        });
//					  var poiArr = data.poiList.pois;
        //添加marker
//					  var marker = new AMap.Marker({
//						  map: map,
//						  position: lnglatXY
//					  });
//					  map.setCenter(marker.getPosition());
        infoWindow.setContent('测试123');
        infoWindow.open(map, lnglatXY);
    }
    function createContent(poi) {  //信息窗体内容
        var s = [];
        s.push("<b>名称：" + poi.name + "</b>");
        s.push("地址：" + poi.address);
        s.push("电话：" + poi.tel);
        s.push("类型：" + poi.type);
        return s.join("<br>");
    }

    function regeocoder(lnglatXY) {  //逆地理编码
        var geocoder = new AMap.Geocoder({
            radius: 1000,
            extensions: "all"
        });
        geocoder.getAddress(lnglatXY, function (status, result) {
            if (status === 'complete' && result.info === 'OK') {
                geocoder_CallBack(result);
            }
        });
        var marker = new AMap.Marker({  //加点
            map: map,
            position: lnglatXY
        });
//					  map.setFitView();
    }
    function regeocoder1(lnglatXY) {  //逆地理编码
        var geocoder = new AMap.Geocoder({
            radius: 1000,
            extensions: "all"
        });
        geocoder.getAddress(lnglatXY, function (status, result) {
            if (status === 'complete' && result.info === 'OK') {
                adds = result.regeocode.formattedAddress;
            } else {
                adds = '暂无';
            }
        });
        return adds;
    }
    function geocoder_CallBack(data) {
        var address = data.regeocode.formattedAddress; //返回地址描述
        document.getElementById("address").value = address;
        return address;
    }
    window.onload = function () {
        initGDmap();
        /* var old_country = $('.old_country').val();
         if (old_country == 10001) {
         initGDmap();
         }else{
         $('.pac1').show();
         $('.pac').hide();
         $('#map').hide();
         //                            initMap();
         $('#map1').show();
         initMap();
         initMap();
         }
         geocoder_google = new google.maps.Geocoder();*/
//                    initMap();
    }
</script>
<!--高德地图-->


<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. Slimscroll is required when using the
     fixed layout. -->
</body>
</html>


<?php
function get_date($date_str)
{
    $week_num = date('N', strtotime($date_str));
    switch ($week_num) {
        case 7:
            $str = '日';
            break;
        case 1:
            $str = '一';
            break;
        case 2:
            $str = '二';
            break;
        case 3:
            $str = '三';
            break;
        case 4:
            $str = '四';
            break;
        case 5:
            $str = '五';
            break;
        case 6:
            $str = '六';
            break;
    }
    return $str;
}

?>


