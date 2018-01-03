/**
 * Created by cuihe on 2017/8/23.
 */
$(function(){
    // 获得uid
    var uid = adminId ;
    // 初始化搜索数据
    var searchData = {
        pageType: ["fd_dsh", "fd_nopass", "fd_dqr", "fd_deny", "fd_dfk", "fd_fkz", "alljs"],
        searchParams : {
            settlementType: 1,
            settlementStatus: "",
            settlementNum: "",
            startDate: "",
            endDate: "",
            settlementUsid: "",
            settlementName: "",
            settlementMobile: "",
            pageNum: 1,
            pageSize: $(".pageSize").val(),
            dateState: 0
        },
        searchBtnClick:function(){
            var _this = this;

        },
        initSearchParamsAction:function(){
            var _this = this;
            //_this.searchParams
        },
        init : function(key, value){
            var _this = this;
            _this.searchParams[key] = value;
        }
    };
    var arr = []; // 用于保存选中的结算单id
    var page_state = ""; // 用于记录页面的结算状态，针对刷新
    var page = window.location.href.split("js_cn_")[1] || window.location.href.split("js_abroad_")[1];
    var page_type = "";
    var page_arr = [];
    if(!page){
        page = window.location.href.split("js_partner_")[1];
        if(page == "alljs"){
            page_type = 8;
        }
    }else{
        if(page == "alljs"){
            page_type = 8;
        }
    }
    if(page == "fd_all" || page == "all"){
        page_type = "";
    }
    if(page_type != 8){
        if(!location.hash.split("#")[1]){
            page_type = "";
        }else{
            page_type = location.hash.split("#")[1];
        }
    }
    //if(!window.location.href.split("?page_state=")[1]){
    //    page_type = "";
    //}else{
    //    page_type = window.location.href.split("?page_state=")[1];
    //}
    // 点击页面状态栏
    $(".tit_btn li").each(function(index){
        if(page_type == $(".tit_btn li").eq(index).attr("index")){
            $(".tit_btn li").eq(index).css({"background": "#3c8dbc", "border": "none"}).siblings().css({"background": "white", "border": "1px solid #666"});
            $(".tit_btn li").find("a").css("color", "black");
            $(".tit_btn li").eq(index).find("a").css("color", "white");
        }
        $(".tit_btn li").eq(index).on("click", function(){
            page_type = $(this).attr("index");
            location.hash = page_type;
            $(this).css({"background": "#3c8dbc", "border": "none"}).siblings().css({"background": "white", "border": "1px solid #666"});
            $(".tit_btn li").find("a").css("color", "black");
            $(this).find("a").css("color", "white");
            $(".to_page").val("1");
            $(".js_id").val("");
            $(".js_dateType").val(0);
            $("#date_start").val("");
            $("#date_end").val("");
            $(".fd_id").val("");
            $(".fd_name").val("");
            $(".fd_phone").val("");
            searchData.init("settlementStatus", page_type);
            searchData.init("settlementNum", $(".js_id").val());
            searchData.init("startDate", change_time($("#date_start").val()));
            searchData.init("endDate", change_time($("#date_end").val()));
            searchData.init("settlementUsid", $(".fd_id").val());
            searchData.init("settlementName", $(".fd_name").val());
            searchData.init("settlementMobile", $(".fd_phone").val());
            searchData.init("pageSize", $(".pageSize").val());
            searchData.init("dateState", $(".js_dateType").val());
            searchData.init("pageNum", 1);
            arr = [];
            ajax_post(url_init, searchData.searchParams);
        })
    });


    var http_url = serveUrl();
    // 默认请求的网址
    var url_init = "/api/finance/balance/getSettlementByCondition";
    // 导出接口
    var export_init = "/api/finance/balance/exportSettlementListAll";
    // 请求数据渲染页面
    // 初始化页面所需的参数
    var data_init = {
        settlementType: 1,
        settlementStatus: page_type,
        settlementNum: "",
        startDate: "",
        endDate: "",
        settlementUsid: "",
        settlementName: "",
        settlementMobile: "",
        pageNum: 1,
        pageSize: $(".pageSize").val(),
        dateState: 0
    };
    var aa = zc_store.get("caiwu_jsDetail", "obj");
    zc_store.remove("caiwu_jsDetail");
    //console.log(aa);
    if(aa){ // 由订单详情页进来的
        $(".to_page").val(aa.pageNum);
        data_init.pageNum = aa.pageNum;
        data_init.pageSize = aa.pageSize;

        searchData.init("pageNum", aa.pageNum);
        searchData.init("pageSize", aa.pageSize);

        data_init.dateState = $(".js_dateType").val();
        data_init.settlementNum = $(".js_id").val();
        data_init.startDate = change_time($("#date_start").val());
        data_init.endDate = change_time($("#date_end").val());
        data_init.settlementUsid = $(".fd_id").val();
        data_init.settlementName = $(".fd_name").val();
        data_init.settlementMobile = $(".fd_phone").val();
        data_init.settlementStatus = page_type;
        searchData.init("dateState", $(".js_dateType").val());
        searchData.init("settlementNum", $(".js_id").val());
        searchData.init("startDate", change_time($("#date_start").val()));
        searchData.init("endDate", change_time($("#date_end").val()));
        searchData.init("settlementUsid", $(".fd_id").val());
        searchData.init("settlementName", $(".fd_name").val());
        searchData.init("settlementMobile", $(".fd_phone").val());
        searchData.init("settlementStatus", page_type);

        $(".pageSize").val(aa.pageSize);
    }
    // 用于判断是从国内、海外、合伙人那种页面跳转过来的
    if(window.location.href.indexOf("js_cn") > 0){ // 国内
        searchData.init("settlementType", "1");
        data_init.settlementType = "1";
    }else if(window.location.href.indexOf("js_abroad") > 0){// 海外
        searchData.init("settlementType", "2");
        data_init.settlementType = "2";
    }else{ // 合伙人
        searchData.init("settlementType", "3");
        data_init.settlementType = "3";
    };
    ajax_post(url_init, data_init);
    // 点击搜索按钮
    $(".sear").on("click", function(){
        searchData.init("settlementStatus", page_type);
        searchData.init("settlementNum", $(".js_id").val());
        searchData.init("startDate", change_time($("#date_start").val()));
        searchData.init("endDate", change_time($("#date_end").val()));
        searchData.init("settlementUsid", $(".fd_id").val());
        searchData.init("settlementName", $(".fd_name").val());
        searchData.init("settlementMobile", $(".fd_phone").val());
        searchData.init("pageSize", $(".pageSize").val());
        searchData.init("dateState", $(".js_dateType").val());
        searchData.init("pageNum", 1);
        arr = [];
        ajax_post(url_init, searchData.searchParams);
    });
    // 点击清空按钮
    $(".clear_data").on("click", function(){
        $(".js_id").val("");
        $(".js_dateType").val(0);
        $("#date_start").val("");
        $("#date_end").val("");
        $(".fd_id").val("");
        $(".fd_name").val("");
        $(".fd_phone").val("");
        searchData.init("settlementStatus", page_type);
        searchData.init("settlementNum", $(".js_id").val());
        searchData.init("startDate", change_time($("#date_start").val()));
        searchData.init("endDate", change_time($("#date_end").val()));
        searchData.init("settlementUsid", $(".fd_id").val());
        searchData.init("settlementName", $(".fd_name").val());
        searchData.init("settlementMobile", $(".fd_phone").val());
        searchData.init("pageSize", $(".pageSize").val());
        searchData.init("dateState", $(".js_dateType").val());
        searchData.init("pageNum", 1);
        arr = [];
    });
    // 变换每页显示条数时
    $(".pageSize").on("change", function(){
        searchData.init("pageSize", $(".pageSize").val());
        searchData.init("settlementStatus", page_type);
        searchData.init("pageNum", "1");
        $(".to_page").val("1");
        ajax_post(url_init, searchData.searchParams);
    });
    // 点击导出
    $("#export").on("click", function(){
        if(arr.length == 0){
            layer.alert("请选择要导出的结算单!");
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
            window.location.href = http_url + "/api/finance/balance/exportSettlementListNotAll?ids=" + ids + "&type=" + searchData.searchParams.settlementType;
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
    });
    // 点击上一页、下一页、首页、尾页
    $(".pro_next").each(function(index){
        $(".pro_next").eq(index).on("click", function(){
            if($(this).attr("class") != "pro_next disabled"){
                searchData.init("pageSize", $(".pageSize").val());
                searchData.init("pageNum", $(this).find("input").val());
                $(".to_page").val($(this).find("input").val());
                searchData.init("settlementStatus", page_type);
                ajax_post(url_init, searchData.searchParams);
            }
        })
    });
    // 点击跳转到某一页
    $(".turn_pages").on("click", function(){
        var to_pages = $(".to_page").val();
        if(to_pages > $(".page_num").html()){
            layer.alert("结算单最多有" + $(".page_num").html() + "页!");
            return false;
        }
        if(to_pages == ""){
            layer.alert("请填写跳转页数!");
            return false;
        }else if(to_pages <= 0){
            layer.alert("页码大于0!");
            return false;
        }else{
            searchData.init("pageNum", to_pages);
            searchData.init("settlementStatus", page_type);
            ajax_post(url_init,searchData.searchParams)
        }
    })
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
                        $(".page_num").html("0");
                        $(".page_zero").remove();
                        $(".pages").remove();
                        $(".pro_next").eq(1).after("<li class='page_zero'><a>0</a></li>");
                        $(".pro_next").attr("class", "pro_next disabled");
                        $(".form_table").append("<div class='box_null' style='width: 100%;text-align: center;background: #f5f5f5;margin-top: -20px;line-height: 40px;margin-bottom: 20px;'>暂时没有结算单</div>");
                        layer.alert("暂时没有结算单!");
                    }else{
                        $(".box_null").remove();
                        $(".page_zero").remove();
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
                            if(res.pageInfo.pageNum == 1 && page_num != 1){
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
                        var settlement_status = ["", "结算待审核", "结算未通过", "结算待确认", "结算待付款", "结算失败", "结算拒绝", "", "已付款", "付款中"];
                        // 用来记录操作栏里的按钮
                        var operation_arr = ["", "<a data-toggle='modal' data-target='#myModal'>通过</a><a data-toggle='modal' data-target='#myModal'>拒绝</a><a>操作流水</a>",
                            "<a data-toggle='modal' data-target='#myModal'>重新审核</a><a>操作流水</a>",
                            "<a data-toggle='modal' data-target='#myModal'>通过</a><a data-toggle='modal' data-target='#myModal'>拒绝</a><a>操作流水</a>",
                            "<a>付款确认</a><a>操作流水</a>",
                            "<a>再次付款</a><a>操作流水</a>",
                            "<a>操作流水</a>",
                            "",
                            "<a>付款详情</a><a>操作流水</a>",
                            "<a>付款详情</a><a>操作流水</a>"];
                        // 用来记录支付方式
                        var pay_platforms = ["", "微信" ,"支付宝", "银联"];
                        for(var x = 0; x < res.pageInfo.list.length; x++){
                            var dat = res.pageInfo.list[x];
                            var paytime = "";
                            if(dat.payTime){
                                paytime = TimeToDate(dat.payTime, "sfm");
                            }else{
                                paytime = "-";
                            }
                            tr = "<tr>" +
                                "<td colspan='10' style='text-align: left;'>" +
                                "<input type='checkbox' class='check_boxs checks'>" +
                                "<em>结算ID: <a class='to_detail'>" + dat.settlementNum + "</a></em>" +
                                "<em>" + ((searchData.searchParams.settlementType == 3)?'合伙人':'房东') + "ID: " + dat.settlementUid + "</em>" +
                                "<em>结算日期: " + TimeToDate(dat.settlementTime, "sfm") + "</em>" +
                                "<em>付款日期: " + (dat.settlementStatus == 8?paytime:"-") + "</em>" +
                                "<input type='hidden' value='" + dat.id + "'/>" +
                                "</td>" +
                                "</tr>" +
                                "<tr class='trs'>" +
                                "<td class='fd_name'>" +
                                "<span>" + (dat.settlementName?dat.settlementName:'-') + "</span>" +
                                "<span>" + (dat.settlementMobile?dat.settlementMobile:'-') + "</span>" +
                                "</td>" +
                                "<td>" + pay_platforms[dat.receiptPlatform] + "</td>" +
                                "<td>" + dat.receiptAccount + "</td>" +
                                "<td>" + dat.dispositBank + "</td>" +
                                "<td>￥" + dat.recAmount + "</td>" +
                                "<td>￥" + dat.realRecAmount + "</td>" +
                                "<td>￥" + dat.couponAmount + "</td>" +
                                "<td>￥" + dat.refundAmount + "</td>" +
                                "<td>￥" + dat.settlementAmount + "</td>" +
                                "<td>" + settlement_status[dat.settlementStatus] + "</td>" +
                                "<td class='operation'>" + operation_arr[dat.settlementStatus] +
                                "<input type='hidden' value='" + dat.settlementNum + "'/>" +
                                "<input type='hidden' value='" + dat.settlementType + "'/>" +
                                "<input type='hidden' value='" + dat.settlementStatus + "'/>" +
                                "<input type='hidden' value='" + dat.id + "'/>" +
                                "<input type='hidden' value='" + dat.receiptPlatform + "'/>" +
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
                            if($(".trs").last().find("td").eq(9).html() == "付款中" || $(".trs").last().find("td").eq(9).html() == "已付款"){
                                $(".trs").last().find("td").eq(9).css("color", "red");
                            }
                            for(var i = 0; i < arr.length; i++){
                                if(dat.id == arr[i]){
                                    $(".check_boxs").last().prop("checked", true);
                                    //$(".check_boxs").eq($(".check_boxs").length / 2 - 1).prop("checked", true);
                                    break;
                                }
                            }
                        }
                        // 操作框里的按钮鼠标滑过时变成小手
                        $(".operation a").css("cursor", "pointer");
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
                                $(".to_page").val($(this).html());
                                searchData.init("pageSize", $(".pageSize").val());
                                searchData.init("pageNum", $(this).html());
                                searchData.init("settlementStatus", page_type);
                                ajax_post(url_init, searchData.searchParams);
                            })
                        })
                        // 点击导出全部
                        $("#export_all").on("click", function(){
                            $("#myModal").modal("show");
                            $("#myModal .modal-body").html("文件即将下载，请禁用浏览器弹出窗拦截器以确保正常下载，确定继续？");
                            $("#myModal .confirm").on("click", function(){
                                $("#myModal").modal("hide");
                                //console.log(searchData.searchParams.settlementType);
                                var all_url = http_url + export_init + '?settlementType=' + searchData.searchParams.settlementType + "&type=" + searchData.searchParams.settlementType;
                                if(page_type != 0){
                                    all_url = all_url + "&settlementStatus=" + page_type;
                                }
                                //var all_url = http_url + export_init + '?settlementType=0&startDate=' + searchData.searchParams.startDate + '&endDate=' + searchData.searchParams.endDate;
                                if(searchData.searchParams.settlementMobile){
                                    all_url = all_url + "&settlementMobile=" + searchData.searchParams.settlementMobile;
                                }
                                if(searchData.searchParams.settlementName){
                                    all_url = all_url + "&settlementName=" + searchData.searchParams.settlementName;
                                }
                                if(searchData.searchParams.settlementUsid){
                                    all_url = all_url + "&settlementUsid=" + searchData.searchParams.settlementUsid;
                                }
                                if(searchData.searchParams.settlementNum){
                                    all_url = all_url + "&settlementNum=" + searchData.searchParams.settlementNum;
                                }
                                if(searchData.searchParams.dateState){
                                    all_url = all_url + "&dataState=" + searchData.searchParams.dateState;
                                }
                                if(searchData.searchParams.startDate){
                                    all_url = all_url + "&startDate=" + searchData.searchParams.startDate;
                                }
                                if(searchData.searchParams.endDate){
                                    all_url = all_url + "&endDate=" + searchData.searchParams.endDate;
                                }
                                window.location.href = all_url;
                                $("#myModal .confirm").off("click")
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
                            })
                        })
                        // 点击操作里面的按钮执行
                        $(".operation").each(function(index){
                            $(".operation").eq(index).find("a").each(function(ind){
                                $(this).off().on("click", function(){
                                    if($(this).html() == "通过"){
                                        $(".clo").html("取消");
                                        $(".confirm").html("确定");
                                        $(".confirm").removeAttr("data-toggle");
                                        $(".confirm").removeAttr("data-target");
                                        $(".clo").removeAttr("data-toggle", "modal");
                                        $(".clo").removeAttr("data-target", "#myModal1");
                                        $("#myModalLabel").html("结算审核");
                                        $(".confirm").off("click");
                                        $(".clo").off("click");
                                        var set_num = $(this).parent().find("input").eq(0).val();
                                        var set_type = $(this).parent().find("input").eq(1).val();
                                        //console.log($(this).parent().find("input").eq(2).val())
                                        if($(this).parent().find("input").eq(2).val() == 1){
                                            $("#myModal .modal-body").html("审核通过后，等待财务确认，您确定吗？");
                                            $(".confirm").on("click", function(){
                                                var pass_url = "/api/finance/balance/audit/agree";
                                                var pass_dat = {
                                                    settlementNum: set_num,
                                                    //settlementType: set_type,
                                                    userId: uid
                                                }
                                                ajax_tc(pass_url, pass_dat);
                                            })
                                        }else{
                                            $("#myModal .modal-body").html("审核通过后，等待财务付款，您确定吗？");
                                            $(".confirm").on("click", function(){
                                                var caiwu_pass = "/api/finance/balance/reaudit/agree";
                                                var caiwu_data = {
                                                    settlementNum: set_num,
                                                    //settlementType: set_type,
                                                    userId: uid
                                                };
                                                ajax_tc(caiwu_pass, caiwu_data);
                                            })
                                        }
                                    }else if($(this).html() == "拒绝"){
                                        $("#myModalLabel").html("拒绝理由");
                                        $(".clo").html("取消");
                                        $(".confirm").html("确定");
                                        $(".confirm").off("click");
                                        $(".clo").off("click");
                                        $(".clo").attr("data-toggle", "");
                                        $(".clo").attr("data-target", "");
                                        var set_num = $(this).parent().find("input").eq(0).val();
                                        var set_type = $(this).parent().find("input").eq(1).val();
                                        if($(this).parent().find("input").eq(2).val() == 1){
                                            $("#myModal .modal-body").html("拒绝后，结算单将进入结算拒绝列表，您确定吗？" + "<textarea placeholder='备注' style='resize: none;width: 310px;height: 50px;display: block;margin: 10px auto;'></textarea>");
                                            $(".confirm").on("click", function(){
                                                if($.trim($("#myModal textarea").val()) == ""){
                                                    layer.alert("请填写拒绝理由!");
                                                    return false;
                                                }
                                                var dely_url = "/api/finance/balance/audit/refuse";
                                                var dely_dat = {
                                                    settlementNum: set_num,
                                                    //settlementType: set_type,
                                                    userId: uid,
                                                    optComment: $("#myModal textarea").val()
                                                }
                                                ajax_tc(dely_url, dely_dat);
                                            })
                                        }else{
                                            $("#myModal .modal-body").html("<textarea placeholder='备注(必填)' style='resize: none;width: 310px;height: 50px;display: block;margin: 10px auto;'></textarea>")
                                            $(".confirm").on("click", function(){
                                                if($.trim($("#myModal textarea").val()) == ""){
                                                    layer.alert("请填写拒绝理由!");
                                                    return false;
                                                }
                                                var caiwu_dely = "/api/finance/balance/reaudit/refuse";
                                                var caiwu_delyDate = {
                                                    settlementNum: set_num,
                                                    //settlementType: set_type,
                                                    userId: uid,
                                                    optComment: $("#myModal textarea").val()
                                                };
                                                ajax_tc(caiwu_dely, caiwu_delyDate);
                                            })
                                        }

                                    }else if($(this).html() == "重新审核"){
                                        $("#myModalLabel").html("重审理由");
                                        $("#myModal .modal-body").html("<textarea placeholder='备注' style='resize: none;width: 310px;height: 80px;display: block;margin: 10px auto;'></textarea>");
                                        $(".clo").html("拒绝");
                                        $(".confirm").html("通过");
                                        $(".confirm").attr("data-toggle", "modal");
                                        $(".confirm").attr("data-target", "#myModal1");
                                        $(".clo").attr("data-toggle", "modal");
                                        $(".clo").attr("data-target", "#myModal1");
                                        $("#myModal1 .modal-footer").find("input").eq(0).val($(this).parent().find("input").eq(0).val());
                                        $("#myModal1 .modal-footer").find("input").eq(1).val($(this).parent().find("input").eq(1).val());
                                        $(".confirm").off("click");
                                        $(".confirm").on("click", function(){
                                            if($.trim($("#myModal textarea").val()) == ""){
                                                layer.alert("请填写重申理由!");
                                                return false;
                                            };
                                            $("#myModal1 .modal-title").html("结算审核:");
                                            $("#myModal1 .modal-body").html("审核通过后，等待财务确认，您确定吗？");
                                            $("#myModal1 .confirm1").off("click");
                                            $("#myModal1 .confirm1").on("click", function(){
                                                var pass_url = "/api/finance/balance/audit/agree";
                                                var pass_dat = {
                                                    settlementNum: $("#myModal1 .modal-footer").find("input").eq(0).val(),
                                                    settlementType: $("#myModal1 .modal-footer").find("input").eq(1).val(),
                                                    userId: uid,
                                                    optComment: $("#myModal textarea").val()
                                                };
                                                ajax_tc(pass_url, pass_dat);
                                            })
                                        });
                                        $(".clo").on("click", function(){
                                            if($.trim($("#myModal textarea").val()) == ""){
                                                layer.alert("请填写重申理由!");
                                                return false;
                                            }
                                            $("#myModal1 .modal-title").html("结算审核:");
                                            $("#myModal1 .modal-body").html("拒绝后，结算单将进入结算拒绝列表，您确定吗？");
                                            $("#myModal1 .confirm1").off("click");
                                            $("#myModal1 .confirm1").on("click", function(){
                                                var dely_url = "/api/finance/balance/audit/refuse";
                                                var dely_dat = {
                                                    settlementNum: $("#myModal1 .modal-footer").find("input").eq(0).val(),
                                                    settlementType: $("#myModal1 .modal-footer").find("input").eq(1).val(),
                                                    userId: uid,
                                                    optComment: $("#myModal textarea").val()
                                                };
                                                ajax_tc(dely_url, dely_dat);
                                            });
                                        });
                                    }else if($(this).html() == "付款确认" || $(this).html() == "再次付款"){
                                        var tit_cont = $(this).html();
                                        var this_type = $(this).html();
                                        var pay_url = "/api/finance/balance/paymentInfo/";
                                        var pay_id = $(this).parent().find("input").eq(0).val();
                                        var _ids = $(this).parent().find("input").eq(3).val();
                                        var pay_type = $(this).parent().find("input").eq(1).val();
                                        var pay_platform = $(this).parent().find("input").eq(4).val();
                                        var btn_this = $(this);
                                        $.ajax({
                                            type: "GET",
                                            contentType:"application/json;charset=UTF-8",
                                            url:http_url + pay_url + pay_id,
                                            success: function(res){
                                                if(res.code == 0){

                                                    $("#myModal2").modal("show");
                                                    $("#myModal2 h4").html(tit_cont)
                                                    $(".fkz").remove();
                                                    $(".js_pay td").eq(34).html("");
                                                    $(".js_pay td").eq(1).html(res.data.settlementNum);
                                                    $(".js_pay td").eq(3).html(settlement_status[res.data.settlementStatus]);
                                                    $(".js_pay td").eq(5).html(TimeToDate(res.data.settlementTime, "sfm"));
                                                    $(".js_pay td").eq(7).html("-");
                                                    $(".js_pay td").eq(9).html(res.data.settlementName);
                                                    $(".js_pay td").eq(11).html(res.data.settlementMobile);
                                                    $(".js_pay td").eq(13).html(res.data.receiptName);
                                                    $(".js_pay td").eq(15).html(res.data.receiptMobile);
                                                    $(".js_pay td").eq(17).html(res.data.receiptPlatform?pay_platforms[res.data.receiptPlatform]:"-");
                                                    $(".js_pay td").eq(19).html(res.data.receiptAccount);
                                                    $(".js_pay td").eq(21).html(res.data.dispositBank);
                                                    $(".js_pay td").eq(23).html("￥" + res.data.recAmount);
                                                    $(".js_pay td").eq(25).html("￥" + res.data.realRecAmount);
                                                    $(".js_pay td").eq(27).html("￥" + res.data.couponAmount);
                                                    $(".js_pay td").eq(29).html("￥" + res.data.refundAmount);
                                                    $(".js_pay td").eq(31).html("￥" + res.data.settlementAmount);
                                                    $(".js_pay td").eq(33).html("-");
                                                    $(".js_pay td").eq(34).html("");
                                                    $(".js_pay .pay_namer").html("")
                                                    $("#myModal2 .third_ls").remove();
                                                    $("#myModal2 .modal-footer").css("text-align", "center")
                                                    $("#myModal2 .btn-primary").css("display", "inline-block");
                                                    $("#myModal2 .btn-default").html("取消");
                                                    $("#myModal2 .confirm").off("click");
                                                    $("#myModal #myModalLabel").html("结算付款");
                                                    // 如果收款账户为空时，不能付款
                                                    var is_all = true; // 此参数用来判定付款信息是否完全
                                                    if(res.data.receiptAccount == ""){
                                                        $("#myModal .modal-body").html("暂无收款账户信息，请线下支付!");
                                                        is_all = false;
                                                    }else{
                                                        if(pay_platform == 3){
                                                            var cont = "<ul style='width: 76%;margin: 0 auto;height: 56px;'>" +
                                                                    "<li style='float: left;width: 50%;text-align: left'>" +
                                                                        "<input checked='checked' type='radio' name='pay_type' id='pay_type1' value='04900'/>" +
                                                                        "<label for='pay_type1'>其他代付</label>" +
                                                                    "</li>" +
                                                                    "<li style='float: left;width: 50%;text-align: left'>" +
                                                                        "<input type='radio' name='pay_type' id='pay_type2' value='09201'/>" +
                                                                        "<label for='pay_type2'>退款</label>" +
                                                                    "</li>" +
                                                                    "<li style='float: left;width: 50%;text-align: left'>" +
                                                                        "<input type='radio' name='pay_type' id='pay_type3' value='06601'/>" +
                                                                        "<label for='pay_type3'>测试代付业务</label>" +
                                                                    "</li>" +
                                                                    //"<li style='float: left;width: 50%;text-align: left'>" +
                                                                    //    "<input type='radio' name='pay_type' id='pay_type4' value='09904'/>" +
                                                                    //    "<label for='pay_type4'>汇款</label>" +
                                                                    //"</li>" +
                                                                "</ul>" +
                                                                "<div>确认后，结算款将支付给商家，请核对账号信息正确</div>";
                                                            $("#myModal .modal-body").html(cont);
                                                            ($("#myModal input[name='pay_type']").eq(0)).prop("checked", true);
                                                        }else{
                                                            $("#myModal .modal-body").html("确认后，结算款将支付给商家，请核对账号信息正确");
                                                        }
                                                    }
                                                    $("#myModal .confirm").off().on("click", function(){
                                                        if(!is_all){
                                                            $("#myModal").modal("hide");
                                                            return false;
                                                        };
                                                        var pay_dat = {
                                                            settleId: _ids,
                                                            optId: uid
                                                        };
                                                        //console.log(pay_dat); return false;
                                                        if(pay_platform == 3){ // 银联
                                                                for(var i = 0; i < $("#myModal input[name='pay_type']").length; i++){
                                                                    if(($("#myModal input[name='pay_type']").eq(i)).prop("checked") == true){
                                                                        pay_dat.businessCode = $("#myModal input[name='pay_type']").eq(i).val();
                                                                    }
                                                                };
                                                                $("#myModal").modal("hide");
                                                                //console.log(pay_dat);
                                                                //return false;
                                                                $.ajax({
                                                                    type: "POST",
                                                                    contentType:"application/json;charset=UTF-8",
                                                                    url:http_url + "/api/unionpay/transfer/pay",
                                                                    data: JSON.stringify(pay_dat),
                                                                    beforeSend: function(){
                                                                        $(".shade_wrap").css("display", "block");
                                                                    },
                                                                    success: function(res){
                                                                        $(".shade_wrap").css("display", "none");
                                                                        if(res.code == 0){
                                                                            layer.alert("支付成功!", {
                                                                                time: 2000,
                                                                            })
                                                                            window.location.reload();
                                                                        }else{
                                                                            layer.alert(res.msg);
                                                                        }
                                                                    },
                                                                    error: function(){
                                                                        $(".shade_wrap").css("display", "none");
                                                                        layer.alert("支付失败，请再次尝试!");
                                                                    }
                                                                });
                                                        }else if(pay_platform == 2){// 支付宝
                                                            //console.log(pay_dat);
                                                            $("#myModal").modal("hide");
                                                            //return false;
                                                            $.ajax({
                                                                type: "POST",
                                                                contentType:"application/json;charset=UTF-8",
                                                                url:http_url + "/api/alipay/transfer/alipay",
                                                                data: JSON.stringify(pay_dat),
                                                                beforeSend: function(){
                                                                    $(".shade_wrap").css("display", "block");
                                                                },
                                                                success: function(res){
                                                                    $(".shade_wrap").css("display", "none");
                                                                    if(res.code == "0000"){
                                                                        layer.alert("支付成功!", {
                                                                            time: 2000,
                                                                        })
                                                                        window.location.reload();
                                                                    }else{
                                                                        layer.alert(res.msg);
                                                                    }
                                                                },
                                                                error: function(){
                                                                    $(".shade_wrap").css("display", "none");
                                                                    layer.alert("支付失败，请再次尝试!");
                                                                }
                                                            })
                                                        }else if(pay_platform == 1){// 微信
                                                            layer.alert("暂不支持该支付方式，请选择其他支付方式!");
                                                        }else{
                                                            layer.alert("支付方式有误!");
                                                        }
                                                    })
                                                }else{
                                                    layer.alert(res.msg);
                                                }
                                            }
                                        })
                                    }else if($(this).html() == "付款详情"){
                                        var pay_url = "/api/finance/balance/paymentInfo/";
                                        var pay_id = $(this).parent().find("input").eq(0).val();
                                        var btn_cont = $(this).parents("tr").find("td").eq(9).html();
                                        var _ids = $(this).parent().find("input").eq(3).val();
                                        var btn_this = $(this);
                                        var pay_state = "";
                                        if(btn_cont == "付款中"){ // 付款中
                                            var search_payUrl = "";
                                            if($(this).parent().find("input").eq(4).val() == 3){ // 银联
                                                search_payUrl = "/api/unionpay/transfer/query";
                                            }else{ // 支付宝
                                                search_payUrl = "/api/alipay/transfer/alipay/query";
                                            }
                                            var pay_dat = {
                                                settleId: _ids,
                                                optId: uid
                                            };
                                            $.ajax({
                                                type: "POST",
                                                contentType: "application/json;charset=UTF-8",
                                                url: http_url + search_payUrl,
                                                data: JSON.stringify(pay_dat),
                                                success: function (res) {
                                                    // ？？？？？？返回状态code为0时，是代表付款成功？如果是，那怎么判定是付款中，关系到后面的弹框以及页面展示
                                                    if(res.code == 0){
                                                        //$(btn_this).parents("tr").find("td").eq(9).html("已付款");
                                                        pay_state = "付款中";
                                                        pay_detail(pay_url, pay_id, btn_cont, settlement_status, pay_platforms, pay_state);
                                                    }else{
                                                        //pay_state = "付款中";
                                                        layer.alert(res.msg);
                                                    }
                                                },
                                                error:function(){
                                                    layer.alert("请求失败，请刷新重试!")
                                                }
                                            })
                                        }else{ // 付款成功
                                            pay_state = "付款详情";
                                            pay_detail(pay_url, pay_id, btn_cont, settlement_status, pay_platforms, pay_state);
                                        }


                                    }else if($(this).html() == "操作流水"){
                                        var liushui_id = $(this).parent().find("input").eq(3).val();
                                        $.ajax({
                                            type: "GET",
                                            contentType:"application/json;charset=UTF-8",
                                            url:http_url + "/api/finance/balance/logs/" + liushui_id,
                                            success: function(res){
                                                $(".czls tr").each(function(index){
                                                    if(index > 0){
                                                        $(this).remove();
                                                    }
                                                });
                                                if(res.code == 0){
                                                    if(res.data.length > 0){
                                                        $("#myModal3").modal("show");
                                                        var ele = "";
                                                        for(var i = 0; i < res.data.length; i++){
                                                            ele = "<tr>" +
                                                                "<td>" + TimeToDate(res.data[i].createTime, "sfm") + "</td>" +
                                                                "<td>" + res.data[i].optUsername + "</td>" +
                                                                "<td>" + (res.data[i].beforeStatus == 0?"创建结算单":settlement_status[res.data[i].beforeStatus]) + "</td>" +
                                                                "<td>" + res.data[i].optEvent + "</td>" +
                                                                "<td>" + res.data[i].optComment + "</td>" +
                                                                "</tr>";
                                                            $(".czls").append(ele);
                                                        }
                                                    }else{
                                                        layer.alert("暂无操作流水!");
                                                    }
                                                }else{
                                                    $("#myModal3 .modal-body").html(res.msg)
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
                        // 点击id,跳转到详情页
                        $(".to_detail").each(function(index){
                            $(".to_detail").eq(index).on("click", function(){
                                zc_store.set("caiwu_jsDetail", {pageNum: searchData.searchParams.pageNum, pageSize: searchData.searchParams.pageSize})
                                window.location.href = $(".href_inp").val() + "?id=" + $(this).html() + "&type=" + searchData.searchParams.settlementType;
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
    // 付款详情查询
    function pay_detail(pay_url, pay_id, btn_cont, settlement_status, pay_platforms, pay_state){
        $.ajax({
            type: "GET",
            contentType:"application/json;charset=UTF-8",
            url:http_url + pay_url + pay_id,
            success: function(res){
                if(res.code == 0){
                    $("#myModal2").modal("show");
                    $("#myModal2 h4").html(settlement_status[res.data.settlementStatus]);
                    $(".js_pay td").eq(1).html(res.data.settlementNum);
                    $(".js_pay td").eq(3).html(settlement_status[res.data.settlementStatus]);
                    $(".js_pay td").eq(5).html(TimeToDate(res.data.settlementTime, "sfm"));
                    $(".js_pay td").eq(7).html((res.data.payTime)?TimeToDate(res.data.payTime, "sfm"):"-");
                    $(".js_pay td").eq(9).html(res.data.settlementName?res.data.settlementName:'-');
                    $(".js_pay td").eq(11).html(res.data.settlementMobile?res.data.settlementMobile:'-');
                    $(".js_pay td").eq(13).html(res.data.receiptName?res.data.receiptName:'-');
                    $(".js_pay td").eq(15).html(res.data.receiptMobile?res.data.receiptMobile:'-');
                    $(".js_pay td").eq(17).html(res.data.receiptPlatform?pay_platforms[res.data.receiptPlatform]:'-');
                    $(".js_pay td").eq(19).html(res.data.receiptAccount?res.data.receiptAccount:'-');
                    $(".js_pay td").eq(21).html(res.data.dispositBank?res.data.dispositBank:'-');
                    $(".js_pay td").eq(23).html("￥" + res.data.recAmount);
                    $(".js_pay td").eq(25).html("￥" + res.data.realRecAmount);
                    $(".js_pay td").eq(27).html("￥" + res.data.couponAmount);
                    $(".js_pay td").eq(29).html("￥" + res.data.refundAmount);
                    $(".js_pay td").eq(31).html("￥" + res.data.settlementAmount);
                    $(".js_pay td").eq(33).html(((res.data.serviceCharge).toString() != "" && btn_cont == "已付款")?"￥" + res.data.serviceCharge:"-");
                    $(".js_pay td").eq(34).html("付款人：");
                    $(".js_pay td").eq(35).html((res.data.optName)?res.data.optName:"-");
                    $(".js_pay .third_ls").remove();
                    //console.log((res.data.serviceCharge).toString() == "")
                    if(settlement_status[res.data.settlementStatus] == "已付款"){
                        $(".fkz").remove();
                        $(".js_pay").append("<tr class='third_ls'><td>第三方流水:</td><td>" + ((res.data.transactionId)?res.data.transactionId:'-') + "</td><td></td><td></td></tr>")
                    }else if(btn_cont == "付款中"){
                        $("#myModal2 .modal-header").append("<span style='position: absolute;right: 50px;top: 16px;' class='fkz'>请稍后刷新页面确认付款结果</span>")
                    }
                    $("#myModal2 .btn-primary").css("display", "none");
                    $("#myModal2 .btn-default").html("关闭");
                    $("#myModal2 .modal-footer").css("text-align", "center");
                }else{
                    layer.alert(res.msg);
                }
            }
        })
    }
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
                    //window.location.href = window.location.href;
                    ajax_post(url_init, searchData.searchParams)
                }else{
                    layer.alert(res.msg);
                }
            },
            error: function(){
                layer.alert("数据请求失败，请刷新重试!");
            }
        })
    }
});