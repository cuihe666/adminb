<?php
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = '订单详情';
$this->params['breadcrumbs'][] = $this->title;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>订单管理-民宿-结算异常订单</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <meta content="telephone=no" name="format-detection" />
    <link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/webcaiwu/css/cobber.css">
    <link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/webcaiwu/css/settlement.css">
    <script src="<?= Yii::$app->request->baseUrl ?>/webcaiwu/js/jquery.min.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/My97DatePicker/WdatePicker.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/webcaiwu/js/sq.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/layer/layer.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/webcaiwu/js/method/base.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/webcaiwu/js/dd_ms_detail.js"></script>
</head>
<style>
    .form-group{
        margin-left:20px;
        margin-top:20px;
    }
</style>
<body>
<input type="hidden" value="" id="fdys">
<input type="hidden" value="<?php echo Yii::$app->user->id;?>" id="opeRate">
<!--确认订单弹框-->
<div class="modal fade" id="myModalsure" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">确认订单</h4>
            </div>
            <div class="modal-body">
                <p>确认后房客可支付预定房间，确定继续吗？</p>
            </div>
            <div class="modal-footer footer-btn">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary" id="sure_sure" >确定</button>
            </div>
        </div>
    </div>
</div>
<!--取消订单弹框-->
<div class="modal fade" id="myModal_cancel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">取消订单</h4>
            </div>
            <div class="modal-body">
                <p>取消后房客无法正常预定房间，确定继续吗？</p>
                <input type="text" placeholder="备注非必填" id="cancelRemark">
            </div>
            <div class="modal-footer footer-btn">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary" id="cancel_sure" >确定</button>
            </div>
        </div>
    </div>
</div>
<!--审核通过 弹框-->
<div class="modal fade" id="myModal_pass" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">审核通过</h4>
            </div>
            <div class="modal-body">
                <p>确定退款给该用户吗？</p>
            </div>
            <div class="modal-footer footer-btn">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary" id="pass_sure" >确定</button>
            </div>
        </div>
    </div>
</div>
<!--驳回退款-->
<div class="modal fade" id="myModal_reject" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">驳回退款</h4>
            </div>
            <div class="modal-body">
                <textarea name="" cols="30" rows="10"placeholder="驳回原因" id="rejectRemark"></textarea>
            </div>
            <div class="modal-footer footer-btn">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary" id="reject_sure" >确定</button>
            </div>
        </div>
    </div>
</div>
<!--确认未通过-->
<div class="modal fade" id="myModal_nopass" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">确认未通过</h4>
            </div>
            <div class="modal-body">
                <p>确认未通过后，将不可以再申请退款，您确定继续吗？</p>
                <input type="text" placeholder="备注非必填" id="nopassRemark">
            </div>
            <div class="modal-footer footer-btn">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary" id="nopass_sure" >确定</button>
            </div>
        </div>
    </div>
</div>
<!--申请退款-->
<div class="modal fade" id="myModal_refund" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">申请退款</h4>
            </div>
            <div class="modal-body">
                <label for=""><span>应退金额：</span><span id="refundAmount"></span></label>
                <label for=""><span>实退金额：</span><span>¥<input type="text" id="jlstmoney" placeholder="" onchange="if(!/^[0-9]+(.[0-9]{1,2})?$/.test(this.value)){alert('只能输入数字和小数');this.value='';}" ></span><input type="radio" name="butie" value="2" checked ><span>商家补贴</span><input type="radio" name="butie" value="1"><span>平台补贴</span></label>
                <div><span>备注信息：</span> <textarea name="" cols="30" rows="10" placeholder="备注" id="refundRemark"></textarea></div>
            </div>
            <div class="modal-footer footer-btn">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary" id="refund_sure" >确定</button>
            </div>
        </div>
    </div>
</div>
<!--修改-异常订单-->
<div class="modal fade" id="myModaledit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">修改订单</h4>
            </div>
            <div class="modal-body" id="mymodel_editbox"></div>
            <div class="modal-footer footer-btn">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary" id="editSure">确定</button>
            </div>
        </div>
    </div>
