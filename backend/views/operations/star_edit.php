<?php
use yii\helpers\Url;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>达人编辑</title>
	<script type="text/javascript">
		var adminId = '<?=Yii::$app->user->getId();?>';
	</script>
	<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/zcoperation/css/reset.css">
	<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/zcoperation/css/common.css">
	<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/zcoperation/css/upload_img.css">
	<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/zcoperation/css/main.css">
	<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/zcoperation/css/star_edit.css">
	<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/zcoperation/js/lib/jquery.min.js"></script>
	<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/zcoperation/js/lib/newbase.js"></script>
	<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/zcoperation/js/lib/layer/layer.js"></script>
	<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/zcoperation/js/custorm/main.js"></script>

</head>
<body>
	<div class="col-xs-12 col-sm-12 col-mg-12 main star_edit">
		<div class="t_header">
			<h4>当前位置 : &nbsp;运营&nbsp;>&nbsp;<a href="<?= Url::toRoute('operations/operationslocat') ?>">运营位管理</a>&nbsp;>&nbsp;<span class="tite"></span></h4>
		</div>
		<div class="conts clear  star_edit">
			<p class="add_new">
			<!--<a data-target="#myModal" data-toggle="modal" class="btn btn-primary"><span class="glyphicon glyphicon-plus" style="margin-right: 6px"></span>新增</a>-->
			<a href="#"  class="btn btn-primary"  data-toggle="modal" onclick="addStar()"><span class="glyphicon glyphicon-plus" style="margin-right: 6px"></span>新增</a>
			</p>
			<div class="edit_table">
				<table class="table table-bordered">
					<thead >
					<thead >
					<tr >
						<th  >序号</th>
						<th >达人ID</th>
						<th >预览</th>
						<th >位置排序</th>
						<th >状态</th>
						<th>更改时间</th>
						<th>操作人</th>
						<th>操作</th>
					</tr>
					</thead>
					<tbody class="star_con"></tbody>
				</table>
				<div class="loading"></div>
			</div>
		</div>
	</div>	


	<div class="modal fade" id="myModal_add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					新增
				</div>
				<div class="cont clear">
					<p>
						<span class="tit">达人ID:</span>
						<input type="text" placeholder="请填写达人ID" name="" class="starId">
					</p>

					<div class="clear pic">
						<span class="tit">图片:</span>
						<input type="text" readonly="readonly" class="pic_url">
						<div class="file" id="files">
							<div id="container" class="container containers tgpic_item" style="margin-top: 2px;width: 120px;">
								<button class="browse" type="button" id="browse" style="z-index: 2;">浏览...</button>
								<input type="hidden" value="0" class="idcardz upload_status">
								<input type="hidden" value="" id="addpic" name="" class="card_pic">
								<div id="html5_1blcujl1i1aq473k78i1musjpe3_container" class="moxie-shim moxie-shim-html5" style="position: absolute; top: 0px; left: 0px; overflow: hidden; z-index: 1;">
									<input id="html5_1blcujl1i1aq473k78i1musjpe3" type="file" style="font-size: 999px; opacity: 0; position: absolute; top: 0px; left: 0px; width: 100%; height: 100%;" multiple="" accept="image/jpeg,.JPG,.JPEG,.PNG,image/png">
								</div>
							</div>
						</div>
					</div>

					<p class="clear sortList">
						<span class="tit">排序:</span>
						<select class="sort">
							<option value="">请选择对应的位置</option>
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
						</select>
					</p>
				</div>
				<div class="modal-footer">
					<span style="margin-right: 100px;color: white;"  type="button"   class="btn btn-default sureBtn updateStar edit" onclick=" _editStar()" >确定</span>
					<span style="margin-right: 100px;color: white;"  type="button"   class="btn btn-default  sureBtn updateStar add" onclick=" _addStar()" >确定</span>
					<span class="btn btn-default cancelBtn"  id="savebut" data-dismiss="modal" style="">取消</span>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/zcoperation/js/custorm/alert.js"></script>

	<script src="http://cdn.staticfile.org/Plupload/2.1.1/plupload.full.min.js"></script>
	<script src="https://cdn.staticfile.org/qiniu-js-sdk/1.0.14-beta/qiniu.js"></script>
	<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/zcoperation/js/custorm/upload_img.js"></script>

	<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/zcoperation/js/custorm/star_edit.js"></script>
</body>
</html>