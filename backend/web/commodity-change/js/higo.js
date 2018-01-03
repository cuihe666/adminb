/**
 * Created by admin on 2017/6/30.
 */
$(function(){
    $(".title li").each(function(index){
        var th = index;
        $(this).on("click", function(){
            $(this).css("background", "#009933").siblings().css("background", "#1888f8")
            $(".tap-wrap div").each(function(index){
                $(this).css("display", "none");
            })
            $(".tap-wrap div").eq(th).css("display", "block");
        })
    })
})