</div>
<!--end-->
<!--付款详情-->
<div class="modal fade" id="myModalPay" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<!--    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel2">付款详情</h4>
            </div>
            <div class="modal-body">
                <div class="row" style="padding:0 15px;font-size: 16px;">
                    <div class="col-md-3">
                        付款金额：
                    </div>
                    <div class="col-md-6">
                        300.00
                    </div>
                </div>
                <div class="row" style="margin-top: 15px;padding:0 15px;font-size: 16px;">
                    <div class="col-md-3">
                        打款方式：
                    </div>
                    <div class="col-md-6">
                        支付宝
                    </div>
                </div>
                <div class="row" style="margin-top: 15px;padding:0 15px;font-size: 16px;">
                    <div class="col-md-3">
                        操作人：
                    </div>
                    <div class="col-md-6">
                       张灿
                    </div>
                </div>
                <div class="row" style="margin-top: 15px;padding:0 15px;font-size: 16px;">
                    <div class="col-md-3">
                        打款时间：
                    </div>
                    <div class="col-md-6">
                        12:00以前
                    </div>
                </div>
                <div class="row" style="margin-top:15px;padding:0 15px;font-size: 16px;">
                    <div class="col-md-3">
                        打款订单号：
                    </div>
                    <div class="col-md-6">
                        1231233133
                    </div>
                </div>
            </div>
         </div>
    </div>-->
</div>
<!--房源详情-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <!--<div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-1">
                        <img src="<?/*= Yii::$app->request->baseUrl */?>/webcaiwu/img/house.png" alt="" style="width:40px;">
                    </div>
                    <div class="col-md-6">
                        <b style="font-size: 14px;font-weight: bold;display: block;">整租</b>
                        <b style="color:#999">20平米,1室0厅</b>
                    </div>
                </div>
                <div class="row" style="margin-top: 15px;">
                    <div class="col-md-1">
                        <img src="<?/*= Yii::$app->request->baseUrl */?>/webcaiwu/img/partment.png" alt="" style="width:40px;">
                    </div>
                    <div class="col-md-6">
                        <b style="font-size: 14px;font-weight: bold;display: block;">精品公寓</b>
                        <b style="color:#999">独享整套房屋</b>
                    </div>
                </div>
                <div class="row" style="margin-top: 15px;">
                    <div class="col-md-1">
                        <img src="<?/*= Yii::$app->request->baseUrl */?>/webcaiwu/img/person.png" alt="" style="width:40px;">
                    </div>
                    <div class="col-md-6">
                        <b style="font-size: 14px;font-weight: bold;display: block;">宜住1人</b>
                        <b style="color:#999">限男,接待外宾,1晚起住</b>
                    </div>
                </div>
                <div class="row" style="margin-top: 15px;">
                    <div class="col-md-1">
                        <img src="<?/*= Yii::$app->request->baseUrl */?>/webcaiwu/img/bed.png" alt="" style="width:40px;">
                    </div>
                    <div class="col-md-6">
                        <b style="font-size: 14px;font-weight: bold;display: block;">18张床</b>
                        <b style="color:#999">19米*19米,18张</b>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <!-- <button type="button" class="btn btn-primary">提交更改</button> -->
    <!--  </div>
 </div>
</div>-->
</div>
<!--入住须知-->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<!--    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel2">入住须知</h4>
            </div>
            <div class="modal-body">
                <div class="row" style="padding:0 15px;font-size: 16px;">
                    <div class="col-md-3">
                        押金
                    </div>
                    <div class="col-md-6">
                        线下收取500元押金
                    </div>
                </div>
                <div class="row" style="margin-top: 15px;padding:0 15px;font-size: 16px;">
                    <div class="col-md-3">
                        最多入住
                    </div>
                    <div class="col-md-6">
                        2人
                    </div>
                </div>
                <div class="row" style="margin-top: 15px;padding:0 15px;font-size: 16px;">
                    <div class="col-md-3">
                        入住时间
                    </div>
                    <div class="col-md-6">
                        14:00以后
                    </div>
                </div>
                <div class="row" style="margin-top: 15px;padding:0 15px;font-size: 16px;">
                    <div class="col-md-3">
                        退房时间
                    </div>
                    <div class="col-md-6">
                        12:00以前
                    </div>
                </div>
                <div class="row" style="margin-top: 15px;padding:0 15px;font-size: 16px;">
                    <span>房东需求</span>
                </div>
                <div class="row" style="margin-top:15px;padding:0 15px;font-size: 16px;">
                    <div class="col-md-3">
                        其他须知
                    </div>
                    <div class="col-md-6">
                        保护屋内设施
                    </div>
                </div>
                <div class="row" style="padding:0 15px;margin-top: 10">
                    <p>
                        住房押金:</br>
                        到店后需要支付¥500.00住房押金，离店后无设施损坏等问题押金全额退回
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <!-- <button type="button" class="btn btn-primary">提交更改</button> -->
    <!-- </div>
 </div>
