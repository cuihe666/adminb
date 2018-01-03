    (function (doc, win) {    
        var docEl = doc.documentElement,    
        resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',    
        recalc = function () {    
            var clientWidth = docEl.clientWidth;    
            if (!clientWidth) return;    
            docEl.style.fontSize = 20 * (clientWidth / 375) + 'px';    
        };    
        if (!doc.addEventListener) return;    
        win.addEventListener(resizeEvt, recalc, false);    
        doc.addEventListener('DOMContentLoaded', recalc, false);    
    })(document, window)   



    // var tagAll = document.getElementsByTagName('*');
   

    function testMaxTag() { //获取页面标签宽度最大的元素
        var $tagAll = $('*');
        var widthArr = [];
        $.each($tagAll,function(i,obj) {
            // console.log($(obj).width());
            var thisWidth = $(obj).width();
            widthArr.push(thisWidth);
        });
        maxItem(widthArr);

        function maxItem(arr) {
            var max = 0;
            $.each(arr,function(i,t) {
                if(max<t) {
                    max=t;
                }
            });
            return max;
        }
    }
    // testMaxTag();