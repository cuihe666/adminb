<?php
use yii\helpers\Url;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/haoqiao/css/hq_setting.css">
	<script type="text/javascript">
		// 获取操作人ID
		var adminId = '<?=Yii::$app->user->getId();?>';
	</script>
</head>
<body>
	<div class="main">
		<p>好巧</p>
		<div class="set">
			<div>
				<span class="partener">合伙人是否分成:</span>
				<select class="divide_into" style="margin-right: 40px;">
					<option value="0">是</option>
					<option value="1">否</option>
				</select>
			</div>
			<button class="save_btn">保存设置</button>
		</div>
		<div style="clear: both;"></div>
	</div>
	<div class="loading_wrap" style="position: absolute;left: 0;top: 0;background: rgba(250,251,250,0.6);width: 100%;height: 99%;text-align: center;padding-top: 15%;box-sizing: border-box">
		<img src="<?= Yii::$app->request->baseUrl ?>/haoqiao/lib/img/loading.gif" />
	</div>
</body>
<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/TC-housing-resource/lib/js/base.js"></script>
<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/TC-housing-resource/lib/layer/layer.js"></script>
<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/haoqiao/js/hq_setting.js"></script>
</html>