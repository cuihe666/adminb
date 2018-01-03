<?php
use yii\helpers\Url;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<script type="text/javascript">
		var adminId = '<?=Yii::$app->user->getId();?>';
	</script>
	<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/zcoperation/css/reset.css">
	<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/zcoperation/css/common.css">
	<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/zcoperation/css/banner_edit.css">
	<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/zcoperation/js/lib/jquery.min.js"></script>
	<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/zcoperation/js/lib/newbase.js"></script>
	<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/zcoperation/js/lib/layer/layer.js"></script>
	<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/zcoperation/js/custorm/banner_edit.js"></script>
	<script src="http://cdn.staticfile.org/Plupload/2.1.1/plupload.full.min.js"></script>
	<script src="https://cdn.staticfile.org/qiniu-js-sdk/1.0.14-beta/qiniu.js"></script>
</head>
<body style="background: white;">
	<div class="main" style="height: 99%;">
		<div class="t_header">
			<h4>当前位置 : &nbsp;运营&nbsp;>&nbsp;<a href="<?= Url::toRoute('operations/operationslocat') ?>">运营位管理</a>&nbsp;>&nbsp;<span class="tite"></span></h4>
		</div>
		<div class="conts clear">
			<p class="add_new">
				<a data-toggle="modal"><span class="glyphicon glyphicon-plus" style="margin-right: 6px"></span>新增</a>
			</p>
			<table class="table table-bordered">
				<thead>
					<td style="width: 5%" class="td1">序号</td>
					<td style="width: 9%" class="td2">标题</td>
					<td style="width: 9%" class="td3">跳转形式</td>
					<td style="width: 22%" class="td4">预览</td>
					<td style="width: 8%" class="td5">排序位置</td>
					<td style="width: 8%" class="td6">状态</td>
					<td style="width: 15%" class="td7">更改时间</td>
					<td style="width: 10%" class="td8">操作人</td>
					<td style="width: 16%" class="td9">操作</td>
				</thead>
			</table>
		</div>
	</div>	
</body>
</html>
<div class="wrap1" style="position: absolute;left: 0;top: 0;display: none;background: rgba(250,251,250,0.6);width: 100%;height: 99%;text-align: center;padding-top: 15%;box-sizing: border-box">
	<img src="<?= Yii::$app->request->baseUrl ?>/zcoperation/img/loading.gif"/>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        	<div class="modal-header">
				新增
        	</div>
            <div class="cont clear">
				<p class="clear">
					<span class="tit">标题:</span>
					<input class="add_tit" type="text" placeholder="请填写标题" name="">
				</p>
				<p class="clear">
					<span class="tit">副标题:</span>
					<input class="fu_tit" type="text" placeholder="请填写副标题" name="">
				</p>
				<p class="clear jump_type">
					<span class="tit">跳转类型:</span>
					<select id="jump_type">
						<option value="0">请填写链接类型</option>
						<option value="1">H5</option>
						<option value="12">民宿产品详情</option>
						<option value="15">酒店产品详情</option>
						<option value="18">旅游产品详情</option>
						<option value="14">原生酒店</option>
						<option value="19">原生商城</option>
						<option value="20">专题活动</option>
						<option value="2">民宿列表(城市分)</option>
						<option value="17">酒店列表(城市分)</option>
						<option value="16">旅游列表(城市分)</option>
						<option value="21">第三方H5</option>
					</select>
					<select class="travel_type" style="margin-left: 10px;display: none;">
						<option value="1">主题线路</option>
						<option value="2">当地活动</option>
<!--						<option value="4">游记攻略</option>-->
<!--						<option value="3">印象随笔</option>-->
<!--						<option value="7">当地向导</option>-->
					</select>
					<span style="display:block;clear: both;"></span>
					<input class="linkurl" type="text" placeholder="请填写链接地址" name="">
					<select class="country" style="margin: 0 10px 0 90px">
						<option value="">国家</option>
					</select>
					<select class="sheng">
						<option value="">省</option>
					</select>
					<select class="shi">
						<option value="">市</option>
					</select>
					<span class="tishi" style="color: red;display: none;margin-left: 92px;padding: 4px 0px 0px;"></span>
				</p>
				<div class="clear pic">
					<span class="tit">图片:</span>
					<input type="text" readonly="readonly" class="pic_url">
					<div class="file" id="files">
                        <div id="container" class="container containers tgpic_item" style="margin-top: 2px;">
                            <button class="browse" type="button" id="browse" style="z-index: 2;">浏览...</button>
                            <input type="hidden" value="0" class="idcardz upload_status">
                            <input type="hidden" value="" id="addpic" name="" class="card_pic">
	                        <div id="html5_1blcujl1i1aq473k78i1musjpe3_container" class="moxie-shim moxie-shim-html5" style="position: absolute; top: 0px; left: 0px; overflow: hidden; z-index: 1;">
	                            <input id="html5_1blcujl1i1aq473k78i1musjpe3" type="file" style="font-size: 999px; opacity: 0; position: absolute; top: 0px; left: 0px; width: 100%; height: 100%;" multiple="" accept="image/jpeg,.JPG,.JPEG,.PNG,image/png">
	                        </div>
                        </div>
                    </div>
				</div>
				<p class="clear sort">
					<span class="tit">排序:</span>
					<select>
						<option value="">请选择对应的位置</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
						<option value="6">6</option>
						<option value="7">7</option>
						<option value="8">8</option>
					</select>
				</p>
            </div>
            <div class="modal-footer">
                <span  id="savebut" style="margin-right: 100px;color: white;">确定</span>
                <span data-dismiss="modal" style="color: white;">取消</span>
                <input type="hidden" name="">
                <input type="hidden" name="">
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
			<div class="cont">确定要禁用该条数据吗？</div>
			<div class="modal-footer">
				<span  id="savebut1" style="margin-right: 100px;color: white;"  data-dismiss="modal">确定</span>
	            <span data-dismiss="modal" style="color: white;">取消</span>
	            <input type="hidden" name="">
	            <input type="hidden" name="">
	        </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
			<div class="cont">确定要使用该条数据吗？</div>
			<div class="modal-footer">
				<span  id="savebut2" style="margin-right: 100px;color: white;"  data-dismiss="modal">确定</span>
	            <span data-dismiss="modal" style="color: white;">取消</span>
	            <input type="hidden" name="">
	            <input type="hidden" name="">
	        </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
			<div class="cont">确定要删除该条数据吗？</div>
			<div class="modal-footer">
				<span  id="savebut3" style="margin-right: 100px;color: white;"  data-dismiss="modal">确定</span>
	            <span data-dismiss="modal" style="color: white;">取消</span>
	            <input type="hidden" name="">
	            <input type="hidden" name="">
	        </div>
        </div>
    </div>
</div>