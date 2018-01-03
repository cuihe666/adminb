<?php
$this->title = '价格规则';
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- 日历css -->
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/css/fullcalendar.css">
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/css/fullcalendar.print.css">
<!-- 日历引用文件 -->
<script src="<?= Yii::$app->request->baseUrl ?>/My97DatePicker/WdatePicker.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/fullcalendar.js"></script>

<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/layer.js"></script>
<style>
    .content > .row > span {
        border: 1px solid #666;
        padding: 5px 10px;
        margin-right: 10px;
    }

    .table td {
        padding-top: 10px !important;
    }

    .table td label {
        margin-right: 20px;
    }

    .table td label input {
        float: left;
        margin-right: 5px;
    }

    .table td label em {
        margin-top: 2px;
        display: inline-block;
        font-style: normal;
        color: #666;
    }

    .table .acreage label input {
        width: 10%;
        float: inherit;
        text-align: center;
        font-weight: normal;
    }

    .table .acreage label em {
        margin-right: 10px;
    }

    .table .acreage2 label {
        margin-top: 10px;
        display: block;
    }

    .table .acreage3 label {
        display: inline-block;
    }

    .table .acreage3 ul {
        display: none;
    }

    .table .acreage3 ul.current_ul {
        display: block;
    }

    .table .acreage2 label input {
        width: 50px;
        text-align: center;
    }

    .table .acreage3 label input {
        width: 15px;
        float: left;
    }

    .table .acreage2 label img {
        width: 25px;
        margin-left: 15px;
    }

    .table .acreage2 label img.shanchu {
        width: 20px;
        margin-left: 20px;
    }

    input[type=number] {
        -moz-appearance: textfield;
        -webkit-appearance: textfield;
        -o-appearance: textfield;
    }

    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        -moz-appearance: none;
        -o-appearance: none;
        margin: 0;
    }

    /*地图样式*/

    .left {
        float: left;
    }

    .right {
        /*float: right;*/
    }

    .clearfix {
        clear: both;
    }

    .hide {
        display: none;
    }

    /*地图标注文本样式*/
    #tip2 {
        background-color: #fff;
        padding-left: 10px;
        padding-right: 2px;
        font-size: 12px;
        border-radius: 3px;
        overflow: hidden;
        width: 66.67%;
        position: absolute;
        left: 10px;
        top: 10px;
        z-index: 999;
    }

    #tip2 select {
        height: 30px;
        margin-bottom: 10px;
    }

    #tip2 input[type="button"] {
        background-color: #0D9BF2;
        height: 25px;
        text-align: center;
        line-height: 25px;
        color: #fff;
        font-size: 12px;
        padding: 0 10px;
        border-radius: 3px;
        outline: none;
        border: 0;
        cursor: pointer;
    }

    #tip2 input[type="text"] {
        height: 25px;
        border: 1px solid #eee;
        padding-left: 5px;
        border-radius: 3px;
        outline: none;
        width: 100% !important;
        height: 34px;
    }

    #pos {
        background-color: #fff;
        padding-left: 10px;
        padding-right: 10px;
        font-size: 12px;
        border-radius: 3px;
        position: absolute;
        left: 0;
        top: 85px;
    }

    #pos input {
        border: 1px solid #ddd;
        height: 23px;
        border-radius: 3px;
        outline: none;
    }

    #result1 {
        max-height: 300px;
    }

    .amap-info-content {
        text-align: center;
        width: 250px !important;
        padding-left: 0;
        padding-right: 0;
    }

    .amap-logo {
        display: none;
    }

    .amap-copyright {
        display: none !important;
    }

    .cha {
        position: absolute;
        right: 20px;
        top: 20px;
        width: 20px;
    }

    .change_price span {
        background-color: #ccc;
        padding: 5px 10px;
        border-radius: 5px;
        color: #fff;
        margin-bottom: 10px;
        display: inline-block;
        margin-right: 10px;
    }

    .week_label {
        padding-left: 25px;
    }

    .week_label label {
        margin-right: 15px;
        display: inline-block;
    }

    .week_label input {
        float: left;
        margin-top: 6px;
    }

    .week_label em {
        font-style: normal;
        font-weight: normal;
        display: inline-block;
        margin-left: 5px;
        margin-top: 3px;
    }

    textarea {
        outline: none;
        padding: 5px 0 0 5px;
    }

    #myModal6 label {
        display: inline-block;
        margin-right: 15px;
    }

    #myModal6 label input {
        float: left;
    }

    #myModal6 .row {
        margin-top: 5px
    }

    #myModal6 label em {
        font-style: normal;
        color: #999;
        font-weight: normal;
        display: inline-block;
        margin-top: 0px;
        margin-left: 3px;
        font-size: 14px;
    }

    #myModal6 span {
        display: inline-block;
        font-size: 14px;
    }

    .table-responsive > .table td {
        text-align: left !important;
    }

    .gmnoprint {
        display: none;
    }

    #deposit {
        display: none
    }

    .wrapper {
        position: inherit;
    }
