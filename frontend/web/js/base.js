function zcGetLocationParm(argu_name,curr_str) { //获取url参数argu_name的值,如果未获取到则返回空,原生JS完成,不依赖$,获取不到时返回空串''
    var i=0;
    var url = curr_str||window.location.href;
    var arguStr = url.split('?')[1];
    var key_val_s = [];
    var len = 0;
    var result='';
    if(arguStr) {
        key_val_s = arguStr.split('&');
        len = key_val_s.length;
        for(i=0;i<len;i++) {
            if(argu_name==key_val_s[i].split('=')[0]) {
                result=key_val_s[i].split('=')[1];
                break;
            }
        }
    }
    return result? result=='null'?'':result :'';
}

function solveIosHead(headNextHasMt,fn) { //top20
    var u = navigator.userAgent;
    var isIOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/);
    var $h_top = $('.h_top');
    var h_top_height = $h_top.height();
    var $h_top_next = $h_top.next();
    var nextMt = h_top_height+20+'px';
    if(isIOS) {
        $h_top.css('padding-top','20px');
        if(!headNextHasMt) {
            $h_top_next.css('margin-top',nextMt);
        }
        if(fn) {
            fn();
        }
    }

}

function applyAppDetailGoback(){ // goback
    var u = navigator.userAgent;
    var isAndroid = u.indexOf('Android') > -1; //android终端
    var isdiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/);
    if(isAndroid){
        javascript:jsandroid.goback();
    }
    if(isdiOS){
        window.webkit.messageHandlers.goback.postMessage('123123');
    }

}

function applyAppShare(obj){ // 分享
    var u = navigator.userAgent;
    var isAndroid = u.indexOf('Android') > -1; //android终端
    var isdiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/);
    if(isdiOS){
        window.webkit.messageHandlers.share.postMessage(obj);
    }
    if(isAndroid){
        javascript:jsandroid.share(obj);
    }
}
