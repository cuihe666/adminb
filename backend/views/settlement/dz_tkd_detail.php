<?php
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = '退款单详情';
$this->params['breadcrumbs'][] = $this->title;
?><!DOCTYPE html>
<html lang="en">
<head>
    <title>财务管理-对账处理-退款单管理-退款单详情</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <meta content="telephone=no" name="format-detection" />
    <link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/webcaiwu/css/settlement.css">
    <script src="<?= Yii::$app->request->baseUrl ?>/webcaiwu/js/jquery.min.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/My97DatePicker/WdatePicker.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/webcaiwu/js/method/base.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/webcaiwu/js/dz_tkd_detail.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/layer/layer.js"></script>
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
                <h4 style="display:inline-block;margin-right:15px;">退款单详情</h4>
                <hr style="border-top:1px dotted #999;margin-top:10px;">
            </div>
            <div class="form_table table_base" id="baseDetail">
            </div>
            <div class="detail_state">
                <p style="margin-top: 25px;margin-bottom:10px;">
                    账目明细
                </p>
                <div class="tdkDetail">

                </div>
            </div>
            <button type="button" class="btn btn-default" id="goback">返回上一页</button>
        </div>
    </section>
</div>

<!--结束-->
</body>
</html>