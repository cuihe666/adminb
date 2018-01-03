var dataDr,http_url = serveUrl();
// var http_url = "http://192.168.64.55:9090/";
// var http_url = "http://106.14.239.132:9090/";  //测试
// var http_url = "http://106.15.126.75:9090/";// 预发布
//var http_url = "http://192.168.66.115:9090/"; // 邱洋本地 zjl 2017年9月20日22:03:43

$(function () {
    initTable();
    $(".fullCut_add").attr("data-val","3");
    $(".purchase_nub input[name~=add_nubRadioOptions]").change(function () {
        if($(".purchase_nub input[name~=add_nubRadioOptions]:checked").val()=="0"){
            $("#add_nub_input").show();
        }else{
            $("#add_nub_input").hide();
        }
    });
    $(".sales_type input[name~=add_salesRadioOptions]").change(function () {
        switch ($(".sales_type input[name~=add_salesRadioOptions]:checked").val()){
            case"1":
                $("#straightDown_1").show();
                $("#discount_2").hide();
                $("#fullCut_3").hide();
                break;
            case"2":
                $("#straightDown_1").hide();
                $("#discount_2").show();
                $("#fullCut_3").hide();
                break;
            case"3":
                $("#straightDown_1").hide();
                $("#discount_2").hide();
                $("#fullCut_3").show();
                break;
            default :
                break;
        }
    });
    // 二级产品分类显示隐藏
    $(".goods_type").on("click", function(){
        if($(this).val() == "3") {
            $('#goods_type_travel').css("display", "inline-block")
        }else {
            $('#goods_type_travel').css("display", "none")
        }
    });
});
//点击+增加数据 最多可增加至6条
function add(thisA){
    // console.log("1")
    // var html,count=$(thisA).attr("data-val");
    // count++;
    // $(thisA).attr("data-val",count);
    if($(".mj").length>5){
        return false;
    }else {
        if($(".mj").length==5){
            $(thisA).hide();
        }
        html = '<div class="mj minus">满<input type="text" class="fullMoney">元， 减<input type="text" class="reduceMoney">元；<button class="fullCut_minus" onclick="minus(this)" name="fullCut_303"><span class="glyphicon glyphicon-minus"></span></button></div>';
        $(thisA).parents(".ww").append(html);
    }
}
//点击-减少数据
function minus(thisA){
    $(thisA).parents(".mj").remove();
    if($(".mj").length<6){
        $(".fullCut_add").show();
    }
}
//保存
function addPromotion(thisA){
    var rulesDetails={},data,datas,ajax_url;
    var reg = /\d{1,}/;
    var is_pass = 0;
    switch($(".sales_type input[name~=add_salesRadioOptions]:checked").val()) {
        case"1":
            rulesDetails=$("#straightDown_1_input").val();
            if(reg.test(rulesDetails)==false){
                $("#straightDown_1_input").addClass("error");
                layer.alert("满减框均为数字，请重新填写！");
                return false;
            }else{
                $(".error").removeClass("error");
            }
            break;
        case"2":
            rulesDetails=$("#discount_2_input").val();
            if(reg.test(rulesDetails)==false){
                $("#discount_2_input").addClass("error");
                layer.alert("满减框均为数字，请重新填写！");
                return false;
            }else{
                $(".error").removeClass("error");
            }
            break;
        case "3":
            rulesDetails = [];
            switch ($("#fullCut_3 input[name~=fullCut_salesRadioOptions]:checked").val()) {
                case
                "301":
                    datas = $(".fullCut .ww .mj");

                    break;
                case
                "302":
                    datas = $(".fullCutRuleA  .mj");
                    break;
                case
                "303":
                    datas = $(".fullCutRuleB .ww .mj");
                    break;
                default:
                    break;
            }
            $.each(datas, function (i, obj) {
                rulesDetails[i]={};
                rulesDetails[i].fullMoney = $(obj).find(".fullMoney").val();
                rulesDetails[i].reduceMoney = $(obj).find(".reduceMoney").val();
                if(reg.test(rulesDetails[i].fullMoney)==true && reg.test(rulesDetails[i].reduceMoney)==true){
                    $(".error").removeClass("error");
                }else{
                    if(reg.test(rulesDetails[i].fullMoney)==false){
                        $(obj).find(".fullMoney").addClass("error");
                    }
                    if(reg.test(rulesDetails[i].reduceMoney)==false){
                        $(obj).find(".reduceMoney").addClass("error");
                    }
                    is_pass = 1;
                    return is_pass;
                }
            });
            break;
        default :
            break;
    }
    if(is_pass == 1){
        layer.alert("满减框均为数字，请重新填写！");
        return false;
    }
    if($("#add_salesName").val()!="") {
        $("#add_salesName").removeClass("error");
        // $.ajax({
        //     type: 'post',
        //     url: ajax_url,
        //     contentType: "application/json;charset=UTF-8",
        //     data: JSON.stringify(data),
        //     success: function (data) {
        //         if (data != null) {
        //             layer.alert("保存成功");
        //             $('#add_promotion_modal').modal('hide');
        //             initTable();
        //         }
        //     },
        //     error: function () {
        //         console.log("请求失败");
        //         console.log(data)
        //     }
        // })
    }else{
        $("#add_salesName").addClass("error");
        layer.alert("促销名称不能为空！");
        return false;

    }
    if($("#add_date_start").val()!="" || $("#add_date_end").val()!=""  ) {
        $("#add_date_start").removeClass("error");

    }else{
        $("#add_date_start").addClass("error");
        layer.alert("日期不能为空！");
        return false;
    }
    var starttime_arr = $("#add_date_start").val().split(":")[0].split("-");
    var endtime_arr = $("#add_date_end").val().split(":")[0].split("-");
    var startTime = new Date(starttime_arr[0] + "/" + starttime_arr[1] + "/" + starttime_arr[2].split(" ")[0]).getTime() + parseInt(starttime_arr[2].split(" ")[1])*60*60*1000 + parseInt($("#add_date_start").val().split(":")[1])*60*1000 + parseInt($("#add_date_start").val().split(":")[2])*1000;
    var endTime = new Date(endtime_arr[0] + "/" + endtime_arr[1] + "/" + endtime_arr[2].split(" ")[0]).getTime() + parseInt(endtime_arr[2].split(" ")[1])*60*60*1000 + parseInt($("#add_date_end").val().split(":")[1])*60*1000 + parseInt($("#add_date_end").val().split(":")[2])*1000;
    if($(thisA).attr("name")=="add"){
        ajax_url = http_url+'api/doPromotion/addSalesPromotion';
        data={
            promotionName:$("#add_salesName").val(),
            //qantityPurchased:$("#add_nub_input").val(),
            qantityPurchased:"",
            restrictionsState:$(".purchase_nub input[name~=add_nubRadioOptions]:checked").val(),
            enable:$(".promotion_state input[name~=add_stateRadioOptions]:checked").val(),
            startTime: startTime,
            endTime: endTime,
            goodsUsersImport:$(".promotion_overlay input[name~=add_RadioOptions]:checked").val(),
            promotionMode:$(".sales_type input[name~=add_salesRadioOptions]:checked").val(),
            secondLeveCode:$("#fullCut_3 input[name~=fullCut_salesRadioOptions]:checked").val(),
            rulesDetail:rulesDetails,
            operator:adminId
        };
    }else{
        ajax_url = http_url+'api/doPromotion/modifyPromotion';
        data={
            id:$(thisA).attr("data-id"),
            promotionName:$("#add_salesName").val(),
            //qantityPurchased:$("#add_nub_input").val(),
            qantityPurchased:"",
            restrictionsState:$(".purchase_nub input[name~=add_nubRadioOptions]:checked").val(),
            enable:$(".promotion_state input[name~=add_stateRadioOptions]:checked").val(),
            startTime: startTime,
            endTime: endTime,
            goodsUsersImport:$(".promotion_overlay input[name~=add_RadioOptions]:checked").val(),
            promotionMode:$(".sales_type input[name~=add_salesRadioOptions]:checked").val(),
            secondLeveCode:$("#fullCut_3 input[name~=fullCut_salesRadioOptions]:checked").val(),
            rulesDetail:rulesDetails,
            operator:adminId
        };
    }
    $.ajax({
        type:'post',
        url:ajax_url,
        contentType:"application/json;charset=UTF-8",
        data:JSON.stringify(data),
        success:function(data){
            if(data!=null){
                layer.alert(data.msg);
                if(data.code == 0){
                    $('#add_promotion_modal').modal('hide');
                }
                initTable();
            }
        },
        error:function () {
            console.log("请求失败")
        }
    })



}
//初始化表格
function initTable(mm){
    var ajax_url = http_url+'api/doPromotion/SalesPromotionList';
    var data={
        promotionName:$("#promotion_name").val(),
        enable:$("#promotion_state").val(),
        overdueState:$("#promotion_overlay").val(),
        restrictionsState:$("#promotion_restrict").val(),
        qantityPurchased:$("#promotion_nub").val(),
        id:$("#promotion_id").val(),
        createTime:(new Date($("#date_made").val())).getTime(),
        startTime:(new Date($("#date_start").val())).getTime(),
        endTime:(new Date($("#date_end").val())).getTime(),
        promotionMode:$("#promotion_mode").val(),
        operator:$("#promotion_operator").val()
    };
    $.ajax({
        type:'post',
        url:ajax_url,
        contentType:"application/json;charset=UTF-8",
        data:JSON.stringify(data),
        success:function(data){
            if(data!=null){
                $("#box_all").prop("checked", false);
                var dataArr=data.data;
                if(dataArr!=undefined) {
                    var htmls='',datas=[],arr=[];
                    var obj_sta = ["关闭","开启"];
                    $.each(dataArr,function(i,obj){
                        datas[i]=obj;
                        htmls+='<tr name="'+obj.id+'" data-data="true"><th scope="row"><input type="checkbox" class="checks" onclick="checked_one()"/></th><td class="objId">'+obj.id+'</td><td>'+ getLocalTimeByJO(obj.createTime) +'</td><td>'+obj.promotionName+'</td><td>'+obj.promotionMode+'</td><td class="pro_rul">'+obj.promotionRules+'</td><td>'+ getLocalTimeByJO(obj.startTime) +'</td><td>'+ getLocalTimeByJO(obj.endTime) +'</td><td>'+obj.overdueState+'</td><td>'+obj.restrictionsState+'</td><td>'+obj_sta[obj.enable]+'</td><td>'+obj.operatorName+'</td><td><button class="btn btn-primary btn-block goodsDetails" type="button"  onclick="addSales(this)">导入商品</button><button class="btn btn-primary btn-block" type="button" onclick="edit(this)"><span class="glyphicon glyphicon-pencil"></span>修改</button><button class="btn btn-danger btn-block del_promotional" type="button" onclick="dele(this)"><span class="glyphicon glyphicon-remove"></span>删除</button></td></tr>';

                    });

                    $(".promotion_tb tbody").html("");
                    $(".promotion_tb tbody").html(htmls);
                    arr=$(".promotion_tb tbody tr");
                    $.each(arr,function(ik,objk){
                        if($(objk)!=null && $(objk).data()!=null && $(objk).data().data!=null && $(objk).data().data==true){
                            $(objk).data().data=datas[ik];
                        }
                        var td5,td9,td10;
                        switch($(objk).find("td:nth-child(5)").text()){
                            case"1":
                                td5="直降";
                                break;
                            case"2":
                                td5="折扣"
                                break;
                            case"3":
                                td5="满减"
                                break;
                        }
                        switch($(objk).find("td:nth-child(9)").text()){
                            case"0":
                                td9="过期";
                                break;
                            case"1":
                                td9="未过期"
                                break;
                        }
                        switch($(objk).find("td:nth-child(10)").text()){
                            case"0":
                                td10= datas[ik].qantityPurchased;
                                break;
                            case"1":
                                td10="不限购"
                                break;
                        }
                        if($(objk).find("td:nth-child(11)").text() == "开启"){
                            $(objk).find("td:nth-child(13)").find("button").eq(2).removeAttr("onclick");
                            $(objk).find("td:nth-child(13)").find("button").eq(2).attr("class", "btn btn-default btn-block del_promotional");
                        }
                        $(objk).find("td:nth-child(5)").text(td5);
                        $(objk).find("td:nth-child(9)").text(td9);
                        $(objk).find("td:nth-child(10)").text(td10);
                    });
                    $("#box_all").click(function(){
                        if(this.checked){
                            $(this).parents("table").find(".checks").prop("checked","checked");
                        }else {
                            $(this).parents("table").find(".checks").removeAttr("checked","checked");
                        }
                    });
                }
                // // 实现分页
                // if($(".pages")){
                //     $(".pages").remove();
                // }
                // var page_num = parseInt(res.pageInfo.total) / parseInt($(".pageSize").val());
                // if(page_num >  parseInt(page_num)){
                //     page_num =  parseInt(page_num) + 1;
                // }
                // // 首页尾页不能点击设置
                // if(res.pageInfo.pageNum == 1 && page_num != 1){
                //     $(".pro_next").eq(0).attr("class", "pro_next disabled");
                //     $(".pro_next").eq(1).attr("class", "pro_next disabled");
                //     $(".pro_next").eq(2).attr("class", "pro_next");
                //     $(".pro_next").eq(3).attr("class", "pro_next");
                // }else if(res.pageInfo.pageNum == page_num && page_num != 1){
                //     $(".pro_next").eq(0).attr("class", "pro_next");
                //     $(".pro_next").eq(1).attr("class", "pro_next");
                //     $(".pro_next").eq(2).attr("class", "pro_next disabled");
                //     $(".pro_next").eq(3).attr("class", "pro_next disabled");
                // }else if(res.pageInfo.pageNum == 1 && page_num == 1){
                //     $(".pro_next").eq(0).attr("class", "pro_next disabled");
                //     $(".pro_next").eq(1).attr("class", "pro_next disabled");
                //     $(".pro_next").eq(2).attr("class", "pro_next disabled");
                //     $(".pro_next").eq(3).attr("class", "pro_next disabled");
                // }else{
                //     $(".pro_next").eq(0).attr("class", "pro_next");
                //     $(".pro_next").eq(1).attr("class", "pro_next");
                //     $(".pro_next").eq(2).attr("class", "pro_next");
                //     $(".pro_next").eq(3).attr("class", "pro_next");
                // }
                // $(".pro_next").eq(1).find("input").val(res.pageInfo.pageNum - 1);
                // $(".pro_next").eq(2).find("input").val(res.pageInfo.pageNum + 1);
                // $(".pro_next").eq(3).find("input").val(page_num);
                // $(".page_num").html(page_num);
                // if(page_num <= 5){
                //     for(var i = page_num; i >= 1; i--){
                //         $(".pro_next").eq(1).after("<li class='pages'><a>" + i + "</a></li>");
                //     }
                //     $(".pages a").css("background-color", "white");
                // }else{
                //     if(res.pageInfo.pageNum <= 3){
                //         for(var i = 5; i >= 1; i--){
                //             $(".pro_next").eq(1).after("<li class='pages'><a>" + i + "</a></li>");
                //         }
                //     }else if(res.pageInfo.pageNum < page_num - 2){
                //         for(var i = res.pageInfo.pageNum + 2; i >= res.pageInfo.pageNum - 2; i--){
                //             $(".pro_next").eq(1).after("<li class='pages'><a>" + i + "</a></li>");
                //         }
                //     }else{
                //         for(var i = page_num; i > page_num - 5; i--){
                //             $(".pro_next").eq(1).after("<li class='pages'><a>" + i + "</a></li>");
                //         }
                //     }
                //     $(".pages a").css("background-color", "white");
                // }
                // $(".pages a").each(function(index){
                //     if($(this).html() == res.pageInfo.pageNum){
                //         $(this).css("background", "#ccc");
                //     }
                // })
            }
        },
        error:function () {
            console.log("请求失败")
        }
    })
}
//重置
function reset(){
    document.getElementById("promotion_form").reset();
    initTable();
}
//删除
function dele(thisA){
    var ajax_url = http_url+'api/doPromotion/delSalesPromotion';
    var data={
        id:$(thisA).parents("tr").attr("name")
    };
    if(confirm("是否要删除ID为："+$(thisA).parents("tr").attr("name")+"的促销活动?")){
        $.ajax({
            type:'post',
            url:ajax_url,
            contentType:"application/json;charset=UTF-8",
            data:JSON.stringify(data),
            success:function(data){
                if(data!=null){
                    layer.alert(data.msg);
                    initTable();
                }
            },
            error:function () {
                console.log("请求失败")
            }
        })
    }
}
//删除促销商品
function deleGoods(thisA){
    var ajax_url = http_url+'api/doPromotionalGoods/delPromotionalGoods';
    var data={
        id:$(thisA).parents("tr").attr("name2")
    };
    if(confirm("是否要删除ID为："+$(thisA).parents("tr").attr("name")+"的促销商品?")){
        $.ajax({
            type:'post',
            url:ajax_url,
            contentType:"application/json;charset=UTF-8",
            data:JSON.stringify(data),
            success:function(data){
                if(data!=null){
                    layer.alert(data.msg);
                    intList($("#addComm_id").attr("data-promotionId"));
                }
            },
            error:function () {
                console.log("请求失败")
            }
        })
    }
}
//修改
function edit(thisA){
    $(".minus").remove();
    $("#add_save").attr("name","edit");
    $("#add_save").attr("data-id",$(thisA).parents("tr").data().data.id);
    var datas=$(thisA).parents("tr").data().data;
    $("#add_salesName").val(datas.promotionName);
    $("#add_salesName").prop("readonly", true);
    $(".table_add tr").eq(5).find("input[type='radio']").prop("disabled", true);
    $("#add_nub_input").val(datas.qantityPurchased);
    var restrictionsState=$(".purchase_nub input[name~=add_nubRadioOptions]");
    var overdueState=$(".promotion_state input[name~=add_stateRadioOptions]");
    var goodsUsersImport=$(".promotion_overlay input[name~=add_RadioOptions]");
    var promotionMode=$(".sales_type input[name~=add_salesRadioOptions]");
    var secondLeveCode=$("#fullCut_3 input[name~=fullCut_salesRadioOptions]");
    var rulesDetail=datas.rulesDetail;
    // 点击修改时个选项数据回填
    //是否限购
    $.each(restrictionsState,function(i,obj){
        if($(obj).val()==datas.restrictionsState){
            $(obj).attr("checked","checked");
        }else{
            $(obj).removeAttr("checked","checked");
        }
    });
    //促销状态
    $.each(overdueState,function(i,obj){
        if($(obj).val()==datas.enable){
            $(obj).prop("checked",true);
        }else{
            $(obj).prop("checked",false);
        }
    });
    if(datas.enable == 0){
        $(".promotion_state input").prop("disabled", true);
    }else{
        $(".promotion_state input").prop("disabled", false);
    }
    // 满减数据回填
    var html = '<div class="mj minus">满<input type="text" class="fullMoney">元， 减<input type="text" class="reduceMoney">元；<button class="fullCut_minus" onclick="minus(this)" name="fullCut_303"><span class="glyphicon glyphicon-minus"></span></button></div>';
    if(JSON.parse(rulesDetail).length == 6){
        $(".fullCut_add").css("display", "none");
    }else{
        $(".fullCut_add").css("display", "block");
    }
    for(var i = 0; i < JSON.parse(rulesDetail).length - 1; i++){
        $(".fullCutRuleB").append(html);
    }
    //console.log(typeof rulesDetail);
    //商品及用户导入
    $.each(goodsUsersImport,function(i,obj){
        if($(obj).val()==datas.goodsUsersImport){
            $(obj).attr("checked","checked");
        }else{
            $(obj).removeAttr("checked","checked");
        }
    });
    // 促销方式
    if(datas.promotionMode == 1){
        $("input[name='add_salesRadioOptions']").eq(0).prop("checked", true).siblings().prop("checked", false);
    }else if(datas.promotionMode == 2){

    }else{
        $("input[name='add_salesRadioOptions']").eq(1).prop("checked", true).siblings().prop("checked", false);
    }
    //一级促销方式
    $.each(promotionMode,function(i,obj){
        var df,dr;
        if(Number($(obj).val())== Number(datas.promotionMode)){
            switch($(obj).val()){
                case "1":
                    $("#straightDown_1").show();
                    $("#discount_2").hide();
                    $("#fullCut_3").hide();
                    $("#straightDown_1_input").val(rulesDetail);
                    break;
                case "2":
                    $("#straightDown_1").hide();
                    $("#discount_2").show();
                    $("#fullCut_3").hide();
                    $("#discount_2_input").val(rulesDetail);
                    break;
                case "3":
                    $("#straightDown_1").hide();
                    $("#discount_2").hide();
                    $("#fullCut_3").show();
                    $("#fullCut_3 input[type=text]").val("");
                    switch(datas.secondLeveCode){     //满减数据回填
                        case 301:
                            df=$(".fullCut .ww .mj .fullMoney");
                            dr=$(".fullCut .ww .mj .reduceMoney");
                            break;
                        case 302:
                            df=$(".fullCutRuleA .mj .fullMoney");
                            dr=$(".fullCutRuleA .mj .reduceMoney");
                            break;
                        case 303:
                            df=$(".fullCutRuleB .mj .fullMoney");
                            dr=$(".fullCutRuleB .mj .reduceMoney");
                            break;
                        default :
                            break;
                    }
                    var rdt = JSON.parse(rulesDetail);//遍历促销规则回填
                    $.each(df,function (p,obs){
                        $(obs).val(rdt[p].fullMoney);
                    });
                    $.each(dr,function (k,obf) {
                        $(obf).val(rdt[k].reduceMoney);
                    });
                    $.each(secondLeveCode,function(i,obj){
                        if($(obj).val()==datas.secondLeveCode){
                            $(obj).prop("checked",true);
                        }else{
                            $(obj).prop("checked", false);
                        }
                    });
                    break;
                default :
                    break;
            }
        }else{
            $(obj).removeAttr("checked","checked");
        }
    });
    // 满减增加删除按钮设置不能用
    $(".fullCut_add").prop("disabled", true);
    $(".fullCut_minus").prop("disabled", true);
    $(".table_add tr").eq(5).find("input").prop("readonly", true);
    $("#add_date_start").val(getLocalTimeByJO(datas.startTime));//日期回填
    $("#add_date_end").val(getLocalTimeByJO(datas.endTime));//日期回填
    $(".zhe").css("z-index", "10");
    $("#add_promotion_modal").modal("show");
}
//新增
function adds(){
    $(".minus").remove();
    // 满减增加删除按钮设置能正常添加减少,新增按钮显示
    $(".fullCut_add").css("display", "block");
    $(".fullCut_add").prop("disabled", false);
    $(".fullCut_minus").prop("disabled", false);
    $("#add_save").attr("name","add");
    $('#add_promotion_modal').modal({backdrop: 'static', keyboard: false});
    $(".zhe").css("z-index", "-10");
    $(".promotion_state input").prop("disabled", false);
    // 清空选项框数据
    $("#add_salesName").val("");
    $("#add_salesName").prop("readonly", false);
    $(".table_add tr").eq(5).find("input").prop("readonly", false);
    $(".table_add tr").eq(5).find("input[type='radio']").prop("disabled", false);
    $(".purchase_nub input[name~=add_nubRadioOptions]:nth-child(0)").attr("checked","checked");
    //$(".promotion_state input[name~=add_stateRadioOptions]").eq(0).prop("checked",true);
    $("#add_date_start").val("");
    $("#add_date_end").val("");
    $("#straightDown_1_input").val("");
    $("#discount_2_input").val("");
    // $(".promotion_overlay input[name~=add_RadioOptions]:nth-child(0)").attr("checked","checked");//有可选状态
    $("#add_overlay_n").attr("checked","checked");//无可选状态
    $(".sales_type input[name=add_salesRadioOptions]:nth-child(0)").val("");
    // $(".sales_type input[name=add_salesRadioOptions]:nth-child(0)").attr("checked","checked");
    $("#fullCut_3 input[name~=fullCut_salesRadioOptions]:nth-child(0)").attr("checked","checked");
    $("#fullCut_3 input[type=text]").val("");
    $("#add_nub_input").val("");
    for(var i = 0; i < $(".table_add input").length; i++){
        if($(".table_add input").eq(i).attr("class")){
            if($(".table_add input").eq(i).attr("class").indexOf("error") >= 0){
                console.log($(".table_add input").eq(i).attr("class").split(" "))
                var class_arr = $(".table_add input").eq(i).attr("class").split(" ");
                var class_init = "";
                for(var j = 0; j < class_arr.length; j++){
                    if(class_arr[j] != "error"){
                        class_init = class_init + class_arr[j];
                    }
                }
                $(".table_add input").eq(i).attr("class", class_init);
            }
        }
    };
    $("input[name='fullCut_salesRadioOptions']").eq(0).prop("checked", true).siblings("checked", false);
    $("input[name='add_stateRadioOptions']").eq(1).prop("checked", false);
    $("input[name='add_stateRadioOptions']").eq(0).prop("checked", true);
    $("input[name='add_salesRadioOptions']").eq(0).prop("checked", true).siblings().prop("checked", false);
    $("#straightDown_1").css("display", "block");
    $("#discount_2").css("display", "none");
    $("#fullCut_3").css("display", "none");
    //$(".table_add input").
    $("#add_promotion_modal").modal("show");
}

