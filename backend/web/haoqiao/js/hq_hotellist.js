	// 初始化页面
	// 设置页面请求网址
	var http_url = serveUrl();
	// 设置对象
	var searchData = {
		searchParams: {
			pageSize: $(".pageSize").val(), // 每页条数
			pageNum: "1", // 页数
			provinceCode: $(".check_province").val(),
			cityCode: $(".check_city").val(),
			type: $(".check_type").val(),
			hotelNameOrId: $.trim($(".check_type").val()),
			checkStatus: "0",
			status: "",
			supplierNameOrId: "",
			sourceType: ""
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
			province_data: [],
			city_data: [],
			type: 0,
			pn: 1,
			list_data: [],
			star_arr: {
				1: "1星级",
				5: "2星级",
				6: "3星级",
				7: "4星级",
				8: "5星级"
			},
			startRow: 0,
			hotelIds: [],
			hotel_type: ["棠果", "好巧"],
		},
		created: function(){ // 当Vue组件创建时执行
			var _this = this;
			_this.get_data("/api/hotel/getHotelListH5", searchData.searchParams, _this);
			_this.pro_change(0)
		},
		methods:{
			pro_change: function(num, ele){ // 获取省市列表num用来区分调省还是市的数据（省是0，市是1）
	            var _this = this;
	            var cont = {};
	            if(num == 0){
	            	cont = {
	            		"parentCode": "10001"
	            	}
	            }else{
	            	cont = {
		                "parentCode": $(".check_province").val()
		            };
	            }
	            $.ajax({
	                type: "POST",
	                contentType:"application/json;charset=UTF-8",
	                url: http_url + "/api/dt/getCityList",
	                data: JSON.stringify(cont),
	                success: function(res){
	                    if(res.code == 0){
	                        if(num == 0){
	                        	_this.province_data = res.data;
	                        }else{
	                        	_this.city_data = res.data;
	                        }
	                    }else{
	                        layer.alert("暂无省份!");
	                    }
	                },
	                error: function(){
	                    layer.alert("数据请求失败!");
	                }
	            });
	        },
			clear_all: function(){ // 清空所有输入框
				$(".check_province").val("");
				$(".check_city").val("");
				$(".check_type").val("");
				$(".hotel_name").val("");
				this.city_data = {};
			},
			search_order: function(){ // 查询按钮
				var provinceCode = $(".check_province").val();
				var cityCode = $(".check_city").val();
				var type = $(".check_type").val();
				var hotelNameOrId = $.trim($(".hotel_name").val());
				// 初始化参数
				searchData.init({
					"provinceCode": provinceCode,
					"cityCode": cityCode,
					"type": type,
					"hotelNameOrId": hotelNameOrId
				});
				var _this = this;
				this.get_data("/api/hotel/getHotelListH5", searchData.searchParams, _this) // ???接口待确认
			},
			add_money:function(num, ele){ // 点击批量添加(1)或者操作里面的添加酒店(0),ele为当前操作的元素
				this.type = num;
				$("#myModal .percent").val("")
				if(num == 1){
					$("#myModal .modal-content").css("height", "120px");
				}else{
					$("#myModal .modal-content").css("height", "200px");
					$("#myModal .hotel_name").html($(ele.target).parents("tr").find("td").eq(3).html())
					this.hotelIds.push($(ele.target).parents("tr").find(".ids").val());
				}
				$("#myModal").modal("show");
			},
			click_ensure: function(){ // 点击弹框里面的确定按钮
				var _this = this;
				var dat = {
					percent: $.trim($("#myModal .percent").val()),
					hotelIds: []
				};
				if(dat.percent == "" || dat.percent == 0){
					layer.alert("请设置佣金比例");
					return false;
				}
				dat.hotelIds = this.hotelIds;
				if(dat.hotelIds.length == 0){
					layer.alert("请选择要添加的酒店!");
					return false;
				}
				$.ajax({
					type:"POST",
					contentType: "application/json;charset=UTF-8",
					url: http_url + "/api/hotel/setHqCommision",
					data: JSON.stringify(dat),
					success:function(data){
						if(data.code == 0){
							layer.alert("设置成功!");
							_this.hotelIds = [];
							$("input[type='checked']").prop("checked", false);
							$("#myModal").modal("hide");
							_this.get_data("/api/hotel/getHotelListH5", searchData.searchParams, _this);
						}else{
							layer.alert(data.msg);
						}
					},
					error: function(){
						layer.alert("数据请求失败，请刷新重试!");
					}
				})
			},
			to_detail: function(num){
				console.log(num);
			},
			to_bottom: function(num){ // 置底
				var _this = this;
				$.ajax({
					type:"POST",
					contentType: "application/json;charset=UTF-8",
					url: http_url + "/api/hotel/setBottom",
					data: JSON.stringify({hotelId: num}),
					success:function(data){
						if(data.code == 0){
							_this.get_data("/api/hotel/getHotelListH5", searchData.searchParams, _this)
						}else{
							layer.alert(data.msg);
						}
					},
					error: function(){
						layer.alert("数据请求失败，请刷新重试!")
					}
				})
			},
			checked_all: function(ele){ // 全选、反选功能
				var checked = $(".checks:checked");
				if($("#checked_all").prop("checked") && checked.length == 0){ // 全选
		            $("table").find(".checks").prop("checked", true);
		            for(var i = 0; i < $(".checks").length; i++){
		            	this.hotelIds.push($(".ids").eq(i).val());
		            }
		        }else if($("#checked_all").prop("checked") && checked.length != 0){ // 反选
		        	if(!Array.indexOf){
					  	Array.prototype.indexOf = function(el){
					 		for (var i=0,n=this.length; i<n; i++){
					 			if (this[i] === el){
					  				return i;
					 			}
					 		}
					 		return -1;
					   	} 
					}
					var arr_index = 0;
		        	for(var i = 0; i < $(".checks").length; i++){
		        		if($(".checks").eq(i).prop("checked")){
		        			$(".checks").eq(i).prop("checked", false);
		        		}else{
		        			$(".checks").eq(i).prop("checked", true);
		        		}
		        		arr_index = this.hotelIds.indexOf($(".ids").eq(i).val())
		        		if(arr_index >= 0){
		        			this.hotelIds.splice(arr_index, 1);
		        		}else{
		        			this.hotelIds.push($(".ids").eq(i).val());
		        		}
		        	}
		        }else{ // 全不选
		            $("table").find(".checks").prop("checked", false);
		            for(var m = 0; m < $(".checks").length; m++){
		            	for(var n = 0; n < this.hotelIds.length; n++){
		            		if(this.hotelIds[n] == $(".ids").eq(m).val()){
		            			this.hotelIds.splice(n, 1);
		            		}
		            	}
		            }
		        }
			},
			checked_one: function(ele){ // 点击选中单个
				var checked = $(".checks:checked");
				if(checked.length == $(".checks").length){
					$("#checked_all").prop("checked", true);
				}else{
					$("#checked_all").prop("checked", false);
				}
				if(this.hotelIds.length == 0){
					this.hotelIds.push($(ele.target).parent().find(".ids").val());
				}else{
					for(var i = 0; i < this.hotelIds.length; i++){
						if(this.hotelIds[i] == $(ele.target).parent().find(".ids").val()){
							this.hotelIds.splice(i, 1);
							return false;
						}else if(i == this.hotelIds.length - 1){
							this.hotelIds.push($(ele.target).parent().find(".ids").val());
							return false;
						}
					}
				}
			},
			change_listSize: function(num){ // 点击每页显示条数
				var _this = this;
				searchData.init({
					"pageSize": $(num.target).val(),
					"pageNum": 1 // ???待确认
				})
				this.get_data("/api/hotel/getHotelListH5", searchData.searchParams, _this);
			},
			click_proOrnext: function(num){ // 点击上一页、下一页、首页、尾页
				var _this = this;
				if($(".pro_next").eq(num).attr("class") != "pro_next disabled"){
					searchData.init({"pageNum": $(".pro_next").eq(num).find("input").val()});
					this.pn = $(".pro_next").eq(num).find("input").val();
					this.get_data("/api/hotel/getHotelListH5", searchData.searchParams, _this);
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
							ele.list_data = data.data.list;
							if($(".pages")){
		                        $(".pages").remove();
		                    }
							if(data.data.list.length == 0){
								layer.alert("暂时没有订单数据!");
								$(".page_num").html(0);
								for(var i = 0; i < $(".pro_next").length; i++){
									$(".pro_next").eq(i).attr("class", "pro_next disabled");
								}
							}else{
								ele.startRow = data.data.startRow;
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
			                            ele.get_data("/api/hotel/getHotelListH5", searchData.searchParams, ele); // ？？？？借口待确认 
			                        })
			                    });
			                    // 判断页面选择框是不是选中状态
			                    if(!Array.indexOf){
								  	Array.prototype.indexOf = function(el){
								 		for (var i=0,n=this.length; i<n; i++){
								 			if (this[i] === el){
								  				return i;
								 			}
								 		}
								 		return -1;
								   	} 
								}
								setTimeout(function(){
									$("input[type='checkbox']").prop("checked", false);
									for(var i = 0; i < ele.list_data.length; i++){
				                    	if(ele.hotelIds.indexOf(ele.list_data[i].id.toString()) >= 0){
				                    		$(".checks").eq(i).prop("checked", true);
				                    	}
				                    }
				                    if($(".checks:checked").length == ele.list_data.length){
				                    	$("#checked_all").prop("checked", true);
				                    }
								}, 100);
			                    
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
					return ""
				}				
			}
		}
	})