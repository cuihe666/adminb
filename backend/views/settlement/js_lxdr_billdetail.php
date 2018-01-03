<!DOCTYPE html>
<html lang="en">
<head>
    <title>财务管理-结算处理-旅行结算-账单明细</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <meta content="telephone=no" name="format-detection" />
    <link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/webcaiwu/css/settlement.css">
    <script src="<?= Yii::$app->request->baseUrl ?>/webcaiwu/js/jquery.min.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/My97DatePicker/WdatePicker.js"></script>

</head>
<style>
    .form_table tr:not(:first-child) td input[type="checkbox"] {
        margin-left: 0px;
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
        margin-top:15px;
    }
    .guo_btn button{
        margin-right:15px;
    }
    .sxh_tk-cx .detail_state{
        margin-top:25px;
    }
    .detail_state h4{
        margin-bottom:15px;
    }
</style>

<body>
<!--modal 导出 start-->
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
<!--end-->

<!--modal 结算单拆分 start-->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel2">拆分确认:</h4>
            </div>
            <div class="modal-body">
                <p> <em>2</em>笔订单(结算金额 <span>500.00</span> )暂不进行结算，您确定吗？ </p>
                <textarea placeholder="备注"></textarea>
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
    <section class="content">
        <div class="sxh_tk-cx">
            <div class="daochu" style="margin-bottom:0;">
                <h4 style="display:inline-block;margin-right:15px;">对账单详情</h4>
                <button type="button" class="btn btn-default btn-lg active" data-toggle="modal" data-target="#myModal">导出</button>
                <hr style="border-top:1px dotted #999;margin-top:10px;">
            </div>
            <div class="guo_btn" style="margin-top:15px;">
                <button class="btn btn-primary">通过</button>
                <button class="btn btn-success">拒绝</button>
                <button class="btn" style="background-color:#9900cd;color:#fff;">操作流水</button>
                <button class="btn btn-warning">返回上一页</button>
            </div>
            <div class="detail_state">
                <h4>本期账单概况</h4>
                <table class="table table-bordered">
                    <tr>
                        <td>结算ID</td>
                        <td>结算总额</td>
                        <td>达人ID</td>
                        <td>达人姓名</td>
                        <td>收款方式</td>
                        <td>收款人姓名</td>
                        <td>收款账户</td>
                        <td>开户行</td>
                        <td>付款状态</td>
                    </tr>
                    <tr>
                        <td>20178384723</td>
                        <td>
                            <span style="color: red;">￥44</span>
                        </td>
                        <td>
                            <span>99970723</span>
                        </td>
                        <td>
                            <span>张三</span>
                        </td>
                        <td>
                            <span>银联</span>
                        </td>
                        <td>
                            <span>张三</span>
                        </td>
                        <td>
                            <span>6225477274628</span>
                        </td>
                        <td>
                            <span>交通银行上地支行</span>
                        </td>
                        <td>
                            <span>结算待确认</span>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="form_table">
                <h4>本期账单明细</h4>
                <button class="btn btn-default" style="margin-bottom:15px;margin-top:15px;" data-toggle="modal" data-target="#myModal2">结算单拆分</button>
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <td>
                            <span style="display: inline-block">预订人信息</span>
                        </td>
                        <td>
                            <span>商品信息</span>
                        </td>
                        <td>
                            <span>商品ID</span>
                        </td>
                        <td>
                            <span>支付时间</span>
                        </td>
                        <td>
                            <span>发团时间</span>
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
                            <span>佣金比例</span>
                        </td>
                        <td>
                            <span>订单状态</span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="10">
                            <input type="checkbox">
                            <a href="#">订单编号:1959400773765672</a>
                            <em>收款单号:400773</em>
                            <em>退款单号:2017-06-18 22:15:34</em>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>纳兹</span>
                            <span>15487412365</span>
                        </td>
                        <td>
                            <span>北京</span>
                            <span>如家连锁</span>
                        </td>
                        <td>
                            <span>18635</span>
                        </td>
                        <td>
                            <span>2017/02/01</span>
                            <em> 12:00:08</em>
                        </td>
                        <td>
                            2017/02/01
                        </td>
                        <td>
                            500
                        </td>
                        <td>
                            400
                        </td>
                        <td>
                            100（满减券）
                        </td>
                        <td>
                            0.00
                        </td>
                        <td>
                            450.00
                        </td>
                        <td>
                            90%
                        </td>
                        <td>
                            <span>已完成</span>
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