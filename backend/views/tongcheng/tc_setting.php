<?php
use yii\helpers\Url;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/TC-housing-resource/css/TC_setting.css">
	<script type="text/javascript">
		var adminId = '<?=Yii::$app->user->getId();?>';
	</script>
</head>
<body>
	<div class="main">
		<p>同程</p>
		<div class="set">
			<div>
				<span class="partener">合伙人是否分成:</span><select class="divide_into" style="margin-right: 40px;"><option value="0">否</option></select><span>加价比例:</span><input type="text" name="add_price" style="margin-right: 10px">%
			</div>
			<button class="save_btn">保存设置</button>
		</div>
		<div style="clear: both;"></div>
	</div>
</body>
<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/TC-housing-resource/lib/js/jquery.js"></script>
<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/TC-housing-resource/lib/js/base.js"></script>
<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/TC-housing-resource/lib/layer/layer.js"></script>
<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/TC-housing-resource/js/TC_setting.js"></script>
</html>