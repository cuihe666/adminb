<?php
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = '国内房东结算';
$this->params['breadcrumbs'][] = $this->title;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>财务管理-结算处理-国内房东结算-全部结算单</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <meta content="telephone=no" name="format-detection" />
    <script type="text/javascript">
        var adminId = '<?=Yii::$app->user->getId();?>';
    </script>
    <link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/webcaiwu/css/settlement.css">
    <script src="<?= Yii::$app->request->baseUrl ?>/webcaiwu/js/jquery.min.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/layer/layer.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/webcaiwu/js/method/base.js" ></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/My97DatePicker/WdatePicker.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/webcaiwu/js/sq.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/webcaiwu/js/js_cn_fd_all.js"></script>

</head>
<style>
    .form_table tr:not(:first-child) td input[type="checkbox"] {
        margin-left: 40px;
    }
    .footer-btn{
        text-align: center;
    }
    .modal-header,.modal-footer{
        border:none;
    }
    .modal-header{
        padding-bottom:0;
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
        resize: none;
    }
    .czls td{
        padding: 6px 0px;
    }
    .pager a:hover{
        cursor: pointer;
    }
    @media screen and (max-width: 1500px) {
        .form_table table{
            width:1500px;
        }
        .form_table .box_null{
            width: 1500px!important;
        }
    }
</style>
<body>
<!--modal-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="width: 400px;margin-left: 120px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">提示:</h4>
            </div>
            <div class="modal-body" style="text-align: center;">请选择所要导出的订单</div>
            <div class="modal-footer" style="text-align: center;">
                <button type="button" class="btn confirm" data-dismiss="modal" style="margin-right: 80px;background: #1888F8;color: white;">确定</button>
                <button type="button" class="btn btn-default clo" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>

<!--付款详情 modal start-->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="position: relative;">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel2">付款确认:</h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered js_pay">
                    <tbody>
                    <tr>
                        <td>
                            结算单号：
                        </td>
                        <td>
<!--                            TB17020433526-->
                        </td>
                        <td>
                            付款状态：
                        </td>
                        <td>
<!--                            结算待付款-->
                        </td>
                    </tr>
                    <tr>
                        <td>
                            结算日期：
                        </td>
                        <td>
                            <span></span>
                            <em></em>
                        </td>
                        <td>
                            付款日期：
                        </td>
                        <td>
                            <span></span>
                            <em></em>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            房东姓名：
                        </td>
                        <td>
<!--                            张三-->
                        </td>
                        <td>
                            房东手机号：
                        </td>
                        <td>
<!--                            12345678954-->
                        </td>
                    </tr>
                    <tr>
                        <td>
                            收款人姓名：
                        </td>
                        <td>
<!--                            小张-->
                        </td>
                        <td>
                            收款人联系方式：
                        </td>
                        <td>
<!--                            13483948234-->
                        </td>
                    </tr>
                    <tr>
                        <td>收款方式：</td>
                        <td></td>
                        <td>收款账户：</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>
                            开户行：
                        </td>
                        <td>
<!--                            交通银行西二旗支行：-->
                        </td>
                        <td>
                            订单总额：
                        </td>
                        <td style="color:orange;">

                        </td>
                    </tr>
                    <tr>
                        <td>
                            实收金额：
                        </td>
                        <td style="color:orange;">

                        </td>
                        <td>
                            优惠金额：
                        </td>
                        <td style="color:orange;">

                        </td>
                    </tr>
                    <tr>
                        <td>
                            退款金额：
                        </td>
                        <td style="color:orange;">

                        </td>
                        <td>
                            结算金额：
                        </td>
                        <td style="color:red;">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            付款手续费：
                        </td>
                        <td style="color:orange;">

                        </td>
                        <td class="pay_name">

                        </td>
                        <td class="pay_namer">

                        </td>
                    </tr>
                    <tr class="third_ls">
                        <td>
                            第三方流水：
                        </td>
                        <td style="color:orange;">
                        </td>
                        <td>

                        </td>
                        <td>

                        </td>
                    </tr>
                    </tbody>
                </table>

            </div>
            <div class="modal-footer footer-btn">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" data-dismiss="modal">付款</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
            </div>
        </div>
    </div>
</div>
<!-- 操作流水-->
<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                    <td width="20%">操作前付款状态</td>
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


