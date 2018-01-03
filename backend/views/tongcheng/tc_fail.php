<?php
use yii\helpers\Url;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/TC-housing-resource/lib/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/TC-housing-resource/css/TC_fali.css">
</head>
<body>
	<div v-cloak class="main" id="myApp">
		<p class="tit">同程更新失败日志</p>
		<ul class="tap_change">
			<li @click="tap_change(-1, 0)" class="click_btn">房源</li>
			<li @click="tap_change(5, 1)">库存</li>
			<li @click="tap_change(2, 2)">房态价格日历</li>
		</ul>
		<div class="cont">
			<p class="prompt_msg">
				最新更新时间：<span style="margin-right: 40px;"></span>共<span>{{data.data}}</span>个房源更新失败
			</p>
			<div class="table_wrap">
				<table class="table table-bordered">
					<thead>
					<td style="width: 13%" class="td1">ID</td>
					<td style="width: 21%" class="td2">房源名称</td>
					<td style="width: 13%" class="td3">酒店ID</td>
					<td style="width: 13%" class="td3">房型ID</td>
					<td style="width: 20%" class="td3">最后更新时间</td>
					<td style="width: 20%" class="td3">更新失败时间</td>
					</thead>
					<tbody v-if="list_data.length">
					<tr v-for="(value, key) in list_data" style="background: white">
						<td>{{value.houseId}}</td>
						<td>{{value.resProName}}</td>
						<td>{{value.resId}}</td>
						<td>{{value.proId}}</td>
						<td>{{change_time(value.updateTime, "y")}}</td>
						<td>{{change_time(value.updateTime, "y")}}</td>
					</tr>
					</tbody>
				</table>
			</div>

			<input class="save_tr" type="hidden" name="" value="">
			<div style="clear: both;"></div>
			<div class="paganition">
                <div class="left" style="float: left">
                    <span>每页显示条数:</span>
                    <select class="pageSize" style="width: 70px;" @change="change_listSize($event)">
                        <option value="15">15</option>
                        <option value="30">30</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                <div class="right" style="float: right;">
                    <ul class="pager">
                        <li @click="click_proOrnext(0)" class="pro_next disabled"><a>首页</a><input type="hidden" value="1"/></li>
                        <li @click="click_proOrnext(1)" class="pro_next disabled"><a>上页</a><input type="hidden" value=""/></li>
                        <li @click="click_proOrnext(2)" class="pro_next disabled"><a>下页</a><input type="hidden" value=""/></li>
                        <li @click="click_proOrnext(3)" class="pro_next disabled"><a>末页</a><input type="hidden" value=""/></li>
                    </ul>
                </div>
                <p style="display: inline-block;float: right;margin-right: 20px;">
                    共<span class="page_num">0</span>页
                </p>
            </div>
		</div>
		<div style="clear: both;"></div>
	</div>
</body>
<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/TC-housing-resource/lib/js/vue.js"></script>
<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/TC-housing-resource/lib/js/jquery.js"></script>
<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/TC-housing-resource/lib/js/base.js"></script>
<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/TC-housing-resource/lib/layer/layer.js"></script>
<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/TC-housing-resource/js/TC_fali.js"></script>
</html>