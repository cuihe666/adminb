//验证姓名
function hinese(hinese, hinese_b) {
	var $this = hinese;
	var thisval = $this.val();
	var $tip = hinese_b;
	reg = /^([\S]){2,50}$/
	if(!reg.test(thisval)) {
		$tip.text("联系人格式不正确");
		return false;
	} else {
		$tip.text("")
		return true;
	}
}
//验证电话
function cellNumber(cellNumber, cellNumber_b) {
	var $this = cellNumber;
	var thisval = $this.val();
	var $tip = cellNumber_b;
	var reg = /^0?1[3|4|5|7|8][0-9]\d{8}$/;
	if(!reg.test(thisval)) {
		$tip.text("手机号错误");
		return false;
	} else {
		$tip.text("")
		return true;
	}
}
//验证邮箱
function checkmail(checkMail, checkMail_b) {
	var $this = checkMail;
	var thisval = $this.val();
	var $tip = checkMail_b;
	var reg = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	if(thisval == "") {
		//		console.log(444);
		$tip.text("");
		return true;
	} else {
		if(!reg.test(thisval) && thisval != "") {
			//			console.log("5555")
			$tip.text("您的电子邮件格式不正确");
			return false;
		} else {
			//			console.log(33333);
			$tip.text("");
			return true;
		}
	}
}
////验证银行名称
function bankname(bankname, bankname_b) {
	var $this = bankname;
	var thisval = $this.val();
	var $tip = bankname_b;
//2017年5月8日17:09:34 zjl 错误提示为红色
	if(thisval.length == 0 || thisval.match(/^\s+$/g)) {
		$tip.text("银行名错误").css("color","red");
		return false;
	} else {
		$tip.text("请确保开户银行名称填写正确，否则无法正常打款")
		return true;
	}
}
////开户支行名称
function openingbank() {
	var $this = $("#openingbank");
	var thisval = $this.val();
	var $tip = $(".openingbank_b");
	if(thisval.length < 1) {
		$tip.text("开户行名错误").css("color","red");;
		return false;
	} else {
		$tip.text("请确保支行名称填写正确，否则无法正常打款")
		return true;
	}
}
//银行账号
//    2017年5月27日15:49:15 xhh修改了银行账号验证
function luhmCheck(bankno) {
	var age = /^\d+$/;
	var thisval = bankno.value;
	if(!age.test(thisval)) {
		$(".account_number_b").html("银行卡号格式错误");
		return false;
	} else {
		$(".account_number_b").html("");
		return true;
	}
}
function next() {
	if(hinese($('#hinese'), $('.hinese_b')) && cellNumber($('#cellNumber'), $('.cellNumber_b')) && checkmail($('#checkMail'), $('.checkMail_b')) && bankname($('#bankname'), $('.bankname_b')) && openingbank() && hinese($('#username'), $('.username')) && luhmCheck(this)) {

	} else {
		return false;
	}
}
//酒店信息
//酒店名称
function hotelname(bankname, bankname_b) {
	var $this = bankname;
	var thisval = $this.val();
	var $tip = bankname_b;
	if(thisval.length == 0 || thisval.match(/^\s+$/g)) {
		$tip.text("酒店名称错误");
		return false;
	} else {
		$tip.text("请确保开户银行名称填写正确，否则无法正常打款")
		return true;
	}
}
//酒店简称
function hostshort() {
	var $this = $("#hostshort");
	var thisval = $this.val();
	var $tip = $(".hostshort_b");
	if(thisval.length < 10 || thisval == "") {
		$tip.text("请确保支行名称填写正确，否则无法正常打款");
		return true;

	} else {
		$tip.text("酒店简称错误");
		return false;
	}
}
//省市区
function province() {
	var province = $('select[name="province"]').val();
	var city = $('select[name="city"]').val();
	var district = $('select[name="district"]').val();
	var $tip = $(".tishi");
	if(province == '0') {
		$tip.text("请选择省份!");
		return false;
	} else if(city == '0') {
		$tip.text("请选择市!");
		return false;
	} else if(district == '0') {
		$tip.text("请选择区!");
		return false;
	} else {
		$tip.text("");
		return true;
	}
}
//地图
function mapeg() {
	var mapval = $("#keyword").val();
	var maphint = $(".maphint");
	if(mapval != "") {
		maphint.text("");
		return true;
	} else {
		maphint.text("请选择地理位置!");
		return false;
	}
}
//前台电话
function phone() {
	var phonearea = $("#phonearea").val();
	var phpnebody = $("#phpnebody").val();
	var phonehint = $(".phonehint");
	var phon = /^\d{3,4}$/;
	var pattern = /^\d{7,8}(-\d{3,4})?$/;
	if(phon.test(phonearea) && pattern.test(phpnebody)) {
		phonehint.text("");
		return true;
	} else {
		phonehint.text("请认真填写")
		return false;
	}
}
//传真
function fax() {
	var hotelfax = $("#fax").val();
	var faxbody = $("#faxbody").val();
	var faxtishi = $(".faxtishi");
	var faxeg = /^\d{3,4}$/;
	var pattern = /^\d{7,8}(-\d{3,4})?$/;
	if(hotelfax == "" && faxbody == "") {
		faxtishi.text("");
		return true;
	} else {
		if(faxeg.test(hotelfax) && pattern.test(faxbody)) {
			faxtishi.text("");
			return true;
		} else {
			faxtishi.text("请认真填写")
			return false;
		}
	}

}
//邮编
function code() {
	var code = $("#code").val();
	var codeg = /^[0-8]\d{5}$/;
	var codehint = $(".code_hint");
	if(!codeg.test(code)) {
		codehint.text("请输入正确的邮编");
		return false;
	} else {
		codehint.text("")
		return true;
	}
}
//酒店简介
function brief() {
	var brief = $("#brief");
	var briefval = brief.val();
	var $tip = $(".briefhint");
	if(briefval.length == 0 || briefval.match(/^\s+$/g)) {
		$tip.text("请填写酒店简介");
		return false;
	} else {
		$tip.text("");
		return true;
	}
}

