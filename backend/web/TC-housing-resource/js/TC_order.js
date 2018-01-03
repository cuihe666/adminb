	// 初始化页面
	// 设置页面请求网址
	var http_url = serveUrl();
	// console.log(http_url)
	// 设置对象
	var searchData = {
		searchParams: {
			pageSize: $(".pageSize").val(), // 每页条数
			pageNum: 1, // 页数
			orderStatus: "",
			type: "",
			orderId: "",
			updateState: "",
			houseId: "",
			startTime: "",
			endTime: ""
		},
		init: function(obj){
			var _this = this;
			$.each(obj, function(keys, val){
				_this.searchParams[keys] = val;
			})
		}
	}
	var vm = new Vue({
		el: "#myApp",
		data: { // 默认需要的数据
			list_data: {},
			order_data: {},
			data: {},
			pn: 1,
			state_arr: {
				0: "待确认库存",
				1: "待支付",
				2: "已取消",
				3: "已支付",
				5: "待同程确认",
				10: "同程已确认",
				11: "确认入住",
				12: "确认未住",
				15: "申请部分退款",
				20: "申请全额退款",
				25: "全额退款结束",
				26: "部分退款结束",
				27: "拒绝部分退款",
				30: "部分退款结束",
				35: "已结算",
				40: "订单结束",
				41: "未抢到房源"
			},
			reserve_state: {
				0: "带同程确认/审核后支付",
				1: "直接支付",
				2: "前台支付",
				3: "担保"
			},
			id_type:{
				0: "身份证",
				1: "身份证",
				2: "护照",
				3: "军官证",
				4: "士兵证",
				5: "港澳台通行证",
				6: "临时身份证",
				7: "户口本",
				8: "其他",
				9: "警官证",
				12: "外国人居留证",
				15: "回乡证",
				16: "企业营业执照",
				17: "法人代码证",
				18: "台胞证"
			},
			update_arr: ["成功", "失败"],
			pay_arr: ["未支付", "支付宝", "微信", "网银"],
			houseType: ["酒店", "景区", "餐饮" , "门票"],
			detail_obj: {
				"tcOrderInfoModel": {
		            "id": "1234444",
		            "cusOrderId": "232312",
		            "displayId": "232345",
		            "orderFlag": "",
		            "orderStatus": "",
		            "origin": "",
		            "insuranceAmount": "",
		            "orderAmount": "",
		            "money": "",
		            "refundAmount": "",
		            "compensateAmount": "",
		            "penaltyAmount": "",
		            "contact": "",
		            "cellphone": "",
		            "contactSex": "",
		            "startTime": "",
		            "endTime": "",
		            "createTime": "",
		            "productTitle": "",
		            "lasestCancelTime": "",
		            "paymentFlag": "",
		            "resId": "",
		            "proId": "",
		            "tgOrderId": "",
		            "updateState": "",
		            "updateTime": "",
		            "resName": "",
		            "proName": "",
		            "adultCount": "",
		            "childCount": "",
		            "priceFraction": "",
		            "roomCount": "",
		            "days": "",
		            "resultCode": ""
		        },
		        "tcPassengerModelList": [
		            {
		                "id": "",
		                "cusOrderId": "",
		                "name": "",
		                "idType": "",
		                "idNo": ""
		            }
		        ],
		        "tcResourceModel": [{
		            "id": "",
		            "cusOrderId": "",
		            "resourceId": "",
		            "name": "",
		            "productName": "",
		            "type": "",
		            "priceFraction": "",
		            "useStartDate": "",
		            "useEndDate": "",
		            "remark": "",
		            "productUniqueId": "",
		            "supplierResourceProps": "",
		            "arrivalTime": "",
		            "supplierConfirmNumber": ""
		        }]
			}
		},
		created: function(){ // 当Vue组件创建时执行
			var _this = this;
			_this.get_data("/api/tongcheng/getTcOrderList", searchData.searchParams, _this);
		},
		methods:{
			update_list: function(){ // 更新全部
				var _this = this;
				$.ajax({
					type:"GET",
					contentType: "application/json;charset=UTF-8",
					url: http_url + "/api/tongcheng/udpateAllTcOrder",
					success:function(data){
						if(data.code == 0){
							layer.alert("更新成功!", function (){
								_this.get_data("/api/tongcheng/getTcOrderList", searchData.searchParams, _this);
								layer.closeAll()	
							});																				
						}else{
							layer.alert(data.msg);
						}
					},
					error: function(){
						layer.alert("error");
					}
				})	
			},
			order_change: function(){ // 订单号切换时清空后面的文本框
				$(".order_num").val("");
			},
			update_single: function(ids, ind){ // 更新单个
				var _this = this;
				$.ajax({
					type:"POST",
					contentType: "application/json;charset=UTF-8",
					url: http_url + "/api/tongcheng/updateTcSingleOrderState",
					data: JSON.stringify({cusOrderId: ids}),
					success:function(data){
						if(data.code == 0){
							layer.alert("更新成功!", function(){
								_this.get_data("/api/tongcheng/getTcOrderList", searchData.searchParams, _this)
								layer.closeAll();
							});
						}else{
							layer.alert(data.msg);
						}
					},
					error: function(){
						layer.alert("error");
					}
				})	
			},
			clear_all: function(){ // 清空所有输入框
				$(".order_state").val(-1);
				$(".order_type").val("");
				$(".order_num").val("");
				$(".update_type").val("");
				$(".houseId").val("");
				$("#d422").val("");
				$("#d4312").val("");
			},
			search_order: function(){ // 查询按钮
				var order_state = $(".order_state").val();
				var order_num = $.trim($(".order_num").val());
				var order_type = $(".order_type").val();
				var update_state = $(".update_state").val();
				var house_id = $.trim($(".house_id").val());
				var order_start = $.trim($("#d422").val());
				var order_end = $.trim($("#d4312").val());
				if(order_type != "" && order_num == ""){
					layer.alert("请填写订单号!");
					return false;
				}
				if(order_num != "" && order_type == ""){
					layer.alert("请选择订单类型!");
					return false;
				}
				if(order_start != "" && order_end == ""){
					layer.alert("请填写订单结束时间!");
					return false;
				}
				if(order_end != "" && order_start == ""){
					layer.alert("请填写订单开始时间!");
					return false;
				}
				searchData.init({
					"pageSize": $(".pageSize").val(),
					"pageNum": 1, // ???待确认
					"orderStatus": $(".order_state").val(),
					"type": $(".order_type").val(),
					"orderId": $(".order_num").val(),
					"updateState": $(".update_type").val(),
					"houseId": $(".houseId").val(),
					"startTime": this.to_millisecond($("#d422").val()),
					"endTime": (parseInt(this.to_millisecond($("#d4312").val())) + 86399000)
				});
				var _this = this;
				this.get_data("/api/tongcheng/getTcOrderList", searchData.searchParams, _this)
			},
			order_detail: function(ids, ind, eve){ // 点击详情按钮
				var _this = this;
				$.ajax({
					type:"GET",
					contentType: "application/json;charset=UTF-8",
					url: http_url + "/api/tongcheng/getTcOrderDetail/" + ids,
					success:function(data){
						if(data.code == 0){
							_this.detail_obj = data.data;
							$(".order_ids").html(ids);
							var a = _this.list_data[ind].orderStatus
							$(".order_status").html(_this.state_arr[a])
							$("#myModal").modal();
						}else{
							layer.alert("数据请求失败，请稍后重试!");
						}
					},
					error: function(){
						layer.alert("数据请求失败，请稍后重试!");
					}
				})				
			},
			change_listSize: function(num){ // 点击每页显示条数
				var _this = this;
				console.log($(num.target).val());
				searchData.init({
					"pageSize": $(num.target).val(),
					"pageNum": 1 // ???待确认
				})
				console.log(searchData.searchParams);
				this.get_data("/api/tongcheng/getTcOrderList", searchData.searchParams, _this);
			},
			export_excel: function(){ // 导出excel
				window.location.href = http_url + "/api/tongcheng/exportExcelTcOrderExcel?orderStatus=" + searchData.searchParams.orderStatus + "&type=" + searchData.searchParams.type + "&orderId=" + searchData.searchParams.orderId + "&updateState=" + searchData.searchParams.updateState + "&houseId=" + searchData.searchParams.houseId + "&startTime=" + searchData.searchParams.startTime + "&endTime=" + searchData.searchParams.endTime;
			},
			click_proOrnext: function(num){ // 点击上一页、下一页、首页、尾页
				var _this = this;
				if($(".pro_next").eq(num).attr("class") != "pro_next disabled"){
					searchData.init({"pageNum": $(".pro_next").eq(num).find("input").val()});
					this.pn = $(".pro_next").eq(num).find("input").val();
					this.get_data("/api/tongcheng/getTcOrderList", searchData.searchParams, _this);
				}				
			},
			get_data: function(url, dat, ele){ // 请求数据
				$.ajax({
					type:"POST",
					contentType: "application/json;charset=UTF-8",
					url: http_url + url,
					data: JSON.stringify(dat),
					success:function(data){
						// console.log(222)
						if(data.code == 0){
							// var data = {
							//     "code": 0,
							//     "data": 20,
							//     "msg": "success",
							//     "pageInfo": {
							//         "pageNum": 1,
							//         "pageSize": 15,
							//         "size": 0,
							//         "orderBy": "",
							//         "startRow": 0,
							//         "endRow": 0,
							//         "total": "15",
							//         "pages": 0,
							//         "list": [
							//         	{
							//         		tgOrderNum: 228930,
							// 				cusOrderId: 228930,
							// 				productTitle: "龙景苑客栈－标准间",
							// 				houseId: 562427,
							// 				orderStatus: 0,
							// 				updateState: 1,
							// 				payStauts: 2,
							// 				payPlatform: 3,
							// 				orderAmount: 110,
							// 				refundAmount: 3,
							// 				createTime: 1507553728000,
							// 				updateTime: 1507573728000,
							// 				roomCount: 3,
							// 				days: 5,
							// 				startTime: 1507593728000,
							// 				endTime: 1507753728000
							//         	},{
							//         		tgOrderNum: 228930,
							// 				cusOrderId: 228930,
							// 				productTitle: "龙景苑客栈－标准间",
							// 				houseId: 562427,
							// 				orderStatus: 0,
							// 				updateState: 2,
							// 				payStauts: 2,
							// 				payPlatform: 3,
							// 				orderAmount: 110,
							// 				refundAmount: 3,
							// 				createTime: 1507553728000,
							// 				updateTime: 1507573728000,
							// 				roomCount: 3,
							// 				days: 5,
							// 				startTime: 1507593728000,
							// 				endTime: 1507753728000
							//         	},{
							//         		tgOrderNum: 228930,
							// 				cusOrderId: 228930,
							// 				productTitle: "龙景苑客栈－标准间",
							// 				houseId: 562427,
							// 				orderStatus: 0,
							// 				updateState: 2,
							// 				payStauts: 2,
							// 				payPlatform: 3,
							// 				orderAmount: 110,
							// 				refundAmount: 3,
							// 				createTime: 1507553728000,
							// 				updateTime: 1507573728000,
							// 				roomCount: 3,
							// 				days: 5,
							// 				startTime: 1507593728000,
							// 				endTime: 1507753728000
							//         	},{
							//         		tgOrderNum: 228930,
							// 				cusOrderId: 228930,
							// 				productTitle: "龙景苑客栈－标准间",
							// 				houseId: 562427,
							// 				orderStatus: 0,
							// 				updateState: 1,
							// 				payStauts: 2,
							// 				payPlatform: 3,
							// 				orderAmount: 110,
							// 				refundAmount: 3,
							// 				createTime: 1507553728000,
							// 				updateTime: 1507573728000,
							// 				roomCount: 3,
							// 				days: 5,
							// 				startTime: 1507593728000,
							// 				endTime: 1507753728000
							//         	},{
							//         		tgOrderNum: 228930,
							// 				cusOrderId: 228930,
							// 				productTitle: "龙景苑客栈－标准间",
							// 				houseId: 562427,
							// 				orderStatus: 0,
							// 				updateState: 2,
							// 				payStauts: 2,
							// 				payPlatform: 3,
							// 				orderAmount: 110,
							// 				refundAmount: 3,
							// 				createTime: 1507553728000,
							// 				updateTime: 1507573728000,
							// 				roomCount: 3,
							// 				days: 5,
							// 				startTime: 1507593728000,
							// 				endTime: 1507753728000
							//         	},{
							//         		tgOrderNum: 228930,
							// 				cusOrderId: 228930,
							// 				productTitle: "龙景苑客栈－标准间",
							// 				houseId: 562427,
							// 				orderStatus: 0,
							// 				updateState: 1,
							// 				payStauts: 2,
							// 				payPlatform: 3,
							// 				orderAmount: 110,
							// 				refundAmount: 3,
							// 				createTime: 1507553728000,
							// 				updateTime: 1507573728000,
							// 				roomCount: 3,
							// 				days: 5,
							// 				startTime: 1507593728000,
							// 				endTime: 1507753728000
							//         	},{
							//         		tgOrderNum: 228930,
							// 				cusOrderId: 228930,
							// 				productTitle: "龙景苑客栈－标准间",
							// 				houseId: 562427,
							// 				orderStatus: 0,
							// 				updateState: 1,
							// 				payStauts: 2,
							// 				payPlatform: 3,
							// 				orderAmount: 110,
							// 				refundAmount: 3,
							// 				createTime: 1507553728000,
							// 				updateTime: 1507573728000,
							// 				roomCount: 3,
							// 				days: 5,
							// 				startTime: 1507593728000,
							// 				endTime: 1507753728000
							//         	},{
							//         		tgOrderNum: 228930,
							// 				cusOrderId: 228930,
							// 				productTitle: "龙景苑客栈－标准间",
							// 				houseId: 562427,
							// 				orderStatus: 0,
							// 				updateState: 1,
							// 				payStauts: 2,
							// 				payPlatform: 3,
							// 				orderAmount: 110,
							// 				refundAmount: 3,
							// 				createTime: 1507553728000,
							// 				updateTime: 1507573728000,
							// 				roomCount: 3,
							// 				days: 5,
							// 				startTime: 1507593728000,
							// 				endTime: 1507753728000
							//         	},{
							//         		tgOrderNum: 228930,
							// 				cusOrderId: 228930,
							// 				productTitle: "龙景苑客栈－标准间",
							// 				houseId: 562427,
							// 				orderStatus: 0,
							// 				updateState: 2,
							// 				payStauts: 2,
							// 				payPlatform: 3,
							// 				orderAmount: 110,
							// 				refundAmount: 3,
							// 				createTime: 1507553728000,
							// 				updateTime: 1507573728000,
							// 				roomCount: 3,
							// 				days: 5,
							// 				startTime: 1507593728000,
							// 				endTime: 1507753728000
							//         	},{
							//         		tgOrderNum: 228930,
							// 				cusOrderId: 228930,
							// 				productTitle: "龙景苑客栈－标准间",
							// 				houseId: 562427,
							// 				orderStatus: 0,
							// 				updateState: 1,
							// 				payStauts: 2,
							// 				payPlatform: 3,
							// 				orderAmount: 110,
							// 				refundAmount: 3,
							// 				createTime: 1507553728000,
							// 				updateTime: 1507573728000,
							// 				roomCount: 3,
							// 				days: 5,
							// 				startTime: 1507593728000,
							// 				endTime: 1507753728000
							//         	}
							//         ],
							//         "firstPage": 0,
							//         "prePage": 0,
							//         "nextPage": 0,
							//         "lastPage": 0,
							//         "isFirstPage": false,
							//         "isLastPage": false,
							//         "hasPreviousPage": false,
							//         "hasNextPage": false,
							//         "navigatePages": 0,
							//         "navigatepageNums": ""
							//     }
							// }
							ele.list_data = data.pageInfo.list;
							if(data.pageInfo.list.length == 0){
								$(".cont_msg span").html(ele.change_time(new Date().getTime(), "y"))
								layer.alert("暂时没有订单数据!");
							}else{
								$(".cont_msg span").html(ele.change_time(data.pageInfo.list[0].updateTime, "y"))
								// 实现分页
			                    if($(".pages")){
			                        $(".pages").remove();
			                    }
			                    var page_num = parseInt(data.data) / parseInt($(".pageSize").val());
			                    if(page_num >  parseInt(page_num)){
			                        page_num =  parseInt(page_num) + 1;
			                    }
			                    // 首页尾页不能点击设置
			                    if(parseInt(ele.pn) == 1 && page_num != 1){
			                        $(".pro_next").eq(0).attr("class", "pro_next disabled");
			                        $(".pro_next").eq(1).attr("class", "pro_next disabled");
			                        $(".pro_next").eq(2).attr("class", "pro_next");
			                        $(".pro_next").eq(3).attr("class", "pro_next");
			                    }else if(parseInt(ele.pn) == page_num && page_num != 1){
			                        $(".pro_next").eq(0).attr("class", "pro_next");
			                        $(".pro_next").eq(1).attr("class", "pro_next");
			                        $(".pro_next").eq(2).attr("class", "pro_next disabled");
			                        $(".pro_next").eq(3).attr("class", "pro_next disabled");
			                    }else if(parseInt(ele.pn) == 1 && page_num == 1){
			                        $(".pro_next").eq(0).attr("class", "pro_next disabled");
			                        $(".pro_next").eq(1).attr("class", "pro_next disabled");
			                        $(".pro_next").eq(2).attr("class", "pro_next disabled");
			                        $(".pro_next").eq(3).attr("class", "pro_next disabled");
			                    }else{
			                        $(".pro_next").eq(0).attr("class", "pro_next");
			                        $(".pro_next").eq(1).attr("class", "pro_next");
			                        $(".pro_next").eq(2).attr("class", "pro_next");
			                        $(".pro_next").eq(3).attr("class", "pro_next");
			                    }
			                    $(".pro_next").eq(1).find("input").val(parseInt(ele.pn) - 1);
			                    $(".pro_next").eq(2).find("input").val(parseInt(ele.pn) + 1);
			                    $(".pro_next").eq(3).find("input").val(page_num);
			                    $(".page_num").html(page_num);
			                    if(page_num <= 5){
			                        for(var i = page_num; i >= 1; i--){
			                            $(".pro_next").eq(1).after("<li class='pages'><a>" + i + "</a></li>");
			                        }
			                        $(".pages a").css("background-color", "white");
			                    }else{
			                        if(parseInt(ele.pn) <= 3){
			                            for(var i = 5; i >= 1; i--){
			                                $(".pro_next").eq(1).after("<li class='pages'><a>" + i + "</a></li>");
			                            }
			                        }else if(parseInt(ele.pn) < page_num - 2){
			                            for(var i = parseInt(ele.pn) + 2; i >= parseInt(ele.pn) - 2; i--){
			                                $(".pro_next").eq(1).after("<li class='pages'><a>" + i + "</a></li>");
			                            }
			                        }else{
			                            for(var i = page_num; i > page_num - 5; i--){
			                                $(".pro_next").eq(1).after("<li class='pages'><a>" + i + "</a></li>");
			                            }
			                        }
			                        $(".pages a").css("background-color", "white");
			                    }
			                    $(".pages a").each(function(index){
			                        if($(this).html() == parseInt(ele.pn)){
			                            $(this).css("background", "#ccc");
			                        }
			                    })
			                    // 点击分页器具体页数
			                    $(".pages a").each(function(index){
			                        $(".pages a").eq(index).on("click", function(){
			                        	searchData.init({
			                        		"pageNum": $(this).html()
			                        	});
			                        	ele.pn = $(this).html();
			                        	// console.log(ele.pn)
			                         //    console.log(searchData.searchParams)
			                            ele.get_data("/api/tongcheng/getTcOrderList", searchData.searchParams, ele)
			                        })
			                    })
							}							
						}else{
							layer.alert("数据请求失败，请刷新重试!");
						}					
					},
					error: function(){
						layer.alert("请求数据失败!");
					}
				})
			},
			change_time: function(dat, el){ // 转换时间
				dat = parseInt(dat);
				var year = new Date(dat).getFullYear();
				var month = new Date(dat).getMonth();
				var da = new Date(dat).getDate();
				var ho = new Date(dat).getHours();
				var min = new Date(dat).getMinutes();
				var sec = new Date(dat).getSeconds();
				if(sec < 10){
					sec = "0" + sec;
				}
				if(min < 10){
					min = "0" + min;
				}
				if(el){
					var e = year + "-" + (month + 1) + "-" + da + " " + ho + ":" + min + ":" + sec;
				}else{
					var e = year + "-" + (month + 1) + "-" + da;
				}
				return e;
			},
			to_millisecond: function(dat){ // 将时间转化为时间戳
				if(dat){
					var millised = new Date(dat.replace("-", "/").replace("-", "/")).getTime();
					return millised;
				}else{
					return ""
				}				
			}
		}
	})