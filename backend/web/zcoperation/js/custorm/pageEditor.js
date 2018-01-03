$(function() {
	/* */
	var httpUrl = serveUrl();
	var zcQiuTokenUrl = httpUrl + '/api/qiniu/getqiniutoken'; //七牛uptoken_url接口
	var countryUrl = httpUrl+'/api/subject/getHotCountries'; //获取热门国家列表
	var provinceUrl = httpUrl+'/api/subject/getCityList';//根据父类ID获取城市列表接口
	var addSubUrl = httpUrl+'/api/subject/saveSubject';//新增专题主题接口
	var fixthmUrl = httpUrl+'/api/subject/getSubjectByid';//修改某一专题（依据id）
	var moduleIndex = 0 ;
	var subId = zcGetLocationParm('id');
	var mdlObj = {
		0:'banner组件',
		1:'图片广告区组件',
		2:'单品组件',
		3:'导航组件'
	};
	var typeFun = {
		'banner':zcBannerFn,
		'sgl'   :zcSglFn,
		'ads'   :zcAdsFn,
		'nav'   :zcNavFn
	};
	var renderTypeFn = {
		'banner':renderZcBannerFn,
		'sgl'   :renderZcSglFn,
		'ads'   :renderZcAdsFn,
		'nav'   :renderZcNavFn
	};

	var type_arr= [
		{val:0,txt:'请选择跳转类型'},                                                          
		{val:1,txt:'H5'},                                                          
		{val:2,txt:'民宿产品详情'},                                                          
		{val:3,txt:'酒店产品详情'},                                                          
		{val:4,txt:'旅游产品详情'},                                                          
		{val:5,txt:'民宿列表(城市分)'},                                                          
		{val:6,txt:'酒店列表(城市分)'},                                                          
		{val:7,txt:'旅游列表(城市分)'}                                                          
	];

	var hot_type_arr = [
		{val:10,txt:'请选择跳转类型'},                                                          
		{val:0,txt:'H5'},                                                          
		{val:1,txt:'礼券'},                                                          
		{val:2,txt:'民宿产品详情'},                                                          
		{val:3,txt:'酒店产品详情'},                                                          
		{val:4,txt:'旅游产品详情'},                                                          
		{val:5,txt:'民宿列表(城市分)'},                                                          
		{val:6,txt:'酒店列表(城市分)'},                                                          
		{val:7,txt:'旅游列表(城市分)'}      
	];

	var child_type_arr = [
		{val:3,txt:'主题线路'}, 
		{val:2,txt:'当地活动'}, 
		{val:5,txt:'当地向导'}, 
		{val:7,txt:'印象随笔'}, 
		{val:8,txt:'游记攻略'}
	];
	var detail_arr = [
		{val:0,txt:'请选择分类'},
		{val:1,txt:'民俗产品详情'},
		{val:2,txt:'酒店产品详情'},
		{val:3,txt:'旅游产品详情'}
	];

	var hotLbl = [
		{val:'allPic',cls:'all_pic',htm:'全图'},
		{val:'noHot',cls:'no_hot',htm:'无'},
		{val:'divide',cls:'zone',htm:'分区'}
	];


	var gAddId = 0;
	var getAreaBtnId = 1;//划定热区

	var initList = function() {
	 	bindEvt();
	 	// initCenterDelBtn();
	 	pageTab();
	 	autoLink();
	 	subId&&fixTheme(subId);
	 	
	};

	var bindEvt = function() {
		$('#module_btn').on('click',onAddModuleBtnClk); //添加一个组件
		$('#page_left_sure').on('click',onPageLeftSureClk);//左侧确认按钮点击
		$('.zj_cancle').on('click',onPageLeftCancelClk);//左侧取消按钮点击
		$('#zc_editor_wp').on('click','.add_one_banner',onAddOneBannerTap);//添加一个新轮播
		$('#zc_editor_wp').on('change','.evy_slider .slider_select',4,onSliderSelChange); //下拉框处理（旅游产品详情）
		$('#zc_editor_wp').on('change','.jump_type_sel',4,onSliderSelChange); //下拉框处理（旅游产品详情）
		$('#zc_editor_wp').on('change','.single_pdt_sel',3,onSliderSelChange); //下拉框处理（旅游产品详情）
		$('#zc_editor_wp').on('change','.jump_type_sel',onJumpTypeSelChange); //广告热区下拉框处理（旅游产品详情）
		$('#zc_editor_wp').on('change','.zc_country',onZcCountryChange); //下拉框处理（国家||省份||城市）
		$('#zc_editor_wp').on('change','.zc_province',onZcProvinceChange); //下拉框处理（国家||省份||城市）
		$('#zc_editor_wp').on('click','.slider_right',onSliderRightClk); //删除按钮点击
		$('#zc_editor_wp').on('click','.add_new_aera',onAddNewAeraClk);//添加一个热区
		$('#zc_editor_wp').on('click','.add_one_tab',onAddOneTabClk);//添加一个tab
		$('#zc_editor_wp').on('click','.add_one_pdt',onAddOnePdtClk);//添加一个pdt
		$('#zc_editor_wp').on('click','.add_one_anchor',onAddOneAnchorClk);//添加一个锚点
		$('#zc_editor_wp').on('click','.del_onepdt_btn',onDelOnePdtBtnClk);//删除一个pdt
		$('#zc_scan_wp').on('click','.moveup',onMoveUpClk);//上移动一个元素
		$('#zc_scan_wp').on('click','.movedown',onMoveDownClk);//下移动一个元素
		$('#zc_scan_wp').on('click','.thiseditor',onThiseDitorClk);//编辑一个元素
		$('#zc_scan_wp').on('click','.thisdel',onThisDelClk);//删除一个元素
		$('#zc_editor_wp').on('click','.del_this',onDelThisBtnClk);//删除一个热区
		$('#zc_editor_wp').on('click','.hot_set label',onHotLabelClk);//选择热区是全图||无||分区
		$('#zc_editor_wp').on('click','.get_area',onGetAreaClk);//点击可划定热区
		$('#zc_editor_wp').on('click','.fake',onFakeClk);//label的tab切换
		/*以下是页面保存和修改取消按钮！*/
		$('.page_sure_btn').off('click').on('click',onPageSureBtnClk); //页面信息保存
		$('.page_cancel_btn').off('click').on('click',onPageCancelBtnClk); //页面信息取消
		$('.page_cancel_btn').on('click',onPageCancelBtnClk);//修改取消

	};

	var autoLink = function() {
		var obj={
			'106.14.239.108':'http://testsales.tgljweb.com/index.html',
			'139.196.252.26':'http://presales.tgljweb.com/index.html',//预发布
			'admin.tgljweb.com':'http://sales.tgljweb.com/index.html',//生产
		};
		var head=window.location.hostname;
		$('#diy_link').val(obj[head]);
	};

	var onFakeClk = function() {
		$(this).addClass('on').siblings('.on').removeClass('on');
	};

	function zcBannerFn($obj) {
		var banObj = {type:'banner'};
		var $currSliders = $obj.find('.evy_slider');
		
		banObj.anchorLocaltion = $obj.find('.ban_anchor').val();
		banObj.sliders = [];
		$.each($currSliders, function(i, el) {
			var obj = {};
			obj.linkType = $(el).find('.jump_type_sel').val();//跳转类型
			obj.title = $(el).find('.ban_title').val(); //标题
			obj.jumpLink = $(el).find('.jump_link').val();//id
			obj.dataCheck = $(el).find('.data_check').val();
			obj.pic = $(el).find('.zcQiniuImg').attr('src');
			if(obj.linkType==4) {
				obj.travelSecondType = $(el).find('.travel_types').val();//如果是4则多出travelSecondType字段
			}else if(obj.linkType==5||obj.linkType==6||obj.linkType==7) {
				obj.cityCode=$(el).find('.zc_area').val();
				obj.countryCode = $(el).find('.zc_country').val();
				obj.provinceCode = $(el).find('.zc_province').val();
			}
			banObj.sliders.push(obj);
		});
		return banObj;
	}

	function zcNavFn($obj) {
		var navObj = {type:'nav'};
		var $navNodes = $obj.find('.evy_nav');
		navObj.nodes = [];
		navObj.hang = $obj.find('.ishang label.on').attr('data-val');//是否悬浮
		// console.log(navObj.hang);
		navObj.navType = $obj.find('.isnavtype label.on').attr('data-val');//横向||竖向
		navObj.pic = $obj.find('.zcQiniuImg').attr('src');
		$.each($navNodes, function(i, el) {
			var obj = {};
			obj.name = $(el).find('.anchor_name').val();
			obj.anchorLocaltion = $(el).find('.anchor_loc').val();
			navObj.nodes.push(obj);
		});
		return navObj;
	}

	function zcSglFn($obj) {
		var sglObj = {type:'sgl'};
		var $pdt = $obj.find('.evy_filtered');
		// var $tabs = $obj.find('.evy_single_pdt');
		// sglObj.tabs = [];
		sglObj.sort = $obj.find('.pailietype label.on').attr('data-val');//宽||窄
		sglObj.anchorLocaltion = $obj.find('.sgl_anchor').val();//锚点位置
		sglObj.products = zcSglChildFn($pdt);
		// $.each($tabs, function(i, el) {
		// 	 var obj={};
		// 	 var $pdt = $(el).find('.evy_filtered');
		// 	 obj.tabLabel=$(el).find('.tab_label_name').val();
			 // obj.dataCheck = $(el).find('.data_check').val();
			 // obj.product = zcSglChildFn($pdt); //[]数组
		// 	 sglObj.tabs.push(obj);
		// });




		return sglObj;
	};

	function zcAdsFn($obj) { //广告热区组件
		var adsObj = {type:'ads'};
		var $hotAreas = $obj.find('.hot_type_wp')||null;
		adsObj.imgWidth = $('.hot_img_wp').width()+'px'||'320px';//用于比例运算@zc20170817
		adsObj.pic = $obj.find('.zcQiniuImg').attr('src');
		adsObj.hotType = $obj.find('.hot_set .hot_lab.on').attr('data-val');//热区类型：全图allPic||无noHot||分区divide
		adsObj.anchorLocaltion = $obj.find('.ads_anchor').val();//锚点位置
		adsObj.hotAreas = [];
		if(adsObj.hotType!='noHot') {
			$.each($hotAreas, function(i, el) {
				var obj={};
				var id = -1;//热区id
				var $target = null;
				obj.type=$(el).find('.jump_type_sel').val();
				obj.linkType = $(el).find('.jump_link').val();//跳转链接
				obj.dataCheck = $(el).find('.data_check').val();//数据检测
				if(adsObj.hotType==='divide') { //如果划定了热区，则增加一个字段
					id = $(el).find('.get_area').attr('curr_id');//需要验证TODO
					$target = $obj.find('.img_masker .zc_hot_div[curr_id='+id+']');
					obj.areaTop = $target.css('top');
					obj.areaLeft = $target.css('left');
					obj.areaWidth = $target.css('width');
					obj.areaHeight = $target.css('height');
				}
				if(obj.type==4) { //旅游产品详情，需要子分类  type:跳转类型分类
					obj.travelSecondType=$(el).find('.travel_types').val();
				}else if(obj.type==5||obj.type==6||obj.type==7) {
					obj.cityCode = $(el).find('.zc_area').val();
					obj.countryCode=$(el).find('.zc_country').val();
					obj.provinceCode=$(el).find('.zc_province').val();
				}else if(obj.type==1) {
					obj.giftSuccess = $(el).find('.success_input').val();
					obj.giftFail = $(el).find('.fail_input').val();
				}
				adsObj.hotAreas.push(obj);
				if(adsObj.hotType==='allPic') {
					if(i!=0) {
						return false;
					}
				}
			});
		}else {
			//没有热区不做处理
		}
		// console.log(adsObj);
		return adsObj;
	}

	function zcSglChildFn($obj) { //单品子函数
		var arr = [];
		$.each($obj, function(i, el) {
			 var obj = {};
			 obj.type = $(el).find('.single_pdt_sel').val();
			 obj.productId = $(el).find('.pdtid').val();
			 if(obj.type==3) {
			 	obj.travelSecondType = $(el).find('.travel_types').val();
			 }
			 obj.tabLabel = $(el).parents('.evy_single_pdt').find('.tab_label_name').val();
			 obj.dataCheck = $(el).parents('.evy_single_pdt').find('.data_check').val();
			 arr.push(obj);
		});
		return arr;
	}


	var onPageSureBtnClk = function() {//页面信息保存
		// console.log('看看页面保存了几次哦');
		var subject = {};
		var dataList = [];
		var $typeDiv = $('.zj_set_wp>div');
		var ajaxData = {};
		var ajaxDataStr = '';
	 	// console.log(adminId);
		$('.page_sure_btn').off('click',onPageSureBtnClk); //页面信息保存
		subject.subName = $('#sub_name').val();
		subject.diyLink = $('#diy_link').val();
		subject.subShare = $('#share_sub').val();
		subject.wordColor = $('#word_color').val();
		subject.bgColor = $('#bg_color').val();
		subject.goTop = $('input[name=asdfg]:checked').attr('gototop')//0:是，1:否
		subject.operator=adminId;
		$.each($typeDiv, function(i, el) {
			var type = $(el).attr('data-type');
			var obj = typeFun[type]($(el));
			dataList.push(obj)
			// console.log(obj);
		});
		// console.log(dataList);
		ajaxData={
			subject:subject,
			dataList:dataList
		};
		if(subId) {
			ajaxData.subject.id=subId;
		}
		ajaxDataStr=JSON.stringify(ajaxData);
		// console.log(ajaxDataStr);
		$.ajax({//JSON.stringify(dataList)
			type:'POST',
			contentType:'application/json;charset=UTF-8',
			url:addSubUrl,
			data:ajaxDataStr,
			success:function(res) {
				console.log(res);
				if(res.code==0) {
					window.location.href='subjectlist';
					return;
					$('.zj_set_wp').html('');
					$('#scan_area_cnt').html('');
					$('.zhuanti_wp').find('input').val('');
					setTimeout(function() {
						$('.page_sure_btn').off('click').on('click',onPageSureBtnClk); //页面信息保存
					},2000)
				}else {
					alert(res.msg);
					$('.page_sure_btn').off('click').on('click',onPageSureBtnClk); //页面信息保存
				}
			},
			error:function(xhr,qwe) {
				$('.page_sure_btn').off('click').on('click',onPageSureBtnClk); //页面信息保存
				console.log('ajax error');
				console.log(xhr);
				console.log(qwe);
			}

		})
	};

	var onPageCancelBtnClk = function() { //页面信息取消
		window.location.href='subjectlist';
	};

	var onZcProvinceChange = function() {
		var val = $(this).val();
		var $dom = $(this).parents('.alllist').find('.zc_area');
		renderProinceByParCode(val,$dom,'请选择市');
	};

	var onZcCountryChange = function() {
		var val = $(this).val();
		var $dom = $(this).parents('.alllist').find('.zc_province');
		$(this).parents('.alllist').find('.zc_area').html('请选择市');
		renderProinceByParCode(val,$dom,'请选择省');
	};

	var onGetAreaClk = function() {
		var currId = $(this).attr('curr_id');
		if(!currId) {
			$(this).attr('curr_id',getAreaBtnId);
			drawHotArea( $('.zj_set_wp .img_masker'),isOverlap,getAreaBtnId );
			getAreaBtnId++;
		}else {
			// console.log($('.img_masker>div'))
			if(  testIn( currId,$('.img_masker>div') )  ) {
				alert('请先删掉已经划定的热区');
				return;
			}
			drawHotArea( $('.zj_set_wp .img_masker'),isOverlap,currId );
		}
	};

	var onHotLabelClk= function() {
		var index = $(this).index();
		if(index==3||index==1) {
			$(this).siblings('.add_new_aera').addClass('show_out');
			$(this).parent().siblings('.hot_type_wp').addClass('show_out');
		}else {
			$(this).siblings('.add_new_aera').removeClass('show_out');
			$(this).parent().siblings('.hot_type_wp').removeClass('show_out');
		}
		$(this).addClass('on').siblings('label').removeClass('on');
	};

	var onDelThisBtnClk = function() {

		$(this).parents('.zc_hot_div').remove();
	};

	var onPageLeftCancelClk = function() { //编辑取消
	 	var id = $('.editing_curr_mdl>div').attr('data-id');
	 	$('.zj_set_wp>div[data-id='+id+']').replaceWith($('.editing_curr_mdl>div'));
	};


	var onThiseDitorClk = function() { //编辑一个组件
	 	var $par = $(this).parents('.mdl_name');
	 	var id = $par.attr('data_id');
	 	$('.zj_set_wp>div.show_out.curr_dom.editing').removeClass('show_out curr_dom editing');
	 	$('.zj_set_wp>div[data-id='+id+']').addClass('show_out curr_dom editing');//添加正在编辑标志editing
	 	$('.editing_curr_mdl').html($('.zj_set_wp>div[data-id='+id+']').clone());
	 	$('.editing_curr_mdl').find('.slider_select').val($('.zj_set_wp>div[data-id='+id+']').find('.slider_select').val());
	 	$('.editing_curr_mdl').find('.travel_types').val($('.zj_set_wp>div[data-id='+id+']').find('.travel_types').val());
	 	$('.moduleSet').trigger('click');
	};

	var onThisDelClk = function() {//删除一个组件
	 	var $par = $(this).parents('.mdl_name');
	 	var id =  $par.attr('data_id');
	 	$par.remove();
	 	$('.zj_set_wp>div[data-id='+id+']').remove();
	};

	var onMoveDownClk = function() {//下移动一个组件
	 	var $upDiv = $(this).parents('.mdl_name').next();
	 	var $currDiv = $(this).parents('.mdl_name');
	 	var $leftDiv1 = $('.zj_set_wp .page_zj[data-id='+$upDiv.attr('data_id')+']');
	 	var $leftDiv2 = $('.zj_set_wp .page_zj[data-id='+$currDiv.attr('data_id')+']');
	 	var len = $upDiv.size();
	 	if (!len) {return;}
	 	swap($upDiv,$currDiv);
	 	swap($leftDiv1,$leftDiv2);
	};

	var onMoveUpClk = function() {//上移动一个组件
	 	var $upDiv = $(this).parents('.mdl_name').prev();
	 	var $currDiv = $(this).parents('.mdl_name');
	 	var $leftDiv1 = $('.zj_set_wp .page_zj[data-id='+$upDiv.attr('data_id')+']');
	 	var $leftDiv2 = $('.zj_set_wp .page_zj[data-id='+$currDiv.attr('data_id')+']');
	 	var len = $upDiv.size();
	 	if (!len) {return;}
	 	swap($upDiv,$currDiv);
	 	swap($leftDiv1,$leftDiv2);
	};

	var onAddOneAnchorClk = function() {
	 	$('.evy_zj_wp .evy_nav').eq(0).clone().appendTo('.zj_set_wp .anchor_wp');
	};

	var onJumpTypeSelChange = function() {
	 	var currVal = $(this).val();
	 	var $counSel = null;
	 	var $prvnSel = null;
	 	var $areaSel = null;
	 	var $alllist = $(this).siblings('.alllist');
	 	// console.log($(this).siblings('.gift_word'));
	 	if(currVal==1) {
	 		$(this).siblings('.gift_word').addClass('show_out');
	 	}else {
	 		$(this).siblings('.gift_word').removeClass('show_out');
	 		if(currVal==5||currVal==6||currVal==7) {
	 			$alllist.addClass('show_out');
	 			$counSel = $alllist.find('.zc_country');
	 			renderCountry($counSel);
	 		}else {
	 			$(this).siblings('.alllist').removeClass('show_out');
	 		}
	 	}
	};

	var onDelOnePdtBtnClk = function() { //删除一个pdt
	 	var len = $(this).parents('.evy_filtered').siblings('.evy_filtered').size();
	 	len>0 && $(this).parents('.evy_filtered').remove();
	};

	var onAddOnePdtClk =function() {
		var $parTarget = $(this).siblings('.pdt_filter_wp');
	 	$('.evy_zj_wp .evy_filtered').clone().appendTo($parTarget);
	};

	var onAddOneTabClk = function() {
		var $parTarget = $(this).parents('.single_zj');
	 	$('.evy_zj_wp .evy_single_pdt').clone().appendTo($parTarget);
	};


	var onAddNewAeraClk = function() {
	 	$('.evy_zj_wp .hot_type_wp').clone().addClass('show_out').appendTo('.zj_set_wp .img_zj');
	 	$(this).siblings('label').removeClass('on').siblings('label[data-val="divide"]').addClass('on');
	};

	var onSliderRightClk= function() { //删除一个模块
		var id = -1;
	 	var len = 1+Number($(this).parents('.left_right_wp').siblings('.left_right_wp').size()) ;
	 	if(len>1) {
	 		if($(this).parents('.page_zj').hasClass('img_zj')) {
	 			id = $(this).siblings('.slider_left').find('.get_area').attr('curr_id');
	 			$('.img_masker>div[curr_id='+id+']').remove();
	 		}
	 		$(this).parents('.left_right_wp').remove();
	 	}else {
	 		console.log('后期再处理TODO');
	 	}
	 	
	};

	var onSliderSelChange = function(ev) {
	 	var currVal = $(this).val();
	 	if(currVal==ev.data) {
	 		$(this).siblings('.travel_types').addClass('show_out');
	 	}else {
	 		$(this).siblings('.travel_types').removeClass('show_out');
	 	}
	};

	var onAddOneBannerTap = function() { //添加一个轮播位
	 	var btn = null,$picDom = null;
	 	var $parTarget = $(this).siblings('.slider_wp');
	 	$('.evy_zj_wp .evy_slider').clone().appendTo($parTarget);
	 	btn = $(this).siblings('.slider_wp').find('.evy_slider:last-child .qiniuBtn').get(0);
	 	$picDom = $(this).siblings('.slider_wp').find('.evy_slider:last-child .zcQiniuImg');
	 	zcCreartQiniu(btn,$picDom);
	};

	var pageTab = function() {
	 	var $tabHedaers = $('.header>div');
	 	var $tabBodys = $('.tab_body>div');
	 	$tabHedaers.on('click',function() {
	 		var index = $(this).index();
	 		$(this).addClass('on').siblings('.on').removeClass('on');
	 		$tabBodys.css('display','none').eq(index).css('display','block');
	 		// if(index==1) {
	 		// 	centerSliderRight($('.zj_set_wp>div.show_out').find('.slider_right'));
	 		// }
	 	})
	};

	var onPageLeftSureClk = function() { //左侧确认按钮点击
	 	var index = $('.zj_set_wp .curr_dom').index();
	 	var isEditing = $('.zj_set_wp .curr_dom').hasClass('editing');
	 	var isBigEditing = $('.zj_set_wp .curr_dom').hasClass('bigEditing');
	 	if(index<0){return;}
	 	if(!isEditing||isBigEditing) {
	 		$('.zj_set_wp .curr_dom').attr('data-id',gAddId).removeClass('curr_dom show_out bigEditing');
		 	$('.mdl_name_wp .mdl_name').find('.mdl_word').html(mdlObj[moduleIndex]).end().attr('data_id',gAddId).clone().appendTo('#scan_area_cnt');
		 	gAddId++;
		}else {
		 	$('.zj_set_wp .curr_dom').removeClass('editing curr_dom show_out');
		}
	};



	var onAddModuleBtnClk = function() { 
	 	var val = $('#selest_zj option:checked').val();
	 	moduleIndex = val;
	 	var btn = null,$picDom = null;
	 	if(val==10) {return;}
	 	$('.show_out.curr_dom.editing').removeClass('show_out curr_dom editing');
	 	// $('#zc_editor_wp .may_show_out').removeClass('show_out').eq(val).addClass('show_out');
	 	$('.zj_set_wp .curr_dom').remove();//先删掉未确认的组件
	 	$('.evy_zj_wp .may_show_out').eq(val).clone().addClass('show_out curr_dom').appendTo($('.zj_set_wp'));//將克隆的組件扔进目标元素并添加curr_dom标记，当点击左侧确认时，去掉该标记，将该组件标记到右侧
	 	// centerSliderRight($('.zj_set_wp>div.show_out').find('.slider_right'));
	 	if(val!=10&&val!=2) {
	 		btn = $('.zj_set_wp .show_out.curr_dom').find('.qiniuBtn').get(0);
	 		$picDom = $('.zj_set_wp .show_out.curr_dom').find('.zcQiniuImg');
	 		zcCreartQiniu(btn,$picDom);
	 	}
	 	$('.moduleSet').trigger('click');
	};

	var initCenterDelBtn = function() {
	 	var $delBtns = $('.slider_right');
	 	// centerSliderRight($delBtns);
	};

	function renderCountry($selDom,argu_code) { //国家下拉框
		// if(!argu_code){
		// 	return;
		// }
		$.ajax({
			type:'POST',
			contentType:"application/json;charset=UTF-8",
			url:countryUrl,
			success:function(res) {
				// console.log(res);
				var data=[];
				var str = '<option value="0">请选择国家</option>';
				if(res.code==0) {
					data = res.data;
					$.each(data, function(index, val) {
						if(argu_code) {
							if(argu_code==val.cityCode) {
								str+='<option value='+val.cityCode+' selected=selected>'+val.countryName+'</option>';
							}else {
								str+='<option value='+val.cityCode+'>'+val.countryName+'</option>';
							}
						}else {
							str+='<option value='+val.cityCode+'>'+val.countryName+'</option>';
						}
						
					});
					$selDom.html(str);
				}else {
					console.log('返回码'+res.code);
				}
			},
			error:function() {
				console.log('ajax error');
			}
		})
	}

	function renderProinceByParCode(code,selDom,firstItem,argu_code) {
		// console.log(selDom);
		// console.log(code);
		// console.log(argu_code);
		if(code=='undefined'||!code) {
			return;
		}
		var ajax_data_str = JSON.stringify({parentCode:code});
		$.ajax({
			type:'POST',
			url:provinceUrl,
			contentType:"application/json;charset=UTF-8",
			data:ajax_data_str,
			success:function(res) {
				// console.log(res);
				var data = [];
				var str = '<option value="0">'+firstItem+'</option>';
				if(res.code==0) {
					data = res.data;
					$.each(data, function(index, val) {
						if(argu_code) {
							if(argu_code==val.cityCode) {
								str+='<option value='+val.cityCode+' selected=selected>'+val.cityName+'</option>'	
							}else {
								str+='<option value='+val.cityCode+'>'+val.cityName+'</option>'	
							}
						}else {
							str+='<option value='+val.cityCode+'>'+val.cityName+'</option>'	
						}
						
					});	
					selDom.html(str);
				}else {
					console.log('返回码'+res.code);
				}
			},
			error:function(xhr) {
				console.log('ajax error');
				console.log(xhr);
			}
		})
	}

	function testIn(id,$obj) {
		var r = false;
		$.each($obj, function(index, val) {
			if($(val).attr('curr_id')==id) {
				r=true;
				return false;
			}
		});
		return r;
	}

	function isOverlap($curr,$all) {
		$.each($all, function(index, val) {
			if($curr.get(0)!=val) {
			 	if(testDivOverlap($curr,$(val))) {
			 		$curr.remove();
			 		return false;
			 	}
			}
		});
	}

	function testDivOverlap($div1,$div2) {
		var r = false;
		var ftX1 = $div1.position().left,	
			ftX2 = ftX1+$div1.outerWidth(),
			ftY1 = $div1.position().top,
			ftY2 = ftY1+$div1.outerHeight(),
			sdX1 = $div2.position().left,	
			sdX2 = sdX1+$div2.outerWidth(),
			sdY1 = $div2.position().top,
			sdY2 = sdY1+$div2.outerHeight();
		if(   ( sdX1<=ftX2&&sdX1>=ftX1||sdX2>=ftX1&&sdX2<=ftX2 ) && ( sdY1>=ftY1&&sdY1<=ftY2||sdY2>=ftY1&&sdY2<=ftY2 )   ) {
			r = true;//重合
		} else {
			r = false;//没有重合
		}
		return r;
	}

	function drawHotArea($dom,fn,curr_id) {
	 	var wId = "w";
		var index = 0;
		var startX = 0, startY = 0;
		var flag = false;
		var retcLeft = "0px", retcTop = "0px", retcHeight = "0px", retcWidth = "0px";
		var left = '0px',top='0px',width='0px',height='0px';
		var currId = '';
		$dom.one('mousedown',function(ev) {
			// console.log(ev);
			index++;
			currId = wId+index;
			flag=true;
			startX = ev.offsetX;
			startY = ev.offsetY;
			$('<div class=div id='+currId+'></div>').css({'left':startX+'px','top':startY+'px'}).appendTo($dom);
		});
		$dom.on('mousemove',function(ev) {
			if(flag) {
				// console.log(ev);
				left   = (ev.offsetX-startX>0?startX:ev.offsetX)+'px';
				top    = (ev.offsetY-startY>0?startY:ev.offsetY)+'px';
				width  = Math.abs(ev.offsetX-startX)+'px';
				height = Math.abs(ev.offsetY-startY)+'px';
				$('#'+wId+index).css({
					'left'   : left,
					'top'    : top,
					'width'  : width,
					'height' : height
				})
			}
		});
		$(document).on('mouseup',function(ev) {
			var $this = $('<div class=zc_hot_div></div>');
			$('#'+wId+index).remove();
			$('.div').remove();
			if(parseInt(width)>30&&parseInt(height)>30) {
				$this.css({
					'left'   : left,
					'top'    : top,
					'width'  : width,
					'height' : height
				}).attr('curr_id',curr_id).appendTo($dom).append('<div class="del_this">x</div>');

			}
			retcLeft = "0px"; retcTop = "0px"; retcHeight = "0px"; retcWidth = "0px";
			left = '0px';top='0px';width='0px';height='0px';
			
			if(flag && fn && typeof fn ==='function') {
				fn($this,$('.zc_hot_div'));
			}
			flag = false;
		});
		
	}

	function zcCreartQiniu(zcBtn,$img) { //创建七牛实例，传递上传按钮id,$img,(zcBtn:id||dom)
	 	var $hotTypeWps=$(zcBtn).parents('.img_zj').find('.hot_type_wp');
	 	var currType='';
	 	// console.log($hotTypeWps);
	 	new QiniuJsSDK().uploader({
	 		runtimes: 'html5,flash,html4',      // 上传模式，依次退化
		    browse_button: zcBtn,         // 上传选择的点选按钮，必需
		    uptoken_url:zcQiuTokenUrl,
		    get_new_uptoken: false,             // 设置上传文件的时候是否每次都重新获取新的uptoken
		    auto_start: true,                   // 选择文件后自动上传，若关闭需要自己绑定事件触发上传
		    domain:'http://img.tgljweb.com/',
		    init:{
		    	FileUploaded: function(up, file, info) {
		    		var httphead = up.getOption('domain');
		    		var key = JSON.parse(info.response).key;
		    		$img.attr('src',(httphead+key));
		    		currType=$(zcBtn).parents('.img_zj').find('.hot_lab.on').attr('data-val');
		    		//热区图片上传成功后，将所有已划定热区干掉！！
		    		if($(zcBtn).hasClass('img_upload_btn')) {
		    			$('.img_masker').html('');
		    			$hotTypeWps=$(zcBtn).parents('.img_zj').find('.hot_type_wp');
		    			$.each($hotTypeWps, function(index, val) {
		    				$(val).remove();
		    			});
		    			if(currType!='noHot') {
		    				$('.evy_zj_wp .img_zj').find('.hot_type_wp').clone().appendTo($(zcBtn).parents('.img_zj'));
		    			}else {
		    				$('.evy_zj_wp .img_zj').find('.hot_type_wp').clone().removeClass('show_out').appendTo($(zcBtn).parents('.img_zj'));
		    			}
		    			
		    		}
	          	},
	          	Error: function(up, err, errTip) {
		        	console.log(err);
		        	console.log(errTip);
		        }

		    }
	 	})
	}

	function swap(a,b) { //交换两个div的位置
		var a1 = $("<div id='a1'></div>").insertBefore(a);
		var b1 = $("<div id='b1'></div>").insertBefore(b);
 		a.insertAfter(b1);
 		b.insertAfter(a1);
 		a1.remove();
 		b1.remove();
		a1 = b1 = null;
    }

	function centerSliderRight(targets) {
	 	$.each(targets, function(index, val) {
	 		var height = $(val).height()+'px';
	 		$(val).css('lineHeight',height);
	 	});
	}        

	function fixTheme(id) {
		$.ajax({
			type:'POST',
			contentType:'application/json;charset=UTF-8',
			url:fixthmUrl,
			data:JSON.stringify({subjectId:id}),
			success:function(res) {
				console.log(res);
				// console.log(JSON.stringify(res.data.dataList));

				renderFix(res.data);
			},
			error:function(xhr) {
				console.log('ajax error');
			}
		})
	}

	var renderFix = function(arr) {
		var sub = arr.subject;
		$('.zhuanti_wp #bg_color').val(sub.bgColor);
		$('.zhuanti_wp #sub_name').val(sub.subName);
		$('.zhuanti_wp #share_sub').val(sub.subShare);
		$('.zhuanti_wp #word_color').val(sub.wordColor);
		$('.zhuanti_wp #diy_link').val(sub.diyLink);
		$('.zhuanti_wp #bg_color').val(sub.bgColor);
		$('.zhuanti_wp input[gototop='+sub.goTop+']').attr('checked','checked');
		$('.zc_page_wp').attr('data-id',sub.id);
		renderModuleOuter(arr.dataList);
		// renderFixCountry();
	};

	var renderModuleOuter = function(arr) {//返现数据右侧显示
		$.each(arr, function(i, obj) {
			var type = obj.type;
			$('.zj_set_wp').append(renderTypeFn[type](obj));
		});
		renderFixCountry();
		renderRightScan();
		aliveQiniu();
		// $('.zj_set_wp>div:nth-child(1)').addClass('show_out curr_dom editing');
	};

	function aliveQiniu() {
		var $btns = $('.zj_set_wp .qiniuBtn');
	 	var $picDom = null;
	 	$.each($btns, function(i, dom) {
	 		if($(dom).parents('.page_zj').hasClass('banner_zj')) {
	 			$picDom=$(dom).parent().next().find('.zcQiniuImg');
	 			// zcCreartQiniu(dom,$picDom);
	 		}else if($(dom).parents('.page_zj').hasClass('img_zj')) {
	 			$picDom=$(dom).parents('.page_zj').find('.zcQiniuImg');
	 			// zcCreartQiniu(dom,$picDom);
	 		}else if($(dom).parents('.page_zj').hasClass('nav_zj')) {
	 			$picDom=$(dom).parents('.nav_zj').find('.zcQiniuImg');
	 			// zcCreartQiniu(dom,$picDom);
	 		}
	 		zcCreartQiniu(dom,$picDom);
	 	});
	 	
	}

	function renderRightScan() { //渲染右侧组件名
		var doms = $('.zj_set_wp>div');
		$.each(doms,function(i,dom) {
			if($(dom).hasClass('banner_zj')) {
				moduleIndex=0;
			}else if($(dom).hasClass('nav_zj')) {
				moduleIndex=3;
			}else if($(dom).hasClass('single_zj')) { 
				moduleIndex=2;
			}else if($(dom).hasClass('img_zj')) {
				moduleIndex=1;
			}
			$(dom).addClass('show_out curr_dom bigEditing');
			$('#page_left_sure').trigger('click');
		})
	}

	function renderFixCountry() {
		var $targets = $('.zj_set_wp').find('.zc_country');
		if($targets.size()==0) {
			return;
		}
		$.each($targets, function(i, el) {
			var parCode=$(el).attr('data-code');
			var $pro = $(el).parents('.alllist').find('.zc_province');
			var proCode = $pro.attr('data-code');
			var $area = $(el).parents('.alllist').find('.zc_area');
			var areaCode = $area.attr('data-code');
			// console.log($pro);
			// console.log($area);
			renderCountry($(el),parCode);
			if(parCode!=0&&proCode!=0){renderProinceByParCode(parCode,$pro,'请选择省',proCode);} 
			if(proCode!=0&&areaCode!=0){renderProinceByParCode(proCode,$area,'请选择市',areaCode);}
		});
	}

	function renderZcBannerFn (obj) {
		var str= '';
		str+=
		`<div class="banner_zj page_zj may_show_out ctrl_p " data-type="banner"><!-- show_out  --><!-- banner组件 -->
			<div class="add_one_banner zc_btn">+新增轮播</div>
			<div class="slider_wp">
				<p>
					<span>锚点位置：</span>
					<input type="text" placeholder="请输入与导航对应的锚点" class="zc_input_sel ban_anchor">
				</p>
				`+renderSlider(obj.sliders)+`
			</div>
		</div>`
		return str;
	}

	function renderSlider(arr) {
		var str = '';
		$.each(arr,function(i,obj) {
			str+=
			`<div class="evy_slider zc_clear_float left_right_wp">
				<div class="slider_left">
					<p>
						<span>标题：</span>
						<input type="text" placeholder="请填写标题" class="ban_title" value=`+obj.title+`>
					</p>
					<div>
						<span>跳转类型：</span>
						<select name="" id="" class="zc_input_sel slider_select jump_type_sel"> 
							`+renderOption(type_arr,obj.linkType)+`
						</select>
						`+renderTravelSel(obj.linkType)+`<!-- show_out如果是旅游产品显示该下拉框 -->
							`+renderOption(child_type_arr,obj.travelSecondType,3)+`
						</select>
						`+renderCityCode(obj.linkType)+`<!--<div class="alllist show_out">-->
							<div>
								<select name="" id="" class="three_city zc_country" data-code=`+obj.countryCode+`>
									<option value="0">请选择国家</option>
								</select>
							</div>
							<div>
								<select name="" id="" class="three_city zc_province" data-code=`+obj.proviceCode+`><!-- jleftwidth -->
									<option value="0">请选择省</option>
								</select>
							</div>
							<div>
								<select name="" id="" class="three_city zc_area" data-code=`+obj.cityCode+`><!-- jleftwidth -->
									<option value="0">请选择市</option>
								</select>
							</div>
						</div>
					</div>

					<p>
						<span>跳转链接：</span>
						<input type="text" placeholder="请输入链接地址或者id" class="zc_input_sel jump_link" value=`+obj.jumpLink+`>
					</p>
					<p>
						<span>数据监测：</span>
						<input type="text" class="zc_input_sel data_check" value=`+obj.dataCheck+`>
					</p>
					<p class="img_module">
						
						<span class="upload_div up_css">
							+选择图片
							<button class="banner_upload_btn zc_upload_btn qiniuBtn"  ></button>
						</span>
						<span><img src=`+obj.pic+` class="zc_select zcQiniuImg"></span>
					</p>
				</div>
				<div class="slider_right">删除</div>
			</div>`
		});
		return str;
	}

	function renderCityCode(str) {
		if(str=='5'||str=='6'||str=='7') {
			return '<div class="alllist show_out">'
		}else {
			return '<div class="alllist">'
		}
	}

	function renderTravelSel(str) {
		if(str==4) {
			return '<select name="" class="travel_types show_out">'
		}else {
			return '<select name="" class="travel_types">'
		}
	}

	function renderWideInput(val) {
		var currStr='';
		if(val=='wide') {
			currStr+=
				'<label data-val="wide" class="sd_input_mr fake on" >宽</label>'+
				'<label data-val="narrow" class="fake">窄</label>'
		}else {
			currStr+=
				'<label data-val="wide" class="sd_input_mr fake" >宽</label>'+
				'<label data-val="narrow" class="fake on">窄</label>'
		}
		return currStr;
	}

	function renderNarrow(val) {
		if(val==='narrow') {
			return '<input data-val="narrow" type="radio" name="pailietypeo" checked>';
		}else {
			return '<input data-val="narrow" type="radio" name="pailietypeo">'
		}
	}

	function renderZcSglFn (obj) {
		var str= '';
		str+=
		`<div class="single_zj page_zj may_show_out ctrl_p " data-type='sgl'><!-- show_out --><!-- 单品组件 -->
			<div class="pailietype">
				<span>产品排列方式:</span>
				`+renderWideInput(obj.sort)+`
			</div>
			<div class="add_one_tab zc_btn">+新增tab</div>
			<p>
				<span>锚点位置：</span>
				<input type="text" placeholder="请输入与导航对应的锚点" class="zc_input_sel sgl_anchor" value=`+obj.anchorLocaltion+`>
			</p>
			`+renderSglPdt(obj.tabs)+`	
			
		</div>`
		return str;
	}

	function renderSglPdt(arr) {
		var str = '';
		$.each(arr,function(i,obj) {
			str+=
			`<div class="evy_single_pdt zc_clear_float left_right_wp"><!-- 单品组件下的单品包裹 -->
				<div class="slider_left">
					<p>
						<span class="jleftwidth">tab签：</span>
						<input type="text" placeholder="请填写tab签" class="zc_input_sel tab_label_name" value=`+obj.tabLabel+`>
					</p>
					<p>
						<span class="jleftwidth">数据监测：</span>
						<input type="text" class="zc_input_sel data_check" value=`+obj.dataCheck+`>
					</p>
					<div class="pdt_filter_wp"><!-- 每一个产品的容器，点击新增时添加一个产品 -->
						`+renderTypePdt(obj.productType)+`
					</div>
					<div class="add_one_pdt zc_btn">+新增产品</div>
				</div>
				<div class="slider_right">删除</div>
			</div>`
		})
		return str;
	}

	function renderTypePdt(arr) {
		var str='';
		$.each(arr, function(i, obj) {
			str+=
			`<div class="evy_filtered"> <!-- 每一个产品的模板 -->
				<p>
					<span class="jleftwidth wd80">产品类型：</span>
					<select name="" id="" class="single_pdt_sel zxcv">
						`+renderOption(detail_arr,obj.type)+`
					</select>
					`+renderShowSel(obj.type)+`<!-- show_out如果是旅游产品显示该下拉框 -->
						`+renderOption(child_type_arr,obj.travelSecondType,3)+`
					</select>
				</p>
				<p>
					<span class="ml5 wd80">添加产品id：</span>
					<textarea class="ml5 pdtid" name="" cols="30" rows="10" placeholder="添加产品id：多个用‘|’隔开">`+obj.productId+`</textarea>
				</p>
				<div class="del_onepdt_btn">X</div>
			</div>`
		});
		return str;
	}

	function renderShowSel(str) {
		if(str=='3') {
			return '<select name="" class="travel_types show_out">';
		}else {
			return '<select name="" class="travel_types">';
		}
	}

	function renderHotLab(str,arr) {
		var tlstr='';
		$.each(arr, function(i, obj) {
			if(obj.val==str) {
				tlstr+='<label data-val='+obj.val+' class="hot_lab '+obj.cls+' on">'+obj.htm+'</label>';
			}else {
				tlstr+='<label data-val='+obj.val+' class="hot_lab '+obj.cls+'">'+obj.htm+'</label>';
			}
		});
		return tlstr;
	}

	function renderAddNewArea(str) {
		if(str=='noHot') {
			return '<span id="" class="add_new_aera zc_btn">+新增热区</span>';
		}else {
			return '<span id="" class="add_new_aera zc_btn show_out">+新增热区</span>';
		}
	}

	function renderZcAdsFn (obj) { //热区函数，下有热区渲染
		var str= '';
		str+=
		`<div class="img_zj page_zj may_show_out ctrl_p show_out" data-type='ads'><!-- show_out --><!-- 广告热区组件 -->
			<div class="hot_img_wp">
				<img src=`+obj.pic+` class="zc_select zcQiniuImg">
				<div class="img_masker">`+renderHotDiv(obj.hotAreas)+`</div>
			</div>
			<p class="img_module">
				<span class="upload_div up_css">
					+选择图片
					<button type="file" name="" class="img_upload_btn zc_upload_btn qiniuBtn"></button>
				</span>
			</p>
			<p class="hot_set">
				<span>设置热区：</span>
				`+renderHotLab(obj.hotType,hotLbl)+`
				`+ renderAddNewArea(obj.hotType)+`	<!--<span id="" class="add_new_aera zc_btn">+新增热区</span>-->
			</p>
			<p>
				<span>锚点位置：</span>
				<input type="text" placeholder="请输入与导航对应的锚点" class="zc_input_sel ads_anchor" value=`+obj.anchorLocaltion+`>
			</p>
			`+renderHotArea(obj.hotAreas)+`
		</div>`;
		return str;
	}

	function renderHotDiv(arr) {
		var str='';
		$.each(arr, function(i, obj) {
			str+=`<div class="zc_hot_div" curr_id=`+i+` style=left:`+obj.areaLeft+`;top:`+obj.areaTop+`;width:`+obj.areaWidth+`;height:`+obj.areaHeight+`>
					<div class="del_this">x</div>
				 </div>`;
			getAreaBtnId=i;
			getAreaBtnId++;
		});
		return str;
	}

	function renderHotArea(arr) {//热区渲染
		var str='';
		$.each(arr, function(i, obj) {
			// console.log(`hot_type_wp`);
			str+=
				`<div class="hot_type_wp zc_clear_float left_right_wp show_out"> <!-- 左右结构包裹 -->
					<div class="slider_left">
						<div class="get_area" curr_id=`+i+`>点击此区域划定热区</div>
						<div class="jump_type_wp">
							<span class="type_word jleftwidth">跳转类型：</span>
							<select name="" id=""  class="zc_input_sel jump_type_sel" >
								`+renderOption(hot_type_arr,obj.type,10)+`
							</select>
							<select name="" class="travel_types"><!-- show_out如果是旅游产品显示该下拉框 -->
								`+renderOption(child_type_arr,obj.travelLinkType,3)+`
							</select>
							
							`+renderCityCode(obj.type)+`<!--<div class="alllist">-->
								<div>
									<select name="" id="" class="three_city zc_country" data-code=`+obj.countryCode+`>
										<option value="0">请选择国家</option>
									</select>
								</div>
								<div>
									<select name="" id="" class="three_city zc_province" data-code=`+obj.proviceCode+`><!-- jleftwidth -->
										<option value="0">请选择省</option>
									</select>
								</div>
								<div>
									<select name="" id="" class="three_city zc_area" data-code=`+obj.cityCode+`><!-- jleftwidth -->
										<option value="0">请选择市</option>
									</select>
								</div>
							</div>
							`+renderGiftsuccess(obj.type)+`<!--<p class="success_word_wp gift_word">-->
								<span class="success_wd jleftwidth ">成功文案：</span>
								<input value=`+(obj.giftSuccess||' ')+` type="text" class="success_input zc_input_sel" placeholder="请填写领取成功的文案">
							</p>
							`+renderGiftFail(obj.type)+`
								<span class="fail_wd jleftwidth ">失败文案：</span>
								<input value=`+(obj.giftFail||' ')+` type="text" class="fail_input zc_input_sel" placeholder="请填写领取失败的文案">
							</p>
						</div>
						<p>
							<span id="" class="jleftwidth href_id">跳转链接：</span> <!-- 可根据条件切换为礼品券id -->
							<input value=`+obj.linkType+` type="text" placeholder="跳转链接或产品id" class="zc_input_sel jump_link">
						</p>
						<p>
							<span class="jleftwidth">数据监测：</span>
							<input value=`+obj.dataCheck+` type="text" class="zc_input_sel data_check">
						</p>
					</div>
					<div class="slider_right">删除</div>
				</div>`
			getAreaBtnId=i;
			getAreaBtnId++;
		});
		return str;
	}

	function renderGiftsuccess(str) {
		if(str==1) {
			return '<p class="success_word_wp gift_word show_out">';
		}else {
			return '<p class="success_word_wp gift_word">';
		}
	}

	function renderGiftFail(str) {
		if(str==1) {
			return '<p class="fail_word_wp gift_word show_out">';
		}else {
			return '<p class="fail_word_wp gift_word">';
		}
	}

	function renderNavInputHangYes(str) {
		var currStr='';
		if(str=='yes') {
			currStr+= 
					  '<label data-val=yes class="sd_input_mr fake on" >是</label>'+
					 ' <label data-val=no  class="isxflab fake">否</label>'
		}else {
			currStr+=
					'<label data-val=yes class="sd_input_mr fake" >是</label>'+
					'<label data-val=no  class="isxflab fake on">否</label>'
		}
		return currStr;
	}

	function renderNavInputHangNo(str) {
		if(str=='no') {
			return '<input data-val=no type="radio"  name="xuanfu" checked>';
		}else {
			return '<input data-val=no type="radio"  name="xuanfu">';
		}
	}

	function renderNavTypeH(str) {
		var currStr='';
		if(str=='horizontal') {
			currStr+=
				'<label data-val="horizontal" class="sd_input_mr fake on">横向</label>'+
				'<label data-val="aside" class="fake">边侧</label>'
		}else {
			currStr+=
				'<label data-val="horizontal" class="sd_input_mr fake">横向</label>'+
				'<label data-val="aside" class="fake on">边侧</label>'
		}
		return currStr;
	}

	function renderNavTypeV(str) {
		if(str=='aside') {
			return '<input data-val="aside" type="radio"  value="" name="nav_type" checked>'
		}else {
			return '<input data-val="aside" type="radio"  value="" name="nav_type">'
		}
	}

	function renderNavNodes(arr) {
		var str='';
		$.each(arr, function(i, obj) {
			str+=
			`<div class="evy_nav zc_clear_float left_right_wp">
				<div class="slider_left">
					<p>
						<span>锚点名称：</span>
						<input type="text" class="anchor_name" value=`+obj.name+`>
					</p>
					<p>
						<span>锚点位置：</span>
						<input type="text" placeholder="请填写锚点位置" class="anchor_loc" value=`+obj.anchorLocaltion+`>
					</p>
				</div>
				<div class="slider_right">删除</div>
			</div>`
		});
		return str;
	}

	function renderZcNavFn (obj) {
		var str= '';
		str+=
		`<div class="nav_zj page_zj may_show_out ctrl_p " data-type='nav'><!-- show_out --><!-- 导航组件 -->
			<p class="ishang">
				<span>是否悬浮：</span>
				`+renderNavInputHangYes(obj.hang)+`
			</p>
			<p class="isnavtype">
				<span>导航类型：</span>
				`+renderNavTypeH(obj.navType)+`
			</p>
			<p class="img_module">
				<span class="upload_div up_css">
					+选择图片
					<button type="file" name="" class="zc_upload_btn qiniuBtn"></button><!--  id="nav_upload_btn"  -->
				</span>
				<span><img src=`+obj.pic+` class="zc_select zcQiniuImg"></span>
			</p>
			<div class="add_one_anchor zc_btn">+新增锚点</div>
			<div class="anchor_wp"><!-- 导航组件下的导航锚点包裹 -->
				`+renderNavNodes(obj.nodes)+`
				
			</div>
		</div>`
		return str;
	}

	function renderOption(type_arr,type,def) {
		var str = '';
		type=type||def;
		$.each(type_arr, function(i, obj) {
			if(type==obj.val) {
				str+='<option value='+obj.val+' selected=selected>'+obj.txt+'</option>';
			}else {
				str+='<option value='+obj.val+'                  >'+obj.txt+'</option>';
			}
			
		});
		return str;
	}




	initList();
}) 

/*
	专题列表页面所需

	1、保存页面数据接口

	2、查询单条数据接口（数据列表页面点击修改按钮时需要）

	3、城市下拉接口（国家/省/城市）

	4、数据列表接口

	5、删除单条数据接口

	6、启用单条数据接口



*/