<?php
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = '付款单详情';
$this->params['breadcrumbs'][] = $this->title;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>财务管理-对账处理-付款单管理-付款单详情</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <meta content="telephone=no" name="format-detection" />
    <link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/webcaiwu/css/settlement.css">
    <script src="<?= Yii::$app->request->baseUrl ?>/webcaiwu/js/jquery.min.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/webcaiwu/js/method/base.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/layer/layer.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/My97DatePicker/WdatePicker.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/webcaiwu/js/dz_fkd_detail.js"></script>
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
    #fkdBase td{text-align: left !important;}
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
                <h4 style="display:inline-block;margin-right:15px;">付款单详情</h4>
                <hr style="border-top:1px dotted #999;margin-top:10px;">
            </div>
            <div class="form_table table_base" id="fkdBase">
                <!--<table class="table">
                    <tr>
                        <td colspan="3">基本信息</td>
                    </tr>
                    <tr>
                        <td>
                            <span>付款单号：</span>
                            <em>MS2017071012938</em>
                        </td>
                        <td>
                            <span>付款单类型：</span>
                            <em>国内房东应付</em>
                        </td>
                        <td>
                            <span>商家姓名：</span>
                            <em>asxc </em>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>订单编号：</span>
                            <em>MS2017071012938</em>
                        </td>
                        <td>
                            <span>付款单状态：</span>
                            <em>已完成</em>
                        </td>
                        <td>
                            <span>商家电话：</span>
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
                            <span>收款人姓名</span>
                            <em></em>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>收款单号：</span>
                            <em>MS2017071012938</em>
                        </td>
                        <td>
                            <span>完成时间：</span>
                            <em>2017-07-10&nbsp;15:00:07</em>
                        </td>
                        <td>
                            <span>收款人姓名：</span>
                            <em></em>
                        </td>
                    </tr>
                </table>-->
            </div>
            <div class="detail_state">
                <p style="margin-top: 25px;margin-bottom:10px;">
                    账目明细
                </p>
                <div class="form_table2"></div>
<!--                <table class="table table-bordered">-->
<!--                    <tr>-->
<!--                        <td>商品ID</td>-->
<!--                        <td>商品名称</td>-->
<!--                        <td>城市</td>-->
<!--                        <td>应收金额</td>-->
<!--                        <td>实际消费金额</td>-->
<!--                        <td>底价</td>-->
<!--                        <td>实际消费底价</td>-->
<!--                        <td>佣金比例</td>-->
<!--                        <td>应付金额</td>-->
<!--                        <td>变更金额</td>-->
<!--                        <td>实际金额</td>-->
<!--                        <td>补贴优惠券</td>-->
<!--                        <td>补贴退款</td>-->
<!--                        <td>付款手续费</td>-->
<!--                    </tr>-->
<!--                    <tr>-->
<!--                        <td>-->
<!--                            <span style="color:blue">239482048023</span>-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            <span>北京大饭店</span>-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            <span>北京</span>-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            <span>500.00</span>-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            <span>500.00</span>-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            <span>90%</span>-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            <span>450.00</span>-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            <span>0.00</span>-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            <span>450.00</span>-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            <span>收款单中优惠券金额</span>-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            <span>0.00</span>-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            <span>-2.00</span>-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            <span>0.00</span>-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            <span>0.00</span>-->
<!--                        </td>-->
<!--                    </tr>-->
<!--                </table>-->
<!--                <table class="table table-bordered">-->
<!--                    <tr>-->
<!--                        <td>商品ID</td>-->
<!--                        <td>商品名称</td>-->
<!--                        <td>城市</td>-->
<!--                        <td>应收金额</td>-->
<!--                        <td>佣金比例</td>-->
<!--                        <td>实付金额</td>-->
<!--                        <td>补贴优惠券</td>-->
<!--                        <td>付款手续费</td>-->
<!--                    </tr>-->
<!--                    <tr>-->
<!--                        <td>-->
<!--                            <span style="color:blue">239482048023</span>-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            <span>北京大饭店</span>-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            <span>北京</span>-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            <span>500.00</span>-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            <span>500.00</span>-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            <span>90%</span>-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            <span>收款单中优惠券金额</span>-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            <span>0.00</span>-->
<!--                        </td>-->
<!--                    </tr>-->
<!--                </table>-->
                <div class="form_table table_base" id="sjDetail">
                   <!-- <table class="table">
                        <tr>
                            <td colspan="3">商家账号信息</td>
                        </tr>
                        <tr>
                            <td>
                                <span>开户名：</span>
                                <em>张三</em>
                            </td>
                            <td>
                                <span>银行名称：</span>
                                <em>交通银行</em>
                            </td>
                            <td>
                                <span>备注：</span>
                                <em>- </em>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span>收款账户：</span>
                                <em>MS2017071012938</em>
                            </td>
                            <td>
                                <span>开户行：</span>
                                <em>北京上地支行</em>
                            </td>
                            <td>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span>银行卡类型：</span>
                                <em>储蓄卡</em>
                            </td>
                            <td>
                                <span>账户属性：</span>
                                <em>公户</em>
                            </td>
                            <td>
                            </td>
                        </tr>
                    </table>-->
                </div>
            </div>
        </div>
    </section>
    <button type="button" class="btn btn-default" id="goback">返回上一页</button>
</div>

<!--结束-->
</body>
</html>