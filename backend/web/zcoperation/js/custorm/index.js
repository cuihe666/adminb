$(function(){
	// 用于读取和存储localstroage
	window.zc_store = {
		set:function(key,value) {
			if(typeof value ==='string') {
				localStorage.setItem(key, value);
			}else {
				localStorage.setItem(key, JSON.stringify(value));
			}
		},
		get:function(key,json_obj) {
			if(json_obj) {
				return JSON.parse( localStorage.getItem(key) );
			} else {
				return localStorage.getItem(key);
			}
		},
		remove:function(key) {
			localStorage.removeItem(key);
		}
	};
	// 请求网址
	//var http_url = "http://192.168.64.55:9090";
	//var http_url = "http://192.168.64.88:9090";
	//var http_url = "http://139.196.145.18:9090";
	//var http_url = "http://106.14.19.71:9090";
	var http_url = serveUrl();
	//var http_url = "http://106.15.126.75:9090";
	//var http_url = "http://javaapi.tgljweb.com:9090";

	// 拼接的接口参数
	// 首页
	var ind = "/api/operate/operatemanage";
	// 当刚打开页面时默认请求首页的数据
	var dat_first = {
		type: 1
	}
	ajax_post(ind, dat_first)
	zc_store.set("types", "1");
	$(".search select").val(1);
	// 当下拉列表变化时请求数据
	$(".search select").on("change", function(){
		var dat = {
			type: $(this).val()
		}
		if($(this).val() == 1){ // 首页banner
			ajax_post(ind, dat)
		}else if($(this).val() == 2){ // 旅游首页
			ajax_post(ind, dat)
		}else if($(this).val() == 3){ // 民宿首页
			ajax_post(ind, dat)
		}else if($(this).val() == 4){ // 城市列表
			ajax_post(ind, dat);
		}
		zc_store.set("types", dat.type);
	})

	// // 发布弹窗确定按钮点击触发事件
	$("#savebut").on("click", function(){
		var dat = parseInt($(this).parent().find("input").val());
		var publish_dat = {
			"id": dat,
			"ispublish": 1
		};
		var publish_url = ""
		if(dat < 12){
			publish_url = "/api/operate/release";
		}else if(dat >= 12 && dat < 15){
			publish_url = "/api/operate/releaseTravel";
			publish_dat = {
				itemId: dat
			};
		}
		$.ajax({
			type: "POST",
			contentType:"application/json;charset=UTF-8",
			url:http_url + publish_url,
			data: JSON.stringify(publish_dat),
			success: function(res){
				if(res.code == 0){
					layer.alert("发布成功!");
				}else{
					layer.alert("发布失败，请重新尝试!");
				}
			}
		})
	})

	// 封装的函数
	function ajax_post(url_add, dat){
		$.ajax({
			type: "POST",
			contentType:"application/json;charset=UTF-8",
			url:http_url + url_add,
			data: JSON.stringify(dat),
			beforeSend: function(){
				$(".wrap1").css("display", "block");
			},
			success: function(res){
				$(".wrap1").css("display", "none");
				if(res.code == 0){
					//console.log(res);
					$("table tbody").remove();
					for(var i = 0; i < res.data.length; i++){
						var str = "<tr class='trs'>" +
							"<td>" + res.data[i].itemTypeName + "</td>" +
							"<td>" + res.data[i].described + "</td>" +
							"<td>" +
							"<a class='edit' href=''>编辑</a>" +
							"<a class='clo' data-toggle='modal'>发布</a>" +
							"<input type='hidden' value='" + res.data[i].id + "' />" +
								// "<input type='hidden' value='" + res.pageInfo.list[i].createBy + "' />" +
							"</td>" +
							"</tr>";
						if(res.data[i].id != "7" && res.data[i].id != "8"){
							$("table").append(str);
							var jump_id = res.data[i].id;
							if(jump_id == 1 || jump_id == 2 || jump_id == 3){
								$("table").find(".edit").last().attr("href", "banner_edit?id=" + jump_id);
							}else if(jump_id == 4){
								$("table").find(".edit").last().attr("href", "odds_edit?id=" + jump_id);
							}else if(jump_id == 5 || jump_id == 6 || jump_id == 7){
								$("table").find(".edit").last().attr("href", "recommend_edit?id=" + jump_id);
							}else if(jump_id == 8){
								$("table").find(".edit").last().attr("href", "star_edit?id=" + jump_id);
							}else if(jump_id == 9){
								$("table").find(".edit").last().attr("href", "hot_edit?id=" + jump_id);
							}else if(jump_id == 10){
								$("table").find(".edit").last().attr("href", "traveltheme_edit?id=" + jump_id);
							}else if(jump_id == 11){
								$("table").find(".edit").last().attr("href", "person_edit?id=" + jump_id);
							}else if(jump_id == 12 || jump_id == 13 || jump_id == 14){ // 旅行特惠、自定义专题活动、旅行城市列表 jump_id???
								$("table").find(".edit").last().attr("href", "travel_edit?id=" + jump_id);
							}
						}
						// 点击去发布
						$(".clo").each(function(index){
							$(".clo").eq(index).on("click", function(){
								$("#myModal").find("input").val($(this).parent().find("input").val());
								$("#myModal").modal("show");
							})
						})
					}
				}else{
					layer.alert("数据请求失败，请刷新重试!");
				}
			},
			error: function(){
				layer.alert("数据请求失败，请刷新页面重试!");
			}
		})
	}

})