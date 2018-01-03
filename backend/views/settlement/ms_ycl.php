<?php
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = '退款单管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script type="text/javascript">
        var adminId = '<?=Yii::$app->user->getId();?>';
    </script>
    <title>财务管理-退款管理-民宿-已处理订单</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <meta content="telephone=no" name="format-detection" />
    <link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/webcaiwu/css/settlement.css">
    <link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/webcaiwu/css/jquery.pagination.css">
    <script src="<?= Yii::$app->request->baseUrl ?>/webcaiwu/js/jquery.min.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/My97DatePicker/WdatePicker.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/webcaiwu/js/sq.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/layer/layer.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/webcaiwu/js/method/base.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/webcaiwu/js/ms_ycl.js"></script>

    <script src="<?= Yii::$app->request->baseUrl ?>/webcaiwu/js/jquery.pagination.min.js"></script>
</head>
<style>
    .form_table tr:not(:first-child) td input[type="checkbox"] {
        margin-left: 62px;
    }
    a:hover {
        cursor: pointer;
    }
    .amount_cw:hover {
        cursor: pointer;
    }
    .modal {
        background: none;
    }
    #myModal6 td {
        padding: 5px;
    }
    #myModal2 .modal-dialog
    {
        height: 500px;
        position: absolute;
        top: 50%;
        left: 50%;
        margin: -250px 0 0 -300px;
    }
</style>
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
                <h4 class="modal-title" id="myModalLabel2">退款详情:</h4>
            </div>
            <div class="modal-body"  style="height: 400px; overflow: auto">
                <table class="table table-bordered js_pay">
                    <tr>
                        <td>
                            订单编号：
                        </td>
                        <td>

                        </td>
                        <td>
                            订单状态：
                        </td>
                        <td>

                        </td>
                    </tr>
                    <tr>
                        <td>
                            收款单号：
                        </td>
                        <td>

                        </td>
                        <td>

                        </td>
                        <td>

                        </td>
                    </tr>
                    <tr>
                        <td>
                            支付时间：
                        </td>
                        <td>

                        </td>
                        <td>
                            申请退款时间：
                        </td>
                        <td>

                        </td>
                    </tr>
                    <tr>
                        <td>
                            预订人姓名：
                        </td>
                        <td>

                        </td>
                        <td>
                            预订人手机号：
                        </td>
                        <td>

                        </td>
                    </tr>
                    <tr>
                        <td>
                            支付方式：
                        </td>
                        <td>

                        </td>
                        <td>
                           支付流水号：
                        </td>
                        <td>

                        </td>

                    </tr>
                    <tr>
                        <td>
                            入住/离店时间：
                        </td>
                        <td>
<!--                            <span>2017-06-19至2017-06-20</span>-->
<!--                            <em>共1晚</em>-->
                        </td>
                        <td>
                            退款规则：
                        </td>
                        <td>

                        </td>
                    </tr>
                    <tr>
                        <td>
                            订单金额：
                        </td>
                        <td style="color:orange" class="datePrice amount_cw" >

                        </td>
                        <td>
                            实收金额：
                        </td>
                        <td style="color:red;">

                        </td>
                    </tr>
                    <tr>
                        <td>
                            优惠金额：
                        </td>
                        <td>

                        </td>
                        <td>
                            清洁费：
                        </td>
                        <td>

                        </td>
                    </tr>
                    <tr>
                        <td>
                            超员费：
                        </td>
                        <td>

                        </td>
                        <td>
                            退款金额：
                        </td>
                        <td>

                        </td>
                    </tr>
                    <tr>
                        <td>
                            退款优惠券：
                        </td>
                        <td>

                        </td>
                        <td>
                            退款时间：
                        </td>
                        <td>

                        </td>
                    </tr>
                    <tr>
                        <td>退款人：</td>
                        <td></td>
                        <td>退款单号：</td>
                        <td></td>
                    </tr>
                </table>

            </div>
            <div class="modal-footer footer-btn md12_footer">

            </div>
        </div>
    </div>
