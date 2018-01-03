	if(zcGetLocationParm("type")==3){ // 合伙人不显示按钮 结算单拆分
			$('#jlbillBtn').hide();
	}
	var settlementNum=zcGetLocationParm("id")||""; //结算单号
	var settlementType=zcGetLocationParm("type")||1; // 结算单类型
	var userId = adminId; // 操作人id
//var renderPagina = true; // 标记翻页
//订单详情列表
	var pageSize=$("#pageSize").val(); // 每页显示多少 条数据
	var pageNum = 1;
	var param={
		settlementNum:settlementNum,
		pageNum:pageNum,
		pageSize:pageSize
	};
//条数切换
	$("#pageSize").change(function(){
		$("#Pagination").html(" ");
		$(".billList").find("tbody").html(" ");
		param.pageSize=$(this).val();
		param.pageNum = 1;
		getDetail(param);
	});
	$("#Pagination").on("click",'a',function(){ // 页码点击
		$(".billList").find("tbody").html(" ");
		param.pageNum =$(this).attr("data-current");
		param.pageSize = $("#pageSize").val();
		getDetail(param);
	}); // 翻页
// 清除记录总页数的localStorage
//window.localStorage.removeItem("pagetotal");
//表头区分
	if((settlementType==1)||(settlementType==2)){
		$(".personTitle").html("房客信息");
		$(".partner-city").css("display", "none");
	}else if(settlementType==3){
		$(".personTitle").html("房东信息");
        $(".ispartner-id").html("合伙人ID");
        $(".ispartner-name").html("合伙人姓名");
		//$(".partner-city").css("display", "block");
	}
	$(".more_td").remove();
	if(settlementType == 2){
		var more_td = "<td class='more_td'><span>底价金额</span></td>" +
			"<td class='more_td'><span>清洁费</span></td>" +
			"<td class='more_td'><span>超员费</span></td>";
		$(".may_get").after(more_td);
	}
	/*
	 * 结算类型
	 * 1:国内房东应付2:海外房东应付3:合伙人应付4:番茄来了房东应付5:旅行达人应付
	 * */
	var settlementTypes=[
		"",
		"国内房东应付",
		"海外房东应付",
		"合伙人应付",
		"番茄来了房东应付",
		"旅行达人应付"
	];
	/*	提交订单状态（成功1、失败2,取消3）1-10，
	 房东应答（确认11、拒绝12）11-20，
	 支付后是否抢到房（成功21、失败22）21-30，
	 入住状态（入住31、退房32、入住失败33,已结算34）31-40。
	 41支付超时,
	 42房东确认超时,
	 43房源已被占用',*/
	var orderState=[
		{id:1,state:"待确认"},
		{id:3,state:"已取消(用户取消)"},
		{id:4,state:"已取消(客服取消)"},
		{id:11,state:"待付款"},
		{id:12,state:"已拒绝"},
		{id:21,state:"待入住"},
		{id:31,state:"已入住"},
		{id:32,state:"已完成"},
		{id:34,state:"已结算"},
		{id:41,state:"房客支付超时"},
		{id:42,state:"房东确认超时"},
		{id:51,state:"退款申请中"},
		{id:52,state:"退款待确认"},
		{id:54,state:"退款中"},
		{id:55,state:"退款完成"},
		{id:56,state:"退款未通过(客服)"},
		{id:57,state:"待退款"},
		{id:58,state:"财务拒绝"},
		{id:59,state:"拒绝退款"},
		{id:61,state:"结算待审核"},
		{id:62,state:"结算未通过(财务)"},
		{id:63,state:"结算待确认"},
		{id:64,state:"结算待付款"},
		{id:65,state:"付款失败"},
		{id:66,state:"结算拒绝(业务)"},
		{id:67,state:"结算异常订单"},
		{id:68,state:"已付款"},
		{id:69,state:"付款中"}
	];
	/*
	 1:支付宝；2：微信；3银联（默认支付宝）
	 */
	var landlordList=["","微信","支付宝","银联"];

	/*
	 结算状态  0:结算待审核  1:结算未通过  2:结算待确认  3:结算拒绝  4:结算待付款 5:付款失败  6:付款中  7结算完成
	 */
	var settlementStatuList=["创建结算单", "结算待审核", "结算未通过", "结算待确认", "结算待付款", "结算失败", "结算拒绝", "", "已付款", "付款中"];
//财务明细
	var absUrl = serveUrl();
//console.log(123);
	var initList = function() {
		//bindEvt();
		getSurvey(); // 获取概况
		getDetail(param);
	};
//获取概况
	function getSurvey(){
		var ajax_url = absUrl+'/api/finance/balance/getSettmentBySettmentNum/'+settlementNum;
		//console.log(ajax_url);
		$.ajax({
			type:'get',
			url:ajax_url,
			data:"",
			contentType:"application/json",
			success:onGetSurveySuccess,
			error:function(xhr) {
				layer.alert("数据请求失败，请稍后刷新重试!");
				//console.log('ajax error');
			}
		});
	}
