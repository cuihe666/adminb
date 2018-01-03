<!DOCTYPE html>
<html lang="en">
<head>
    <title>订单管理-旅行-结算异常订单-待处理</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <meta content="telephone=no" name="format-detection" />
    <link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/webcaiwu/css/settlement.css">
    <script src="<?= Yii::$app->request->baseUrl ?>/webcaiwu/js/jquery.min.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/My97DatePicker/WdatePicker.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/webcaiwu/js/sq.js"></script>


</head>
<style>
    .sxh_tk-cx .table_base{
        width:60%;
        background-color:#e5e5e5;
    }
    .table_base td{
        border:none!important;
        text-align: center!important;
    }
    .table_base td:nth-child(1){
        text-align: left!important;
    }
    .form_table td span{
        display:inline-block;
    }
    .sxh_tk-cx .table_base{
        width:inherit;
    }
    .table_base td{
        text-align: left!important;
    }
    .sxh_tk-cx .table_base{
        width:70%;
    }
    .form_table tr:nth-child(2) td input{
        margin-left:0;
    }
</style>

<body>
<!--modal 确认退款 start-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">确认退款:</h4>
            </div>
            <div class="modal-body">
                <p>是否确认退款？</p>
            </div>
            <div class="modal-footer footer-btn">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary">确定</button>
            </div>
        </div>
    </div>
</div>
<!--end-->

<!--modal 退款驳回 start-->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel2">退款驳回:</h4>
            </div>
            <div class="modal-body">
                <textarea placeholder="驳回原因" style="width:65%;resize:none"></textarea>
            </div>
            <div class="modal-footer footer-btn">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary">确定</button>
            </div>
        </div>
    </div>
</div>
<!--end-->

<!--modal 商家已退款 start-->
<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel3">商家已退款:</h4>
            </div>
            <div class="modal-body">
                <p>确认之后订单状态为已退款，请确认商家已成功转账到用户！</p>
                <textarea placeholder="备注" style="width:65%;resize:none"></textarea>
            </div>
            <div class="modal-footer footer-btn">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary">确定</button>
            </div>
        </div>
    </div>
</div>
<!--end-->