function save() {
	if(hotelname($('#bankname'), $('.bankname_b')) && hostshort($('#bankname'), $('.bankname_b')) && province() && mapeg() && phone() && fax() && code() && brief()) {

	} else {
		return false;

	}
}
//房型名称
function houst_name() {
	var houst_name = $('#houst_name').val();
	if(houst_name.length == 0 || houst_name.match(/^\s+$/g)) {
		$(".houst_name").text("房型名称不能为空")
		return false;
	} else {
		$(".houst_name").text("")
		return true;
	}
}
//早餐
function cereal() {
	var cereal = $("#cereal").val();
	if(cereal.length == 0 || cereal.match(/^\s+$/g)) {
		$(".cereal").text("早餐不能为空")
		return false;
	} else {
		$(".cereal").text("")
		return true;
	}
}
//床型
function bed() {
	var bed = $("#bed").val();
	if(bed.length == 0 || bed.match(/^\s+$/g)) {
		$(".bed").text("床型不能为空")
		return false;
	} else {
		$(".bed").text("床型名称不可过长，建议输入大床、双床等床型")
		return true;
	}
}
//最大可住人数
function maxnumber() {
	var maxnumber = $("#maxnumber").val();
	if(maxnumber == "") {
		$(".maxnumber").text("人数不能为空")
		return false;
	} else {
		$(".maxnumber").text("")
		return true;
	}
}
//面积
function houst_area() {
	var houst_area = $("#houst_area").val();
	if(houst_area.length == 0 || houst_area.match(/^\s+$/g)) {
		$(".houst_area").text("面积不能为空");
		return false;
	} else {
		$(".houst_area").text("")
		return true;
	}
}
//销售时段
function houst_time() {
	var houst_time = $("#houst_time").val();
	if(houst_time.length == 0 || houst_time.match(/^\s+$/g)) {
		$(".houst_time").text("面积不能为空");
		return false;
	} else {
		$(".houst_time").text("")
		return true;
	}
}

function house_save() {
	if(houst_name() && cereal() && bed() && maxnumber() && houst_area() && houst_time()) {
		return false;
	} else {
		return true;
	}
}

//供应商资质管理
function gys_hinese() {
	var gys_hinese = $('#gys_hinese').val();
	if(gys_hinese.length == 0 || gys_hinese.match(/^\s+$/g)) {
		$(".gys_hinese_b").text("请认真填写")
		return false;
	} else {
		$(".gys_hinese_b").text("")
		return true;
	}
}
//日历验证
function rili() {
	var $tip3 = $("#date-em");
	var $date = $("#d422");
	var $datetwo = $("#d4312");
	var $dateval = $date.val();
	var $datetwoval = $datetwo.val();
	if($dateval == "" && $datetwoval == "" || $dateval == "" || $datetwoval == "") {
		$tip3.text("请填写起始、结束日期")
		return false;
	} else {
		$tip3.text("")
		return true;
	}
	return false;
}

