/**
 * Created by admin on 2017/11/9.
 */
var vm = new Vue({
    el: "#main",
    data: {
        http_url: serveUrl(), // 获取网址链接
        ids: window.location.href.split("id=")[1], // 判断是旅行特惠、自定义专题活动、或者城市列表那个页面进来的
        data_url: "/api/operate/editBannerById",
        cont: "", // 用来保存请求市的时候的传递的参数
        pro_code: "", // 用来保存国内省份的code码
        country_res: [],// 用来保存海外国家的数据
        pro_res: [], // 保存省份的数组
        city_res:{
            1: {
                "city_res": []
            },
            2: {
                "city_res": []
            },
            3: {
                "city_res": []
            },
            4: {
                "city_res": []
            },
            5: {
                "city_res": []
            },
            6: {
                "city_res": []
            },
            7: {
                "city_res": []
            },
            8: {
                "city_res": []
            },
            9: {
                "city_res": []
            },
            10: {
                "city_res": []
            },
            11: {
                "city_res": []
            },
            12: {
                "city_res": []
            }

        }, // 保存12组市的对象
        is_china: 0, // 判断是国内还是海外，从而控制编辑弹框内省市显示
        page_type: {
            12: {},
            13: {},
            14: {}
        },// 用来判断是那个页面进来的从而给出相应的数据
        use_num: 0, // 用于保存点击禁用、使用、删除的下标
        add_edit: 0, // 用来记录是新增还是编辑
        edit_dat: [], // 用来保存编辑页面的产品数组
        product_style: $(".li2").html(), // 页面产品的模板
        product_state: ["启用", "禁用"] // 产品的启用禁用状态
    },
    created: function(){
        console.log(this.ids);
        console.log(adminId);
        var _this = this;
        // 请求页面展示数据
        var dat = {
            id: this.ids
        };
        this.ajax_post(_this, this.data_url, dat);
        if(this.ids == 14){ // 旅行城市列表
            // 请求国内的省份数据
            this.get_provence(_this, {"parentCode": "10001"}, "/api/dt/getCityList");
            //请求海外的国家列表数据
            this.get_provence(_this, "", "/api/dt/getHotCountries");
        }
    },
    methods: {
        // 当为城市列表页时，进图页面调取省份和国家数据
        get_provence: function(th, dat, port_url){
            $.ajax({
                type: "POST",
                contentType:"application/json;charset=UTF-8",
                url: th.http_url + port_url,
                data: JSON.stringify(dat),
                success: function(res){
                    $(".wrap1").css("display", "none");
                    if(res.code == 0){
                        if(dat.parentCode == "10001"){ // 国内省份数据
                            th.pro_res = res.data;
                        }else { // 海外国家列表数据
                            th.country_res = res.data;
                        }

                    }else{
                        $(".wrap1").css("display", "none");
                        layer.alert("暂无省份!");
                    }
                },
                error: function(){
                    $(".wrap1").css("display", "none");
                    layer.alert("数据请求失败!");
                }
            });
        },
        // 当为城市列表页时，切换弹框里的省份或国家时触发
        pro_change: function(num, ele){
            var _this = this;
            this.pro_code = $(ele.target).val();
            this.cont = {
                "parentCode": _this.pro_code
            };
            $.ajax({
                type: "POST",
                contentType:"application/json;charset=UTF-8",
                url: _this.http_url + "/api/dt/getCityList",
                data: JSON.stringify(_this.cont),
                success: function(res){
                    if(res.code == 0){
                        _this.city_res[num].city_res = res.data;
                        $("#myModal1 .city").eq(num - 1).val("");
                    }else{
                        layer.alert("暂无省份!");
                    }
                },
                error: function(){
                    layer.alert("数据请求失败!");
                }
            });
        },
        // 当为城市列表页时，切换弹框里的城市的时候触发
        city_change: function(num){
            var _this = this;
            var city_name = "";
            for(var i = 0; i < _this.city_res[num].city_res.length; i++){
                if($("#myModal1 .city").eq(num - 1).val() == _this.city_res[num].city_res[i].cityCode){
                    city_name = _this.city_res[num].city_res[i].cityName;
                }
            }
            $("#myModal1 .class-name").eq(num - 1).val(city_name);
        },
        // 请求页面展示数据
        ajax_post:function(th, url, dat){
            $.ajax({
                type: "POST",
                contentType:"application/json;charset=UTF-8",
                url: th.http_url + url,
                data: JSON.stringify(dat),
                success: function(res){
                    $(".wrap1").css("display", "none");
                    if(res.code == 0){
                        th.page_type[th.ids] = res.data;
                    }else{
                        layer.alert(res.msg);
                    }
                },
                error: function(){
                    $(".wrap1").css("display", "none");
                    layer.alert("数据请求失败!");
                }
            })
        },
        // 点击操作里面的删除、使用、禁用
        dele_click: function(ele, ind){
            $("#myModal .opt").html($(ele.target).html());
            this.use_num = ind;
            $("#myModal").modal("show");
        },
        // 点击使用、禁用、删除弹框里面的确定
        submit_click: function(ele){
            var _this = this;
            var url = ""; // 用于保存请求网址
            var dat = {}; // 用于保存发送请求的参数
            if($(ele.target).parents(".modal-content").find(".opt").html() == "删除"){
                url = "/api/operate/deleteByid";
                dat = {
                    id: $(".table-bordered tr").eq(this.use_num + 1).find("td").last().find("input").val()
                };
            }else if($(ele.target).parents(".modal-content").find(".opt").html() == "使用"){
                url = "/api/operate/disablebyid";
                dat = {
                    id: $(".table-bordered tr").eq(this.use_num + 1).find("td").last().find("input").val(),
                    enabled: 1
                };
            }else if($(ele.target).parents(".modal-content").find(".opt").html() == "禁用"){
                url = "/api/operate/disablebyid";
                dat = {
                    id: $(".table-bordered tr").eq(this.use_num + 1).find("td").last().find("input").val(),
                    enabled: 0
                };
            }
            //return false;
            $.ajax({
                type: "POST",
                contentType:"application/json;charset=UTF-8",
                url: _this.http_url + url,
                data: JSON.stringify(dat),
                success: function(res){
                    if(res.code == 0){
                        layer.alert($(ele.target).parents(".modal-content").find(".opt").html() + "成功!");
                        _this.ajax_post(_this, _this.data_url, {id: _this.ids})
                    }else{
                        layer.alert(res.msg);
                    }
                },
                error: function(){
                    layer.alert("数据请求出错，请刷新重试!");
                }
            })


        },
        // 点击新增、编辑按钮
        edit_click: function(num, data, ele){// 参数分别是num(编辑(1)还是新增(0)),data(城市列表中国内还是海外,如果肥城市列表页，此参数无所谓),
            var _this = this;
            this.add_edit = num;
            if(this.ids == 12 || this.ids == 13){ // 旅行特惠、自定义专题活动
                $("#myModal2 .modal-header .tit").html("新增");
                // 清空弹框里的数据
                $("#myModal2 input").val("");
                $("#myModal2 select").val("1");
                $(".li4").remove();
                //return false;
                if(num == 1){
                    $("#myModal2 .modal-header .tit").html("编辑");
                    // 进行数据调取以及数据绑定
                    $("#myModal2 .subItemId").val($(ele.target).parent().find("input").val());
                    $.ajax({
                        type: "GET",
                        contentType:"application/json;charset=UTF-8",
                        url: _this.http_url + "/api/operate/getTravelProductLit?subItemId=" + $(ele.target).parent().find("input").val(),
                        success: function(res){
                            if(res.code == 0){
                                _this.edit_dat = res.data.operationTravleProductList;
                                // 进行数据绑定 时间还有点问题，需要解决
                                $("#myModal2 #date_start").val(_this.change_time(res.data.startTime, "sfm"));
                                $("#myModal2 #date_end").val(_this.change_time(res.data.endTime, "sfm"));
                                if(_this.ids == 13){ // 自定义专题模块的数据绑定
                                    $("#myModal2 .tit-name").val(res.data.title);
                                    $("#myModal2 .more-H5").val(res.data.linkUrl);
                                }
                                for(var n = 0; n < (res.data.operationTravleProductList.length - 1); n++){
                                    $(".li2").last().after("<li class='li2 li4'>" + _this.product_style + "<button style='margin-left: 20px;background: #1888F8;padding: 4px 10px;color: white;-webkit-border-radius: 4px;-moz-border-radius: 4px;border-radius: 4px;'>删除</button></li>");
                                    $(".li4").last().find("button").on("click", function(){
                                        $(this).parent().remove();
                                    });
                                }
                                for(var i = 0; i < res.data.operationTravleProductList.length; i++){
                                    $(".li2").eq(i).find(".travel-type").val(res.data.operationTravleProductList[i].travelType);
                                    $(".li2").eq(i).find(".product-id").val(res.data.operationTravleProductList[i].travelProductId);
                                    $(".li2").eq(i).find(".operationProductId").val(res.data.operationTravleProductList[i].id);
                                }
                                $("#myModal2").modal("show");
                            }else{
                                layer.alert(res.msg);
                            }
                        },
                        error: function(){
                            layer.alert("数据请求出错，请刷新重试!");
                        }
                    })
                }else{
                    $("#myModal2").modal("show");
                }

            }else if(this.ids == 14){ // 城市列表,只有编辑，不考虑新增num,num的值随意
                console.log(data);
                $("#myModal1 .list_id").val($(ele.target).parent().find("input").val());
                //调取数据绑定
                if($.trim($(ele.target).parents("tr").find("td").eq(0).html()) == "国内"){ // 国内
                    $("#myModal1 .modal-header span").html("国内");
                    this.is_china = 0;
                }else if($.trim($(ele.target).parents("tr").find("td").eq(0).html()) == "海外"){ // 海外
                    this.is_china = 1;
                    $("#myModal1 .modal-header span").html("海外");
                }
                $(".class-name").val("");
                $(".citylist_id").val("");
                $("#myModal1 select").val(""); // 清空弹框里面的select，如果有数据回填，则不需要此功能
                $.each(_this.city_res, function(keys,val){
                    _this.city_res[keys].city_res = [];
                });
                $.ajax({
                    type: "GET",
                    contentType: "application/json;charset=UTF-8",
                    url: _this.http_url + "/api/operate/getCityList?subItemId=" + data,
                    success: function (res) {
                        if(res.code == 0){
                            var parent_code = {};
                            var resu = res.data;
                            for(var i = 0; i < res.data.length; i++){
                                $("#myModal1 li").eq(i).find(".class-name").val(res.data[i].cityname);
                                if($.trim($(ele.target).parents("tr").find("td").eq(0).html()) == "国内"){
                                    $("#myModal1 li").eq(i).find(".provence").val(res.data[i].province);
                                }else{
                                    $("#myModal1 li").eq(i).find(".provence").val(res.data[i].country);
                                }
                                $("#myModal1 li").eq(i).find(".citylist_id").val(res.data[i].id);
                            }
                            //for(var k = 0; k < resu.length; k++){
                            $.each(resu, function(index, value){
                                if($.trim($(ele.target).parents("tr").find("td").eq(0).html()) == "国内"){
                                    parent_code = {
                                        "parentCode": resu[index].province
                                    };
                                }else{
                                    parent_code = {
                                        "parentCode": resu[index].country
                                    };
                                }
                                $.ajax({
                                    type: "POST",
                                    contentType:"application/json;charset=UTF-8",
                                    url: _this.http_url + "/api/dt/getCityList",
                                    data: JSON.stringify(parent_code),
                                    success: function(res){
                                        if(res.code == 0){
                                            var k = index + 1
                                            _this.city_res[k].city_res = res.data;
                                            setTimeout(function(){
                                                $("#myModal1 li").eq(index).find(".city").val(resu[index].city);
                                            }, 100);
                                        }else{
                                            layer.alert("暂无城市信息!");
                                        }
                                    },
                                    error: function(){
                                        layer.alert("数据请求失败!");
                                    }
                                });
                            })
                        }else{
                            layer.alert(res.msg);
                        }
                    },
                    error: function () {
                        layer.alert("数据请求失败，请刷新重试!");
                    }
                });
                $("#myModal1").modal("show");
            }
        },
        // 点击新增或编辑弹框里上面的新增按钮触发事件
        add_product: function(){
            if($(".li2").length < 5){
                $(".li2").last().after("<li class='li2 li4'>" + this.product_style + "<button style='margin-left: 20px;background: #1888F8;padding: 4px 10px;color: white;-webkit-border-radius: 4px;-moz-border-radius: 4px;border-radius: 4px;'>删除</button></li>");
            }else{
                layer.alert("最多添加5组产品!")
            };
            $(".li2").last().find("button").on("click", function(){
                $(this).parent().remove();
            })
        },
        // 点击新增、编辑弹窗里的确定,type为判断为城市列表里面的国内(0)还是国外(1)
        edit_submit: function(type){
            var _this = this;
            var edit_url = ""; // 编辑或者新增的接口
            var edit_data = {}; // 编辑或者新增的传递参数
            var edit_url = ""; // 编辑或者新增请求的接口
            var edit_arr = this.edit_dat;
            edit_msg = edit_arr;
            if(this.ids == 12 || this.ids == 13){ // 旅行特惠、自定义专题活动
                 edit_url = "/api/operate/saveTravelPreference"; // 默认写旅行特惠的
                var dat = {
                    startTime: this.to_millisecond($("#myModal2 #date_start").val()),
                    endTime: this.to_millisecond($("#myModal2 #date_end").val()),
                    createBy: adminId,
                    itemId: this.ids,
                    type: 2,
                    travleProductVo: []
                };
                if(this.ids == 13){
                    edit_url = "/api/operate/saveTravelThematic";
                    dat.linkUrl = $("#myModal2 .more-H5").val();
                    dat.title = $("#myModal2 .tit-name").val();
                    dat.linkType = 1;
                }
                if(this.add_edit == 0){ // 新增
                    dat.id = "";
                    for(var i = 0; i < $(".li2").length; i++){
                        if($.trim($(".li2 .product-id").eq(i).val()) != ""){
                            dat.travleProductVo.push({
                                "operationProductId": "",
                                "travelProductId": $.trim($(".li2 .product-id").eq(i).val()),
                                "travelType": $(".li2 .travel-type").eq(i).val(),
                                "editType": "1"
                            });
                        };
                    }
                }else { // 编辑
                    dat.id = $("#myModal2 .subItemId").val();
                    for(var i = 0; i < $(".li2").length; i++){
                        if($.trim($(".li2 .product-id").eq(i).val()) != ""){
                            if($(".li2 .operationProductId").eq(i).val() == ""){ // 新增的
                                dat.travleProductVo.push({
                                    "operationProductId": "",
                                    "travelProductId": $.trim($(".li2 .product-id").eq(i).val()),
                                    "travelType": $(".li2 .travel-type").eq(i).val(),
                                    "editType": "1"
                                });
                            }else{
                                for(var j = 0; j < edit_msg.length; j++){
                                    if($(".li2 .operationProductId").eq(i).val() == edit_msg[j].id){
                                        if($(".li2 .product-id").eq(i).val() != edit_msg[j].travelProductId || $(".li2 .travel-type").eq(i).val() != edit_msg[j].travelType){ // 修改的
                                            dat.travleProductVo.push({
                                                "operationProductId": edit_msg[j].id,
                                                "travelProductId": $.trim($(".li2 .product-id").eq(i).val()),
                                                "travelType": $(".li2 .travel-type").eq(i).val(),
                                                "editType": "2"
                                            });
                                            edit_msg.splice(j, 1);
                                        }else { // 未改变的
                                            edit_msg.splice(j, 1);
                                        }
                                    }
                                }
                            }
                        }
                    }
                    for(var k = 0; k < edit_msg.length; k++){ // 删除的
                        dat.travleProductVo.push({
                            "operationProductId": edit_msg[k].id,
                            "travelProductId": edit_msg[k].travelProductId,
                            "travelType": edit_msg[k].travelType,
                            "editType": "3"
                        });
                    }
                }
                //console.log(dat);
                //return false;
                if(dat.startTime == "" || dat.endTime == ""){
                    layer.alert("请完善生效日期!");
                    return false;
                }
                if(dat.travleProductVo.length < 3 && $(".li2").length < 3){
                    layer.alert("至少添加3组商品!");
                    return false;
                }
                if(this.add_edit == 0){ // 新增
                    if(dat.travleProductVo.length < 3){
                        layer.alert("请完善商品信息!");
                        return false;
                    }
                }else if(this.add_edit == 1){ // 删除
                    var val = 0;
                    for(var i = 0; i < $(".li2").length; i++){
                        if($(".li2").eq(i).find(".product-id").val() == ""){
                            val = 1;
                        }
                    }
                    if($(".li2").length < 3 || val == 1){
                        layer.alert("请完善商品信息!");
                        return false;
                    }
                }
                if(_this.ids == 13){ // 自定义专题活动的阻止
                    if(dat.title == ""){
                        layer.alert("请填写专题标题!");
                        return false;
                    }
                }
            }else{ // 城市列表
                console.log(type);
                edit_url = "/api/operate/savaCityList";
                var dat = {
                    createBy: adminId,
                    itemId: 14,
                    type: 4,
                    id: $("#myModal1 .list_id").val(),
                    cityList: []
                };
                //dat.id =
                for(var i = 0; i < $("#myModal1 .provence").length; i++){
                    dat.cityList[i] = {};
                    dat.cityList[i].cityname = $("#myModal1 .class-name").eq(i).val();
                    dat.cityList[i].id = $("#myModal1 .citylist_id").eq(i).val();
                    if($("#myModal1 .modal-header").find("span").html() == "国内"){
                        dat.cityList[i].city = $("#myModal1 .city").eq(i).val();
                        dat.cityList[i].province = $("#myModal1 .provence").eq(i).val();
                        dat.cityList[i].country = "10001";
                    }else{
                        dat.cityList[i].city = $("#myModal1 .city").eq(i).val();
                        dat.cityList[i].province = $("#myModal1 .city").eq(i).val();
                        dat.cityList[i].country = $("#myModal1 .provence").eq(i).val();
                    }
                    if(type == 0){
                        if(dat.cityList[i].province == ""){
                            layer.alert("请完善城市列表!");
                            return false;
                        }
                    }else{
                        if(dat.cityList[i].country == ""){
                            layer.alert("请完善城市列表!");
                            return false;
                        }
                    }
                    if(dat.cityList[i].cityName == "" || dat.cityList[i].city == ""){
                        layer.alert("请完善城市列表!");
                        return false;
                    }
                };
                $("#myModal1").modal("hide");
            }
            //console.log(JSON.stringify(dat));
            //return false;
            // 发送请求
            $.ajax({
                type: "POST",
                contentType:"application/json;charset=UTF-8",
                url: _this.http_url + edit_url,
                data: JSON.stringify(dat),
                success: function(res){
                    if(res.code == 0){
                        $("#myModal2").modal("hide");
                        layer.alert("数据更新成功!");
                        _this.ajax_post(_this, _this.data_url, {id: _this.ids});
                    }else{
                        layer.alert(res.msg);
                    }
                },
                error: function(){
                    layer.alert("数据更改失败!");
                }
            });
        },
        // 将时间转化为带十分秒的日期格式
        change_time: function(dat, sfm){
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
            var e;
            if(sfm){
                e = year + "-" + (month + 1) + "-" + da + " " + ho + ":" + min + ":" + sec;
            }else{
                e = year + "-" + (month + 1) + "-" + da;
            }

            return e;
        },
        // 将时间转化为时间戳
        to_millisecond: function(dat){
            if(dat){
                var millised = new Date(dat.replace("-", "/").replace("-", "/")).getTime();
                return millised;
            }else{
                return ""
            }
        }
    }
})