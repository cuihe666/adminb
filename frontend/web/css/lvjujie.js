$(function() {
//弹窗
	$(".x_yanze").click(function(){
		$(".layer5").show();
		$(".close").click(function(){
			$(".layer5").hide();
		})
	})
//	优惠券
	$('label').click(function() {
		var radioId = $(this).attr('name');
		$(this).addClass("checked").parents(".x_coupon").siblings(".x_coupon").find("label").removeClass("checked");
		$('input[type="radio"]').removeAttr('checked') && $('#' + radioId).attr('checked', 'checked');
	});

//	侧导航
	var lilen = $(".nav_cont li");
	lilen.click(function() {
		$(this).css("background","#ffe0ae").siblings().css("background","")
		var index = $(this).index();
		var hei = $(".offset_top").eq(index).offset().top;
		$("body:not(animated)").animate({
			scrollTop: hei
		}, 1000)
	})

	// 2017年6月15日 16:55:40 宋杏会 侧边导航z-index层级问题
	$(".foot_hide").click(function(){
		$(".libao_posi").fadeIn(2000)
		// $(".hide_nav").fadeOut();
        $(".fixed_nav").animate({top:"-480px"},1500)
	})
	$(".nav_hide").click(function(){
		$(".libao_posi").hide();
		// $(".hide_nav").fadeIn(2000);
		$(".fixed_nav").css("z-index","3").show().animate({top:"103px"},1500);
		// if($("body").width()<=375){
         //    $(".fixed_nav").animate({top:"117px"},1500);
		// }else if($("body").width()<=320){
         //    $(".fixed_nav").animate({top:"99px"},1500);
		// }
		// if($("body").width()<=320){
         //    $(".fixed_nav").animate({top:"99px"},1500);
		// }
	})

	// 2017年6月15日15:54:50 宋杏会
	$(".arch_tu .arch_07").click(function(){
		window.location.href = "coupon.html";
		$(this).children("img").attr("src","images/i_yhq_10.png")
	})
	$(".arch_tu .arch_09").click(function(){
		window.location.href = "coupon.html";
		$(this).children("img").attr("src","images/i_yhq_30.png")
	})
	$(".arch_tu .arch_11").click(function(){
		window.location.href = "coupon.html";
		$(this).children("img").attr("src","images/i_yhq_50.png")
	})

})
$(document).ready(function() {
//	tab切换
// 	$(".laca_li li").click(function() {
// 		$(this).addClass("current").siblings().removeClass("current");
// 		// $(".laca_cont ul").eq($(".laca_li li").index(this)).addClass("on").siblings().removeClass('on');
// 		// $(this).addClass("on").siblings().removeClass("on")
// 	});
//	轮播图
	var swiper = new Swiper('.container02', {
		pagination: '.swiper-pagination',
		slidesPerView: 1.3,
		paginationClickable: true,
		spaceBetween: 10
	});
});

