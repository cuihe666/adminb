<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>专题列表</title>
	<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/zcoperation/css/tg_reset.css">
	<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/zcoperation/css/subjectList.css">
	<script src="<?= Yii::$app->request->baseUrl ?>/zcoperation/js/lib/jquery-1.11.3.min.js"></script>
	<script src="<?= Yii::$app->request->baseUrl ?>/zcoperation/js/lib/pagination.js"></script>
	<script src="<?= Yii::$app->request->baseUrl ?>/zcoperation/js/lib/base.js"></script>
	<script src="<?= Yii::$app->request->baseUrl ?>/zcoperation/js/custorm/subjectList.js"></script>
</head>
<body>
	<div class="zc_page_wp">
		<div class="curr_postion">当前位置：首页  > 运营> 专题管理</div>
		<div class="add_new_sub zc_btn">+新增专题</div>
		<div class="search_wp">
			<span class="sub_thm">专题主题:</span>
			<input type="text" placeholder="搜索关键字" class="search_input srh_name">
			<span class="sub_thm">专题链接:</span>
			<input type="text" placeholder="搜索关键字" class="search_input srh_word">
			<span class="sub_thm">启用状态:</span>
			<select name="" id="use_status" class="search_input">
				<option value="">全部</option>
				<option value="1">已启用</option>
				<option value="2">未启用</option>
			</select>
			<div class="zc_btn search_btn">搜索</div>
		</div>
		<table id="sub_list_wp">
			<thead>
				<th>序号</th>
				<th>专题主题</th>
				<th class="link">专题链接</th>
				<th class="related_time">创建时间</th>
				<th class="related_time">最后修改时间</th>
				<th>状态</th>
				<th>操作人</th>
				<th class="handle">操作</th>
			</thead>
			<tbody id="zc_tbody">
				<!-- <tr>
					<td>01</td>
					<td>78旅行节</td>
					<td class="link">http://lvcheng.tgljweb.com/indexzby/i</td>
					<td class="related_time">2017-06-25 18:14:15</td>
					<td class="related_time">2017-06-25 18:14:15</td>
					<td>启用</td>
					<td>流氓兔</td>
					<td class="handle">
						<span class="fix handleBtn">修改</span>
						<span class="del handleBtn">删除</span>
						<span class="use handleBtn">启用</span>
					</td>
				</tr> -->
			</tbody>
		</table>
		<div class="zc_pagina_wp zc_clear_float">
			<div class="page_per_wp">
				<span>每页显示条数：</span>
				<select name="" id="p_size">
					<option value="10">10</option>
					<option value="15">15</option>
					<option value="30">30</option>
					<option value="50">50</option>
				</select>
			</div>
			<div class="right_side zc_clear_float">
				<div id="first_page" class="p_btn">首页</div>
				<div class="zc_pagination" id="zc_pagination"></div>
				<div id="last_page" class="p_btn">末页</div>
			</div>
		</div>
		
	</div>
	<div class="confirm_wp">	
		<div class="del_thm">
			<div class="word">确定删除这条数据吗？</div>
			<div class="sure" data-id='' id="confm_sure">确定</div>
			<div class="cancel" id="confm_cancel">取消</div>
		</div>
		<div class="masker"></div>
	</div>
	
</body>
</html>