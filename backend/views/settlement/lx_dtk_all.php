<!DOCTYPE html>
<html lang="en">
<head>
    <title>财务管理-退款管理-旅行-待退款订单-全部</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <meta content="telephone=no" name="format-detection" />
    <link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/webcaiwu/css/settlement.css">
    <script src="<?= Yii::$app->request->baseUrl ?>/webcaiwu/js/jquery.min.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/My97DatePicker/WdatePicker.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/webcaiwu/js/sq.js"></script>
</head>
<style>
    .third_ul li span, .second_ul li span{
        width:90px;
    }
    .sxh_content .second_ul li{
        width:300px;
    }
    .form_table tr:not(:first-child) td input[type="checkbox"]{
        margin-left:58px;
    }

</style>
<script>
    $(function(){
        $(".sxh_content .top .sq").click(function(){
            $(".second_ul").slideUp()
            $(".third_ul").slideUp()
        })

        $(".sxh_content .top .cx").click(function(){
            $(".third_ul").slideDown()
        })
    })

</script>

<body>
<!--开始-->
<div class="sxh_main">
    <section class="content-header h_wrap">
        <ul>
            <li class="current-top">
                <a href="<?php echo \yii\helpers\Url::to(['settlement/lx_dtk_all']) ?>">
                    全部 <i>（）</i>
                </a>
            </li>
            <li>
                <a href="<?php echo \yii\helpers\Url::to(['settlement/lx_dtk_dsh']) ?>">
                    退款待确认 <i>（）</i>
                </a>
            </li>
            <li>
                <a href="<?php echo \yii\helpers\Url::to(['settlement/lx_dtk_dtk']) ?>">
                    待退款 <i>（）</i>
                </a>
            </li>
        </ul>
        <hr>
    </section>
    <section class="content">
        <div class="sxh_tk-cx">
            <div class="sxh_content">
                <div class="top" style="margin-bottom:20px;padding:0 20px;">
                    <span class="cx" style="background:url(<?= Yii::$app->request->baseUrl ?>/webcaiwu/img/arrow_bot.png) left center no-repeat;padding-left:20px;display:inline-block;background-size:15px">查询条件</span>
                    <i></i>
                    <span class="sq" style="background:url(<?= Yii::$app->request->baseUrl ?>/webcaiwu/img/shouqi.png) left center no-repeat;padding-left:20px;display:inline-block;background-size:20px">收起</span>
                </div>

                <ul class="first_ul">
                    <li>
                        <span>订单编号:</span>
                        <input type="text">
                    </li>
                    <li>
                        <select>
                            <option value="不限">不限</option>
                            <option value="下单时间">下单时间</option>
                            <option value="支付时间">支付时间</option>
                            <option value="入住日期">入住日期</option>
                            <option value="离店日期">离店日期</option>
                        </select>
                        <input id="date_start" name="" value="" class="Wdate" type="text" onfocus="var date_end=$dp.$('date_end');WdatePicker({readOnly:true,minDate:'%y-%M-{%d}',onpicked:function(){date_end.focus()}})" />至
                        <input id="date_end" class="Wdate" name="" value="" type="text" onFocus="WdatePicker({minDate:'#F{$dp.$D(\'date_start\')}',readOnly:true,maxDate:'#F{$dp.$D(\'date_start\',{M:+6})}'})" />
                    </li>
                    <li>
                        <span>订单类型：</span>
                        <select>
                            <option value="不限">不限</option>
                            <option value="不需确认">不需确认</option>
                            <option value="需要确认">需要确认</option>
                        </select>
                    </li>
                </ul>
                <div style="clear:both;"></div>
                <ul class="second_ul">
                    <li>
                        <span>达人姓名：</span>
                        <input type="text">
                    </li>
                    <li>
                        <span>预订人姓名：</span>
                        <input type="text">
                    </li>
                    <li>
                        <span>预订人电话：</span>
                        <input type="text">
                    </li>
                </ul>
                <div style="clear:both;"></div>
                <ul class="third_ul">
                    <li>
                        <span>商品名称:</span>
                        <input type="text">
                    </li>
                    <li>
                        <span>支付方式:</span>
                        <select>
                            <option value="-全部-">-全部-</option>
                            <option value="微信">微信</option>
                            <option value="支付宝">支付宝</option>
                        </select>
                    </li>
                    <li>
                        <button type="button" class="btn btn-primary" >搜索</button>
                    </li>
                    <li>
                        <button type="button" class="btn">清空</button>
                    </li>
                </ul>
                <div style="clear: both"></div>
            </div>
            <div class="daochu">
                <button type="button" class="btn btn-default btn-lg active">导出</button>
                <button type="button" class="btn btn-default btn-lg active">导出全部</button>
            </div>
            <div class="form_table">
                <p>*本报表内金额单位为（元）</p>
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <td>
                            <input type="checkbox">
                            <span style="display: inline-block">商品信息</span>
                        </td>
                        <td>
                            <span>预订人信息</span>
                        </td>
                        <td>
                            <span>达人信息</span>
                        </td>
                        <td>
                            <span>订单类型</span>
                        </td>
                        <td>
                            <span>人数</span>
                        </td>
                        <td>
                            <span>订单金额</span>
                        </td>
                        <td>
                            <span>退款金额</span>
                        </td>
                        <td>
                            <span>支付方式</span>
                        </td>
                        <td>
                            <span>订单状态</span>
                        </td>
                        <td>
                            <span>操作</span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="10">
                            <input type="checkbox">
                            <em>订单编号:1959400773765672</em>
                            <em>下单时间:2017-06-18 22:15:34</em>
                            <em>发团时间:2017-06-18 22:15:34</em>
                            <em>申请退款时间:2017-06-18 22:15:34</em>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>当地活动</span>
                            <span>婺源|踏春赏花季</span>
                        </td>
                        <td>
                            <span>露西</span>
                            <span>18635228384</span>
                        </td>
                        <td>
                            <span>露西</span>
                            <span>18635228384</span>
                        </td>
                        <td>需要确认</td>
                        <td>2</td>
                        <td>500.00</td>
                        <td>400.00</td>
                        <td>支付宝</td>
                        <td>退款中</td>
                        <td>
                            <a href="#">退款审核</a>
                            <a href="#" style="margin-right:10px;" target="_blank">操作流水</a>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="10" style="text-align: inherit">
                            <input type="checkbox">
                            <em>订单编号:1959400773765672</em>
                            <em>下单时间:2017-06-18 22:15:34</em>
                            <em>发团时间:2017-06-18 22:15:34</em>
                            <em>申请退款时间:2017-06-18 22:15:34</em>
                        </td>
                    </tr>

                    </tbody>
                </table>
            </div>
            <!--分页-->
            <div class="paganition">
                <div class="left">
                    <span>每页显示条数:</span>
                    <select>
                        <option value="15">15</option>
                        <option value="30">30</option>
                        <option value="50">50</option>
                    </select>
                </div>
                <div class="right">
                    <ul class="pager">
                        <li><a href="#">首页</a></li>
                        <li class="disabled"><a href="#">上页</a></li>
                        <li><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li><a href="#">5</a></li>
                        <li><a href="#">下页</a></li>
                        <li><a href="#">末页</a></li>
                    </ul>
                </div>
            </div>
            <div style="clear:both;"></div>
        </div>
    </section>
</div>

<!--结束-->
</body>
</html>