<!--开始-->
<div class="sxh_main">
    <div class="shade_wrap" style="position: absolute;left: 0;top: 0;display: none;z-index:20;background: rgba(250,251,250,0.6);width: 100%;height: 100%;text-align: center;padding-top: 15%;box-sizing: border-box">
        <img src="<?= Yii::$app->request->baseUrl ?>/webcaiwu/img/loading.gif"/>
    </div>
    <input class="href_inp" type="hidden" value="<?php echo \yii\helpers\Url::to(['settlement/js_cn_billdetail']) ?>"/>
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
                        <span>结算ID:</span>
                        <input type="text" class="js_id">
                    </li>
                    <li>
                        <select class="js_dateType">
                            <option value="0">结算日期</option>
                            <option value="1">付款日期</option>
                        </select>
                        <input id="date_start" name="" value="" placeholder="请选择开始时间" class="Wdate" type="text" onfocus="var date_end=$dp.$('date_end');WdatePicker({readOnly:true,onpicked:function(){date_end.focus()}})" />至
                        <input id="date_end" class="Wdate" name="" placeholder="请选择结束时间" value="" type="text" onFocus="WdatePicker({minDate:'#F{$dp.$D(\'date_start\',{d:+1})}',readOnly:true})" />
                    </li>
                    <li>
                        <span>房东ID:</span>
                        <input type="text" class="fd_id">
                    </li>
                </ul>
                <div style="clear:both;"></div>
                <ul class="second_ul">
                    <li>
                        <span>房东姓名：</span>
                        <input type="text" class="fd_name">
                    </li>
                    <li>
                        <span>房东电话：</span>
                        <input type="text" class="fd_phone">
                    </li>
                    <li>
                        <button type="button" class="btn btn-primary sear" >搜索</button>
                    </li>
                    <li>
                        <button type="button" class="btn clear_data">清空</button>
                    </li>
                </ul>
                <div style="clear: both"></div>
                </div>
            </div>
            <div class="daochu">
                <button type="button" id="export" class="btn btn-default btn-lg active">导出</button>
                <button type="button" id="export_all" class="btn btn-default btn-lg active">导出全部</button>
            </div>
            <div class="form_table">
                <p>*本报表内金额单位为（元）</p>
                <table class="table table-bordered">
                    <tbody class="cont">
                    <tr>
                        <td>
                            <input type="checkbox" id="box_all">
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
                            <span>付款状态</span>
                        </td>
                        <td>
                            <span>操作</span>
                        </td>
                    </tr>
<!--                    <tr>-->
<!--                        <td colspan="10">-->
<!--                            <input type="checkbox">-->
<!--                            <a href="#">结算ID:1959400773765672</a>-->
<!--                            <em>房东ID:400773</em>-->
<!--                            <em>结算日期:2017-06-18 22:15:34</em>-->
<!--                            <em>付款日期:-</em>-->
<!--                        </td>-->
<!--                    </tr>-->
<!--                    <tr>-->
<!--                        <td>-->
<!--                            <span>番茄来了</span>-->
<!--                            <span>15487412365</span>-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            <span>银联</span>-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            <span>18635228384</span>-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            <span>招商银行上地支行</span>-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            500.00-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            400.00-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            100.00-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            400.00-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            400.00-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            已付款-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            <button style="color:#3c8dbc" data-toggle="modal" data-target="#myModal2">付款详情</button>-->
<!--                            <a href="#" style="margin-right:10px;" target="_blank">操作流水</a>-->
<!--                        </td>-->
<!--                    </tr>-->
<!--                    <tr>-->
<!--                        <td colspan="10" style="text-align: left;">-->
<!--                            <input type="checkbox">-->
<!--                            <a href="#">结算ID:1959400773765672</a>-->
<!--                            <em>房东ID:400773</em>-->
<!--                            <em>结算日期:2017-06-18 22:15:34</em>-->
<!--                            <em>付款日期:-</em>-->
<!--                        </td>-->
<!--                    </tr>-->
<!--                    <tr>-->
<!--                        <td>-->
<!--                            <span>番茄来了</span>-->
<!--                            <span>15487412365</span>-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            <span>银联</span>-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            <span>18635228384</span>-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            <span>招商银行上地支行</span>-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            500.00-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            400.00-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            100.00-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            400.00-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            400.00-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            <span>付款中</span>-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            <button style="color:#3c8dbc" data-toggle="modal" data-target="#myModal2">付款详情</button>-->
<!--                            <a href="#" style="margin-right:10px;" target="_blank">操作流水</a>-->
<!--                        </td>-->
<!--                    </tr>-->
<!--                    <tr>-->
<!--                        <td colspan="10" style="text-align: left;">-->
<!--                            <input type="checkbox">-->
<!--                            <a href="#">结算ID:1959400773765672</a>-->
<!--                            <em>房东ID:400773</em>-->
<!--                            <em>结算日期:2017-06-18 22:15:34</em>-->
<!--                            <em>付款日期:-</em>-->
<!--                        </td>-->
<!--                    </tr>-->
<!--                    <tr>-->
<!--                        <td>-->
<!--                            <span>番茄来了</span>-->
<!--                            <span>15487412365</span>-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            <span>银联</span>-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            <span>18635228384</span>-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            <span>招商银行上地支行</span>-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            500.00-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            400.00-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            100.00-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            400.00-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            400.00-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            <span style="color:red;">付款失败</span>-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            <button style="color:#3c8dbc" data-toggle="modal" data-target="#myModal2">再次付款</button>-->
<!--                            <a href="#" style="margin-right:10px;" target="_blank">操作流水</a>-->
<!--                        </td>-->
<!--                    </tr>-->
                    </tbody>
                </table>
            </div>
            <!--分页-->
            <div class="paganition">
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
                        <li style="margin-left: 20px;">跳转到&nbsp;<input type="text" class="to_page" style="width: 40px;text-align: center;"  value="1"/>&nbsp;页<button class="turn_pages" style="margin-left: 10px;padding: 4px 8px;color: white;background: #367fa9;">确定</button></li>
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