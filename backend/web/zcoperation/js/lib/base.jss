function serveUrl() { //域名
	// return 'http://106.14.19.71:9090';//测试
	// return 'http://javatest.tgljweb.com:9090';//测试
	return 'http://javaapi.tgljweb.com:9090';//正式
	// return 'http://javapre.tgljweb.com:9090'; //预发布
	// return 'http://139.196.145.18:9090'; //0904
	// return 'http://192.168.64.55:9090'; //0913 
	// return 'http://106.15.126.75:9090'; //预发布
}

function zcAddZero(num) {
	return num<10?'0'+num:num;
}


function getLocalTimeByMs(timestamp,argu) {     //将时间戳（毫秒）转换成日期@zc170609
	var zc_new_date_obj = new Date( parseInt(timestamp) );
	var zc_year = zc_new_date_obj.getFullYear();
	var zc_month = ( zc_new_date_obj.getMonth() )+1;
	var zc_day = zc_new_date_obj.getDate();
	var zc_hour = zc_new_date_obj.getHours();
	var zc_min = zc_new_date_obj.getMinutes();
	var zc_seconds = zc_new_date_obj.getSeconds();
	var mark = argu||'-';
	var resultStr = zc_year+'-'+zcAddZero(zc_month)+'-'+zcAddZero(zc_day)+' '+zcAddZero(zc_hour)+':'+zcAddZero(zc_min)+':'+zcAddZero(zc_seconds);
	// var resultStr = zc_year+mark+zcAddZero(zc_month)+mark+zcAddZero(zc_day)+mark+zcAddZero(zc_hour)+mark+zcAddZero(zc_min)+mark+zcAddZero(zc_seconds);
	
	if(!zc_year || !zc_month ||  !zc_day) {
		resultStr = '暂无可选日期';
		return resultStr;
	}
	return resultStr;
}

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
				result= key_val_s[i].split('=')[1].indexOf('#')>0? key_val_s[i].split('=')[1].substr(0,key_val_s[i].split('=')[1].indexOf('#')):key_val_s[i].split('=')[1];
				break;
			}
		}
	}
	return result? result=='null'?'':result :'';
}