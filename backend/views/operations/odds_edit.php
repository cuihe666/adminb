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
	<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/zcoperation/js/lib/jquery.min.js"></script>
	<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/zcoperation/js/lib/newbase.js"></script>
	<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/zcoperation/js/lib/layer/layer.js"></script>
	<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/zcoperation/js/custorm/odds_edit.js"></script>
	<script src="http://cdn.staticfile.org/Plupload/2.1.1/plupload.full.min.js"></script>
	<script src="https://cdn.staticfile.org/qiniu-js-sdk/1.0.14-beta/qiniu.js"></script>
	<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/zcoperation/js/lib/My97DatePicker/WdatePicker.js"></script>
	<style type="text/css">
		img{
			display: block;
			width: 150px;
			height: 100px;
			margin: 0 auto;
		}
		td a{
			margin-right: 10px
		}
		#myModal1 .cont, #myModal2 .cont, #myModal3 .cont{
			text-align: center;
			font-size: 18px;
			padding: 50px;
		}
		.pic_url{
			display: inline-block;
			width: 260px;
			height: 30px;
			line-height: 30px;
			margin-right: 10px;
			border: 1px solid #efefef;
			float: left;
		}
		.file{
			float: left;
			width: 100px;
			height: 32px;
		}
		.file button{
			padding: 2px 10px;
			color: white;
			background: #1888F8;
			border: 1px solid #efefef;
		}
		.pic .tit{
			display: block;
			float: left;
			width: 80px;
			height: 30px;
			line-height: 30px;
			margin-right: 10px;
			text-align: right;
		}
		#d422, #d4312{
			width: 150px;
		}
	</style>
</head>
<body>
	<div class="main">
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
					<td style="width: 10%" class="td2">产品ID</td>
					<td style="width: 10%" class="td3">价格</td>
					<td style="width: 25%" class="td4">预览</td>
					<td style="width: 10%" class="td6">状态</td>
					<td style="width: 15%" class="td7">更改时间</td>
					<td style="width: 10%" class="td8">操作人</td>
					<td style="width: 15%" class="td9">操作</td>
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
				<p class="clear jump_type">
					<span class="tit">产品分类:</span>
					<select id="jump_type">
						<option value="0">请选择产品分类</option>
						<option value="12">民宿产品详情</option>
						<option value="15">酒店产品详情</option>
						<option value="18">旅游产品详情</option>
					</select>
					<select class="travel_type" style="margin-left: 10px;">
						<option value="1">主题线路</option>
						<option value="2">当地活动</option>
<!--						<option value="4">游记攻略</option>-->
<!--						<option value="3">印象笔记</option>-->
<!--						<option value="7">当地向导</option>-->
					</select>
				</p>
				<p class="clear">
					<span class="tit">产品id:</span>
					<input onkeyup="$(this).val($(this).val().replace(/[^1234567890]+/g,''))" class="linkurl" type="text" placeholder="请填写产品ID" name="">
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
				<p class="clear">
					<span class="tit">获取价格:</span>
					<input id="d422" name="" value="" class="Wdate addpla" type="text" onfocus="var d4312=$dp.$('d4312');WdatePicker({readOnly:true,minDate:'%y-%M-{%d}',onpicked:function(){d4312.focus()}})" placeholder="请设置起始日期"/>至
                	<input id="d4312" class="Wdate addpla"  name="" value="" type="text" placeholder="请设置结束日期" onFocus="WdatePicker({minDate:'#F{$dp.$D(\'d422\')}',readOnly:true,maxDate:'#F{$dp.$D(\'d422\',{d:+7})}'})"/>     
				</p>
				<p class="clear">
					<span class="tit">原价:</span>
					<input class="price" type="text" onkeyup="$(this).val($(this).val().replace(/[^1234567890]+/g,''))" name="" placeholder="请填写产品原价">
				</p>
            </div>
            <div class="modal-footer">
                <span  id="savebut" style="margin-right: 100px;color: white;">确定</span>
<!--                <span  id="savebut" style="margin-right: 100px;color: white;"  data-dismiss="modal">确定</span>-->
                <span data-dismiss="modal" style="">取消</span>
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
	            <span data-dismiss="modal" style="">取消</span>
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
	            <span data-dismiss="modal" style="">取消</span>
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
	            <span data-dismiss="modal" style="">取消</span>
				<input type="hidden" name="">
				<input type="hidden" name="">
	        </div>
        </div>
    </div>
</div>

