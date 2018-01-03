<?php
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = '民宿异常订单列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>订单管理-民宿-结算异常订单</title>
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
    <script src="<?= Yii::$app->request->baseUrl ?>/webcaiwu/js/dd_ms_abnormal.js"></script>
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
</style>

<body>
<input type="hidden" value="<?php echo Yii::$app->user->id;?>" id="opeRate">
<!--modal-->
<div class="modal fade" id="myModaledit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">修改订单</h4>
            </div>
            <div class="modal-body" id="mymodel_editbox"></div>
            <div class="modal-footer footer-btn">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary" id="editSure">确定</button>
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
                            <input id="date_start" name="" value="" class="Wdate" type="text" onfocus="var date_end=$dp.$('date_end');WdatePicker({readOnly:true,onpicked:function(){date_end.focus()}})" placeholder="请输入开始日期"/>至
                            <input id="date_end" class="Wdate" name="" value="" type="text" onFocus="WdatePicker({minDate:'#F{$dp.$D(\'date_start\',{d:+1})}',readOnly:true})" placeholder="请输入结束日期"/>

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
                    <li class="current" id="detailAll" status=67 abstatus="">
                        全部订单
                    </li>
                    <li id="detailDcl" abstatus=1 status=67>
                        待处理
                    </li>
                    <li id="detailYcl" abstatus=2 status=67>
                        已处理
                    </li>

                </ul>
                <hr>
            </section>
            <div class="col-sm-12">
                <div class="form_table  table-responsive kv-grid-container" id="ddListData" data=0 style="width: 100%;">
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
            <input type="hidden" id="pageTotal" value="">
        </div>
    </div>
    <div style="clear:both;"></div>

</div>
<!--结束-->
</body>
</html>