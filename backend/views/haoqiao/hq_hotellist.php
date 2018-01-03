<?php
use yii\helpers\Url;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/haoqiao/css/hq_order.css">
	<style type="text/css">
		.search select{
			width: 140px;
		}
		#myModal .conts{
			margin-bottom: 0px;
		}
		#myModal ul{
			list-style: none;
		}
		.modal-footer{
			text-align: center;
			background: white;
			margin-top: 0px;
		}
		.modal-footer span{
			border-radius: 4px;
		}
		.modal-footer span:hover{
			cursor: pointer;
		}
	</style>
</head>
<body>
	<div v-cloak id="myApp" class="main">
		<!-- 顶部查询栏 -->
		<ul class="search">
			<li>
				<select class="check_province" @change="pro_change(1)">
					<option value="">请选择省</option>
					<option v-for="val in province_data" :value="val.cityCode">{{val.cityName}}</option>
				</select>
			</li>
			<li>
				<select class="check_city">
					<option value="">请选择市</option>
					<option v-for="val in city_data" :value="val.cityCode">{{val.cityName}}</option>
				</select>
			</li>
			<li>
				<select class="check_type">
					<option value="">请选择星级类型</option>
					<option value="1">一星级</option>
					<option value="5">二星级</option>
					<option value="6">三星级</option>
					<option value="7">四星级</option>
					<option value="8">五星级</option>
				</select>
			</li>
			<li>
				<input class="hotel_name" type="text" placeholder="请填写酒店名称" name="">
			</li>
			<li>
				<button style="margin-top: 0px" @click="search_order()">查询</button>
				<button style="margin-top: 0px" @click="clear_all()">清空</button>
			</li>
		</ul>
		<!-- 中间部分的批量添加 -->
		<div class="volume_set">
			<input type="checkbox" name="" id="checked_all" @click="checked_all($event)">
			<label for=checked_all>全选/反选</label>
			<button @click="add_money(1)">批量添加</button>
		</div>
		<!-- 底部的表格以及分页 -->
		<div class="cont">
			<div class="table_wrap">
				<table class="table table-bordered checkboxs">
					<thead>
					<td style="width: 5%" class="td1">
						<span>选择</span>
					</td>
					<td style="width: 5%" class="td2">序号</td>
					<td style="width: 10%" class="td3">好巧酒店ID</td>
					<td style="width: 10%" class="td3">酒店名称</td>
					<td style="width: 10%" class="td3">酒店低价</td>
					<td style="width: 10%" class="td3">星级类型</td>
					<td style="width: 10%" class="td3">城市</td>
					<td style="width: 10%" class="td3">供应商</td>
					<td style="width: 30%" class="td3">操作</td>
					</thead>
					<tbody>
						<tr style="background: white" v-for="(val, index) in list_data">
							<td>
								<input type="checkbox" class="checks" name="" @click="checked_one($event)">
								<input type="hidden" class="ids" :value="val.id" name="">
							</td>
							<td>{{startRow + index}}</td>
							<td>{{val.id?val.id:"-"}}</td>
							<td>{{val.completeName?val.completeName:"-"}}</td>
							<td>{{val.startingPrice?val.startingPrice:"-"}}</td>
							<td>{{val.type?star_arr[val.type]:"-"}}</td>
							<td>{{val.cityName?val.cityName:"-"}}</td>
							<td>{{val.sourceType?hotel_type[val.sourceType]:"-"}}</td>
							<td class="operation">
								<a @click="to_detail(val.id)">查看</a>
								<a @click="add_money(0, $event)">添加酒店</a>
								<a @click="to_bottom(val.id)">置底</a>
							</td>
						</tr>						
					</tbody>
				</table>
			</div>
			<div style="clear: both;"></div>
			<div class="paganition" style="margin-bottom: 10px">
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
		<!-- 弹窗开始 -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		    <div class="modal-dialog">
		        <div class="modal-content clear">
		        	<div class="modal-header" style="background: white">
						<span v-if="type == 0">批量添加</span>
						<span v-if="type == 1">添加</span>
		        	</div>
		            <ul class="conts clear">
						<li v-if="type == 0">
							<span style="margin-right: 20px">酒店名称</span>
							<span class="hotel_name"></span>
						</li>
						<li>
							<span style="margin-right: 20px;">佣金比例</span>
							<input type="text" placeholder="请设置佣金比例" name="" class="percent">%
						</li>
		            </ul>
		            <div class="modal-footer">
		                <span  id="savebut" style="margin-right: 100px;color: white;" @click="click_ensure()">确认</span>
		                <span data-dismiss="modal" style="color: white;">取消</span>
		                <input type="hidden" name="">
		                <input type="hidden" name="">
		            </div>
		            <div style="clear: both"></div>
		        </div>
		    </div>
		</div>
	</div>
	<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/TC-housing-resource/lib/js/vue.js"></script>
	<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/TC-housing-resource/lib/js/base.js"></script>
	<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/TC-housing-resource/lib/layer/layer.js"></script>
	<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/TC-housing-resource/lib/My97DatePicker/WdatePicker.js"></script>
	<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/haoqiao/js/hq_hotellist.js"></script>
</body>
</html>