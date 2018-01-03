<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>页面编辑</title>
	<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/zcoperation/css/tg_reset.css">
	<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/zcoperation/css/pageEditor.css">
	<script src="<?= Yii::$app->request->baseUrl ?>/zcoperation/js/lib/jquery-1.11.3.min.js"></script>
	<script src="<?= Yii::$app->request->baseUrl ?>/zcoperation/js/lib/base.js"></script>
	<script src="<?= Yii::$app->request->baseUrl ?>/zcoperation/js/lib/plupload.full.min.js"></script>
	<script src="<?= Yii::$app->request->baseUrl ?>/zcoperation/js/lib/qiniu.min.js"></script>
	<script type="text/javascript">
		var adminId = '<?=Yii::$app->user->getId();?>';
	</script>
	<script src="<?= Yii::$app->request->baseUrl ?>/zcoperation/js/custorm/pageEditor.js"></script>

	<!-- <script src="../js/lib/jquery-1.11.3.min.js"></script> -->
	<!-- <script src="../js/lib/base.js"></script> -->
	<!-- <script src="../js/lib/plupload.full.min.js"></script> -->
	<!-- <script src="../js/lib/qiniu.min.js"></script> -->
	<!-- <script src="../js/custorm/pageEditor.js"></script> -->

</head>
<body>
	<div class="zc_page_wp">
		<div class="curr_postion">当前位置：首页  > 运营> 专题管理</div>
		<div class="tw_div_manger zc_clear_float">
			<div class="zc_editor_wp zc_operate_wp" id="zc_editor_wp"><!-- 左侧编辑区 -->
				<div class="content_dis">
					<div class="header zc_clear_float">
						<div class="pageEditor on">页面编辑</div>
						<div class="moduleSet">组件设置</div>
					</div>
					<div class="tab_body">
						<div class="zhuanti_wp ctrl_p show_out may_show_out"> <!-- 专题页整体设置 -->
							<p>
								<span>专题名称：</span>
								<input type="text" placeholder="专题名称" class="zc_input_sel" id="sub_name">
							</p>
							<p>
								<span>自定义链接：</span>
								<input style="background: #ccc" type="text" placeholder="链接地址" class="zc_input_sel" id="diy_link" value="http://sales.tgljweb.com/index.html" readonly>
							</p>
							<p>
								<span>分享专题：</span>
								<input type="text" placeholder="分享专题" class="zc_input_sel" id="share_sub">
							</p>
							<p>
								<span>文案颜色：</span>
								<input type="text" placeholder="请添加色值" class="zc_input_sel" id="word_color">
							</p>
							<p>
								<span>底色：</span>
								<input type="text" placeholder="请添加色值" class="zc_input_sel" id="bg_color">
							</p>
							<p>
								<span>返回顶部：</span>
								<label >是<input gototop="0" type="radio" id="isTrue" value="是" name="asdfg" class="sd_input_mr" checked></label>
								<label >否<input gototop="1" type="radio" id="isFalse" value="否" name="asdfg"></label>
							</p>
						</div>
						<div class="zj_set_wp">
							
						</div>
					</div>
					
					<div class="evy_zj_wp ctrl_p"> <!-- 所有的组件包裹容器，对应组件添加show_out显示 -->
						<div class="banner_zj page_zj may_show_out ctrl_p" data-type="banner"><!-- show_out  --><!-- banner组件 -->
							
							<div class="slider_wp">
								<p>
									<span>锚点位置：</span>
									<input type="text" placeholder="请输入与导航对应的锚点" class="zc_input_sel ban_anchor">
								</p>
								<div class="evy_slider zc_clear_float left_right_wp">
									
									<div class="slider_left">
										<p>
											<span>标题：</span>
											<input type="text" placeholder="请填写标题" class="ban_title">
										</p>
										<div>
											<span>跳转类型：</span>
											<select name="" id="" class="zc_input_sel slider_select jump_type_sel">
												<option value="0">请选择跳转类型</option>
												<option value="1">H5</option>
												<option value="2">民宿产品详情</option>
												<option value="3">酒店产品详情</option>
												<option value="4">旅游产品详情</option>
												<option value="5">民宿列表(城市分)</option>
												<option value="6">酒店列表(城市分)</option>
												<option value="7">旅游列表(城市分)</option>
											</select>
											<select name="" class="travel_types"><!-- show_out如果是旅游产品显示该下拉框 -->
												<option value="3">主题线路</option>
												<option value="2">当地活动</option>
												<option value="5">当地向导</option>
												<option value="7">印象随笔</option>
												<option value="8">游记攻略</option>
											</select>
											<div class="alllist">
												<div>
													<select name="" id="" class="three_city zc_country">
														<option value="0">请选择国家</option>
													</select>
												</div>
												<div>
													<select name="" id="" class="three_city zc_province"><!-- jleftwidth -->
														<option value="0">请选择省</option>
													</select>
												</div>
												<div>
													<select name="" id="" class="three_city zc_area"><!-- jleftwidth -->
														<option value="0">请选择市</option>
													</select>
												</div>
											</div>
										</div>

										<p>
											<span>跳转链接：</span>
											<input type="text" placeholder="请输入链接地址或者id" class="zc_input_sel jump_link">
										</p>
										<p>
											<span>数据监测：</span>
											<input type="text" class="zc_input_sel data_check">
										</p>
										<p class="img_module">
											
											<span class="upload_div up_css">
												+选择图片
												<button class="banner_upload_btn zc_upload_btn qiniuBtn"  ></button>
											</span>
											<span><img src="<?= Yii::$app->request->baseUrl ?>/zcoperation/img/zc_select.png" class="zc_select zcQiniuImg"></span>
										</p>
									</div>
									<div class="slider_right">删除</div>
								</div>

							</div>
							<div class="add_one_banner zc_btn">+新增轮播</div>
						</div>
						<div class="img_zj page_zj may_show_out ctrl_p" data-type='ads'><!-- show_out --><!-- 广告热区组件 -->
							<div class="hot_img_wp">
								<img src="<?= Yii::$app->request->baseUrl ?>/zcoperation/img/zc_select.png" class="zc_select zcQiniuImg">
								<div class="img_masker"></div>
							</div>
							<p class="img_module">
								<span class="upload_div up_css">
									+选择图片
									<button type="file" name="" class="img_upload_btn zc_upload_btn qiniuBtn"></button>
								</span>
							</p>
							<p class="hot_set">
								<span>设置热区：</span>
								<label data-val="allPic" class="hot_lab all_pic on">全图<!-- <input type="radio" name="hot_area" checked class="sd_input_mr"> --></label><!-- hot_area_all -->
								<label data-val="noHot" class="hot_lab no_hot">无<!-- <input type="radio" name="hot_area" id=""> --></label>
								<label data-val="divide" class="hot_lab zone">分区</label>
								<span id="" class="add_new_aera zc_btn">+新增热区</span>
							</p>
							<p>
								<span>锚点位置：</span>
								<input type="text" placeholder="请输入与导航对应的锚点" class="zc_input_sel ads_anchor">
							</p>
							<div class="hot_type_wp zc_clear_float left_right_wp show_out"> <!-- 左右结构包裹 -->
								<div class="slider_left">
									<div class="get_area">点击此区域划定热区</div>
									<div class="jump_type_wp">
										<span class="type_word jleftwidth">跳转类型：</span>
										<select name="" id=""  class="zc_input_sel jump_type_sel" >
											<option value="10">请选择跳转类型</option>
											<option value="0">H5</option>
											<option value="1">礼券</option>
											<option value="2">民宿产品详情</option>
											<option value="3">酒店产品详情</option>
											<option value="4">旅游产品详情</option>
											<option value="5">民宿列表(城市分)</option>
											<option value="6">酒店列表(城市分)</option>
											<option value="7">旅游列表(城市分)</option>
										</select>
										<select name="" class="travel_types"><!-- show_out如果是旅游产品显示该下拉框 -->
											<option value="3">主题线路</option>
											<option value="2">当地活动</option>
											<option value="5">当地向导</option>
											<option value="7">印象随笔</option>
											<option value="8">游记攻略</option>
										</select>
										<div class="alllist">
											<div>
												<select name="" id="" class="three_city zc_country">
													<option value="0">请选择国家</option>
												</select>
											</div>
											<div>
												<select name="" id="" class="three_city zc_province"><!-- jleftwidth -->
													<option value="0">请选择省</option>
												</select>
											</div>
											<div>
												<select name="" id="" class="three_city zc_area"><!-- jleftwidth -->
													<option value="0">请选择市</option>
												</select>
											</div>
										</div>
										<p class="success_word_wp gift_word">
											<span class="success_wd jleftwidth ">成功文案：</span>
											<input type="text" class="success_input zc_input_sel" placeholder="请填写领取成功的文案">
										</p>
										<p class="fail_word_wp gift_word">
											<span class="fail_wd jleftwidth ">失败文案：</span>
											<input type="text" class="fail_input zc_input_sel" placeholder="请填写领取失败的文案">
										</p>
									</div>
									<p>
										<span id="" class="jleftwidth href_id">跳转链接：</span> <!-- 可根据条件切换为礼品券id -->
										<input type="text" placeholder="跳转链接或产品id" class="zc_input_sel jump_link">
									</p>
									<p>
										<span class="jleftwidth">数据监测：</span>
										<input type="text" class="zc_input_sel data_check">
									</p>
								</div>
								<div class="slider_right">删除</div>
							</div>
						</div>
						<div class="single_zj page_zj may_show_out ctrl_p" data-type='sgl'><!-- show_out --><!-- 单品组件 -->
							<div class="pailietype">
								<span>产品排列方式:</span>
								<label data-val="wide" class="sd_input_mr fake on" >宽</label>
								<label data-val="narrow" class="fake">窄</label>
							</div>
							<div class="add_one_tab zc_btn">+新增tab</div>
							<p>
								<span>锚点位置：</span>
								<input type="text" placeholder="请输入与导航对应的锚点" class="zc_input_sel sgl_anchor">
							</p>
								
								<div class="evy_single_pdt zc_clear_float left_right_wp"><!-- 单品组件下的单品包裹 -->
									<div class="slider_left">
										<p>
											<span class="jleftwidth">tab签：</span>
											<input type="text" placeholder="请填写tab签" class="zc_input_sel tab_label_name">
										</p>
										<p>
											<span class="jleftwidth">数据监测：</span>
											<input type="text" class="zc_input_sel data_check">
										</p>
										<div class="pdt_filter_wp"><!-- 每一个产品的容器，点击新增时添加一个产品 -->
											<div class="evy_filtered"> <!-- 每一个产品的模板 -->
												<p>
													<span class="jleftwidth wd80">产品类型：</span>
													<select name="" id="" class="single_pdt_sel zxcv">
														<option value="0">请选择分类</option>
														<option value="1">民宿产品详情</option>
														<option value="2">酒店产品详情</option>
														<option value="3">旅游产品详情</option>
													</select>
													<select name="" class="travel_types"><!-- show_out如果是旅游产品显示该下拉框 -->
														<option value="3">主题线路</option>
														<option value="2">当地活动</option>
														<option value="5">当地向导</option>
														<option value="7">印象随笔</option>
														<option value="8">游记攻略</option>
													</select>
												</p>
												<p>
													<span class="ml5 wd80">添加产品id：</span>
													<textarea class="ml5 pdtid" name="" cols="30" rows="10" placeholder="添加产品id：多个用‘|’隔开"></textarea>
												</p>
												<div class="del_onepdt_btn">X</div>
											</div>
										</div>
										<div class="add_one_pdt zc_btn">+新增产品</div>
									</div>
									<div class="slider_right">删除</div>
							</div>
						</div>
						<div class="nav_zj page_zj may_show_out ctrl_p" data-type='nav'><!-- show_out --><!-- 导航组件 -->
							<p class="ishang">
								<span>是否悬浮：</span>
								<label data-val='yes' class="sd_input_mr fake" >是</label>
								<label data-val='no'  class="isxflab fake on">否</label>
							</p>
							<p class="isnavtype">
								<span>导航类型：</span>
								<label data-val="horizontal" class="sd_input_mr fake">横向</label>
								<label data-val="aside" class="fake on">边侧</label>
							</p>
							<p class="img_module">
								<span class="upload_div up_css">
									+选择图片
									<button type="file" name="" class="zc_upload_btn qiniuBtn"></button><!--  id="nav_upload_btn"  -->
								</span>
								<span><img src="<?= Yii::$app->request->baseUrl ?>/zcoperation/img/zc_select.png" class="zc_select zcQiniuImg"></span>
							</p>
							<div class="add_one_anchor zc_btn">+新增锚点</div>
							<div class="anchor_wp"><!-- 导航组件下的导航锚点包裹 -->
								<div class="evy_nav zc_clear_float left_right_wp">
									<div class="slider_left">
										<p>
											<span>锚点名称：</span>
											<input type="text" class="anchor_name">
										</p>
										<p>
											<span>锚点位置：</span>
											<input type="text" placeholder="请填写锚点位置" class="anchor_loc">
										</p>
									</div>
									<div class="slider_right">删除</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="btn_dis cnt_btn_wp">
					<div class="zj_sure zc_btn" id="page_left_sure">确认</div>
					<div class="zj_cancle zc_btn">取消</div>
				</div>
			</div>
			<div class="zc_scan_wp zc_operate_wp" id="zc_scan_wp"> <!-- 右侧浏览区 -->
				<div class="content_dis" id="scan_area_cnt"> <!-- 右侧浏览区内容 -->
					
				</div>
				<div class="btn_dis"> <!-- 右侧浏览区底部按钮 -->
					<div id="zj_set_wp" class="zc_clear_float">
						<div class="set_word fl_zj" >添加组件：</div>

						<select name="" id="selest_zj" class="fl_zj">
							<option value="10">请选择组件</option>
							<option value="0">banner图</option>
							<option value="1">图片广告区</option>
							<option value="2">单品</option>
							<option value="3">导航</option>
						</select>
						<div class="add_btn zc_btn fl_zj" id="module_btn">添加</div>
					</div>
				</div>
				
			</div>
		</div>
		<div class="end_btn zc_clear_float">
			<div class="page_sure_btn">提交保存</div>
			<div class="page_cancel_btn">取消</div>
		</div>
	</div>
	<div class="mdl_name_wp">
		<div class="mdl_name">
			<div class="mdl_word"></div>
			<div class="mdl_handle">
				<ul>
					<li class="moveup">上移</li>
					<li class="movedown">下移</li>
					<li class="thiseditor">编辑</li>
					<li class="thisdel">删除</li>
				</ul>
			</div>
		</div>
	</div>
	
	
	<div class="editing_curr_mdl"></div>
</body>
</html>
<!-- 
<template class="up_img">
	<p class="img_module">
		<span class="upload_div up_css">
			+选择图片
			<input type="file" name="" id="banner_upload_btn" class="zc_upload_btn">
		</span>
		<span><img src="../img/zc_select.png" class="zc_select"></span>
	</p>
</template>
<template>
	<p>
		<span>锚点位置：</span>
		<input type="text" placeholder="请输入与导航对应的锚点" class="zc_input_sel">
	</p>
</template>
<template>
	<p>
		<span>数据监测：</span>
		<input type="text" class="zc_input_sel">
	</p>
</template> -->
