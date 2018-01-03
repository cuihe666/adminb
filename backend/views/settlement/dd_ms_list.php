<?php
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = '民宿订单列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>订单管理-民宿-订单列表</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <meta content="telephone=no" name="format-detection" />
    <link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/webcaiwu/css/settlement.css?v1">
    <link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/webcaiwu/css/jquery.pagination.css">
    <script src="<?= Yii::$app->request->baseUrl ?>/webcaiwu/js/jquery.min.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/My97DatePicker/WdatePicker.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/webcaiwu/js/sq.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/layer/layer.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/webcaiwu/js/method/base.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/webcaiwu/js/dd_ms_list.js?v1"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/webcaiwu/js/jquery.pagination.min.js"></script>
</head>
<style>
    .sxh_tk-cx .table_base{
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
    .form_table tr:nth-child(2) td input{
        margin-left:0;
    }
    .first_ul select{min-width: 100px;}
</style>

<body>
<input type="hidden" value="<?php echo Yii::$app->user->id;?>" id="opeRate">
<!--确认订单弹框-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                <textarea name="" cols="30" rows="10" placeholder="驳回原因" id="rejectRemark"></textarea>
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
<!--end-->
<!--开始-->
<div class="sxh_main">
    <div class="shade_wrap" style="position: absolute;left: 0;top: 0;display: none;z-index:20;background: rgba(250,251,250,0.6);width: 100%;height: 99%;text-align: center;padding-top: 15%;box-sizing: border-box">
        <img src="<?= Yii::$app->request->baseUrl ?>/webcaiwu/img/loading.gif"/>
    </div>
    <section class="content">
        <div class="sxh_tk-cx">
            <div class="daochu">
                <h4 style="display:inline-block;margin-right:15px;">当前位置:首页 > 民宿订单 > 订单列表</h4>
                <hr style="border-top:2px solid blue;margin-top:10px;">
            </div>
            <div class="form_table table_base sxh_content" style="padding-bottom:20px;">
                <div class="top" style="padding-top:10px;">
                    <span class="cx" style="background:url(<?= Yii::$app->request->baseUrl ?>/webcaiwu/img/arrow_bot.png) left center no-repeat;padding-left:20px;display:inline-block;background-size:15px">查询条件</span>
                    <i></i>
                    <span class="sq" style="padding-left:20px;display:inline-block;background-size:20px">收起</span>
                </div>
                <div class="search-content">
                    <table class="table first_ul">
                    <tr>
                        <td style="width:120px;">按订单号查询</td>
                        <td style="width:450px;">
                            <input type="text" placeholder="订单号" value="" id="orderNum">
                        </td>
                        <td style="width:130px;">按预订人姓名查询</td>
                        <td>
                            <input type="text" placeholder="预订人姓名" value="" id="ydName">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            按日期查询
                        </td>
                        <td>
                            <select id="selDate">
                                <option value="">不限</option>
                                <option value="1">下单日期</option>
                                <option value="2">入住日期</option>
                                <option value="3">离店日期</option>
                            </select>
                            <input id="date_start" placeholder="请选择开始日期" name="" value="" class="Wdate" type="text" onfocus="var date_end=$dp.$('date_end');WdatePicker({readOnly:true,onpicked:function(){date_end.focus()}})" />至
                            <input id="date_end"  placeholder="请选择结束日期" class="Wdate" name="" value="" type="text" onFocus="WdatePicker({minDate:'#F{$dp.$D(\'date_start\',{d:+1})}',readOnly:true})" />

                        </td>
                        <td>
                            按预订人电话查询
                        </td>
                        <td>
                            <input type="text" placeholder="预订人电话" value="" id="ydMobile">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            按地区查询
                        </td>
                        <td id="citybox">
                            <select id="country">
                                <option value="">国家</option>
                            </select>
                            <select id="province">
                                <option value="">省</option>
                            </select>
                            <select id="city">
                                <option value="">市</option>
                            </select>
                            <select id="area">
                                <option value="">区</option>
                            </select>

                        </td>
                        <td>
                            按房东姓名查询
                        </td>
                        <td>
                            <input type="text" placeholder="房东姓名" value="" id="landlordName">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            按房源id查询
                        </td>
                        <td>
                            <input type="text" placeholder="房源id" value="" id="houseId">
                        </td>
                        <td>
                            按房东电话查询
                        </td>
                        <td>
                            <input type="text" placeholder="房东电话" value="" id="landlordMobile">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            按房源名称查询
                        </td>
                        <td>
                            <input type="text" placeholder="房源名称" value="" id="houseName">
                        </td>
                        <td>
                            按订单状态查询
                        </td>
                        <td>
                            <select id="orderStatus">
                                <option value="">全部订单状态</option>
                                <option value="1">待确认</option>
                                <option value="11">待付款</option>
                                <option value="12">已拒绝</option>
                                <option value="41">房客支付超时</option>
                                <option value="42">房东确认超时</option>
                                <option value="3">用户已取消</option>
                                <option value="4">客服已取消</option>
                                <option value="21">待入住</option>
                                <option value="31">已入住</option>
                                <option value="32">已完成</option>
                                <option value="34">已结算</option>
                                <option value="51">退款申请中</option>
                                <option value="52">退款待确认</option>
                                <option value="57">待退款</option>
                                <option value="56">退款未通过</option>
                                <option value="58">财务拒绝</option>
                                <option value="54">退款中</option>
                                <option value="55">退款完成</option>
                                <option value="59">拒绝退款</option>
                                <option value="61">结算待审核</option>
                                <option value="62">结算未通过</option>
                                <option value="63">结算待确认</option>
                                <option value="64">结算待付款</option>
                                <option value="65">付款失败</option>
                                <option value="66">结算拒绝</option>
                                <option value="67">结算异常订单</option>
                                <option value="68">已打款</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            按房源来源
                        </td>
                        <td>
                            <select id="houseSource">
                                <option value="">全部</option>
                                <option value="0">棠果</option>
                                <option value="1">番茄来了</option>
                                <option value="2">同程</option>
                            </select>
                        </td>
<!--                        因现在没有区分来源所以现在先隐藏掉 接口传空  2017年11月15日15:30:30 琳涛-->
                        <!--                        <td>-->
<!--                            按订单来源-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            <select id="orderSource">-->
<!--                                <option value="">全部</option>-->
<!--                                <option value="1">棠果APP</option>-->
<!--                                <option value="2">H5</option>-->
<!--                            </select>-->
<!--                        </td>-->
                    </tr>
                    <tr>
                        <td>
                            <button type="button" class="btn btn-primary" id="pullExcel">导出列表</button>
                        </td>
                        <td></td>
                        <td>
                            <button class="btn btn-primary" id="search">搜索</button>
                            <button class="btn btn-default" id="clear">清空</button>
                        </td>
                        <td></td>
                    </tr>
                </table>
                </div>
            </div>
                <section class="content-header h_wrap">
                    <ul id="detail_ul">
                        <li class="current" id="detailAll" status="">
                                全部订单
                        </li>
<!--                        <li id="detailDtksh" status=52 tabmodel="1">-->
                        <li id="detailDtksh" tabmodel="1">
                                退款待审核
                        </li>
                        <li id="detailDfk" status=11>
                                待付款
                        </li>
                        <li id="detailDqr" status=1>
                                待确认
                        </li>
                        <li id="detailDrz" status=21>
                                待入住
                        </li>
                        <li id="detailYrz" status=31>
                                已入住
                        </li>
                        <li id="detailYwc" status=32>
                                已完成
                        </li>
                        <li id="detailYjs"  tabmodel="2">
<!--                        <li id="detailYjs" status=34  tabmodel="1" >-->
                                已结算
                        </li>
                    </ul>
                    <hr>
                </section>
            <div class="col-sm-12">
                <div class="form_table table-responsive kv-grid-container" id="ddListData" data=0 style="width: 100%;">
                    <div id="load">数据加载中...</div>
                </div>
            </div>
        </div>
    </section>
            <div class="paganition">
                <div class="left">
                    <span>每页显示条数:</span>
                    <select id="pageSize">
                        <option value="15">15</option>
                        <option value="30">30</option>
                        <option value="50">50</option>
                    </select>
                </div>
                <div class="right">
                       共 <span id="totalNum">0</span> 页
                        <div class="pagination" id="pagination"></div>
                    </ul>
                    <input type="hidden" id="pageNum" value="1">
                    <input type="hidden" id="pageTotal" value="0">
                </div>
            </div>
            <div style="clear:both;"></div>

</div>
<!--结束-->
</body>
</html>