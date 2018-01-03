$(".loading").css("display","block");
var id=GetRequest("id").id||10;
var type=window.localStorage.getItem("types")||2;
var travelLinkType=16;
//获取达人列表
function getTravelList(){
	$(".loading").css("display","block");
	var param= {
		id:id
	}
	$.ajax({
		type: "POST",
		contentType:"application/json;charset=UTF-8",
		url:http_url+ "/api/operate/editBannerById",
		data:JSON.stringify(param),
		success: function(data){
			$(".loading").css("display","none");
			$(".star_con").html("");
			if(data.code==0){
				var starList=data.data;
                //console.log(starList);
				for(var i=0;i<starList.length;i++){
                     var cityName=starList[i].cityName.split("市")[0];
					//获取城市名
					$(".star_con").append(
						"<tr>"+
						"<td class='id'>"+(i+1)+"</td>"+
						" <td>"+cityName+"</td>"+
						"<td>"+getDateDiff(starList[i].updateTime)+"</td>"+
						" <td>"+starList[i].sort+"</td>"+
						"<td>"+((starList[i].enabled==1)?'已使用':'禁用')+"</td>"+
						"<td>" + starList[i].userName + "</td>"+
						"<td class='edit_star'><a class='changeState' onclick='changeState("+i+","+starList[i].enabled+")'>"+((starList[i].enabled==1)?'禁用':'使用')+"</a><a onclick='editTravel("+i+")'>编辑</a><a onclick='delStar("+i+","+starList[i].id+")'>删除</a></td>"+
						"</tr>");
				}
			}else{
				layer.alert("加载数据失败");
				return false;
			}
		}
	})
}
getTravelList();


//禁用、使用
function changeState(curIndex,curStatus){
	var enablesTest;
	if(curStatus){
		enablesTest="禁用"
	}else{
		enablesTest="使用"
	}
	$.beamDialog({
		title:'',
		content:'确定'+enablesTest+'该条数据吗?',
		showCloseButton:false,
		otherButtons:["确定","取消"],
		otherButtonStyles:['btn-primary yes','btn-primary no'],
		bsModalOption:{keyboard: true},
		clickButton:function(sender,modal,index){
			// console.log('选中第'+index+'个按钮：'+sender.html());
			if(index==0){
				tochangeState(curIndex);
				// tochangeState(897346550768861184,curStatus);
			}else if(index==1){
				//console.log("点击了取消按钮");
			}
			$(this).closeDialog(modal);
		}
	});
}
function tochangeState(curIndex){
	$.ajax({
		type: "POST",
		contentType: "application/json;charset=UTF-8",
		url: http_url + "/api/operate/editBannerById",
		data: JSON.stringify({id:id}),
		success: function (data) {
			if(data.code==0){
				var curStarList=data.data;
				var curStarId=curStarList[curIndex].id;
				var curStatus=curStarList[curIndex].enabled;
				var enabled;
				if(curStatus==1){
					enabled=0
				}else{
					enabled=1
				}
				var param={
					id:curStarId,
					enabled:parseInt(enabled)
				}
				$.ajax({
					type: "POST",
					contentType:"application/json;charset=UTF-8",
					url:http_url + "/api/operate/disablebyid",
					data:JSON.stringify(param),
					success: function(data){
						getTravelList();
					}
				})
			}
		}
	})
}

//删除达人
function delStar(curIndex){
	$.ajax({
		type: "POST",
		contentType: "application/json;charset=UTF-8",
		url: http_url + "/api/operate/editBannerById",
		data: JSON.stringify({id: id}),
		success: function (data) {
			if (data.code == 0) {
				var curStarConId = data.data[curIndex].id;
				var param={
					id:curStarConId
				}

				$.beamDialog({
					title:'',
					content:'确定删除该条数据吗?',
					showCloseButton:false,
					otherButtons:["确定","取消"],
					otherButtonStyles:['btn-primary yes','btn-primary no'],
					bsModalOption:{keyboard: true},
					clickButton:function(sender,modal,index){
						// console.log('选中第'+index+'个按钮：'+sender.html());
						if(index==0){
							//console.log("点击了确认按钮");
							$.ajax({
								type: "POST",
								contentType:"application/json;charset=UTF-8",
								url:http_url + "/api/operate/deleteByid",
								data:JSON.stringify(param),
								success: function(data){
									getTravelList();
								}
							})
						}else if(index==1){
							// console.log("点击了取消按钮");
						}
						$(this).closeDialog(modal);
					}
				});


			}
		}
	})
}


