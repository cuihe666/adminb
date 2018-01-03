<?php
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = '对账单详细';
$this->params['breadcrumbs'][] = $this->title;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>财务管理-对账处理-对账单管理-对账单详情-全部</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <meta content="telephone=no" name="format-detection" />
    <link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/webcaiwu/css/settlement.css">
    <link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/webcaiwu/css/jquery.pagination.css">
    <script src="<?= Yii::$app->request->baseUrl ?>/webcaiwu/js/jquery.min.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/My97DatePicker/WdatePicker.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/layer/layer.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/webcaiwu/js/method/base.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/webcaiwu/js/dz_dzd_detailall.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/webcaiwu/js/jquery.pagination.min.js"></script>
</head>
<body>
<!--开始-->
<div class="sxh_main">
    <div class="shade_wrap" style="position: absolute;left: 0;top: 0;display: none;z-index:20;background: rgba(250,251,250,0.6);width: 100%;height: 99%;text-align: center;padding-top: 15%;box-sizing: border-box">
        <img src="<?= Yii::$app->request->baseUrl ?>/webcaiwu/img/loading.gif"/>
    </div>
    <section class="content">
        <div class="sxh_tk-cx">
            <div class="daochu">
                <h4 style="display:inline-block;margin-right:15px;">对账单详情</h4>
                <span>日期：</span><em style="display:inline-block;margin-right:15px;" id="dateNum"></em>
                <button type="button" class="btn btn-default btn-lg active" id="pullout">导出</button>
                <hr style="border-top:1px dotted #999;margin-top:10px;">
            </div>
            <ul class="first_ul" style="margin-bottom: 15px;">
                <li>
                    <span>财务单类型：</span>
                    <select name="" id="checkValue">
                        <option value="">全部</option>
                        <option value="1">收款</option>
                        <option value="2">退款</option>
                        <option value="3">付款</option>
                    </select>
                </li>
            </ul>
            <div class="detail_state" style="overflow-x: auto"></div>
        </div>
    </section>
    <div class="paganition">
        <div class="left">
            <span>每页显示条数:</span>
            <select id="pageSize">
                <option value="10">10</option>
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
    <button type="button" class="btn btn-default" id="goback">返回上一页</button>
</div>

<!--结束-->
</body>
</html>