</style>
<script>
    //    $(function(){
    //        if($(".No_deposit").is(":checked")){
    //            $("#deposit").hide()
    //        }
    //        if($(".None_deposit").is(":checked")){
    //            $("#deposit").show()
    //        }
    //
    //    })
</script>

<script>
    function leave() {
        var len = $(".title_inp").val().length;
        if (len > 22 || len < 5) {
            alert("请输入正确格式");
            $(".title_inp").val("")
        }
    }
    //input checkbox

    function chooseOne(cb) {
        var obj = document.getElementsByName("deposit");
        for (var i = 0; i < obj.length; i++) {
            if (obj[i] != cb) {
                obj[i].checked = false;
            } else {
                obj[i].checked = cb.checked;
                if ($(".None_deposit").is(":checked")) {
                    $("#deposit").show()
                } else {
                    $("#deposit").hide()
                }

            }
        }
    }
    window.onload = function () {
        if ($(".profit").is(":checked")) {
            $(".profit_div").show()
        } else {
            $(".profit_div").hide()
        }
        if ($(".commission").is(":checked")) {
            $(".commission_div").show()
        } else {
            $(".commission_div").hide()
        }
    }
    //2017年5月8日13:40:10 宋杏会 国内外佣金
    function choosetwo() {
        if ($(".commission").is(":checked")) {
            $(".commission_div").show()
        } else {
            $(".commission_div").hide()
        }
    }

    function choosethree() {
        if ($(".profit").is(":checked")) {
            $(".profit_div").show()
        } else {
            $(".profit_div").hide()
        }
    }


    // 日常价格改变事件
    function change() {
//        $(".change_price span").css("background-color", "#367fa9")
    }

    $(function () {
        $("body").on("click", ".shanchu", function () {
            $(this).parents(".str_label").remove()
        });
        $(".cha").click(function () {
            $("#myModal").hide()
            $(".modal-backdrop").hide()
        })
        $(".inp_first").click(function () {
            $(".ul_1").show()
            $(".ul_2").hide()
            $(".ul_3").hide()
            $(".ul_4").hide()
        })
        $(".inp_second").click(function () {
            $(".ul_1").hide();
            $(".ul_2").show();
            $(".ul_3").hide()
            $(".ul_4").hide()
        })
        $(".inp_third").click(function () {
            $(".ul_1").hide()
            $(".ul_2").hide()
            $(".ul_3").show()
            $(".ul_4").hide()
        })
        $(".inp_fourth").click(function () {
            $(".ul_1").hide()
            $(".ul_2").hide()
            $(".ul_3").hide()
            $(".ul_4").show()
        })
    })
