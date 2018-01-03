	// 初始化页面
	// 设置页面请求网址
	var http_url = serveUrl();
	// 设置对象
	var searchData = {
		searchParams: {
			pageSize: $(".pageSize").val(), // 每页条数
			pageNum: "1", // 页数
			status: "",
			sourceType: "",
			orderNum: "",
			hotelId: "",
			createTimeBegin: "",
			createTimeEnd: "",
			cityCode: "",
			orderMobile: "",
			userMobile: "",
			hotelType: "",
			payPlatform: ""
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
				0: "待支付",
				11: "待确认",
				12: "待入住",
				13: "已入住",
				14: "已离店",
				15: "已点评",
				21: "已取消",
				31: "退款中",
				32: "已退款",
				33: "退款失败",
				"-1": "酒店拒单"
			},
			update_arr: ["成功", "失败"],
			pay_arr: {
				0: "-",
				1: "支付宝",
				2: "微信"
			},
		},
		created: function(){ // 当Vue组件创建时执行
			var _this = this;
			_this.get_data("/api/hotel/order/getOrderList", searchData.searchParams, _this);
		},
		methods:{
			order_change: function(){ // 订单号切换时清空后面的文本框
				$(".order_num").val("");
			},
			clear_all: function(){ // 清空所有输入框
				$(".order_state").val("");
				$(".order_type").val("");
				$(".order_num").val("");
				$(".update_type").val("");
				$(".houseId").val("");
				$("#d422").val("");
				$("#d4312").val("");
			},
			search_order: function(){ // 查询按钮
				var order_state = $(".order_state").val(); // 订单状态
				var order_num = $.trim($(".order_num").val()); // 订单号
				var order_type = $(".order_type").val(); // 订单类别
				var hotel_id = $.trim($(".hotelId").val()); // 酒店ID
				var order_start = $.trim($("#d422").val()); // 下单开始时间
				var order_end = $.trim($("#d4312").val()); // 下单结束时间
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
				// 初始化参数
				searchData.init({
					"pageSize": $(".pageSize").val(),
					"pageNum": 1, 
					"status": order_state,
					"sourceType": order_type,
					"orderNum": order_num,
					"hotelId": hotel_id,
					"createTimeBegin": this.to_millisecond(order_start) > 0?this.to_millisecond(order_start): "",
					"createTimeEnd": (parseInt(this.to_millisecond(order_end))?parseInt(this.to_millisecond(order_end)) + 86399000: "")
				});
				var _this = this;
				this.get_data("/api/hotel/order/getOrderList", searchData.searchParams, _this) // ???接口待确认
			},
			change_listSize: function(num){ // 点击每页显示条数
				var _this = this;
				searchData.init({
					"pageSize": $(num.target).val(),
					"pageNum": 1 // ???待确认
				})
				this.pn = 1;
				this.get_data("/api/hotel/order/getOrderList", searchData.searchParams, _this);
			},
			click_proOrnext: function(num){ // 点击上一页、下一页、首页、尾页
				var _this = this;
				if($(".pro_next").eq(num).attr("class") != "pro_next disabled"){
					searchData.init({"pageNum": $(".pro_next").eq(num).find("input").val()});
					this.pn = $(".pro_next").eq(num).find("input").val();
					this.get_data("/api/hotel/order/getOrderList", searchData.searchParams, _this);
				}				
			},
			get_data: function(url, dat, ele){ // 请求数据
				$.ajax({
					type:"POST",
					contentType: "application/json;charset=UTF-8",
					url: http_url + url,
					data: JSON.stringify(dat),
					beforeSend: function(){
						$(".loading_wrap").css("display", "block");
					},
					success:function(data){
						$(".loading_wrap").css("display", "none");
						if(data.code == 0){
							// ？？？？进行数据绑定
							ele.list_data = data.data.list;
							if($(".pages")){
			                        $(".pages").remove();
			                    }
							if(data.data.list.length == 0){
								layer.alert("暂时没有订单数据!");
								for(var i = 0; i < $(".pro_next").length; i++){
									$(".pro_next").eq(i).attr("class", "pro_next disabled");
								}		              
			                    $(".page_num").html(0);
							}else{
								// 实现分页		
								ele.pn = data.data.pageNum;	               
			                    var page_num = parseInt(data.data.total) / parseInt($(".pageSize").val());
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
			                        if($(this).html() == data.data.pageNum){
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
			                            ele.get_data("/api/hotel/order/getOrderList", searchData.searchParams, ele); 
			                        })
			                    })
							}							
						}else{
							layer.alert("数据请求失败，请刷新重试!");
						}					
					},
					error: function(){
						$(".loading_wrap").css("display", "none");
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
					return "0"
				}				
			}
		}
	})