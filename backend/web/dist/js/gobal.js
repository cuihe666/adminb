//验证姓名
function hinese(hinese, hinese_b) {
	var $this = hinese;
	var thisval = $this.val();
	var $tip = hinese_b;
	reg = /^([\u2E80-\u9FFF]){2,6}$/
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
	var reg = /^0?1[3|4|5|8][0-9]\d{8}$/;
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

	if(thisval.length == 0 || thisval.match(/^\s+$/g)) {
		$tip.text("银行名错误");
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
		$tip.text("开户行名错误");
		return false;
	} else {
		$tip.text("请确保支行名称填写正确，否则无法正常打款")
		return true;
	}
}
//银行账号
function luhmCheck(bankno) {
	var thisval = bankno.value;
	var lastNum = thisval.substr(thisval.length - 1, 1); //取出最后一位（与luhm进行比较）

	var first15Num = thisval.substr(0, thisval.length - 1); //前15或18位
	var newArr = new Array();
	for(var i = first15Num.length - 1; i > -1; i--) { //前15或18位倒序存进数组
		newArr.push(first15Num.substr(i, 1));
	}
	var arrJiShu = new Array(); //奇数位*2的积 <9
	var arrJiShu2 = new Array(); //奇数位*2的积 >9

	var arrOuShu = new Array(); //偶数位数组
	for(var j = 0; j < newArr.length; j++) {
		if((j + 1) % 2 == 1) { //奇数位
			if(parseInt(newArr[j]) * 2 < 9)
				arrJiShu.push(parseInt(newArr[j]) * 2);
			else
				arrJiShu2.push(parseInt(newArr[j]) * 2);
		} else //偶数位
			arrOuShu.push(newArr[j]);
	}

	var jishu_child1 = new Array(); //奇数位*2 >9 的分割之后的数组个位数
	var jishu_child2 = new Array(); //奇数位*2 >9 的分割之后的数组十位数
	for(var h = 0; h < arrJiShu2.length; h++) {
		jishu_child1.push(parseInt(arrJiShu2[h]) % 10);
		jishu_child2.push(parseInt(arrJiShu2[h]) / 10);
	}

	var sumJiShu = 0; //奇数位*2 < 9 的数组之和
	var sumOuShu = 0; //偶数位数组之和
	var sumJiShuChild1 = 0; //奇数位*2 >9 的分割之后的数组个位数之和
	var sumJiShuChild2 = 0; //奇数位*2 >9 的分割之后的数组十位数之和
	var sumTotal = 0;
	for(var m = 0; m < arrJiShu.length; m++) {
		sumJiShu = sumJiShu + parseInt(arrJiShu[m]);
	}

	for(var n = 0; n < arrOuShu.length; n++) {
		sumOuShu = sumOuShu + parseInt(arrOuShu[n]);
	}

	for(var p = 0; p < jishu_child1.length; p++) {
		sumJiShuChild1 = sumJiShuChild1 + parseInt(jishu_child1[p]);
		sumJiShuChild2 = sumJiShuChild2 + parseInt(jishu_child2[p]);
	}
	//计算总和
	sumTotal = parseInt(sumJiShu) + parseInt(sumOuShu) + parseInt(sumJiShuChild1) + parseInt(sumJiShuChild2);

	//计算Luhm值
	var k = parseInt(sumTotal) % 10 == 0 ? 10 : parseInt(sumTotal) % 10;
	var luhm = 10 - k;

	if(lastNum == luhm && lastNum.length != 0) {
		$(".account_number_b").html("");
		return true;
	} else {
		$(".account_number_b").html("银行卡号必须符合Luhm校验");
		return false;
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
		$tip.text("")
		return true;
	}
}
//酒店简称
function hostshorts() {
	var $this = $("#hostshort");
	var thisval = $this.val();
	var $tip = $(".hostshort_b");
	if(thisval.length < 10 || thisval == "") {
		$tip.text("");
		return true;

	} else {
		$tip.text("酒店简称错误");
		return false;
	}
}

//酒店类型
function hotelType(){
	var type = $("#hotel-type").val();
	if(type=="" || type=="0"){
		$(".jd_type").text("请选择酒店类型");
		return false;
	}
	else{
		$(".jd_type").text("");
		return true;
	}
}

//省市区
function province() {
	var province = $('select[name="Hotel[province]"]').val();
	var city = $('select[name="Hotel[city]"]').val();
	var district = $('select[name="Hotel[area]"]').val();
	var $tip = $(".tishi");

	if(province == '' || province=='0') {
		$tip.text("请选择省份");
		return false;
	} else if(city == '' || city=='0') {
		$tip.text("请选择城市");
		return false;
	} else if(district == '' || district == '0') {
		$tip.text("请选择区县");
		return false;
	} else {
		$tip.text("");
		return true;
	}
}
//地图
function mapeg() {
	var mapval = $("#pac-input").val();
	var maphint = $(".maphint");
	if(mapval != "") {
		maphint.text("");
		return true;
	}/* else {
		maphint.text("请选择地理位置");
		return false;
	}*/
}
//前台电话