//获取概况 成功
	function onGetSurveySuccess(res){
		//console.log(res);
		if(res.code==0){
			var survey=res.data;
			window.localStorage.removeItem("id");
			window.localStorage.setItem("id", survey.id);//总页数
			$(".billSurveyCon").html("");
			var landlordName;
			//收款方式
			if(survey.receiptPlatform){
				landlordName=landlordList[survey.receiptPlatform]
			}else{
				landlordName='-';
			}
			var settlementStatus=survey.settlementStatus; // 结算状态
			var curPayStatu=valNull(settlementStatuList[settlementStatus]);
			if(settlementStatus != 1 && settlementStatus != 2){
				$(".billDetailList button").css("display", "none");
			}
			changeBtnDisplay(curPayStatu); // 审核按钮的显示隐藏
			if(survey.settlementAmount!=''||survey.settlementAmount==0){
				var jsmoney = "￥"+survey.settlementAmount;
			}else{
				var jsmoney = '-';
			}
			//console.log(landlordName)
			$(".billSurveyCon").append(
				"<td>"+valNull(survey.settlementNum)+"</td>"
				+"<td>"
				+ "<span style='color:red'>"+jsmoney+"</span>"
				+"</td>"
				+"<td>"
				+"<span>"+valNull(survey.settlementUid)+"</span>"
				+"</td>"
				+"<td>"
				+"<span>"+valNull(survey.settlementName)+"</span>"
				+"</td>"
				+((survey.cityName)?('<td><span>' + (survey.cityName?survey.cityName:'-') +'</span></td>'):'')
				+"<td>"
				+"<span>"+valNull(landlordName)+"</span>"
				+"</td>"
				+"<td>"
				+"<span>"+valNull(survey.receiptName)+"</span>"
				+"</td>"
				+"<td>"
				+"<span>"+valNull(survey.receiptAccount)+"</span>"
				+"</td>"
				+"<td>"
				+"<span>"+valNull(survey.dispositBank)+"</span>"
				+"</td>"
				+"<td class='curPayState'>"
				+"<span>"+curPayStatu+"</span>"
				+"<input class='pay_platform' type='hidden' value='" + survey.receiptPlatform + "'/>"
				+"<input class='pay_settlementNum' type='hidden' value='" + survey.settlementNum + "'/>"
				+"<input class='pay_id' type='hidden' value='" + survey.id + "'/>"
				+"<input class='pay_settlementType' type='hidden' value='" + survey.settlementType + "'/>"
					/*+"<span>"+"结算待审核"+"</span>"*/
				+"</td>"
			);
			for(var i = 0; i < $(".billSurveyCon td").length; i++){
				if($(".billSurveyCon td").eq(i).find("span").html() == ""){
					$(".billSurveyCon td").eq(i).find("span").html("-");
				}
			}
		}
	}
	var totalPage = 0;
	//console.log(param);
	var getDetail = function(param) {
		var ajax_url = absUrl+'/api/finance/balance/settlements';
		//console.log(param);
		$.ajax({
			type:'POST',
			url:ajax_url,
			data:JSON.stringify(param),
			contentType:"application/json",
			success:onGetDetailSuccess,
			error:function(xhr) {
				layer.alert("数据请求失败，请稍后刷新重试!");
				//console.log('ajax error');
			}
		});
	};
	var onGetDetailSuccess=function(res){
		//console.log(res);
		$("#Pagination").html(" "); // 翻页
		if(res.code==0){
			var page_num = 0;
			var billBody=$(".billList").find("tbody");
			//console.log(res.pageInfo.total,000000000000,$("#pageSize").val())
			if(Number(res.pageInfo.total) == 0){
				$(billBody).html("暂时没有数据");
			}else if(Number(res.pageInfo.total) < $("#pageSize").val()){
				page_num = 1;
			}else{
				pagesize = parseInt($("#pageSize").val());//页码
				if(parseInt(res.pageInfo.total % pagesize)==0){
					page_num = parseInt(res.pageInfo.total / pagesize);
				}else{
					page_num = parseInt(res.pageInfo.total / pagesize)+1;

				}
				//console.log(page_num,'页码')
			}
			$("#totalNum").html(page_num);// 总页

			//$("#allPageCount span").html(page_num);// 总页
			//console.log(res);
			var billList=res.pageInfo.list;
			//window.localStorage.removeItem("receiptId");
			if(billList.length==0) { // 汇总数据为空
				$(billBody).html("暂无数据");
			}else{
				for(var i=0;i<billList.length;i++){
					//billList[i].orderState
					var curOrderState;
					for(var j= 0;j<orderState.length;j++){
						if(orderState[j].id==billList[i].orderState){
							curOrderState=orderState[j].state
						}
					}
					$(billBody).append(
						"<tr>"
						+"<td colspan='11' class='billListTitle' style='text-align: left'>"
						+"<input type='checkbox' receiptId=" + billList[i].receiptId + " orderId="+billList[i].orderId+"  value="+billList[i].id+">"
						+"<a style='color: #666;'>订单编号:"+(billList[i].orderNum?billList[i].orderNum:'-')+"</a>"
						+"<em>收款单号:"+(billList[i].receiptNum?billList[i].receiptNum:'-')+"</em>"
						+"<em>退款单号:"+(billList[i].refundNum?billList[i].refundNum:'-')+"</em>"
						+"<em>入住/离店:"+getLocalTimeByMs(billList[i].intoDate,'/')+"至"+getLocalTimeByMs(billList[i].outDate,'/')+"</em>"
						+"</td>"
						+"</tr>"
						+"</tr>"
						+"<tr>"
						+"<td>"
						+"<span>"+billList[i].tenantName+"</span>"
						+"<span>"+billList[i].tenantMobile+"</span>"
						+"</td>"
						+"<td>"
						+"<span>"+billList[i].houseCity+"</span>"
						+"<span>"+billList[i].houseTitle+"</span>"
						+"</td>"
						+"<td>"
						+"<span>"+billList[i].houseId+"</span>"
						+"</td>"
						+"<td>"
						+"<span>"+getLocalTimeByMs(billList[i].payTime,'/')+"</span>"
						+"<em>"+TimeToHour(billList[i].payTime)+"</em>"
						+"</td>"
						+"<td class='td_point'>￥"
						+(billList[i].recAmount?billList[i].recAmount:'0')
						+"</td>"
						+"<td>￥"
						+(billList[i].realRecAmount?billList[i].realRecAmount:'0')
						+"</td>"
						+"<td>￥" // 优惠券
						+(billList[i].couponAmount?billList[i].couponAmount:'0') + ((billList[i].couponStr?'(' + billList[i].couponStr + ')':''))
						+"</td>"
						+"<td>￥"
						+(billList[i].refundAmount?(billList[i].refundAmount).toFixed(2):(0.0.toFixed(2)))
						+"</td>"
						+"<td>￥"
							/*+(billList[i].settlementAmount?(billList[i].settlementAmount).toFixed(2):(0.0.toFixed(2)))*/
						+(billList[i].settlementAmount?(billList[i].settlementAmount).toFixed(2):('0.00'))
						+"</td>"
						+"<td>"
						+(billList[i].commissionRate?(billList[i].commissionRate+'%'):'')
						+"</td>"
						+"<td>"
						+"<span>"+curOrderState+"</span>"
						+"</td>"
						+"</tr>"
					)
					if(settlementType == 2){
						$(".td_point").last().after("<td>" + (billList[i].housePrice?billList[i].housePrice:'-') + "</td><td>" + (billList[i].cleanFee?billList[i].cleanFee:'-') + "</td><td>" + (billList[i].overManFee?billList[i].overManFee:'-') + "</td>")
					}
				}
				$("#Pagination").pagination({
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
				});
			}
		}
	};
	initList();
