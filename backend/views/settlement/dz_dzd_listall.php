<?php
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = '对账单列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>财务管理-对账处理-对账单管理-对账单列表-全部</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <meta content="telephone=no" name="format-detection" />
    <link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/webcaiwu/css/settlement.css">
    <script src="<?= Yii::$app->request->baseUrl ?>/webcaiwu/js/jquery.min.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/My97DatePicker/WdatePicker.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/layer/layer.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/webcaiwu/js/method/base.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/webcaiwu/js/dz_dzd_listall.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/webcaiwu/js/sq.js"></script>
</head>
<style>
    .form_table td span{
        display:inline-block;
    }
    .form_table tr:nth-child(2) td{
        text-align: center;
    }
    .sxh_content ul li:nth-child(1){
        width:inherit;
    }
    .sxh_content .first_ul li:nth-child(3){
        width:inherit;
        margin-left:50px;
    }
    .form_table td em, .form_table td a{
        margin-right:0;
    }
    .form-control[readonly], .form-control{
        background-color:#fff;
        display:inline-block;
        width:inherit;
    }
</style>
<body>
<!--开始-->
<div class="sxh_main">
    <div class="shade_wrap" style="position: absolute;left: 0;top: 0;display: none;z-index:20;background: rgba(250,251,250,0.6);width: 100%;height: 99%;text-align: center;padding-top: 15%;box-sizing: border-box">
        <img src="<?= Yii::$app->request->baseUrl ?>/webcaiwu/img/loading.gif"/>
    </div>
    <section class="content-header h_wrap">
        <ul id="dzd_tab">
            <li class="current-top" statementStatus="">全部</li>
            <li statementStatus="1">已确认</li>
            <li statementStatus="2">未确认</li>
        </ul>
        <hr>
    </section>
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
                        <span style="float:left;margin-top:5px;">时间范围：</span>
                        <div style="display:inline-block;position:relative">
                            <img class="left_img" src="<?= Yii::$app->request->baseUrl ?>/webcaiwu/img/left_arrow.png" style="cursor:pointer;width:25px;position:absolute;left:0;top:3px;" alt="" id="dz_l_date">
                            <input type="text" value="" readonly class="form-control" id="dateRange" style="text-align: center" value="" onClick="WdatePicker({dateFmt:'yyyy-MM'})" >
                            <img class="right_img" src="<?= Yii::$app->request->baseUrl ?>/webcaiwu/img/right_arrow.png" alt="" style="cursor:pointer;position:absolute;right:0;top:0;" id="dz_r_date">
                        </div>

                    </li>
                    <li>
                        <span>业务线：</span>
                        <select id="checkValue">
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
                <div style="clear: both"></div>
                </div>
            </div>
            <div class="daochu">
                <button type="button" class="btn btn-primary btn-lg" id="pullout">导出</button>
            </div>
            <div class="form_table" data=0></div>
        </div>
    </section>
</div>

<!--结束-->
</body>
</html>