</div>
<!--end-->

<!--退款详情 确认退款 modal start-->
<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header h-top">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel3">确认退款:</h4>
            </div>
            <div class="modal-body">审核通过后，等待财务退款，您确定吗？</div>
            <div class="modal-footer footer-btn">
                <button type="button" class="btn btn-primary">确定</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>
<!--end-->


<!--退款详情 退款 modal start-->
<div class="modal fade" id="myModa23" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header h-top">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel3">确认退款:</h4>
            </div>
            <div class="modal-body">审核通过后，退款将返回原支付账户，您确定吗？</div>
            <div class="modal-footer footer-btn">
                <button type="button" class="btn btn-primary cw_agree">确定</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>
<!--end-->

<!--退款详情 拒绝退款 modal start-->
<div class="modal fade" id="myModal4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel4">拒绝理由:</h4>
            </div>
            <div class="modal-body h-body">
                <span>退款金额计算错误</span>
            </div>
            <div class="modal-footer footer-btn">
                <button type="button" class="btn btn-primary">确定</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>
<!--end-->

<!--退款详情 订单金额点击查看日历价格 modal start-->
<div class="modal fade" id="myModal5" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog calendar-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel5">房价明细:</h4>
            </div>
            <div class="modal-body h-body">
                <table class="table table-bordered">
                    <tr class="dateCon">

                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- 操作流水-->
<div class="modal fade" id="myModal6" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="width: 900px; margin-left: -100px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">操作流水:</h4>
            </div>
            <div class="modal-body" style="text-align: center;height: 400px; overflow-y: auto">
                <table class="table-bordered czls" width="90%" style="margin: 0 auto;vertical-align: middle">
                    <thead>
                    <td width="20%">操作时间</td>
                    <td width="15%">操作人</td>
                    <td width="20%">操作前订单状态</td>
                    <td width="15%">操作类型</td>
                    <td>备注</td>
                    </thead>
                </table>
            </div>
            <div class="modal-footer" style="text-align: center;">
                <button type="button" class="btn btn-default clo1" data-dismiss="modal">取消</button>
            </div>
        </div>
    </div>
</div>
<!--end-->


<!--退款详情 导出全部 modal start-->
<div class="modal fade" id="myModa33" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header h-top">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel3">导出全部:</h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer footer-btn">
                <button type="button" class="btn btn-primary confirm">确定</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>
<!--end-->
<!--退款详情 导出全部 modal start-->
<div class="modal fade" id="myModa33" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header h-top">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel3">导出全部:</h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer footer-btn">
                <button type="button" class="btn btn-primary confirm">确定</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>
<!--end-->