//导出Excel
function exportExcel(){
    var checks=$(".checks:checked"),ids=[];
    if(checks.length>0) {
        $.each(checks, function (i, obj) {
            ids.push($(obj).parents("tr").attr("name"));
        });
        window.open(http_url+"api/doPromotion/exportExcel?ids=" + ids.join(","));
    }else{
        layer.alert("请选择要导出数据!")
    }
}
//批量下载
function goodsExportExcel(){
    var checksxz=$(".checksxz:checked"),ids=[];
    if(checksxz.length>0) {
        $.each(checksxz, function (i, obj) {
            ids.push($(obj).parents("tr").attr("name2"));
        });
        window.open(http_url+"api/doPromotionalGoods/exportExcel?ids=" + ids.join(","));
    }else{
        layer.alert("请选择要导出数据!")
    }

}
// 导出部分判断全选按钮是否选中



function checked_one(){
    var checked = $(".checks:checked"), ids = [];
    if(checked.length == $(".checks").length){
        $("#box_all").prop("checked", true);
    }else{
        $("#box_all").removeAttr("checked");
    }
}
// 下载部分判断全选按钮是否选中
function download_one(){
    var checked = $(".checksxz:checked"), ids = [];
    if(checked.length == $(".checksxz").length){
        $("#list_tb_all").prop("checked", true);
    }else{
        $("#list_tb_all").removeAttr("checked");
    }
}
//单个导入
function imports(){
    var ajax_url,data;
    var datas=$("#addComm_id").attr("data-data");
    ajax_url = http_url+'api/doPromotionalGoods/addPromotionalGoods';
    data= {

        productId: $("#goods_id").val(),
        goodsType: $(".goods_type").val(),  //商品
        secondgoodsCode: $("#goods_type_travel").val(),  //商品二级
        promotionMode: $("#addComm_id").attr("data-promotionMode"),//促销一级
        secondLeveCode: $("#addComm_id").attr("data-secondLeveCode"),//促销二级
        rulesDetail: JSON.parse($("#addComm_id").attr("data-rulesDetail")),//促销规则
        promotionId: $("#addComm_id").attr("data-promotionId")//促销ID
    };
    if($.trim($("#addComm_id").val())&&$(".goods_type").val()!=""){
        $.ajax({
            type:'post',
            url:ajax_url,
            contentType:"application/json;charset=UTF-8",
            data:JSON.stringify(data),
            success:function(data){
                console.log(data);
                if(data.code == 0){
                    $("#goods_id").val("");
                    $(".goods_type").val("");
                    layer.alert(data.msg);
                    intList($("#addComm_id").val());
                }else{
                    $("#goods_id").val("");
                    layer.alert(data.msg);
                }
            },
            error:function () {
                $("#goods_id").val("");
                $(".goods_type").val("");
                console.log("请求失败")
            }
        })

    }else {
        if($.trim($("#goods_id").val())==""){
            layer.alert("请填写产品ID");
            return false;
        }
        if($.trim($(".goods_type").val())==""){
            layer.alert("请选择产品分类");
            return false;
        }
    }

};
//批量导入
function doUpload() {
    var formData = new FormData($( "#uploadForm" )[0]);
    // console.log(formData);
    $.ajax({
        url: http_url+'api/doPromotionalGoods/bacthImport',
        type: 'POST',
        data: formData,
        async: false,
        cache: false,
        contentType: false,
        processData: false,
        success: function (returndata) {

            layer.alert(returndata.msg);
            intList($("#addComm_id").val());
            $("input[type=file]").val("");
        },
        error: function (returndata) {
            $("input[type=file]").val("");
            layer.alert(returndata.msg);
            console.log(returndata);

        }
    });
}
//初始化商品列表
function intList(ids) {
    var ajax_url = http_url + 'api/doPromotionalGoods/PromotionalGoodsList';
    // $("#add_save").attr("data-id",$(thisA).parents("tr").data().data.id);
    $.ajax({
        type: 'post',
        url: ajax_url,
        contentType: "application/json;charset=UTF-8",
        data:JSON.stringify({ promotionId:ids }),
        success: function (data) {
            if (data != null) {
                var dataArr = data.data;
                if (dataArr != undefined) {
                    var htmls = '';
                    var obj_type = ["商品","民宿","酒店","旅游"]
                    $.each(dataArr, function(i, obj) {
                        htmls += '<tr name="'+obj.goodsId+'" name2="'+obj.id+'" ><th scope="row"><input type="checkbox" class="checksxz" onclick="download_one()"/></th><td>' + obj.goodsId + '</td><td>' + obj.goodsName + '</td><td>' + obj_type[obj.goodsType] + '</td><td>' + obj.commodityPrice + '</td><td><button class="btn btn-danger btn-block del_promotional" type="button" onclick="deleGoods(this)"><span class="glyphicon glyphicon-remove"></span>删除</button></td></tr>';
                    });
                    $(".list_tb tbody").html("");
                    $(".list_tb tbody").html(htmls);
                    $("#list_tb_all").click(function(){
                        if(this.checked){
                            $(this).parents("table").find(".checksxz").prop("checked","checked");
                        }else {
                            $(this).parents("table").find(".checksxz").removeAttr("checked","checked");
                        }
                    });
                }
            }
        },
        error: function () {
            console.log("请求失败")
        }
    })
}
//导入商品赋值
function addSales(thisA) {
    $("#goods_id").val("");
    $(".goods_type").val("");
    $("#list_tb_all").removeAttr("checked");
    $("input[type=file]").val("");

    var datas = $(thisA).parents("tr").data().data,promotionMode;
    var create = getLocalTimeByJO(datas.createTime);//创建时间
    var end = getLocalTimeByJO(datas.endTime);//结束时间
    var start = getLocalTimeByJO(datas.startTime);//开始时间
    switch(datas.promotionMode){
        case 1:
            promotionMode="直降";
            break;
        case 2:
            promotionMode="折扣";
            break;
        case 3:
            promotionMode="满减";
            break;
    }

    $("#addComm_id").val(datas.id).attr("data-promotionMode",datas.promotionMode).attr("data-secondLeveCode",datas.secondLeveCode).attr("data-rulesDetail",datas.rulesDetail).attr("data-promotionId",datas.id);

    $("#addComm_creat").val(create);
    $("#addComm_name").val(datas.promotionName);
    $("#addComm_mode").val(promotionMode);
    $("#addComm_start").val(start );
    $("#addComm_end").val(end);
    $(".addCommModal").modal("show");

    //批量上传上传参数
    $("#up_code").val(datas.secondLeveCode);
    $("#up_mode").val(datas.promotionMode);
    $("#up_rule").val(datas.rulesDetail);
    $("#up_id").val(datas.id);

    dataDr = {
        promotionMode: datas.promotionMode,//促销一级
        secondLeveCode: datas.secondLeveCode,//促销二级
        rulesDetail: JSON.parse(datas.rulesDetail),//促销规则
        promotionId: datas.id//促销ID
    };
    intList(datas.id);
}



