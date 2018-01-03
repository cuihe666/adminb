$(function() {
	//弹窗
	$(".x_yanze").click(function() {
			$(".layer5").show();
			$(".layer_con img").attr("src","/images/layer.png")
			$(".close").click(function() {
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
		$(this).css({"background": "#ffe0ae","color":"#ff4c7a"}).siblings().css({"background": "","color":"#fff"})
		var index = $(this).index();
		var hei = $(".offset_top").eq(index).offset().top;
		$("body:not(animated)").animate({
			scrollTop: hei
		}, 1000)
	})

	// 2017年6月15日 16:55:40 宋杏会 侧边导航z-index层级问题
	$(".foot_hide").click(function() {
		$(".libao_posi").fadeIn(1000)
		$(this).attr("src","../images/shouqi_top.png")
		$(".fixed_nav").animate({
			top: "-480px"
		}, 1000)
	})
	$(".nav_hide").click(function() {
		$(".libao_posi").hide();
		$(".foot_hide").attr("src","../images/shouqi.png")
		$(".fixed_nav").css("z-index", "3").show().animate({
			top: "145px"
		}, 1000);
		if($("body").width() <= 375) {
			$(".fixed_nav").animate({
				top: "94px"
			}, 1000);
		}
		if($("body").width() <= 320) {
			$(".fixed_nav").animate({
				top: "75px"
			}, 1000);
		}
	})
	//	tab切换
	$(".laca_li li").click(function() {
		$(this).addClass("current").siblings().removeClass("current");
        $(".laca_cont ul").eq($(".laca_li li").index(this)).addClass("on").siblings().removeClass('on');
	});
});