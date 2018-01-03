$(function(){
	// 获取网址
	var href_url = window.location.href;
	// 保存公共请求网址
	var http_url = serveUrl();
	//var http_url = "http://139.196.145.18:9090";
	//var http_url = "http://192.168.64.88:9090";
	//var http_url = "http://106.14.19.71:9090";
	//var http_url = "http://106.15.126.75:9090";
	//var http_url = "http://192.168.64.55:9090";
	//var http_url = "http://javaapi.tgljweb.com:9090";
	// 新增需要的接口
	var add_port = "/api/apppush/addapppush";
	// 编辑需要的接口
	var edit_port = "/api/apppush/editapppush";
	// 获取数据判断是从边界也进入还是从新增页进入，a=0是从新增页进入,a=1是从编辑也进入
	html_from = href_url.split("?a=")[1].split("&")[0];
	// 如果是新建，则为创建ID，如果是编辑，则为更新人的ID
	var uid = href_url.split("?a=")[1].split("&uid=")[1];
	// 判断是否是初次进入
	var isok = true;
	// 默认请求国家数据
	$.ajax({
		type: "POST",
		contentType:"application/json;charset=UTF-8",
		url: http_url + "/api/subject/getHotCountries",
		success: function(res){
			for(var i = 0; i < res.data.length; i++){
				$(".country").html($(".country").html() + "<option value='" + res.data[i].cityCode + "' >" + res.data[i]["cityName"] + "</option>")
			}
			// 如果是编辑页进入的话发送请求获取数据，渲染页面
			if(html_from == 1){
				// 此接口用于编辑
				var edit_push = "/api/apppush/searchapppushbyid";
				var _id = JSON.parse(get_or_push("edit_id"));
				var product_id = _id["id"];
				var user_id = _id["create_id"];
				var edit_first = {
					id: product_id
					// id: "896971410327470080"
				}
				$.ajax({
					type: "POST",
					contentType:"application/json;charset=UTF-8",
					url:http_url + edit_push,
					data: JSON.stringify(edit_first),
					success: function(res){
						//console.log(res); return false;
						if(res.code == 0){
							//var tim = new Date(parseInt(res.data.pushTime)).getFullYear() + "-" + (new Date(parseInt(res.data.pushTime)).getMonth() + 1) + "-" + new Date(parseInt(res.data.pushTime)).getDate() + "-" + new Date(parseInt(res.data.pushTime)).getHours() + ":00";
							$(".push_type").val(res.data.pushType)
							$("#d241").val(change_time1(res.data.pushTime));
							if(res.data.isAllCity == 0){
								$(".city").eq(0).attr("checked", "checked");
							}else{
								$(".city").eq(1).attr("checked", "checked");
								$(".add_city").css("display", "block");
								$(".add_city").val(res.data.citys.split("[")[1].split("]")[0])
							}
							$(".city_hid").val(res.data.isAllCity)
							$(".platform").val(res.data.platform);
							$(".radio").eq(res.data.pushUser).attr("checked", "checked");
							$(".rup_type").val(res.data.jumpType);
							$(".user_hid").val(res.data.pushUser);
							$(".city_hid").val(res.data.isAllCity);
							if(res.data.jumpType == 1 || res.data.jumpType == 12 || res.data.jumpType == 14 || res.data.jumpType == 4 || res.data.jumpType == 20){
								$(".link_id").css("display", "block");
								if(res.data.jumpType == 1){
									$(".link_id").val(res.data.jumpUrl)
								}else{
									$(".link_id").val(res.data.jumpId)
									if(res.data.jumpType == 4){
										$(".travel").css("display", "inline-block");
										$(".travel").val(res.data.jumpTypeChild)
									}else if(res.data.jumpType == 20){
										$(".link_id").css("display", "none");
									}
								}
							}else{
								if(res.data.jumpType == 16){
									$(".travel").css("display", "inline-block");
									$(".travel").val(res.data.jumpTypeChild);
								}
								var sheng_code = res.data.jumpProvince;
								if(res.data.jumpCountry == "10001"){
									$(".sheng").css("display", "inline-block");
									// 请求省份
									var con_dat = {
										parentCode: "10001"
									}
									$.ajax({
										type: "POST",
										contentType:"application/json;charset=UTF-8",
										url: http_url + "/api/subject/getCityList",
										data: JSON.stringify(con_dat),
										success: function(res){
											for(var i = 0; i < res.data.length; i++){
												$(".sheng").html($(".sheng").html() + "<option value='" + res.data[i].cityCode + "' >" + res.data[i]["cityName"] + "</option>")
											}
											// 添加省
											$(".sheng").val(sheng_co);
											$(".sheng").off("change");
											$(".sheng").on("change", function(){
												var sheng_code = $(this).val();
												$(".shi").html("<option value=''>市</option>");
												if(sheng_code != ""){
													var dat = {
														parentCode: sheng_code
													}
													$.ajax({
														type: "POST",
														contentType:"application/json;charset=UTF-8",
														url: http_url + "/api/subject/getCityList",
														data: JSON.stringify(dat),
														success: function(res){
															for(var i = 0; i < res.data.length; i++){
																$(".shi").html($(".shi").html() + "<option value='" + res.data[i].cityCode + "' >" + res.data[i]["cityName"] + "</option>")
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
								var country_code = res.data.jumpCountry;
								// 默认请求省
								var sheng_co = res.data.jumpProvince;
								$(".country").val(country_code);
								$(".country").off("change");
								$(".country").on("change", function(){
									isok = false;
									$(".sheng").html("<option value=''>省</option>")
									$(".shi").html("<option value=''>市</option>")
									if($(this).val() != ""){
										if($(this).val() == "10001"){
											$(".sheng").css("display", "inline-block");
											var cont_dat = {
												parentCode: "10001"
											}
											$.ajax({
												type: "POST",
												contentType:"application/json;charset=UTF-8",
												url: http_url + "/api/subject/getCityList",
												data: JSON.stringify(con_dat),
												success: function(res){
													for(var i = 0; i < res.data.length; i++){
														$(".sheng").html($(".sheng").html() + "<option value='" + res.data[i].cityCode + "' >" + res.data[i]["cityName"] + "</option>")
													}
													// 添加省
													if(isok){
														$(".sheng").val(sheng_co);
													}
													$(".sheng").off("change");
													$(".sheng").on("change", function(){
														var sheng_code = $(this).val()
														$(".shi").html("<option>市</option>");
														if(sheng_code != ""){
															var dat = {
																parentCode: sheng_code
															}
															$.ajax({
																type: "POST",
																contentType:"application/json;charset=UTF-8",
																url: http_url + "/api/subject/getCityList",
																data: JSON.stringify(dat),
																success: function(res){
																	for(var i = 0; i < res.data.length; i++){
																		$(".shi").html($(".shi").html() + "<option value='" + res.data[i].cityCode + "' >" + res.data[i]["cityName"] + "</option>")
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
											var province_dat = {
												parentCode: $(this).val()
											}
											$.ajax({
												type: "POST",
												contentType:"application/json;charset=UTF-8",
												url: http_url + "/api/subject/getCityList",
												data: JSON.stringify(province_dat),
												success: function(res){
													if(res.data.length == 0){
														layer.alert("该地区暂未开通服务，请重新选择!");
														return false;
													}
													for(var i = 0; i < res.data.length; i++){
														$(".shi").html($(".shi").html() + "<option value='" + res.data[i].cityCode + "' >" + res.data[i]["cityName"] + "</option>")
													}
												}
											})

										}
									}
								})
								// 获取拉取市所需要的数据
								var adc = "";
								if(res.data.jumpCountry != "10001"){
									adc = res.data.jumpCountry;
								}else{
									adc = res.data.jumpProvince;
								}
								var province_dat = {
									parentCode: adc
								}
								// 默认请求市
								var shi_code = res.data.jumpCity;
								$.ajax({
									type: "POST",
									contentType:"application/json;charset=UTF-8",
									url: http_url + "/api/subject/getCityList",
									data: JSON.stringify(province_dat),
									success: function(res){
										for(var i = 0; i < res.data.length; i++){
											$(".shi").html($(".shi").html() + "<option value='" + res.data[i].cityCode + "' >" + res.data[i]["cityName"] + "</option>")
										}
										$(".shi").val(shi_code)
									}
								})
							}
							$(".add_tit").val(res.data.pushTitle);
							$(".add_cont").val(res.data.pushContent);
						}else{
							layer.alert(res.msg,function(){
								window.location.href = $(".toapp_push").val();
							});
						}
					},
					error: function(){
						layer.alert("数据请求失败，请刷新重试!");
					}
				})

			}
		}
	})
	
	// 点击全部城市与部分城市的时候下面城市输入框的显示与消失
	$("input[name='city']").on("click", function(){
		if($(this).val() == "0"){
			$(".add_city").css("display", "none")
			$(".city_hid").val(0);
		}else{
			$(".add_city").css("display", "block");
			$(".city_hid").val(1);
		}
	})
	// 点击推送用户单选按钮
	$("input[name='user']").on("click", function(){
		$(".user_hid").val($(this).val())
	})

	// 跳转类型切换时进行的操作
	$(".rup_type").on("change", function(){
		if($(this).val() == 20){
			$(".link_id").css("display", "none");
			$(".travel").css("display", "none");
			$(".country").css("display", "none");
			$(".sheng").css("display", "none");
			$(".shi").css("display", "none");
			$(".country").val("");
			$(".sheng").html("<option value=''>省</option>");
			$(".shi").html("<option value=''>市</option>");
			$(".travel").val(1);
			$(".link_id").val("")
		}else if($(this).val() == 1 || $(this).val() == 12 || $(this).val() == 14){
			$(".link_id").css("display", "block");
			$(".travel").css("display", "none");
			$(".country").css("display", "none");
			$(".sheng").css("display", "none");
			$(".shi").css("display", "none");
			$(".country").val("");
			$(".sheng").html("<option value=''>省</option>");
			$(".shi").html("<option value=''>市</option>");
			if($(this).val() == 1){
				$(".link_id").attr("placeholder", "请填写链接地址");
			}else{
				$(".link_id").attr("placeholder", "请填写产品ID");
			}
		}else if($(this).val() == 4){
			$(".link_id").css("display", "block");
			$(".country").css("display", "none");
			$(".sheng").css("display", "none");
			$(".shi").css("display", "none");
			$(".link_id").attr("placeholder", "请填写产品ID");
			$(".travel").css("display", "inline-block");
			$(".country").val("");
			$(".sheng").html("<option value=''>省</option>");
			$(".shi").html("<option value=''>市</option>");
		}else if($(this).val() == 2 || $(this).val() == 15 || $(this).val() == 16){
			if($(this).val() == 16){
				$(".travel").css("display", "inline-block");
				$(".travel").val(1);
			}else{
				$(".travel").css("display", "none");
			}
			$(".link_id").css("display", "none");
			$(".country").css("display", "inline-block");
			$(".sheng").css("display", "inline-block");
			$(".shi").css("display", "inline-block");
			$(".country").val("")
			$(".sheng").html("<option value=''>省</option>");
			$(".shi").html("<option value=''>市</option>");
			$(".country").off("change");
			$(".country").on("change", function(){
				if($(this).val() != ""){
					if($(this).val() == "10001"){
						$(".sheng").html("<option value=''>省</option>")
						$(".shi").html("<option value=''>市</option>")
						$(".sheng").css("display", "inline-block");
						var country_code = $(this).val();									
						var country_dat = {
							parentCode: country_code
						}
						$.ajax({
							type: "POST",
							contentType:"application/json;charset=UTF-8",
							url: http_url + "/api/subject/getCityList",
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
												url: http_url + "/api/subject/getCityList",
												data: JSON.stringify(dat),
												success: function(res){
													if(res.code == 0){
														for(var i = 0; i < res.data.length; i++){
															$(".shi").html($(".shi").html() + "<option value='" + res.data[i].cityCode + "' >" + res.data[i]["cityName"] + "</option>")
														}
													}else {
														layer.alert("数据获取失败，请刷新页面重新尝试!");
													}
												}
											})
										}
									})
								}else{
									layer.alert("数据获取失败,请刷新页面重新尝试!");
								}

							}
						})									
					}else{
						$(".sheng").css("display", "none");
						$(".sheng").html("<option value=''>省</option>");
						var sheng_code = $(this).val()
						$(".sheng").val("<option value=''>省</option>")
						$(".shi").html("<option value=''>市</option>");
						if(sheng_code != ""){
							var dat = {
								parentCode: sheng_code
							}
							$.ajax({
								type: "POST",
								contentType:"application/json;charset=UTF-8",
								url: http_url + "/api/subject/getCityList",
								data: JSON.stringify(dat),
								success: function(res){
									if(res.code == 0){
										if(res.data.length == 0){
											layer.alert("该地区暂未开通服务，请重新选择!");
										}
										for(var i = 0; i < res.data.length; i++){
											$(".shi").html($(".shi").html() + "<option value='" + res.data[i].cityCode + "' >" + res.data[i]["cityName"] + "</option>")
										}
									}else{
										layer.alert("数据获取失败，请刷新页面重新尝试!");
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

	// 点击选择市
	$(".shi").on("click", function(){
		if($(".country").val() == "10001"){
			if($(".sheng").val() == ""){
				layer.alert("请先选择省");
			}
		}
		if($(".country").val() == ""){
			layer.alert("请先选择国家!");
		}		
	})
	$(".sheng").on("click", function(){
		if($(".country").val() == ""){
			layer.alert("请先选择国家!");
		}
	})




	// 点击保存按钮
	$("#save").on("click", function(){
		// 获取推送时间
		var d241 = $("#d241").val().split(":")[0].split("-");
		//var pushtime = new Date(d241[0] + "/" + d241[1] + "/" + d241[2]).getTime() + parseInt(d241[3])*60*60*1000;
		var pushtime = new Date(d241[0] + "/" + d241[1] + "/" + d241[2]).getTime() + parseInt(d241[3])*60*60*1000 + parseInt($("#d241").val().split(":")[1])*60*1000 + parseInt($("#d241").val().split(":")[2])*1000;
		//alert(pushtime); return false;
		// 推送城市
		var isAllCity = $(".city_hid").val();
		// 部分推送城市的城市名称
		var citys = "";
		var city_all = "";
		if(isAllCity == 0){
			citys = "";
		}else{
			city_all = $.trim($(".add_city").val());
			for(var i = 0; i < city_all.split("，").length; i++){
				if(i < city_all.split("，").length - 1){
					citys = citys + city_all.split("，")[i] + ","
				}else if(i == city_all.split("，").length - 1){
					citys += city_all.split("，")[i];
					break;
				}
			}
			if($.trim($(".add_city").val()) == ""){
				layer.alert("请填写推送城市!");
				return false;
			}
			// citys = $(".add_city").val();
		}
		// 推送平台
		var platform = $(".platform").val();
		// 推送用户
		var pushUser = $(".user_hid").val();
		// 跳转类型
		var jumpType = $(".rup_type").val();
		var jumpUrl = "";
		var jumpId = "";
		var jumpCity = "";
		var jumpProvince = "";
		var jumpTypeChild = "";
		var jumpCountry = "";
		// 通过跳转类型决定jumpUrl、jumpCity、jumpProvince、jumpIdjumpTypeChild、jumpId；
		if(jumpType == 20){
			jumpUrl = "";
			jumpCity = "";
			jumpId = "";
			jumpProvince = "";
			jumpTypeChild = "";
			jumpCountry = "";
		}else if(jumpType == 1){
			jumpUrl = $(".link_id").val();
			// h5链接为空阻拦
			if($.trim($(".link_id").val()) == ""){
				layer.alert("请填写h5链接!");
				return false;
			}
			if(!IsURL(jumpUrl)){
				layer.alert("请填写正确的网址链接!")
				return false;
			}
			jumpCity = "";
			jumpId = "";
			jumpProvince = "";
			jumpTypeChild = "";
			jumpCountry = "";
		}else if(jumpType == 12 || jumpType == 14){
			jumpId = $(".link_id").val();
			jumpUrl = "";
			jumpCity = "";
			jumpProvince = "";
			jumpTypeChild = "";
			jumpCountry = "";
			if($.trim($(".link_id").val()) == ""){
				layer.alert("请填写产品ID!");
				return false;
			}
		}else if(jumpType == 4){
			jumpUrl = "";
			jumpCity = "";
			jumpId = $(".link_id").val();
			jumpProvince = "";
			jumpCountry = "";
			jumpTypeChild = $(".travel").val();
			if($.trim($(".link_id").val()) == ""){
				layer.alert("请填写产品ID!");
				return false;
			}
		}else{
			if(jumpType == 16){
				jumpTypeChild = $(".travel").val();
			}else{
				jumpTypeChild = "";
			}
			jumpUrl = "";
			jumpCity = $(".shi").val();
			jumpId = "";
			jumpCountry = $(".country").val();
			if(jumpCountry != "10001"){
				jumpProvince = "";
			}else{
				jumpProvince = $(".sheng").val();
			}
			if(jumpCountry == ""){
				layer.alert("请选择国家!");
				return false;
			}
			if(jumpCountry == "10001" && jumpProvince == ""){
				layer.alert("请选择省份!");
				return false;
			}
			if($(".shi").val() == ""){
				layer.alert("请选择城市!");
				return false;
			}
		}
		// Push主题
		var pushTitle = $(".add_tit").val();
		// 添加主题
		var pushContent = $(".add_cont").val();

		// 获取页面数据
		var data_all = {
			pushType: $(".push_type").val(),
			pushTime: pushtime,
			isAllCity: isAllCity,
			citys: citys,
			platform: platform,
			pushUser: pushUser,
			jumpType: jumpType,
			jumpUrl: jumpUrl,
			jumpCity: jumpCity,
			jumpId: jumpId,
			jumpProvince: jumpProvince,
			jumpTypeChild: jumpTypeChild,
			pushTitle: pushTitle,
			pushContent: pushContent,
			jumpCountry: jumpCountry
		}
		// 用于阻拦
		//  日期阻拦
		if($("#d241").val() == ""){
			layer.alert("请选择日期!");
			return false;
		}
		// 推送城市阻拦
		if(isAllCity == ""){
			layer.alert("请选择推送城市!");
			return false;
		}
		// 推送用户阻拦
		if(pushUser == ""){
			layer.alert("请选择推送用户!");
			return false;
		}
		// 推送主题或内容阻拦
		if(pushTitle == "" && pushContent == ""){
			layer.alert("请填写推送主题或推送内容!");
			return false;
		}

		// 根据从哪个页面进来的从而发送数据到不同的接口 
		if(html_from == 0){
			// 从新增选项进入页面
			data_all.createBy = uid;
			data_all.updateBy = uid;
			ajax_post(data_all, add_port)
		}else if(html_from == 1){
			// 从编辑选项进入页面
			data_all.createBy = JSON.parse(get_or_push("edit_id"))["create_id"];
			data_all.updateBy = uid;
			data_all.id = JSON.parse(get_or_push("edit_id"))["id"];
			// 发送数据
			ajax_post(data_all, edit_port);			
		}
	})

	// 点击取消按钮
	$("#abolish").on("click", function(){
		window.location.href = $(".toapp_push").val();
	})

	// 一下是封装的公用函数

	// 用于点击保存时请求数据
	function ajax_post(dat, url){
		$.ajax({
			type: "POST",
			contentType:"application/json;charset=UTF-8",
			url:http_url + url,
			data: JSON.stringify(dat),
			success: function(res){
				if(res.code == 0){
					window.location.href = $(".toapp_push").val();
				}else{
					layer.alert(res.msg, function(){
						window.location.href = $(".toapp_push").val();
					})
				}
			},
			error: function(){
				layer.alert("数据请求失败，请刷新重试!");
			}
		})
	}
	// 将时间戳转化为日期加上时分秒格式
	function change_time1(dat){
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
	}
})