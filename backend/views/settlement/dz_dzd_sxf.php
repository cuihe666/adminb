<?php
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = '对账单手续费';
$this->params['breadcrumbs'][] = $this->title;
?><!DOCTYPE html>
<html lang="en">
<head>
    <title>财务管理-对账处理-对账单管理-手续费记录</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <meta content="telephone=no" name="format-detection" />
    <link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/webcaiwu/css/settlement.css">
    <link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/webcaiwu/css/jquery.pagination.css">
    <script src="<?= Yii::$app->request->baseUrl ?>/webcaiwu/js/jquery.min.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/My97DatePicker/WdatePicker.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/layer/layer.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/webcaiwu/js/method/base.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/webcaiwu/js/dz_dzd_sxf.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/webcaiwu/js/sq.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/webcaiwu/js/jquery.pagination.min.js"></script>

</head>
<style>
    .form_table tr:nth-child(2) td{
        text-align: center;
    }
</style>
<body>
<!--开始-->
<div class="sxh_main">
    <div class="shade_wrap" style="position: absolute;left: 0;top: 0;display: none;z-index:20;background: rgba(250,251,250,0.6);width: 100%;height: 99%;text-align: center;padding-top: 15%;box-sizing: border-box">
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
                        <span>财务单号：</span>
                        <input type="text" id="cw_number" value="">
                    </li>
                    <li>
                        <span>订单编号：</span>
                        <input type="text" id="dd_number" value="">
                    </li>
                    <li>
                        <span>单据类型：</span>
                        <select id="djtype">
                            <option value="">全部</option>
                            <option value="0">收款单</option>
                            <option value="1">退款单</option>
                            <option value="3">结算单</option>
                        </select>
                    </li>
                    <li>
                        <span>日期：</span>
                        <input id="date_start" placeholder="请选择开始日期" name="" value="" class="Wdate" type="text" onfocus="var date_end=$dp.$('date_end');WdatePicker({readOnly:true,onpicked:function(){date_end.focus()}})" />至
                        <input id="date_end"  placeholder="请选择结束日期" class="Wdate" name="" value="" type="text" onFocus="WdatePicker({minDate:'#F{$dp.$D(\'date_start\',{d:+1})}',readOnly:true})" />
                    </li>
                    <li>
                        <span>业务线：</span>
                        <select id="ywx">
                            <option value="">全部</option>
                            <option value="1">民宿</option>
                            <option value="2">旅行</option>
                        </select>
                    </li>
                    <li>
                        <button type="button" class="btn btn-primary" id="search" >搜索</button>
                    </li>
                    <li>
                        <button type="button" class="btn btn-default" id="clear">清空</button>
                    </li>
                </ul>
                <div style="clear:both;"></div>
                </div>
            </div>
            <div class="daochu">
                <button type="button" class="btn btn-primary btn-lg" id="pullOut">导出</button>
            </div>
            <div class="form_table"></div>
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
    </section>
</div>
<!--结束-->
</body>
</html>