<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<script type="text/javascript">
		var adminId = '<?=Yii::$app->user->getId();?>';
	</script>
	<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/zcoperation/css/reset.css">
	<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/zcoperation/css/index.css">
	<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/zcoperation/js/lib/jquery.min.js"></script>
	<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/zcoperation/js/lib/newbase.js"></script>
	<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/zcoperation/js/lib/layer/layer.js"></script>
	<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/zcoperation/js/custorm/index.js"></script>
</head>
<body>
	<div class="main clear">
		<div class="t_header">
			<h4>当前位置 : &nbsp;运营&nbsp;>&nbsp;运营位管理</h4>
		</div>
		<div class="cont clear">
			<p class="search">
				<select>
					<option value="1">首页</option>
					<option value="2">旅行首页</option>
					<option value="3">民宿首页</option>
					<option value="4">城市列表页</option>
				</select>
			</p>
			<div class="tab">
				<table class="table table-bordered">
					<thead>
						<td style="width: 20%" class="td1">位置名称</td>
						<td style="width: 50%" class="td2">描述</td>
						<td style="width: 30%" class="td3">操作</td>
					</thead>
				</table>
			</div>
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
				信息<span data-dismiss="modal">X</span>
        	</div>
            <div class="conts">您确定操作吗？</div>
            <div class="modal-footer">
                <span style="margin-right: 100px;background: white;"  data-dismiss="modal">取消</span>
                <span  id="savebut" data-dismiss="modal" style="color: white;">确定</span>
                <input type="hidden" name="">
            </div>
        </div>
    </div>
</div>