<!--开始-->
<div class="sxh_main">
    <section class="content">
        <div class="sxh_tk-cx">
            <div class="daochu">
                <h4 style="display:inline-block;margin-right:15px;">当前位置:首页 > 旅行订单 > 订单列表</h4>
                <hr style="border-top:2px solid blue;margin-top:10px;">
            </div>
            <div class="form_table table_base sxh_content" style="padding-bottom:20px;">
                <div class="top" style="padding-top:10px;">
                    <span class="cx" style="background:url(<?= Yii::$app->request->baseUrl ?>/webcaiwu/img/arrow_bot.png) left center no-repeat;padding-left:20px;display:inline-block;background-size:15px">查询条件</span>
                    <i></i>
                    <span class="sq" style="background:url(<?= Yii::$app->request->baseUrl ?>/webcaiwu/img/shouqi.png) left center no-repeat;padding-left:20px;display:inline-block;background-size:20px">收起</span>
                </div>

                <table class="table first_ul">
                    <tr>
                        <td style="width:120px;">按订单号查询</td>
                        <td style="width:450px;">
                            <input type="text" placeholder="订单号">
                        </td>
                        <td style="width:130px;">按用户名查询</td>
                        <td>
                            <input type="text" placeholder="用户名">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            按日期查询
                        </td>
                        <td>
                            <select>
                                <option value="下单日期">下单日期</option>
                                <option value="体验日期">体验日期</option>
                                <option value="不限">不限</option>
                            </select>
                            <input id="date_start" name="" value="" placeholder="请选择开始日期" class="Wdate" type="text" onfocus="var date_end=$dp.$('date_end');WdatePicker({readOnly:true,minDate:'%y-%M-{%d}',onpicked:function(){date_end.focus()}})" />至
                            <input id="date_end" class="Wdate" name="" value="" type="text" placeholder="请选择结束日期" onFocus="WdatePicker({minDate:'#F{$dp.$D(\'date_start\')}',readOnly:true,maxDate:'#F{$dp.$D(\'date_start\',{M:+6})}'})" />

                        </td>
                        <td>
                            按电话查询
                        </td>
                        <td>
                            <input type="text" placeholder="电话">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            按地区查询
                        </td>
                        <td>
                            <select>
                                <option value="国家">国家</option>
                            </select>
                            <select>
                                <option value="省">省</option>
                            </select>
                            <select>
                                <option value="市">市</option>
                            </select>
                            <select>
                                <option value="区">区</option>
                            </select>

                        </td>
                        <td>
                            按商品名称查询
                        </td>
                        <td>
                            <input type="text" placeholder="商品名称">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            按订单状态查询
                        </td>
                        <td>
                            <select>
                                <option value="全部订单状态">全部订单状态</option>
                                <option value="待确认">待确认</option>
                            </select>
                        </td>
                        <td>
                            按发布账号查询
                        </td>
                        <td>
                            <input type="text" placeholder="发布账号">
                        </td>

                    </tr>
                    <tr>
                        <td>
                            按支付状态
                        </td>
                        <td>
                            <select>
                                <option value="全部">全部</option>
                                <option value="已支付">已支付</option>
                                <option value="未支付">未支付</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                        </td>
                        <td></td>
                        <td>
                            <button class="btn btn-primary">搜索</button>
                            <button>清空</button>
                        </td>
                        <td></td>
                    </tr>
                </table>
            </div>
            <section class="content-header h_wrap">
                <p style="margin-bottom:20px;">
                    <button type="button" class="btn btn-default">导出列表</button>
                </p>
                <ul>
                    <li>
                        <a href="<?php echo \yii\helpers\Url::to(['settlement/dd_lx_abnormal_dcl']) ?>">
                            待处理 <i>（）</i>
                        </a>
                    </li>
                    <li class="current-top">
                        <a href="<?php echo \yii\helpers\Url::to(['settlement/dd_lx_abnormal_ycl']) ?>">
                            已处理 <i>（）</i>
                        </a>
                    </li>
                </ul>
                <hr>
            </section>

            <div class="form_table">
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <td>
                            <input type="checkbox">
                            <span style="display: inline-block">商品信息</span>
                        </td>
                        <td>城市</td>
                        <td>订单总价</td>
                        <td>实际支付金额</td>
                        <td>优惠券</td>
                        <td>体验日期</td>
                        <td>支付方式</td>
                        <td>订单状态</td>
                        <td>结算状态</td>
                        <td>操作</td>
                    </tr>
                    <tr>
                        <td colspan="10">
                            <em>订单ID:1959400773765672</em>
                            <em>订单编号:400773</em>
                            <em>下单日期:2017-06-18 22:15:34</em>
                            <em>支付日期:2017-06-18 22:15:34</em>
                            <em>用户名/用户电话:张三/15421315478</em>
                            <em>结算单号:15421315478</em>
                            <em>新结算单号:15421315478</em>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>安定门豪华大两居...</span>
                            <em style="display:block">房源ID:1542354</em>
                        </td>
                        <td>北京</td>
                        <td>155.00</td>
                        <td>155.00</td>
                        <td>155.00</td>
                        <td>2017-06-19至2017-06-30</td>
                        <td>微信</td>
                        <td>待退款</td>
                        <td>已结算未打款</td>
                        <td>
                            <a href="<?php echo \yii\helpers\Url::to(['settlement/dd_lx_detail']) ?>">查看</a>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="10">
                            <input type="checkbox">
                            <em>订单ID:1959400773765672</em>
                            <em>订单编号:400773</em>
                            <em>下单日期:2017-06-18 22:15:34</em>
                            <em>支付日期:2017-06-18 22:15:34</em>
                            <em>用户名/用户电话:张三/15421315478</em>
                            <em>结算单号:15421315478</em>
                            <em>新结算单号:15421315478</em>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>安定门豪华大两居...</span>
                            <em style="display:block">房源ID:1542354</em>
                        </td>
                        <td>北京</td>
                        <td>155.00</td>
                        <td>155.00</td>
                        <td>155.00</td>
                        <td>2017-06-19至2017-06-30</td>
                        <td>微信</td>
                        <td>待退款</td>
                        <td>已结算未打款</td>
                        <td>
                            <a href="<?php echo \yii\helpers\Url::to(['settlement/dd_lx_detail']) ?>">查看</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
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

<!--结束-->
</body>
</html>