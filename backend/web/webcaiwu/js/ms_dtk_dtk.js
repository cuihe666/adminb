/**
 * Created by JOJO on 2017/9/1.
 */
$(function(){
    getCity();//城市四级联动
    // 初始化搜索数据
    var searchData = {
        searchParams : {
            orderNum:$("#dtk_orderId").val(),// 订单单号
            timeType:$("#dtk_timeType").val(), //时间类型
            beginTime :$("#date_start").val(), //开始时间
            endTime:$("#date_end").val(), // 结束时间
            countryCode:$("#country").val(), //国家code
            cityCode:$("#city").val(), //城市code
            provinceCode:$("#province").val(), //省份code
            districtCode:$("#area").val(), //区code
            lodgerName:$("#dtk_lodgerName").val(), // 房客姓名
            lodgerMobile:$("#dtk_lodgerMobile").val(), // 房客手机
            landLordName:$("#dtk_landLordName").val(), //房东姓名
            landLordMobile:$("#dtk_landLordMobile").val(), //房东手机
            houseId:$("#dtk_houseId").val(), // 房源id
            payPlatform : $("#dtk_payPlatform").val(), // 支付方式
            orderType: 7,// 订单状态 - 待退款
            pageNum:1, //第几页
            pageSize:$(".pageSize").val()//每页几条
        },
        init : function(obj){
            var _this = this;
            $.each(obj, function(keys, val){
                _this.searchParams[keys] = val;
            })
        }
    };
    // console.log(searchData);
    var arr = []; // 用于保存选中的订单id
    var page = window.location.href.split("js_cn_")[1] || window.location.href.split("js_abroad_")[1];
    var page_type = 0;
    var page_arr = [];
    if(!page){
        page = window.location.href.split("js_partner_")[1];
        page_arr = ["dsh", "nopass", "dqr", "deny", "dfk", "fkz", "alljs"];
        page_type = page_arr.indexOf(page);
    }else{
        page_arr = ["fd_dsh", "fd_nopass", "fd_dqr", "fd_deny", "fd_dfk", "fd_fkz", "alljs"];
        page_type = page_arr.indexOf(page);
    }
    if(page == "fd_all" || page == "all"){
        page_type = "";
    }
    var http_url = serveUrl();
    // 默认请求的网址
    var url_init = "/api/order/house/refundorders";
    // 导出（全部）接口
    var export_init = "/api/order/house/exportAllData";
    // 请求数据渲染页面
    // 初始化页面所需的参数
    var data_init = {
        orderNum:$("#dtk_orderId").val(),// 订单单号
        timeType:$("#dtk_timeType").val(), //时间类型
        beginTime :$("#date_start").val(), //开始时间
        endTime:$("#date_end").val(), // 结束时间
        countryCode:$("#country").val(), //国家code
        cityCode:$("#city").val(), //城市code
        provinceCode:$("#province").val(), //省份code
        districtCode:$("#area").val(), //区code
        lodgerName:$("#dtk_lodgerName").val(), // 房客姓名
        lodgerMobile:$("#dtk_lodgerMobile").val(), // 房客手机
        landLordName:$("#dtk_landLordName").val(), //房东姓名
        landLordMobile:$("#dtk_landLordMobile").val(), //房东手机
        houseId:$("#dtk_houseId").val(), // 房源id
        orderType: 7,// 订单状态 - 待退款
        payPlatform : $("#dtk_payPlatform").val(), // 支付方式
        pageNum:1, //第几页
        pageSize:$(".pageSize").val()//每页几条

    };

    ajax_post(url_init, data_init);


    function se(){
        searchData.init({
            orderNum:$("#dtk_orderId").val(),// 订单单号
            timeType:$("#dtk_timeType").val(), //时间类型
            beginTime :$("#date_start").val(), //开始时间
            endTime:$("#date_end").val(), // 结束时间
            countryCode:$("#country").val(), //国家code
            cityCode:$("#city").val(), //城市code
            provinceCode:$("#province").val(), //省份code
            districtCode:$("#area").val(), //区code
            lodgerName:$("#dtk_lodgerName").val(), // 房客姓名
            lodgerMobile:$("#dtk_lodgerMobile").val(), // 房客手机
            landLordName:$("#dtk_landLordName").val(), //房东姓名
            landLordMobile:$("#dtk_landLordMobile").val(), //房东手机
            houseId:$("#dtk_houseId").val(), // 房源id
            orderType: 7,// 订单状态 - 待退款
            payPlatform : $("#dtk_payPlatform").val(), // 支付方式
            pageNum:$(".page_hid").val(), //第几页
            pageSize:$(".pageSize").val()//每页几条
        })
        ajax_post(url_init, searchData.searchParams);
    }
    // 点击搜索按钮
    $(".sear").on("click", function(){
        $(".page_hid").val("1");
        se();
    });

    // 点击清空按钮
    $(".clear_data").on("click", function(){
        $("#dtk_orderId").val(""),// 订单单号
            $("#dtk_timeType").val(1), //时间类型
            $("#date_start").val(""), //开始时间
            $("#date_end").val(""), // 结束时间
            $("#country").val(""), //国家code
            $("#city").val(""), //城市code
            $("#province").val(""), //省份code
            $("#area").val(""), //区code
            $("#dtk_lodgerName").val(""), // 房客姓名
            $("#dtk_lodgerMobile").val(""), // 房客手机
            $("#dtk_landLordName").val(""), //房东姓名
            $("#dtk_landLordMobile").val(""), //房东手机
            $("#dtk_houseId").val(""), // 房源id
            $("#dtk_payPlatform").val(""), // 支付方式
            $("#pageNum").val(), //第几页
            $("#pageSize").val()//每页几条
    });
    // 变换每页显示条数时
    $(".pageSize").on("change", function(){
        searchData.init({
            "pageNum": "1",
            "pageSize": $(".pageSize").val()
        });
        $(".page_hid").val("1");
        ajax_post(url_init, searchData.searchParams);
    });
    // 点击导出
    $("#export").on("click", function(){
        if(arr.length == 0){
            layer.alert("请选择要导出的订单!");
            return false;
        }else{
            var ids = "";
            for(var i = 0; i < arr.length; i++){
                if(i == arr.length - 1){
                    ids = ids + arr[i];
                    break;
                }
                ids = ids + arr[i] + ",";
            }
            window.location.href = http_url + "/api/order/house/exportData/" + ids;
        }
    });
    // 点击全选
    $("#box_all").click(function(){
        if(this.checked){
            $(this).parents("table").find(".checks").prop("checked","checked");
            for(var i = 0; i < $(".checks").length; i++){
                if(arr.indexOf($(".checks").eq(i).parent().find("input").eq(1).val()) < 0){
                    arr.push($(".checks").eq(i).parent().find("input").eq(1).val())
                }
            }
        }else {
            $(this).parents("table").find(".checks").removeAttr("checked","checked");
            for(var i = 0; i < $(".checks").length; i++){
                if(arr.indexOf($(".checks").eq(i).parent().find("input").eq(1).val()) >= 0){
                    arr.splice(arr.indexOf($(".checks").eq(i).parent().find("input").eq(1).val()), 1);
                }
            }
        }
        // console.log(arr);

    });
    // 点击上一页、下一页、首页、尾页
    $(".pro_next").each(function(index){
        $(".pro_next").eq(index).on("click", function(){
            if($(this).attr("class") != "pro_next disabled"){
                searchData.init({
                    "pageNum":  $(this).find("input").val(),
                    "pageSize": $(".pageSize").val()
                });
                $(".page_hid").val($(this).find("input").val());
                ajax_post(url_init, searchData.searchParams);
            }
        })
    });
    // 请求数据的函数
    function ajax_post(url, dat){
        $.ajax({
            type: "POST",
            contentType:"application/json;charset=UTF-8",
            url:http_url + url,
            data: JSON.stringify(dat),
            beforeSend: function(){
                $(".shade_wrap").css("display", "block");
            },
            success: function(res){
                $(".shade_wrap").css("display", "none");
                if(res.code == 0){
                    if(res.pageInfo.list.length == 0){
                        $(".cont tr").each(function(index){
                            if(index > 0){
                                $(this).remove();
                            }
                        });
                        $(".box_null").remove();
                        $(".form_table").append("<div class='box_null' style='width: 100%;text-align: center;background: #f5f5f5;margin-top: -20px;line-height: 40px;margin-bottom: 20px;'>暂时没有订单</div>");
                        layer.alert("暂时没有订单!");
                    }else{
                        $(".box_null").remove();
                        var tr = "";
                        $("#export_all").off("click");
                        $(".cont tr").each(function(index){
                            if(index > 0){
                                $(this).remove();
                            }
                        });
                        // 实现分页
                        if($(".pages")){
                            $(".pages").remove();
                        }
                        var page_num = parseInt(res.pageInfo.total) / parseInt($(".pageSize").val());
                        if(page_num >  parseInt(page_num)){
                            page_num =  parseInt(page_num) + 1;
                        }
                        // 首页尾页不能点击设置
                        if(res.pageInfo.pageNum == 1 && page_num != 1) {
                            $(".pro_next").eq(0).attr("class", "pro_next disabled");
                            $(".pro_next").eq(1).attr("class", "pro_next disabled");
                            $(".pro_next").eq(2).attr("class", "pro_next");
                            $(".pro_next").eq(3).attr("class", "pro_next");
                        }else if(res.pageInfo.pageNum == page_num && page_num != 1){
                            $(".pro_next").eq(0).attr("class", "pro_next");
                            $(".pro_next").eq(1).attr("class", "pro_next");
                            $(".pro_next").eq(2).attr("class", "pro_next disabled");
                            $(".pro_next").eq(3).attr("class", "pro_next disabled");
                        }else if(res.pageInfo.pageNum == 1 && page_num == 1){
                            $(".pro_next").eq(0).attr("class", "pro_next disabled");
                            $(".pro_next").eq(1).attr("class", "pro_next disabled");
                            $(".pro_next").eq(2).attr("class", "pro_next disabled");
                            $(".pro_next").eq(3).attr("class", "pro_next disabled");
                        }else{
                            $(".pro_next").eq(0).attr("class", "pro_next");
                            $(".pro_next").eq(1).attr("class", "pro_next");
                            $(".pro_next").eq(2).attr("class", "pro_next");
                            $(".pro_next").eq(3).attr("class", "pro_next");
                        }
                        $(".pro_next").eq(1).find("input").val(res.pageInfo.pageNum - 1);
                        $(".pro_next").eq(2).find("input").val(res.pageInfo.pageNum + 1);
                        $(".pro_next").eq(3).find("input").val(page_num);
                        $(".page_num").html(page_num);
                        if(page_num <= 5){
                            for(var i = page_num; i >= 1; i--){
                                $(".pro_next").eq(1).after("<li class='pages'><a>" + i + "</a></li>");
                            }
                            $(".pages a").css("background-color", "white");
                        }else{
                            if(res.pageInfo.pageNum <= 3){
                                for(var i = 5; i >= 1; i--){
                                    $(".pro_next").eq(1).after("<li class='pages'><a>" + i + "</a></li>");
                                }
                            }else if(res.pageInfo.pageNum < page_num - 2){
                                for(var i = res.pageInfo.pageNum + 2; i >= res.pageInfo.pageNum - 2; i--){
                                    $(".pro_next").eq(1).after("<li class='pages'><a>" + i + "</a></li>");
                                }
                            }else{
                                for(var i = page_num; i > page_num - 5; i--){
                                    $(".pro_next").eq(1).after("<li class='pages'><a>" + i + "</a></li>");
                                }
                            }
                            $(".pages a").css("background-color", "white");
                        }
                        $(".pages a").each(function(index){
                            if($(this).html() == res.pageInfo.pageNum){
                                $(this).css("background", "#ccc");
                            }
                        })
                        // 用来记录付款状态
                        var objS = {
                            "52":"退款待确认","54":"退款中","55":"退款完成","57":"待退款"
                        };
                        var obj_arr = {
                            "52":'<a>退款详情</a><a style="margin-right:10px;" >操作流水</a>',
                            "54":'<a>退款详情</a><a style="margin-right:10px;" >操作流水</a>',
                            "55":'<a>退款详情</a><a style="margin-right:10px;" >操作流水</a>',
                            "57":'<a>退款详情</a><a style="margin-right:10px;" >操作流水</a>',
                        };
                        // var settlement_status = ["结算待审核", "结算未通过", "结算待确认", "结算拒绝", "结算待付款", "结算失败", "付款中", "已付款"];
                        // // 用来记录操作栏里的按钮
                        // var operation_arr = ["<a data-toggle='modal' data-target='#myModal'>通过</a><a data-toggle='modal' data-target='#myModal'>拒绝</a><a data-toggle='modal' data-target='#myModal3'>操作流水</a>", "<a data-toggle='modal' data-target='#myModal'>重新审核</a><a data-toggle='modal' data-target='#myModal3'>操作流水</a>", "<a data-toggle='modal' data-target='#myModal'>通过</a><a data-toggle='modal' data-target='#myModal'>拒绝</a><a data-toggle='modal' data-target='#myModal3'>操作流水</a>", "<a data-toggle='modal' data-target='#myModal3'>操作流水</a>", "<a>付款确认</a><a data-toggle='modal' data-target='#myModal3'>操作流水</a>", "<a>再次付款</a><a data-toggle='modal' data-target='#myModal3'>操作流水</a>", "<a>付款详情</a><a data-toggle='modal' data-target='#myModal3'>操作流水</a>", "<a>付款详情</a><a data-toggle='modal' data-target='#myModal3'>操作流水</a>"];
                        // 用来记录支付方式
                        var pay_platform = ["","支付宝", "微信" , "银联"];
                        for(var x = 0; x < res.pageInfo.list.length; x++){
                            var dat = res.pageInfo.list[x];
                            var paytime = "";
                            if(dat.payTime){
                                paytime = "-"
                            }else{
                                paytime = TimeToDate(dat.payTime, "sfm");
                            }
                            tr = "<tr>" +

                                "<td colspan='11' style='text-align: left;'>" +
                                "<input type='checkbox' class='check_boxs checks'>" +
                                "<em>订单编号: " + dat.orderNum + "</em>" +
                                "<em>下单时间: " + TimeToDate(dat.orderTime,'sfm') + "</em>" +
                                "<em>支付时间: " + TimeToDate(dat.payTime,'sfm') + "</em>" +
                                "<em>申请退款时间:" +TimeToDate(dat.applyRefundTime,'sfm')+ "</em>" +
                                "<input type='hidden' value='" + dat.orderId + "'/>" +
                                "</td>" +
                                "</tr>" +
                                "<tr>"+
                                "<td>"+
                                "<span>"+dat.houseTitle+"</span>"+
                                "<span>房源ID: <i>"+dat.houseId+"</i></span>"+
                                "</td>"+
                                "<td>"+
                                "<span>"+dat.lodgerName+"</span>"+
                                "<span>"+dat.lodgerMobile+"</span>"+
                                "</td>"+
                                "<td>"+
                                "<span>"+dat.landlordName+"</span>"+
                                "<span>"+dat.landlordMobile+"</span>"+
                                "</td>"+
                                "<td>"+dat.cityName+"</td>"+
                                "<td>"+dat.bookHouseCount+"</td>"+
                                "<td>"+dat.total+"</td>"+
                                "<td>"+dat.refundAmount+"</td>"+
                                "<td>"+dat.actualAmount+"</td>"+
                                "<td>"+pay_platform[dat.payPlatform]+"</td>"+
                                "<td>"+objS[dat.orderStatus]+"</td>"+
                                "<td class='operation'>" + obj_arr[dat.orderStatus] +
                                "<input type='hidden' value='" + dat.orderId + "'/>" +
                                "<input type='hidden' value='" + dat.settlementType + "'/>" +
                                "<input type='hidden' value='" + dat.settlementStatus + "'/>" +
                                "<input type='hidden' value='" + dat.orderId + "'/>" +
                                "<input type='hidden' value='" + dat.orderStatus + "'/>" +
                                "<input type='hidden' value='" + dat.payPlatform + "'/>" +
                                "<input type='hidden' class='m_id' value=''/>" +
                                "<input type='hidden' class='m_type' value=''/>" +
                                "</td>" +
                                "</tr>";

                            $(".cont").append(tr);
                            $(".cont tr").last().find("td").each(function(index){
                                var htm = $.trim($(".cont tr").last().find("td").eq(index).html());
                                if(htm == "" || htm == "undefined" ){
                                    $(".cont tr").last().find("td").eq(index).html("-")
                                }
                            })
                            if($(".fd_name").last().find("span").eq(0).html() == "番茄来了"){
                                $(".fd_name").last().find("span").eq(0).css("color", "red");
                            }
                            for(var i = 0; i < arr.length; i++){
                                if(dat.orderId == arr[i]){
                                    $(".check_boxs").last().prop("checked", true);
                                    //$(".check_boxs").eq($(".check_boxs").length / 2 - 1).prop("checked", true);
                                    break;
                                }
                            }
                        }
                        // 换页后判断全选框状态
                        for(var i = 0; i < $(".checks").length; i++){
                            if(arr.indexOf($(".checks").eq(i).parent().find("input").eq(1).val()) < 0){
                                $("#box_all").removeAttr("checked");
                                break;
                            }
                            if(i == $(".checks").length - 1){
                                $("#box_all").prop("checked", true);
                                break;
                            }
                        }
                        // 点击分页器具体页数
                        $(".pages a").each(function(index){
                            $(".pages a").eq(index).on("click", function(){
                                searchData.init({
                                    "pageNum":  $(this).html(),
                                    "pageSize": $(".pageSize").val()
                                });
                                $(".page_hid").val($(this).html());
                                ajax_post(url_init, searchData.searchParams);
                            })
                        })
                        // 点击导出全部
                        $("#export_all").on("click", function(){
                            $("#myModa33").modal("show");
                            $("#myModa33 .modal-body").html("文件即将下载，请禁用浏览器弹出窗拦截器以确保正常下载，确定继续？");
                            $("#myModa33 .confirm").on("click", function() {
                                $("#myModa33").modal("hide");
                                var all_url = http_url + export_init + "?orderType=7";
                                // console.log(all_url)

                                if (searchData.searchParams.orderNum) {
                                    all_url = all_url + "&orderNum=" + searchData.searchParams.orderNum;
                                }
                                if (searchData.searchParams.timeType) {
                                    all_url = all_url + "&timeType=" + searchData.searchParams.timeType + "&beginTime=" + searchData.searchParams.beginTime + "&endTime=" + searchData.searchParams.endTime;
                                }
                                if (searchData.searchParams.beginTime) {
                                    all_url = all_url + "&timeType=" + searchData.searchParams.timeType + "&beginTime=" + searchData.searchParams.beginTime + "&endTime=" + searchData.searchParams.endTime;
                                }
                                if (searchData.searchParams.endTime) {
                                    all_url = all_url + "&timeType=" + searchData.searchParams.timeType + "&beginTime=" + searchData.searchParams.beginTime + "&endTime=" + searchData.searchParams.endTime;
                                }

                                if (searchData.searchParams.countryCode) {
                                    all_url = all_url + "&countryCode=" + searchData.searchParams.countryCode + "&cityCode=" + searchData.searchParams.cityCode + "&provinceCode=" + searchData.searchParams.provinceCode + "&districtCode=" + searchData.searchParams.districtCode;
                                }
                                if (searchData.searchParams.cityCode) {
                                    all_url = all_url + "&countryCode=" + searchData.searchParams.countryCode + "&cityCode=" + searchData.searchParams.cityCode + "&provinceCode=" + searchData.searchParams.provinceCode + "&districtCode=" + searchData.searchParams.districtCode;
                                }
                                if (searchData.searchParams.provinceCode) {
                                    all_url = all_url + "&countryCode=" + searchData.searchParams.countryCode + "&cityCode=" + searchData.searchParams.cityCode + "&provinceCode=" + searchData.searchParams.provinceCode + "&districtCode=" + searchData.searchParams.districtCode;
                                }
                                if (searchData.searchParams.districtCode) {
                                    all_url = all_url + "&countryCode=" + searchData.searchParams.countryCode + "&cityCode=" + searchData.searchParams.cityCode + "&provinceCode=" + searchData.searchParams.provinceCode + "&districtCode=" + searchData.searchParams.districtCode;
                                }
                                if (searchData.searchParams.lodgerName) {
                                    all_url = all_url + "&lodgerName=" + searchData.searchParams.lodgerName;
                                }
                                if (searchData.searchParams.lodgerMobile) {
                                    all_url = all_url + "&lodgerMobile=" + searchData.searchParams.lodgerMobile;
                                }
                                if (searchData.searchParams.landLordName) {
                                    all_url = all_url + "&landLordName=" + searchData.searchParams.landLordName;
                                }
                                if (searchData.searchParams.landLordMobile) {
                                    all_url = all_url + "&landLordMobile=" + searchData.searchParams.landLordMobile;
                                }
                                if (searchData.searchParams.houseId) {
                                    all_url = all_url + "&houseId=" + searchData.searchParams.houseId;
                                }
                                if (searchData.searchParams.payPlatform) {
                                    all_url = all_url + "&payPlatform=" + searchData.searchParams.payPlatform;
                                }
                                // console.log(all_url)
                                window.location.href = all_url;
                            })
                        })
                        // 点击选中一条数据
                        $(".check_boxs").each(function(index){
                            $(".check_boxs").eq(index).on("click", function(){
                                var ids = $(this).parent().find("input[type='hidden']").val();

                                if(arr.length == 0){
                                    arr.push(ids);
                                }else{
                                    for(var i = 0; i < arr.length; i++){
                                        if(ids == arr[i]){
                                            arr.splice(i, 1);
                                            break;
                                        }else if(i == arr.length - 1){
                                            arr.push(ids);
                                            break;
                                        }
                                    }
                                }
                                for(var i = 0; i < $(".checks").length; i++){
                                    if(arr.indexOf($(".checks").eq(i).parent().find("input").eq(1).val()) < 0){
                                        $("#box_all").removeAttr("checked");
                                        break;
                                    }
                                    if(i == $(".checks").length - 1){
                                        $("#box_all").prop("checked", true);
                                        break;
                                    }
                                }
                                // console.log(arr);
                            })
                        })
                        // 点击操作里面的按钮执行
                        $(".operation").each(function(index){
                            $(".operation").eq(index).find("a").each(function(ind){
                                $(this).on("click", function(){
                                    var pay_state = $(this).parent().find("input").eq(4).val();
                                    $(".md12_footer").html("")

                                    if(pay_state=="55"){
                                        add_btn = ' <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>'
                                        $(".md12_footer").append(add_btn);

                                    }else if(pay_state=="52"){
                                        add_btn = '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal3">确认退款</button>'+
                                            '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal4">拒绝退款</button>'
                                        $(".md12_footer").append(add_btn);
                                    }else{
                                        add_btn = '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModa23">退款</button>'+
                                            '<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>'
                                        $(".md12_footer").append(add_btn);
                                    }
                                    if($(this).html() == "退款详情" ){
                                        var pay_url = "/api/order/house/refundorders/";
                                        var pay_id = $(this).parent().find("input").eq(0).val();
                                        $(".m_id").val(pay_id);
                                        $(".m_type").val($(this).parent().find("input").eq(5).val());
                                        $.ajax({
                                            type: "GET",
                                            contentType:"application/json;charset=UTF-8",
                                            url:http_url + pay_url + pay_id,
                                            success: function(res){
                                                if(res.code == 0){
                                                    $("#myModal2").modal("show");
                                                    switch(res.data.refundOrder.refundRule){
                                                        case 1:
                                                            refundRule = '灵活: 入住前1天14：00点前取消预订可获得全额退款\n要获得全额住宿费用退款，房客必须在入住日期当天前1天14：00前取消预订。例如，如果入住日期是周五，则需在该周周四的14：00之前取消预订\n如果房客在入住日14：00前24小时内取消预订，首晚房费将不可退还\n如果房客已入住但决定提前退房，那么扣除未消费的头一天的房费，其余部分退还给房客  ';
                                                            break;
                                                        case 2:
                                                            refundRule = '中等: 入住前5天14：00点前取消预订可获得全额退款\n要获得住宿费用的全额退款，房客必须在入住日期，前5天14：00前取消预订。例如，如果入住日期是周五，则需在前一个周日的14：00之前取消预订\n如果房客提前不到5天退订，那么首晚房费将不可退还，但剩余的天数将退还50%的房费\n如果房客已入住但决定提前退房，那么扣除未消费的头一天的房费，其余部分50%退还给房客';
                                                            break;
                                                        case 3:
                                                            refundRule = '严格: 入住前1周14：00点前取消预订可获得50%退款\n要获得50%的住宿费用退款，房客必须在入住日期，前7天14：00前取消预订，否则不予退款。例如入住日期是周五，则需在前一个周五的14：00之前取消预订。\n如果房客未能在7天前取消预订，未住宿天数的房费将不予退还\n如果房客已入住但决定提前退房，剩余天数的房费将不予退还';
                                                            break;
                                                        case 4:
                                                            refundRule = '极严: 房客支付后取消预订将不退还任何费用';
                                                            break;
                                                        case "":
                                                            refundRule = '- ';
                                                    }
                                                    var coupon,refundCoupon;
                                                    if(res.data.refundOrder.useCoupon==true){
                                                        if(res.data.refundCoupon!=""){
                                                            coupon = '￥' + res.data.refundOrder.couponAmount + (res.data.useCoupon.name?'('+ res.data.useCoupon.name +')':"-");
                                                            refundCoupon ='￥' + res.data.refundOrder.couponAmount +   (res.data.refundCoupon.name?'('+ res.data.refundCoupon.name +')':"-");
                                                        }else{
                                                            coupon = '￥' + res.data.refundOrder.couponAmount + (res.data.useCoupon.name?'('+ res.data.useCoupon.name +')':"-");
                                                            refundCoupon =' - ';
                                                        }


                                                    }else if(res.data.refundOrder.usePromotion==true){
                                                        coupon = '￥' + res.data.refundOrder.couponAmount + (res.data.usePromotion.promotionRules?'('+ res.data.usePromotion.promotionRules +')':"-");
                                                        //refundCoupon ='￥' + res.data.refundOrder.couponAmount +   (res.data.usePromotion.promotionRules?'('+ res.data.usePromotion.promotionRules +')':"-");
                                                        refundCoupon =" - ";
                                                    }else {
                                                        coupon = ' - ';
                                                        refundCoupon =' - ';
                                                    }
                                                    var overManFee = res.data.refundOrder.overManFee ; // 超员费
                                                    var ischina = res.data.refundOrder.ischina; // 是否国内房源
                                                    if(!ischina){ // 海外收取清洁费
                                                        // 超员费如何收取
                                                        if(res.data.refundOrder.isOverManFee ==1){ // 不允许超员
                                                            overManFee='不允许超员';
                                                        } else if(res.data.refundOrder.isOverManFee ==2){ //线下收取超额费用
                                                            overManFee='￥'+overManFee+' (线下收取)</span>';
                                                        }else if(res.data.refundOrder.isOverManFee ==3) {//线上支付超额费用
                                                            overManFee = '￥' + overManFee + ' (线上支付)</span>';
                                                        }
                                                    }else{ // 国内
                                                        overManFee = "不收取超员费";
                                                    }
                                                    $(".js_pay td").eq(1).html(res.data.refundOrder.orderNum);
                                                    $(".js_pay td").eq(3).html(objS[res.data.refundOrder.orderStatus]);
                                                    $ (".js_pay td").eq(5).html(res.data.refundOrder.receiptNum);
                                                    $(".js_pay td").eq(7).html("");
                                                    $(".js_pay td").eq(9).html(TimeToDate(res.data.refundOrder.payTime,"sfm"));
                                                    $(".js_pay td").eq(11).html(TimeToDate(res.data.refundOrder.applyRefundTime,"sfm"));
                                                    $(".js_pay td").eq(13).html(res.data.refundOrder.lodgerName);
                                                    $(".js_pay td").eq(15).html(res.data.refundOrder.lodgerMobile);
                                                    $(".js_pay td").eq(17).html(pay_platform[res.data.refundOrder.payPlatform]);
                                                    $(".js_pay td").eq(19).html(res.data.refundOrder.transactionId);
                                                    $(".js_pay td").eq(21).html(getLocalTimeByMs(res.data.refundOrder.inTime) + "至" + getLocalTimeByMs(res.data.refundOrder.outTime) + "<br><br><span style='background-color:#dad5d5;padding: 5px'>共" + res.data.refundOrder.dayNum + "晚</span>");
                                                    $(".js_pay td").eq(23).html(refundRule);
                                                    $(".js_pay td").eq(25).html(res.data.refundOrder.total);
                                                    $(".js_pay td").eq(27).html(res.data.refundOrder.realRecAmount);
                                                    $(".js_pay td").eq(29).html(coupon);
                                                    $(".js_pay td").eq(31).html(res.data.refundOrder.cleanFee);
                                                    $(".js_pay td").eq(33).html(overManFee);
                                                    $(".js_pay td").eq(35).html(res.data.refundOrder.actualAmount);
                                                    $(".js_pay td").eq(37).html(refundCoupon);
                                                    $(".js_pay td").eq(39).html(TimeToDate(res.data.refundOrder.refundTime));
                                                    $(".js_pay td").eq(41).html(res.data.refundOrder.operateName);
                                                    $(".js_pay td").eq(43).html(res.data.refundOrder.refundNum);
                                                    $(".js_pay").find("td").each(function(index){
                                                        var htm = $.trim($(".js_pay").find("td").eq(index).html());
                                                        if(htm == "" || htm == "undefined" ){
                                                            $(".js_pay").find("td").eq(index).html("-")
                                                        }
                                                    })
                                                    //点击金额显示价格日历
                                                    $(".amount_cw").off().on("click", function(){
                                                        if(res.data.datePrice.length>0){
                                                            $(".dateCon").html("");
                                                            $("#myModal5").modal("show");

                                                            var td = "";
                                                            for(var i = 0; i < res.data.datePrice.length; i++){
                                                                td = "<td>" +
                                                                    "<span>"+getLocalTimeByWeek(res.data.datePrice[i].hotelDate,'sfm')+"</span><br><span>￥"+res.data.datePrice[i].raisePrice+"</span>"+
                                                                    "</td>";
                                                                $(".dateCon").append(td);
                                                            }

                                                        }else{

                                                            layer.alert("暂无价格详情明细");
                                                        }
                                                    })


                                                }else{
                                                    layer.alert("数据请求失败，请刷新重试!");
                                                }
                                            }
                                        })
                                    }else if($(this).html() == "操作流水")
                                    {
                                        var liushui_arr = ["正常订单", "退款申请中","退款待确认" , "", "退款中", "退款完成", "退款未通过（客服）", "待退款", "财务拒绝", "拒绝退款 "];
                                        var liushui_id = $(this).parent().find("input").eq(0).val();
                                        $.ajax({
                                            type: "GET",
                                            contentType:"application/json;charset=UTF-8",
                                            url:http_url + "/api/order/house/optLogs/" + liushui_id,
                                            success: function(res){
                                                $(".czls tr").each(function(index){
                                                    if(index > 0){
                                                        $(this).remove();
                                                    }
                                                });
                                                if(res.code == 0 && res.data!=""){
                                                    $("#myModal6").modal("show");
                                                    var ele = "";
                                                    for(var i = 0; i < res.data.length; i++){
                                                        ele = "<tr>" +
                                                            "<td>" + TimeToDate(res.data[i].createTime, "sfm") + "</td>" +
                                                            "<td>" + res.data[i].optUsername + "</td>" +
                                                            "<td>" + liushui_arr[res.data[i].beforeStatus] + "</td>" +
                                                            "<td>" + res.data[i].optEvent + "</td>" +
                                                            "<td>" + res.data[i].optComment + "</td>" +
                                                            "</tr>";
                                                        $(".czls").append(ele);
                                                        $(".czls tr").last().find("td").each(function(index){
                                                            var htm = $.trim($(".czls tr").last().find("td").eq(index).html());
                                                            if(htm == "" || htm == "undefined" ){
                                                                $(".czls tr").last().find("td").eq(index).html("-")
                                                            }
                                                        })
                                                    }
                                                }else{
                                                    layer.alert("暂无操作流水");
                                                }
                                            },
                                            error: function(){
                                                layer.alert("数据请求失败，请刷新重试!");
                                            }
                                        })
                                    }

                                })
                            })
                        })
                    }
                }else{
                    layer.alert(res.msg);
                }
            },
            error: function(){
                $(".shade_wrap").css("display", "none");
                layer.alert("数据请求失败!")
            }
        })
    }

    // 点击退款按钮   .dqr_tk
    $(".dqr_tk").on("click", function(){
        var url_ali = "/api/alipay/refund";
        var url_wec = "/api/unionpay/refund";
        var data = {
            orderId:$(".m_id").val(),
            optId:adminId
        }
        var type = $(".m_type").val();
        // console.log(type)
        if(type==2){   //微信
            $.ajax({
                type: "GET",
                contentType:"application/json;charset=UTF-8",
                // url:http_url + url_wec + '?orderId=' + $(".m_id").val() + '&optId=19' ,
                url:http_url + url_wec + '?orderId=' + $(".m_id").val() + '&optId='+ adminId ,
                success: function(res){
                    if(res.code == 0){
                        layer.alert("退款成功");
                        $("#myModal2").modal("hide");
                        $("#myModa23").modal("hide");
                    }else{
                        layer.alert(res.msg);
                        $("#myModal2").modal("hide");
                        $("#myModa23").modal("hide");
                    }
                    se();
                },
                error: function(){
                    layer.alert("数据请求失败，请刷新重试!");
                    $("#myModal2").modal("hide");
                    $("#myModa23").modal("hide");
                    // console.log(data)
                }
            })
        }else{        //支付宝
            $.ajax({
                type: "GET",
                contentType:"application/json;charset=UTF-8",
                // url:http_url + url_ali + '?orderId=' + $(".m_id").val() + '&optId=19' ,
                url:http_url + url_ali + '?orderId=' + $(".m_id").val() + '&optId='+ adminId ,
                success: function(res){
                    if(res.code == 0){
                        layer.alert("退款成功");
                        $("#myModal2").modal("hide");
                        $("#myModa23").modal("hide");
                    }else{
                        layer.alert(res.msg);
                        $("#myModal2").modal("hide");
                        $("#myModa23").modal("hide");
                    }
                    se();
                },
                error: function(){
                    layer.alert("数据请求失败，请刷新重试!");
                    $("#myModal2").modal("hide");
                    $("#myModa23").modal("hide");
                    // console.log(data)
                }
            })
        }


    });
    // 将日期格式转化为时间戳
    function change_time(dat){
        if(dat){
            dat = dat.replace("-", "/").replace("-", "/");
            var tim = "" + new Date(dat).getTime();
        }else{
            var tim = "";
        }
        return tim;
    }
    // 点击弹窗按钮发送请求
    function ajax_tc(url, dat){
        $.ajax({
            type: "POST",
            contentType:"application/json;charset=UTF-8",
            url:http_url + url,
            data: JSON.stringify(dat),
            success: function(res){
                if(res.code == 0){
                    window.location.href = window.location.href;
                }else{
                    layer.alert(res.msg);
                }
            },
            error: function(){
                layer.alert("数据请求失败，请刷新重试!");
            }
        })
    }
    //将时间戳转化为 月-日 （星期） 格式   @JO 2017/10/13
    function getLocalTimeByWeek(timestamp,argu){
        // var obj=new Date( parseInt(timestamp) );
        var date=new Date( parseInt(timestamp) );
        var month=gw_now_addzero(date.getMonth()+1);
        var day=gw_now_addzero(date.getDate());

        switch (date.getDay()) {
            case 0:week="星期天";break
            case 1:week="星期一";break
            case 2:week="星期二";break
            case 3:week="星期三";break
            case 4:week="星期四";break
            case 5:week="星期五";break
            case 6:week="星期六";break
        }
        var resultStr = month + "-" + day +  " " +"(" +week+")";
        if(argu) {
            resultStr = month + "-" + day +  " " +"(" +week+")";
        }
        if(!month || !day ||  !week) {
            resultStr = '暂无可选日期';
            return resultStr;
        }
        return resultStr;
    }
    function gw_now_addzero(temp){
        if(temp<10) return "0" + temp;
        else return temp;
    }
});
//城市四级联动
var getCity = function(){
    var cityurl = serveUrl()+'/api/dt/cityall';
    $.ajax({
        type:'GET',
        url:cityurl,
        data:'',
        beforeSend: function(){
            $("#load").fadeIn();
        },
        success:function(res){
            $("#load").fadeOut();

            //console.log(res);
            var country = res.data.nation;
            var province = res.data.province;
            var city = res.data.city;
            var area = res.data.area;
            var dataCountry=[];
            var dataProvince=[];
            var dataCity=[];
            var dataArea=[];
            dataCountry.push(
                '<select id="country">',
                '<option value="">国家</option>'
            );
            $.each(country,function(i,obj){
                dataCountry.push(
                    '<option value='+obj.code+'>'+obj.name+'</option>'
                );
            })
            dataCountry.push(
                '</select>'
            )
            $("#country").html('');
            $("#country").html(dataCountry.join(''));
            $("#country").on("change",function(){
                if($(this).val()!='10001'&& $(this).val()!=''){ // 中国四级 国外三级
                    $("#area").hide();
                }else{
                    $("#area").show();
                }
                dataProvince =[];
                dataCity =[];
                dataArea =[];
                dataProvince.push(
                    '<select id="province">',
                    '<option value="">省</option>'
                );
                $.each(province,function(i,obj){
                    if($("#country").val()==obj.parent) {
                        dataProvince.push(
                            '<option value=' + obj.code + '>' + obj.name + '</option>'
                        );
                    }
                })
                dataProvince.push(
                    '</select>'
                );
                $("#province").html('');
                $("#city").html('<option value="">市</option>');
                $("#area").html('<option value="">区</option>');
                $("#province").html(dataProvince.join(''));
            })
            $("#province").on("change",function(){
                $("#city").html('');
                $("#area").html('<option value="">区</option>');
                dataCity = [];
                dataArea = [];
                dataCity.push(
                    '<select id="city">',
                    '<option value="">市</option>'
                );
                $.each(city,function(i,obj){
                    if($("#province").val()==obj.parent) {
                        dataCity.push(
                            '<option value=' + obj.code + '>' + obj.name + '</option>'
                        );
                    }
                })
                dataCity.push(
                    '</select>'
                );
                $("#city").html(dataCity.join(''));
            })
            $("#city").on("change",function(){
                $("#area").html('');
                dataArea = [];
                dataArea.push(
                    '<select id="area">',
                    '<option value="">区</option>'
                );
                $.each(area,function(i,obj){
                    if($("#city").val()==obj.parent) {
                        dataArea.push(
                            '<option value=' + obj.code + '>' + obj.name + '</option>'
                        );
                    }
                })
                dataArea.push(
                    '</select>'
                );
                $("#area").html(dataArea.join(''));
            })
        },
        error:function(xhr) {
            // console.log('ajax error');
            // alert('ajax error');
        }
    });
}