</div>-->
</div>
<!--房价明细-->
<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<!--    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel3">房价明细</h4>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-condensed">
                        <tbody>
                        <tr>
                            <td style="background-color: #f4f4f4">
                                <span>03-16</span>
                                <b>(星期四)</b>
                            </td>
                            <td style="background-color: #f4f4f4">
                                <span>03-17</span>
                                <b>(星期五)</b>
                            </td>
                            <td style="background-color: #f4f4f4">
                                <span>03-18</span>
                                <b>(星期六)</b>
                            </td>
                            <td style="background-color: #f4f4f4">
                                <span>03-19</span>
                                <b>(星期日)</b>
                            </td>
                            <td style="background-color: #f4f4f4">
                                <span>03-20</span>
                                <b>(星期一)</b>
                            </td>
                            <td style="background-color: #f4f4f4">
                                <span>03-21</span>
                                <b>(星期二)</b>
                            </td>
                            <td style="background-color: #f4f4f4">
                                <span>03-22</span>
                                <b>(星期三)</b>
                            </td>
                            <td style="background-color: #f4f4f4">
                                <span>03-23</span>
                                <b>(星期四)</b>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                ￥208
                            </td>
                            <td>
                                ￥208
                            </td>
                            <td>
                                ￥208
                            </td>
                            <td>
                                ￥208
                            </td>
                            <td>
                                ￥208
                            </td>
                            <td>
                                ￥208
                            </td>
                            <td>
                                ￥208
                            </td>
                            <td>
                                ￥208
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>-->
</div>
<!--开始-->
<div class="shade_wrap" style="position: absolute;left: 0;top: 0;display: none;z-index:20;background: rgba(250,251,250,0.6);width: 100%;height: 99%;text-align: center;padding-top: 15%;box-sizing: border-box">
    <img src="<?= Yii::$app->request->baseUrl ?>/webcaiwu/img/loading.gif"/>
</div>
<div>
    <h4>当前位置:>首页>民宿订单>订单详情</h4>
    <hr style="border-top:2px solid blue;margin-top:10px;">
</div>
<div class="form-group" id="order_message">
    <div class="row">
        <h4 style="font-weight: bold;border-left:3px solid #3c8dbc;height:30px;line-height: 30px;padding-left: 5px;">订单信息</h4>
    </div>
    <div class="table-responsive" id="orderData">
        <div class="load">数据加载中...</div>
        <!--<table class="table table-condensed" style="margin: 10px 0;">
            <tbody>
            <tr>
                <td>订单ID：</td>
                <td>
                    <span>213</span>
                </td>
                <td>订单号：</td>
                <td>
                    <span style="color:#3c8dbc">455412145</span>
                </td>
            </tr>
            <tr>
                <td>实付金额：</td>
                <td>￥1634.00</td>
                <td>下单时间：</td>
                <td>2017-05-14 10:00:00</td>
            </tr>
            <tr>
                <td>付款时间：</td>
                <td>2017-05-14 10:00:00</td>
                <td>订单状态：</td>
                <td>
                    <span style="color:red">已支付</span>
                </td>
            </tr>
            <tr>
                <td>支付方式：</td>
                <td>
                    支付宝
                </td>
                <td>结算状态：</td>
                <td>未结算</td>
            </tr>
            <tr>
                <td>房源来源：</td>
                <td>棠果</td>
                <td>订单来源：</td>
                <td>棠果APP</td>
            </tr>
            </tbody>
        </table>-->
    </div>
