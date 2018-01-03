<?php
use yii\helpers\Url;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/TC-housing-resource/lib/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/TC-housing-resource/css/TC_order.css">
</head>
<body>
	<div v-cloak class="main" id="myApp">
		<p class="tit">同程订单</p>
		<ul class="search">
			<li>
				<span>订单状态:</span>
				<select class="order_state">
					<option value="">请选择</option>
					<option value="0">待确认库存</option>
					<option value="1">待支付</option>
					<option value="2">已取消</option>
					<option value="3">已支付</option>
					<option value="5">待同程确认</option>
					<option value="10">同程已确认</option>
					<option value="11">确认入住</option>
					<option value="12">确认未住</option>
					<option value="15">申请部分退款</option>
					<option value="20">申请全额退款</option>
					<option value="25">全额退款结束</option>
					<option value="26">部分退款结束</option>
					<option value="27">拒绝部分退款</option>
					<option value="30">部分退款结束</option>
					<option value="35">已结算</option>
					<option value="40">订单结束</option>
					<option value="41">未抢到房源</option>
				</select>
			</li>
			<li>
				<span>订单号:</span>
				<select @change="order_change()" class="order_type">
					<option value="">请选择</option>
					<option value="0">棠果订单号</option>
					<option value="1">同程订单号</option>
				</select>
				<input type="text" class="order_num" name="" style="height: 29px;">
			</li>
			<li>
				<span>更新状态:</span>
				<select class="update_type">
					<option value="">请选择</option>
					<option value="0">成功</option>
					<option value="1">失败</option>
				</select>
			</li>
			<li>
				<span>房源ID:</span>
				<input type="text" name="" class="houseId">
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
		<div class="cont">
			<p class="cont_msg">
				最新更新时间:<span></span><button class="update_btn" @click="update_list">更新</button><button @click="export_excel" style="float: right;margin-right: 20%">导出excel</button>
			</p>
			<div class="table_wrap">
				<table class="table table-bordered">
					<thead>
					<td style="width: 5%" class="td1">订单ID</td>
					<td style="width: 6%" class="td2">同程订单ID</td>
					<td style="width: 12%" class="td3">房源名称</td>
					<td style="width: 6%" class="td3">房源ID</td>
					<td style="width: 8%" class="td3">状态</td>
					<td style="width: 5%" class="td3">更新状态</td>
					<td style="width: 5%" class="td3">支付方式</td>
					<td style="width: 5%" class="td3">支付金额</td>
					<td style="width: 5%" class="td3">退款金额</td>
					<td style="width: 10%" class="td3">下单时间</td>
					<td style="width: 10%" class="td3">最后更新时间</td>
					<td style="width: 5%" class="td3">间夜</td>
					<td style="width: 10%" class="td3">入离时间</td>
					<td style="width: 8%" class="td3">操作</td>
					</thead>
					<tbody>
					<tr v-for="(value, key) in list_data" style="background: white">
						<td>{{value.tgOrderNum}}</td>
						<td>{{value.cusOrderId}}</td>
						<td>{{value.productTitle}}</td>
						<td>{{value.houseId}}</td>
						<td>{{state_arr[value.orderStatus]}}</td>
						<td>{{update_arr[value.updateState]}}</td>
						<td>{{pay_arr[value.payPlatform]}}</td>
						<td>￥{{value.orderAmount}}</td>
						<td>￥{{value.refundAmount}}</td>
						<td>{{change_time(value.createTime, "y")}}</td>
						<td>{{change_time(value.updateTime, "y")}}</td>
						<td>{{value.roomCount}}间&nbsp;|&nbsp;{{value.days}}晚</td>
						<td>入:{{change_time(value.startTime)}}<br/>离:{{change_time(value.endTime)}}</td>
						<td>
							<a @click="update_single(value.cusOrderId, key)">更新</a>&nbsp;&nbsp;
							<a @click="order_detail(value.cusOrderId, key, $event)">详情</a>
						</td>
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
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		    <div class="modal-dialog">
		        <div class="modal-content" style="width: 140%; margin-left: -20%">
		        	<div class="modal-header">
						同程订单号: <span class="order_ids"></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;状态:<span class="order_status"></span><i  data-dismiss="modal" class="clo_btn" style="font-weight: bold; font-size: 18px;float: right;">X</i>
		        	</div>
		            <div class="cont clear" style="height: 640px; overflow-y: auto;">
						<p>订单信息</p>
						<table class="table table-bordered">
							<tr>
								<td class="thead" style="width: 15%">棠果订单ID</td>
								<td style="width: 20%">{{detail_obj.tcOrderInfoModel.tgOrderId}}</td>
								<td class="thead" style="width: 12%">订单金额</td>
								<td style="width: 20%">{{detail_obj.tcOrderInfoModel.orderAmount}}</td>
								<td class="thead" style="width: 13%">支付金额</td>
								<td style="width: 20%">{{detail_obj.tcOrderInfoModel.money}}</td>
							</tr>
							<tr>
								<td class="thead">退款金额</td>
								<td>￥{{detail_obj.tcOrderInfoModel.refundAmount}}</td>
								<td class="thead">赔款金额</td>
								<td>￥{{detail_obj.tcOrderInfoModel.compensateAmount}}</td>
								<td class="thead">手续费</td>
								<td>￥{{detail_obj.tcOrderInfoModel.penaltyAmount}}</td>
							</tr>
							<tr>
								<td class="thead">联系人</td>
								<td>{{detail_obj.tcOrderInfoModel.contact}}</td>
								<td class="thead">联系人手机</td>
								<td>{{detail_obj.tcOrderInfoModel.cellphone}}</td>
								<td class="thead">联系人性别</td>
								<td>{{(detail_obj.tcOrderInfoModel.contactSex == 0)?"男":"女"}}</td>
							</tr>
							<tr>
								<td class="thead">入住时间</td>
								<td>{{change_time(detail_obj.tcOrderInfoModel.startTime)}}</td>
								<td class="thead">离店时间</td>
								<td>{{change_time(detail_obj.tcOrderInfoModel.endTime)}}</td>
								<td class="thead">下单时间</td>
								<td>{{change_time(detail_obj.tcOrderInfoModel.createTime, "y")}}</td>
							</tr>
							<tr>
								<td class="thead">订单预订模式</td>
								<td>{{reserve_state[detail_obj.tcOrderInfoModel.paymentFlag]}}</td>
								<td class="thead">房间数</td>
								<td>{{detail_obj.tcOrderInfoModel.roomCount}}</td>
								<td class="thead">天数</td>
								<td>{{detail_obj.tcOrderInfoModel.days}}</td>
							</tr>
						</table>
						<p>预订人信息</p>
						<table class="table table-bordered">
							<tr>
								<td class="thead" style="width: 15%">成人数</td>
								<td style="width: 20%">{{detail_obj.tcOrderInfoModel.adultCount}}</td>
								<td class="thead" style="width: 12%">儿童数</td>
								<td style="width: 20%">{{detail_obj.tcOrderInfoModel.childCount}}</td>
								<td class="thead" style="width: 13%"></td>
								<td style="width: 20%"></td>
							</tr>
							<tr v-if="detail_obj.tcPassengerModelList.length > 0" v-for="item in detail_obj.tcPassengerModelList">
								<td class="thead">姓名</td>
								<td>{{item.name}}</td>
								<td class="thead">证件类型</td>
								<td>{{id_type[item.idType]}}</td>
								<td class="thead">证件号码</td>
								<td>{{item.idNo}}</td>
							</tr>
						</table>
						<p>房源信息</p>
						<table class="table table-bordered">
							<tr>
								<td class="thead" style="width: 15%">房源ID</td>
								<td style="width: 20%">{{detail_obj.tcResourceModel['0'].houseId}}</td>
								<td class="thead" style="width: 12%">房源名称</td>
								<td style="width: 20%">{{detail_obj.tcResourceModel['0'].name}}</td>
								<td class="thead" style="width: 13%">房型名称</td>
								<td style="width: 20%">{{detail_obj.tcResourceModel['0'].productName}}</td>
							</tr>
							<tr>
								<td class="thead">房源类型</td>
								<td>{{houseType[detail_obj.tcResourceModel['0'].type]}}</td>
								<td class="thead">销售策略</td>
								<td>{{detail_obj.tcResourceModel['0'].productUniqueId}}</td>
								<td class="thead">份数</td>
								<td>{{detail_obj.tcResourceModel['0'].priceFraction}}</td>
							</tr>
							<tr>
								<td class="thead">特殊要求</td>
								<td>{{detail_obj.tcResourceModel['0'].remark}}</td>
								<td class="thead">到店时间</td>
								<td>{{detail_obj.tcResourceModel['0'].arrivalTime}}</td>
								<td class="thead">供应商确认号</td>
								<td>{{detail_obj.tcResourceModel['0'].supplierConfirmNumber}}</td>
							</tr>
						</table>
						<!-- <br/> -->
						<table class="table table-bordered">
							<tr>
								<td class="thead" width="20%">备注</td>
								<td>无</td>
							</tr>
						</table>
		            </div>
		            <div class="modal-footer">
		                <!-- <span  id="savebut" style="margin-right: 100px;color: white;">确定</span>
		                <span data-dismiss="modal" style="color: white;">取消</span> -->
		            </div>
		        </div>
		    </div>
		</div>
	</div>
</body>
<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/TC-housing-resource/lib/js/vue.js"></script>
<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/TC-housing-resource/lib/js/jquery.js"></script>
<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/TC-housing-resource/lib/js/base.js"></script>
<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/TC-housing-resource/lib/layer/layer.js"></script>
<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/TC-housing-resource/lib/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/TC-housing-resource/lib/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/TC-housing-resource/js/TC_order.js"></script>
</html>
