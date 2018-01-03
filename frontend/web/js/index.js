$(function() {
    var parm = zcGetLocationParm("share") ;
    var fromhome = zcGetLocationParm("fromhome") ;

    var shareObj ={};
    shareObj["shareImgUrl"] = 'http://lvcheng.tgljweb.com/images/share_dk.jpg';
    shareObj["shareContent"] ='棠果旅行供应商后台开放啦1、在线注册2、在线签约3、上传产品;只需要简单三步即可马上成为达人，快来加入我们吧' ;
    shareObj["shareTitle"] = '棠果平台诚邀您加入我们';
    shareObj["shareUrl"] = window.location.href+"&share=true" ;

    //分享页面显示下载，不是先头部
    if(parm){
        $(".download").show();
        $("#pt_wp").hide();
    }
    //苹果导航条下移20像素
    var initList = function() {
        bindEvt();
        solveIosHead('$'); // ios 导航下移20px
    };
    var bindEvt = function() {
        $(document).on('scroll',onWinScroll); //滚动
        $(".download").on("click",".close",downLoad);
        $('.goback').on('click',onGobackTap); // goback
        $('.theme_share').on('click',onShare); // share

    }
    var onWinScroll = function(){
        if($("body").scrollTop()>=44){
            $('.h_top').addClass('show_bg');
            $('.goback').css('backgroundImage','url(../img/go_back.png)');
            $('.theme_share').css('backgroundImage','url(../img/share_black.png)');
            $(".titleTxt").css("display","block");
        }else{
            $('.h_top').removeClass('show_bg');
            $('.goback').css('backgroundImage','url(../img/go_back_white.png)');
            $('.theme_share').css('backgroundImage','url(../img/share_white.png)');
            $(".titleTxt").css("display","none");
        }
    }
    var downLoad = function(){
        $(".download").hide();
    }
    var onGobackTap = function(){ // 返回banner
        if(fromhome){ // 返回app首页banner
            applyAppDetailGoback();
        }else{ // 返回旅行首页banner
            window.history.go(-1);
        }

    }
    var onShare = function(){
        var obj = JSON.stringify(shareObj);
        applyAppShare(obj);
    }
    initList();
})