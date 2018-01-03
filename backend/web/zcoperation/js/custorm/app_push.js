$(function(){
	var uid = "2443040";
	//var uid = window.location.href.split("uid=")[1];
	//console.log(uid);
	// 新增链接拼接ID
	$(".add_new a").attr("href", $(".add_new a").attr("href") + "&uid=" + adminId);
	// 请求的网址
	//var http_url = "http://106.14.19.71:9090";
	var http_url = serveUrl();
	//var http_url = "http://106.15.126.75:9090";
	//var http_url = "http://139.196.145.18:9090";
	//var http_url = "http://192.168.64.88:9090";
	//var http_url = "http://192.168.64.55:9090";
	//var http_url = "http://javaapi.tgljweb.com:9090";
	// 拼接的参数
	var can = "/api/apppush/searchapppush";
	// 启用的参数
	var qi = "/api/apppush/startpushbyid";
	// 禁用的参数
	var jin = "/api/apppush/forbiddenpushbyid";
	var first_list = {
			"key": "",
			"pageNum": 1,
			"pageSize": 30
		}
	// 刚登陆页面请求数据，渲染页面	
	ajax_get(can, first_list);

	// 每页条数展示变化时，发送请求，重新渲染页面
	$(".ape_page select").on("change", function(){
		$("#pagination").html("");
		var th = $(this).val();
		var num_change = {
			"key": $(".key_words").val(),
			"pageNum": 1,
			"pageSize": th
		}
		// var st = $(".fen").html();
		// $(".fen").html("");
		// $(".fen").html(st)
		ajax_get(can, num_change);
	})
	// 点击禁用按钮执行的操作
	$("#savebut").on("click", function(){
		var id = $(this).parent().find("input").eq(0).val();
		var jin_id = {
			id: id
		}
		var a = $(this).parent().find("input").eq(2).val();
		$.ajax({
			type: "POST",
			contentType:"application/json;charset=UTF-8",
			url:http_url + jin,
			data: JSON.stringify(jin_id),
			success: function(res){
				if(res.code == 0){
					$(".clo").eq(a).css("display", "none");
					$(".open").eq(a).css("display", "inline-block");
					$(".stat").eq(a).html("已禁用");
				}else{
					layer.alert("禁用失败");
				}
			}
		})
	})
	
	// 点击启用按钮执行的操作
	$("#savebut1").on("click", function(){
		var id = $(this).parent().find("input").eq(0).val();
		var qi_id = {
			id: id
		}
		var a = $(this).parent().find("input").eq(2).val();
		$.ajax({
			type: "POST",
			contentType:"application/json;charset=UTF-8",
			url:http_url + qi,
			data: JSON.stringify(qi_id),
			success: function(res){
				if(res.code == 0){
					$(".clo").eq(a).css("display", "inline-block");
					$(".open").eq(a).css("display", "none");
					$(".stat").eq(a).html("已启用");
				}else{
					layer.alert(res.msg);
				}
			}
		})
	})
	// 搜索关键字
	$(".words_btn").on("click", function(){
		$("#pagination").html("");
		var th = $.trim($(".key_words").val());
		// return false;
		if(th == ""){
			layer.alert("请填写关键字!");
			return false;
		}
		var page_n = 1;
		$(".ui-pagination-container").find("a").each(function(index){
			if($(".ui-pagination-container").find("a").eq(index).attr("class") == "active"){
				page_n = index;
			} 
		})
		var pageNum = $(".ape_page select").val();
		var num_change = {
			"key": th,
			"pageNum": page_n,
			"pageSize": pageNum
		}
		ajax_get(can, num_change);
	})

	// 将时间戳转化成日期格式
	function change_time1(dat){
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
		var e = year + "-" + (month + 1) + "-" + da + "  " + ho + ":" + min + ":" + sec;
		return e;
	}
	function change_time(dat){
		var year = new Date(dat).getFullYear();
		var month = new Date(dat).getMonth();
		var da = new Date(dat).getDate();
		var ho = new Date(dat).getHours();
		var e = year + "-" + (month + 1) + "-" + da + "  " + ho + ":00";
		return e;
	}
	// 封装函数，判定是否推送
	function is_push(n){
		if(n == 0){
			n = "未推送";
		}else if(n == 1){
			n = "已过期";
		}else if(n == 2){
			n = "已禁用";
		}else if(n == 3){
			n = "已启用"
		}
		return n;
	}


	// 数据请求封装函数
	function ajax_get(url_add, dat){

		$.ajax({
			type: "POST",
			contentType:"application/json;charset=UTF-8",
			url:http_url + url_add,
			data: JSON.stringify(dat),
			beforeSend: function(){
				$(".load").css("display", "block");
			},
			success: function(res){
				$(".load").css("display", "none");
				$("#pagination").html("");
				var errMsg = '';
				try{
					//throw new Error('12312');
					if( res.code!=0 ){
						errMsg = res.msg;
						throw new Error('res_error');
					}

					$("table tbody").remove();
					var page_num = 0
					if(res.pageInfo.total == 0){
						page_num = 0;
					}else if(parseInt(res.pageInfo.total) <= parseInt($(".ape_page select").val())){
						page_num = 1;
					}else{
						page_num = parseInt(res.pageInfo.total / parseInt($(".ape_page select").val())) + 1;
					}
					// 根据数据渲染列表
					for(var i = 0; i < res.pageInfo.list.length; i++){
						var tr = "<tr class='trs'>" + 
								 "<td>" + (i + 1 + (res.pageInfo.pageNum - 1) * res.pageInfo.pageSize) + "</td>" + 
								 "<td>" + change_time1(parseInt(res.pageInfo.list[i].createTime)) + "</td>" +
								 "<td>" + res.pageInfo.list[i].pushTitle + "</td>" + 
								 "<td>" + res.pageInfo.list[i].pushContent + "</td>" + 
								 "<td>" + change_time1(parseInt(res.pageInfo.list[i].pushTime)) + "</td>" +
								 "<td class='stat'>" + is_push(res.pageInfo.list[i].pushState) + "</td>" + 
								 "<td>" + res.pageInfo.list[i].name + "</td>" +
								 "<td>" + 
								 "<a class='edit'>编辑</a>" +
								 "<a class='open' data-toggle='modal'>启用</a>" +
								 "<a class='clo' data-toggle='modal'>禁用</a>" +
								 "<input type='hidden' value='" + res.pageInfo.list[i].id + "' />" +
								 "<input type='hidden' value='" + res.pageInfo.list[i].createBy + "' />" +
								 "</td>" + 
								 "</tr>";
						$("table").append(tr);
						$("#pagination").html("");
						if(is_push(res.pageInfo.list[i].pushState) == "已禁用"){
							$(".open").last().css("display", "inline-block");
							$(".clo").last().css("display", "none");
						}else{
							$(".open").last().css("display", "none");
							$(".clo").last().css("display", "inline-block");
						}
					}
					$(".edit").each(function(index){
						$(".edit").eq(index).on("click", function(){
							window.location.href = $(".edit_a").val().split("uid=")[0] + "uid=" + adminId;
						})
					})
					// 初始化页数
					$(".page_num").html("共" + page_num + "页")
					// 分页器初始化
					$("#pagination").pagination({
						currentPage: res.pageInfo.pageNum,
						maxentries: res.pageInfo.total,
						items_per_page:  parseInt($(".ape_page select").val()),
						num_display_entries: parseInt($(".ape_page select").val()),
						totalPage: page_num,
						isShow: true,
						count: 10,
						homePageText: "首页",
						endPageText: "尾页",
						prevPageText: "上一页",
						nextPageText: "下一页",
						callback: function(current) {
							$("#current3").text(current)
						}
					});	
					// 点击分页器点击触发，请求数据渲染页面
					$(".ui-pagination-container").find("a").each(function(index){
						$(".ui-pagination-container a").eq(index).on("click", function(){
							// $("#pagination").html("");
							var dat = {
								"key": "",
								"pageNum": $(this).attr("data-current"),
								"pageSize": $(".ape_page select").val()
							}
							ajax_get(can, dat);
						})
					})
					// 点击编辑触发效果
					$(".edit").each(function(index){
						$(".edit").eq(index).on("click", function(){
							var _id = $(this).parent().find("input").first().val();
							var create_id = $(this).parent().find("input").last().val()
							var dat = {
								id: _id,
								create_id: create_id
							}
							get_or_push("edit_id", dat);
						})
					})	
					$(".open").each(function(index){
						$(".open").eq(index).on("click", function(){
							$("#myModal1").find("input").eq(0).val($(this).parent().find("input").eq(0).val())
							$("#myModal1").find("input").eq(1).val($(this).parent().find("input").eq(1).val())
							$("#myModal1").find("input").eq(2).val(index)
							$("#myModal1").modal("show");
						})
					})
					$(".clo").each(function(index){
						$(".clo").eq(index).on("click", function(){
							$("#myModal").find("input").eq(0).val($(this).parent().find("input").eq(0).val())
							$("#myModal").find("input").eq(1).val($(this).parent().find("input").eq(1).val())
							$("#myModal").find("input").eq(2).val(index);
							$("#myModal").modal("show");
						})
					})
					
				}catch(e){

					switch(e.message){
						case 'res_error':
						console.log('操作失败');
						errMsg =  errMsg || 'try_errMsg_empty';
						console.log('errMsg:'+errMsg);
						break;
						default:
						console.log('操作失败~~');
					}
				}
			},
			error:function(){
				layer.alert('数据请求失败，请刷新重试!');
			}
		})
	}


	// 用足本地存储读取或者存储
	function get_or_push(nam, dat){
		if(dat){
			if(typeof dat == "String"){
				localStorage.setItem(nam, dat);
			}else{
				dat = JSON.stringify(dat);
				localStorage.setItem(nam, dat);
			}
		}else{
			var data = localStorage.getItem(nam);
			return data;
		}
	}

})