//导出 获取ids
	function getIds(){
		var billDetailList=$(".billDetailList .billListTitle").find("input");
		var ids=[];
		for(var i=0;i<billDetailList.length;i++){
			if($(billDetailList[i]).is(":checked")){
				//console.log(($(billDetailList[i]).val()));
				ids.push($(billDetailList[i]).val());
			}
		}
		ids=ids.join(",");
		return  ids;
	}
//获取orderIds
	function getOrderIds(){
		var billDetailList=$(".billDetailList .billListTitle").find("input");
		var orderIds=[];
		for(var i=0;i<billDetailList.length;i++){
			if($(billDetailList[i]).is(":checked")){
				orderIds.push($(billDetailList[i]).attr("orderId") + ":" + $(billDetailList[i]).attr("receiptId"));
			}
		}
		orderIds=orderIds.join(";");
		return  orderIds;
	}
	function getPriceCount(){
		var billDetailList=$(".billDetailList .billListTitle").find("input");
		var priceCount=0;
		for(var i=0;i<billDetailList.length;i++){
			if($(billDetailList[i]).is(":checked")){
				//console.log(($(billDetailList[i]).val()));
				//ids.push($(billDetailList[i]).val());
				var tds=$(billDetailList[i]).parent().parent().next().find("td");
				if(settlementType == 2){
					priceCount+=(parseFloat($(tds[11]).html().split("￥")[1]));
				}else{
					priceCount+=(parseFloat($(tds[8]).html().split("￥")[1]));
				}
			}
		}
		//console.log(priceCount);
		return  priceCount;
	}
//点击导出弹出框判断
	function exportBll(){
		var ids=getIds();
		//console.log(ids);
		if(ids){
			$('#upLoadBill').modal('show')
		}else{
			$('#myModal').modal('show')
		}
	}
//确认导出
	function loadBillList(){
		var ids=getIds();
		if(settlementType == 1){
			window.location=absUrl+"/api/finance/balance/exportHomeOrderList?ids="+ids;
		}else if(settlementType == 2){
			window.location=absUrl+"/api/finance/balance/exportSeasOrderList?ids="+ids;
		}else{
			window.location=absUrl+"/api/finance/balance/exportPartnerOrderList?ids="+ids;
		}
		$('#upLoadBill').modal('hide')
	}
//返回上一页
	function goback(){
		window.history.go(-1);
	}
//操作流水
//获取状态id
	function getStatu(statuId){
		var curStatu;
		var orderStatusType = [
			{"id": 0, "state": "创建结算单"},
			{"id": 1, "state": "结算待审核"},
			{"id": 2, "state": "结算未通过"},
			{"id": 3, "state": "结算待确认"},
			{"id": 4, "state": "结算待付款"},
			{"id": 5, "state": "结算失败"},
			{"id": 6, "state": "结算拒绝"},
			{"id": 7, "state": "-"},
			{"id": 8, "state": "已付款"},
			{"id": 9, "state": "付款中"}
		];
		for(var j=0;j<orderStatusType.length;j++){
			if(statuId ==orderStatusType[j].id){
				curStatu=orderStatusType[j].state
			}
		}
		return curStatu;
	};
//获取概况表格
//獲取操作流水
	function getProgram(){
		var id=window.localStorage.getItem("id");  //当前页
		var ajax_url = absUrl+'/api/finance/balance/logs/'+id;
		var tbody=$("#programList table").find("tbody");
		if(id){
			$('#programList').modal('show');
		}else{
			layer.alert("暂无数据");
		}

		$(tbody).html("") ;
		//console.log(ajax_url);
		$.ajax({
			type:'get',
			url:ajax_url,
			data:"",
			contentType:"application/json",
			success:function(res){
				//console.log(res);
				if(res.code==0){
					var programList=res.data;
					for(var i=0;i<programList.length;i++){
						//orderState
						//   var oldState;
						//   console.log(programList[i]);
						//   console.log(orderState.length);
						var oldState = "";
						if(programList[i].beforeStatus == 0){
							oldState= "创建结算单";
						}else{
							oldState=getStatu(programList[i].beforeStatus);
						}
						//var newState=getStatu(programList[i].afterStatus);
						/*for(var j=0;j<orderState.length;j++){
						 if(programList[i].beforeStatus==orderState[j].id){
						 oldState=orderState[j].state
						 }
						 }*/
						$(tbody).append(
							"<tr>"
							+"<td>"+TimeToDate(programList[i].updateTime,true)+"</td>"
							+"<td>"+(programList[i].optUsername?programList[i].optUsername:'-')+"</td>"
							+"<td>"+oldState+"</td>"
							+"<td>"+programList[i].optEvent+"</td>"
							+"<td>"+(programList[i].optComment?programList[i].optComment:'-')+"</td>"
							+"</tr>"
						)
					}
				}
			},
			error:function(xhr) {
				layer.alert("数据请求失败，请稍后刷新重试!");
				//console.log('ajax error');
			}
		});
	}

//结算单拆分
	function billSplit(){
		//console.log("结算单拆分");
		var ids=getIds();
		var priceCount=getPriceCount();
		if(ids){
			$("#myModal2").modal("show");
			$("#myModal2").find(".billCount").html("").html(ids.split(",").length);
			$("#myModal2").find(".price").html("").html(priceCount.toFixed(2));
		}else{
			$("#myModal3").modal("show");
		}
	}

