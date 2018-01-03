$(function(){
	var types = localStorage.getItem("types");
	// 七牛云的token值
	var token = "/api/qiniu/getqiniutoken";
	// 公共网址
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
	var id_type = {
		id: _id
	};
	if(_id == 1){
		$(".tite").html("首页Banner图");
	}else if(_id == 2){
		$(".tite").html("民宿首页banner图");
	}else if(_id == 3){
		$(".tite").html("旅游首页banner图");
	}else{
		$(".tite").html("运营位管理");
	}
	// 解决banner民宿跳转类型问题
	// 民宿
	if(_id == 2){
		var timer1 = setInterval(function(){
			for(var i=2;i<$("#jump_type option").length;i++){
				if($("#jump_type option").eq(i).val() != "12" && $("#jump_type option").eq(i).val() != "20" && $("#jump_type option").eq(i).val() != "2"){
					$("#jump_type option").eq(i).remove();
				}
			}
		},200);
	}
	// 旅游首页banner
	if(_id == 3){
		var timer2 = setInterval(function(){
			for(var i = 2; i < $("#jump_type option").length; i++){
				if($("#jump_type option").eq(i).val() != "18" && $("#jump_type option").eq(i).val() != "20" && $("#jump_type option").eq(i).val() != "16"){
					$("#jump_type option").eq(i).remove();
				}
			}
		},200);
		$(".travel_type").append("<option value='4'>游记攻略</option><option value='3'>印象随笔</option>")
	}
	// 请求数据
	ajax_post(put_id, id_type);
	// 默认提取国家的数据
	$.ajax({
		type: "POST",
		contentType:"application/json;charset=UTF-8",
		url: http_url + "/api/dt/getHotCountries",
		success: function(res){
			if(res.code == 0){
				for(var i = 0; i < res.data.length; i++){
					$(".country").html($(".country").html() + "<option value='" + res.data[i].cityCode + "' >" + res.data[i]["cityName"] + "</option>")
				}
			}else{
				layer.alert("城市信息拉取失败，请刷新页面!");
			}

		}
	})
	if(_id == 2){
		setInterval(function(){
			for(var i = 2;i < $("#jump_type option").length; i++){
				if($("#jump_type option").eq(i).val() != "12" && $("#jump_type option").eq(i).val() != "20"){
					$("#jump_type option").eq(i).remove();
				}
			}
		},200);
	}

	// 当新增或者编辑改变跳转类型的值进行操作
	$("#jump_type").on("change", function(){
		if($(this).val() == 0 || $(this).val() == 14 || $(this).val() == 19){
			$(".travel_type").css("display", "none");
			$(".country").css("display", "none");
			$(".sheng").css("display", "none");
			$(".shi").css("display", "none");
			$(".jump_type input").css("display", "none");
			$(".linkurl").val("");
			$(".tishi").css("display", "none");
		}else if($(this).val() == 1 || $(this).val() == 20 || $(this).val() == 21){
			$(".travel_type").css("display", "none");
			$(".country").css("display", "none");
			$(".sheng").css("display", "none");
			$(".shi").css("display", "none");
			$(".jump_type input").css("display", "block");
			$(".jump_type input").attr("placeholder", "请填写链接地址");
			$(".tishi").css("display", "none");
			$(".linkurl").val("");
		}else if($(this).val() == 12 || $(this).val() == 15){
			$(".travel_type").css("display", "none");
			$(".country").css("display", "none");
			$(".sheng").css("display", "none");
			$(".shi").css("display", "none");
			$(".jump_type input").css("display", "block");
			$(".jump_type input").attr("placeholder", "请填写产品ID");
			$(".tishi").css("display", "none");
			$(".linkurl").val("");
		}else if($(this).val() == 18){
			$(".travel_type").css("display", "inline-block");
			$(".country").css("display", "none");
			$(".sheng").css("display", "none");
			$(".shi").css("display", "none");
			$(".jump_type input").css("display", "block");
			$(".jump_type input").attr("placeholder", "请填写产品ID");
			$(".tishi").css("display", "none");
			$(".linkurl").val("");
		}else if($(this).val() == 2 || $(this).val() == 17 || $(this).val() == 16){
			if($(this).val() == 16){
				$(".travel_type").css("display", "inline-block");
			}else{
				$(".travel_type").css("display", "none");
			}
			$(".linkurl").val("");
			$(".tishi").css("display", "none");
			$(".country").css("display", "inline-block");
			$(".sheng").css("display", "inline-block" +
				"");
			$(".shi").css("display", "inline-block");
			$(".country").val("");
			$(".sheng").html("<option value=''>省</option>");
			$(".shi").html("<option value=''>市</option>");
			$(".jump_type input").css("display", "none");
			// 城市查询
					$(".country").off("change");
					$(".country").on("change", function(){
						if($(this).val() != ""){
							if($(this).val() == "10001"){
								$(".sheng").html("<option value=''>省</option>")
								$(".shi").html("<option value=''>市</option>")
								$(".sheng").css("display", "inline-block");
								$(".shi").css("display", "inline-block");
								var country_code = $(this).val();
								var country_dat = {
									parentCode: country_code
								}
								$.ajax({
									type: "POST",
									contentType:"application/json;charset=UTF-8",
									url: http_url + "/api/dt/getCityList",
									data: JSON.stringify(country_dat),
									success: function(res){
										if(res.code == 0){
											for(var i = 0; i < res.data.length; i++){
												$(".sheng").html($(".sheng").html() + "<option value='" + res.data[i].cityCode + "' >" + res.data[i]["cityName"] + "</option>")
											}
											$(".sheng").off("change");
											$(".sheng").on("change", function(){
												var sheng_code = $(this).val()
												$(".shi").html("<option value=''>市</option>");
												if(sheng_code != ""){
													var dat = {
														parentCode: sheng_code
													}
													$.ajax({
														type: "POST",
														contentType:"application/json;charset=UTF-8",
														url: http_url + "/api/dt/getCityList",
														data: JSON.stringify(dat),
														success: function(res){
															if(res.code == 0){
																for(var i = 0; i < res.data.length; i++){
																	$(".shi").html($(".shi").html() + "<option value='" + res.data[i].cityCode + "' city_name='" + res.data[i].cityName + "'>" + res.data[i]["cityName"] + "</option>")
																}
															}else{
																layer.alert("数据请求失败,请刷新重试!");
															}
														}
													})
												}
											})
										}else{
											layer.alert("数据请求失败,请刷新重试!");
										}
									}
								})
							}else{
								$(".sheng").css("display", "none");
								var sheng_code = $(this).val()
								$(".sheng").html("<option value=''>省</option>")
								$(".shi").html("<option value=''>市</option>");
								if(sheng_code != ""){
									var dat = {
										parentCode: sheng_code
									}
									$.ajax({
										type: "POST",
										contentType:"application/json;charset=UTF-8",
										url: http_url + "/api/dt/getCityList",
										data: JSON.stringify(dat),
										success: function(res){
											if(res.code == 0){
												if(res.data.length == 0){
													layer.alert("该国家暂未开通业务!");
												}
												for(var i = 0; i < res.data.length; i++){
													$(".shi").html($(".shi").html() + "<option value='" + res.data[i].cityCode + "' city_name='" + res.data[i].cityName + "'>" + res.data[i]["cityName"] + "</option>")
												}
											}else{
												layer.alert("数据请求失败,请刷新重试!");
											}
										}
									})
								}
							}
						}else{
							$(".sheng").css("display", "inline-block");
							$(".sheng").html("<option value=''>省</option>");
							$(".shi").html("<option value=''>市</option>");
						}

					})

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
				if(res.code == 0){
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
				if(res.code == 0){
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
		$("#myModal .add_tit").val("");
		$("#myModal .fu_tit").val("");
		$("#myModal #jump_type").val(0);
		$("#myModal .travel_type").val(1);
		$("#myModal .travel_type").css("display", "none");
		$(".linkurl").val("");
		$(".tishi").css("display", "none");
		$(".linkurl").css("display", "none");
		$(".country").css("display", "none");
		$(".sheng").css("display", "none");
		$(".shi").css("display", "none");
		$(".pic_url").val("");
		$(".sort select").val("");
		$("#myModal").modal("show");
	})
	// 新增或者编辑弹窗点击确认
	$("#savebut").on("click", function(){
		var main_tit = $.trim($("#myModal .add_tit").val());
		var subtitle = $.trim($("#myModal .fu_tit").val());
		var click_position = $(this).parent().find("input").eq(0).val();
		if(main_tit == ""){
			layer.alert("请添加标题!");
			return false;
		}
		if(subtitle == ""){
			layer.alert("请添加副标题!");
			return false;
		}
		var linkType = $("#myModal #jump_type").val();
		var pro_id = "";
		if(linkType == 0){
			layer.alert("请选择跳转类型!");
			return false;
		}else if(linkType == 1 || linkType == 12 || linkType == 15 || linkType == 18 || linkType == 14 || linkType == 19 || linkType == 20 || linkType == 21){
			var linkUrl = $(".linkurl").val();
			var country = "";
			var province = "";
			var city = "";
			var cityName = "";
			if($.trim(linkUrl) == ""){
				if(linkType == 1 || linkType == 20 || linkType == 21){
					layer.alert("请填写链接地址!");
					return false;
				}else if(linkType == 12 || linkType == 15 || linkType == 18){
					layer.alert("请填写产品ID!");
					return false;
				}
			}
			if(linkType == 1 || linkType == 20 || linkType == 21){
				pro_id = "";
				if(!IsURL(linkUrl)){
					layer.alert("请填写正确的网址链接!");
					return false;
				}
			}
			if(linkType == 12 || linkType == 15 || linkType == 18){
				pro_id = $(".linkurl").val();
				linkUrl = "";
			}
			if(linkType == 18){
				var travelType = $(".travel_type").val();
			}else{
				var travelType = "";
			}
			if(linkType == 14 || linkType == 19){
				linkUrl = "";
			}
		}else if(linkType == 2 || linkType == 17 || linkType == 16){
			var country = $(".country").val();
			var province = $(".sheng").val();
			var city = $(".shi").val();
			var cityName = "";
			if(country != "10001"){
				province = city;
			}
			for(var i = 0; i < $(".sheng option").length; i++){
				if($(".sheng option").eq(i).val() == province){
					cityName = $(".shi option").eq(i).html();
					break;
				}
			}
			if(country == "10001"){
				if(country =="" || province == "" || city == ""){
					layer.alert("请选择城市!");
					return false;
				}
			}else{
				if(country =="" || city == ""){
					layer.alert("请选择城市!");
					return false;
				}
			}

			var linkUrl = "";
			if(linkType == 16){
				var travelType = $(".travel_type").val();
			}else{
				var travelType = "";
			}
		}
		var pic = $(".pic_url").val();
		if(pic == ""){
			layer.alert("请添加图片!");
			return false;
		}else{
			pic = pic.split("http://img.tgljweb.com/")[1];
		}
		var sort = $(".sort select").val();
		if(sort == ""){
			layer.alert("请选择对应的排序位置!");
			return false;
		}
		if($(this).parent().find("input").eq(0).val() == 0){
			// 添加

			var add_dat = {
				title: main_tit,
				subtitle: subtitle,
				linkType: linkType,
				itemId: _id,
				createBy: adminId,
				country: country,
				province: province,
				city: city,
				linkUrl: linkUrl,
				travelType: travelType,
				sort: sort,
				pic: pic,
				type: types,
				productId: pro_id,
				cityName: cityName
			};
			if(_id == 1){
				if(linkType == 12){
					add_dat.types = 0;
				}else if(linkType == 15){
					add_dat.types = 1;
				}else if(linkType == 18){
					if(travelType == 1){
						add_dat.types = 2;
					}else if(travelType == 2){
						add_dat.types = 3
					}
				}else {
					add_dat.types = "";
				}
			}
			$.ajax({
				type: "POST",
				contentType:"application/json;charset=UTF-8",
				url: http_url + "/api/operate/addOperate",
				data: JSON.stringify(add_dat),
				success: function(res){
					if(res.code == "0"){
						// window.location.href = "index.html";
						$("#myModal").modal("hide");
						ajax_post(put_id, id_type);
					}else{
						if(_id != 1){
							$("#myModal").modal("hide");
						}
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
			var productId = $(this).parent().find("input").eq(1).val();
			var edit_dat = {
				title: main_tit,
				subtitle: subtitle,
				linkType: linkType,
				id: productId,
				productId: pro_id,
				country: country,
				province: province,
				city: city,
				linkUrl: linkUrl,
				travelType: travelType,
				sort: sort,
				pic: pic,
				cityName: cityName,
				createBy: adminId
			};
			if(_id == 1){
				if(linkType == 12){
					edit_dat.types = 0;
				}else if(linkType == 15){
					edit_dat.types = 1;
				}else if(linkType == 18){
					if(travelType == 1){
						edit_dat.types = 2;
					}else if(travelType == 2){
						edit_dat.types = 3
					}
				}else{
					edit_dat.types = "";
				}
			}
			$.ajax({
				type: "POST",
				contentType:"application/json;charset=UTF-8",
				url: http_url + "/api/operate/updateBannerDetail",
				data: JSON.stringify(edit_dat),
				success: function(res){
					if(res.code == "0"){
						// window.location.href = "index.html";
						$("#myModal").modal("hide");
						ajax_post(put_id, id_type);
					}else {
						if(_id != 1){
							$("#myModal").modal("hide");
						}
						if(res.msg == ""){
							layer.alert("编辑失败，请重试!");
						}else{
							layer.alert(res.msg);
						}
					}
				}
			})
		}
	})
	/********************************点击省市的时候判断其上一级有没有选*********************************************************/
	$(".sheng").on("click", function(){
		if($(".country").val() == ""){
			$(".tishi").css("display", "block");
			$(".tishi").html("请先选择国家!");
			return false;
		}else{
			$(".tishi").css("display", "none");
			return true;
		}
	})
	$(".shi").on("click", function(){
		if($(".country").val() == ""){
			$(".tishi").css("display", "block");
			$(".tishi").html("请先选择国家!");
			return false;
		}else if($(".country").val() == "10001"){
			if($('.sheng').val() == ""){
				$(".tishi").css("display", "block");
				$(".tishi").html("请先选择省份!");
				return false;
			}
		}else{
			$(".tishi").css("display", "none");
			return true;
		}

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


    function previewImage(file, callback) {//file为plupload事件监听函数参数中的file对象,callback为预览图片准备完成的回调函数
        if (!file || !/image\//.test(file.type)) return; //确保文件是图片
        if (file.type == 'image/gif') {//gif使用FileReader进行预览,因为mOxie.Image只支持jpg和png
            var fr = new mOxie.FileReader();
            fr.onload = function () {
                callback(fr.result);
                fr.destroy();
                fr = null;
            }
            fr.readAsDataURL(file.getSource());
        } else {
            var preloader = new mOxie.Image();
            preloader.onload = function () {
                preloader.downsize(300, 300);//先压缩一下要预览的图片,宽300，高300
                var imgsrc = preloader.type == 'image/jpeg' ? preloader.getAsDataURL('image/jpeg', 80) : preloader.getAsDataURL(); //得到图片src,实质为一个base64编码的数据
                callback && callback(imgsrc); //callback传入的参数为预览图片的url
                preloader.destroy();
                preloader = null;
            };
            preloader.load(file.getSource());
        }
    }
    /*******************************************************图片上传完成****************************************************************************/

	
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
				$(".wrap1").css("display", "none");

				try{
					$("table tbody").remove();
					if(res.code == 0){
						var arr_sort = ["1", "12", "15", "18", "14", "19", "20", "2", "17", "16", "21"];
						var arr_cont = ["H5", "民宿产品详情", "酒店产品详情", "旅游产品详情", "原生酒店", "原生商城", "专题活动", "民宿列表(城市分)", "酒店列表(城市分)", "旅游列表(城市分)", "第三方H5"];
						for(var i = 0; i < res.data.length; i++){
							var mins = new Date(res.data[i].updateTime).getMinutes();
							if(mins < 10){
								mins = "0" + mins;
							}
							// console.log(arr_sort.indexOf(res.data[i].linkType))
							//var dte = new Date(res.data[i].updateTime).getFullYear() + "-" + (new Date(res.data[i].updateTime).getMonth() + 1) + "-" + new Date(res.data[i].updateTime).getDate() + "  " + new Date(res.data[i].updateTime).getHours() + ":" + mins + ":00";
							var str = "<tr>" +
								"<td>" + (i + 1) + "</td>" +
								"<td>" + res.data[i].title + "</td>" +
								"<td class='type'>" + arr_cont[arr_sort.indexOf(res.data[i].linkType)] + "</td>" +
								"<td><img src='http://img.tgljweb.com/" + res.data[i].pic + "' /></td>" +
								"<td>" + res.data[i].sort + "</td>" +
								"<td><span class='open'>已使用</span><span class='clo'>禁用</span></td>" +
								"<td>" + change_time(res.data[i].updateTime) + "</td>" +
								"<td>" + res.data[i].userName + "</td>" +
								"<td>" +
								"<a class='able' data-toggle='modal'>使用</a>" +
								"<a class='unable' data-toggle='modal'>禁用</a>" +
								"<a class='edit' data-toggle='modal'>编辑</a>" +
								"<a class='dele' data-toggle='modal'>删除</a>" +
								"<input type='hidden' value='" + res.data[i].id +"'/>" +
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
								$("#myModal .add_tit").val("");
								$("#myModal .fu_tit").val("");
								$("#myModal select").val(0);
								$("#myModal .travel_type").val(1);
								$("#myModal .travel_type").css("display", "none");
								$(".linkurl").val("");
								$(".linkurl").css("display", "none");
								$(".country").css("display", "none");
								$(".sheng").css("display", "none");
								$(".shi").css("display", "none");
								$(".pic_url").val("");
								$(".sort select").val("");
								$("#myModal .add_tit").val(res.data[index].title);
								$("#myModal .fu_tit").val(res.data[index].subtitle);
								$("#myModal #jump_type").val(res.data[index].linkType);
								$("#myModal .pic_url").val("http://img.tgljweb.com/" + res.data[index].pic);
								$("#myModal .sort select").val(res.data[index].sort);
								var link = res.data[index].linkType;
								if(link == 1 || link == 12 || link == 15 || link == 18 || link == 14 || link == 19 || link == 20 || link == 21){
									$("#myModal .travel_type").css("display", "none");
									$("#myModal .linkurl").css("display", "inline-block");
									$("#myModal .linkurl").val(res.data[index].linkUrl);
									$("#myModal .country").css("display", "none");
									$("#myModal .sheng").css("display", "none");
									$("#myModal .shi").css("display", "none");
									if(link == 12 || link == 15 || link == 18){
										$("#myModal .linkurl").val(res.data[index].productId);
									}
									if(link == 18){
										$("#myModal .travel_type").css("display", "inline-block");
										$("#myModal .travel_type").val(res.data[index].travelType);
									}
									if(link == 14 || link == 19){
										$("#myModal .linkurl").css("display", "none");
									}
								}else{
									$("#myModal .travel_type").css("display", "none");
									$("#myModal .linkurl").css("display", "none");
									if(link == 16){
										$("#myModal .travel_type").css("display", "inline-block");
										$("#myModal .travel_type").val(res.data[index].travelType);
									}
									$(".country").val("");
									$(".sheng").html("<option value=''>省</option>");
									$(".shi").html("<option value=''>市</option>");
									if(res.data[index].country == "10001"){
										$(".sheng").css("display", "inline-block");
										// 请求省份
										var con_dat = {
											parentCode: res.data[index].country
										}
										var sheng_co = res.data[index].province;
										$.ajax({
											type: "POST",
											contentType:"application/json;charset=UTF-8",
											url: http_url + "/api/dt/getCityList",
											data: JSON.stringify(con_dat),
											success: function(res){
												for(var i = 0; i < res.data.length; i++){
													$("#myModal .sheng").html($("#myModal .sheng").html() + "<option value='" + res.data[i].cityCode + "' >" + res.data[i]["cityName"] + "</option>")
												}
												// 添加省
												$("#myModal .sheng").val(sheng_co);
												$("#myModal .sheng").off("change");
												$(".sheng").on("change", function(){
													var sheng_code = $(this).val();
													$(".shi").html("<option>市</option>");
													if(sheng_code != "省"){
														var dat = {
															parentCode: sheng_code
														}
														$.ajax({
															type: "POST",
															contentType:"application/json;charset=UTF-8",
															url: http_url + "/api/dt/getCityList",
															data: JSON.stringify(dat),
															success: function(res){
																for(var i = 0; i < res.data.length; i++){
																	$(".shi").html($(".shi").html() + "<option value='" + res.data[i].cityCode + "' city_name='" + res.data[i].cityName + "'>" + res.data[i]["cityName"] + "</option>")
																}
															}
														})
													}
												})
											}
										})
									}
									$(".country").css("display", "inline-block");
									$(".shi").css("display", "inline-block");
									// 请求国家的数据
									var country_code = res.data[index].country;
									$(".country").val(country_code);
									$(".country").off("change");
									$(".country").on("change", function(){
										$(".sheng").css("display", "inline-block");
										$(".shi").css("display", "inline-block");
										$(".sheng").html("<option value=''>省</option>");
										$(".shi").html("<option value=''>市</option>");
										if($(this).val() != ""){
											if($(this).val() == "10001"){
												$(".sheng").css("display", "inline-block");
												var cont_dat = {
													parentCode: "10001"
												}
												$.ajax({
													type: "POST",
													contentType:"application/json;charset=UTF-8",
													url: http_url + "/api/dt/getCityList",
													data: JSON.stringify(cont_dat),
													success: function(res){
														for(var i = 0; i < res.data.length; i++){
															$(".sheng").html($(".sheng").html() + "<option value='" + res.data[i].cityCode + "' >" + res.data[i]["cityName"] + "</option>")
														}
														$(".sheng").off("change");
														$(".sheng").on("change", function(){
															var sheng_code = $(this).val()
															$(".shi").html("<option value=''>市</option>");
															if(sheng_code != ""){
																var dat = {
																	parentCode: sheng_code
																}
																$.ajax({
																	type: "POST",
																	contentType:"application/json;charset=UTF-8",
																	url: http_url + "/api/dt/getCityList",
																	data: JSON.stringify(dat),
																	success: function(res){
																		console.log(res)
																		for(var i = 0; i < res.data.length; i++){
																			$(".shi").html($(".shi").html() + "<option value='" + res.data[i].cityCode + "' city_name='" + res.data[i].cityName + "'>" + res.data[i]["cityName"] + "</option>")
																		}
																	}
																})
															}
														})
													}
												})
											}else{
												$(".sheng").css("display", "none");
												$(".sheng").html("<option value=''>省</option>");
												$(".shi").html("<option value=''>市</option>");
												var count_co = {
													parentCode: $(this).val()
												}
												$.ajax({
													type: "POST",
													contentType:"application/json;charset=UTF-8",
													url: http_url + "/api/dt/getCityList",
													data: JSON.stringify(count_co),
													success: function(res){
														if(res.data.length == 0){
															layer.alert("该国家暂未开通业务!");
														}
														for(var i = 0; i < res.data.length; i++){
															$(".shi").html($(".shi").html() + "<option value='" + res.data[i].cityCode + "' city_name='" + res.data[i].cityName + "'>" + res.data[i]["cityName"] + "</option>")
														}
													}
												})
											}
										}
									})
									// 获取拉取市所需要的数据
									if(res.data[index].country == "10001"){
										var adc = res.data[index].province;
									}else{
										var adc = res.data[index].country;
									}

									var province_dat = {
										parentCode: adc
									}
									// 默认请求市
									var shi_code = res.data[index].city;
									$.ajax({
										type: "POST",
										contentType:"application/json;charset=UTF-8",
										url: http_url + "/api/dt/getCityList",
										data: JSON.stringify(province_dat),
										success: function(res){
											for(var i = 0; i < res.data.length; i++){
												$(".shi").html($(".shi").html() + "<option value='" + res.data[i].cityCode + "' >" + res.data[i]["cityName"] + "</option>")
											}
											$(".shi").val(shi_code)
										}
									})
								}
								$("#myModal").modal("show");
							})
						})
						$(".unable").each(function(index){
							$(".unable").eq(index).on("click", function(){
								$("#myModal1").find("input").eq(0).val($(this).parent().find("input").val());
								$("#myModal1").find("input").eq(1).val(index);
								$("#myModal1").modal("show");
							})
						})
						$(".able").each(function(index){
							$(".able").eq(index).on("click", function(){
								$("#myModal2").find("input").eq(0).val($(this).parent().find("input").val());
								$("#myModal2").find("input").eq(1).val(index);
								$("#myModal2").modal("show");
							})
						})
						$(".dele").each(function(index){
							$(".dele").eq(index).on("click", function(){
								$("#myModal3").find("input").eq(0).val($(this).parent().find("input").val());
								$("#myModal3").find("input").eq(1).val(index);
								$("#myModal3").modal("show");
							})
						})
					}

				}catch(e){
					layer.alert("数据请求失败，请刷新页面或稍后重试!");
				}
			},
			error: function(){
				$(".wrap1").css("display", "none");
				layer.alert("数据请求失败，请刷新重试!");
			}
		})
	}
	// 新增或者编辑时发送请求
	function add_edit(url, dat){
		$.ajax({
			type: "POST",
			contentType:"application/json;charset=UTF-8",
			url:http_url + url,
			data: JSON.stringify(dat),
			success: function(res){
				if(res.msg == "success"){

				}
			}
		})
	}
	// 匹配网址的正则函数
	function IsURL(str_url){
		var strRegex = "^((https|http|ftp|rtsp|mms)?://)"
			+ "?(([0-9a-z_!~*'().&=+$%-]+: )?[0-9a-z_!~*'().&=+$%-]+@)?" //ftp的user@
			+ "(([0-9]{1,3}\.){3}[0-9]{1,3}" // IP形式的URL- 199.194.52.184
			+ "|" // 允许IP和DOMAIN（域名）
			+ "([0-9a-z_!~*'()-]+\.)*" // 域名- www.
			+ "([0-9a-z][0-9a-z-]{0,61})?[0-9a-z]\." // 二级域名
			+ "[a-z]{2,6})" // first level domain- .com or .museum
			+ "(:[0-9]{1,4})?" // 端口- :80
			+ "((/?)|" // a slash isn't required if there is no file name
			+ "(/[0-9a-z_!~*'().;?:@&=+$,%#-]+)+/?)";
		var re=new RegExp(strRegex);
		//re.test()
		if (re.test(str_url)){
			return (true);
		}else{
			return (false);
		}
	};

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
})