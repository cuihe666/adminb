<?php
/**
 * Created by PhpStorm.
 * User: gpf
 * Date: 2017/6/7
 * Time: 上午11:44
 */
?>
<script>
    //检测 ie 浏览器版本(6-9)
    var isIE = function(ver){
        var b = document.createElement('b')
        b.innerHTML = '<!--[if IE ' + ver + ']><i></i><![endif]-->';
        return b.getElementsByTagName('i').length === 1
    };
    if(isIE(6) || isIE(7) || isIE(8) || isIE(9)){
        alert("抱歉,当前页面不支持低版本的 ie 浏览器,为获得更好的体验请使用谷歌浏览器,如果是 360浏览器 请使用<极速模式>")
    }
</script>