//确认拆分
	function sureSplit(){
		var splitMsg=$(".splitMsg").val();
		var orderIds=getOrderIds();
		//console.log(orderIds);
		//return false;
		//receiptId
		//var receiptId=window.localStorage.getItem("receiptId");
		//console.log("收款人Id",receiptId);
		//console.log(splitMsg);
		if(!splitMsg){
			layer.alert("请填写备注");
			return false;
		}else{
			//console.log("执行拆分");
			//console.log(orderIds);
			var params={
				orderIds:orderIds,
				settlementNum:settlementNum
				//receiptId:receiptId
			};
			//console.log(params);
			$.ajax({
				type:'POST',
				url: absUrl+"/api/finance/balance/splitOrderOnSettment",
				data:JSON.stringify(params),
				contentType:"application/json",
				success:function(res){
					//console.log(res);
					//getSurvey();
					if(res.code == 0){
						//zjl 点击x和确定都要刷新页面
						layer.open({
							title: '提示'
							,content: "结算单" + params.settlementNum +"（拆分后结算金额" + res.data + "）拆分完成，请重新审核!"
							,cancel: function(){ window.location.reload();}
							,yes: function(){ window.location.reload();}
						});
					}else{
						layer.alert(res.msg);
					}
				},
				error:function(xhr) {
					layer.alert("数据请求失败，请稍后刷新重试!");
					//console.log('ajax error');
				}
			});

			$("#myModal2").modal("hide");
		}
	}

//获取结算类型名称
	function getSettlementStatuName(){
		var settlementStatuName;
		var curStatuSpan=$(".curPayState").find("span");
		var curSettlementStatu;
		settlementStatuName=$(curStatuSpan[0]).html();
		return  settlementStatuName
	}
//获取结算类型id
	function getSettlementStatu(){
		var curStatuSpan=$(".curPayState").find("span");
		var curSettlementStatu;
		for(var i=0;i<settlementStatuList.length;i++){
			if($(curStatuSpan[0]).html()==settlementStatuList[i]){
				curSettlementStatu=i;
			}
		}
		return  curSettlementStatu
	}


