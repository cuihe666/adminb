
var id=GetRequest("id").id||6;
//var http_url="http://192.168.65.254:9090";
//var http_url = "http://139.196.145.18:9090";
//var http_url = "http://106.14.19.71:9090";
//var http_url = "http://106.15.126.75:9090";
//var http_url = "http://javaapi.tgljweb.com:9090";
var http_url = serveUrl();
var type=window.localStorage.getItem("types")||3;
$(".tite").html("热门城市");
//获取达人列表
$(".loading").css("display","none");
function getPersonList(){
	$(".loading").css("display","block");
	var param= {
		id:id
	}
	$.ajax({
		type: "POST",
		contentType:"application/json;charset=UTF-8",
		url:http_url + "/api/operate/editBannerById",
		data:JSON.stringify(param),
		success: function(data){
			$(".loading").css("display","none");
			$(".star_con").html("");
			if(data.code==0){
				var starList=data.data;
				for(var i=0;i<starList.length;i++){
					var curLinkType;
					if(starList[i].linkType==1){
						curLinkType="H5";
					}else if(starList[i].linkType==12){
						curLinkType="民宿产品详情";
					}else if(starList[i].linkType==15){
						curLinkType="酒店产品详情";
					}else if(starList[i].linkType==18){
						curLinkType="旅游产品详情";
					}else if(starList[i].linkType==14){
						curLinkType="原生酒店";
					}else if(starList[i].linkType==2){
						curLinkType="民宿列表（城市分）";
					}else if(starList[i].linkType==17){
						curLinkType="酒店列表（城市分）";
					}else if(starList[i].linkType==16){
						curLinkType="旅游列表（城市分）";
					}
					var curUrlCon;
					if(starList[i].linkUrl){
						curUrlCon=starList[i].linkUrl;
					}else if(starList[i].productId){
						curUrlCon=starList[i].productId;
					}else{
						curUrlCon="";
					}
					$(".star_con").append(
						"<tr>"+
						"<td class='id'>"+(i+1)+"</td>"+
						"<td>"+starList[i].title+"</td>"+
						"<td>"+curLinkType+"</td>"+
						/*"<td class='linkUrl_Id'>"+curUrlCon+"</td>"+*/
						"<td><img alt='民宿' src=http://img.tgljweb.com/"+(starList[i].pic?(starList[i].pic+"?imageView2/1/w/150/h/100"):"")+"></td>"+
						" <td>"+starList[i].sort+"</td>"+
						"<td>"+((starList[i].enabled==1)?'已使用':'禁用')+"</td>"+
						"<td>"+getDateDiff(starList[i].updateTime)+"</td>"+
						"<td>" + starList[i].userName + "</td>"+
						"<td class='edit_star'><a class='changeState' onclick='changePerson("+i+","+starList[i].enabled+")'>"+((starList[i].enabled==1)?'禁用':'使用')+"</a><a onclick='editPerson("+i+")'>编辑</a><a onclick='delPerson("+i+")'>删除</a></td>"+
						"</tr>"
					);
				}
			}
		}
	})
}
getPersonList();


//禁用、使用
function changePerson(curIndex,curStatus){
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
				tochangePerson(curIndex);
				// tochangeState(897346550768861184,curStatus);
			}else if(index==1){
				//console.log("点击了取消按钮");
			}
			$(this).closeDialog(modal);
		}
	});
}
function tochangePerson(curIndex){
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
						if(data.code==0){
							getPersonList();
						}else{
							if(curStatus==1){
								layer.alert("禁用无效");
								return false;
							}else{
								layer.alert("使用无效");
								return false;
							}
						}

					}
				})
			}

		}
	})
}

