$(function(){
	var absUrl = serveUrl();
	var dateScope = zcGetLocationParm('time'); //时间
	var serviceLine = zcGetLocationParm('serviceLine'); // 业务线
	var statementStatus = zcGetLocationParm('statementStatus'); // 财务单状态
	var financeType =''; // 财务单类型
	var pageNum=1; //第几页 必传
	var pageSize=$('#pageSize').val();//每页几条 必传
	var dzdtl_ajax_data = {dateScope:dateScope,serviceLine:serviceLine,statementStatus:statementStatus,financeType:financeType,pageNum:pageNum,pageSize:pageSize};
	var initList = function() {
		bindEvt();
		getDetail(dzdtl_ajax_data);
	};
	var bindEvt = function() {
		$("#checkValue").on("change",checkValue); // 财务单类型
		$("#goback").on('click',goback);// 返回上一页
		$("body").on("click",'#pullout',pullOut); // 导出
		$("#pageSize").on("change",pageSizeChange); // 选择每页显示条数
		$("#pagination").on("click",'a',pageClick); // 翻页
	};
	var pageSizeChange = function () { // 每页显示条数
		dzdtl_ajax_data.pageSize = $(this).val();
		dzdtl_ajax_data.pageNum = 1;
		getDetail(dzdtl_ajax_data);
	}
	var pageClick = function(){ // 页码点击
		dzdtl_ajax_data.pageNum =$(this).attr("data-current");
		dzdtl_ajax_data.pageSize = $("#pageSize").val();
		zc_store.set("dzdtl_ajax_data",dzdtl_ajax_data); // 存 session 筛选项
		zc_store.set("pagenum",$(this).attr("data-current")); //
		zc_store.set("pagesize",$("#pageSize").val()); //
		getDetail(dzdtl_ajax_data);
	}; // 翻页
	var goback = function (){ // 返回上一页
		//window.history.go(-1);

		var time = zcGetLocationParm('time').substr(0,7); // 时间 2017-11 格式长度
		var serviceLine = zcGetLocationParm('serviceLine'); // 业务线
		var statementStatus = zcGetLocationParm('statementStatus'); // 对账单状态
		zc_store.set('jldzisdetail',true);// 来源是详情页返回
		window.location.href ='dz_dzd_listall'+'?time='+time+'&serviceLine='+serviceLine+'&statementStatus='+statementStatus;
	};
	var checkValue = function(){ // 财务单类型
		if($(this).val()==1){// 收款单
			dzdtl_ajax_data.financeType = 1;
		}else if($(this).val()==2){//退款单
			dzdtl_ajax_data.financeType = 2;
		}else if($(this).val()==3){ // 付款单
			dzdtl_ajax_data.financeType = 3;
		}else if($(this).val()==''){
			dzdtl_ajax_data.financeType = '';
		}
		dzdtl_ajax_data.pageNum = 1;
		dzdtl_ajax_data.pageSize = $('#pageSize').val();
		getDetail(dzdtl_ajax_data);
	};
	var pullOut = function () { // 导出
		//console.log(dzdtl_ajax_data);
		if($(".form_table").attr('data')==0){ // 判断是否有数据
			layer.msg('暂无数据可导出');
			return;
		}
		var url = absUrl+'/api/finance/statement/detail/exportAll'; // TODO
		var arr = [];
		var str='';
		for(var i in dzdtl_ajax_data) {
			arr.push([i, dzdtl_ajax_data[i]]);
		}
		$.each(arr, function (i,obj) {
			str+='&'+obj[0]+'='+obj[1];
		});
		window.location.href = url+'?123'+str; // 导出
	}
	var getDetail = function(dzdtl_ajax_data) {
		if(dzdtl_ajax_data.statementStatus==1||dzdtl_ajax_data.statementStatus==2){
			$('.first_ul').remove(); // 未确认、已确认状态不显示财务单类型
		}
		var ajax_url = absUrl+'/api/finance/statement/statementdetails';
		dzdtl_ajax_data_str = JSON.stringify(dzdtl_ajax_data);
		//console.log(dzdtl_ajax_data_str);
		$.ajax({
			type:'POST',
			url:ajax_url,
			data:dzdtl_ajax_data_str,
			contentType:"application/json",
			beforeSend: function(){
				$(".shade_wrap").fadeIn();
			},
			success:onGetDetailSuccess,
			error:function(xhr) {
				layer.msg('数据加载失败');
				$(".shade_wrap").fadeOut();
				console.log('ajax error');
				// alert('ajax error');
			}
		});
	};

	var onGetDetailSuccess = function(res) {
		$(".shade_wrap").fadeOut();
		$(".detail_state").html(''); // 列表数据
		$("#pagination").html(""); // 翻页
		//console.log(res);
		var data = [];
		if(res.code=='0') {
			var page_num = 0;
			//console.log(res.pageInfo.total,000000000000,$("#pageSize").val())
			if(Number(res.pageInfo.total) == 0){
				$(".detail_state").html("暂时没有数据").attr('data',0);
			}else if(Number(res.pageInfo.total) < $("#pageSize").val()){
				page_num = 1;
				$(".detail_state").attr('data',1);
			}else{
				$(".detail_state").attr('data',1);
				var pagesize = parseInt($("#pageSize").val());//页码
				if(parseInt(res.pageInfo.total % pagesize)==0){
					page_num = parseInt(res.pageInfo.total / pagesize);
				}else{
					page_num = parseInt(res.pageInfo.total / pagesize)+1;

				}
				//console.log(page_num,'页码')
			}
			$("#totalNum").html(page_num);// 总页
			var eachData = res.pageInfo.list;
			//日期
			$("#dateNum").html(zcGetLocationParm('time'));
			if(eachData.length==0) { // 汇总数据为空
				$(".detail_state").html("暂无数据").attr('data',0);
			}else{
				$(".detail_state").attr('data',1);
				if(dzdtl_ajax_data.statementStatus==''){
					data.push(
						'<table class="table table-bordered" style="border: 1px solid #000;width: 1500px;" cellpadding="0" cellspacing="0">',
						'<tr>',
						'<td>完成时间</td>',
						'<td>订单编号</td>',
						'<td>商品ID</td>',
						'<td>商品名称</td>',
						'<td>业务线</td>',
						'<td>收款单号</td>',
						'<td>退款单号</td>',
						'<td>付款单号</td>',
						'<td>应收金额</td>',
						'<td>实收金额</td>',
						'<td>优惠金额</td>',
						'<td>实退金额</td>',
						'<td>退还优惠券</td>',
						'<td>结算付款</td>',
						'</tr>'
					);
					$.each(eachData, function (i,obj) {
						var ywx = obj.serviceLine;
						var sfm = 2;// 待时分秒的时间
						if(ywx==1){
							ywx = "民宿";
						}else if(ywx==2){
							ywx = "旅行";
						}else{
							ywx = '-';
						}
						data.push(
							'<tr>',
							'<td>',
							'<span>'+TimeToDate(obj.completeTime,sfm)+'</span>',
							'</td>',
							'<td>',
							'<span>'+obj.orderNum+'</span>',
							'</td>',
							'<td>',
							'<span>'+obj.goodId+'</span>',
							'</td>',
							'<td>',
							'<span>'+obj.goodName+'</span>',
							'</td>',
							'<td>',
							'<span >'+ywx+'</span>',
							'</td>',
							'<td>',
							'<span>'+valNull(obj.receiptNum)+'</span>',
							'</td>',
							'<td>',
							'<span>'+valNull(obj.refundNum)+'</span>',
							'</td>',
							'<td>',
							'<span>'+valNull(obj.paymentNum)+'</span>',
							'</td>',
							'<td>',
							'<span>'+valNull(obj.recAmount)+'</span>',
							'</td>',
							'<td>',
							'<span>'+valNull(obj.realRecAmount)+'</span>',
							'</td>',
							'<td>',
							'<span>'+valNull(obj.couponAmount)+'</span>',
							'</td>',
							'<td>',
							'<span>'+valNull(obj.realRefund)+'</span>',
							'</td>',
							'<td>',
							'<span>'+valNull(obj.refundCoupon)+'</span>',
							'</td>',
							'<td>',
							'<span>'+valNull(obj.realPayAmount)+'</span>',
							'</td>',
							'</tr>'
						)
					});
					data.push(
						'</table>'
					);
				}else if(dzdtl_ajax_data.statementStatus==1){ //已确认
					data.push(
						'<table class="table table-bordered" style="border: 1px solid #000;" cellpadding="0" cellspacing="0">',
						'<tr>',
						'<td>完成时间</td>',
						'<td>订单编号</td>',
						'<td>商品ID</td>',
						'<td>商品名称</td>',
						'<td>业务线</td>',
						'<td>收款单号</td>',
						'<td>退款单号</td>',
						'<td>付款单号</td>',
						'<td>收入</td>',
						'<td>退款</td>',
						'<td>结算付款</td>',
						//'<td>手续费</td>',
						'<td>补贴优惠金额</td>',
						'<td>补贴退款</td>',
						'<td>毛利</td>',
						'</tr>'
					);
					$.each(eachData, function (i,obj) {
						var ywx = obj.serviceLine;
						var sfm = 2;// 待时分秒的时间
						if(ywx==1){
							ywx = "民宿";
						}else if(ywx==2){
							ywx = "旅行";
						}else{
							ywx = '-';
						}
						data.push(
							'<tr>',
							'<td>',
							'<span>'+TimeToDate(obj.completeTime,sfm)+'</span>',
							'</td>',
							'<td>',
							'<span>'+obj.orderNum+'</span>',
							'</td>',
							'<td>',
							'<span>'+obj.goodId+'</span>',
							'</td>',
							'<td>',
							'<span>'+obj.goodName+'</span>',
							'</td>',
							'<td>',
							'<span >'+ywx+'</span>',
							'</td>',
							'<td>',
							'<span>'+valNull(obj.receiptNum)+'</span>',
							'</td>',
							'<td>',
							'<span>'+valNull(obj.refundNum)+'</span>',
							'</td>',
							'<td>',
							'<span>'+valNull(obj.paymentNum)+'</span>',
							'</td>',
							'<td>',
							'<span>'+obj.incomeAccount+'</span>',
							'</td>',
							'<td>',
							'<span>'+obj.refundAccount+'</span>',
							'</td>',
							'<td>',
							'<span>'+obj.paymentAccount+'</span>',
							'</td>',
							//'<td>',
							//'<span>'+obj.serviceCharge+'</span>',
							//'</td>',
							'<td>',
							'<span>'+obj.couponAccount+'</span>',
							'</td>',
							'<td>',
							'<span>'+obj.subsidyRefund+'</span>',
							'</td>',
							'<td>',
							'<span>'+valNull(obj.grossProfit)+'</span>',
							'</td>',
							'</tr>'
						)
					});
					data.push(
						'</table>'
					);
				}else if(dzdtl_ajax_data.statementStatus==2){ // 未确认
					data.push(
						'<table class="table table-bordered" style="border: 1px solid #000;" cellpadding="0" cellspacing="0">',
						'<tr>',
						'<td>完成时间</td>',
						'<td>订单编号</td>',
						'<td>商品ID</td>',
						'<td>商品名称</td>',
						'<td>业务线</td>',
						'<td>收款单号</td>',
						'<td>退款单号</td>',
						'<td>付款单号</td>',
						'<td>收入</td>',
						'<td>退款</td>',
						'<td>结算付款</td>',
						'<td>补贴优惠金额</td>',
						'<td>补贴退款</td>',
						'</tr>'
					);
					$.each(eachData, function (i,obj) {
						var ywx = obj.serviceLine;
						var sfm = 2;// 待时分秒的时间
						if(ywx==1){
							ywx = "民宿";
						}else if(ywx==2){
							ywx = "旅行";
						}else{
							ywx = '-';
						}
						data.push(
							'<tr>',
							'<td>',
							'<span>'+TimeToDate(obj.completeTime,sfm)+'</span>',
							'</td>',
							'<td>',
							'<span>'+obj.orderNum+'</span>',
							'</td>',
							'<td>',
							'<span>'+obj.goodId+'</span>',
							'</td>',
							'<td>',
							'<span>'+obj.goodName+'</span>',
							'</td>',
							'<td>',
							'<span >'+ywx+'</span>',
							'</td>',
							'<td>',
							'<span>'+valNull(obj.receiptNum)+'</span>',
							'</td>',
							'<td>',
							'<span>'+valNull(obj.refundNum)+'</span>',
							'</td>',
							'<td>',
							'<span>'+valNull(obj.paymentNum)+'</span>',
							'</td>',
							'<td>',
							'<span>'+valNull(obj.incomeAccount)+'</span>',
							'</td>',
							'<td>',
							'<span>'+valNull(obj.refundAccount)+'</span>',
							'</td>',
							'<td>',
							'<span>'+valNull(obj.paymentAccount)+'</span>',
							'</td>',
							'<td>',
							'<span>'+valNull(obj.couponAccount)+'</span>',
							'</td>',
							'<td>',
							'<span>'+valNull(obj.subsidyRefund)+'</span>',
							'</td>',
							'</tr>'
						)
					});
					data.push(
						'</table>'
					);
				}

					$(".detail_state").html('');
				$(".detail_state").html(data.join(''));
				//分页，PageCount是总条目数，这是必选参数，其它参数都是可选
				$("#pagination").pagination({
					currentPage: res.pageInfo.pageNum, //当前页
					maxentries: res.pageInfo.total, // 总条数
					items_per_page:  4,
					num_display_entries: 5,
					totalPage: page_num,
					num_edge_entries: 2,       //两侧首尾分页条目数
					homePageText: "首页",
					endPageText: "尾页",
					prevPageText: "上一页",
					nextPageText: "下一页"
					//callback: pageselectCallback // 回调函数

				});
			}
		}else {
			layer.msg(res.msg);
		}

	};
	initList();
})