//审核订单
	$(".yesToAccount").on("click",clickAgreeBtn);
	$(".noToAccount").on("click",clickRefuseBtn);
	$(".reHandle").on("click",clickReHandleBtn);


	/****************************审核按钮的显示与隐藏******************************************/
	function changeBtnDisplay(curPayStatu){
		//console.log(curPayStatu);
		if(curPayStatu=="结算待审核"){
			$(".yesToAccount").css("display","inline-block");
			$(".noToAccount").css("display","inline-block");
			$(".reHandle").css("display","none");
		}else if(curPayStatu=="结算未通过"){
			$(".yesToAccount").css("display","none");
			$(".noToAccount").css("display","none");
			$(".reHandle").css("display","inline-block").html("重新审核");
		}else if(curPayStatu=="结算拒绝"){
			$(".yesToAccount").css("display","none");
			$(".noToAccount").css("display","none");
			$(".reHandle").css("display","none");
		}else if(curPayStatu=="结算待确认"){
			$(".yesToAccount").css("display","inline-block");
			$(".noToAccount").css("display","inline-block");
			$(".reHandle").css("display","none");
		}else if(curPayStatu=="结算待付款"){
			$(".yesToAccount").css("display","none");
			$(".noToAccount").css("display","none");
			$(".reHandle").css("display","inline-block").html("付款确认");
		}else if(curPayStatu=="结算失败"){
			$(".yesToAccount").css("display","none");
			$(".noToAccount").css("display","none");
			$(".reHandle").css("display","inline-block").html("再次付款");
		}else if(curPayStatu=="付款中"){
			$(".yesToAccount").css("display","none");
			$(".noToAccount").css("display","none");
			$(".reHandle").css("display","inline-block").html("付款详情");
		}else if(curPayStatu=="已付款"){
			$(".yesToAccount").css("display","none");
			$(".noToAccount").css("display","none");
			$(".reHandle").css("display","inline-block").html("付款详情");
		}
	}


	/************************点击确认按钮开始*******************************/
	function clickAgreeBtn(){
		var curPayStatu=getSettlementStatuName();
		//console.log(curPayStatu);
		if(curPayStatu=="结算待审核"){
			$.beamDialog({
				title:'结算审核：',
				content:'审核通过后，等待财务确认，您确定吗？',
				showCloseButton:false,
				otherButtons:["确定","取消"],
				otherButtonStyles:['btn-default yes','btn-default no'],
				bsModalOption:{keyboard: true},
				clickButton:function(sender,modal,index){
					// console.log('选中第'+index+'个按钮：'+sender.html());
					if(index==0){
						//console.log("点击了确认按钮");
						agreeAccount()
					}else if(index==1){
						//console.log("点击了取消按钮");
					}
					$(this).closeDialog(modal);
				}
			});
		}else if(curPayStatu=="结算待确认"){
			//结算待确认
			$.beamDialog({
				title:'结算审核：',
				content:'审核通过后，等待财务付款，您确定吗？',
				showCloseButton:false,
				otherButtons:["确定","取消"],
				otherButtonStyles:['btn-default yes','btn-default no'],
				bsModalOption:{keyboard: true},
				clickButton:function(sender,modal,index){
					// console.log('选中第'+index+'个按钮：'+sender.html());
					if(index==0){
						//console.log("点击了确认按钮");
						agreeAccountAgain()
					}else if(index==1){
						//console.log("点击了取消按钮");
					}
					$(this).closeDialog(modal);
				}
			});
		}
	}

	function agreeAccountAgain(){
		//结算付款确认——同意
		var settlementStatu=getSettlementStatu();
		var param={
			settlementNum:settlementNum,
			userId:userId,
			settlementType:settlementType
		}
		$.ajax({
			type:'post',
			url: absUrl+"/api/finance/balance/reaudit/agree",
			data:JSON.stringify(param),
			contentType:"application/json",
			success:function(res){
				//console.log(res);
				// getSurvey();
				window.location.reload();
			},
			error:function(xhr) {
				layer.alert("数据请求失败，请稍后刷新重试!");
				//console.log('ajax error');
			}
		});
	}
	function agreeAccount(curOptComment){
		//结算审核
		var settlementStatu=getSettlementStatu();
		var param={
			settlementNum:settlementNum,
			userId:userId,
			settlementType:settlementType,
			optComment:curOptComment||""
		}

		$.ajax({
			type:'post',
			url: absUrl+"/api/finance/balance/audit/agree",
			data:JSON.stringify(param),
			contentType:"application/json",
			success:function(res){
				//console.log(res);
				// getSurvey();
				window.location.reload();
			},
			error:function(xhr) {
				layer.alert("数据请求失败，请稍后刷新重试!");
				//console.log('ajax error');
			}
		});
	}
	/************************点击确认按钮结束*******************************/


	/************************点击拒绝按钮结束*******************************/
	function clickRefuseBtn(){
		//console.log(getSettlementStatuName())
		var curPayStatu=getSettlementStatuName();
		//console.log("点击了拒绝按钮");
		if(curPayStatu=="结算待审核"){
			$.beamDialog({
				title:'拒绝理由',
				content:"审核通过后，等待财务确认，您确定吗？<input placeholder='备注' class='refuseMsg'/>",
				showCloseButton:false,
				otherButtons:["确定","取消"],
				otherButtonStyles:['btn-default yes','btn-default no'],
				bsModalOption:{keyboard: true},
				clickButton:function(sender,modal,index){
					// console.log('选中第'+index+'个按钮：'+sender.html());
					var _this=this;
					if(index==0){
						//console.log("点击了确认按钮");
						//console.log($(".refuseMsg").val());
						refuseAccount();
						function refuseAccount(fn){
							var settlementStatu=getSettlementStatu();
							var param={
								settlementNum:settlementNum,
								userId:userId,
								settlementType:settlementType,
								optComment:$(".refuseMsg").val()
							}
							if(!$(".refuseMsg").val()){
								layer.alert("请输入备注信息");
								return false;
							}else{
								$(this).closeDialog(modal);
							}
							$.ajax({
								type:'post',
								url: absUrl+"/api/finance/balance/audit/refuse",
								data:JSON.stringify(param),
								contentType:"application/json",
								success:function(res){
									//console.log(res);
									// getSurvey();
									window.location.reload();
								},
								error:function(xhr) {
									layer.alert("数据请求失败，请稍后刷新重试!");
									//console.log('ajax error');
								}
							});
						}
					}else if(index==1){
						//console.log("点击了取消按钮");
						$(this).closeDialog(modal);
					}
				}
			});
		}else if(curPayStatu=="结算待确认"){
			//结算付款审核—拒绝
			$.beamDialog({
				title:'拒绝理由',
				content:"审核通过后，等待财务确认，您确定吗？<input placeholder='金额有误，需要重新结算' class='refuseMsg'/>",
				showCloseButton:false,
				otherButtons:["确定","取消"],
				otherButtonStyles:['btn-default yes','btn-default no'],
				bsModalOption:{keyboard: true},
				clickButton:function(sender,modal,index){
					// console.log('选中第'+index+'个按钮：'+sender.html());
					var _this=this;
					if(index==0){
						//console.log("点击了确认按钮");
						//console.log($(".refuseMsg").val());
						refuseAccountAgain();
						function refuseAccountAgain(){
							var settlementStatu=getSettlementStatu();
							var param={
								settlementNum:settlementNum,
								userId:userId,
								settlementType:settlementType,
								optComment:$(".refuseMsg").val()
							}
							if(!$(".refuseMsg").val()){
								layer.alert("请输入备注信息");
								return false;
							}else{
								$(this).closeDialog(modal);
							}
							$.ajax({
								type:'post',
								url: absUrl+"/api/finance/balance/reaudit/refuse",
								data:JSON.stringify(param),
								contentType:"application/json",
								success:function(res){
									//console.log(res);
									// getSurvey();
									window.location.reload();
								},
								error:function(xhr) {
									layer.alert("数据请求失败，请稍后刷新重试!");
									//console.log('ajax error');
								}
							});
						}
					}else if(index==1){
						//console.log("点击了取消按钮");
						$(this).closeDialog(modal);
					}
				}
			});
		}
	}
	/************************点击拒绝按钮结束*******************************/

	/*******************************点击了重新审核按钮******************************************/
	function clickReHandleBtn(){
		var curPayStatu=getSettlementStatuName();
		var _settlementStatu=getSettlementStatu();
		var rehandelHtml=$(".reHandle").html();
		//console.log(rehandelHtml);
		if(rehandelHtml=="重新审核"){
			//审核通过后，等待财务确认，您确定吗？ /api/finance/balance/audit/agree
			//拒绝后，结算单将进入结算拒绝列表，您确定吗？
			clickHandleEvent("审核通过后，等待财务确认，您确定吗？","拒绝后，结算单将进入结算拒绝列表，您确定吗？","/api/finance/balance/audit/agree")
		}else if(rehandelHtml=="付款确认"){
			clickWaitPay();
		}else if(rehandelHtml=="再次付款"){
			clickWaitPay();
			//付款失败
		}else if(rehandelHtml=="付款详情"){
			//if($(".curPayState span").html() == "付款中"){
			//	alert(1)
			//}else if($(".curPayState span").html() == "已付款"){
			//	alert(2)
			//}
			//付款中和已付款
			getpayDetail();
		}

	}