</script>
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="background-color: #fff;">
        <div class="modal-content">
            <div class="modal-body">
                <span
                    style="background-color: #ccc;padding:5px 10px;border-radius: 5px;display: inline-block;margin-bottom: 10px;color:#fff;">排期修改</span>
                <div>
                    <span>开始时间:</span>
                    <input id="d422" name="stock_start" value="" class="Wdate" type="text"
                           onfocus="var d4312=$dp.$('d4312');WdatePicker({readOnly:true,minDate:'%y-%M-{%d}',onpicked:function(){d4312.focus()}})"
                    / style="width:200px;margin-top: 5px;height: 30px;">
                </div>
                <div style="margin-top:10px;">
                    <span>结束时间:</span>
                    <input id="d4312" class="Wdate" name="stock_end" value="" type="text"
                           onFocus="WdatePicker({minDate:'#F{$dp.$D(\'d422\')}',readOnly:true,maxDate:'#F{$dp.$D(\'d422\',{M:+6})}'})"
                           style="width:200px;height:30px;margin-top:5px;"/>
                </div>
                <div style="margin-top:10px;">
                    <span>库存:</span>
                    <select class="batch_stock">
                        <option value="-1">请选择</option>
                        <option value="0">无房</option>
                        <option value="1">1间</option>
                        <option value="2">2间</option>
                    </select>
                </div>
                <div style="margin-top:10px;">
                    <span>状态:</span>
                    <select class="batch_status">
                        <option value="1">开启</option>
                        <option value="2">关闭</option>
                    </select>
                </div>
            </div>

        </div>

        <div class="modal-footer" style="text-align: center;">
            <button type="button" class="btn btn-primary update-stock" style="background-color: orange;border:none">
                确认修改
            </button>
            <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="background-color: #fff;">
        <div class="modal-content">
            <div class="modal-body">
                <span
                    style="background-color: #ccc;padding:5px 10px;border-radius: 5px;display: inline-block;margin-bottom: 10px;color:#fff;">批量价格修改</span>
                <div>
                    <span style="width:80px;text-align: right;display: inline-block;">价格:</span>
                    <input type="number" name="special_price" style="width:100px;">元
                </div>
                <div style="margin-top:10px;">
                    <span style="width:80px;text-align: right;display: inline-block;">开始时间:</span>
                    <input id="start_date" value="" class="Wdate" type="text"
                           onfocus="var end_date=$dp.$('end_date');WdatePicker({readOnly:true,minDate:'%y-%M-{%d}',onpicked:function(){end_date.focus()}})"
                    / style="width:200px;margin-top: 5px;height: 30px;">
                </div>
                <div style="margin-top:10px;">
                    <span style="width:80px;text-align: right;display: inline-block;">结束时间:</span>
                    <input id="end_date" class="Wdate" value="" type="text"
                           onFocus="WdatePicker({minDate:'#F{$dp.$D(\'start_date\')}',readOnly:true,maxDate:'#F{$dp.$D(\'start_date\',{M:+6})}'})"
                           style="width:200px;height:30px;margin-top:5px;"/>
                </div>

            </div>

        </div>
        <div class="modal-footer" style="text-align: center;">
            <button type="button" class="btn btn-primary batch_update" style="background-color: orange;border:none">
                确认修改
            </button>
            <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="background-color: #fff;">
        <div class="modal-content">
            <div class="modal-body">
                <span
                    style="background-color: #ccc;padding:5px 10px;border-radius: 5px;display: inline-block;margin-bottom: 10px;color:#fff;">星期价格修改</span>
                <div>
                    <span style="width:80px;text-align: right;display: inline-block;">星期价格:</span>
                    <input type="number" class="week-price" style="width:100px;">元
                </div>
                <!--                <div style="margin-top:10px;">-->
                <!--                    <span style="width:80px;text-align: right;display: inline-block;">开始时间:</span>-->
                <!--                    <input id="start_date_one" name="TravelHigo[start_time]" value="" class="Wdate" type="text"-->
                <!--                           onfocus="var end_date_one=$dp.$('end_date_one');WdatePicker({readOnly:true,minDate:'%y-%M-{%d}',onpicked:function(){end_date_one.focus()}})"-->
                <!--                    / style="width:35%;margin-top: 5px;height: 30px;">-->
                <!--                </div>-->
                <!--                <div style="margin-top:10px;">-->
                <!--                    <span style="width:80px;text-align: right;display: inline-block;">结束时间:</span>-->
                <!--                    <input id="end_date_one" class="Wdate" name="TravelHigo[end_time]" value="" type="text"-->
                <!--                           onFocus="WdatePicker({minDate:'#F{$dp.$D(\'start_date_one\')}',readOnly:true,maxDate:'#F{$dp.$D(\'start_date_one\',{M:+6})}'})"-->
                <!--                           style="width:36%;margin-top:5px;height: 30px;"/>-->
                <!--                </div>-->
                <div style="margin-top:10px;" class="week_label">
                    <label>
                        <input type="checkbox" class="week-check" name="week-check" value="0">
                        <em>周日</em>
                    </label>
                    <label>
                        <input type="checkbox" class="week-check" name="week-check" value="1">
                        <em>周一</em>
                    </label>
                    <label>
                        <input type="checkbox" class="week-check" name="week-check" value="2">
                        <em>周二</em>
                    </label>
                    <label>
                        <input type="checkbox" class="week-check" name="week-check" value="3">
                        <em>周三</em>
                    </label>
                    <label>
                        <input type="checkbox" class="week-check" name="week-check" value="4">
                        <em>周四</em>
                    </label>
                    <label>
                        <input type="checkbox" class="week-check" name="week-check" value="5">
                        <em>周五</em>
                    </label>
                    <label>
                        <input type="checkbox" class="week-check" name="week-check" value="6">
                        <em>周六</em>
                    </label>
                </div>
            </div>

        </div>
        <div class="modal-footer" style="text-align: center;">
            <button type="button" class="btn btn-primary week-update" style="background-color: orange;border:none">
                确认修改
            </button>
            <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        </div>
    </div>
</div>
<div class="modal" id="myModal5">
    <div class="modal-dialog" style="background-color: #fff;">
        <div class="modal-content">
            <div class="calendarWrapper">
                <div id="calendar" class="dib"></div>
            </div>
            <style>
                .fc-header td {
                    padding-top: 10px;
                }

                .fc-event {
                    border: none;
                    background: transparent !important;
                }

                .fc-event-inner {
                    text-align: center;
                    margin-top: 5px;
                }

                .fc-event-title {

                }
            </style>
            <script>
                $(document).ready(function () {
                    var date = new Date();
                    var d = date.getDate();
                    var m = date.getMonth();
                    var y = date.getFullYear();
                    var initialLangCode = 'en';
                    $('#calendar').fullCalendar({

                        buttonText: {
                            prev: "<span class='fc-text-arrow'>&lsaquo;上个月</span>",
                            next: "<span class='fc-text-arrow'>下个月&rsaquo;</span>"
                        },
                        editable: false,
                        weekends: true,
                        defaultDate: '2016-06-06',
                        events: [
                            <?php

                            foreach ($date_data as $k => $v) {

                            ?>

                            {
                                title: '<?php
                                    echo '￥' . $v;
                                    ?>',
                                start: '<?php  echo $k;?>'

                            },
                            <?php
                            }

                            ?>
                        ],
                    });
                    $("#fullcal").click(function () {
                        $("#myModal5").show();
                        $('#calendar').fullCalendar('render');
                    })
                    $("#fullcal_close").click(function () {
                        $("#myModal5").hide();
                        $(".modal-backdrop.in").hide()
                    })
                })
                /** 绑定事件到日期下拉框 **/
                $(function () {
                    $("#fc-dateSelect").delegate("select", "change", function () {
                        var fcsYear = $("#fcs_date_year").val();
                        var fcsMonth = $("#fcs_date_month").val();
                        $("#calendar").fullCalendar('gotoDate', fcsYear, fcsMonth);
                    });

                });

            </script>
        </div>
        <div class="modal-footer" style="text-align: center;">
            <button type="button" class="btn btn-default" id="fullcal_close">关闭</button>
        </div>
    </div>
