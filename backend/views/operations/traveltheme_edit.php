<?php
use yii\helpers\Url;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>旅游主题线路</title>
	<script type="text/javascript">
		var adminId = '<?=Yii::$app->user->getId();?>';
	</script>
	<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/zcoperation/css/reset.css">
	<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/zcoperation/css/common.css">
	<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/zcoperation/css/upload_img.css">
	<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/zcoperation/css/main.css">
	<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/zcoperation/css/travelTheme_edit.css">
	<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/zcoperation/js/lib/jquery.min.js"></script>
	<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/zcoperation/js/lib/newbase.js"></script>
	<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/zcoperation/js/lib/layer/layer.js"></script>
	<script src="http://cdn.staticfile.org/Plupload/2.1.1/plupload.full.min.js"></script>
	<script src="https://cdn.staticfile.org/qiniu-js-sdk/1.0.14-beta/qiniu.js"></script>
	<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/zcoperation/js/custorm/upload_img.js"></script>
	<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/zcoperation/js/custorm/main.js"></script>
	<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/zcoperation/js/custorm/travelTheme_edit.js"></script>
    <script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/zcoperation/js/custorm/alert.js"></script>

</head>
<body>
<div class="col-xs-12 col-sm-12 col-mg-12 main star_edit">
	<div class="t_header">
		<h4>当前位置 : &nbsp;运营&nbsp;>&nbsp;<a href="<?= Url::toRoute('operations/operationslocat') ?>">运营位管理</a>&nbsp;>&nbsp;<span class="tite">主题线路分类</span></h4>
	</div>
	<div class="conts clear ">
		<p class="add_new">
			<!--<a data-target="#myModal" data-toggle="modal" class="btn btn-primary"><span class="glyphicon glyphicon-plus" style="margin-right: 6px"></span>新增</a>-->
			<a href="#"  class="btn btn-primary"  data-toggle="modal" onclick="addTravel()"><span class="glyphicon glyphicon-plus" style="margin-right: 6px"></span>新增</a>
		</p>
		<div class="travelTheme">
			<div class="edit_table">
				<table class="table table-bordered">
					<thead >
					<thead >
					<tr >
						<th>序号</th>
						<th>分类名称</th>
						<th >更改时间</th>
						<th >位置排序</th>
						<th >状态</th>
						<th>操作人</th>
						<th>操作</th>
					</tr>
					</thead>
					<tbody class="star_con">

					</tbody>
				</table>
				<div class="loading"></div>
			</div>
		</div>

	</div>
</div>


<div class="modal fade travelThemeModal" id="myModal_add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<span  class="travelThemeModalName">新增</span>
				<span><a onclick="addGoods()"><i class="glyphicon glyphicon-plus"></i>新增商品</a></span>
			</div>
			<div class="cont clear">
				<div class="travelTop">
					<div class="travelTopCon">
						<div  class="cityList common">
							<p>
								<span class="tit">城市名称：</span>
								<select class="country">
									<option value="0">国家</option>
								</select>
								<select  class="province">
									<option value="0">省份</option>
								</select>
								<select class="city">
									<option value="0">市</option>
								</select>
							</p>
						</div>
						<div class="list1 selectSort ">
								<span class="tit">排序:</span>
								<select class="sort">
									<option value="0">请选择对应的位置</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
								</select>
						</div>
					</div>
					<p class="msg">
						<span class="tit"></span>
						<span class="msgTxt"></span>
					</p>
				</div>
				<table class="table table-bordered ">

				</table>

			</div>
			<div class="modal-footer">
				<span  type="button"  class="btn btn-default sureBtn updateStar edit" onclick=" _editTravel()" >确定</span>
				<span   type="button"   class="btn btn-default sureBtn updateStar add" onclick=" _addTravel()" >确定</span>
				<span  class="btn btn-default cancelBtn" id="savebut" data-dismiss="modal" style="">取消</span>
			</div>
		</div>
	</div>

</div>






</body>
</html>