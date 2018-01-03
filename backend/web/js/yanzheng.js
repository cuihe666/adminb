$(function(){
	$(".submit").on("click", function(){
		var is_abroad = 0;
		var is_travel_ag = 0;
		var pay_platform = 0;
		var reg = /^(\w)+(\.\w+)*@(\w)+((\.\w+)+)$/;
		for(var i = 0; i < $(".count .lxs_type").length; i++){
	        if($(".count .lxs_type").eq(i).find("input").attr("checked") == "checked"){
	            is_abroad = i;
	            break;
	        }
	    }
	    for(var i = 0; i < $(".travel_agency .lxs_type").length; i++){
	        if($(".travel_agency .lxs_type").eq(i).find("input").attr("checked") == "checked"){
	            is_travel_ag = i;
	            break;
	        }
	    }
	    for(var i = 0; i < $(".card_t").length; i++){
	    	if($(".card_t").eq(i).find("input").attr("checked") == "checked"){
	    		pay_platform = i;
	    		break;
	    	}
	    }
		if($.trim($("#regcity").val()) == ""){
			layer.alert("请添加公司注册国家省市!");
			return false;
		}
		if($.trim($("#travelcompany-name").val()) == ""){
			layer.alert("请填写公司全称!");
			return false;
		}
		if($.trim($("#travelcompany-company_address").val()) == ""){
			layer.alert("请填写公司地址!");
			return false;
		}
		if($.trim($("#travelcompany-recommend").val()) == ""){
			layer.alert("请填写公司介绍!");
			return false;
		}
		if($.trim($("#travelcompany-brandname").val()) == ""){
			layer.alert("请填写公司主业品牌名称!");
			return false;
		}
		//console.log($("input[name='TravelCompany[travel_avatar]']").val()); return false;
		if($("input[name='TravelCompany[travel_avatar]']").val() == "0" || $("input[name='TravelCompany[travel_avatar]']").val() == ""){
			layer.alert("请添加头像!");
			return false;
		}
		if($.trim($("#travelcompany-business_name").val()) == ""){
			layer.alert("请填写业务联系人姓名!");
			return false;
		}
		if($.trim($("#travelcompany-business_tel").val()) == ""){
			layer.alert("请填写业务联系人电话!");
			return false;
		}
		if($.trim($("#travelcompany-business_tel").val()).length > 20){
			layer.alert("请填写正确的手机号码!");
			return false;
		}
		if($.trim($("#travelcompany-business_email").val()) == ""){
			layer.alert("请填写邮箱!");
			return false;
		}
		if(!reg.test($.trim($("#travelcompany-business_email").val()))){
			layer.alert("请输入正确的邮箱");
			return false;
		}
		if($.trim($("#travelcompany-finance_name").val()) == ""){
			layer.alert("请添加财务联系人姓名!");
			return false;
		}
		if($.trim($("#travelcompany-finance_tel").val()) == ""){
			layer.alert("请添加财务联系人电话!");
			return false;
		}
		if($.trim($("#travelcompany-finance_tel").val()).length > 20){
			layer.alert("请填写正确的财务联系人电话!");
			return false;
		}
		if($.trim($("#travelcompany-finance_email").val()) == ""){
			layer.alert("请添加邮箱!");
			return false;
		}
		if(!reg.test($.trim($("#travelcompany-finance_email").val()))){
			layer.alert("请输入正确的邮箱");
			return false;
		}
		// 判断是国内还是国外，是旅行社还是非旅行社
		if(is_abroad == 0){
			if($("input[name='TravelCompany[license]']").val() == "0" || $("input[name='TravelCompany[license]']").val() == ""){
				layer.alert("请添加营业执照副本!");
				return false;
			}
			if($("input[name='TravelCompany[proposer_a]']").val() == "0" || $("input[name='TravelCompany[proposer_b]']").val() == "0" || $("input[name='TravelCompany[proposer_a]']").val() == "" || $("input[name='TravelCompany[proposer_b]']").val() == ""){
				layer.alert("请添加申请人身份证!");
				return false;
			}
			if(is_travel_ag == 0){
				if($("input[name='TravelCompany[operation]']").val() == "0" || $("input[name='TravelCompany[operation]']").val() == ""){
					layer.alert("请添加旅行社经营资格证!");
					return false;
				}
				if($("input[name='TravelCompany[policy]']").val() == "0" || $("input[name='TravelCompany[policy]']").val() == ""){
					layer.alert("请添加旅行社责任险保险单!");
					return false;
				}
			}
		}else if(is_abroad == 1 || is_abroad == 2 || is_abroad == 3){
			console.log(222)
			if($("input[name='TravelCompany[reg_file]']").val() == "" || $("input[name='TravelCompany[reg_file]']").val() == "0"){
				layer.alert("请添加公司登记注册文件");
				return false;
			}
			if($("input[name='TravelCompany[corporation_id_a]']").val() == "0" || $("input[name='TravelCompany[corporation_id_b]']").val() == "0" || $("input[name='TravelCompany[corporation_id_a]']").val() == "" || $("input[name='TravelCompany[corporation_id_b]']").val() == ""){
				layer.alert("请添加企业法人身份证件!");
				return false;
			}
			if($("input[name='TravelCompany[proposer_a]']").val() == "0" || $("input[name='TravelCompany[proposer_b]']").val() == "0" || $("input[name='TravelCompany[proposer_a]']").val() == "" || $("input[name='TravelCompany[proposer_b]']").val() == ""){
				layer.alert("请添加申请人身份证!");
				return false;
			}
		}
		// 支付方式出现区别后，添加信息相应改变
		if(pay_platform == 0){// 银行账号
			if($.trim($("input[name='travelAccountBank[account_name]']").val()) == ""){
				layer.alert("请填写开户名称!");
				return false;
			}
			if($.trim($("input[name='travelAccountBank[account_num]']").val()) == ""){
				layer.alert("请填写收款账号!");
				return false;
			}
			if($.trim($("input[name='travelAccountBank[account_bank]']").val()) == ""){
				layer.alert("请填写开户行!");
				return false;
			}
		}else{// 支付宝
			if($.trim($("input[name='travelAccountBank[account_name_ali]']").val()) == ""){
				layer.alert("请填写支付宝名称!");
				return false;
			}
			if($.trim($("input[name='travelAccountBank[account_num_ali]']").val()) == ""){
				layer.alert("请填写支付宝账号!");
				return false;
			}
		}
		//$("form").submit();
	})
	
})