function upload() {
	var upload1 = $("#container .filelist").find("li");
	var upload2 = $("#container2 .filelist").find("li");
	var upload3 = $("#container3 .filelist").find("li");
	if(upload1.length <= 0) {
		$(".zhizhao").text("请上传图片");
		return false;
	} else {
		$(".zhizhao").text("");

	}
	if(upload2.length <= 0) {
		$(".xukezheng").text("请上传图片");
		return false;
	} else {
		$(".xukezheng").text("");

	}
	if(upload3.length <= 0) {
		$(".xieyi").text("请上传图片");
		return false;
	} else {
		$(".xieyi").text("");

	}
}

function baocun() {
	if(gys_hinese() && rili() && upload()) {
		console.log('false');
		return false;
	} else {
		console.log('true');
		return true;
	}
}

//酒店政策验证
function reminder_btn(){
	gys_hinese()
}
//酒店设施验证
function policyBtn() {
	var check1=$("[name='one-checkbox']").is(":checked");
	var check2=$("[name='two-checkbox']").is(":checked");
	var check3=$("[name='th-checkbox']").is(":checked");
	var check4=$("[name='for-checkbox']").is(":checked");
	if(check1===true) {
		$(".sheshi_i").text("");
	}else {
		$(".sheshi_i").text("请勾选核心设施");
		return false;
	}
	if(check2===true) {
		$(".home_i").text("");
	}else {
		$(".home_i").text("请勾选房间设施");
		return false;
	}
	if(check3===true) {
		$(".th_checkbox_i").text("");
	}else {
		$(".th_checkbox_i").text("请勾选酒店服务");
		return false;
	}
	if(check4===true) {
		$(".for_checkbox_i").text("");
		
	}else {
		$(".for_checkbox_i").text("请勾选酒店设施");
		return false;
	}
}
$(function(){
	//以下是对酒店供应商的账户信息的输入验证
	//财务联系人
	$('#hinese').blur(function(){
		hinese($('#hinese'),$('.hinese_b'))
	});
	//联系人手机
	$('#cellNumber').blur(function(){
		cellNumber($('#cellNumber'),$('.cellNumber_b'));
	})
	//联系人邮箱
	$('#checkMail').blur(function(){
		checkmail($('#checkMail'),$('.checkMail_b'));
	});
	//银行名称
	$('#bankname').blur(function(){
		bankname($('#bankname'),$('.bankname_b'));
	});
	//开户支行名称
	$('#openingbank').blur(function(){
		openingbank();
	});
	//户名
	$('#username').blur(function(){
		var thisval = $(this).val();
		//2017年5月8日19:11:56 zjl
		//hinese($('#username'),$('.username'));
		var reg = /^(\S){0,50}$/
		if(thisval.length == 0 ||thisval.match(/^\s+$/g)) {
			$(this).siblings("i.username").text("户名不能为空");
			return false;
		}else if(!reg.test(thisval)) {
			$(this).siblings("i.username").text("户名格式不正确");
			return false;
		} else {
			$(this).siblings("i.username").text("")
			return true;
		}

	});
	//银行帐号
	$('#account_number').blur(function(){
		luhmCheck(this)
	});

	//以下是酒店供应商上传资料时的验证
	//供应商名称
	$('#gys_hinese').blur(function(){
		gys_hinese();
	})
	//提交前的验证
	$('#credential_submit').click(function(){
		baocun();
	})


})
//tab切换
$(document).ready(function() {
	$(".active_one").eq(0).addClass("on")
	$(".financial_header li").click(function() {
		$(this).addClass("bac").siblings().removeClass('bac');
		$(".active_one").eq($(".financial_header li").index(this)).addClass("on").siblings().removeClass('on');
	});
	//取消政策显示为限时取消的时候显示时间时间列表
	$(".house_table_select").change(function() {
		var province = $('select[name="house_table_time"]').val();
		if(province == "限时取消") {
			$(".hide_time").show();
		} else {
			$(".hide_time").hide();
		}
	})

//	$("body").on('click', '.shoutu', function() {
//		$(this).parents(".file-panel").siblings(".shoutublock").show();
//		$(this).parents(".file-item").siblings().find('.shoutublock').hide();
//	})

})