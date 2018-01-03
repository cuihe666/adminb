<?php
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = '结算单详情';
$this->params['breadcrumbs'][] = $this->title;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>财务管理-结算处理-国内房东结算-账单明细</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <meta content="telephone=no" name="format-detection" />
    <script type="text/javascript">
        var adminId = '<?=Yii::$app->user->getId();?>';
    </script>
    <link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/webcaiwu/css/settlement.css">
    <link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/webcaiwu/css/jquery.pagination.css">
    <script src="<?= Yii::$app->request->baseUrl ?>/webcaiwu/js/jquery.min.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/webcaiwu/js/alert.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/webcaiwu/js/method/base.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/layer/layer.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/My97DatePicker/WdatePicker.js"></script>

    <script src="<?= Yii::$app->request->baseUrl ?>/webcaiwu/js/jquery.pagination.min.js"></script>
</head>
<style>
    .form_table tr:not(:first-child) td input[type="checkbox"]{
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
    .form_table h4{
        margin-bottom:15px;
    }
    .pageNum_location{
        padding-top: 6px;
        float: left;
    }
</style>


<body>
<!--modal操作流水 start-->
<div class="modal fade" id="programList" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" >操作流水:</h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered hasBorder">
                    <thead>
                      <tr>
                          <th>操作时间</th>
                          <th>操作人</th>
                          <th>操作前付款状态</th>
                          <th>操作类型</th>
                          <th>备注</th>
                      </tr>
                    </thead>
                    <tbody>
                        <tr>
                           <td></td>
                           <td></td>
                           <td></td>
                           <td></td>
                           <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer footer-btn">
                <button type="button" class="btn btn-default no" data-dismiss="modal" >取消</button>
            </div>
        </div>
    </div>
</div>

<!--modal 付款确认 start-->
<div class="modal fade" id="myModal4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>-->
                <h4 class="modal-title" >付款确认:</h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered payTable">
                   <tr>
                       <td>结算单号：</td>
                       <td class='blue bold'>TB17020433526</td>
                       <td>付款状态</td>
                       <td>结算待付款</td>
                   </tr>
                   <tr>
                       <td>结算日期：</td>
                       <td>2017-03-05   10:00:00</td>
                       <td>付款日期：</td>
                       <td>-</td>
                   </tr>
                   <tr>
                        <td>房东姓名：</td>
                        <td>张三 </td>
                        <td>房东手机号：</td>
                        <td>13483948234</td>
                   </tr>
                   <tr>
                       <td>收款人姓名：</td>
                       <td>小张</td>
                       <td>收款人联系方式：</td>
                       <td>18462726423</td>
                   </tr>
                   <tr>
                        <td>收款方式：</td>
                        <td>银联</td>
                        <td>收款账户：</td>
                        <td>6225838472839222</td>
                   </tr>
                   <tr>
                       <td>开户行：</td>
                       <td>交通银行西二旗支行</td>
                       <td>订单总额：</td>
                       <td class='orange underLine bold'>￥1634.00</td>
                   </tr>
                   <tr>
                       <td>实收总额：</td>
                       <td  class='orange underLine bold'>￥1134.00</td>
                       <td>优惠金额：</td>
                       <td class='orange underLine bold'>￥500.00</td>
                   </tr>
                    <tr>
                        <td>退款金额：</td>
                        <td class='orange underLine bold'>￥0.00</td>
                        <td>结算总额：</td>
                        <td class='red underLine bold'>￥1500.00</td>
                    </tr>
                    <tr>
                        <td>付款手续费：</td>
                        <td class='orange bold'>—</td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer footer-btn">
                <button type="button" class="btn btn-default yes" onclick="surePay()">付款</button>
                <button type="button" class="btn btn-default no" data-dismiss="modal">取消</button>
            </div>
        </div>
    </div>
</div>


<!--modal 付款中 start-->
<div class="modal fade" id="myModal5" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>-->
                <span class="modelMsg">请稍后刷新页面确认付款结果</span>
                <h4 class="modal-title" >付款中</h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered payTable">

                </table>
            </div>
            <div class="modal-footer footer-btn">
                <button type="button" class="btn btn-default no" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>


<!--modal 导出 start-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" >提示:</h4>
            </div>
            <div class="modal-body">请选择所要导出的订单</div>
            <div class="modal-footer footer-btn">
                <button type="button" class="btn btn-default yes" data-dismiss="modal">确定</button>
            </div>
        </div>
    </div>
</div>
<!--结算单拆分-->
<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" >提示:</h4>
            </div>
            <div class="modal-body">请选择所要拆分的订单</div>
            <div class="modal-footer footer-btn">
                <button type="button" class="btn btn-default yes" data-dismiss="modal">确定</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="upLoadBill" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">提示:</h4>
            </div>
            <div class="modal-body">文件即将下载，请禁用浏览器弹出窗拦截器以确保正常下载，确定继续？</div>
            <div class="modal-footer footer-btn">
                <button type="button" class="btn btn-default yes"  onClick="loadBillList()">确认</button>
                <button type="button" class="btn btn-default no" data-dismiss="modal" >取消</button>
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
                <p> <em class="billCount">2</em>笔订单(结算金额 <span class="price">500.00</span> )暂不进行结算，您确定吗？ </p>
                <textarea placeholder="备注" class="splitMsg"></textarea>
            </div>
            <div class="modal-footer footer-btn">
                <button type="button" class="btn btn-primary" onclick="sureSplit()">确定</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
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
            <div class="daochu" style="margin-bottom:0;">
                <h4 style="display:inline-block;margin-right:15px;">结算单详情</h4>
                <button type="button" class="btn btn-default btn-lg active" data-toggle="modal" onclick="exportBll()">导出</button>
                <hr style="border-top:1px dotted #999;margin-top:10px;">
            </div>
            <div class="guo_btn" style="margin-top:15px;">
                <button class="btn btn-primary yesToAccount">通过</button>
                <button class="btn btn-success noToAccount">拒绝</button>
                <button class="btn btn-primary reHandle">重新审核</button>
                <button class="btn" style="background-color:#9900cd;color:#fff;"  onclick="getProgram()">操作流水</button>
                <button class="btn btn-warning" onclick="goback()">返回上一页</button>
            </div>
            <div class="detail_state">
                <h4>本期账单概况</h4>
                <table class="table table-bordered billSurvey">
                    <thead>
                        <tr>
                            <td>结算ID</td>
                            <td>结算总额</td>
                            <td class="ispartner-id">房东ID</td>
                            <td class="ispartner-name">房东姓名</td>
                            <td class="partner-city">合伙人城市</td>
                            <td>收款方式</td>
                            <td>收款人姓名</td>
                            <td>收款账户</td>
                            <td>开户行</td>
                            <td>付款状态</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="billSurveyCon">
                           <!-- <td>20178384723</td>
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
                            <td class="curPayState">
                                <span >结算待审核</span>
                            </td>-->
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="form_table">
                <h4>本期账单明细</h4>
                <div class="billDetailList">
                    <button class="btn btn-default" id="jlbillBtn" style="margin-bottom:15px;margin-top:15px;" data-toggle="modal" onclick="billSplit()">结算单拆分</button>
                    <table class="table table-bordered  billList">
                        <thead>
                        <tr>
                            <td>
                                <span style="display: inline-block" class="personTitle">房客信息</span>
                            </td>
                            <td>
                                <span>房源信息</span>
                            </td>
                            <td>
                                <span>房源ID</span>
                            </td>
                            <td>
                                <span>支付时间</span>
                            </td>
                            <td class="may_get">
                                <span>应收金额</span>
                            </td>
                            <td>
                                <span>实收金额</span>
                            </td>
                            <td>
                                <span>优惠金额</span>
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
                        </thead>
                        <tbody>
                        <!--<tr>
                            <td colspan="11" class="billListTitle">
                                <input value="1"  type="checkbox">
                                <a href="#">订单编号:1959400773765672</a>
                                <em>收款单号:400773</em>
                                <em>退款单号:2017-06-18 22:15:34</em>
                                <em>入住/离店:2017/02/07至2017/02/09</em>
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
                                <span>已结算</span>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="11" class="billListTitle">
                                <input value="2"  type="checkbox">
                                <a href="#">订单编号:1959400773765672</a>
                                <em>收款单号:400773</em>
                                <em>退款单号:2017-06-18 22:15:34</em>
                                <em>入住/离店:2017/02/07至2017/02/09</em>
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
                                <span>已结算</span>
                            </td>
                        </tr>-->

                        </tbody>
                    </table>
                </div>
            </div>
            <!--分页-->
            <div class="paganition">
                <div class="left">
                    <span>每页显示条数:</span>
                    <select  id="pageSize" style="width: 70px;">
                        <option value="15">15</option>
                        <option value="30">30</option>
                        <option value="50">50</option>
                    </select>
                </div>
                <div class="right">
                    <div class="pageNum_location">
                        共 <span id="totalNum">0</span> 页
                    </div>
                    <div id="Pagination" class="right flickr"></div>
                </div>
            </div>
            <div style="clear:both;"></div>
        </div>
    </section>
</div>
<!--结束-->
<script src="<?= Yii::$app->request->baseUrl ?>/webcaiwu/js/js_cn_billdetail.js"></script>
</body>
</html>