//结算待付款
	function clickWaitPay(){
		$("#myModal4").modal("show");
		$.ajax({
			type:'get',
			url:absUrl+'/api/finance/balance/paymentInfo/'+settlementNum,
			data:"",
			contentType:"application/json",
			success:function(res){
				//console.log(res);
				if(res.code==0){
					var payDetail=res.data;
					$(".payTable").html("");
					//settlementStatus
					if(payDetail.receiptPlatform!=''){
						var receiptPlatform= landlordList[payDetail.receiptPlatform];
					}else{
						var receiptPlatform = '-';
					}
					$(".payTable").append(
						"<tr>"
						+"<td>结算单号：</td>"
						+"<td class='blue bold'>"+payDetail.settlementNum+"</td>"
						+"<td>付款状态</td>"
						+"<td>"+settlementStatuList[payDetail.settlementStatus]+"</td>"
						+"</tr>"
						+"<tr>"
						+"<td>结算日期：</td>"
						+"<td>"+TimeToDate(payDetail.settlementTime,true)+"</td>"
						+"<td>付款日期：</td>"
						+"<td>——</td>"
						+"</tr>"
						+"<tr>"
						+"<td>" + (settlementType == '3'? '合伙人': '房东') + "姓名：</td>"
						+"<td>"+payDetail.settlementName+" </td>"
						+"<td>" + (settlementType == '3'? '合伙人': '房东') + "手机号：</td>"
						+"<td>"+payDetail.settlementMobile+"</td>"
						+"</tr>"
						+"<tr>"
						+"<td>收款人姓名：</td>"
						+"<td>"+payDetail.receiptName+"</td>"
						+"<td>收款人联系方式：</td>"
						+"<td>"+payDetail.receiptMobile+"</td>"
						+"</tr>"
						+"<tr>"
						+"<td>收款方式：</td>"
						+"<td>"+receiptPlatform+"</td>"
						+"<td>收款账户：</td>"
						+"<td class='receiptId'>"+payDetail.receiptAccount+"</td>"
						+"</tr>"
						+"<tr>"
						+"<td>开户行：</td>"
						+"<td>"+payDetail.dispositBank+"</td>"
						+"<td>订单总额：</td>"
						+"<td class='orange underLine bold'>￥"+(payDetail.recAmount).toFixed(2)+"</td>"
						+"</tr>"
						+"<tr>"
						+"<td>实收总额：</td>"
						+"<td  class='orange underLine bold'>￥"+(payDetail.realRecAmount).toFixed(2)+"</td>"
						+"<td>优惠金额：</td>"
						+"<td class='orange underLine bold'>￥"+(payDetail.couponAmount).toFixed(2)+"</td>"
						+"</tr>"
						+"<tr>"
						+"<td>退款金额：</td>"
						+"<td class='orange underLine bold'>￥"+(payDetail.refundAmount).toFixed(2)+"</td>"
						+"<td>结算总额：</td>"
						+"<td class='red underLine bold'>￥"+(payDetail.settlementAmount).toFixed(2)+"</td>"
						+"</tr>"
						+"<tr>"
						+"<td>付款手续费：</td>"
						+"<td class='orange bold'>—</td>"
						+"<td></td>"
						+"<td></td>"
						+"</tr>"
					);
				}
			}
		})
	}

	function surePay(){
		$("#myModal4").modal("hide");
		if($(".receiptId").html() == "" || $(".receiptId").html() == "-"){
			layer.alert("暂无收款账户信息，请线下支付!");
			return false;
		}
		var cont = "";
		if($(".pay_platform").val() == 3){
			cont = "<ul style='width: 76%;margin: 0 auto;height: 56px;'>" +
				"<li style='float: left;width: 50%;text-align: left'>" +
				"<input checked='checked' type='radio' name='pay_type' id='pay_type1' value='04900'/>" +
				"<label for='pay_type1'>其他代付</label>" +
				"</li>" +
				"<li style='float: left;width: 50%;text-align: left'>" +
				"<input type='radio' name='pay_type' id='pay_type2' value='09201'/>" +
				"<label for='pay_type2'>退款</label>" +
				"</li>" +
				"<li style='float: left;width: 50%;text-align: left'>" +
				"<input type='radio' name='pay_type' id='pay_type3' value='06601'/>" +
				"<label for='pay_type3'>测试代付业务</label>" +
				"</li>" +
				//"<li style='float: left;width: 50%;text-align: left'>" +
				//"<input type='radio' name='pay_type' id='pay_type4' value='09904'/>" +
				//"<label for='pay_type4'>汇款</label>" +
				//"</li>" +
				"</ul>" +
				"<div>确认后，结算款将支付给商家，请核对账号信息正确</div>";
			($("#myModal input[name='pay_type']").eq(0)).prop("checked", true);
		}else{
			cont = "确认后，结算款将支付给商家，请核对账号信息正确";
		};
		$.beamDialog({
			title:'结算付款：',
			content: cont,
			showCloseButton:false,
			otherButtons:["确定","取消"],
			otherButtonStyles:['btn-default yes','btn-default no'],
			bsModalOption:{keyboard: true},
			clickButton:function(sender,modal,index){
				// console.log('选中第'+index+'个按钮：'+sender.html());
				if(index==0){
					var pay_dat = {
						settleId: $(".pay_id").val(),
						optId: userId
					};
					//console.log(pay_dat); return false;
					if($(".pay_platform").val() == 2){// 支付宝
						console.log(pay_dat);
						//return false;
						$.ajax({
							type: "POST",
							contentType:"application/json;charset=UTF-8",
							url:absUrl + "/api/alipay/transfer/alipay",
							data: JSON.stringify(pay_dat),
							beforeSend: function(){
								$(".shade_wrap").css("display", "block");
							},
							success: function(res){
								//console.log(res);
								$(".shade_wrap").css("display", "none");
								if(res.code == "0000"){
									layer.alert("支付成功!", {
										time: 2000,
									})
									window.location.reload();
								}else{
									layer.alert(res.msg);
								}
							},
							error: function(){
								$(".shade_wrap").css("display", "none");
								layer.alert("支付失败，请再次尝试!");
							}
						})
					}else if($(".pay_platform").val() == 1){// 微信
						layer.alert("请选择银联支付");
					}else if($(".pay_platform").val() == 3){ // 银联
							for (var i = 0; i < $("input[name='pay_type']").length; i++) {
								if (($("input[name='pay_type']").eq(i)).prop("checked") == true) {
									pay_dat.businessCode = $("input[name='pay_type']").eq(i).val();
								}
							};

							console.log(pay_dat);
							//return false;
							$.ajax({
								type: "POST",
								contentType:"application/json;charset=UTF-8",
								url:absUrl + "/api/unionpay/transfer/pay",
								data: JSON.stringify(pay_dat),
								beforeSend: function(){
									$(".shade_wrap").css("display", "block");
								},
								success: function(res){
									$(".shade_wrap").css("display", "none");
									if(res.code == 0){
										layer.alert("支付成功!", {
											time: 2000,
										})
										window.location.reload();
									}else{
										layer.alert(res.msg);
									}
								},
								error: function(){
									$(".shade_wrap").css("display", "none");
									layer.alert("支付失败，请再次尝试!");
								}
							})
					}else{
						layer.alert("支付方式有误!");
					}
				}else if(index==1){
					//console.log("点击了取消按钮");

				}
				$(this).closeDialog(modal);
			}
		});
	}

