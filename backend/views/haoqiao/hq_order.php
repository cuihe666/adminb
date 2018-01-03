<?php
use yii\helpers\Url;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/haoqiao/css/hq_order.css">
</head>
<body>
	<div v-cloak class="main" id="myApp">
		<p class="tit">好巧订单</p>
		<!-- 搜索部分 -->
		<ul class="search">
			<li>
				<span>订单状态:</span>
				<select class="order_state">
					<option value="">请选择</option>
					<option value="0">待支付</option>
					<option value="11">待确认</option>
					<option value="12">待入住</option>
					<option value="13">已入住</option>
					<option value="14">已离店(待点评)</option>
					<option value="15">已点评</option>
					<option value="21">已取消</option>
					<option value="31">退款中</option>
					<option value="32">已退款</option>
					<option value="33">退款失败</option>
					<option value="-1">酒店拒单</option>
				</select>
			</li>
			<li>
				<span>订单号:</span>
				<select @change="order_change()" class="order_type">
					<option value="">请选择</option>
					<option value="0">棠果订单号</option>
					<option value="1">好巧订单号</option>
				</select>
				<input type="text" class="order_num" name="" style="height: 29px;">
			</li>
			<li>
				<span>酒店ID:</span>
				<input type="text" name="" class="hotelId">
			</li>
			<li>
				<span>下单日期:</span>
				<input id="d422" name="" value="" class="Wdate" type="text" onfocus="var d4312=$dp.$('d4312');WdatePicker({readOnly:true,onpicked:function(){d4312.focus()}})" placeholder="请设置起始日期" readonly="">
				—
				<input id="d4312" class="Wdate" name="" value="" type="text" placeholder="请设置结束日期" onfocus="WdatePicker({minDate:'#F{$dp.$D(\'d422\')}',readOnly:true,maxDate:'#F{$dp.$D(\'d422\',{M:+6})}'})" readonly="">
			</li>
			<li style="width: 200px">
				<button @click="search_order">查询</button>
				<button style="margin-left: 20px" @click="clear_all">清空</button>
			</li>
		</ul>
		<!-- 表格以及分页 -->
		<div class="cont">
			<div class="table_wrap">
				<table class="table table-bordered">
					<thead>
					<td style="width: 5%" class="td1">订单号</td>
					<td style="width: 7%" class="td2">好巧订单号</td>
					<td style="width: 13%" class="td3">酒店名称</td>
					<td style="width: 10%" class="td3">房型名称</td>
					<td style="width: 10%" class="td3">订单状态</td>
					<td style="width: 5%" class="td3">支付方式</td>
					<td style="width: 5%" class="td3">订单金额</td>
					<td style="width: 5%" class="td3">支付金额</td>
					<td style="width: 5%" class="td3">退款金额</td>
					<td style="width: 15%" class="td3">下单时间</td>
					<td style="width: 15%" class="td3">入离时间</td>
					<td style="width: 10%" class="td3">间夜</td>
					</thead>
					<tbody>
					<tr v-for="(value, key) in list_data" style="background: white">
						<td>{{value.orderNum?value.orderNum:"-"}}</td>
						<td>{{value.thirdOrderNum?value.thirdOrderNum:"-"}}</td>
						<td>{{value.hotelName?value.hotelName:"-"}}</td>
						<td>{{value.hotelHouseName?value.hotelHouseName:"-"}}</td>
						<td>{{state_arr[value.status]}}</td>
						<td>{{pay_arr[value.payPlatform]}}</td>
						<td>{{value.orderTotal? "￥" + value.orderTotal:"￥0"}}</td>
						<td>{{value.payTotal? "￥" + value.payTotal: "￥0"}}</td>
						<td>{{value.refundPrice? "￥" + value.refundPrice: "￥0"}}</td>
						<td>{{value.createTime?change_time(value.createTime, "sfm"):"-"}}</td>
						<td>{{value.inTime?change_time(value.inTime, "sfm"):"-"}}-{{value.outTime?change_time(value.outTime, "sfm"):"-"}}</td>
						<td>{{value.houseNum?value.houseNum + "间":"-"}}|{{value.dayNum?value.dayNum + "晚":"-"}}</td>
					</tr>
					</tbody>
				</table>
			</div>
			<div style="clear: both;"></div>
			<div class="paganition">
                <div class="left" style="float: left">
                    <span>每页显示条数:</span>
                    <select class="pageSize" style="width: 70px;" @change="change_listSize($event)">
                        <option value="15">15</option>
                        <option value="30">30</option>
                        <option value="50">50</option>
                    </select>
                </div>
                <div class="right" style="float: right;">
                    <ul class="pager">
                        <li class="pro_next disabled" @click="click_proOrnext(0)"><a>首页</a><input type="hidden" value="1"/></li>
                        <li class="pro_next disabled" @click="click_proOrnext(1)"><a>上页</a><input type="hidden" value=""/></li>
                        <li class="pro_next disabled" @click="click_proOrnext(2)"><a>下页</a><input type="hidden" value=""/></li>
                        <li class="pro_next disabled" @click="click_proOrnext(3)"><a>末页</a><input type="hidden" value=""/></li>
                    </ul>
                </div>
                <p style="display: inline-block;float: right;margin-right: 20px;">
                    共<span class="page_num">0</span>页
                </p>
            </div>
		</div>
		<div style="clear: both;"></div>
		<!-- loading图 -->
		<div class="loading_wrap" style="position: absolute;left: 0;top: 0;background: rgba(250,251,250,0.6);width: 100%;height: 99%;text-align: center;padding-top: 15%;box-sizing: border-box">
			<img src="<?= Yii::$app->request->baseUrl ?>/haoqiao/lib/img/loading.gif" />
		</div>
	</div>
</body>
<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/TC-housing-resource/lib/js/vue.js"></script>
<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/TC-housing-resource/lib/js/base.js"></script>
<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/TC-housing-resource/lib/layer/layer.js"></script>
<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/TC-housing-resource/lib/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/haoqiao/js/hq_order.js"></script>
</html>