<!DOCTYPE html>
<html lang="en">
<head>
    <title>财务管理-退款管理-旅行-已处理订单</title>
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
        width:100px;
    }
    .sxh_content .second_ul li{
        width:300px;
    }
    .form_table tr:not(:first-child) td input[type="checkbox"] {
        margin-left:62px;
    }

    .modal-body table tr td:nth-child(1),.modal-body table tr td:nth-child(3){
        text-align: right;
        width:150px;
    }
    .modal-body table tr td:nth-child(2),.modal-body table tr td:nth-child(4){
        text-align: left;
    }
    .footer-btn{
        text-align: center;
    }
    .modal-footer{
        border:none;
    }
    .h-top{
        border-bottom:1px solid #e5e5e5;
    }
    .modal-title{
        font-size:14px;
    }
    .h-body span,.h-body textarea{
        border:1px solid #e5e5e5;
        display: block;
        padding:20px 0;
        width:65%;
        resize:none;
    }

    @media (min-width: 768px){
        .calendar-dialog{
            width:1200px;
        }
    }

</style>
<script>
    $(function(){
        $(".sxh_content .top .sq").click(function(){
            $(".second_ul").slideUp()
            $(".third_ul").slideUp()
        })

        $(".sxh_content .top .cx").click(function(){
            $(".second_ul").slideDown()
            $(".third_ul").slideDown()
        })
    })

</script>

<body>
<!--modal-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">提示:</h4>
            </div>
            <div class="modal-body">请选择所要导出的订单</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>


<!--退款详情 modal start-->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel2">退款成功:</h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <td>
                            订单编号：
                        </td>
                        <td>
                            TB17020433526
                        </td>
                        <td>
                            订单状态：
                        </td>
                        <td>
                            已退款
                        </td>
                    </tr>
                    <tr>
                        <td>
                            收款单号：
                        </td>
                        <td>
                            MS2017071012345
                        </td>
                        <td>

                        </td>
                        <td>

                        </td>
                    </tr>
                    <tr>
                        <td>
                            下单日期：
                        </td>
                        <td>
                            2017-03-05
                        </td>
                        <td>
                            申请退款时间：
                        </td>
                        <td>
                            2017-03-15
                        </td>
                    </tr>
                    <tr>
                        <td>
                            预订人姓名：
                        </td>
                        <td>
                            张三
                        </td>
                        <td>
                            预订人手机号：
                        </td>
                        <td>
                            13483948234
                        </td>
                    </tr>
                    <tr>
                        <td>退款方式：</td>
                        <td>支付宝</td>
                        <td>退款账户：</td>
                        <td>asdfg@126.com</td>
                    </tr>
                    <tr>
                        <td>
                            订单金额：
                        </td>
                        <td>
                            <u style="color:orange" data-toggle="modal" data-target="#myModal5">¥100.00/¥200.00</u>
                        </td>
                        <td>
                            实收金额：
                        </td>
                        <td>
                            <u style="color:red;">¥150.00</u>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            优惠券金额：
                        </td>
                        <td>
                            满减券(满200减50)
                        </td>
                        <td>
                            退款金额：
                        </td>
                        <td>
                            <u style="color:red;">¥150.00</u>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            退换优惠券：
                        </td>
                        <td>
                            满减券(满500减200)
                        </td>
                        <td>
                            退款人：
                        </td>
                        <td>
                            棠果A
                        </td>
                    </tr>
                    <tr>
                        <td>
                            退款时间：
                        </td>
                        <td>
                            2017-03-09 14:00:00
                        </td>
                        <td>
                            退款单号：
                        </td>
                        <td>
                            <span style="color:blue">143634545568453</span>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer footer-btn">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>
<!--end-->


<!--开始-->
<div class="sxh_main">
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
                <button type="button" class="btn btn-default btn-lg active" data-toggle="modal" data-target="#myModal">导出</button>
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
                        <td>500.00</td>
                        <td>支付宝</td>
                        <td>退款中</td>
                        <td>
                            <button style="color:#3c8dbc" data-toggle="modal" data-target="#myModal2">退款详情</button>
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
                        <td>500.00</td>
                        <td>支付宝</td>
                        <td>
                            <span style="color:red;">退款失败</span>
                        </td>
                        <td>
                            <button style="color:#3c8dbc" data-toggle="modal" data-target="#myModal2">退款详情</button>
                            <a href="#" style="margin-right:10px;" target="_blank">操作流水</a>
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