//重新审核
	function clickHandleEvent(msgConAgree,msgConRefuse,acceptApi){
		var settlementStatu=getSettlementStatu();
		//console.log(settlementStatu);
		$.beamDialog({
			title:'重审理由：',
			content:"<input placeholder='备注' class='refuseMsg reviewInput'/>",
			showCloseButton:false,
			otherButtons:["通过","拒绝"],
			otherButtonStyles:['btn-default yes','btn-default no'],
			bsModalOption:{keyboard: true},
			clickButton:function(sender,modal,index){
				// console.log('选中第'+index+'个按钮：'+sender.html());
				if(index==0){
					//通过
					// console.log($(".refuseMsg").val());
					if(!$(".refuseMsg").val()){
						layer.alert("请输入备注信息");
						return false;
					}else{
						var curOptComment=$(".refuseMsg").val();
						$(this).closeDialog(modal);
					}
					$.beamDialog({
						title:'结算审核：',
						content:msgConAgree,
						showCloseButton:false,
						otherButtons:["确定","取消"],
						otherButtonStyles:['btn-default yes','btn-default no'],
						bsModalOption:{keyboard: true},
						clickButton:function(sender,modal,index){
							// console.log('选中第'+index+'个按钮：'+sender.html());
							if(index==0){
								//console.log("确认-确认");
								agreeAccount(curOptComment)

							}else if(index==1){
								//console.log("点击了取消按钮");
							}
							$(this).closeDialog(modal);
						}
					});
				}else if(index==1){
					//拒绝
					if(!$(".refuseMsg").val()){
						layer.alert("请输入备注信息");
						return false;
					}else{
						var curOptComment=$(".refuseMsg").val();
						$(this).closeDialog(modal);

					}
					$.beamDialog({
						title:'结算审核：',
						content:msgConRefuse,
						showCloseButton:false,
						otherButtons:["确定","取消"],
						otherButtonStyles:['btn-default yes','btn-default no'],
						bsModalOption:{keyboard: true},
						clickButton:function(sender,modal,index){
							// console.log('选中第'+index+'个按钮：'+sender.html());
							if(index==0){
								//console.log("拒绝-同意");
								reviewAccount();
								function reviewAccount(){
									var param={
										settlementNum:settlementNum,
										userId:userId,
										settlementType:settlementType,
										optComment:curOptComment
									}
									//console.log(param);
									$.ajax({
										type:'post',
										url: absUrl+"/api/finance/balance/audit/refuse",
										data:JSON.stringify(param),
										contentType:"application/json",
										success:function(res){
											//console.log(res);
											// getSurvey();
											window.location.reload();
										},
										error:function(xhr) {
											layer.alert("数据请求失败，请稍后刷新重试!");
											//console.log('ajax error');
										}
									});
								}

							}else if(index==1){
								//console.log("点击了取消按钮");
							}
							$(this).closeDialog(modal);
						}
					});
					$(this).closeDialog(modal);
				}
			}
		});
	}

//获取付款详情
	function getpayDetail(){
		//console.log("获取付款详情");
		var curPayStatu=getSettlementStatuName();
		var pay_dat = {
			settleId: $(".pay_id").val(),
			optId: userId
		}
		//console.log("curPayStatu=" + curPayStatu);
		if(curPayStatu == "付款中"){
			var search_payUrl = "";
			if($(".pay_platform").val() == 2){// 支付宝
				search_payUrl = "/api/alipay/transfer/alipay/query";
			}else if($(".pay_platform").val() == 3){ // 银联
				search_payUrl = "/api/unionpay/transfer/query";
			}else if($(".pay_platform").val() == 1){
				return false;
			}
			$.ajax({
				type: "POST",
				contentType: "application/json;charset=UTF-8",
				url: absUrl + search_payUrl,
				data: JSON.stringify(pay_dat),
				success: function (res) {
					// 这里还差一个将页面的付款中变为已付款的操作，以及如何判定是否更改
					if(res.code == 0){
						pay_detail(curPayStatu, settlementStatuList, landlordList)
					}else{
						layer.alert(res.msg);
					}
				},
				error:function(){
					layer.alert("请求失败，请刷新重试!")
				}
			})
		}else{
			pay_detail(curPayStatu, settlementStatuList, landlordList)
		}


		// myModal5
	}

