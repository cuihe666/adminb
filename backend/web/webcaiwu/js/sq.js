/**
 * Created by admin on 2017/8/9.
 */
$(function(){
    var arua = 0; // 参数变量
    $(".sxh_content .top .sq").click(function(){
        if(arua==0){
            $(this).html("展开");
            arua=1;
        }else if(arua==1){
            $(this).html("收起");
            arua = 0;
        }
        $(this).toggleClass("active");
        $(".search-content").slideToggle();
    })
})


