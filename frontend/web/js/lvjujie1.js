$(function () {
//弹窗
    $(".x_yanze").click(function () {
        $(".layer5").show();
        $(".layer_con img").attr("src", "/images/layer.png");
        $(".close").click(function () {
            $(".layer5").hide();
        })
    })
//	优惠券
    $('label').click(function () {
        var radioId = $(this).attr('name');
        $(this).addClass("checked").parents(".x_coupon").siblings(".x_coupon").find("label").removeClass("checked");
        $('input[type="radio"]').removeAttr('checked') && $('#' + radioId).attr('checked', 'checked');
    });

//	侧导航
    var lilen = $(".nav_cont li");
    lilen.click(function () {
        $(this).css("background", "#ffe0ae").siblings().css("background", "")
        var index = $(this).index();
        var hei = $(".offset_top").eq(index).offset().top;
        $("body:not(animated)").animate({
            scrollTop: hei
        }, 1000)
    })

    // 2017年6月15日 16:55:40 宋杏会 侧边导航z-index层级问题
    $(".foot_hide").click(function () {
        $(".libao_posi").fadeIn(2000)
        $(".hide_nav").fadeOut();
        $(".fixed_nav").hide()
    })
    $(".nav_hide").click(function () {
        $(".libao_posi").hide();
        $(".hide_nav").fadeIn(2000);
        $(".fixed_nav").css("z-index", "3").show()
    })

    $(".arch_tu .coupon_1_no").click(function () {
        This=$(this);
        $(".layer5").show();
        $(".layer_con img").attr("src", "/images/succeed.png")
        $(".close").click(function () {
            $(".layer5").hide();
            This.attr("src", '/images/i_yhq_10.png');
        })
        This.unbind();
    })

    $(".arch_tu .coupon_2_no").click(function () {
        This=$(this);
        $(".layer5").show();
        $(".layer_con img").attr("src", "/images/succeed.png")
        $(".close").click(function () {
            $(".layer5").hide();
            This.attr("src", '/images/i_yhq_30.png');
        })
        This.unbind();
    })

    $(".arch_tu .coupon_3_no").click(function () {
        This=$(this);
        $(".layer5").show();
        $(".layer_con img").attr("src", "/images/succeed.png")
        $(".close").click(function () {
            $(".layer5").hide();
            This.attr("src", '/images/i_yhq_50.png');
        })
        This.unbind();
    })


})
$(document).ready(function () {
//	tab切换
    $(".laca_li li").click(function () {
        $(".laca_cont ul").eq($(".laca_li li").index(this)).addClass("on").siblings().removeClass('on');
    });
//	轮播图
//    var swiper = new Swiper('.container02', {
//        pagination: '.swiper-pagination',
//        slidesPerView: 1.3,
//        paginationClickable: true,
//        spaceBetween: 10
//    });
});