</div>
<section class="content" style="width:80%;margin:0 auto;">
    <div class="row">
        <span id="base_message">
            <a href="<?php echo \yii\helpers\Url::to(['update-one', 'house_id' => $_GET['house_id']]) ?>"
               style="color:#666;">1、基本信息</a>
        </span>
        <span id="price_rule" style="border:none;background-color: #367fa9;">
            <a href="###" style="color:#fff;">2、价格规则</a>
        </span>
        <span id="ruzhu_note">
            <a href="<?php echo \yii\helpers\Url::to(['add-three', 'house_id' => $_GET['house_id']]) ?>"
               style="color:#666;">3、入住须知</a>
        </span>
        <span id="house_dep">
            <a href="<?php echo \yii\helpers\Url::to(['add-four', 'house_id' => $_GET['house_id']]) ?>"
               style="color:#666;">4、房屋描述</a>
        </span>
        <?php if ($house_error) { ?>
            <b style="color:red;">审核不通过原因:<?php echo $house_error['reson']; ?></b>
        <?php } ?>
    </div>
    <div class="form-group" style="margin-top:30px;">
        <!--        <div class="row">-->
        <!--            <span style="padding: 5px 10px;background-color: #367fa9;color:#fff;">2、价格规则</span>-->
        <!--        </div>-->
        <div class="table-responsive">
            <table class="table table-condensed">
                <tbody>
                <tr>
                    <td style="text-align: right!important;width:140px;">日常价格:</td>
                    <td>
                        <input type="number" placeholder="" value="<?php echo $price; ?>" id="normal-price"
                               onchange="change()"
                               style="width:80px;text-align: center;">
                        <button class="btn btn-primary price-confirm">确定</button>
                        <!--                        <span style="color:red;">(修改后立即生效)</span>-->
                        <span style="color:#ccc">*6月内每日房价(间/夜)</span>
                    </td>
                </tr>
                <tr class="change_price">
                    <td style="text-align: right!important;width:140px">特殊价格:</td>
                    <td>
                        <span modal_name="#myModal2" class="price-modal"
                              style="cursor:pointer;<?php if ($price_status == 0) {
                                  echo 'background-color: #ccc';
                              } else {
                                  echo 'background-color: #367fa9';
                              } ?>">排期修改</span>
                        <span modal_name="#myModal3" class="price-modal"
                              style="cursor:pointer;<?php if ($price_status == 0) {
                                  echo 'background-color: #ccc';
                              } else {
                                  echo 'background-color: #367fa9';
                              } ?>">批量修改</span>
                        <span modal_name="#myModal4" class="price-modal"
                              style="cursor:pointer;<?php if ($price_status == 0) {
                                  echo 'background-color: #ccc';
                              } else {
                                  echo 'background-color: #367fa9';
                              } ?>">星期修改</span>
                        <span modal_name="#myModal5" id="fullcal" class="price-modal"
                              style="cursor:pointer;<?php if ($price_status == 0) {
                                  echo 'background-color: #ccc';
                              } else {
                                  echo 'background-color: #367fa9';
                              } ?>">预览</span>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right!important;width:140px;">押金:</td>
                    <td>
                        <label>
                            <input type="checkbox" name="deposit" class="No_deposit"
                                   value="0" <?php if ($deposit == 0) {
                                echo 'checked';
                            } ?>
                                   onclick="return chooseOne(this);">
                            <em>无押金</em>
                        </label>
                        <?php if ($deposit > 0): ?>
                            <label>
                                <input type="checkbox" class="None_deposit" name="deposit" value="1"
                                       onclick="return chooseOne(this);" checked="checked">
                                <em>线下押金</em>
                            </label>
                            <input type="number"  value="<?php echo $deposit ?>"
                                   style="width:80px;text-align: center; display: inline-block" id="deposit" >
                        <?php else: ?>
                            <label>
                                <input type="checkbox" class="None_deposit" name="deposit" value="1"
                                       onclick="return chooseOne(this);">
                                <em>线下押金</em>
                            </label>
                            <input type="number" placeholder="" value="0" id="deposit"
                                   style="width:80px;text-align: center;">

                        <?php endif ?>

                    </td>
                </tr>

                <!--                2017年5月8日13:40:10 宋杏会 合伙人增加国内外佣金-->
                <?php if ($is_guowai == 1 &&  Yii::$app->user->getId()==2) { ?>
                    <tr>
                        <td style="text-align: right!important;width:140px;">(国内)佣金:</td>
                        <td>
                            <label style="float:left">
                                <span style="float: left;margin-right: 5px;"><?php echo $old_scale . '%'; ?></span>
                                <input type="checkbox" <?php if ($scale_status == 1){ ?>checked <?php } ?>
                                       class="commission" name="commission" value="1" onclick="return choosetwo(this);">
                                <em>设置佣金</em>
                            </label>
                            <div class="commission_div">
                                <span>佣金:</span>
                                <select class="guonei_scale">
                                    <?php foreach ($yongjin_list as $k => $v): ?>
                                        <option
                                            value="<?php echo $v['scale_value']; ?>"><?php echo $v['scale_value'] . '%'; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <span>有效期:</span>
                                <input id="guonei_date_start" placeholder="起始时间" name="guonei_top_start"
                                       value="<?php echo $scale ? date('Y-m-d', strtotime($scale['start_time'])) : ''; ?>"
                                       class="Wdate" type="text"
                                       onfocus="var date_end=$dp.$('guonei_date_end');WdatePicker({readOnly:true,minDate:'%y-%M-{%d}',onpicked:function(){guonei_date_end.focus()}})"
                                       style="width:147px;margin-top: 5px;">-
                                <input id="guonei_date_end" class="Wdate" placeholder="结束时间" name="guonei_top_end"
                                       value="<?php echo $scale ? date('Y-m-d', strtotime($scale['end_time'])) : ''; ?>"
                                       type="text"
                                       onFocus="WdatePicker({minDate:'#F{$dp.$D(\'guonei_date_start\')}',readOnly:true,maxDate:'#F{$dp.$D(\'guonei_date_start\',{M:+6})}'})"
                                       style="width:147px;margin-top:5px;"/>
                                <i class="time_tip" style="color:red;font-size: 12px;"></i>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
                <?php if ($is_guowai == 0 && Yii::$app->user->getId()==2) { ?>

                    <tr>
                        <td style="text-align: right!important;width:140px;">(海外)售卖卖价:</td>
                        <td>
                            <label style="float:left;">
                                <span class="haiwai_sell"
                                      style="float: left;margin-right: 5px;"><?php echo ceil($haiwai_sell_price); ?></span>
                                <input type="checkbox" <?php if ($scale_status == 1){ ?>checked <?php } ?>
                                       class="profit" name="profit" value="1" onclick="return choosethree(this);">
                                <em>设置利润</em>
                            </label>
                            <div class="profit_div">
                                <span>利润:</span>
                                <select class="haiwai_scale">
                                    <?php foreach ($haiwai_list as $k => $v): ?>
                                        <option
                                            <?php if ($scale['commision'] == $v['scale_value']){ ?>selected<?php } ?>
                                            value="<?php echo $v['scale_value']; ?>"><?php echo $v['scale_value'] . '%'; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <span>有效期:</span>
                                <input id="haiwai_start_time" placeholder="起始时间" name="haiwai_time_start"
                                       value="<?php echo $scale ? date('Y-m-d', strtotime($scale['start_time'])) : ''; ?>"
                                       class="Wdate" type="text"
                                       onfocus="var date_end=$dp.$('haiwai_end_time');WdatePicker({readOnly:true,minDate:'%y-%M-{%d}',onpicked:function(){haiwai_end_time.focus()}})"
                                       style="width:147px;margin-top: 5px;">-
                                <input id="haiwai_end_time" class="Wdate" placeholder="结束时间" name="haiwai_time_end"
                                       value="<?php echo $scale ? date('Y-m-d', strtotime($scale['end_time'])) : ''; ?>"
                                       type="text"
                                       onFocus="WdatePicker({minDate:'#F{$dp.$D(\'haiwai_start_time\')}',readOnly:true,maxDate:'#F{$dp.$D(\'haiwai_start_time\',{M:+6})}'})"
                                       style="width:147px;margin-top:5px;"/>
                                <i class="time_tip2" style="color:red;font-size: 12px;"></i>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
                <style>
                    .profit_div, .commission_div {
                        display: none;
                    }
                </style>
                <!--                end-->

                <?php if ($is_guowai == 0) { ?>
                    <tr>
                        <td style="text-align: right!important;">清洁费</td>
                        <td>
                            <input type="number" placeholder=""
                                   value="<?php echo $old_house_data ? $old_house_data['clean_fee'] : 0; ?>"
                                   id="clean_fee"
                                   onchange="change()"
                                   style="width:80px;text-align: center;" onblur="fee()">
                            <!--                        <span style="color:red;">(修改后立即生效)</span>-->
                            <span style="color:#ccc">(间/次)</span>
                            <i class="fee_tip" style="color:red;font-size: 12px;"></i>
                        </td>
                        <script>
                            function fee() {
                                var reg = /^\+?[1-9]\d*$/;
                                var val = $("#clean_fee").val();
                                if(parseInt(val)!=0){
                                    if (!reg.test(val)) {
                                        $(".fee_tip").text("请输入大于0的正整数")
                                    } else {
                                        $(".fee_tip").text("")
                                    }
                                }
                            }
                        </script>
                    </tr>
                    <tr>
                        <td style="text-align: right!important;">超额费用</td>
                        <!--                    宋杏会 超额费用修改-->
                        <td>
                            <label>
                                <input type="radio" <?php if ($old_house_data['is_over_fee'] == 1){ ?>checked<?php } ?>
                                       class="None_excess" name="excess" value="1">
                                <em>不收取</em>
                            </label>
                            <label style="margin-right:10px;">
                                <input type="radio" <?php if ($old_house_data['is_over_fee'] == 2){ ?>checked<?php } ?>
                                       class="line" name="excess" value="2">
                                <em>线下收取</em>
                            </label>
                            <input type="number" placeholder=""
                                   value="<?php if ($old_house_data['is_over_fee'] == 2) {
                                       echo $old_house_data ? $old_house_data['over_fee'] : '';
                                   } ?>" id="line" style="width:80px;text-align: center;">
                            <i class="line_tip" style="color:red;font-size: 12px;"></i>
                            <label style="margin-left:15px;margin-right:10px;">
                                <input type="radio" <?php if ($old_house_data['is_over_fee'] == 3){ ?>checked<?php } ?>
                                       class="online" name="excess" value="3">
                                <em>线上收取</em>
                            </label>
                            <input type="number" placeholder=""
                                   value="<?php if ($old_house_data['is_over_fee'] == 3) {
                                       echo $old_house_data ? $old_house_data['over_fee'] : '';
                                   } ?>" id="online"
                                   style="width:80px;text-align: center;">
                            <?php if($max_num){ ?><span style="color:#ccc">(<?php echo '元/人，'.$max_num.'人以上算超额' ?>)</span><?php } ?>
                            <i class="online_tip" style="color:red;font-size: 12px;"></i>
                        </td>
                        <script>
                            function choosefour(cb) {
                                var obj = document.getElementsByName("excess");
                                for (var i = 0; i < obj.length; i++) {
                                    if (obj[i] != cb) {
                                        obj[i].checked = false;
                                    } else {
                                        obj[i].checked = cb.checked;
                                        if ($(".line").is(":checked")) {
                                            $("#line").show()
                                        } else {
                                            $("#line").hide()
                                        }
                                        if ($(".online").is(":checked")) {
                                            $("#online").show()
                                        } else {
                                            $("#online").hide()
                                        }


                                    }
                                }
                            }
                            function line() {
                                var reg = /^\+?[1-9]\d*$/;
                                var val = $("#line").val()
                                if (!reg.test(val)) {
                                    $(".line_tip").text("请输入大于0的正整数")
                                } else {
                                    $(".line_tip").text("")
                                }
                            }
                            function online() {
                                var reg = /^\+?[1-9]\d*$/;
                                var val = $("#online").val();
                                if (!reg.test(val)) {
                                    $(".online_tip").text("请输入大于0的正整数")
                                } else {
                                    $(".online_tip").text("")
                                }
                            }

                        </script>
                        <!--                    <td>-->
                        <!--                        <input type="number" placeholder="" value="0" id="over_fee"-->
                        <!--                               onchange="change()"-->
                        <!--                               style="width:80px;text-align: center;">-->
                        <!--                        <span style="color:#ccc">(元/人)</span>-->
                        <!--                    </td>-->
                    </tr>
                <?php } ?>
                <tr class="acreage acreage2 acreage3 ">
                    <td style="text-align: right!important;width:140px;">退款规则:</td>
                    <td style="text-align: inherit!important;">
                        <label>
                            <input type="radio" name="rb" checked class="inp_first" value="1">
                            <span>灵活</span>
                        </label>
                        <label>
                            <input type="radio" name="rb" class="inp_second" value="2">
                            <span>中等</span>
                        </label>
                        <label>
                            <input type="radio" name="rb" class="inp_third" value="3">
                            <span>严格</span>
                        </label>
                        <label>
                            <input type="radio" name="rb" class="inp_fourth" value="4">
                            <span>极严</span>
                        </label>
                        <ul class="current_ul ul_1">
                            <li style="margin-top:10px;">灵活的:</li>
                            <li style="font-weight: bold;font-size: 14px;">入住前1天14：00点前取消预订可获得全额退款</li>
                            <li>1、要获得全额住宿费用退款，房客必须在入住日期当天前1天14：00前取消预订。例如，如果入住日期是周五，则需在该周周四的14：00之前取消预订</li>
                            <li>
                                2、如果房客在入住日14：00前24小时内取消预订，首晚房费将不可退还
                            </li>
                            <li>
                                3、如果房客已入住但决定提前退房，那么扣除未消费的头一天的房费，其余部分退还给房客
                            </li>
                        </ul>
                        <ul class="ul_2">
                            <li style="margin-top:10px;">中等:</li>
                            <li style="font-weight: bold;font-size: 14px;">入住前5天14：00点前取消预订可获得全额退款</li>
                            <li>1、要获得住宿费用的全额退款，房客必须在入住日期，前5天14：00前取消预订。例如，如果入住日期是周五，则需在前一个周日的14：00之前取消预订</li>
                            <li>
                                2、如果房客提前不到5天退订，那么首晚房费将不可退还，但剩余的天数将退还50%的房费
                            </li>
                            <li>
                                3、如果房客已入住但决定提前退房，那么扣除未消费的头一天的房费，其余部分50%退还给房客
                            </li>
                        </ul>
                        <ul class="ul_3">
                            <li style="margin-top:10px;">严格:</li>
                            <li style="font-weight: bold;font-size: 14px;">入住前1周14：00点前取消预订可获得50%退款</li>
                            <li>
                                1、要获得50%的住宿费用退款，房客必须在入住日期，前7天14：00前取消预订，否则不予退款。例如，入住日期是周五，则需在前一个周五的14：00之前取消预订。周四的14：00之前取消预订
                            </li>
                            <li>
                                2、如果房客未能在7天前取消预订，未住宿天数的房费将不予退还
                            </li>
                            <li>
                                3、如果房客已入住但决定提前退房，剩余天数的房费将不予退还
                            </li>
                        </ul>
                        <ul class="ul_4">
                            <li style="margin-top:10px;">
                                极严：
                            </li>
                            <li style="font-weight: bold;font-size: 14px;">
                                房客支付后取消预订将不退还任何费用
                            </li>
                            <li>
                                1、预订成功之后，若要取消预订，将不退还任何费用
                            </li>
                        </ul>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="row" style="padding-top: 0;">
            <input type="hidden" id="price_status" value="<?php echo $price_status; ?>">
            <input type="hidden" id="house_id" value="<?php echo $_GET['house_id']; ?>">
            <!--            <button type="button" class="btn btn-primary">上一步</button>-->
            <button type="button" class="btn btn-primary add-last" <?php if ($price_status == 0) {
                echo 'disabled';
            } ?>>保存并继续
            </button>
        </div>
    </div>