//删除达人
function delPerson(curIndex){
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
									if(data.code==0){
										getPersonList();
									}else{
										layer.alert("删除无效");
										return false;
									}
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


//编辑达人
function editPerson(curIndex){
	window.localStorage.removeItem("clickCurIndex")
	window.localStorage.setItem("clickCurIndex",curIndex)
	$(".add").css("display","none");
	$(".edit").css("display","inline-block");
	$(".modal-header").html("编辑");

	$(".country").html("<option value='0'>国家</option>");
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
				var curImgurl=curStarCon.pic;
				var bannerId=curStarCon.id;

				var curLinklUrlText;
				if(curStarCon.linkUrl){
					curLinklUrlText=curStarCon.linkUrl;
				}else if(curStarCon.productId){
					curLinklUrlText=curStarCon.productId;
				}else{
					curLinklUrlText="";
				}
                var curlinkType=curStarCon.linkType;
				if(curlinkType==1){
					$(".link_url").attr("placeholder","请输入链接地址");
					$(".common.travel").css("display","none");
					$(".common.cityList").css("display","none");
					$(".common.travelCity").css("display","none");
					$(".common.normal").css("display","block");
				}else if((curlinkType==12)||(curlinkType==15)){
					$(".link_url").attr("placeholder","请填写产品id");
					$(".common.travel").css("display","none");
					$(".common.cityList").css("display","none");
					$(".common.travelCity").css("display","none");
					$(".common.normal").css("display","block");
				}else if(curlinkType==18){
					//旅游产品城市
					$(".common.travel").css("display","block");
					$(".common.normal").css("display","none");
					$(".common.cityList").css("display","none");
					$(".common.travelCity").css("display","none");
				}else if((curlinkType==2)||(curlinkType==17)) {
					//民宿列表、酒店列表、旅游列表s
					$(".common.travel").css("display","none");
					$(".common.cityList").css("display","block");
					$(".common.travelCity").css("display","none");
					$(".common.normal").css("display","none");
				}else if(curlinkType==16){
					$(".common.travel").css("display","none");
					$(".common.cityList").css("display","block");
					$(".common.travelCity").css("display","block");
					$(".common.normal").css("display","none");

				}else if(curlinkType==14){
					$(".common.travel").css("display","none");
					$(".common.cityList").css("display","none");
					$(".common.travelCity").css("display","none");
					$(".common.normal").css("display","none");
				}

				$(".personTitle").val(curStarCon.title); //标题
				$(".myLinkType").val(curStarCon.linkType); //链接类型
				$(".link_url").val(curLinklUrlText);//跳转链接
				$(".myLinkType2").val(curStarCon.travelType);  //旅游二级菜单
				$(".travelInput2").val(curStarCon.productId);//旅游产品二级id
				$(".myLinkType_long").val(curStarCon.travelType);//旅游二级菜单，宽为100%

				function getCountryList(){
					$.ajax({
						type: "POST",
						contentType: "application/json;charset=UTF-8",
						url: http_url + "/api/dt/getHotCountries",
						data: "",
						success: function (data) {
							var temp_html;
							if(data.code==0){
								var countryList=data.data;
								/*$.each(countryList,function(i,country){
									temp_html+="<option value='"+country.cityCode+"'>"+country.cityName+"</option>";
								});*/
                                //热门城市只显示中国
                                temp_html+="<option value='"+countryList[0].cityCode+"'>"+countryList[0].cityName+"</option>";
								$(".country").html("<option value='0'>国家</option>"+temp_html);

								$(".country").val(curStarCon.country);//国家
								getProvinceList();
							}
						}
					})
				}
                function getProvinceList(){
					if(curStarCon.country>0){
						$.ajax({
							type: "POST",
							contentType: "application/json;charset=UTF-8",
							url: http_url + "/api/dt/getCityList",
							data:JSON.stringify({parentCode:curStarCon.country}) ,
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
						data:JSON.stringify({parentCode:curStarCon.province}) ,
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
                                        $(".city").val(cityList[0].cityCode).css("display","inline-block");//城市
                                    }else{
                                        $(".city").val("").css("display","inline-block");//城市
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
				getCountryList();
				$(".pic_url").val("http://img.tgljweb.com/" + curImgurl); //图片
				$(".sort").val(curStarCon.sort); //排序
			}
		}
	})
	$('#myModal_add').modal('show');
}

function _editPerson(){
	var curIndex=window.localStorage.getItem("clickCurIndex");
	$.ajax({
		type: "POST",
		contentType: "application/json;charset=UTF-8",
		url: http_url + "/api/operate/editBannerById",
		data: JSON.stringify({id:id}),
		success: function (data) {
			if(data.code==0){
				var curStarCon=data.data[curIndex];
				var bannerId=curStarCon.id;
				var curLinkType=curStarCon.linkType;

				var param;
				var curTravelType=$(".myLinkType2").val()||""; //旅游产品路线
				var curTravelType_long=$("#longTravelType").val()||"";

				//输入验证
				var errMsg;
				var personTitle=$(".personTitle").val(), //标题
					myLinkType=$(".myLinkType").val(),//链接类型
					link_url=$(".link_url").val(),//跳转链接
					myLinkType2=$(".myLinkType2").val(),  //旅游二级菜单
					longTravelType=$("#longTravelType").val(),  //旅游二级菜单
					travelInput2=$(".travelInput2").val(),//旅游产品二级id
					myLinkType_long=$(".myLinkType_long").val(),//旅游二级菜单，宽为100%

					country=$(".country").val(),//国家
					province=$(".province").val(),//省份
					city=$(".city").val(),//城市

					pic_url=$(".pic_url").val(),  //图片
					sort=$(".sort").val(); //排序


				if(!personTitle){
					errMsg="请填写标题"
				}else if(myLinkType==0){
					errMsg="请选择链接类型"
				}else{
					if(curLinkType==1){
						if(!link_url){
							errMsg="请输入链接地址"
						}else if(!pic_url){
							errMsg="请上传图片"
						}else if(!sort){
							errMsg="请选择对应的位置"
						}
					}else if((curLinkType==12)||(curLinkType==15)){
						if(!link_url){
							errMsg="请填写产品Id"
						}else if(!pic_url){
							errMsg="请上传图片"
						}else if(!sort){
							errMsg="请选择对应的位置"
						}
					}else if(curLinkType==18){
						if(!myLinkType2){
							errMsg="请选择旅游线路"
						}else if(!travelInput2){
							errMsg="请填写产品Id"
						}else if(!pic_url){
							errMsg="请上传图片"
						}else if(!sort){
							errMsg="请选择对应的位置"
						}
					}else if((curLinkType==2)||(curLinkType==17)){
						if(country==0){
							errMsg="请选择国家"
						}else if(province==0){
							errMsg="请选择省份"
						}else if(($(".country").val()=="10001")&&($(".city").val()==0)){
                            errMsg="请选择市"
                        }else if(!pic_url){
							errMsg="请上传图片"
						}else if(!sort){
							errMsg="请选择对应的位置"
						}
					}else if(curLinkType==16){
						if(!longTravelType){
							errMsg="请选择旅游路线"
						}else if(country==0){
							errMsg="请选择国家"
						}else if(province==0){
							errMsg="请选择省份"
						}else if(($(".country").val()=="10001")&&($(".city").val()==0)){
                            errMsg="请选择市"
                        }else if(!pic_url){
							errMsg="请上传图片"
						}else if(!sort){
							errMsg="请选择对应的位置"
						}
					}else if(curLinkType==14){
						if(!pic_url){
							errMsg="请上传图片"
						}else if(!sort){
							errMsg="请选择对应的位置"
						}
					}
				}
				if(errMsg){
					layer.alert(errMsg);
					return false;
				}else{
					//提交数据
					var curLinkType=$(".myLinkType").val()
					if(curLinkType==1){
						//H5
						param= {
							title:$(".personTitle").val(), //标题
							linkType:curLinkType,//跳转类型
							linkUrl:$(".link_url").val(),
							pic:$(".pic_url").val().split("http://img.tgljweb.com/")[1].split("?")[0],  //图片
							sort:$(".sort").val(),    //排序
							id:bannerId,
							type:type
						}
					}else if((curLinkType==12)||(curLinkType==15)){
						//民宿、酒店
						param= {
							title:$(".personTitle").val(), //标题
							linkType:curLinkType,//跳转类型
							productId:$(".link_url").val(),
							pic:$(".pic_url").val().split("http://img.tgljweb.com/")[1].split("?")[0],  //图片
							sort:$(".sort").val(),    //排序
							id:bannerId,
							type:type
						}
					}else if(curLinkType==18){
						//旅游产品（有旅游路线）
						param={
							title:$(".personTitle").val(), //标题
							linkType:curLinkType,//跳转类型
							travelType:curTravelType,//旅游路线
							productId:$(".travelInput2").val(),
							pic:$(".pic_url").val().split("http://img.tgljweb.com/")[1].split("?")[0],  //图片
							sort:$(".sort").val(),    //排序
							id:bannerId,
							type:type
						}
					}else if((curLinkType==2)||(curLinkType==17)){
						//民宿列表、酒店列表（有省、市）
						param={
							title:$(".personTitle").val()||"", //标题
							linkType:curLinkType,//跳转类型
							country:$(".country").val()||"", //国家
							province:$(".province").val()||"", //省
							city:($(".city").val()>0)?($(".city").val()):"",//市
                            cityName:($(".city").val()!=0)?($(".city option:selected").text()):($(".province option:selected").text()),
							pic:$(".pic_url").val().split("http://img.tgljweb.com/")[1].split("?")[0]||"",  //图片
							sort:$(".sort").val()||"",    //排序
							id:bannerId,
							type:type
						}
					}else if(curLinkType==16){
						//旅游列表（路线、省、市）
						param={
							title:$(".personTitle").val()||"", //标题
							linkType:curLinkType,//跳转类型
							travelType:curTravelType_long,//旅游路线
							country:$(".country").val()||"",
							province:$(".province").val()||"",
							city:($(".city").val()>0)?($(".city").val()):"",//市
                            cityName:($(".city").val()!=0)?($(".city option:selected").text()):($(".province option:selected").text()),
							pic:$(".pic_url").val().split("http://img.tgljweb.com/")[1].split("?")[0]||"",  //图片
							sort:$(".sort").val()||"",    //排序
							id:bannerId,
							type:type
						}
					}else  if(curLinkType==14){
						//原生酒店
						param= {
							title:$(".personTitle").val(), //标题
							linkType:curLinkType,//跳转类型
							pic:$(".pic_url").val().split("http://img.tgljweb.com/")[1].split("?")[0],  //图片
							sort:$(".sort").val(),    //排序
							id:bannerId,
							type:type
						}
					}
                    param.createBy=adminId;
                   // console.log("编辑",param);
					$.ajax({
						type: "POST",
						contentType:"application/json;charset=UTF-8",
						url:http_url + "/api/operate/updateHomeCity",
						data:JSON.stringify(param),
						success: function(date){
							if(data.code==0){
								$('#myModal_add').modal('hide');
								getPersonList();
							}else{
								layer.alert("编辑失败");
								return  false;
							}

						}
					})

				}
			}
		}
	})

}

//新增民宿
$("#mylinkType").change(function(){
	var _this=this;
	var  curlinkType=$(_this).children('option:selected').val();//这就是selected的值
	$(".msg").css("display","none");
	if(curlinkType==1){
        $(".link_url").attr("placeholder","请输入链接地址");
		$(".link_url").val("");
		$(".common.travel").css("display","none");
		$(".common.cityList").css("display","none");
		$(".common.travelCity").css("display","none");
		$(".common.normal").css("display","block");
	}else if((curlinkType==12)||(curlinkType==15)){
		$(".link_url").attr("placeholder","请填写产品id");
		$(".link_url").val("");
		$(".common.travel").css("display","none");
		$(".common.cityList").css("display","none");
		$(".common.travelCity").css("display","none");
		$(".common.normal").css("display","block");
	}else if(curlinkType==18){
		//旅游产品
		$(".common.travel").css("display","block");
		$(".common.normal").css("display","none");
		$(".common.cityList").css("display","none");
		$(".common.travelCity").css("display","none");
		$(".myLinkType2").val(1);
		$(".travelInput2").val("");
	}else if((curlinkType==2)||(curlinkType==17)) {
		//民宿列表、酒店列表、旅游列表
		$(".common.travel").css("display","none");

		$(".common.cityList").css("display","block");
		$(".country").val("0");
		$(".province").html("<option value='0'>省份</option>")
		$(".city").css("display","inline-block").html("<option value='0'>市</option>");

		$(".common.travelCity").css("display","none");
		$(".common.normal").css("display","none");
	}else if(curlinkType==16){
		$(".common.travel").css("display","none");
		$(".common.cityList").css("display","block");
		$(".country").val("0");
		$(".province").html("<option value='0'>省份</option>")
		$(".city").css("display","inline-block").html("<option value='0'>市</option>");
		$(".myLinkType_long").val("1");

		$(".common.travelCity").css("display","block");
		$(".common.normal").css("display","none");

	}else if(curlinkType==14){
		$(".common.travel").css("display","none");
		$(".common.cityList").css("display","none");
		$(".common.travelCity").css("display","none");
		$(".common.normal").css("display","none");
	}

});


function addPerson(){

	$(".add").css("display","inline-block");
	$(".edit").css("display","none");
	$(".personTitle").val(""); //标题
	$(".myLinkType").val("0"); //链接类型
	$(".link_url").val("");//跳转链接
	$(".myLinkType2").val(1);  //旅游二级菜单
	$(".travelInput2").val("");//旅游产品二级id
	$(".myLinkType_long").val(1);//旅游二级菜单，宽为100%

	$(".pic_url").val("");  //图片
	$(".sort").val(""); //排序

	$(".link_url").attr("placeholder","请输入链接地址");
	$(".common.travel").css("display","none");
	$(".common.cityList").css("display","none");
	$(".common.travelCity").css("display","none");
	$(".common.normal").css("display","block");

	$(".country").val("0");//国家
	$(".province").html("<option value='0'>省份</option>");//省份
	$(".city").html("<option value='0'>城市</option>");//城市
	$(".city").css("display","inline-block");

    if($(".country").val()!="10001"){
        $(".city").css("display","none");
    }else{
        $(".city").css("display","inline-block");
    }

	$('#myModal_add').modal('show');

}

function _addPerson(){
	var param;
	var curLinkType=$("#mylinkType").val()||"";
	var curTravelType=$(".myLinkType2").val()||""; //旅游产品路线
	var curTravelType_long=$("#longTravelType").val()||"";

	//输入验证
	var errMsg;
	var personTitle=$(".personTitle").val(), //标题
		myLinkType=$(".myLinkType").val(),//链接类型
	    link_url=$(".link_url").val(),//跳转链接
	    myLinkType2=$(".myLinkType2").val(),  //旅游二级菜单
		longTravelType=$("#longTravelType").val(),  //旅游二级菜单
	    travelInput2=$(".travelInput2").val(),//旅游产品二级id
	    myLinkType_long=$(".myLinkType_long").val(),//旅游二级菜单，宽为100%
		country=$(".country").val(),//国家
		province=$(".province").val(),//省份
		city=$(".city").val(),//城市
		pic_url=$(".pic_url").val(),  //图片
		sort=$(".sort").val(); //排序
	if(!personTitle){
		 errMsg="请填写标题"
	}else if(myLinkType==0){
		 errMsg="请选择链接类型"
	}else{
		if(curLinkType==1){
			if(!link_url){
				errMsg="请输入链接地址"
			}else if(!pic_url){
				errMsg="请上传图片"
			}else if(!sort){
				errMsg="请选择对应的位置"
			}
		}else if((curLinkType==12)||(curLinkType==15)){
			if(!link_url){
				errMsg="请填写产品Id"
			}else if(!pic_url){
				errMsg="请上传图片"
			}else if(!sort){
				errMsg="请选择对应的位置"
			}
		}else if(curLinkType==18){
			if(!myLinkType2){
				errMsg="请选择旅游线路"
			}else if(!travelInput2){
				errMsg="请填写产品Id"
			}else if(!pic_url){
				errMsg="请上传图片"
			}else if(!sort){
				errMsg="请选择对应的位置"
			}
		}else if((curLinkType==2)||(curLinkType==17)){
			if(country==0){
				errMsg="请选择国家"
			}else if(province==0){
				errMsg="请选择省份"
			}else if(($(".country").val()=="10001")&&($(".city").val()==0)){
                errMsg="请选择市"
            }else if(!pic_url){
				errMsg="请上传图片"
			}else if(!sort){
				errMsg="请选择对应的位置"
			}
		}else if(curLinkType==16){
			if(!longTravelType){
				errMsg="请选择旅游路线"
			}else if(country==0){
				errMsg="请选择国家"
			}else if(province==0){
				errMsg="请选择省份"
			}else if(($(".country").val()=="10001")&&($(".city").val()==0)){
                errMsg="请选择市"
            }else if(!pic_url){
				errMsg="请上传图片"
			}else if(!sort){
				errMsg="请选择对应的位置"
			}
		}else if(curLinkType==14){
			if(!pic_url){
				errMsg="请上传图片"
			}else if(!sort){
				errMsg="请选择对应的位置"
			}
		}
	}
    if(errMsg){
		 layer.alert(errMsg);
		 return false;
	}else{
		//数据提交
        var curCityCode=($(".city").val()>0)?($(".city").val()):"";
		if(curLinkType==1){
			//H5
			param= {
				title:$(".personTitle").val(), //标题
				linkType:curLinkType,//跳转类型
				linkUrl:$(".link_url").val(),
				pic:$(".pic_url").val().split("http://img.tgljweb.com/")[1].split("?")[0],  //图片
				sort:$(".sort").val(),    //排序
				itemId:id,  //id
				type:type
			}
		}else if((curLinkType==12)||(curLinkType==15)){
			//民宿、酒店
			param= {
				title:$(".personTitle").val(), //标题
				linkType:curLinkType,//跳转类型
				productId:$(".link_url").val(),
				pic:$(".pic_url").val().split("http://img.tgljweb.com/")[1].split("?")[0],  //图片
				sort:$(".sort").val(),    //排序
				itemId:id,  //id
				type:type
			}
		}else if(curLinkType==18){
			//旅游产品（有旅游路线）
			param={
				title:$(".personTitle").val(), //标题
				linkType:curLinkType,//跳转类型
				travelType:curTravelType,//旅游路线
				productId:$(".travelInput2").val(),
				pic:$(".pic_url").val().split("http://img.tgljweb.com/")[1].split("?")[0],  //图片
				sort:$(".sort").val(),    //排序
				itemId:id,  //id
				type:type
			}
		}else if((curLinkType==2)||(curLinkType==17)){
			//民宿列表、酒店列表（有省、市）
			param={
				title:$(".personTitle").val()||"", //标题
				linkType:curLinkType,//跳转类型
				country:$(".country").val()||"", //国家
				province:$(".province").val()||"", //省
				city: curCityCode,//市
                cityName:($(".city").val()!=0)?($(".city option:selected").text()):($(".province option:selected").text()),
				pic:$(".pic_url").val().split("http://img.tgljweb.com/")[1].split("?")[0]||"",  //图片
				sort:$(".sort").val()||"",    //排序
				itemId:id,  //id
				type:type
			}
		}else if(curLinkType==16){
			//旅游列表（路线、省、市）
			param={
				title:$(".personTitle").val()||"", //标题
				linkType:curLinkType,//跳转类型
				travelType:curTravelType_long,//旅游路线
				country:$(".country").val()||"",
				province:$(".province").val()||"",
				city: curCityCode,//市
                cityName:($(".city").val()!=0)?($(".city option:selected").text()):($(".province option:selected").text()),
				pic:$(".pic_url").val().split("http://img.tgljweb.com/")[1].split("?")[0]||"",  //图片
				sort:$(".sort").val()||"",    //排序
				itemId:id,  //id
				type:type
			}
		}else  if(curLinkType==14){
			param= {
				title:$(".personTitle").val(), //标题
				linkType:curLinkType,//跳转类型
				pic:$(".pic_url").val().split("http://img.tgljweb.com/")[1].split("?")[0],  //图片
				sort:$(".sort").val(),    //排序
				itemId:id,  //id
				type:type
			}
		}
        param.createBy=adminId;
       // console.log("新增",param);
		$.ajax({
			type: "POST",
			contentType:"application/json;charset=UTF-8",
			url:http_url + "/api/operate/addHomeCity",
			data:JSON.stringify(param),
			success: function(data){
				if(data.code==0){
					$('#myModal_add').modal('hide');
					getPersonList();
				}
			}
		})
	}

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
                //热门城市只显示中国的
				var countryList=data.data;
				var temp_html;
				/*for(var i=0;i<countryList.length;i++){
					temp_html+="<option value='"+countryList[i].cityCode+"'>"+countryList[i].cityName+"</option>";
				}*/
                temp_html+="<option value='"+countryList[0].cityCode+"'>"+countryList[0].cityName+"</option>";
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
					country();
					function country(){
						/*$.each(countryList,function(i,country){
							temp_html+="<option value='"+country.cityCode+"'>"+country.cityName+"</option>";
						});*/
                        temp_html+="<option value='"+countryList[0].cityCode+"'>"+countryList[0].cityName+"</option>";
						oCountry.html("<option value='0'>国家</option>"+temp_html);
						province();
					};
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
									changeCity();
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
                                                    $( $(".city").find("option")[1]).attr("selected",true)
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

//初始化图片
uploadImg(browse,container,".pic_url");