$(".sort").click(function(){
	$(".msg").css("display","none");
})


//编辑旅游路线
function editTravel(curIndex){
	$(".travelThemeModalName").html("编辑");
	window.localStorage.removeItem("flag");
	window.localStorage.setItem("flag",2);

	window.localStorage.removeItem("clickCurIndex");
	window.localStorage.setItem("clickCurIndex",curIndex);

	$(".add").css("display","none");
	$(".edit").css("display","inline-block");
	$(".province").html("<option value='0'>省份</option>");
	$(".city").html("<option value='0'>市</option>");

	$.ajax({
		type: "POST",
		contentType: "application/json;charset=UTF-8",
		url: http_url + "/api/operate/editBannerById",
		data: JSON.stringify({id:id}),
		success: function (data) {
			if(data.code==0){
				var curStarCon=data.data[curIndex];
				var bannerId=curStarCon.id;
				//城市、排序初始化
				$(".country").val( curStarCon.country||"0");  //城市
				$(".sort").val(curStarCon.sort); //排序
				//城市初始化
				getProvinceList();
				function getProvinceList(){
					if($(".country").val()>0){
						$.ajax({
							type: "POST",
							contentType: "application/json;charset=UTF-8",
							url: http_url + "/api/dt/getCityList",
							data:JSON.stringify({parentCode:$(".country").val()}) ,
							success: function (data) {
								var temp_html;
								if(data.code==0){
									var provinceList=data.data;
									$.each(provinceList,function(i,province){
										temp_html+="<option value='"+province.cityCode+"'>"+province.cityName+"</option>";
									});
									if($(".country").val()==0){
										$(".province").html("<option value='0'>省份</option>");
									}else{
										$(".province").html("<option value='0'>省份</option>"+temp_html);
										$(".province").val(curStarCon.province);//省份
										getCityList();
									}
								}
							}
						})
					}
				}
				function getCityList(){
					$.ajax({
						type: "POST",
						contentType: "application/json;charset=UTF-8",
						url: http_url + "/api/dt/getCityList",
						data:JSON.stringify({parentCode:$(".province").val()}) ,
						success: function (data) {
							var temp_html;
                            if(data.code==0){
                                var cityList=data.data;
                                if(cityList.length>0){
                                    $.each(cityList,function(i,city){
                                        temp_html+="<option value='"+city.cityCode+"'>"+city.cityName+"</option>";
                                    });
                                }
                                /*$(".city").val(curStarCon.city);//城市*/
                                if(curStarCon.city==0){
                                    //$(".city").html("<option value='0'>市</option>");
                                    //$(".city").html("<option value='0'>市</option>").css("display","none");
                                    if($(".country").val()!="10001"){
                                        $(".city").html("<option value='0'>市</option>").css("display","none");
                                    }else{
                                        $(".city").html("<option value='0'>市</option>").css("display","inline-block");
                                    }

                                }else{
                                    $(".city").html("<option value='0'>市</option>"+temp_html);
                                    if($(".country").val()!="10001"){
                                        //$(".city").val(cityList[0].cityCode).css("display","inline-block");//城市
                                        //如果是国外，cityCode显示成proviceCode
                                        $(".city").val($(".province").val()).css("display","inline-block");//城市
                                    }else{
                                        $(".city").val(0).css("display","inline-block");//城市
                                    }
                                    for(var i=0;i<cityList.length;i++){
                                        if(cityList[i].cityCode==curStarCon.city){
                                            $(".city").val(curStarCon.city).css("display","inline-block");//城市
                                        }
                                    }
                                }
                                if((curStarCon.city)&&($(".country").val()!="10001")&&(cityList.length==1)){
                                    $(".city").css("display","none");
                                }else{
                                    $(".city").css("display","inline-block");
                                }
                            }

						}
					})
				}

				//模拟假的数据(编辑旅游路线)  子元素初始化
				$.ajax({
					type:"POST",
					contentType: "application/json;charset=UTF-8",
					url:http_url+"/api/operate/selectSubject",
					data: JSON.stringify({itemId:bannerId}),
					success:function(data){
						//alert(data.data)
						if(data.code==0 && data.data != ''){
							var dataList=data.data;  //二级元素
							//旅游路线初始化
							$(".travelThemeModal").find("table").html("");
							for(var i=0;i<dataList.length;i++){
								//$(".travelThemeModal ").find("table").append("<tr id='oddTravel"+i+"'><td><div  class='typeList travelCity common'><span class='tit'></span><select   class='myLinkType_long  myTravelType"+i+"'  id='longTravelType'><option value='1'>主题线路</option><option value='2'>当地活动</option><option value='4'>游记攻略</option><option value='3'>印象随笔</option><option value='5'>当地向导</option></select></div><div class='typeList typeListId travel_productId'><span class='tit'>产品ID：</span><input value='"+dataList[i].travelProductId+"' type='text' placeholder='请填写产品Id' name='' class='productId' ></div><div class='typeList  travel_productImg clear pic'><span class='tit'>图片:</span><input value='http://img.tgljweb.com/"+dataList[i].pic+"' type='text' readonly='readonly' class='pic_url cur_pic_url"+i+"'><div class='file' id='files'><div id='curContainer"+i+"' class=' containers tgpic_item' style='margin-top: 2px;'><button class='browse' type='button' id='curBrowse"+i+"' style='z-index: 2;'>浏览...</button><input type='hidden' value='0' class='idcardz upload_status'><input type='hidden' value='' id='addpic' name='' class='card_pic'><div id='html5_1blcujl1i1aq473k78i1musjpe3_container' class='moxie-shim moxie-shim-html5' style='position: absolute; top: 0px; left: 0px; overflow: hidden; z-index: 1;'><input id='html5_1blcujl1i1aq473k78i1musjpe3' type='file' style='font-size: 999px; opacity: 0; position: absolute; top: 0px; left: 0px; width: 100%; height: 100%;' multiple='' accept='image/jpeg,.JPG,.JPEG,.PNG,image/png'></div></div></div></div><div class='typeList reviewImg'><a  onclick='reviewEditImg("+i+")'>查看图片<span class='flag'>2</span><span class='subItemId'>"+dataList[i].subItemId+"</span></a></div></td><td class='del'><a onclick='delOddTravel("+i+")'>删除</a></td></tr>");
								// 带上传图片版本的
								//$(".travelThemeModal ").find("table").append("<tr id='oddTravel"+i+"'><td><input class='hid_inp' type='hidden' value='" + dataList[i].id + "'/> <div  class='typeList travelCity common'><span class='tit'></span><select   class='myLinkType_long  myTravelType"+i+"'  id='longTravelType'><option value='1'>主题线路</option></select></div><div class='typeList typeListId travel_productId'><span class='tit'>产品ID：</span><input value='"+dataList[i].travelProductId+"' type='text' placeholder='请填写产品Id' name='' class='productId' ></div><div class='typeList  travel_productImg clear pic'><span class='tit'>图片:</span><input value='http://img.tgljweb.com/"+dataList[i].pic+"' type='text' readonly='readonly' class='pic_url cur_pic_url"+i+"'><div class='file' id='files'><div id='curContainer"+i+"' class=' containers tgpic_item' style='margin-top: 2px;'><button class='browse' type='button' id='curBrowse"+i+"' style='z-index: 2;'>浏览...</button><input type='hidden' value='0' class='idcardz upload_status'><input type='hidden' value='' id='addpic' name='' class='card_pic'><div id='html5_1blcujl1i1aq473k78i1musjpe3_container' class='moxie-shim moxie-shim-html5' style='position: absolute; top: 0px; left: 0px; overflow: hidden; z-index: 1;'><input id='html5_1blcujl1i1aq473k78i1musjpe3' type='file' style='font-size: 999px; opacity: 0; position: absolute; top: 0px; left: 0px; width: 100%; height: 100%;' multiple='' accept='image/jpeg,.JPG,.JPEG,.PNG,image/png'></div></div></div></div><div class='typeList reviewImg'><a  onclick='reviewEditImg("+i+")'>查看图片<span class='flag'>2</span><span class='subItemId'>"+dataList[i].subItemId+"</span></a></div></td><td class='del'><a onclick='delOddTravel("+i+")'>删除</a></td></tr>");
								//uploadImg(("curBrowse"+i),("curContainer"+i),(".cur_pic_url"+i));
								$(".travelThemeModal ").find("table").append("<tr id='oddTravel"+i+"'><td><input class='hid_inp' type='hidden' value='" + dataList[i].id + "'/> <div  class='typeList travelCity common'><span class='tit'></span><select   class='myLinkType_long  myTravelType"+i+"'  id='longTravelType'><option value='1'>主题线路</option></select></div><div class='typeList typeListId travel_productId'><span class='tit'>产品ID：</span><input value='"+dataList[i].travelProductId+"' type='text' placeholder='请填写产品Id' name='' class='productId' ></div><div class='typeList reviewImg'><span class='flag'>2</span><span class='subItemId'>"+dataList[i].subItemId+"</span></div></td><td class='del'><a onclick='delOddTravel("+i+")'>删除</a></td></tr>");
								$(".myTravelType"+i).val(dataList[i].travelType);

							}
							$('#myModal_add').modal('show');
							isCommited=false;

						}else{
							layer.alert(data.msg);
						}

                    },
					error: function(){
						layer.alert("数据请求失败，请稍后重试!");
					}
                })


            }
        }
    })
}
function reviewEditImg(i){
    if($(".cur_pic_url"+i).val()){
		window.open($(".cur_pic_url"+i).val());
	}else{
		layer.alert("请先上传图片");
	}
}

