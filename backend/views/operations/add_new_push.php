<?php
use yii\helpers\Url;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/zcoperation/css/reset.css">
	<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/zcoperation/css/add_new_push.css">
	<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/zcoperation/js/lib/jquery.min.js"></script>
	<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/zcoperation/js/lib/newbase.js"></script>
	<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/zcoperation/js/lib/layer/layer.js"></script>
	<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/zcoperation/js/custorm/add_new_push.js"></script>
	<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/zcoperation/js/lib/My97DatePicker/WdatePicker.js"></script>
	<style>
		.main{
			border:none;
		}
		.footer{
			background: none;
			border:none;
		}
	</style>
</head>
<body>

	<div class="main clear">
		<h4>当前位置:首页 > 运营 > App Push</h4>
		<p class="clear">
			<span class="tit">推送类型:</span>
			<select class="push_type">
				<option value="1">Push推送</option>
				<option value="2">站内信</option>
			</select>
		</p>
		<p class="clear">
			<span class="tit">推送时间:</span>
			<input type="text" id="d241" onclick="WdatePicker({minDate:'%y-%M-{%d}',dateFmt:'yyyy-MM-dd- HH:mm:ss'})" class="Wdate" style="width:300px"/>
		</p>
		<p class="clear cit">
			<span class="tit">推送城市:</span>
			<label>
				<input class="city" type="radio" name="city" value="0" /><span style="margin: 0px 20px 0px 10px">全部城市</span>
			</label>
			<label>
				<input class="city" type="radio" name="city" value="1" /><span style="margin: 0px 20px 0px 10px">部分城市</span>
			</label>
			<input type="hidden" class="city_hid">
			<textarea class="add_city" style="resize: none;" type="text" placeholder="请添加城市名称(根据已有城市完全匹配、未完全匹配城市当保存后默认去掉，城市间以逗号隔开)" name=""></textarea> 
		</p>
		<p class="clear">
			<span class="tit">推送平台:</span>
			<select class="platform">
				<option value="0" selected="selected">全部</option>
				<option value="1">安卓</option>
				<option value="2">ios</option>
			</select>
		</p>
		<p class="clear push_user">
			<span class="tit">推送用户</span>
			<label>
				<input class="radio" type="radio" name="user" value="0" style="float: left;margin-top: 8px;"/><span style="margin: 0 20px 0 10px">全部用户</span>
			</label>
			<label>
				<input class="radio" type="radio" name="user" value="1"  style="float: left;margin-top: 8px;"/><span style="margin: 0 20px 0 10px">新用户</span>
			</label>
			<label>
				<input class="radio" type="radio" name="user" value="2"  style="float: left;margin-top: 8px;"/><span style="margin: 0 20px 0 10px">已购买用户</span>
			</label>
			<label>
				<input class="radio" type="radio" name="user" value="3"  style="float: left;margin-top: 8px;"/><span style="margin: 0 20px 0 10px">未购买用户</span>
			</label>
			<input type="hidden" class="user_hid" />			
		</p>
		<p>
			<span class="tit">跳转类型:</span>
			<select class="rup_type">
				<option value="20" selected="selected">启动APP</option>
				<option value="1">H5</option>
				<option value="12">民宿产品详情</option>
				<option value="14">酒店产品详情</option>
				<option value="4">旅游产品详情</option>
				<option value="2">民宿列表(城市分)</option>
				<option value="15">酒店列表(城市分)</option>
				<option value="16">旅游列表(城市分)</option>
			</select>
			<select class="travel">
				<option value="1" selected="selected">主题线路</option>
				<option value="2">当地活动</option>
				<option value="4">游记攻略</option>
				<option value="3">印象随笔</option>
				<option value="7">当地向导</option>
			</select>
			<input class="link_id" type="text" />
			<div style="clear: both;"></div>
			<select style="margin-left: 94px" class="country">
				<option selected="selected" value="">国家</option>
			</select>
			<select class="sheng">
				<option selected="selected" value="">省</option>
			</select>
			<select class="shi">
				<option selected="selected" value="">市</option>
			</select>
		</p>
		<p>
			<span class="tit">Push主题:</span>
			<input class="add_tit" type="text" placeholder="请填写主题" />
		</p>
		<p>
			<span class="tit" style="float: left;">Push内容:</span>
			<textarea class="add_cont" style="resize: none;" placeholder="请填写内容"></textarea>
		</p>
		<p class="footer">
			<a id="save">保存</a>
			<a id="abolish">取消</a>
		</p>
	</div>
<!--js使用到的url跳转地址 start-->
	<input class="toapp_push" type="hidden" value="<?= Url::toRoute('operations/app_push') ?>"/>
<!--js使用到的url跳转地址 end-->
</body>
</html>