$(function(){
	// 查询佣金比例
	var http_url = serveUrl();
	$.ajax({
		type: "POST",
		contentType:"application/json;charset=UTF-8",
		url: http_url + "/api/hotel/getPartnerDivide",
		success: function(res){
			$(".loading_wrap").css("display", "none");
			if(res.code == 0){
				$(".divide_into").val(res.data.status)
			}else{
				layer.alert("数据请求失败，请刷新重试!");
			}
		},
		error: function(){
			$(".loading_wrap").css("display", "none");
			layer.alert("数据请求失败，请刷新重试!");
		}
	})



	$(".save_btn").on("click", function(){
		console.log(http_url)
		var pass_data = {
			"status": $(".divide_into").val(),
			"uid": adminId
		}
		$.ajax({
			type: "POST",
			contentType:"application/json;charset=UTF-8",
			url: http_url + "/api/hotel/setPartnerDivide",
			data: JSON.stringify(pass_data),
			beforeSend: function(){
				$(".loading_wrap").css("display", "block");
			},
			success: function(res){
				$(".loading_wrap").css("display", "none");
				if(res.code == 0){
					layer.alert("设置成功!");
				}else{
					layer.alert(res.msg);
				}
			},
			error: function(){
				$(".loading_wrap").css("display", "none");
				layer.alert("系统繁忙，请稍后刷新重试!");
			}
		})
	})
})