//编辑旅游路线
var isCommited=false;
function _editTravel(){
	if(!isCommited){
		var param;
		var dataList=[];
		var travelLis=$(".travelThemeModal").find("tr");
		//var city=$(".cityNameText").val();  //城市
		var city=$(".city").val();  //城市
		var province=$(".province").val();
		var country=$(".country").val();
		var sort=$(".sort").val(); //排序
		var curIndex=window.localStorage.getItem("clickCurIndex");
		$.ajax({
			type: "POST",
			contentType: "application/json;charset=UTF-8",
			url: http_url + "/api/operate/editBannerById",
			data: JSON.stringify({id: id}),
			success: function (data) {
				//console.log(data);
				if (data.code == 0) {
					var curStarCon = data.data[curIndex];
					var bannerId = curStarCon.id;

					var taverList=data.data;
					for(var i = 0;i < travelLis.length; i++){

						if($(travelLis[i]).find(".flag").html()==3){
							dataList[i]={
								itemId:id,
								travelType:$(travelLis[i]).find(".myLinkType_long").val()||"",
								productId:$(travelLis[i]).find(".productId").val()||"",
								//pic:($(travelLis[i]).find(".pic_url").val())?($(travelLis[i]).find(".pic_url").val().split("http://img.tgljweb.com/")[1].split("?")[0]):"",
								flag:$(travelLis[i]).find(".flag").html(),
								subItemId:$(travelLis[i]).find(".subItemId").html()||"",
								status:0,
								travelProductId: $(travelLis[i]).find(".hid_inp").val()
							}
						}else{
							dataList[i]={
								itemId:id,
								travelType:$(travelLis[i]).find(".myLinkType_long").val()||"",
								productId:$(travelLis[i]).find(".productId").val()||"",
								//pic:($(travelLis[i]).find(".pic_url").val())?($(travelLis[i]).find(".pic_url").val().split("http://img.tgljweb.com/")[1].split("?")[0]):"",
								flag:$(travelLis[i]).find(".flag").html(),
								subItemId:$(travelLis[i]).find(".subItemId").html()||"",
								travelProductId: $(travelLis[i]).find(".hid_inp").val()
							}
						}
					}
					var travleCity={
						//city:($(".city").val()>0)?($(".city").val()):($(".province").val()),
                        city:($(".city").val() > 0)?($(".city").val()):($(".province").val()),//城市
						cityName:($(".city").css("display")=="inline-block")?($(".city option:selected").text()):($(".province option:selected").text()),
						itemId:id,
						province:province,
						country:country,
						sort:sort,
						linkType:"16",
						type:type,
                        createBy:adminId
					}
					param={
						id:bannerId,
						travleCity:travleCity,
						dataList:dataList,
					}
                   // param.createBy=adminId;
                   // console.log("编辑",param);
					//输入判断
					var errMsg;
					if(country==0){
						errMsg="请选择国家"
					}else if(province==0){
						errMsg="请选择省份"
					//}else if(($(".country").val()=="10001")&&($(".city").val()==0)){
					}else if(city==0){
                        errMsg="请选择市"
                    }else if(sort==0){
						errMsg="请选择对应的位置"
					}else{
						//子元素新增输入判断
						for(var i=0;i<param.dataList.length;i++){
							if(!param.dataList[i].productId){
								errMsg="请填写产品ID"
							}
						}
					}
					if(errMsg){
						layer.alert(errMsg);
						return false;
					}else{
						//提交数据
						var index = layer.load(1, {
							shade: [0.1,'#fff'] //0.1透明度的白色背景
						});
						//console.log(param); return false;
						$.ajax({
							type: "POST",
							contentType:"application/json;charset=UTF-8",
							url:http_url+"/api/operate/updateByDataList",
							data:JSON.stringify(param),
							success: function(data){
								if(data.code==0){
									layer.close(index);
									$('#myModal_add').modal('hide');
									getTravelList();
								}else{
									layer.close(index);
									layer.alert("编辑失败");
									return false;
								}
							},
							error: function(){
								layer.close(index);
								layer.alert("编辑失败，请稍后重试!");
							}
						})

					}

				}
			}
		})
	}

}

