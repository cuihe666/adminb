$(function(){
	// 前31天
    //$('.oldprev').click(function(){
     //   // 获取当前选择的时间
     //   var date_info=$('#date_text').val().split("-");
     //   var newDate = new Date(date_info[0], date_info[1]-1, date_info[2]);
     //   var befminuts = newDate.getTime() - 1000 * 60 * 60 * 24 * parseInt(30);
     //   var beforeDat = new Date;
     //    if(new Date().getTime()>=new Date($("#date_text").val()).getTime()){
     //    	layer.msg('前面没有内容了', {
	//		    time: 1000});
     //    	return false;
     //   }
     //   beforeDat.setTime(befminuts);
     //   var befMonth = beforeDat.getMonth()+1;
     //   var mon = befMonth >= 10 ? befMonth : '0' + befMonth;
     //   var befDate = beforeDat.getDate();
     //   var da = befDate >= 10 ? befDate : '0' + befDate;
     //   var newDate = beforeDat.getFullYear() + '-' + mon + '-' + da;
     //   $("#date_text").val(newDate);
     //   setNewDate();
    //})
    // 后31天
    //$('.newprev').click(function(){
    //    var date_info=$('#date_text').val().split("-");
    //    var newDate = new Date(date_info[0], date_info[1]-1, date_info[2]);
    //    var befminuts = newDate.getTime() + 1000 * 60 * 60 * 24 * parseInt(30);
    //    var beforeDat = new Date;
    //    beforeDat.setTime(befminuts);
    //    var befMonth = beforeDat.getMonth()+1;
    //    var mon = befMonth >= 10 ? befMonth : '0' + befMonth;
    //    var befDate = beforeDat.getDate();
    //    var da = befDate >= 10 ? befDate : '0' + befDate;
    //    var newDate = beforeDat.getFullYear() + '-' + mon + '-' + da;
    //    $("#date_text").val(newDate);
    //    //console.log($("#date_text").val(),"val");
    //    setNewDate();
    //})
    // bootsrtap-datetimepicker 时间插件
    $(document).ready(function(){
    	var y = new Date().getFullYear();
    	var m = new Date().getMonth()+1;
    	var d = new Date().getDate();
    	if(m<10){
    		m = '0'+m;
    	}

    	var day =y+"-"+m+"-"+d;
    	//$("#date_text").val(day);
    	$.fn.datetimepicker.dates['zh'] = {  
		    days:       ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六","星期日"],  
		    daysShort:  ["日", "一", "二", "三", "四", "五", "六","日"],  
		    daysMin:    ["日", "一", "二", "三", "四", "五", "六","日"],  
		    months:     ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月","十二月"],  
		    monthsShort:  ["一", "二", "三", "四", "五", "六", "七", "八", "九", "十", "十一", "十二"],  
		    meridiem:    ["上午", "下午"],  
		    //suffix:      ["st", "nd", "rd", "th"],  
		    today:       "今天"  
		}; 
        if($(".iDate.date").length>0){
			$('#date_text').datetimepicker({
				/* 语言 中文*/
			    language:  'zh',
			    /*输入框内显示的日期格式*/
			    format: "yyyy-mm-dd", 
			    /* 周一作为一周起始点 */
			    weekStart: 1,
			    /*悬框下面是否有一个可以选择今天的按钮*/
			    todayBtn:  1,
			    /* 选中日期后，悬框自动消失 */
				autoclose: 1,
				/*高亮显示当前日期*/
				todayHighlight: true,
				/*可以通过键盘方向键改变日期*/
				keyboardNavigation: true,
			    /*只显示的某月的某天*/
				minView: "month",
			    /*可选日期的开始时间和结束时间,范围之外的不可选*/
			    // startDate:"2017-2-11",
			    startDate:new Date(),
				/*当选择器关闭的时候，是否强制解析输入框中的值*/
				forceParse: true,
				/*打开悬窗，默认停留项*/
				// initialDate: new Date(2014,11,1,0,0,0),
			});
        }
        // 查找新的月份内容
        setNewDate();
    })
    // 设置当前选择的天数
    function setNewDate(){
        var date_info=$('#date_text').val().split("-");
			//console.log(date_info,121212) // 2017 04 13
        var getDays = function(str,day_count,format){
            if(typeof str === "number"){
                format = day_count;
                day_count = str;
                str = new Date();
            }
            var date = new Date(str);
            //console.log(date,111)// 2017 04 13
            // 设置当前时间为选择的时间
            date.setFullYear(date_info[0],date_info[1]-1,date_info[2]);
            //console.log(date,222)// 2017 05 13
            var dates = [];
            // 获取n天
//          console.log(day_count,"day_count1")
            for(var i=0;i<=day_count;i++){
                var d = null;
                " "
                if(format){
                    var fmt = format;
                    fmt = fmt.replace(/y{4}/,date.getFullYear());
                    //console.log(fmt,1111)
                    fmt = fmt.replace(/M{2}/,date.getMonth()+1);
                    a = fmt.split("-");
                    if(a[1]<10){
                    	a[1] = '0'+a[1];
                    }
                    b = a[0]+"-"+a[1]+"-"+a[2];
                    
                    fmt = fmt.replace(/d{2}/,date.getDate());
                     // console.log(fmt,333)
                    
                    d = fmt;
                }else{
                    d = date.getFullYear() + "-" + date.getMonth()+1 + "-" + date.getDate();
                }
                dates.push(d);
                date.setDate(date.getDate()+1);
            //   console.log(date,12313123)
            }
            return dates;
        };
        
        /*
            *getDays(当前时间,获取的天数,只获取天)
            *arg(2)dd是天 可以设置为 yyyy年MM月dd日 调用yyyy mm dd获取年月日
        */
        
        var all_date=getDays(30,'yyyy-MM-dd');
        //console.log(all_date,222222222222222222)
        // 设置新的html
        html='<li id="top_date"><div class="cal_title fx">房型</div>';
        html2 ='<li class="item_title"><div class="cal_title fx_title">大床房-【预】</div>';
        // 循环天数追加到html内容中
        //console.log(all_date)
        for(var i=0;i<all_date.length;i++){
        	var day = all_date[i].split("-");
        	var week = "日一二三四五六".charAt(new Date(all_date[i]).getDay());
        	//console.log(week)
            html+="<div class='fangtai_day' >"+week+"<br>"+day[2]+"</div>";
            html2+="<div class='fangtai_item'><span class='man'>满</span><span>"+"读库"+i+"</span></div>";
        }
        // 循环下面的tr 循环数据

        html+="</li>";
        html2+="</li>";
        // 将html插入到页面Dom中
        //$("#tab").html(html);
        //$(".cal_con").html(html2);
    }
})