<!--开始-->
<div class="sxh_main">
    <div class="shade_wrap" style="position: absolute;left: 0;top: 0;display: none;z-index:20;background: rgba(250,251,250,0.6);width: 100%;height: 100%;text-align: center;padding-top: 15%;box-sizing: border-box">
        <img src="<?= Yii::$app->request->baseUrl ?>/webcaiwu/img/loading.gif"/>
    </div>
    <section class="content">
        <div class="sxh_tk-cx">
            <div class="sxh_content">
                <div class="top" style="margin-bottom:20px;padding:0 20px;">
                    <span class="cx" style="background:url(<?= Yii::$app->request->baseUrl ?>/webcaiwu/img/arrow_bot.png) left center no-repeat;padding-left:20px;display:inline-block;background-size:15px">查询条件</span>
                    <i></i>
                    <span class="sq" style="padding-left:20px;display:inline-block;background-size:20px">收起</span>
                </div>
                <div class="search-content">
                    <ul class="first_ul">
                        <li>
                            <span>订单编号:</span>
                            <input type="text" id="dtk_orderId">
                        </li>
                        <li>
                            <select id="dtk_timeType" value="">
                                <!--                            <option value="0">不限</option>-->
                                <option value="1">下单时间</option>
                                <option value="2">支付时间</option>
                                <option value="3">申请退款时间</option>
                            </select>
                            <input id="date_start" name="" value="" placeholder="请输入开始时间" class="Wdate" type="text" onfocus="var date_end=$dp.$('date_end');WdatePicker({readOnly:true,onpicked:function(){date_end.focus()}})" />-
                            <input id="date_end" class="Wdate"  placeholder="请选择结束时间"  name="" value="" type="text" onFocus="WdatePicker({minDate:'#F{$dp.$D(\'date_start\',{d:+1})}',readOnly:true})" />
                        </li>
                        <li>
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
                        </li>
                    </ul>
                    <div style="clear:both;"></div>
                    <ul class="second_ul">
                        <li>
                            <span>房客姓名：</span>
                            <input type="text" id="dtk_lodgerName">
                        </li>
                        <li>
                            <span>房客电话：</span>
                            <input type="text" id="dtk_lodgerMobile">
                        </li>
                        <li>
                            <span>房东姓名：</span>
                            <input type="text" id="dtk_landLordName">
                        </li>
                        <li>
                            <span>房东电话：</span>
                            <input type="text" id="dtk_landLordMobile">
                        </li>
                    </ul>
                    <!--                <div style="clear:both;"></div>-->
                    <ul class="third_ul">
                        <li>
                            <span>房源ID:</span>
                            <input type="text" id="dtk_houseId">
                        </li>
                        <li>
                            <span>支付方式:</span>
                            <select id="dtk_payPlatform" value="">
                                <option value="">-全部-</option>
                                <option value="1">支付宝</option>
                                <option value="2">微信</option>
                                <option value="3">银联</option>
                            </select>
                        </li>
                        <li>
                            <button type="button" class="btn btn-primary sear"">搜索</button>
                        </li>
                        <li>
                            <button type="button" class="btn btn btn-default clear_data">清空</button>
                        </li>
                    </ul>
                    <div style="clear: both"></div>
                </div>
            </div>
            <div class="daochu">
                <button type="button" id="export" class="btn btn-primary btn-lg">导出</button>
                <button type="button" id="export_all" class="btn btn-primary btn-lg">导出全部</button>
            </div>
            <div class="form_table">
                <p>*本报表内金额单位为（元）</p>
                <table class="table table-bordered" style="width: 1500px;">
                    <tbody class="cont">
                    <tr>
                        <td>
                            <input type="checkbox" id="box_all">
                            <span style="display: inline-block">商品信息</span>
                        </td>
                        <td>
                            <span>预订人信息</span>
                        </td>
                        <td>
                            <span>房东信息</span>
                        </td>
                        <td>
                            <span>城市</span>
                        </td>
                        <td>
                            <span>间数</span>
                        </td>
                        <td>
                            <span>订单金额</span>
                        </td>
                        <td>
                            <span>应退金额</span>
                        </td>
                        <td>
                            <span>实退金额</span>
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
                    </tbody>
                </table>
            </div>
            <!--分页-->
            <div class="paganition">
                <input type="hidden" class="page_hid" value="1" />
                <div class="left">
                    <span>每页显示条数:</span>
                    <select class="pageSize" style="width: 70px;">
                        <option value="15">15</option>
                        <option value="30">30</option>
                        <option value="50">50</option>
                    </select>
                </div>
                <div class="right">
                    <ul class="pager">
                        <li class="pro_next"><a>首页</a><input type="hidden" value="1"/></li>
                        <li class="pro_next"><a>上页</a><input type="hidden" value=""/></li>
                        <li class="pro_next"><a>下页</a><input type="hidden" value=""/></li>
                        <li class="pro_next"><a>末页</a><input type="hidden" value=""/></li>
                    </ul>
                </div>
                <p style="display: inline-block;float: right;margin: 26px 20px 0px 0px;">
                    共<span class="page_num"></span>页
                </p>
            </div>
            <div style="clear:both;"></div>
        </div>
    </section>
</div>
<!--结束-->
</body>
</html>