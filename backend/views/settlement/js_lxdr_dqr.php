<!DOCTYPE html>
<html lang="en">
<head>
    <title>财务管理-结算处理-旅行结算-达人待付款-结算待确认</title>
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
        margin-left: 33px;
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

<!--modal2 通过 start-->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel2">结算审核:</h4>
            </div>
            <div class="modal-body">
                <p>审核通过后，等待财务确认，您确定取消吗？</p>
            </div>
            <div class="modal-footer footer-btn">
                <button type="button" class="btn btn-primary">确定</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
            </div>
        </div>
    </div>
</div>
<!--end-->

<!--modal2 拒绝 start-->
<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel3">拒绝理由:</h4>
            </div>
            <div class="modal-body">
                <textarea placeholder="金额有误，需要重新结算"></textarea>
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
                        <span>结算日期</span>
                        <input id="date_start" name="" value="" class="Wdate" type="text" onfocus="var date_end=$dp.$('date_end');WdatePicker({readOnly:true,minDate:'%y-%M-{%d}',onpicked:function(){date_end.focus()}})" />至
                        <input id="date_end" class="Wdate" name="" value="" type="text" onFocus="WdatePicker({minDate:'#F{$dp.$D(\'date_start\')}',readOnly:true,maxDate:'#F{$dp.$D(\'date_start\',{M:+6})}'})" />
                    </li>
                    <li>
                        <span>达人ID:</span>
                        <input type="text">
                    </li>
                </ul>
                <div style="clear:both;"></div>
                <ul class="second_ul">
                    <li>
                        <span>达人姓名：</span>
                        <input type="text">
                    </li>
                    <li>
                        <span>达人电话：</span>
                        <input type="text">
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
                            <em>结算ID:1959400773765672</em>
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
                            <span>5</span>
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
                            结算待审核
                        </td>
                        <td>
                            <button style="color:#3c8dbc;" data-toggle="modal" data-target="#myModal2">通过</button>
                            <button style="color:#3c8dbc;" data-toggle="modal" data-target="#myModal3">拒绝</button>
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