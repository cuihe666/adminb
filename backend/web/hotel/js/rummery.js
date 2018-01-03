$(function(){
//	酒店管理详情页 tab
function rummery_tab(source,current,source_p,rummery_con,rummery_item){
	$(source).click(function(){
		var i= $(this).index();
		$(this).addClass(current).siblings(source).removeClass(current);
		$(this).parent(source_p).siblings(rummery_con).children(rummery_item).eq(i).show().siblings(rummery_item).hide();
	})
}
// rummery_tab(".rummery_tab>li","current",".rummery_tab",".rummery_con",".rummery_item");
rummery_tab(".house_price_tab>li","current",".house_price_tab",".house_price_con",".house_price_item");


	//酒店供应商-基本信息 表单提交
	$('#addForm').submit(function(){
		var contact_num = $('#contact_num').val();
		var res1 = suppy_name();
		var res2 = add_detail();
		var res3 = false;
		// if(contact_num < 1){
		// 	$('#contact_error').show();
		// 	res3 = false;
		// }else{
		// 	$('#contact_error').hidden();
		// 	res3 = true;
		// }

		if(res1 && res2){
			return true;
		}else{
			return false;
		}
	});

	//酒店供应商-账号信息 表单提交
	$('#account-form').submit(function(){
		var account_user = hinese($('#hinese'),$('.hinese_b'));
		var account_phone = cellNumber($('#cellNumber'),$('.cellNumber_b'));
		var account_bank_name = bankname($('#bankname'),$('.bankname_b'));
		var account_openingbank = openingbank();
		var account_name = hinese($('#username'),$('.username'));
		var account_bank_number = luhmCheck($('#account_number')[0]);
		// console.log(account_user , account_phone , account_bank_name , account_openingbank , account_name);
		if ($("#top_account_type_val").val() == 1) {
            if(account_user && account_phone && account_bank_name && account_openingbank && account_name && account_bank_number){
                return true;
            }else{
                return false;
            }
		} else {
			return true;
		}
	});



//single alter house status 
$("body").on("click",".cal_con>li>.fangtai_item",function(){
	$("#single_modal").modal("show");
})
//single house add reduce  todo 
$("body").on("click","#single_modal .single_house_reduce",function(){
	$(this).siblings("input[type='text']").val()+1;
})
//点击修改底价
$("body").on("click","#edit_price",function(e){
	if (e.stopPropagation){
		e.stopPropagation(); 
	}else{ 
		e.cancelBubble = true; 
	} 
	$(this).parent(".last_click").siblings(".click_con").find(".dijia_input").show().siblings(".dijia").hide();
})
//点击修改佣金
$("body").on("click","#edit_money",function(e){
	if (e.stopPropagation){
		e.stopPropagation(); 
	}else{ 
		e.cancelBubble = true; 
	} 
	$(this).parent(".last_click").siblings(".click_con").find(".yongjin_input").show().siblings(".yongjin").hide();
})
//冒泡
$("body").on("click",".click_con",function(e){
	if (e.stopPropagation){
		e.stopPropagation(); 
	}else{ 
		e.cancelBubble = true; 
	} 
})
//保存修改佣金,底价
$(document).on("click",function(e){
	$(".yongjin_input").hide();
	$(".yongjin").show();
	$(".dijia_input").hide();
	$(".dijia").show();
	
})

//房态房价 弹框验证
$("body").on("click","#single_fangtai_sure",function(){
	var val=$('input:radio[name="house_status_single"]:checked').val();
	if(val==null){
	    alert("请选择房源状态");
	    return false;
	}
	var list= $('input:radio[name="house_num_single"]:checked').val();
	if(list==null){
	    alert("请选择可售数量");
	    return false;
	}
	$(this).parents("#single_modal").modal("hide");
})

$("body").on("click","#more_fangtai_sure",function(){
	var val=$('input:checked[name="house_name"]:checked').val();
	if(val==null){
	    alert("请选择房型");
	    return false;
	}
	if($("input.fangtai_date1").val()==""&&$("input.fangtai_date2").val()==""||$("input.fangtai_date1").val()==""||$("input.fangtai_date2").val()==""){
		alert("请选择日期");
		return false;
	}
	var val=$('input:checked[name="house_week"]:checked').val();
	if(val==null){
	    alert("请选择有效星期");
	    return false;
	}
	var val=$('input:radio[name="house_status"]:checked').val();
	if(val==null){
	    alert("请选择房源状态");
	    return false;
	}
	var list= $('input:radio[name="house_num"]:checked').val();
	if(list==null){
	    alert("请选择可售数量");
	    return false;
	}

	$(this).parents("#more_modal").modal("hide");
})

$("body").on("click","#more_fangjia_sure",function(){
	var val=$('input:checked[name="house_name_price"]:checked').val();
	if(val==null){
	    alert("请选择房型");
	    return false;
	}
	if($("input.fangjia_date1").val()==""&&$("input.fangjia_date2").val()==""||$("input.fangjia_date1").val()==""||$("input.fangjia_date2").val()==""){
		alert("请选择日期");
		return false;
	}
	var val=$('input:checked[name="house_week_price"]:checked').val();
	if(val==null){
	    alert("请选择有效星期");
	    return false;
	}
	var val=$('input:radio[name="house_status_price"]:checked').val();
	if(val==null){
	    alert("请选择房源状态");
	    return false;
	}
	var list= $('input:radio[name="house_num_price"]:checked').val();
	if(list==null){
	    alert("请选择可售数量");
	    return false;
	}

	$(this).parents("#more_modal_price").modal("hide");
})

// //点击添加联系人
// $(".add_person").on("click",function(){
// 	var str = '<ul class="content_item content_con clearfix"><li class="li_item"><span style="display:none;">业务联系人</span><input type="text" placeholder="请输入联系人" style="display:block"></li><li class="li_item"><span style="display:none;">王小毛</span><input type="text" placeholder="请输入姓名" style="display:block"></li><li class="li_item"><span style="display:none;">店长</span><input type="text" placeholder="请输入职务" style="display:block"></li><li class="li_item"><span style="display:none;">18888888888</span><input type="text" placeholder="请输入手机号码" style="display:block"></li><li class="li_item"><span style="display:none;">asd@qq.com</span><input type="text" placeholder="请输入E-mail" style="display:block"></li><li class="li_item"><span style="display:none;">010-12345678</span><input type="text" placeholder="请输入电话" style="display:block"></li><li class="li_item"><div class="op_eds"><p class="edit" style="display:none;">编辑</p><p class="save" style="display:block">保存</p></div><p class="delete">删除</p></li></ul>';
// 	$(this).siblings(".contact_box").append(str);
// })
// //点击修改联系人
// $("body").on("click",".op_eds>.edit",function(){
// 	$(this).parents(".li_item").siblings(".li_item").find("span").hide().siblings("input[type='text']").show();
// 	$(this).hide().siblings(".save").show();
// })
// //点击保存联系人
// $("body").on("click",".op_eds>.save",function(){
// 	$(this).parents(".li_item").siblings(".li_item").find("input[type='text']").hide().siblings("span").show();
// 	$(this).hide().siblings(".edit").show();
// })
// //点击删除联系人
// $("body").on("click",".li_item>.delete",function(){
// 	$(this).parents(".content_item").remove();
// })

//房间数量增加
function add_num(add){
	$(add).click(function(){
		var val = parseInt($(this).siblings("input[type='text']").val());
		val++;
		$(this).siblings("input[type='text']").val(val);
	})
}
add_num(".single_house_add");
add_num(".more_house_add");
function reduce_num(reduce){
	$(reduce).click(function(){
		var val = parseInt($(this).siblings("input[type='text']").val());
		val--;
		if(val<0){
			$(this).siblings("input[type='text']").val(0);
			return false;
		}
		$(this).siblings("input[type='text']").val(val);
	})
}
reduce_num(".single_house_reduce");
reduce_num(".more_house_reduce");

})
//供应商基本信息-验证信息
//验证供应商不能为空
function suppy_name(){
	var suppy = $("#suppy_name").val();
	if(suppy==""||suppy.substring(0,suppy.length)==0){
		$("#suppy_name").siblings("i").show();
		return false;
	}else{
		$("#suppy_name").siblings("i").hide();
		return true;
	}
}
function suppy_name2(){
	var suppy = $("#suppy_name2").val();
	if(suppy==""||suppy.substring(0,suppy.length)==0){
		$("#suppy_name2").siblings("i").show();
		return false;
	}else{
		$("#suppy_name2").siblings("i").hide();
		return true;
	}
}
//验证地址不能为空
function add_detail(){
	var suppy = $("#add_detail").val();
	console.log(suppy.length)
	console.log(suppy)
	if(suppy==""||suppy.substring(0,suppy.length)==0){
		$("#add_detail").parent(".address_box").siblings("i").show();
		return false;
	}else{
		$("#add_detail").parent(".address_box").siblings("i").hide();
		return true;
	}
}