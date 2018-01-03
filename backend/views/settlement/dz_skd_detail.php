<?php
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = '收款单详情 ';
$this->params['breadcrumbs'][] = $this->title;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>财务管理-对账处理-收款单管理-收款单详情</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <meta content="telephone=no" name="format-detection" />
    <link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/webcaiwu/css/settlement.css">
    <script src="<?= Yii::$app->request->baseUrl ?>/webcaiwu/js/jquery.min.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/My97DatePicker/WdatePicker.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/layer/layer.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/webcaiwu/js/method/base.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/webcaiwu/js/dz_skd_detail.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/webcaiwu/js/sq.js"></script>
</head>
<style>
    .sxh_tk-cx .table_base{
        /*width:60%;*/
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
    #baseDetail td{text-align: left !important;}
</style>

<body>
<!--开始-->
<div class="sxh_main">
    <div class="shade_wrap" style="position: absolute;left: 0;top: 0;display: none;z-index:20;background: rgba(250,251,250,0.6);width: 100%;height: 99%;text-align: center;padding-top: 15%;box-sizing: border-box">
        <img src="<?= Yii::$app->request->baseUrl ?>/webcaiwu/img/loading.gif"/>
    </div>
    <section class="content">
        <div class="sxh_tk-cx">
            <div class="daochu">
                <h4 style="display:inline-block;margin-right:15px;">收款单详情</h4>
                <hr style="border-top:1px dotted #999;margin-top:10px;">
            </div>
            <div class="form_table table_base" id="baseDetail">
                <!--<table class="table">
                    <tr>
                        <td colspan="3">基本信息</td>
                    </tr>
                    <tr>
                        <td>
                            <span>收款单号：</span>
                            <em>MS2017071012938</em>
                        </td>
                        <td>
                            <span>收款单类型：</span>
                            <em>民宿应退</em>
                        </td>
                        <td>
                            <span>买家姓名：</span>
                            <em>asxc </em>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>订单编号：</span>
                            <em>MS2017071012938</em>
                        </td>
                        <td>
                            <span>收款单状态：</span>
                            <em>已完成</em>
                        </td>
                        <td>
                            <span>买家电话：</span>
                            <em></em>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>第三方单号：</span>
                            <em>DIF9393292939393</em>
                        </td>
                        <td>
                            <span>创建时间：</span>
                            <em>2017-07-10&nbsp;15:00:07</em>
                        </td>
                        <td>
                            <span>支付方式：</span>
                            <em>微信</em>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>付款单号：</span>
                            <em>MS2017071012938</em>
                        </td>
                        <td>
                            <span>完成时间：</span>
                            <em>2017-07-10&nbsp;15:00:07</em>
                        </td>
                        <td>
                            <span>支付账号：</span>
                            <em>djkdcbk</em>
                        </td>
                    </tr>
                </table>-->
            </div>
            <div class="detail_state">
                <p style="margin-top: 25px;margin-bottom:10px;">
                    账目明细
                </p>
                <div id="receiptDetail">

                    <!--<table class="table table-bordered">
                        <tr>
                            <td>商品ID</td>
                            <td>商品名称</td>
                            <td>应收金额</td>
                            <td>实收金额</td>
                            <td>应退金额</td>
                            <td>实退金额</td>
                            <td>退换优惠券</td>
                            <td>使用优惠券</td>
                            <td>退换手续费</td>
                        </tr>
                        <tr>
                            <td>
                                <span style="color:blue">239482048023</span>
                            </td>
                            <td>锦江之星</td>
                            <td>500.00</td>
                            <td>400.00</td>
                            <td>400.00</td>
                            <td>400.00</td>
                            <td>100.00</td>
                            <td>0.00</td>
                            <td>+1.00</td>
                        </tr>
                    </table>-->
                </div>
            </div>
            <button type="button" class="btn btn-default" id="ysk_btn">已收款</button>
            <button type="button" class="btn btn-default" id="goBack">返回上一页</button>
        </div>
    </section>
</div>

<!--结束-->
</body>
</html>