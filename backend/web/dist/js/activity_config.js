//验证正则 2017年5月10日15:58:27 zjl
$(function(){
//	配置颜色验证
	$("#bg_color,#btn_color").blur(function(){
		var thisval = $(this).val();
		var reg = /^#([a-f]|[A-F]|[0-9]){3}(([a-f]|[A-F]|[0-9]){3})?$/;
		if(thisval=="" | thisval==" "){
			$(this).parent().siblings(".color_show").hide();
			$(this).parent().siblings("i").show().text("请输入色值");
			return false;
		}else if(!reg.test(thisval)){
			$(this).parent().siblings(".color_show").hide();
			$(this).parent().siblings("i").show().text("请输入正确色值");
			return false;
		}else {
			$(this).parent().siblings("i").hide();
			return true;
		}
	})
//配置颜色btn验证
	$(".button_color").on("click",function(){
		var bg_col = $("#bg_color").val();
		var btn_col = $("#btn_color").val();
		var reg = /^#([a-f]|[A-F]|[0-9]){3}(([a-f]|[A-F]|[0-9]){3})?$/;
		if(bg_col==""|bg_col ==" "){
			$("#bg_color").parent().siblings(".color_show").hide();
			$("#bg_color").parent().siblings("i").show().text("请输入色值");
		}
		if(btn_col==""|btn_col ==" "){
			$("#btn_color").parent().siblings(".color_show").hide();
			$("#btn_color").parent().siblings("i").show().text("请输入色值");
		}
		if(!reg.test(bg_col)|!reg.test(btn_col)){
			$(this).parent().siblings(".color_show").hide();
			$(this).parent().siblings("i").show().text("请输入正确色值");
			return false;
		}else{
			$(this).siblings("i").hide();
			$(".activity_form").submit();
			return true;
		}
	})
	
//	头图模块-提交时验证是否上传图片
	$(".button_pic").on("click",function(){
		var pic = $(".filelist").find(".pic").val();
		if(typeof(pic)=="undefined"){
			$(".error_title_pic").text("请上传图片");
			return false;
		}
		else{
			$(".error_title_pic").text("");
			$(".activity_form").submit();
			return true;
		}
	})

// 预定记录
	$(".button_book").on("click",function(){
		$(".activity_form").submit();
	})

//	删除添加的自定义内容/模块
	$("body").on("click",".config_l>ul>li>.del",function(){
		var _this = $(this);
		var mid = $(this).attr("data");
		var key = $(this).attr("data-key");
		var type = $(this).attr("data-type");
		layer.confirm('你确定要删除么？', {
			btn: ['确定','取消'] //按钮
		}, function(index){
			$.ajax({
				type: 'get',
				url: del_module_url,
				data: {
					mid: mid,
					key: key,
					type: type,
				},
				success: function (data) {
					console.log(data);
					_this.parents("li").remove();
					layer.close(index);
					location.href = to_index_url;
				}
			});

		});
	})
//	添加模块
	function add_module(module,content,add_url,to_url){
		$(module).on("click",function(){
			$.ajax({
				type: 'post',
				url: add_url,
				data: {
					thematic_id: thematic_id,
					content:content,
				},
				success: function (data) {
					console.log(data);
					if(data==-1){
						layer.alert("参数错误");
					}else{
						$(module).parents("ul").find("a").removeClass("current");
						var str_own = '<li><a href="#" class="current">'+content+'</a></li>';
						$(module).parent("li").before(str_own);
						location.href = to_url+"&mid="+data;
					}
				}
			});

		})
	}
//	添加自定义内容
	add_module(".add_own","自定义内容",add_content_url,to_content_url);
//	添加商品模块
	add_module(".add_module","商品模块",add_goods_module_url,to_goods_module_url);



	//	tab切换
	var Tab = function (clk,par,parslb,item){
		$(clk).on("click",function(){
			var index = $(this).index();
			$(this).addClass("current").siblings(clk).removeClass("current").parents(par).siblings(parslb).find(item).eq(index).show().siblings(item).hide();
		})
	}
//	配置和模板tab
	Tab(".config_tap>li",".config_tab",".config_con",".c_module_item");
//	商品分类模板tab
	Tab(".default_item_header>li",".default_item_header",".default_item_con",".m_default");
//	$(".config_tap>li").on("click",function(){
//		var index = $(this).index();
//		$(this).addClass("current").siblings("li").removeClass("current").parents(".config_tab").siblings(".config_con").find(".c_module_item").eq(index).show().siblings(".c_module_item").hide();
//
//	})
//	全选全不选 start
	$("#checkall").click(function(){  //全选全不选
		if(this.checked){
			$(".m_configure :checkbox").prop("checked", true).addClass("clkbox");

		}else{
			$(".m_configure :checkbox").prop("checked", false).removeClass("clkbox");
		}
	});
	$("body").on("click",".m_configure :checkbox",function(){
		allchk();
	});
	function allchk(){
		var chknum = $(".m_configure :checkbox").size();//选项总个数
		var chk = 0;
		$(".m_configure :checkbox").each(function () {
			if($(this).prop("checked")==true){
				chk++;
			}
		});
		if(chknum==chk){//全选
			$("#checkall").prop("checked",true);
		}else{//不全选
			$("#checkall").prop("checked",false);
		}
	}
//	全选全不选 end

// 	checkbox选择 为了以后删除数据
	$("body").on("click","input[name='goods_id[]']",function(){
		if(this.checked){
			$(this).addClass("clkbox");
		}else{
			$(this).removeClass("clkbox");
		}
	})
// 	删除商品
	$(".operate_bar .del").click(function(){
		var flag = true;
//		如果有class clkbox 代表要删除的内容
		if($(".m_configure :checkbox").hasClass("clkbox")){
			layer.confirm('你确定要删除么？', {
				btn: ['确定','取消'] //按钮
			}, function(index){
				var goods_id = [];
				var now_cat_num = $(".goods_name").length;
				var del_cat_num = $(".clkbox").length;
				for(var i=0; i<del_cat_num; i++){
					if($(".clkbox").eq(i).val()=="")
						flag = false;
					goods_id.push($(".clkbox").eq(i).val());
				}
				if(!flag){
					$(".clkbox").parents("ul").remove();
				}
				$.ajax({
					type: 'post',
					url: del_goods,
					data: {
						goods_id: goods_id,
					},
					success: function (data) {
						$(".clkbox").parents("ul").remove();
						/*var str = '<ul class="model_configure tag clearfix clear">' +
							'<li class="first_li key_li"><input type="checkbox" class="goods_id" name="goods_id[]" value="" /></li>' +
							'<li><input type="text" placeholder="" class="goods_name" maxlength="6"></li>' +
							'<li><a href="" class="f_goods">商品管理</a></li><li><span>0</span></li>' +
							'<li class="pos sort_li">' +
							'<span class="up">↑</span>' +
							'<span class="down">↓</span></li>' +
							'</ul>';
						if(now_cat_num-del_cat_num==0){
							$(".con_configure").append(str);
							$(".con_configure").append(str);
						}
						if(now_cat_num-del_cat_num==1){
							$(".con_configure").append(str);
						}*/
						layer.close(index);
					}
				});
			});
		}else{
			layer.msg("您未选择删除内容")
		}
	})
//	up箭头
	$("body").on("click",".up",function(){
		var goods_id = $(this).parent().siblings(".key_li").find(".goods_id").val();
		var goods_id_pre = $(this).parent().parent().prev().find(".key_li").find(".goods_id").val();
		var sort = $(this).attr("data");
		var sort_pre = $(this).parent().parent().prev().find(".sort_li").find(".up").attr("data");
		var This = $(this);
		if(goods_id==""){
			layer.msg("您选择的内容为空");
			return false;
		}
		layer.confirm('你确定要移动么？', {
			btn: ['确定','取消'] //按钮
		}, function(index){
			if(This.parents(".tag").index()==0){
				layer.msg("已经是第一位啦")
			}
			$.ajax({
				type: 'post',
				url: update_goods_sort,
				data: {
					goods_id: goods_id,
					goods_id_pre:goods_id_pre,
					sort:sort,
					sort_pre:sort_pre,
				},
				success: function (data) {
					This.attr("data",sort_pre);
					This.siblings(".down").attr("data",sort_pre);
					This.parent().parent().prev().find(".sort_li").find(".up").attr("data",sort);
					This.parent().parent().prev().find(".sort_li").find(".down").attr("data",sort);
					This.parents(".tag").prev(".tag").before(This.parents(".tag"));
					layer.close(index);
				}
			});

		});
	})
//	down箭头
	$("body").on("click",".down",function(){
		var goods_id = $(this).parent().siblings(".key_li").find(".goods_id").val();
		var goods_id_pre = $(this).parent().parent().next().find(".key_li").find(".goods_id").val();
		var sort = $(this).attr("data");
		var sort_pre = $(this).parent().parent().next().find(".sort_li").find(".down").attr("data");
		var This = $(this);
		if(goods_id==""){
			layer.msg("您选择的内容为空");
			return false;
		}
		layer.confirm('你确定要移动么？', {
			btn: ['确定','取消'] //按钮
		}, function(index){
			var len = $(".tag").length;
			if(This.parents(".tag").index()==len-1){
				layer.msg("已经是最后一位啦");
			}
			$.ajax({
				type: 'post',
				url: update_goods_sort,
				data: {
					goods_id: goods_id,
					goods_id_pre:goods_id_pre,
					sort:sort,
					sort_pre:sort_pre,
				},
				success: function (data) {
					This.attr("data",sort_pre);
					This.siblings(".up").attr("data",sort_pre);
					This.parent().parent().next().find(".sort_li").find(".down").attr("data",sort);
					This.parent().parent().next().find(".sort_li").find(".up").attr("data",sort);
					This.parents(".tag").next(".tag").after(This.parents(".tag"));
					layer.close(index);
				}
			});
		});
	})

//模板选择
	$(".m_btn_box .m_btn").on("click",function(){
		$(this).text("使用中").addClass("current").parents(".m_item").siblings(".m_item").find(".m_btn").text("使用").removeClass("current");
	})

//	商品分类模块分类名称
	$("body").on("blur",".goods_name",function(){
		var thisval = $(this).val();
		var goods_id = $(this).parent().siblings(".key_li").find(".goods_id").val();
		var _this = $(this);
		var reg = /^[\u4e00-\u9fa5]+$/;
		if(thisval=="" |thisval==" "){
			layer.msg("分类名称不能为空");
			return false;
		}/*else if(!reg.test(thisval)){
			layer.msg("请正确填写分类名称(汉字)");
			return false;
		}*/
		else{
			if(goods_id=="")
				goods_id = 0;
			$.ajax({
				type: 'post',
				url: save_goods_cat,
				data: {
					name: thisval,
					goods_id: goods_id,
				},
				success: function (data) {
					data = eval("("+data+")");
					console.log(data);
					if(data.type=="add"){
						_this.parent().siblings(".key_li").find(".goods_id").val(data.id);
						_this.parent().siblings(".sort_li").find("span").attr("data",data.sort);
						_this.parent().next().find("a").attr("href","/thematic-config/goods?id="+thematic_id+"&mid="+data.id+"&module_type=2");
					}
					if(data==""){
						layer.msg("参数错误");
					}
					else{
						layer.msg("保存成功");
					}
					/*if(data>0){
						layer.msg("保存成功");
					}
					else{
						layer.msg("参数错误");
					}*/
				}
			});
		}
	})
//	添加商品分类
	$(".add_classify").on("click",function(){
		var num = $(".model_configure").length;
		if(num==4){
			layer.msg("最多添加四个分类");
			return false;
		}
		var str = '<ul class="model_configure tag clearfix clear">' +
			'<li class="first_li key_li"><input type="checkbox" class="goods_id" name="goods_id[]" value="" /></li>' +
			'<li><input type="text" placeholder="" class="goods_name" maxlength="6"></li>' +
			'<li><a href="" class="f_goods">商品管理</a></li><li><span>0</span></li>' +
			'<li class="pos sort_li">' +
			'<span class="up">↑</span>' +
			'<span class="down">↓</span></li>' +
			'</ul>';
		$(".con_configure").append(str);
	})

// 预览发布
	$(".button_release").on("click",function(){
		$(".activity_form").submit();
	})

//点击商品分类模块中商品管理时，首先判断是否添加了分类名称
	$(".con_configure").on("click",".f_goods",function(){
		if($(this).attr("href")=="" || $(this).attr("href")=="#"){
			layer.msg("请正确填写分类名称");
			return false;
		}
	})

//输入色值时显示具体颜色
	$(".color_v").bind('input propertychange',function(){
		$(this).parent().siblings(".color_show").show().css("background-color",$(this).val());
	})

})