//新增达人
function addTravel(){
	$(".travelThemeModalName").html("新增");
	window.localStorage.removeItem("flag")
	window.localStorage.setItem("flag",1)
	$(".add").css("display","inline-block");
	$(".edit").css("display","none");
	$(".city").css("display","inline-block");
	//$(".cityList").css("display","none");
	$(".country").val("0");
	$(".province").html("<option value='0'>省份</option>");
	$(".city").html("<option value='0'>市</option>");

	$(".sort").val(0);
	$(".travelThemeModal").find("table").html("");
	//$(".travelThemeModal ").find("table").append("<tr id='newTravel'><td><div  class='typeList travelCity common'><span class='tit'></span><select class='myLinkType_long'  id='longTravelType'><option value='1'>主题线路</option><option value='2'>当地活动</option><option value='4'>游记攻略</option><option value='3'>印象随笔</option><option value='5'>当地向导</option></select></div><div class='typeList typeListId travel_productId'><span class='tit'>产品ID：</span><input type='text' placeholder='请填写产品Id' name='' class='productId' ></div><div class='typeList  travel_productImg clear pic'><span class='tit'>图片:</span><input type='text' readonly='readonly' class='pic_url pic_url01'><div class='file' id='files'><div id='container' class=' tgpic_item' style='margin-top: 2px;'><button class='browse' type='button' id='browse' style='z-index: 2;'>浏览...</button><input type='hidden' value='0' class='idcardz upload_status'><input type='hidden' value='' id='addpic' name='' class='card_pic'><div id='html5_1blcujl1i1aq473k78i1musjpe3_container' class='moxie-shim moxie-shim-html5' style='position: absolute; top: 0px; left: 0px; overflow: hidden; z-index: 1;'><input id='html5_1blcujl1i1aq473k78i1musjpe3' type='file' style='font-size: 999px; opacity: 0; position: absolute; top: 0px; left: 0px; width: 100%; height: 100%;' multiple='' accept='image/jpeg,.JPG,.JPEG,.PNG,image/png'></div></div></div></div><div class='typeList reviewImg'><a  onclick='reviewImg()'>查看图片<span class='flag'>1</span></a></div></td><td class='del'><a onclick='delNewTravel()'>删除</a></td></tr>");
	//$(".travelThemeModal ").find("table").append("<tr id='newTravel'><td><div  class='typeList travelCity common'><span class='tit'></span><select class='myLinkType_long'  id='longTravelType'><option value='1'>主题线路</option></select></div><div class='typeList typeListId travel_productId'><span class='tit'>产品ID：</span><input type='text' placeholder='请填写产品Id' name='' class='productId' ></div><div class='typeList  travel_productImg clear pic'><span class='tit'>图片:</span><input type='text' readonly='readonly' class='pic_url pic_url01'><div class='file' id='files'><div id='container' class=' tgpic_item' style='margin-top: 2px;'><button class='browse' type='button' id='browse' style='z-index: 2;'>浏览...</button><input type='hidden' value='0' class='idcardz upload_status'><input type='hidden' value='' id='addpic' name='' class='card_pic'><div id='html5_1blcujl1i1aq473k78i1musjpe3_container' class='moxie-shim moxie-shim-html5' style='position: absolute; top: 0px; left: 0px; overflow: hidden; z-index: 1;'><input id='html5_1blcujl1i1aq473k78i1musjpe3' type='file' style='font-size: 999px; opacity: 0; position: absolute; top: 0px; left: 0px; width: 100%; height: 100%;' multiple='' accept='image/jpeg,.JPG,.JPEG,.PNG,image/png'></div></div></div></div><div class='typeList reviewImg'><a  onclick='reviewImg()'>查看图片<span class='flag'>1</span></a></div></td><td class='del'><a onclick='delNewTravel()'>删除</a></td></tr>"); // 带添加商品图片的版本
	//初始化图片
	//uploadImg(browse,container,".pic_url01");
	$(".travelThemeModal ").find("table").append("<tr id='newTravel'><td><div  class='typeList travelCity common'><span class='tit'></span><select class='myLinkType_long'  id='longTravelType'><option value='1'>主题线路</option></select></div><div class='typeList typeListId travel_productId'><span class='tit'>产品ID：</span><input type='text' placeholder='请填写产品Id' name='' class='productId' ></div><div class='typeList reviewImg'><span class='flag'>1</span></div></td><td class='del'><a onclick='delNewTravel()'>删除</a></td></tr>");


	$('#myModal_add').modal('show');

}

