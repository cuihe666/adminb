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

    <!--new link-->
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/bootstrap/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/dist/css/rummery.css"/>
    <link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/dist/css/gobal.css"/>
    <link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/layer/skin/default/layer.css"/>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        .hotel_information_tips, .hostshort_b {
            color: red;
        }
        /*2017年5月10日14:03:38写滚动条展示不完全给日历加个宽度*/
        .hotel-form{
            width:100%;
        }
        .rummery_con{
            width:100%;
        }
    </style>


    <body class="hold-transition skin-blue sidebar-mini">


    <!-- Content Wrapper. Contains page content -->
    <div class="wrapper-content animated fadeInRight" style="background-color: #F2F2F2;">
        <!-- Content Header (Page header) -->

        <!-- Main content -->
        <section class="content">
            <ul class="rummery_tab clearfix">
                <li class="col-sm-8"><a
                        href="<?php echo \yii\helpers\Url::to(['hotel/update', 'id' => $_GET['hotel_id']]) ?>">酒店信息</a>
                </li>
                <!-- 酒店2.1 添加酒店账户信息 ↓ admin:ys time:2017/11/3 -->
                <li class="col-sm-8">
                    <a href="<?php echo \yii\helpers\Url::to(['hotel/hotel-account','id'=>$_GET['hotel_id']]) ?>">账号信息</a>
                </li>
                <!-- 完 ↑ -->
                <li class="col-sm-8"><a
                        href="<?php echo \yii\helpers\Url::to(['hotel/two', 'id' => $_GET['hotel_id']]) ?>">酒店政策</a>
                </li>
                <li class="col-sm-8"><a
                        href="<?php echo \yii\helpers\Url::to(['hotel/three', 'id' => $_GET['hotel_id']]) ?>">服务设施</a>
                </li>
                <li class="col-sm-8"><a
                        href="<?php echo \yii\helpers\Url::to(['hotel/four', 'id' => $_GET['hotel_id']]) ?>">房型管理</a>
                </li>
                <li class="col-sm-8 current"><a href="###">房态房价设置</a></li>
                <li class="col-sm-8"><a
                        href="<?php echo \yii\helpers\Url::to(['hotel/hotel-pic', 'id' => $_GET['hotel_id']]) ?>">图片管理</a>
                </li>
                <li class="col-sm-8"><a
                        href="<?php echo \yii\helpers\Url::to(['hotel/supplier', 'id' => $_GET['hotel_id']]) ?>">关联供应商</a>
                </li>
                <li class="col-sm-8"><a
                        href="<?php echo \yii\helpers\Url::to(['hotel/contact', 'id' => $_GET['hotel_id']]) ?>">联系人信息</a>
                </li>
            </ul>
            <?= Html::beginForm('', 'post', ['enctype' => 'multipart/form-data', "class" => 'hotel-form']) ?>
            <div class="rummery_con">
                <div class="rummery_item rummery_price">
                    <ul class="house_price_tab">
                        <!--                        <li class="current tab_li1">房态</li>-->
                        <!--                        <li class="tab_li2">房价</li>-->
                        <a class="current"
                           href="<?php echo \yii\helpers\Url::to(['hotel/set-price', 'hotel_id' => $_GET['hotel_id']]); ?>">房态</a>
                        <a class=""
                           href="<?php echo \yii\helpers\Url::to(['hotel/set-price1', 'hotel_id' => $_GET['hotel_id']]); ?>">房价</a>
                    </ul>
                    <div class="house_price_con">
                        <!--房态-->
                        <div class="house_price_item fangtai">
                            <div class="house_top clearfix">
                                <div class="house_change fl">
                                    <!--                                    <select name="fangtai_select">-->
                                    <!--                                        <option value="">筛选房型（全部）</option>-->
                                    <!--                                        <option value="">某一个</option>-->
                                    <!--                                        <option value="">某一个</option>-->
                                    <!--                                    </select>-->
                                </div>
                                <div class="change_cal fr">
                                    <div class="price_clk price_clk_fangtai" data-toggle="modal"
                                         data-target="#more_modal">批量修改房态
                                    </div>
                                </div>
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
                    </div>
                </div>
            </div>
            <?= Html::endForm(); ?>

        </section>
        <!-- /.content -->
    </div>
    <!--修改单日房态-->
    <div class="modal fade house_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
         id="single_modal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myLargeModalLabel">修改单日房态</h4>
                </div>
                <div class="modal-body">
                    <ul class="house_modal_con">
                        <li class="status clearfix">
                            <label for="" class="fl">房源状态：</label>
                            <div class="radio_box fl"><input type="radio" name="house_status_single" value="2"
                                                             class="single_no_status fl" checked="checked"/><span
                                    class="fl">不做修改</span></div>
                            <div class="radio_box fl"><input type="radio" name="house_status_single" value="1"
                                                             class="fl"/><span
                                    class="fl">房间开放</span></div>
                            <div class="radio_box fl"><input type="radio" name="house_status_single" value="0"
                                                             class="fl"/><span
                                    class="fl">房间关闭</span></div>
                        </li>
                        <li class="num clearfix">
                            <label for="" class="fl">可售数量：</label>
                            <div class="radio_box fl"><input type="radio" name="house_num_single" value="0"
                                                             class="single_no_num fl" checked="checked"/><span
                                    class="fl">不做修改</span></div>
                            <div class="radio_box fl"><input type="radio" name="house_num_single" value="1" class="fl"/><span
                                    class="fl">设为</span>
                                <div class="single_num_box fl"><em class="single_house_reduce fl">-</em><input
                                        type="text"
                                        class="fl f_maxnum"
                                        value="1"
                                        name="stock_one"
                                        autocomplete="off"
                                        max="127"
                                        maxlength="3"
                                        onkeyup="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}"
                                        onafterpaste="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}"/><em
                                        class="single_house_add fl">+</em></div>
                                <span class="fl">间</span></div>
                            <script>
                                $(".f_maxnum").blur(function(){
                                    var num = parseInt($(this).val());
                                    if(num>127){
                                        layer.alert("您最大可设置127间房！");
                                        $(this).val(127);
                                        return false;
                                    }
                                })
                            </script>
                        </li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="fangtai_id" value="">
                    <input type="hidden" name="date_one" value="">
                    <button type="button" class="btn btn-primary disabled" id="single_fangtai_sure">确定</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                </div>
            </div>
        </div>
    </div>
    <!--批量修改房态-->
    <div class="modal fade house_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="more_modal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myLargeModalLabel">批量修改房态</h4>
                </div>
                <div class="modal-body">
                    <ul class="house_modal_con">
                        <li class="house_names clearfix">
                            <label for="" class="fl">房型名称：</label>
                            <?php foreach ($hotel_house as $k => $v): ?>
                                <div class="checkbox_box fl"><input type="checkbox" value="<?php echo $v['id']; ?>"
                                                                    name="house_name[]" class="fl"/><span
                                        class="fl"><?php echo $v['name']; ?></span></div>
                            <?php endforeach; ?>
                        </li>
                        <li class="house_date clearfix">
                            <label for="" class="fl">选择日期：</label>
                            <div class="house_date_con fl xhh_margin">
                                <input id="d422" name="housedate" value="" class="fangtai_date1 Wdate fl" type="text"
                                       onfocus="var d4312=$dp.$('d4312');WdatePicker({readOnly:true,minDate:'%y-%M-{%d}',onpicked:function(){d4312.focus()}})"
                                       placeholder="请设置起始日期"/><span class="fl">至</span><input id="d4312"
                                                                                              class="fangtai_date2 Wdate fl"
                                                                                              name="housedate" value=""
                                                                                              type="text"
                                                                                              placeholder="请设置结束日期"
                                                                                              onFocus="WdatePicker({minDate:'#F{$dp.$D(\'d422\')}',readOnly:true})"/>
                            </div>
                        </li>
                        <li class="house_weeks clearfix">
                            <label for="" class="fl">有效星期：</label>
                            <div class="checkbox_box house_weeks_first  fl"><input type="checkbox" class="fl"
                                                                                   id="ftweek_check"
                                                                                   onclick="CheckAll(this)"/><span
                                    class="fl">全部</span></div>
                            <div class="checkbox_box fl"><input type="checkbox" name="house_week" value="1"
                                                                class="check_box fl"/><span class="fl">周一</span></div>
                            <div class="checkbox_box fl"><input type="checkbox" name="house_week" value="2"
                                                                class="check_box fl"/><span class="fl">周二</span></div>
                            <div class="checkbox_box fl"><input type="checkbox" name="house_week" value="3"
                                                                class="check_box fl"/><span class="fl">周三</span></div>
                            <div class="checkbox_box fl"><input type="checkbox" name="house_week" value="4"
                                                                class="check_box fl"/><span class="fl">周四</span></div>
                            <div class="checkbox_box fl"><input type="checkbox" name="house_week" value="5"
                                                                class="check_box fl"/><span class="fl">周五</span></div>
                            <div class="checkbox_box fl"><input type="checkbox" name="house_week" value="6"
                                                                class="check_box fl"/><span class="fl">周六</span></div>
                            <div class="checkbox_box fl"><input type="checkbox" name="house_week" value="7"
                                                                class="check_box fl"/><span class="fl">周日</span></div>
                        </li>
                        <li class="status clearfix">
                            <label for="" class="fl">房源状态：</label>
                            <div class="radio_box fl"><input type="radio" name="house_status" value="2"
                                                             class="no fl" checked="checked"/><span
                                    class=" fl">不做修改</span>
                            </div>
                            <div class="radio_box fl"><input type="radio" name="house_status" value="1"
                                                             class="fl"/><span
                                    class="fl">房间开放</span>
                            </div>
                            <div class="radio_box fl"><input type="radio" name="house_status" value="0"
                                                             class="fl"/><span
                                    class="fl">房间关闭</span>
                            </div>
                        </li>
                        <li class="num clearfix">
                            <label for="" class="fl">可售数量：</label>
                            <div class="radio_box fl"><input type="radio" name="house_num" value="0" class=" no fl"
                                                             checked="checked"/><span
                                    class="fl">不做修改</span></div>
                            <div class="radio_box fl"><input type="radio" name="house_num" value="1" class="fl"/><span
                                    class="fl">设为</span>
                                <div class="more_num_box fl"><em class="more_house_reduce fl">-</em>
                                    <input type="text" name="stock" class="fl" value="1" autocomplete="off" maxlength="2"
                                           onkeyup="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}"
                                           onafterpaste="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}"/><em
                                        class="single_house_add fl">+</em></div>
                                <span class="fl">间</span></div>
                        </li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary disabled" id="more_fangtai_sure">确定</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                </div>
            </div>
        </div>
    </div>
    <!--批量修改房价-->
    <div class="modal fade house_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
         id="more_modal_price">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myLargeModalLabel">批量修改房价</h4>
                </div>
                <div class="modal-body">
                    <ul class="house_modal_con">
                        <li class="house_names clearfix">
                            <label for="" class="fl">房型名称：</label>
                            <?php foreach ($hotel_house as $k => $v): ?>
                                <div class="checkbox_box fl">
                                    <input type="checkbox" value="<?php echo $v['id']; ?>" name="house_name_price"
                                           class="fl"/>
                                    <span class="fl"><?php echo $v['name']; ?></span>
                                </div>
                            <?php endforeach; ?>
                        </li>
                        <li class="house_date clearfix">
                            <label for="" class="fl">选择日期：</label>
                            <div class="house_date_con fl">
                                <input id="d42" name="housedate_price" value="" class="fangjia_date1 Wdate fl"
                                       type="text"
                                       onfocus="var d432=$dp.$('d432');WdatePicker({readOnly:true,minDate:'%y-%M-{%d}',onpicked:function(){d432.focus()}})"
                                       placeholder="请设置起始日期"/><span class="fl">至</span><input id="d432"
                                                                                              class="fangjia_date2 Wdate fl"
                                                                                              name="housedate_price"
                                                                                              value="" type="text"
                                                                                              placeholder="请设置结束日期"
                                                                                              onFocus="WdatePicker({minDate:'#F{$dp.$D(\'d42\')}',readOnly:true})"/>
                            </div>
                        </li>
                        <li class="house_weeks clearfix">
                            <label for="" class="fl">有效星期：</label>
                            <div class="checkbox_box house_weeks_first fl"><input type="checkbox"
                                                                                  onclick="CheckAllfj(this)"
                                                                                  id="fjweek_check"
                                                                                  class="fl"/><span
                                    class="fl">全部</span></div>
                            <div class="checkbox_box fl"><input type="checkbox" value="1" name="house_week_price"
                                                                class="fl"/><span
                                    class="fl">周一</span></div>
                            <div class="checkbox_box fl"><input type="checkbox" value="2" name="house_week_price"
                                                                class="fl"/><span
                                    class="fl">周二</span></div>
                            <div class="checkbox_box fl"><input type="checkbox" value="3" name="house_week_price"
                                                                class="fl"/><span
                                    class="fl">周三</span></div>
                            <div class="checkbox_box fl"><input type="checkbox" value="4" name="house_week_price"
                                                                class="fl"/><span
                                    class="fl">周四</span></div>
                            <div class="checkbox_box fl"><input type="checkbox" value="5" name="house_week_price"
                                                                class="fl"/><span
                                    class="fl">周五</span></div>
                            <div class="checkbox_box fl"><input type="checkbox" value="6" name="house_week_price"
                                                                class="fl"/><span
                                    class="fl">周六</span></div>
                            <div class="checkbox_box fl"><input type="checkbox" value="7" name="house_week_price"
                                                                class="fl"/><span
                                    class="fl">周日</span></div>
                        </li>
                        <li class="status clearfix">
                            <label for="" class="fl">房价修改：</label>
                            <!--                            <div class="radio_box fl"><input type="radio" name="house_status_price" value="0" class="fl"/><span-->
                            <!--                                    class="fl">不做修改</span></div>-->
                            <div class="radio_box fl">
                                <!--                                <input type="radio" name="house_status_price" value="1" class="djyj fl"/>-->
                                <span class="fl">底价</span><input type="text" class="fl" name="tg_dj"
                                                                 style="width:60px;max-width: 60px;border: 1px solid #ccc;margin:4px;"/>
                                <span class="fl">佣金</span><input type="text" name="tg_yj"
                                                                 style="width:60px;max-width: 60px;border: 1px solid #ccc;margin:4px;">%
                            </div>
                        </li>

                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="more_fangjia_sure">确定</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                </div>
            </div>
        </div>
    </div>

    <!-- /.content-wrapper -->


    <div class="control-sidebar-bg"></div>


    <!-- REQUIRED JS SCRIPTS -->

    <!-- jQuery 2.2.3 -->
    <script src="<?= Yii::$app->request->baseUrl ?>/plugins/jQuery/jquery-2.2.3.min.js"></script>
    <!-- Bootstrap 3.3.6 -->
    <script src="<?= Yii::$app->request->baseUrl ?>/bootstrap/js/bootstrap-datetimepicker.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= Yii::$app->request->baseUrl ?>/dist/js/app.min.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/My97DatePicker/WdatePicker.js"></script>
    <!--new link-->
    <script src="<?= Yii::$app->request->baseUrl ?>/dist/js/rummery.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/dist/js/calendar.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/dist/js/gobal.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/layer/layer.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/js/jquery.session.js"></script>

    <!-- Optionally, you can add Slimscroll and FastClick plugins.
         Both of these plugins are recommended to enhance the
         user experience. Slimscroll is required when using the
         fixed layout. -->
    </body>

    <script>
        $(function () {
//            2017年5月4日15:11:17 zjl bug id 2148 start
//            单日房态
            $("input[name='house_num_single']").click(function () {
                if ($(this).hasClass("single_no_num") && $("input[name='house_status_single']")[0].checked == true) {
                    $(this).parents("#single_modal").find("#single_fangtai_sure").addClass("disabled");
                } else {
                    $(this).parents("#single_modal").find("#single_fangtai_sure").removeClass("disabled");
                }
            })
//            单日房态
            $("input[name='house_status_single']").click(function () {
                if ($(this).hasClass("single_no_status") && $("input[name='house_num_single']")[0].checked == true) {
                    $(this).parents("#single_modal").find("#single_fangtai_sure").addClass("disabled");
                } else {
                    $(this).parents("#single_modal").find("#single_fangtai_sure").removeClass("disabled");
                }
            })
            // 批量房态 状态
            $("input[name='house_status']").click(function () {
                if ($(this).hasClass("no") && $("input[name='house_num']")[0].checked == true) {
                    $(this).parents("#more_modal").find("#more_fangtai_sure").addClass("disabled");
                } else {
                    $(this).parents("#more_modal").find("#more_fangtai_sure").removeClass("disabled");
                }
            })
//            批量房态 数量
            $("input[name='house_num']").click(function () {
                if ($(this).hasClass("no") && $("input[name='house_status']")[0].checked == true) {
                    $(this).parents("#more_modal").find("#more_fangtai_sure").addClass("disabled");
                } else {
                    $(this).parents("#more_modal").find("#more_fangtai_sure").removeClass("disabled");
                }
            })


//            2017年5月4日15:11:17 zjl bug id 2148 end

            $('.date_text').change(function () {
                var value = $(this).val();
                var hotel_id =<?php echo $_GET['hotel_id']; ?>;
                $.ajax({
                    type: 'post',
                    url: "<?php echo \yii\helpers\Url::to(['update-session']) ?>",
                    data: {
                        hotel_id: hotel_id,
                        date: value,
                    },
                })
                location.reload();
            })
            $('.newprev').click(function () {
                var value = $('#date_text').val();
                var hotel_id =<?php echo $_GET['hotel_id']; ?>;
                $.ajax({
                    type: 'post',
                    url: "<?php echo \yii\helpers\Url::to(['update-next']) ?>",
                    data: {
                        hotel_id: hotel_id,
                        date: value,
                    },
                    success: function (data) {

                    }
                })
                location.reload();
            })
//2017年5月8日14:44:25 zjl 房态当前天之前的不可点击
            $('.oldprev').click(function () {
                var value = $('#date_text').val();
                var hotel_id =<?php echo $_GET['hotel_id']; ?>;
                var now1 = new Date().getFullYear();
                var now2 = new Date().getMonth() + 1;
                var now3 = new Date().getDate();
                if (now2 < 10) {
                    now2 = "0" + now2;
                }
                if (now3 < 10) {
                    now3 = "0" + now3;
                }
                var y = value.slice(0, 4);
                var m = value.slice(5, 7);
                var d = value.slice(8, 10);
//                console.log(y,m,d,now1,now2,now3)
                if (y < now1) {
                    return false;
                } else {
                    if (m == now2) {
                        if (d <= now3) {
                            return false;
                        } else {
                            $.ajax({
                                type: 'post',
                                url: "<?php echo \yii\helpers\Url::to(['update-prev']) ?>",
                                data: {
                                    hotel_id: hotel_id,
                                    date: value,
                                },
                                success: function (data) {

                                }
                            })
                            location.reload();
                        }

                    } else if (m < now2) {
                        return false;
                    } else {
                        $.ajax({
                            type: 'post',
                            url: "<?php echo \yii\helpers\Url::to(['update-prev']) ?>",
                            data: {
                                hotel_id: hotel_id,
                                date: value,
                            },
                            success: function (data) {

                            }
                        })
                        location.reload();

                    }
                }

            })

            $('.oldprev2').click(function () {
//                2017年5月8日16:24:44 zjl 房价日历当前日之前的不可点击
                var value = $('#date_text2').val();
                var hotel_id =<?php echo $_GET['hotel_id']; ?>;
                var now1 = new Date().getFullYear();
                var now2 = new Date().getMonth() + 1;
                var now3 = new Date().getDate();
                if (now2 < 10) {
                    now2 = "0" + now2;
                }
                if (now3 < 10) {
                    now3 = "0" + now3;
                }
                var y = value.slice(0, 4);
                var m = value.slice(5, 7);
                var d = value.slice(8, 10);
//                console.log(y,m,d,now1,now2,now3)
                if (y < now1) {
                    return false;
                } else {
                    if (m == now2) {
                        if (d <= now3) {
                            return false;
                        } else {
                            $.ajax({
                                type: 'post',
                                url: "<?php echo \yii\helpers\Url::to(['update-prev2']) ?>",
                                data: {
                                    hotel_id: hotel_id,
                                    date: value,
                                },
                                success: function (data) {

                                }
                            })
                            location.reload();
                        }

                    } else if (m < now2) {
                        return false;
                    } else {
                        $.ajax({
                            type: 'post',
                            url: "<?php echo \yii\helpers\Url::to(['update-prev2']) ?>",
                            data: {
                                hotel_id: hotel_id,
                                date: value,
                            },
                            success: function (data) {

                            }
                        })
                        location.reload();
                    }
                }


            })

            $('.newprev2').click(function () {
                var value = $('#date_text2').val();
                var hotel_id =<?php echo $_GET['hotel_id']; ?>;
                $.ajax({
                    type: 'post',
                    url: "<?php echo \yii\helpers\Url::to(['update-next2']) ?>",
                    data: {
                        hotel_id: hotel_id,
                        date: value,
                    },
                    success: function (data) {

                    }
                })
                location.reload();
            })

            $('#single_fangtai_sure').click(function () {
                var house_status = $('input:radio[name="house_status_single"]:checked').val();
                var stock_status = $('input:radio[name="house_num_single"]:checked').val();
                var stock = $('input[name="stock_one"]').val();
                var hotel_id =<?php echo $_GET['hotel_id']; ?>;
                var hotel_house_id = $('input[name="fangtai_id"]').val();
                var date = $('input[name="date_one"]').val();
                if (house_status == null) {
                    layer.open({
                        content: '请设置房态',
                    });
                    return false;
                }
                if (stock_status == null) {
                    layer.open({
                        content: '请设置库存',
                    });
                    return false;
                }
                $.ajax({
                    type: 'post',
                    url: "<?php echo \yii\helpers\Url::to(['set-status']) ?>",
                    data: {
                        hotel_id: hotel_id,
                        hotel_house_id: hotel_house_id,
                        house_status: house_status,
                        stock_status: stock_status,
                        stock: stock,
                        date: date
                    },
                    success: function (data) {
                        if (data == -1) {
                            layer.open({
                                content: '缺少参数',
                            });
                            return false;
                        }
                        if (data == -2) {
//                            2017年5月4日21:00:53 zjl bug 2155
//                            layer.open({
//                                content: '请激活房态',
//                            });
                            return false;
                        }
                        if (data >= 0) {
                            layer.open({
                                content: '设置成功',
                            });
                            location.reload();
                        }
                    }
                })
            })

            $('#more_fangtai_sure').click(function () {
//                var bool=check_fangtai();
//                if(bool===false){
//                    return false;
//                }
                var hotel_house_arr = new Array;
                var house_week_arr = new Array;
                $("input[name='house_name[]']:checkbox:checked").each(function (i) {
                    hotel_house_arr[i] = $(this).val();
                })
                $("input[name='house_week']:checkbox:checked").each(function (i) {
                    house_week_arr[i] = $(this).val();
                })
                var house_week_str = house_week_arr.join(',');
                var hotel_house_str = hotel_house_arr.join(',');
                var fangtai_date1 = $('.fangtai_date1').val();
                var fangtai_date2 = $('.fangtai_date2').val();
                var house_status = $('input:radio[name="house_status"]:checked').val();
                var house_num = $('input:radio[name="house_num"]:checked').val();
                var stock = $('input[name="stock"]').val();
                var hotel_id =<?php echo $_GET['hotel_id']; ?>;
                $.ajax({
                    type: 'post',
                    url: "<?php echo \yii\helpers\Url::to(['batch-status']) ?>",
                    data: {
                        hotel_id: hotel_id,
                        hotel_house_str: hotel_house_str,
                        start_time: fangtai_date1,
                        end_time: fangtai_date2,
                        house_status: house_status,
                        house_num: house_num,
                        stock: stock,
                        house_week: house_week_str
                    },
                    success: function (data) {
                        if (data == -1) {
                            layer.open({
                                content: '请补全信息',
                            });
                            return;
                        }
                        if (data == -2) {
//                            2017年5月4日15:04:55 zjl bug id 2153
//                            layer.open({
//                                content: '请先激活房源状态',
//                            });
                            return;
                        }
                        if (data == -3) {
                            layer.open({
                                content: '设置失败',
                            });
                            return;
                        }
                        if (data == 1) {
                            $('#more_modal').modal('hide');
//                            $(".fangtai").load(location.href+" .fangtai");
                            location.reload();
                        }
                    }
                })
            })

            $(document).on('click', '.fangtai_item', function () {
                var hotel_house_id = $(this).attr('hotel_house_id');
                $('input[name="fangtai_id"]').val(hotel_house_id);
                var index_of = $(this).index();
                var date = $('#tab li').find('div').eq(index_of).attr('date');
                var stock=$(this).find('span').html();
                if(stock=='' || isNaN(stock)){
                    var stock=1;
                }
                $('input[name="stock_one"]').val(stock);
                $('input[name="date_one"]').val(date);
            })

            $('.edit_price_save').click(function () {
                var This = $(this);
                var hotel_id =<?php echo $_GET['hotel_id'] ?>;
                var hotel_house_id = $(this).parents('.item_title').attr('hotel_house_id');
                var date_arr = new Array;
                var price_arr = new Array; //底价
                $(".date_div").each(function (i) {
                    date_arr[i] = $(this).attr('date');
                })
                var date_str = date_arr.join(',');
                This.parents('.last_click').siblings('.click_con').find('.hotel_price').each(function (i) {
                    price_arr[i] = $(this).val();
                })
                var price_str = price_arr.join(',');
                $.ajax({
                    type: 'post',
                    url: "<?php echo \yii\helpers\Url::to(['update-price']) ?>",
                    data: {
                        hotel_id: hotel_id,
                        hotel_house_id: hotel_house_id,
                        date: date_str,
                        price: price_str,
                    },
                    success: function (data) {
                        if (data == -1) {
                            layer.open({
                                content: '缺少参数',
                            });
                            return false;
                        }
                        if (data == -2) {
                            layer.open({
                                content: '请填写合法的金额',
                            });
                            return false;
                        }
                        if (data == 0) {
                            layer.open({
                                content: '设置失败',
                            });
                            return false;
                        }
                        if (data == 1) {
                            layer.open({
                                content: '设置成功',
                            });
                            This.parents('.last_click').siblings('.click_con').find('.hotel_price').each(function (i) {
                                $(this).val(price_arr[i]);
                                $(this).parent().siblings(".dijia").text(price_arr[i]);
                            })
                        }
                    }
                })
            })

            $('.edit_money_save').click(function () {
                var This = $(this);
                var hotel_id =<?php echo $_GET['hotel_id'] ?>;
                var hotel_house_id = $(this).parents('.item_title').attr('hotel_house_id');
                var date_arr = new Array;
                var price_arr = new Array; //底价
                $(".date_div").each(function (i) {
                    date_arr[i] = $(this).attr('date');
                })
                var date_str = date_arr.join(',');
                This.parents('.last_click').siblings('.click_con').find('.scale_price').each(function (i) {
                    price_arr[i] = $(this).val();
                })
                var price_str = price_arr.join(',');
                $.ajax({
                    type: 'post',
                    url: "<?php echo \yii\helpers\Url::to(['update-scale']) ?>",
                    data: {
                        hotel_id: hotel_id,
                        hotel_house_id: hotel_house_id,
                        date: date_str,
                        price: price_str,
                    },
                    success: function (data) {
                        if (data == -1) {
                            layer.open({
                                content: '缺少参数',
                            });
                            return false;
                        }
                        if (data == -2) {
                            layer.open({
                                content: '请填写合法的佣金比例(0-1000的正整数)',
                            });
                            return false;
                        }
                        if (data == 0) {
                            layer.open({
                                content: '设置失败',
                            });
                            return false;
                        }
                        if (data == 1) {
                            layer.open({
                                content: '设置成功',
                            });
                            This.parents('.last_click').siblings('.click_con').find('.scale_price').each(function (i) {
                                $(this).val(price_arr[i]);
                                $(this).parent().siblings(".yongjin").text(price_arr[i]);
                            })
                        }
                    }
                })
            })

            $('#more_fangjia_sure').click(function () {
                var bool = fangjia();
                if (bool === false) {
                    return false;
                }
                var hotel_id =<?php echo $_GET['hotel_id'] ?>;
                var hotel_house_arr = new Array;
                var house_week_arr = new Array;
                var fangjia_date1 = $('.fangjia_date1').val();
                var fangjia_date2 = $('.fangjia_date2').val();
                var dijia = $("input[name='tg_dj']").val();
                var yongjin = $("input[name='tg_yj']").val();
                $("input[name='house_name_price']:checkbox:checked").each(function (i) {
                    hotel_house_arr[i] = $(this).val();
                })
                $("input[name='house_week_price']:checkbox:checked").each(function (i) {
                    house_week_arr[i] = $(this).val();
                })
                var house_week_str = house_week_arr.join(',');
                var hotel_house_str = hotel_house_arr.join(',');
                $.ajax({
                    type: 'post',
                    url: "<?php echo \yii\helpers\Url::to(['batch-price']) ?>",
                    data: {
                        hotel_id: hotel_id,
                        hotel_house_str: hotel_house_str,
                        start_time: fangjia_date1,
                        end_time: fangjia_date2,
                        house_dj: dijia,
                        house_yj: yongjin,
                        house_week: house_week_str
                    },
                    success: function (data) {
                        if (data == -1) {
                            layer.open({
                                content: '缺少参数',
                            });
                            return;
                        }
                        if (data == -2) {
                            layer.open({
                                content: '价格有误',
                            });
                            return;
                        }
                        if (data == -3) {
                            layer.open({
                                content: '佣金有误',
                            });
                            return;
                        }
                        if (data > 0) {
                            $('#more_modal_price').modal('hide');
//                            $(".fangtai").load(location.href+" .fangtai");
                            location.reload();
                        }
                    }
                })
            })
        })
        function check_fangtai() {
            var val = $('input:checked[name="house_name[]"]:checked').val();
            if (val == null) {
                layer.open({
                    content: '请先选择房型',
                });
                return false;
            }
            if ($("input.fangtai_date1").val() == "" && $("input.fangtai_date2").val() == "" || $("input.fangtai_date1").val() == "" || $("input.fangtai_date2").val() == "") {
                layer.open({
                    content: '请选择日期',
                });
                return false;
            }
            var val = $('input:checked[name="house_week"]:checked').val();
            if (val == null) {
                layer.open({
                    content: '请选择有效星期',
                });
                return false;
            }
            var val = $('input:radio[name="house_status"]:checked').val();
            if (val == null) {
                layer.open({
                    content: '请选择房源状态',
                });
                return false;
            }
            var list = $('input:radio[name="house_num"]:checked').val();
            if (list == null) {
                layer.open({
                    content: '请选择可售数量',
                });
                return false;
            }

            $(this).parents("#more_modal").modal("hide");
        }

        function fangjia() {
            var val = $('input:checked[name="house_name_price"]:checked').val();
            if (val == null) {
                layer.open({
                    content: '请选择房型',
                });
                return false;
            }
            if ($("input.fangjia_date1").val() == "" && $("input.fangjia_date2").val() == "" || $("input.fangjia_date1").val() == "" || $("input.fangjia_date2").val() == "") {
                layer.open({
                    content: '请选择日期',
                });
                return false;
            }
//            var val = $('input:radio[name="house_status_price"]:checked').val();
//            if (val == null) {
//                layer.open({
//                    content: '请选择房价修改',
//                });
//                return false;
//            }
            var list = $('.djyj:checked');
            var djval = $('input[name="tg_dj"]').val();
            var yjval = $('input[name="tg_yj"]').val();
            if (list && djval == "") {
                layer.open({
                    content: '请填写底价',
                });
                return false;
            }
            if (list && yjval == "") {
                layer.open({
                    content: '请填写佣金',
                });
                return false;
            }
        }
    </script>
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