$(function(){
	// ？？？？？？？？？？？？？？？？？？？？？？？？？？？？？？？还缺一个操作人id的字段需要添加？？？？？？？？？？？？？？？？？？？？？？？？？？
	// 查询加价比例
	// console.log(new Date(1504108800000).getMonth() + "-" + new Date(1504108800000).getDate())
	var http_url = serveUrl();
	$.ajax({
		type: "POST",
		contentType:"application/json;charset=UTF-8",
		url: http_url + "/api/tongcheng/getIncreaseProportion",
		data: JSON.stringify({"type": "1"}),
		success: function(res){
			if(res.code == 0){
				console.log(res)
				$("input[name='add_price']").val(res.data.scaleValue);
			}else{
				layer.alert("数据请求失败，请刷新重试!");
			}
		},
		error: function(){
			layer.alert("数据请求失败，请刷新重试!");
		}
	})



	$(".save_btn").on("click", function(){
		var ratio = $.trim($("input[name='add_price']").val());
		if(ratio == ""){
			layer.alert("请填写加价比例!");
			return false;
		}
		var pass_data = {
			"scaleValue": ratio,
			"type": 1,
			"updateBy": adminId
		}
		$.ajax({
			type: "POST",
			contentType:"application/json;charset=UTF-8",
			url: http_url + "/api/tongcheng/setIncreaseProportion",
			data: JSON.stringify(pass_data),
			success: function(res){
				if(res.code == 0){
					layer.alert("设置成功!");
				}else{
					layer.alert(res.msg);
				}
			},
			error: function(){
				layer.alert("系统繁忙，请稍后刷新重试!");
			}
		})
	})
})