function reviewImg(){
  if($(".pic_url01").val()){
	  window.open($(".pic_url01").val());
  }else{
	  layer.alert("请先上传图片");
	  return false;
  }
	//window.open();
}

function _addTravel(){
	var param;
	var dataList=[];
	var travelLis=$(".travelThemeModal").find("tr");

	var sort=$(".sort").val(); //排序
	var city=$(".city").val();
	var province=$(".province").val();
	var country=$(".country").val();

	//param
	for(var i=0;i<travelLis.length;i++){
		dataList[i]={
			itemId:id,
			travelType:$(travelLis[i]).find(".myLinkType_long").val()||"",
			productId:$(travelLis[i]).find(".productId").val()||"",
			//pic:($(travelLis[i]).find(".pic_url").val())?$(travelLis[i]).find(".pic_url").val().split("http://img.tgljweb.com/")[1].split("?")[0]:"",
			flag:$(travelLis[i]).find(".flag").html(),
			travelProductId: ""
		}
	}
	var travleCity={
		city:($(".city").val()>0)?($(".city").val()):($(".province").val()),
		cityName:($(".city").css("display")=="inline-block")?($(".city option:selected").text()):($(".province option:selected").text()),
		itemId:id,
		province:province,
		country:country,
		sort:sort,
		type:type,
		linkType:"16",
        createBy:adminId
	}
	param={
		travleCity:travleCity,
		dataList:dataList,
	}
   // param.createBy=adminId;
   // console.log("新增param",param);

	//输入判断
	var errMsg;
	if(country==0){
		errMsg="请选择国家"
	}else if(province==0){
		errMsg="请选择省份"
	}else if((   $(".city").css("display")=="inline-block"  ) &&(city==0)){
		errMsg="请选择市"
	}else if(sort==0){
		errMsg="请选择对应的位置"
	}else{
          //子元素新增输入判断
		for(var i=0;i<param.dataList.length;i++){
			if(!param.dataList[i].productId){
				errMsg="请填写产品ID"
			}
		}
	}
	if(errMsg){
		layer.alert(errMsg);
		return false;
	}else{
		//提交数据
        //console.log("新增",param); return false;
		$.ajax({
			type: "POST",
			contentType:"application/json;charset=UTF-8",
			url:http_url + "/api/operate/updateByDataList",
			data:JSON.stringify(param),
			success: function(data){
				if(data.code==0){
					$('#myModal_add').modal('hide');
					getTravelList();
				}else{
					layer.alert("新增失败");
					return false;
				}

			},
			error: function(){
				layer.alert("新增失败，请稍后重试!");
			}
		})
	}
}
//在模态框中增加商品
var rowCount=$(".travelThemeModal table").find("tr").length;  //行数默认4行
function addGoods(){
	rowCount++;
	var flag=window.localStorage.getItem("flag");

	//$(".travelThemeModal").find("table").append("<tr id='option"+rowCount+"'><td><div  class='typeList travelCity common'><span class='tit'></span><select class='myLinkType_long'  id='longTravelType'><option value='1'>主题线路</option><option value='2'>当地活动</option><option value='4'>游记攻略</option><option value='3'>印象随笔</option><option value='5'>当地向导</option></select></div><div class='typeList typeListId travel_productId'><span class='tit'>产品ID：</span><input type='text' placeholder='请填写产品Id' name='' class='productId'></div><div class='typeList  travel_productImg clear pic'><span class='tit'>图片:</span><input type='text' readonly='readonly' class='pic_url' id='pic_url"+rowCount+"'><div class='file' id='files'><div  id='container"+rowCount+"' class=' containers tgpic_item' style='margin-top: 2px;'><button    class='browse"+rowCount+"' type='button' id='browse"+rowCount+"' style='z-index: 2;'>浏览...</button><input type='hidden' value='0' class='idcardz upload_status'><input type='hidden' value='' id='addpic' name='' class='card_pic'><div id='html5_1blcujl1i1aq473k78i1musjpe3_container' class='moxie-shim moxie-shim-html5' style='position: absolute; top: 0px; left: 0px; overflow: hidden; z-index: 1;'><input id='html5_1blcujl1i1aq473k78i1musjpe3' type='file' style='font-size: 999px; opacity: 0; position: absolute; top: 0px; left: 0px; width: 100%; height: 100%;' multiple='' accept='image/jpeg,.JPG,.JPEG,.PNG,image/png'></div></div></div></div><div class='typeList reviewImg'><a  onclick='reviewNewImg("+rowCount+")'>查看图片<span><span class='flag'>1</span></a></div></td><td class='del'><a onclick='del("+rowCount+")'>删除</a></td></tr>");
	//uploadImg(("browse"+rowCount),("container"+rowCount),("#pic_url"+rowCount));
	$(".travelThemeModal").find("table").append("<tr id='option"+rowCount+"'><td><div  class='typeList travelCity common'><span class='tit'></span><select class='myLinkType_long'  id='longTravelType'><option value='1'>主题线路</option></select></div><div class='typeList typeListId travel_productId'><span class='tit'>产品ID：</span><input type='text' placeholder='请填写产品Id' name='' class='productId'></div><div class='typeList reviewImg'><span class='flag'>1</span></div></td><td class='del'><a onclick='del("+rowCount+")'>删除</a></td></tr>");
}
function reviewNewImg(rowCount){
	if($("#pic_url"+rowCount).val()){
		window.open($("#pic_url"+rowCount).val());
	}else{
		layer.alert("请先上传图片");
		return false;
	}
}

