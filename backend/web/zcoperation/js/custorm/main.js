
// 请求网址
//var http_url = "http://192.168.64.88:9090";
//var http_url = "http://139.196.145.18:9090";
var http_url = serveUrl();
//var http_url = "http://106.14.19.71:9090";
//var http_url = "http://192.168.64.55:9090";
//var http_url = "http://106.15.126.75:9090";
//var http_url = "http://javaapi.tgljweb.com:9090";
function getDateDiff(curTime){
   var d=new Date(curTime);
   // var d=curTime;
     var year = d.getFullYear();  //年
    var month = ((d.getMonth()+1)<10)?("0"+(d.getMonth()+1)):(d.getMonth()+1); //月
    var date = (d.getDate()<10)?("0"+d.getDate()):d.getDate();  //日
    var hour= (d.getHours()<10)?("0"+d.getHours()):d.getHours();  //时
    var min= (d.getMinutes()<10)?("0"+d.getMinutes()):d.getMinutes()  //分
    var second = (d.getSeconds()<10)?("0"+d.getSeconds()):d.getSeconds(); //秒
    var curTime = year+"-"+month+"-"+ date+" " +hour +":"+ min+":"+second;
    return curTime;
}

function GetRequest() {
    var url = location.search; //获取url中"?"符后的字串
    var theRequest = new Object();
    if (url.indexOf("?") != -1) {
        var str = url.substr(1);
        strs = str.split("&");
        for(var i = 0; i < strs.length; i ++) {
            theRequest[strs[i].split("=")[0]]=unescape(strs[i].split("=")[1]);
        }
    }
    return theRequest;
}

//要调用的函数：
function run_task(id){
    $.post("mrTask/runTask",{id:id},function(res){
        if("success"==res){
            layer.msg('已加入运行队列', {icon: 1});
        }else{
            layer.msg('运行失败', {icon: 5});
        }
    });

}