	// 请求数据网址
	var http_url = serveUrl();
	// 分页器实现以及初始化请求数据需要的对消
	var searchData = {
		searchParams: {
			pageSize: $(".pageSize").val(), // 每页条数
			pageNum: 1, // 页数
			incrementType: -1 // 显示的类别
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
			list_data: [],
			order_data: {},
			data: {},
			tr: "",
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
				30: "部分退款结束",
				35: "已结算",
				40: "订单结束"
			},
			update_arr: ["", "成功", "失败"],
			pay_arr: ["未支付", "支付宝", "微信", "银联"]
		},
		created: function(){ // 当Vue组件创建时执行
			var _this = this;
			_this.get_data("/api/tongcheng/recordUpdateFailureLog", searchData.searchParams, _this);
		},
		methods:{
			tap_change: function(num, ind){// 切换显示类型的时候
				var _this = this;
				$(".tap_change li").eq(ind).attr("class", "click_btn").siblings().removeAttr("class");
				searchData.init({"incrementType": num});
				_this.get_data("/api/tongcheng/recordUpdateFailureLog", searchData.searchParams, _this)
			},
			change_listSize: function(num){ // 点击每页显示条数
				var _this = this;
				searchData.init({
					"pageSize": $(num.target).val(),
					"pageNum": 1 // ???待确认
				})
				this.get_data("/api/tongcheng/recordUpdateFailureLog", searchData.searchParams, _this);
			},
			click_proOrnext: function(num){ // 点击上一页、下一页、首页、尾页
				var _this = this;
				if($(".pro_next").eq(num).attr("class") != "pro_next disabled"){
					searchData.init({"pageNum": $(".pro_next").eq(num).find("input").val()});
					this.pn = $(".pro_next").eq(num).find("input").val();
					this.get_data("/api/tongcheng/recordUpdateFailureLog", searchData.searchParams, _this);
				}				
			},
			get_data: function(url, dat, ele){ // 请求数据
				$.ajax({
					type:"POST",
					contentType: "application/json;charset=UTF-8",
					url: http_url + url,
					data: JSON.stringify(dat),
					success:function(data){
						if(data.code == 0){
							ele.data = data;
							ele.list_data = data.pageInfo.list;
							if(data.pageInfo.list.length == 0){
								$(".prompt_msg span").eq(0).html(ele.change_time(new Date().getTime(), "y"));
								layer.alert("暂时没有更新失败订单!");
							}else{
								$(".prompt_msg span").eq(0).html(ele.change_time(ele.list_data[0].updateTime, 'y'))
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
			                            ele.get_data("/api/tongcheng/recordUpdateFailureLog", searchData.searchParams, ele)
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