</div>
<div class="form-group" id="order_message_part">
    <div class="row">
        <h4 style="font-weight: bold;border-left:3px solid #3c8dbc;height:30px;line-height: 30px;padding-left: 5px;">入住信息</h4>
    </div>
    <div class="table-responsive" id="orderHouseData">
        <div class="load">数据加载中...</div>
        <!--        <table class="table table-condensed" style="margin: 10px 0;">
                    <tbody>
                    <tr>
                        <td>房屋名称</td>
                        <td>
                            <span style="color:#3c8dbc">丽江阅古楼观景客栈</span>
                            <b style="display: inline-block;background-color: #3c8dbc;border-radius: 5px;padding:3px 5px;float: right;cursor:pointer" data-toggle="modal" data-target="#myModal">!</b>
                        </td>
                        <td>房屋地址</td>
                        <td>
                            阅古楼（新华街翠文段34、35号），雁江院（新华街黄山上段35、36号）
                        </td>
                    </tr>
                    <tr>
                        <td>入离日期</td>
                        <td>2016年12月8日  -  2016年12月9日     共8晚  </td>
                        <td>间数</td>
                        <td>
                            1间
                        </td>
                    </tr>
                    <tr>
                        <td>实际入住日期</td>
                        <td>（默认入住时间）</td>
                        <td>实际离店日期</td>
                        <td>
                            （默认入住离店时间，如果房客提前退房，则显示离店时间）
                        </td>
                    </tr>
                    <tr>
                        <td>住房押金</td>
                        <td>
                            <span style="color:orange">￥500.00</span>
                            <span>(线下支付)</span>
                            <b style="display: inline-block;background-color: #3c8dbc;border-radius: 5px;padding:3px 5px;float: right;">!</b>
                        </td>
                        <td>房东</td>
                        <td>
                            张三/13465433456
                        </td>
                    </tr>
                    <tr>
                        <td>入住房客</td>
                        <td>
                            <span>张三 / 340239542233543214 </span>
                            <b style="display: inline-block;background-color: #3c8dbc;border-radius: 5px;padding:3px 5px;float: right;cursor:pointer" data-toggle="modal" data-target="#myModal2" >入住须知</b>
                            <span style="display: block;">张三 / 340239542233543214 </span>
                        </td>
                        <td>房费</td>
                        <td>
                            <b style="color:orange;font-weight: bold;cursor: pointer" data-toggle="modal" data-target="#myModal3">￥1664.00</b>
                            <span>（以下是每日每间的房价）</span>
                        </td>
                    </tr>
                    </tbody>
                </table>
        -->    </div>
</div>
<div class="form-group" id="order_message_part_two">
    <div class="row">
        <h4 style="font-weight: bold;border-left:3px solid #3c8dbc;height:30px;line-height: 30px;padding-left: 5px;">用户信息</h4>
    </div>
    <div class="table-responsive" id="userInfo">
        <div class="load">数据加载中...</div>
        <!--<table class="table table-condensed" style="margin: 10px 0;">
            <tbody>
            <tr>
                <td>用户</td>
                <td>
                    414454
                </td>
                <td>用户账号</td>
                <td>
                    13483948234
                </td>
            </tr>
            <tr>
                <td>用户昵称</td>
                <td>棠果</td>
                <td>联系人姓名</td>
                <td>张三</td>
            </tr>
            <tr>
                <td>联系人手机号</td>
                <td>156453151285</td>
                <td>联系人邮箱</td>
                <td>123@126.com</td>
            </tr>
            </tbody>
        </table>-->
    </div>
</div>
<div class="form-group" style="margin-bottom:50px;" id="order_message_part_three">
    <div class="row">
        <h4 style="font-weight: bold;border-left:3px solid #3c8dbc;height:30px;line-height: 30px;padding-left: 5px;">费用明细</h4>
    </div>
    <div class="table-responsive" id="priceDetail">
        <div class="load">数据加载中...</div>
        <!--<table class="table table-condensed" style="margin: 10px 0;">
            <tbody>
            <tr>
                <td>房费：</td>
                <td>
                    <span style="color:orange" >￥1664 .00</span>
                </td>
                <td>实付金额：</td>
                <td>
                    <span style="color:orange">￥0</span>
                </td>
            </tr>
            <tr>
                <td>清洁费：</td>
                <td>
                    <span style="color:orange">￥0</span>
                </td>
                <td>超员费：</td>
                <td>
                    <span style="color:orange">￥50*5人</span>
                    <span style="color:orange">共￥250</span>
                </td>
            </tr>
            <tr>
                <td>已享优惠：</td>
                <td>
                    <span style="color:green;display: block">￥-20.00(3月满200减20元券)</span>
                    <span style="color:green">￥-10.00(APP首单支付立减10元)</span>
                </td>
                <td>申请退款金额：</td>
                <td>
                    <span style="color:orange;font-weight: bold;">￥1634.00</span>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                </td>
                <td>实际退款金额：</td>
                <td>
                    <input type="text" value="1634.00" style="width:100px;">元
                    <label for="" style="margin-left:10px;">
                        <input type="radio">
                        <span>商家补贴</span>
                    </label>
                    <label for="">
                        <input type="radio">
                        <span>平台补贴</span>
                    </label>
                </td>
            </tr>
            </tbody>
        </table>-->
    </div>
</div>
<div class="row" id="btn_box"></div>
<div class="form-group" style="margin-bottom:50px;" id="order_message_part_five">
    <div class="row">
        <h4 style="font-weight: bold;border-left:3px solid #3c8dbc;height:30px;line-height: 30px;padding-left: 5px;">操作日志</h4>
    </div>
    <div class="table-responsive" id="operateLog">
        <div class="load">数据加载中...</div>
    </div>
</div>
<!--结束-->
</body>
</html>