//座机区号
function areaNum(){
	var val=$('input:radio[name="Hotel[mobile_type]"]:checked').eq(0).val();

		var phonearea = $("#phonearea").val();
		var phonehint = $(".phonehint");
		var phon = /^(0[0-9]{2,3})$/;
	if(val==null) {
		phonehint.text("<i style='color: red;font-size: 12px;margin-left: 10px;'>请选择座机</i>");
	}else if($("input[name='Hotel[mobile_type]']").get(0).checked=true){
		phonehint.after(" ");

	}
		if(phonearea==""||phonearea==null){
			phonehint.text("请填写座机区号");
			return false;
		}else if(!phon.test(phonearea)){
			phonehint.text("请正确填写座机区号");
			return false;

		}else{
			phonehint.text("");
		}

}
//座机号
function phone() {
	var phpnebody = $("#phpnebody").val();
	var phonehint = $(".phonehint");
	var pattern = /^\d{7,8}(-\d{3,4})?$/;
	if(phpnebody==""||phpnebody==null){
		phonehint.text("请填写座机号码");
		return false;
	}else if(pattern.test(phpnebody)) {
		phonehint.text("");
	} else {
		phonehint.text("请正确填写座机号");
		return false;
	}
}
//手机
function mobile() {
	var value = $(".shouji_sxh").val();
	var reg = /^0?1[3|4|5|8][0-9]\d{8}$/;
	if(value=="" || value==null){
		$(".tip_sxh").text("请填写手机号");
		return false;
	}
	if(!reg.test(value)){
		$(".tip_sxh").text("请输入正确手机号");
		return false;
	}else{
		$(".tip_sxh").text("");
		return true;
	}
}
function checkPhone() {
	var phonearea = $("#phonearea").val();
	var phpnebody = $("#phpnebody").val();
	var phonehint = $(".phonehint");
	var phon = /^\d{3,4}$/;
	var pattern = /^\d{7,8}(-\d{3,4})?$/;
	var val1=$('#radio1:checked').val();
	var val2=$('#radio2:checked').val();
	if(val1==null && val2==null){
		$(".phonehint").eq(0).text("请选择前台联系方式");
		return false;
	}else if(val1!=null && val2==null){ //选择座机
		$('.tip_sxh').text("");
		if(phonearea==""||phonearea==null||phpnebody==""||phpnebody==null){
			$("#radio1").siblings('.phonehint').text("请完整填写座机区号及号码");
			return false;
		}else if(phon.test(phonearea) && pattern.test(phpnebody)) {
			$("#radio1").siblings('.phonehint').text("");
			return true;
		} else {
			$("#radio1").siblings('.phonehint').text("请正确填写座机号");
			return false;
		}

	}else if(val2!=null && val1==null){ // 选择手机
		var status = mobile();
		$("#radio1").siblings('.phonehint').text("");
		return status;

	}

}
//传真
function faxs() {
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
function codes() {
	var code = $("#code").val();
	var codeg = /^[0-8]\d{5}$/;
	var codehint = $(".code_hint");
	if(code!=""){
		if(!codeg.test(code)) {
			codehint.text("请输入正确的邮编");
			return false;
		} else {
			codehint.text("")
			return true;
		}
	}
	else
		return true;
}
//酒店简介
function briefs() {
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
	if(hotelname($('#bankname'), $('.bankname_b')) && hostshorts($('#bankname'), $('.bankname_b')) && hotelType() && province() && mapeg() && checkPhone() && faxs() && codes() && briefs()) {
		$(".hotel-form").submit();
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
    var bed_type = $("select[name='type']").val();
    var bed_num = $("input[name='bed_num']").val();
    var bed_width = $("input[name='bed_width']").val();
    var bed_num1 = $("input[name='bed_num1']").val();
    var bed_width1 = $("input[name='bed_width1']").val();
    var bed_num2 = $("input[name='bed_num2']").val();
    var bed_width2 = $("input[name='bed_width2']").val();
    var other_bed_type = $("input[name='other_bed_type']").val();
    if(bed_type == '请选择' || bed_type.match(/^\s+$/g)){
        $(".bed").text("床型不能为空");
        return false;
    } else if(bed_type == '2' && (!bed_num1 || !bed_num2)){
        $(".bed").text("床的数量不能为空");
        return false;
    } else if(bed_type == '2' && (!bed_width1 || !bed_width2)){
        $(".bed").text("床的宽度不能为空");
        return false;
    } else if(bed_type == '11' && (!other_bed_type || other_bed_type.match(/^\s+$/g))){
		$('.bed').text('床型详情不能为空');
		return false;
	} else if(bed_type != '2' && !bed_num){
        $(".bed").text("床的数量不能为空");
        return false;
	} else if(bed_type != '2' && !bed_width){
        $(".bed").text("床的宽度不能为空");
        return false;
	} else {
    	$(".bed").text("");
    	return true;
	}
	/*var bed = $("#bed").val();
	if(bed.length == 0 || bed.match(/^\s+$/g)) {
		$(".bed").text("床型不能为空")
		return false;
	} else {
		$(".bed").text("")
		return true;
	}*/
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
//取消政策
function refund_type() {
	var refund_type = $(".refund_type").val();
	if(refund_type==""){
		$(".refund_type_i").text("请选择取消政策");
		return false;
	} else {
		$(".refund_type_i").text("")
		return true;
	}
}

function house_save() {
	console.log('00000');
	//当前操作为添加的时候判断
	if($("#optype").val()==1){
		if(!$("#uploader").find("input[type='hidden']").hasClass("pic")){
			$(".pic_text").text("请上传房型图片")
			return false;
		}
		else{
			var picNum = $("#uploader").find(".pic").length;
			if(picNum<1){
				$(".pic_text").text("请至少上传1张房型图片")
				return false;
			}
			else{
				$(".pic_text").text("")
			}
		}
	}
	if($("#optype").val()==2){
		if(!$(".ul_pic").find("li").hasClass("house_imgs") && !$("#uploader").find("input[type='hidden']").hasClass("pic")){
			$(".pic_text").text("请上传房型图片")
			return false;
		}
		else{
			var picNum1 = $(".house_imgs").length;
			var picNum2 = $("#uploader").find(".pic").length;
			var picNum = parseInt(picNum1+picNum2)
			if(picNum<1){
				$(".pic_text").text("请至少上传1张房型图片")
				return false;
			}
			else{
				$(".pic_text").text("")
			}
		}
	}
	console.log('11111');
	if(houst_name() && cereal() && bed() && maxnumber() && houst_area() && refund_type()) {
		$(".hotel-form").submit();
	} else {
		return false;
	}
}

function pic_save() {
	//当前操作为添加的时候判断
	if($("#type").val()==1){
		$(this).parent(".hotel-form").submit();
		/*alert($(this).siblings(".f_wrapper").find(".filelist").html());
		if(!$(this).siblings(".f_wrapper").find("input[type='hidden']").hasClass("pic")){
			$(".pic_text1").text("请上传酒店外观图片")
			return false;
		}
		else{
			var picNum = $(this).siblings(".f_wrapper").find(".pic").length;
			alert(picNum);
			if(picNum<5){
				$(".pic_text1").text("请至少上传5张酒店外观图片")
				return false;
			}
			else{
				$(".pic_text1").text("")
			}
		}*/
	}
	if($("#type").val()==2){
		if(!$(".ul_pic").find("li").hasClass("house_imgs") && !$("#uploader").find("input[type='hidden']").hasClass("pic")){
			$(".pic_text").text("请上传房型图片")
			return false;
		}
		else{
			var picNum1 = $(".house_imgs").length;
			var picNum2 = $("#uploader").find(".pic").length;
			var picNum = parseInt(picNum1+picNum2)
			if(picNum<5){
				$(".pic_text").text("请至少上传5张房型图片")
				return false;
			}
			else{
				$(".pic_text").text("")
			}
		}
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
		$(".hotel-form").submit();
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
		return false;
	} else {
		return true;
	}
}

//酒店政策验证
function reminder_btn(){
	gys_hinese()
}
//酒店设施验证
function policyBtn() {
	var check1=$(".core").is(":checked");
	var check2=$(".house").is(":checked");
	var check3=$(".service").is(":checked");
	var check4=$(".facilities").is(":checked");
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

	$(".hotel-form").submit();
}
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

	$("body").on('click', '.shoutu', function() {
		$(this).parents(".file-panel").siblings(".shoutublock").addClass("first_pic");
		$(this).parents(".file-item").siblings().find('.shoutublock').removeClass("first_pic");
	})

})

$(function(){
	$("#radio1").on("click", function () { // 前台电话radio check
		var val=$('#radio1:checked').val();
		if(val!=null){
			$("#phonearea").removeAttr("disabled");
			$("#phpnebody").removeAttr("disabled");
			$("#mobile_m").attr("disabled","disabled");

		}else{
			$("#phonearea").attr("disabled","disabled");
			$("#phpnebody").attr("disabled","disabled");

		}
	})
	$("#radio2").on("click", function () {
		var val=$('#radio2:checked').val();
		if(val!=null){
			$("#mobile_m").removeAttr("disabled");
			$("#phonearea").attr("disabled","disabled");
			$("#phpnebody").attr("disabled","disabled");
		}else{
			$("#mobile_m").attr("disabled","disabled");

		}
	})
})