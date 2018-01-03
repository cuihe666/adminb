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
	<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/zcoperation/css/jquery.pagination.css">
	<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/zcoperation/css/reset.css">
	<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/zcoperation/css/app_push.css">
	<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/zcoperation/js/lib/jquery.min.js"></script>
	<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/zcoperation/js/lib/newbase.js"></script>
	<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/zcoperation/js/lib/layer/layer.js"></script>
	<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/zcoperation/js/lib/jquery.pagination.min.js"></script>
	<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/zcoperation/js/custorm/app_push.js"></script>
</head>
<body>
	<div class="main clear">
		<h4>当前位置:首页 > 运营 > App Push</h4>
		<p class="search">
			<input class="key_words" type="text" placeholder="请填写关键字"/> 
			<input class="words_btn" type="button" value="搜索">
		</p>
		<p class="add_new">
			<a href="<?= Url::toRoute(['operations/add_new_push','a'=>0]) ?>"><span class="glyphicon glyphicon-plus"></span>新增</a>
		</p>
		<div class="cont clear">
			<table class="table table-bordered" style="margin-bottom: 0">
				<thead>
					<td style="width: 5%" class="td1">序号</td>
					<td style="width: 15%" class="td2">创建时间</td>
					<td style="width: 15%" class="td3">主题</td>
					<td style="width: 25%" class="td4">内容</td>
					<td style="width: 14%" class="td5">发送时间</td>
					<td style="width: 6%" class="td6">状态</td>
					<td style="width: 6%" class="td7">操作人</td>
					<td style="width: 14%" class="td8">操作</td>
				</thead>
			</table>
			<div style="border: 1px solid #efefef; margin: 2px 0px; text-align: center;font-size: 16px;line-height: 30px;width: 1200px;display: none;">暂时没有信息</div>
			<div class="load" style="text-align: center;width: 1200px;line-height: 30px">数据正在加载....</div>
			<div class="footer" style="margin-top: 20px;background: white;border: none;">
				<div class="ape_page">
					<span>每页显示条数</span>
					<select onkeyup="this.blur();this.focus();">
						<option value="15">15</option>
						<option value="30" selected="selected">30</option>
						<option value="50">50</option>
					</select>
				</div>
				<div class="fen">
					<div id="pagination" class="page fl"></div>
					<span class="page_num">共1页</span>
				</div>
			</div>
			<input type="hidden" value="<?= Url::toRoute(['operations/add_new_push', 'a' =>1,'uid' =>'']) ?>" class="edit_a"/>
		</div>
	</div>
</body>
<!-- 弹窗 -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="conts">确定禁用此push吗？</div>
            <div class="modal-footer">
                <span style="margin-right: 100px;color: white;background: #ccc;"  data-dismiss="modal">取消</span>
                <span  id="savebut" data-dismiss="modal" style="color: white;">确定</span>
                <input type="hidden" name="">
                <input type="hidden" name="">
                <input type="hidden" name="">
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="conts">确定启用此push吗？</div>
            <div class="modal-footer">
                <span style="margin-right: 100px;background: #ccc;"  data-dismiss="modal">取消</span>
                <span  id="savebut1" data-dismiss="modal" style="color: white;">确定</span>
                <input type="hidden" name="">
                <input type="hidden" name="">
                <input type="hidden" name="">
            </div>
        </div>
    </div>
</div>
</html>