function getLocalTimeByJO(timestamp,argu) {     //将时间戳（毫秒）转换成日期-时间 @JO.0911
    var zc_new_date_obj = new Date( parseInt(timestamp) );
    var zc_year = zc_new_date_obj.getFullYear();
    var zc_month = ( zc_new_date_obj.getMonth() )+1;
    var zc_day = zc_new_date_obj.getDate();
    var zc_hour = zc_new_date_obj.getHours();
    var zc_minute = zc_new_date_obj.getMinutes();
    var zc_second = zc_new_date_obj.getSeconds();
    var resultStr = zc_year +'-'+zcAddZero(zc_month)+'-'+zcAddZero(zc_day)+' '+zcAddZero(zc_hour)+':'+zcAddZero(zc_minute)+':'+zcAddZero(zc_second)  ;
    if(argu) {
        resultStr = zc_year +argu+zcAddZero(zc_month)+argu+zcAddZero(zc_day)+zcAddZero(zc_hour)+zcAddZero(zc_minute)+zcAddZero(zc_second);
    }
    if(!zc_year || !zc_month ||  !zc_day) {
    // if(!zc_year || !zc_month ||  !zc_day||  !zc_hour||  !zc_minute||  !zc_second) {
        resultStr = '暂无可选日期';
        return resultStr;
    }
    return resultStr;
}


