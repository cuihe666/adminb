/**
 * Created by Administrator on 2017/5/9 0009.
 */
// 2017年5月9日17:51:43 xhh修改酒店一系列的滚动条控制整体页面滚动
$(function(){
    changeMargin();
    window.onresize = function(){
        changeMargin();
    };
    function changeMargin(){
        var wid =  $(window).width();
        if(wid<1784){
            $(".wrapper").width("1784px");
        }else{
            $(".wrapper").width("100%");
        }
    }
})