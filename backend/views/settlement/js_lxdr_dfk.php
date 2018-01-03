<!DOCTYPE html>
<html lang="en">
<head>
    <title>财务管理-结算处理-旅行结算-达人待付款-结算待付款</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <meta content="telephone=no" name="format-detection" />
    <link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/webcaiwu/css/settlement.css">
    <script src="<?= Yii::$app->request->baseUrl ?>/webcaiwu/js/jquery.min.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/My97DatePicker/WdatePicker.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/webcaiwu/js/sq.js"></script>
</head>
<style>
    .form_table tr:not(:first-child) td input[type="checkbox"] {
        margin-left: 27px;
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
    .modal-body textarea{
        resize:none;
        width:65%;
        height:100px;
    }
</style>
<script>
    $(function(){
        $(".sxh_content .top .sq").click(function(){
            $(".second_ul").slideUp()
        })

        $(".sxh_content .top .cx").click(function(){
            $(".second_ul").slideDown()
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
            <div class="modal-footer footer-btn">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>

<!--付款详情 modal start-->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel2">付款确认:</h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <td>
                            结算单号：
                        </td>
                        <td>
                            TB17020433526
                        </td>
                        <td>
                            付款状态：
                        </td>
                        <td>
                            结算待付款
                        </td>
                    </tr>
                    <tr>
                        <td>
                            结算日期：
                        </td>
                        <td>
                            <span>2017-03-05</span>
                            <em> 10:00:00</em>
                        </td>
                        <td>
                            付款日期：
                        </td>
                        <td>
                            <span>2017-03-05</span>
                            <em> 10:00:00</em>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            达人姓名：
                        </td>
                        <td>
                            张三
                        </td>
                        <td>
                            达人手机号：
                        </td>
                        <td>
                            12345678954
                        </td>
                    </tr>
                    <tr>
                        <td>
                            收款人姓名：
                        </td>
                        <td>
                            小张
                        </td>
                        <td>
                            收款人联系方式：
                        </td>
                        <td>
                            13483948234
                        </td>
                    </tr>
                    <tr>
                        <td>收款方式：</td>
                        <td>银联</td>
                        <td>收款账户：</td>
                        <td>6225838472839222</td>
                    </tr>
                    <tr>
                        <td>
                            开户行：
                        </td>
                        <td>
                            交通银行西二旗支行：
                        </td>
                        <td>
                            订单总额：
                        </td>
                        <td>
                            <u style="color:orange;">¥1634.00</u>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            实收金额：
                        </td>
                        <td>
                            <u style="color:orange;">¥1134.00</u>
                        </td>
                        <td>
                            优惠券金额：
                        </td>
                        <td>
                            <u style="color:orange;">¥500.00</u>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            结算金额：
                        </td>
                        <td>
                            <u style="color:red;">¥0.00</u>
                        </td>
                        <td>
                            付款手续费：
                        </td>
                        <td>
                            <u style="color:orange;"></u>
                        </td>

                    </tr>
                    </tbody>
                </table>

            </div>
            <div class="modal-footer footer-btn">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal3">付款</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
            </div>
        </div>
    </div>
</div>
<!--end-->

<!--modal 点击付款确认里的付款按钮的modal start-->
<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel3">结算付款:</h4>
            </div>
            <div class="modal-body">
                <p>确认后，结算款将支付给商家，请核对账户信息正确</p>
            </div>
            <div class="modal-footer footer-btn">
                <button type="button" class="btn btn-primary">确定</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
            </div>
        </div>
    </div>
</div>
<!--end-->


<!--开始-->
<div class="sxh_main">
    <section class="content-header h_wrap">
        <ul>
            <li class="current-top">
                <a href="<?php echo \yii\helpers\Url::to(['settlement/js_lxdr_all']) ?>">
                    全部 <i>（）</i>
                </a>
            </li>
            <li>
                <a href="<?php echo \yii\helpers\Url::to(['settlement/js_lxdr_dqr']) ?>">
                    结算待确认 <i>（）</i>
                </a>
            </li>
            <li>
                <a href="<?php echo \yii\helpers\Url::to(['settlement/js_lxdr_deny']) ?>">
                    结算拒绝 <i>（）</i>
                </a>
            </li>
            <li>
                <a href="<?php echo \yii\helpers\Url::to(['settlement/js_lxdr_dfk']) ?>">
                    结算待付款 <i>（）</i>
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
                        <span>结算ID:</span>
                        <input type="text">
                    </li>
                    <li>
                        <select>
                            <option value="结算日期">结算日期</option>
                            <option value="付款日期">付款日期</option>
                        </select>
                        <input id="date_start" name="" value="" class="Wdate" type="text" onfocus="var date_end=$dp.$('date_end');WdatePicker({readOnly:true,minDate:'%y-%M-{%d}',onpicked:function(){date_end.focus()}})" />至
                        <input id="date_end" class="Wdate" name="" value="" type="text" onFocus="WdatePicker({minDate:'#F{$dp.$D(\'date_start\')}',readOnly:true,maxDate:'#F{$dp.$D(\'date_start\',{M:+6})}'})" />
                    </li>
                    <li>
                        <span>付款状态</span>
                        <select>
                            <option value="全部">全部</option>
                            <option value="结算待付款">结算待付款</option>
                            <option value="付款中">付款中</option>
                            <option value="付款失败">付款失败</option>
                        </select>
                    </li>
                </ul>
                <div style="clear:both;"></div>
                <ul class="second_ul">
                    <li>
                        <span>达人ID:</span>
                        <input type="text">
                    </li>
                    <li>
                        <span>达人姓名：</span>
                        <input type="text">
                    </li>
                    <li>
                        <span>达人电话：</span>
                        <input type="text">
                    </li>
                    <li style="width:inherit">
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
                            <span style="display: inline-block">房东信息</span>
                        </td>
                        <td>
                            <span>收款方式</span>
                        </td>
                        <td>
                            <span>收款账户</span>
                        </td>
                        <td>
                            <span>开户行</span>
                        </td>
                        <td>
                            <span>订单总额</span>
                        </td>
                        <td>
                            <span>应收金额</span>
                        </td>
                        <td>
                            <span>实收金额</span>
                        </td>
                        <td>
                            <span>优惠券金额</span>
                        </td>
                        <td>
                            <span>退款金额</span>
                        </td>
                        <td>
                            <span>结算金额</span>
                        </td>
                        <td>
                            <span>付款状态</span>
                        </td>
                        <td>
                            <span>操作</span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="10">
                            <input type="checkbox">
                            <a href="#">结算ID:1959400773765672</a>
                            <em>达人ID:400773</em>
                            <em>结算日期:2017-06-18 22:15:34</em>
                            <em>付款日期:-</em>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>番茄来了</span>
                            <span>15487412365</span>
                        </td>
                        <td>
                            <span>银联</span>
                        </td>
                        <td>
                            <span>18635228384</span>
                        </td>
                        <td>
                            <span>招商银行上地支行</span>
                        </td>
                        <td>
                            <span>2</span>
                        </td>
                        <td>
                            500.00
                        </td>
                        <td>
                            400.00
                        </td>
                        <td>
                            100.00
                        </td>
                        <td>
                            400.00
                        </td>
                        <td>
                            400.00
                        </td>
                        <td>
                            结算待付款
                        </td>
                        <td>
                            <button style="color:#3c8dbc" data-toggle="modal" data-target="#myModal2">付款确认</button>
                            <a href="#" style="margin-right:10px;" target="_blank">操作流水</a>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="10" style="text-align: left;">
                            <input type="checkbox" style="margin-left:27px;">
                            <a href="#">结算ID:1959400773765672</a>
                            <em>房东ID:400773</em>
                            <em>结算日期:2017-06-18 22:15:34</em>
                            <em>付款日期:-</em>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>番茄来了</span>
                            <span>15487412365</span>
                        </td>
                        <td>
                            <span>银联</span>
                        </td>
                        <td>
                            <span>18635228384</span>
                        </td>
                        <td>
                            <span>招商银行上地支行</span>
                        </td>
                        <td>
                            500.00
                        </td>
                        <td>
                            400.00
                        </td>
                        <td>
                            100.00
                        </td>
                        <td>
                            400.00
                        </td>
                        <td>
                            400.00
                        </td>
                        <td>
                            <span style="color:red;">付款中</span>
                        </td>
                        <td>
                            <button style="color:#3c8dbc" data-toggle="modal" data-target="#myModal2">付款详情</button>
                            <a href="#" style="margin-right:10px;" target="_blank">操作流水</a>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="10" style="text-align: left;">
                            <input type="checkbox" style="margin-left:27px;">
                            <a href="#">结算ID:1959400773765672</a>
                            <em>房东ID:400773</em>
                            <em>结算日期:2017-06-18 22:15:34</em>
                            <em>付款日期:-</em>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>番茄来了</span>
                            <span>15487412365</span>
                        </td>
                        <td>
                            <span>银联</span>
                        </td>
                        <td>
                            <span>18635228384</span>
                        </td>
                        <td>
                            <span>招商银行上地支行</span>
                        </td>
                        <td>
                            500.00
                        </td>
                        <td>
                            400.00
                        </td>
                        <td>
                            100.00
                        </td>
                        <td>
                            400.00
                        </td>
                        <td>
                            400.00
                        </td>
                        <td>
                            <span style="color:red;">付款失败</span>
                        </td>
                        <td>
                            <button style="color:#3c8dbc" data-toggle="modal" data-target="#myModal2">再次付款</button>
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