// 获取付款详情查询
	function pay_detail(curPayStatu, settlementStatuList, landlordList){
		//console.log(settlementNum);
		$.ajax({
			type:'get',
			url:absUrl+'/api/finance/balance/paymentInfo/'+settlementNum,
			data:"",
			contentType:"application/json",
			success:function(res){
				if(res.code==0){
					var payDetail=res.data;
					$(".payTable").html("");
					$(".modal-header").html("");
					//settlementStatus
					if(curPayStatu=="付款中") {
						$(".modal-header").append(
							"<span class='modelMsg'>请稍后刷新页面确认付款结果</span>"
							+"<h4 class='modal-title' >付款中</h4>"
						);
						$(".payTable").append(
							"<tr>"
							+ "<td>结算单号：</td>"
							+ "<td class='blue bold'>" + payDetail.settlementNum + "</td>"
							+ "<td>付款状态</td>"
							+ "<td>付款中</td>"
							+ "</tr>"
							+ "<tr>"
							+ "<td>结算日期：</td>"
							+ "<td>" + TimeToDate(payDetail.settlementTime, "-") + "</td>"
							+ "<td>付款日期：</td>"
							+ "<td>" + TimeToDate(payDetail.payTime, "-") + "</td>"  //付款日期
							+ "</tr>"
							+ "<tr>"
							+ "<td>" + (settlementType == '3'? '合伙人': '房东') + "姓名：</td>"
							+ "<td>" + payDetail.settlementName + " </td>"
							+ "<td>" + (settlementType == '3'? '合伙人': '房东') + "手机号：</td>"
							+ "<td>" + payDetail.settlementMobile + "</td>"
							+ "</tr>"
							+ "<tr>"
							+ "<td>收款人姓名：</td>"
							+ "<td>" + payDetail.receiptName + "</td>"
							+ "<td>收款人联系方式：</td>"
							+ "<td>" + payDetail.receiptMobile + "</td>"
							+ "</tr>"
							+ "<tr>"
							+ "<td>收款方式：</td>"
							+ "<td>" + landlordList[payDetail.receiptPlatform] + "</td>"
							+ "<td>收款账户：</td>"
							+ "<td>" + payDetail.receiptAccount + "</td>"
							+ "</tr>"
							+ "<tr>"
							+ "<td>开户行：</td>"
							+ "<td>" + valNull(payDetail.dispositBank) + "</td>"
							+ "<td>订单总额：</td>"
							+ "<td class='orange underLine bold'>￥" + (payDetail.recAmount).toFixed(2) + "</td>"
							+ "</tr>"
							+ "<tr>"
							+ "<td>实收总额：</td>"
							+ "<td  class='orange underLine bold'>￥" + (payDetail.realRecAmount).toFixed(2) + "</td>"
							+ "<td>优惠金额：</td>"
							+ "<td class='orange underLine bold'>￥" + (payDetail.couponAmount).toFixed(2) + "</td>"
							+ "</tr>"
							+ "<tr>"
							+ "<td>退款金额：</td>"
							+ "<td class='orange underLine bold'>￥" + (payDetail.refundAmount).toFixed(2) + "</td>"
							+ "<td>结算总额：</td>"
							+ "<td class='red underLine bold'>￥" + (payDetail.settlementAmount).toFixed(2) + "</td>"
							+ "</tr>"
							+ "<tr>"
							+ "<td>付款手续费：</td>"
							+ "<td class='orange bold'>"+valNull(payDetail.serviceCharge)+"</td>"
							+ "<td>付款人：</td>"
							+ "<td>" + valNull(payDetail.optName) + "</td>"
							+ "</tr>")
					}else if(curPayStatu=="已付款"){
						$(".modal-header").append(
							+"<h4 class='modal-title' >付款详情！</h4>"
						);
						$(".payTable").append(
							"<tr>"
							+ "<td>结算单号：</td>"
							+ "<td class='blue bold'>" + payDetail.settlementNum + "</td>"
							+ "<td>付款状态</td>"
							+"<td>"+settlementStatuList[payDetail.settlementStatus]+"</td>"
							+ "</tr>"
							+ "<tr>"
							+ "<td>结算日期：</td>"
							+ "<td>" + TimeToDate(payDetail.settlementTime, "-") + "</td>"
							+ "<td>付款日期：</td>"
							+ "<td>" + TimeToDate(payDetail.payTime, "-") + "</td>"  //付款日期
							+ "</tr>"
							+ "<tr>"
							+ "<td>" + (settlementType == '3'? '合伙人': '房东') + "姓名：</td>"
							+ "<td>" + payDetail.settlementName + " </td>"
							+ "<td>" + (settlementType == '3'? '合伙人': '房东') + "手机号：</td>"
							+ "<td>" + payDetail.settlementMobile + "</td>"
							+ "</tr>"
							+ "<tr>"
							+ "<td>收款人姓名：</td>"
							+ "<td>" + payDetail.receiptName + "</td>"
							+ "<td>收款人联系方式：</td>"
							+ "<td>" + payDetail.receiptMobile + "</td>"
							+ "</tr>"
							+ "<tr>"
							+ "<td>收款方式：</td>"
							+ "<td>" + landlordList[payDetail.receiptPlatform] + "</td>"
							+ "<td>收款账户：</td>"
							+ "<td>" + payDetail.receiptAccount + "</td>"
							+ "</tr>"
							+ "<tr>"
							+ "<td>开户行：</td>"
							+ "<td>" + valNull(payDetail.dispositBank) + "</td>"
							+ "<td>订单总额：</td>"
							+ "<td class='orange underLine bold'>￥" + (payDetail.recAmount).toFixed(2) + "</td>"
							+ "</tr>"
							+ "<tr>"
							+ "<td>实收总额：</td>"
							+ "<td  class='orange underLine bold'>￥" + (payDetail.realRecAmount).toFixed(2) + "</td>"
							+ "<td>优惠金额：</td>"
							+ "<td class='orange underLine bold'>￥" + (payDetail.couponAmount).toFixed(2) + "</td>"
							+ "</tr>"
							+ "<tr>"
							+ "<td>退款金额：</td>"
							+ "<td class='orange underLine bold'>￥" + (payDetail.refundAmount).toFixed(2) + "</td>"
							+ "<td>结算总额：</td>"
							+ "<td class='red underLine bold'>￥" + (payDetail.settlementAmount).toFixed(2) + "</td>"
							+ "</tr>"
							+ "<tr>"
							+ "<td>付款手续费：</td>"
							+ "<td class='orange bold'>"+valNull(payDetail.serviceCharge)+"</td>"
							+ "<td>付款人：</td>"
							+ "<td>" + valNull(payDetail.optName) + "</td>"
							+ "</tr>"
							+ "<tr>"
							+ "<td>第三方流水号：</td>"
							+ "<td >"+payDetail.transactionId+"</td>"
							+ "<td></td>"
							+ "<td></td>"
							+ "</tr>"
						)
					}
					$("#myModal5").modal("show");
				}else {
					layer.alert(res.msg);
				}
			}
		})
	}
	/**********************************重新审核按钮结束*******************************************/