//删除行
function  del(rowIndex){
	$("#option"+rowIndex).remove();
	rowCount--;
}
function delOddTravel(index){
	$("#oddTravel"+index).css("display","none");
	$("#oddTravel"+index).find(".flag").html(3);
}

function delNewTravel(){
	$("#newTravel").remove();
}


//初始化城市
$(".loading").css("display","none");
function getCountryList(curContry){
    $(".loading").css("display","block");
    //获取热门城市
    $.ajax({
        type: "POST",
        contentType:"application/json;charset=UTF-8",
        url:http_url + "/api/dt/getHotCountries",
        data:"",
        success: function(data){
            $(".loading").css("display","none");
            if(data.code==0){
                var countryList=data.data;
                var temp_html;
                for(var i=0;i<countryList.length;i++){
                    temp_html+="<option value='"+countryList[i].cityCode+"'>"+countryList[i].cityName+"</option>";
                }
                $(".country").html("<option value='0'>国家</option>"+temp_html);
                if(curContry>0){
                    $(".country").val(curContry);
                }

                $(".cityList").each(function(){
                    var temp_html;
                    var oCountry = $(this).find(".country");  //国家
                    var oProvince = $(this).find(".province");  //省份
                    var oCity = $(this).find(".city");  //城市
                    //初始化国家
                    //country();
                    //function country(){
                    //    $.each(countryList,function(i,country){
                    //        temp_html+="<option value='"+country.cityCode+"'>"+country.cityName+"</option>";
                    //    });
                    //    oCountry.html("<option value='0'>国家</option>"+temp_html);
                    //
                    //    province();
                    //};
                    //初始化省份
                    function province(){
                        temp_html = "";
                        var curCityCode=$(".country").val();
                        //根据索引号获取省份  //api/dt/getCityList
                        $.ajax({
                            type: "POST",
                            contentType: "application/json;charset=UTF-8",
                            url: http_url + "/api/dt/getCityList",
                            data:JSON.stringify({parentCode:curCityCode}) ,
                            success: function (data) {
                                if(data.code==0){
                                    var provinceList=data.data;
                                    $.each(provinceList,function(i,province){
                                        temp_html+="<option value='"+province.cityCode+"'>"+province.cityName+"</option>";
                                    });
                                    if($(".country").val()==0){
                                        oProvince.html("<option value='0'>省份</option>");
                                    }else{
                                        oProvince.html("<option value='0'>省份</option>"+temp_html);
                                    }
                                    //初始化
                                    if($(".country").val()!="10001"){
                                        $(".city").css("display","none");
                                    }else{
                                        $(".city").css("display","inline-block");
                                    }
                                    //changeCity();
                                }
                            }
                        })
                    }

                    //初始化城市
                    function changeCity(){
                        var provinceCode=$(oProvince).val();
                        temp_html = "";
                        $.ajax({
                            type: "POST",
                            contentType: "application/json;charset=UTF-8",
                            url: http_url + "/api/dt/getCityList",
                            data:JSON.stringify({parentCode: provinceCode}) ,
                            success: function (data){
                                if(data.code==0){
                                    var cityList=data.data;
                                    if((typeof(cityList) == "undefined")||((cityList.length==0))){
                                        oCity.css("display","none");
                                    }else{
                                        oCity.css("display","inline");
                                        $.each(cityList,function(i,city){
                                            temp_html+="<option value='"+city.cityCode+"'>"+city.cityName+"</option>";
                                        });
                                        if(provinceCode==0){
                                            oCity.html("<option value='0'>市</option>");
                                        }else{
                                            oCity.html("<option value='0'>市</option>"+temp_html);
                                            if($(".country").val()!="10001"){
                                                if($(".province").val()>0){
                                                    //$( $(".city").find("option")[1]).attr("selected",true)
                                                    //国外的cityCode显示成省的cityCode
                                                    //$( $(".city").find("option")[1]).attr("selected",true)
                                                    $(".city").val($(".province").val())//城市
                                                }
                                            }
                                        }

                                    };
                                    if(($(".country").val()!="10001")&&(cityList.length==1)){
                                        $(".city").css("display","none");
                                    }else{
                                        $(".city").css("display","inline-block");
                                    }

                                }

                            }
                        })
                    }

                    //select监听
                    //选择国家改变省
                    oCountry.change(function(){
                        province();
                    });
                    //选择省改市
                    oProvince.change(function(){
                        changeCity();
                    });
                    oProvince.click(function(){
                        if($(".country").val()==0){
                            $(".province").html("");
                            $(".province").html("<option value='0'>省份</option>");
                        }
                    });
                    oCity.click(function(){
                        if($(".province").val()==0){
                            $(".city").html("");
                            $(".city").html("<option value='0'>市</option>");
                        }
                    })


                    $(".province").click(function(){
                        if($(".country").val()==0){
                            $(".msgTxt").html("请先选择国家");
                            $(".msg").css("display","block");
                        }else{
                            $(".msg").css("display","none");
                        }
                    });
                    $(".country").click(function(){
                        $(".msg").css("display","none");
                    });

                    $(".city").click(function(){
                        if($(".city").val()==0){
                            if($(".country").val()==0){
                                if($(".province").val()==0){
                                    $(".msgTxt").html("请先选择国家");
                                    $(".msg").css("display","block");
                                }else{
                                    $(".msg").css("display","none");
                                }

                            }else if($(".province").val()==0){
                                $(".msgTxt").html("请先选择省");
                                $(".msg").css("display","block");
                            }
                        }else{
                            $(".msg").css("display","none");
                        }

                    });
                });

            }

        }

    })
}
getCountryList();

