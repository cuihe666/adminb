$(function(){
	var types = localStorage.getItem("types") || "1";
	// 七牛云的token值
	var token = "/api/qiniu/getqiniutoken";
	//var http_url = "http://192.168.64.55:9090";
	//var http_url = "http://192.168.64.88:9090";
	//var http_url = "http://139.196.145.18:9090";
	var http_url = serveUrl();
	//var http_url = "http://106.14.19.71:9090";
	//var http_url = "http://106.15.126.75:9090";
	//var http_url = "http://javaapi.tgljweb.com:9090";
	// 刚进入页面时请求的接口
	var put_id = "/api/operate/editBannerById";
	// 添加数据的接口
	var add_id = "/api/operate/addOperate";
	// 编辑数据提交的接口
	var edit_id = "/api/operate/updateBannerDetail";
	//请求的参数
	var _id = window.location.href.split("id=")[1];
	$(".tite").html("首页今日特惠");
	var id_type = {
		id: _id
	}
	// 请求数据
	ajax_post(put_id, id_type);
	// 当新增或者编辑改变跳转类型的值进行操作
	$("#jump_type").on("change", function(){
		$(".linkurl").val("");
		$('.pic_url').val("");
		$("#d422").val("");
		$("#d4312").val("");
		$(".price").val("")
		if($(this).val() == 0 || $(this).val() == 12 || $(this).val() == 15){
			$(".travel_type").css("display", "none");
		}else if($(this).val() == 18){
			$(".travel_type").css("display", "inline-block");
			$(".travel_type").val("1");
		}
	})
	// 点击禁用

	$("#savebut1").on("click", function(){
		var _id = $(this).parent().find("input").eq(0).val();
		var ind = 0;
		for(var i = 0; i < $("table tbody tr").length; i++){
			if(_id == $("table tbody tr").eq(i).find("td").last().find("input").eq(0).val()){
				ind = i;
			}
		}
		var dat = {
			id: _id,
			enabled: 0
		}
		$.ajax({
			type: "POST",
			contentType:"application/json;charset=UTF-8",
			url:http_url + "/api/operate/disablebyid",
			data: JSON.stringify(dat),
			success: function(res){
				if(res.msg == "success"){
					$(".open").eq(ind).css("display", "none");
					$(".clo").eq(ind).css("display", "inline-block");
					$(".able").eq(ind).css("display", "inline-block");
					$(".unable").eq(ind).css("display", "none");
				}else{
					layer.alert("禁用失效!");
				}
			}
		})
	})
	// 点击使用
	$("#savebut2").on("click", function(){
		var _id = $(this).parent().find("input").eq(0).val();
		var ind = 0;
		for(var i = 0; i < $("table tbody tr").length; i++){
			if(_id == $("table tbody tr").eq(i).find("td").last().find("input").eq(0).val()){
				ind = i;
			}
		}
		var dat = {
			id: _id,
			enabled: 1
		}
		$.ajax({
			type: "POST",
			contentType:"application/json;charset=UTF-8",
			url:http_url + "/api/operate/disablebyid",
			data: JSON.stringify(dat),
			success: function(res){
				if(res.msg == "success"){
					$(".clo").eq(ind).css("display", "none");
					$(".open").eq(ind).css("display", "inline-block");
					$(".unable").eq(ind).css("display", "inline-block");
					$(".able").eq(ind).css("display", "none");
				}else{
					layer.alert("使用失效!");
				}
			}
		})
	})
	// 点击删除
	$("#savebut3").on("click", function(){
		var _id = $(this).parent().find("input").eq(0).val();
		var ind = 0;
		for(var i = 0; i < $("table tbody tr").length; i++){
			if(_id == $("table tbody tr").eq(i).find("td").last().find("input").eq(0).val()){
				ind = i;
			}
		}
		var dat = {
			id: _id
		}
		$.ajax({
			type: "POST",
			contentType:"application/json;charset=UTF-8",
			url:http_url + "/api/operate/deleteByid",
			data: JSON.stringify(dat),
			success: function(res){
				if(res.code == "0"){
					$("table tbody tr").eq(ind).remove();
					for(var i = 0; i < $("table tbody tr").length; i++){
						$("table tbody tr").eq(i).find("td").eq(0).html(i + 1);
					}
				}else{
					layer.alert("删除失败!");
				}
			}
		})
	})

	// 点击新增按钮
	$(".add_new a").on("click", function(){
		$("#myModal .modal-header").html("新增");
		$("#myModal .modal-footer").find("input").eq(0).val("0");
	})
	// 点击新增,初始化样式，清空表单内数据
	$(".add_new a").on("click", function(){
		$("#myModal #jump_type").val(0);
		$("#myModal .travel_type").val(1);
		$("#myModal .travel_type").css("display", "none");
		$(".linkurl").val("");
		$(".pic_url").val("");
		$("#d422").val("");
		$("#d4312").val("");
		$(".price").val("")
		$("#myModal").modal("show");
	})
	// 查询价格
	//var d = {
	//	"houseId": "1612772",
	//	"startTime": "1485187100",
	//	"endTime": "1485188100"
	//}
	//$.ajax({
	//	type: "POST",
	//	contentType:"application/json;charset=UTF-8",
	//	url: http_url + "/api/operate/selectPriceByDate",
	//	data: JSON.stringify(d),
	//	success: function(res){
	//		console.log(res);
	//	}
	//})

	// 新增或者编辑弹窗点击确认
	$("#savebut").on("click", function(){
		var linkType = $("#myModal #jump_type").val();
		var click_position = $(this).parent().find("input").eq(0).val();
		// 添加判断，如果是新增项的话，点击确认弹框不消失，如果是编辑的话就消失
		//if(click_position == 0){
		//	$("#savebut").removeAttr("data-dismiss");
		//}else{
		//	$("#savebut").attr("data-dismiss", "modal");
		//}
		if(linkType == 0){
			layer.alert("请选择产品分类!");
			return false;
		}else{
			var linkUrl = "";
			var travelType = "";
			var productId = $(".linkurl").val();
			if(productId == ""){
				layer.alert("请填写产品ID!");
				return false;
			}
			if(linkType == 18){
				travelType = $(".travel_type").val();
			}
		}
		var pic = $(".pic_url").val();
		if(pic == ""){
			layer.alert("请添加图片!");
			return false;
		}else{
			pic = pic.split("http://img.tgljweb.com/")[1];
		}
		var startTime = $("#d422").val().split("-");
		var endTime = $("#d4312").val().split("-");
		if(startTime == "" || endTime == ""){
			layer.alert("请选择获取价格!");
			return false;
		}else{
			startTime = new Date(startTime[0] + "/" + startTime[1] + "/" + startTime[2]).getTime();
			endTime = new Date(endTime[0] + "/" + endTime[1] + "/" + endTime[2]).getTime();
		}
		var price = $.trim($(".price").val());
		if(price == ""){
			layer.alert("请填写原价!");
			return false;
		}
		var dat = {
			productId: productId,
			linkType: linkType,
			pic: pic,
			originalPrice: price,
			linkUrl: linkUrl,
			travelType: travelType,
			startTime: startTime,
			endTime: endTime,
			createBy: adminId
		}
		var type = 0;
		if(linkType == 12){
			type = 0;
		}else if(linkType == 15){
			type = 1;
		}else if(linkType == 18){
			if(travelType == 1){
				type = 2;
			}else if(travelType == 2){
				type = 3;
			}
			//else if(travelType == 4){
			//	type = 4;
			//}else if(travelType == 3){
			//	type = 5;
			//}
		}
		var get_price = {
			"type": type,
			"houseId": productId,
			"startTime": startTime,
			"endTime": endTime
		}
		var edit_id = $(this).parent().find("input").eq(1).val();
		$.ajax({
			type: "POST",
			contentType:"application/json;charset=UTF-8",
			url: http_url + "/api/operate/selectPriceByDate",
			data: JSON.stringify(get_price),
			success: function(res){
				if(res.code == 0){
					var price = res.data.price;
					dat.price = price;
					if(click_position == 0){
						// 添加
						dat.itemId = _id;
						dat.type = types;
						dat.types = type;
						$.ajax({
							type: "POST",
							contentType:"application/json;charset=UTF-8",
							url: http_url + "/api/operate/addOperateHotProduct",
							data: JSON.stringify(dat),
							success: function(res){
								if(res.code == "0"){
									// window.location.href = "index.html";
									ajax_post(put_id, id_type);
									$("#myModal").modal("hide");
								}else{
									if(res.msg == ""){
										layer.alert("新增失败，请重试!");
									}else{
										layer.alert(res.msg);
									}
								}
							}
						})
					}else{
						// 编辑
						dat.id = edit_id;
						dat.types = type;
						$.ajax({
							type: "POST",
							contentType:"application/json;charset=UTF-8",
							url: http_url + "/api/operate/updateCheap",
							data: JSON.stringify(dat),
							success: function(res){
								if(res.code == "0"){
									// window.location.href = "index.html";
									ajax_post(put_id, id_type);
									$("#myModal").modal("hide");
								}else{
									if(res.msg == ""){
										layer.alert("编辑失败，请重试!");
									}else{
										layer.alert(res.msg);
									}
								}
							}
						})
					}
				}else{
					if(res.msg == ""){
						layer.alert("无此房源信息!");
					}else{
						layer.alert(res.msg);
					}
				}
			}
		})
	})
	//*******************************图片上传**********************************************
	var uploader = Qiniu.uploader({
        runtimes: 'html5,flash,html4',      // 上传模式,依次退化
        browse_button: 'browse',         // 上传选择的点选按钮，**必需**
        filters: {
            mime_types: [ //只允许上传图片文件和rar压缩文件
                {title: "图片文件", extensions: "jpg,JPG,JPEG,jpeg,PNG,png"}
            ],
            max_file_size: '3072kb', //最大只能上传100kb的文件
        },
        uptoken_url: http_url + token, // uptoken 是上传凭证，由其他程序生成
        get_new_uptoken: false,             // 设置上传文件的时候是否每次都重新获取新的 uptoken
        domain: 'http://img.tgljweb.com/',     // bucket 域名，下载资源时用到，**必需**
        container: 'container',             // 上传区域 DOM ID，默认是 browser_button 的父元素，
        max_file_size: '200mb',             // 最大文件体积限制
        flash_swf_url: 'http://cdn.staticfile.org/Plupload/2.1.1/Moxie.swf',  //引入 flash,相对路径
        max_retries: 50,                     // 上传失败最大重试次数
        dragdrop: true,                     // 开启可拖曳上传
        drop_element: 'container',          // 拖曳上传区域元素的 ID，拖曳文件或文件夹后可触发上传
        chunk_size: '4mb',                  // 分块上传时，每块的体积
        auto_start: true,                   // 选择文件后自动上传，若关闭需要自己绑定事件触发上传,
        init: {
            'FilesAdded': function (up, files) {
                for (var i = 0, len = files.length; i < len; i++) {
                    var file_name = files[i].name; //文件名
                    !function (i) {
                        // previewImage(files[i], function (imgsrc) {
                        // })
                    }(i);
                }
            },
            'BeforeUpload': function (up, file) {
                // 每个文件上传前,处理相关的事情
            },
            'UploadProgress': function (up, file) {
                //                console.log(file);
                console.log(file.percent);

                $('.progress').css('width', file.percent + '%');//控制进度条
                // 每个文件上传时,处理相关的事情
            },
            'FileUploaded': function (up, file, info) {
                // 每个文件上传成功后,处理相关的事情
                // 其中 info 是文件上传成功后，服务端返回的json，形式如
                // {
                //    "hash": "Fh8xVqod2MQ1mocfI4S4KpRL6D98",
                //    "key": "gogopher.jpg"
                //  }
                // 参考http://developer.qiniu.com/docs/v6/api/overview/up/response/simple-response.html
                var domain = up.getOption('domain');
                var res = $.parseJSON(info);
                var sourceLink = domain + res.key; //  获取上传成功后的文件的Url
                // console.log(sourceLink)
                $(".pic_url").val(sourceLink);
                // $('.card_pic' + index).val(sourceLink);
                //                                    alert('success')
            },
            'Error': function (up, err, errTip) {
                console.log(errTip);
                //上传出错时,处理相关的事情
            },
            'UploadComplete': function () {
                //队列文件处理完毕后,处理相关的事情
            },
            'Key': function (up, file) {
                // 若想在前端对每个文件的key进行个性化处理，可以配置该函数
                // 该配置必须要在unique_names: false，save_key: false时才生效
                var ext = Qiniu.getFileExtension(file.name);

                var key = Date.parse(new Date()) + '.'+ext;
                localStorage.key1 = 'http://img.tgljweb.com/' + key;
                // do something with key here
                return key
            },

        }
    });
	// 页面初始化请求数据
	function ajax_post(url, dat){
		$.ajax({
			type: "POST",
			contentType:"application/json;charset=UTF-8",
			url:http_url + url,
			data: JSON.stringify(dat),
			beforeSend: function(){
				$(".wrap1").css("display", "block");
			},
			success: function(res){
				console.log(res)
				$(".wrap1").css("display", "none");
				try{
					 $("table tbody").remove();
					for(var i = 0; i < res.data.length; i++){
						//var dte = new Date(res.data[i].updateTime).getFullYear() + "-" + (new Date(res.data[i].updateTime).getMonth() + 1) + "-" + new Date(res.data[i].updateTime).getDate() + "  " + new Date(res.data[i].updateTime).getHours() + ":00:00";
						var str = "<tr>" +
								  "<td>" + (i + 1) + "</td>" + 
								  "<td>" + res.data[i].productId + "</td>" + 
								  "<td>" + res.data[i].price + "</td>" +
								  "<td><img src='http://img.tgljweb.com/" + res.data[i].pic + "' /></td>" +
								  "<td><span class='open'>已使用</span><span class='clo'>禁用</span></td>" +
								  "<td>" + change_time(res.data[i].updateTime) + "</td>" +
								  "<td>" + res.data[i].userName + "</td>" +
								  "<td>" + 
								  "<a class='able' data-toggle='modal'>使用</a>" +
								  "<a class='unable' data-toggle='modal'>禁用</a>" +
								  "<a class='edit' data-toggle='modal'>编辑</a>" +
								  "<a class='dele' data-toggle='modal'>删除</a>" +
								  "<input type='hidden' value='" + res.data[i].id + "'/>" +
								  "</td>" +
								  "</tr>"

						$("table").append(str);
						if(res.data[i].enabled == 0){
							$("table .able").eq(i).css("display", "inline-block");
							$("table .unable").eq(i).css("display", "none");
							$("table .open").eq(i).css("display", "none");
							$("table .clo").eq(i).css("display", "inline-block");							
						}else{
							$("table .able").eq(i).css("display", "none");
							$("table .unable").eq(i).css("display", "inline-block");
							$("table .clo").eq(i).css("display", "none");
							$("table .open").eq(i).css("display", "inline-block");
						}
					}
					$(".edit").each(function(index){
						$(".edit").eq(index).on("click", function(){
							$("#myModal .modal-header").html("编辑");
							$("#myModal .modal-footer").find("input").eq(0).val("1");
							$("#myModal .modal-footer").find("input").eq(1).val($(this).parent().find("input").val());
							$("#myModal #jump_type").val(0);
							$("#myModal .travel_type").val(1);
							$("#myModal .travel_type").css("display", "none");
							$(".linkurl").val("");
							$(".pic_url").val("");
							$("#d422").val("");
							$("#d4312").val("");
							$(".price").val("");
							$("#jump_type").val(res.data[index].linkType);
							if(res.data[index].linkType == 18){
								$(".travel_type").css("display", "inline-block");
								$(".travel_type").val(res.data[index].travelType);
							}
							$(".linkurl").val(res.data[index].productId);
							$(".pic_url").val("http://img.tgljweb.com/" + res.data[index].pic);
							var startTime = new Date(res.data[index].startTime).getFullYear() + "-" + (new Date(res.data[index].startTime).getMonth() + 1) + "-" + new Date(res.data[index].startTime).getDate();
							var endTime = new Date(res.data[index].endTime).getFullYear() + "-" + (new Date(res.data[index].endTime).getMonth() + 1) + "-" + new Date(res.data[index].endTime).getDate();
							$("#d422").val(startTime);
							$("#d4312").val(endTime);
							$(".price").val(res.data[index].originalPrice);
							$("#myModal").modal("show");
						})
					})
					$(".unable").each(function(index){
						$(".unable").eq(index).on("click", function(){
							$("#myModal1").find("input").eq(0).val($(this).parent().find("input").val());
							$("#myModal1").modal("show");
						})
					})
					$(".able").each(function(index){
						$(".able").eq(index).on("click", function(){
							$("#myModal2").find("input").eq(0).val($(this).parent().find("input").val());
							$("#myModal2").modal("show");
						})
					})
					$(".dele").each(function(index){
						$(".dele").eq(index).on("click", function(){
							$("#myModal3").find("input").eq(0).val($(this).parent().find("input").val());
							$("#myModal3").modal("show");
						})
					})
				}catch(e){
					layer.alert("数据请求失败，请刷新页面或稍后重试!");
				}
			}
		})
	}
	// 将时间戳转化为日期加上时分秒格式
	function change_time(dat){
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
		var e = year + "-" + (month + 1) + "-" + da + "-" + ho + ":" + min + ":" + sec;
		return e;
	}
	// 新增或者编辑时发送请求
	//function add_edit(url, dat){
	//	$.ajax({
	//		type: "POST",
	//		contentType:"application/json;charset=UTF-8",
	//		url:http_url + url,
	//		data: JSON.stringify(dat),
	//		success: function(res){
	//			console.log(res);
	//			if(res.msg == "success"){
    //
	//			}
	//		}
	//	})
    //
	//}
})