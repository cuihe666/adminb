$(function(){
	var date = new Date(); // 时间范围 默认当月
	var month = date.getMonth()+1; // 月
	var year = date.getFullYear();// 年
	if(month<10){
		month = "0"+month;
	}
	var value = year+"-"+month;
	$("#dateRange").val(value); //时间范围
	var y = value.slice(0, 4);// 年
	var dateScope = $("#dateRange").val(); // 2017-08格式
	//var dateScope ='2017-09-08'; // TODO
	//var serviceLine =zcGetLocationParm('serviceLine'); // 业务线
	var serviceLine = $("#checkValue").val();// 业务线
	//var statementStatus =zcGetLocationParm('statementStatus'); // 状态
	var statementStatus =$('#dzd_tab li.current-top').attr('statementStatus'); // 状态 默认所有
	var absUrl = serveUrl();
	var ajax_data = {dateScope:dateScope,serviceLine:serviceLine,statementStatus:statementStatus};
	var initList = function() {
		bindEvt();
		getDetail(ajax_data);
	};
	var bindEvt = function() {
		$("#dz_l_date").on("click",dz_l_date);// 时间范围left
		$("#dz_r_date").on("click",dz_r_date); //时间范围right
		$("#search").on("click",search);//搜索
		$("#clear").on("click",clearDate);// 清除数据
		$("#dzd_tab").on("click","li",dzdTab);// 状态切换
		$("body").on("click",'#pullout',pullOut); // 导出
	};
	var dzdTab = function () { // 对账单切换
		clearDate(); // 切换清空数据
		if($(this).hasClass('current-top')){
			return false;
		}
		$(this).addClass('current-top').siblings('li').removeClass('current-top');
		if($(this).attr('statementStatus')==1){// 已确认
			ajax_data.statementStatus=1;
		}else if($(this).attr('statementStatus')==2){// 未确认
			ajax_data.statementStatus = 2;
		}else{//全部
			ajax_data.statementStatus = '';
		}
		getDetail(ajax_data);
	};
	var dz_l_date = function(){ //时间范围left
		month = Number($('#dateRange').val().substring(5));
		y = Number($('#dateRange').val().slice(0, 4));
		month--;
		if(month<10){
			month = "0"+month;
		}
		var value = y+"-"+month;
		$("#dateRange").val(value);
		if(month<1){
			y=y-1;
			month=12;
			if(month<10){
				month = "0"+month;
			}
			var value = y+"-"+month;
			$("#dateRange").val(value);
		}
	}
	var dz_r_date = function () { // 时间范围 right
		month = Number($('#dateRange').val().substring(5));
		y = Number($('#dateRange').val().slice(0, 4));
		month++;
		if(month<10){
			month = "0"+month;
		}
		var value = y+"-"+month;
		$("#dateRange").val(value);
		if(month>12){
			y=parseInt(y)+1;
			month=1;
			if(month<10){
				month = "0"+month;
			}
			var value = y+"-"+month;
			$("#dateRange").val(value);
		}
	}
	var search = function () { // 搜索
		ajax_data.dateScope = $("#dateRange").val(); // 2017-08格式
		ajax_data.serviceLine = $("#checkValue").val();// 业务线
		ajax_data.statementStatus =$('#dzd_tab li.current-top').attr('statementStatus'); // 状态 默认所有
		if(dateScope==null||dateScope==""){
			layer.msg("请选择时间范围");
			return false;
		}else {
			//console.log(serviceLine,ajax_data)
			getDetail(ajax_data);
		}
	}
	var clearDate = function(){ // 清空
		var date = new Date(); // 时间范围回到当前月
		var month = date.getMonth()+1;
		var year = date.getFullYear();
		if(month<10){
			month = "0"+month;
		}
		var value = year+"-"+month;
		$("#dateRange").val(value);
		$("#checkValue").val(""); // 业务线
	};
	var pullOut = function () { // 导出
		if($(".form_table").attr('data')==0){ // 判断是否有数据
			layer.msg('暂无数据可导出');
			return;
		}
		var url = absUrl+'/api/finance/statement/exportAll';
		//var oarr = JSON.parse(zc_store.get('dz_dzd_ajax'))|| ajax_data; // 导出带状态列表的数据参数
		var arr = [];
		var str='';
		for(var i in ajax_data) {
			arr.push([i, ajax_data[i]]);
		}
		$.each(arr, function (i,obj) {
			str+='&'+obj[0]+'='+obj[1];
		});
		window.location.href = url+'?123'+str; // 导出
	}
	var getDetail = function(ajax_data) { // 拉数据
		if(zc_store.get('jldzisdetail')=='true') {
			if (zcGetLocationParm('time') != '') {
				ajax_data.dateScope = zcGetLocationParm('time');
				ajax_data.serviceLine = zcGetLocationParm('serviceLine');
				ajax_data.statementStatus = zcGetLocationParm('statementStatus');
				$("#dateRange").val(zcGetLocationParm('time'));
				$("#checkValue").val(ajax_data.serviceLine).selected;
			}
			if (zcGetLocationParm("statementStatus") != '') {
				var val = zcGetLocationParm('statementStatus');
				for (var i = 0; i < $("#dzd_tab li").length; i++) {
					if ($("#dzd_tab li").eq(i).attr('statementStatus') == val) {
						$("#dzd_tab li").eq(i).addClass("current-top").siblings('li').removeClass("current-top");
					}
				}
			}

			zc_store.set('jldzisdetail',false);
		}
		var ajax_url = absUrl+'/api/finance/statement/statements';
		ajax_data_str = JSON.stringify(ajax_data);
		//console.log(ajax_data_str);
		$.ajax({
			type:'POST',
			url:ajax_url,
			data:ajax_data_str,
			contentType:"application/json",
			beforeSend: function(){
				$(".shade_wrap").fadeIn();
			},
			success:onGetDetailSuccess,
			error:function(xhr) {
				layer.msg("数据请求失败");
				$(".shade_wrap").fadeOut();
				console.log('ajax error');
			}
		});
	};
	var onGetDetailSuccess = function(res) {
		$(".shade_wrap").fadeOut();
		//console.log(res);
		var data = [];
		if(res.code=='0') {
			var totalData = res.data.total;
			var eachData = res.data.statement;
			if(eachData.length==0) { // 汇总数据为空
				$(".form_table").html("暂无数据").attr('data',0);
			}else{
				$(".form_table").attr('data',1);
				if(ajax_data.statementStatus==''){
					data.push(
						'<table class="table table-bordered">',
						'<tbody>',
						'<tr>',
						'<td>',
						'<span>日期</span>',
						'</td>',
						'<td>',
						'<span>收入</span>',
						'</td>',
						'<td>',
						'<span>退款</span>',
						'</td>',
						'<td>',
						'<span>结算付款</span>',
						'</td>',
						'<td>',
						'<span>操作</span>',
						'</td>',
						'</tr>'
					);
					$.each(eachData, function (i,obj) {
						data.push(
							'<tr>',
							'<td>',
							'<span>'+TimeToDate(obj.dateGroupBy)+'</span>',
							'</td>',
							'<td>',
							'<span>'+obj.receiptTotal+'元&nbsp;&nbsp;</span>',
							'<em> 共'+obj.receiptCount+'笔</em>',
							'</td><td>',
							'<span>'+obj.refundTotal+'元&nbsp;&nbsp; </span>',
							'<em> 共'+obj.refundCount+'笔</em>',
							'</td><td>',
							'<span>'+obj.paymentTotal+'元&nbsp;&nbsp; </span>',
							'<em> 共'+obj.paymentCount+'笔</em>',
							'</td>',
							'<td>',
							'<a href="dz_dzd_detailall?time='+TimeToDate(obj.dateGroupBy)+'&'+'serviceLine='+ajax_data.serviceLine+'&'+'statementStatus='+ajax_data.statementStatus+'">查看明细</a>' ,
							'</td></tr>'
						)
					});
					data.push(
						'<tr>',
						'<td>',
						'<span>汇总：</span>',
						'<em></em>',
						'</td>',
						'<td style="color:red;">',
						'<span>'+totalData.receiptTotal+'元&nbsp;&nbsp; </span>',
						'<em> 共'+totalData.receiptCount+'笔</em>',
						'</td>',
						'<td style="color:red;">',
						'<span>'+totalData.refundTotal+'元&nbsp;&nbsp; </span>',
						'<em> 共'+totalData.refundCount+'笔</em>',
						'</td>',
						'<td style="color:red;">',
						'<span>'+totalData.paymentTotal+'元&nbsp;&nbsp; </span>',
						'<em> 共'+totalData.paymentCount+'笔</em>',
						'</td>',
						'<td>',
						'<a href="dz_dzd_detailall?time='+ajax_data.dateScope+'&'+'serviceLine='+ajax_data.serviceLine+'&'+'statementStatus='+ajax_data.statementStatus+'">查看明细</a>',
						'</td>',
						'</tr>',
						'</tbody>',
						'</table>'
					);
				}else if(ajax_data.statementStatus=='1'){
						data.push(
							'<table class="table table-bordered">',
							'<tbody>',
							'<tr>',
							'<td>',
							'<span>日期</span>',
							'</td>',
							'<td>',
							'<span>收入</span>',
							'</td>',
							'<td>',
							'<span>退款</span>',
							'</td>',
							'<td>',
							'<span>结算付款</span>',
							'</td>',
							'<td>',
							'<span>补贴优惠金额</span>',
							'</td>',
							'<td>',
							'<span>补贴退款</span>',
							'</td>',
							'<td>',
							'<span>毛利</span>',
							'</td>',
							'<td>',
							'<span>操作</span>',
							'</td>',
							'</tr>'
						);
						$.each(eachData, function (i,obj) {
							data.push(
								'<tr>',
								'<td>',
								'<span>'+TimeToDate(obj.dateGroupBy)+'</span>',
								'</td>',
								'<td>',
								'<span>'+obj.receiptTotal+'元&nbsp;&nbsp; </span>',
								'<em> 共'+obj.receiptCount+'笔</em>',
								'</td><td>',
								'<span>'+obj.refundTotal+'元&nbsp;&nbsp; </span>',
								'<em> 共'+obj.refundCount+'笔</em>',
								'</td><td>',
								'<span>'+obj.paymentTotal+'元&nbsp;&nbsp; </span>',
								'<em> 共'+obj.paymentCount+'笔</em>',
								'</td>',
								'<td>',
								'<span>'+obj.couponAmount+'</span>' ,
								'</td>',
								'<td>',
								'<span>'+obj.subsidyRefund+'</span>' ,
								'</td>',
								'<td>',
								'<span>'+obj.grossProfit+'</span>' ,
								'</td>',
								'<td>',
								'<a href="dz_dzd_detailall?time='+TimeToDate(obj.dateGroupBy)+'&'+'serviceLine='+ajax_data.serviceLine+'&'+'statementStatus='+ajax_data.statementStatus+'">查看明细</a>' ,
								'</td></tr>'
							)
						});
						data.push(
							'<tr>',
							'<td>',
							'<span>汇总：</span>',
							'<em></em>',
							'</td>',
							'<td style="color:red;">',
							'<span>'+totalData.receiptTotal+'&nbsp;&nbsp; </span>',
							'<em> 共'+totalData.receiptCount+'笔</em>',
							'</td>',
							'<td style="color:red;">',
							'<span>'+totalData.refundTotal+'元&nbsp;&nbsp; </span>',
							'<em> 共'+totalData.refundCount+'笔</em>',
							'</td>',
							'<td style="color:red;">',
							'<span>'+totalData.paymentTotal+'元&nbsp;&nbsp; </span>',
							'<em> 共'+totalData.paymentCount+'笔</em>',
							'</td>',
							'<td style="color:red;">',
							'<span>'+totalData.couponAmount+'</span>',
							'</td>',
							'<td style="color:red;">',
							'<span>'+totalData.subsidyRefund+'</span>',
							'</td>',
							'<td>',
							'<span>'+totalData.grossProfit+'</span>' ,
							'</td>',
							'<td>',
							'<a href="dz_dzd_detailall?time='+ajax_data.dateScope+'&'+'serviceLine='+ajax_data.serviceLine+'&'+'statementStatus='+ajax_data.statementStatus+'">查看明细</a>',
							'</td>',
							'</tr>',
							'</tbody>',
							'</table>'
						);
				}else if(ajax_data.statementStatus=='2'){
					data.push(
						'<table class="table table-bordered">',
						'<tbody>',
						'<tr>',
						'<td>',
						'<span>日期</span>',
						'</td>',
						'<td>',
						'<span>收入</span>',
						'</td>',
						'<td>',
						'<span>退款</span>',
						'</td>',
						'<td>',
						'<span>结算付款</span>',
						'</td>',
						'<td>',
						'<span>补贴优惠金额</span>',
						'</td>',
						'<td>',
						'<span>补贴退款</span>',
						'</td>',
						'<td>',
						'<span>操作</span>',
						'</td>',
						'</tr>'
					);
					$.each(eachData, function (i,obj) {
						data.push(
							'<tr>',
							'<td>',
							'<span>'+TimeToDate(obj.dateGroupBy)+'</span>',
							'</td>',
							'<td>',
							'<span>'+obj.receiptTotal+'元&nbsp;&nbsp; </span>',
							'<em> 共'+obj.receiptCount+'笔</em>',
							'</td><td>',
							'<span>'+obj.refundTotal+'元&nbsp;&nbsp; </span>',
							'<em> 共'+obj.refundCount+'笔</em>',
							'</td><td>',
							'<span>'+obj.paymentTotal+'元&nbsp;&nbsp; </span>',
							'<em> 共'+obj.paymentCount+'笔</em>',
							'</td>',
							'<td>',
							'<span>'+obj.couponAmount+'</span>' ,
							'</td>',
							'<td>',
							'<span>'+obj.subsidyRefund+'</span>' ,
							'</td>',
							'<td>',
							'<a href="dz_dzd_detailall?time='+TimeToDate(obj.dateGroupBy)+'&'+'serviceLine='+ajax_data.serviceLine+'&'+'statementStatus='+ajax_data.statementStatus+'">查看明细</a>' ,
							'</td></tr>'
						)
					});
					data.push(
						'<tr>',
						'<td>',
						'<span>汇总：</span>',
						'<em></em>',
						'</td>',
						'<td style="color:red;">',
						'<span>'+totalData.receiptTotal+'元&nbsp;&nbsp; </span>',
						'<em> 共'+totalData.receiptCount+'笔</em>',
						'</td>',
						'<td style="color:red;">',
						'<span>'+totalData.refundTotal+'元&nbsp;&nbsp; </span>',
						'<em> 共'+totalData.refundCount+'笔</em>',
						'</td>',
						'<td style="color:red;">',
						'<span>'+totalData.paymentTotal+'元&nbsp;&nbsp; </span>',
						'<em> 共'+totalData.paymentCount+'笔</em>',
						'</td>',
						'<td style="color:red;">',
						'<span>'+totalData.couponAmount+'</span>',
						'</td>',
						'<td style="color:red;">',
						'<span>'+totalData.subsidyRefund+'</span>',
						'</td>',
						'<td>',
						'<a href="dz_dzd_detailall?time='+ajax_data.dateScope+'&'+'serviceLine='+ajax_data.serviceLine+'&'+'statementStatus='+ajax_data.statementStatus+'">查看明细</a>',
						'</td>',
						'</tr>',
						'</tbody>',
						'</table>'
					);
				}

				$(".form_table").html('');
				$(".form_table").html(data.join(''));
			}
		}else {
			layer.msg(res.msg);
		}

	};
	initList();
})