</section>
<script>
    $(function () {


        $('.price-confirm').click(function () {
            var price = $('#normal-price').val();
            var house_id = $('#house_id').val();
            var house_status = $('#price_status').val();
            if (price == '') {
                layer.open({
                    content: '价格不能为空',
                });
                return false;
            }
            $.ajax({
                type: 'post',
                url: "<?php echo \yii\helpers\Url::to(['add-price']) ?>",
                data: {price: price, house_id: house_id},
                success: function (data) {
                    var data = $.parseJSON(data);
                    if (data.status == 0) {
                        if (house_status == 1) {
                            $('#normal-price').val(data.old_price);
                        } else {
                            $('#price_status').val(0);
                            $(".change_price span").css("background-color", "#ccc");
                        }
                        layer.open({
                            content: data.msg,
                        });
                    } else {
                        $(".change_price span").css("background-color", "#367fa9");
                        $('#price_status').val(1);
                        layer.open({
                            content: '设置价格成功',
                        });
                        location.reload();
                    }
                }
            });
        })

        $('.price-modal').click(function () {
            var price_status = $('#price_status').val();
            var name = $(this).attr('modal_name');
            if (price_status == 1) {
                $(name).modal();
            }
        })

        $('.update-stock').click(function () {
            var stock_start_time = $('input[name="stock_start"]').val();
            var stock_end_time = $('input[name="stock_end"]').val();
            var num = $('.batch_stock option:selected').val();
            var status = $('.batch_status option:selected').val();
            var house_id = $('#house_id').val();
            if (stock_start_time != '' && stock_end_time != '' && house_id > 0) {
                $.ajax({
                    type: 'post',
                    url: "<?php echo \yii\helpers\Url::to(['add-stock']) ?>",
                    data: {
                        start_time: stock_start_time,
                        end_time: stock_end_time,
                        house_id: house_id,
                        num: num,
                        status: status
                    },
                    success: function (data) {
                        if (data == 1) {
                            $('#myModal2').modal('hide');
                            location.reload();
                        }
                    }
                })
            } else {
                layer.open({
                    content: '所填信息有误',
                });
            }
        })


        $('.batch_update').click(function () {
            var start_time = $('#start_date').val();
            var end_time = $('#end_date').val();
            var price = $('input[name="special_price"]').val();
            var house_id = $('#house_id').val();
            if (start_time != '' && end_time != '' && price != '' && price > 0 && house_id > 0) {
                $.ajax({
                    type: 'post',
                    url: "<?php echo \yii\helpers\Url::to(['batch-price']) ?>",
                    data: {start_time: start_time, end_time: end_time, house_id: house_id, price: price},
                    success: function (data) {
                        if (data == -1) {
                            layer.open({
                                content: '请补全信息',
                            });
                        }
                        if (data == -2) {
                            layer.open({
                                content: '价格有误',
                            });
                        }
                        if (data == 1) {
                            $('#myModal3').modal('hide');
                            location.reload();
                        }
                    }
                })
            } else {
                layer.open({
                    content: '所填信息有误',
                });
            }
        })

        $('.week-update').click(function () {
            var price = $('.week-price').val();
            var house_id = $('#house_id').val();
            var week_arr = new Array;
            $("input[name='week-check']:checkbox:checked").each(function (i) {
                week_arr[i] = $(this).val()
            })
            var week_str = week_arr.join(',');
            if (week_str && price > 0 && house_id > 0) {
                $.ajax({
                    type: 'post',
                    url: "<?php echo \yii\helpers\Url::to(['week-price']) ?>",
                    data: {week: week_str, house_id: house_id, price: price},
                    success: function (data) {
                        if (data == -1) {
                            layer.open({
                                content: '所填信息有误',
                            });
                        }
                        if (data == -2) {
                            layer.open({
                                content: '价格有误',
                            });
                        }
                        if (data == 1) {
                            $('#myModal4').modal('hide');
                            location.reload();
                        }
                    }
                })
            } else {
                layer.open({
                    content: '所填信息有误',
                });
            }
        })

        $('.haiwai_scale').change(function () {
            var scale = $('.haiwai_scale option:selected').val();
            var price = $('#normal-price').val();
            if (parseInt(price) > 0) {
                var jia = eval(1 + scale / 100);
                $('.haiwai_sell').html(Math.ceil(accMul(price, jia)));
            }
        })

        function accMul(arg1, arg2) {

            var m = 0, s1 = arg1.toString(), s2 = arg2.toString();

            try {
                m += s1.split(".")[1].length
            } catch (e) {
            }

            try {
                m += s2.split(".")[1].length
            } catch (e) {
            }

            return Number(s1.replace(".", "")) * Number(s2.replace(".", "")) / Math.pow(10, m)

        }

        $('.add-last').click(function () {
            var house_id = $('#house_id').val();
            var price_status = $('#price_status').val();
            var refund = $("input[name='rb']:checked").val();
            var is_deposit = $("input[name='deposit']:checked").val();
            var deposit_price = $('#deposit').val();
            var is_guowai =<?php echo $is_guowai; ?>;
            if (is_deposit == 0) {
                var deposit_price = 0;
            }
            if (is_guowai == 1) {
                var excess_type = 1;
                var excess = 0;
                if ($(".commission").is(':checked')) {
                    var is_scale = 1;
                    var scale = $('.guonei_scale option:selected').val();
                    if ($("#guonei_date_start").val == "" || $("#guonei_date_end").val() == "") {
                        $(".time_tip").text("请选择有效时间");
                        return false;
                    } else {
                        var scale_start_time = $('#guonei_date_start').val();
                        var scale_end_time = $('#guonei_date_end').val();
                        $(".time_tip").text("")
                    }
                } else {
                    var scale = 0;
                    var scale_start_time = '';
                    var scale_end_time = '';
                    var is_scale = 0;
                }
            } else {
                var excess_type = $('input:radio[name="excess"]:checked').val();
                if (excess_type == '') {
                    layer.open({
                        content: '请选择超额费用',
                    });
                    return false;
                }
                var reg = /^\+?[1-9]\d*$/;
                if (excess_type == 2) {
                    var excess = $('#line').val();
                    if (!reg.test(parseInt(excess))) {
                        $(".line_tip").text("请输入大于0的正整数.")
                        return false;
                    } else {
                        $(".line_tip").text("")
                    }
                }
                if (excess_type == 3) {
                    var excess = $('#online').val();
                    if (!reg.test(parseInt(excess))) {
                        $(".online_tip").text("请输入大于0的正整数")
                        return false;
                    } else {
                        $(".online_tip").text("")
                    }
                }
                if (excess_type == 1) {
                    var excess = 0;
                }
                if ($(".profit").is(':checked')) {
                    var is_scale = 1;
                    var scale = $('.haiwai_scale option:selected').val();
                    if ($("#haiwai_start_time").val == "" || $("#haiwai_end_time").val() == "") {
                        $(".time_tip2").text("请选择有效时间");
                        return false;
                    } else {
                        var scale_start_time = $('#haiwai_start_time').val();
                        var scale_end_time = $('#haiwai_end_time').val();
                        $(".time_tip2").text("")
                    }
                } else {
                    var scale = 0;
                    var scale_start_time = '';
                    var scale_end_time = '';
                    var is_scale = 0;
                }
            }
            var clean_fee = $('#clean_fee').val();
//            var over_fee = $('#over_fee').val();
            if (house_id > 0 && price_status == 1 && refund) {
                $.ajax({
                    type: 'post',
                    url: "<?php echo \yii\helpers\Url::to(['two-last']) ?>",
                    data: {
                        refund: refund,
                        house_id: house_id,
                        is_deposit: is_deposit,
                        deposit: deposit_price,
                        clean_fee: clean_fee,
                        is_scale: is_scale,
                        start_time: scale_start_time,
                        end_time: scale_end_time,
                        scale: scale,
                        excess_type: excess_type,
                        excess: excess
                    },
                    success: function (data) {
                        if (data == -1) {
                            layer.open({
                                content: '所填信息有误',
                            });
                        }
                        if (data == -2) {
                            layer.open({
                                content: '请输入合法的数字',
                            });
                        }
                        if (data == -3) {
                            layer.open({
                                content: '上传失败',
                            });
                        }
                        if (data == 1) {
                            location.href = "<?php echo \yii\helpers\Url::to(['add-three', 'house_id' => $_GET['house_id']]) ?>"
                        }
                    }
                })
            } else {
                layer.open({
                    content: '所填信息有误',
                });
            }
        })
    })
</script>