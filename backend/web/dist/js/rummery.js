$(function () {
//	酒店管理详情页 tab
    function rummery_tab(source, current, source_p, rummery_con, rummery_item) {
        $(source).click(function () {
            var i = $(this).index();
            $(this).addClass(current).siblings(source).removeClass(current);
            $(this).parent(source_p).siblings(rummery_con).children(rummery_item).eq(i).show().siblings(rummery_item).hide();
        })
    }

//rummery_tab(".rummery_tab>li","current",".rummery_tab",".rummery_con",".rummery_item");
    rummery_tab(".house_price_tab>li", "current", ".house_price_tab", ".house_price_con", ".house_price_item");

//供应商基本信息保存 验证
    $(".suppy_detail_btn").click(function () {

    })


//single alter house status
    $("body").on("click", ".cal_con>li>.fangtai_item", function () {
        $("#single_modal").modal("show");
    })

//single house add reduce
    $("body").on("click", "#single_modal .single_house_reduce", function () {
        $(this).siblings("input[type='text']").val() + 1;
    })
//点击修改底价
    $("body").on("click", ".edit_price", function (e) {
        if (e.stopPropagation) {
            e.stopPropagation();
        } else {
            e.cancelBubble = true;
        }
        $(this).parent(".last_click").siblings(".click_con").find(".dijia_input").show().siblings(".dijia").hide();
        $(this).hide().siblings(".edit_price_save").show();
    })
//点击修改佣金
    $("body").on("click", ".edit_money", function (e) {
        if (e.stopPropagation) {
            e.stopPropagation();
        } else {
            e.cancelBubble = true;
        }
        $(this).parent(".last_click").siblings(".click_con").find(".yongjin_input").show().siblings(".yongjin").hide();
        $(this).hide().siblings(".edit_money_save").show();
    })
//冒泡
    $("body").on("click", ".click_con", function (e) {
        if (e.stopPropagation) {
            e.stopPropagation();
        } else {
            e.cancelBubble = true;
        }
    })
//保存修改底价
    $("body").on("click", ".edit_price_save", function (e) {
        if (e.stopPropagation) {
            e.stopPropagation();
        } else {
            e.cancelBubble = true;
        }
        $(this).parent(".last_click").siblings(".click_con").find(".dijia_input").hide().siblings(".dijia").show();
        $(this).hide().siblings(".edit_price").show();

    })
//保存修改佣金
    $("body").on("click", ".edit_money_save", function (e) {
        if (e.stopPropagation) {
            e.stopPropagation();
        } else {
            e.cancelBubble = true;
        }
        $(this).parent(".last_click").siblings(".click_con").find(".yongjin_input").hide().siblings(".yongjin").show();
        $(this).hide().siblings(".edit_money").show();

    })

//    $(".house_weeks .house_weeks_first input[name='checkbox']").click(function () {
//       if($(this).attr("checked")){
//           console.log(1)
//            $(this).siblings(".checkbox_box").find("[name='checkbox']").attr("checked",false);
//       }else{
//           console.log(1)
//
//           $(this).siblings(".checkbox_box").find("[name='checkbox']").attr("checked",true);
//
//       }
//    })


//房态房价 弹框验证
//    $("body").on("click", "#single_fangtai_sure", function () {
//        var val = $('input:radio[name="house_status_single"]:checked').val();
//        if (val == null) {
//            alert("请选择房源状态");
//            return false;
//        }
//        var list = $('input:radio[name="house_num_single"]:checked').val();
//        if (list == null) {
//            alert("请选择可售数量");
//            return false;
//        }
//        $(this).parents("#single_modal").modal("hide");
//    })


    //$("body").on("click", "#more_fangtai_sure", function () {
    //    var val = $('input:checked[name="house_name[]"]:checked').val();
    //    if (val == null) {
    //        layer.open({
    //            content: '请先选择房型',
    //        });
    //        return false;
    //    }
    //    if ($("input.fangtai_date1").val() == "" && $("input.fangtai_date2").val() == "" || $("input.fangtai_date1").val() == "" || $("input.fangtai_date2").val() == "") {
    //        layer.open({
    //            content: '请选择日期',
    //        });
    //        return false;
    //    }
    //    var val = $('input:checked[name="house_week"]:checked').val();
    //    if (val == null) {
    //        alert("请选择有效星期");
    //        return false;
    //    }
    //    var val = $('input:radio[name="house_status"]:checked').val();
    //    if (val == null) {
    //        alert("请选择房源状态");
    //        return false;
    //    }
    //    var list = $('input:radio[name="house_num"]:checked').val();
    //    if (list == null) {
    //        alert("请选择可售数量");
    //        return false;
    //    }
    //
    //    $(this).parents("#more_modal").modal("hide");
    //})

    //$("body").on("click", "#more_fangjia_sure", function () {
    //    var val = $('input:checked[name="house_name_price"]:checked').val();
    //    if (val == null) {
    //        alert("请选择房型");
    //        return false;
    //    }
    //    if ($("input.fangjia_date1").val() == "" && $("input.fangjia_date2").val() == "" || $("input.fangjia_date1").val() == "" || $("input.fangjia_date2").val() == "") {
    //        alert("请选择日期");
    //        return false;
    //    }
    //    var val = $('input:checked[name="house_week_price"]:checked').val();
    //    if (val == null) {
    //        alert("请选择有效星期");
    //        return false;
    //    }
    //    var val = $('input:radio[name="house_status_price"]:checked').val();
    //    if (val == null) {
    //        alert("请选择房价修改");
    //        return false;
    //    }
    //    var list = $('.djyj:checked');
    //    var djval = $('input[name="tg_dj"]').val();
    //    var yjval = $('input[name="tg_yj"]').val();
    //    if (list && djval == "") {
    //        alert("请填写底价");
    //        return false;
    //    }
    //    if (list && yjval == "") {
    //        alert("请填写佣金");
    //        return false;
    //    }
    //
    //    $(this).parents("#more_modal_price").modal("hide");
    //})

//点击添加联系人
    $(".add_person").on("click", function () {
        var str = '<ul class="content_item content_con clearfix">' +
            '<li class="li_item"><input type="text" placeholder="请输入联系人" name="type" style="display:block"></li>' +
            '<li class="li_item"><input type="text" placeholder="请输入姓名" name="name" style="display:block"></li>' +
            '<li class="li_item"><input type="text" placeholder="请输入职务" name="job" style="display:block"></li>' +
            '<li class="li_item"><input type="text" placeholder="请输入手机号码" name="mobile" style="display:block"></li>' +
            '<li class="li_item"><input type="text" placeholder="请输入E-mail" name="email" style="display:block"></li>' +
            '<li class="li_item"><input type="text" placeholder="请输入电话" name="landline" style="display:block"></li>' +
            '<li class="li_item"><input type="text" name="sms_status" readonly="readonly" class="select_sms_status" value="已开启" myAttr="0" style="display:block"></li>' +
            '<li class="li_item"><div class="op_eds"><p class="edit" style="display:none;">编辑</p><p class="save" style="display:block" data="0">保存</p></div><p class="delete">删除</p></li>' +
            '</ul>';

        $(this).siblings(".contact_box").append(str);
    });
//点击修改联系人
    $("body").on("click", ".op_eds>.edit", function () {
        var parent = $(this).parent().parent().parent();
        $(this).parents(".li_item").siblings(".li_item").find("span").hide().siblings("input[type='text']").show();
        $(this).hide().siblings(".save").show();
    });
    //酒店2.1，更改酒店联系人的短信接受状态 admin:ys time:2017/11/2
    $("body").on("click", ".li_item>.select_sms_status", function () {
        var status = $(this).attr("myAttr");
        if (status == 0) {//短信接受状态未开启状态，修改为关闭状态
            $(this).val("已关闭");
            $(this).attr("myAttr", 1);
        } else {//短信接受状态未关闭状态，修改为开启状态
            $(this).val("已开启");
            $(this).attr("myAttr", 0);
        }
    });
//点击保存联系人
    $("body").on("click", ".op_eds>.save", function () {
        var contactId = $(this).attr('data');
        var ajax_url = save_url;
        if (contactId == "0") {
            ajax_url = save_url;
        }
        else {
            ajax_url = update_url;
        }
        var parent = $(this).parent().parent().parent();
        var type = parent.find("input[name='type']").val();
        var name = parent.find("input[name='name']").val();
        var job = parent.find("input[name='job']").val();
        var mobile = parent.find("input[name='mobile']").val();
        var email = parent.find("input[name='email']").val();
        var landline = parent.find("input[name='landline']").val();
        var theme_id = hotel_id;
        //酒店2.1 admin:ys time:2017/11/2
        var sms_status = parent.find("input[name='sms_status']").attr("myAttr");
        var sms_status_val = parent.find("input[name='sms_status']").val();
        var _this = $(this);
        if(type==""){
            layer.alert("请输入联系人！");
            parent.find("input[name='type']").focus();
            return false;
        }
        if(name==""){
            layer.alert("请输入姓名！");
            parent.find("input[name='name']").focus();
            return false;
        }
        if(job==""){
            layer.alert("请输入职务！");
            parent.find("input[name='job']").focus();
            return false;
        }
        if(mobile==""){
            layer.alert("请输入手机号码！");
            parent.find("input[name='mobile']").focus();
            return false;
        }
        else{
            var reg = /^0?1[3|4|5|7|8][0-9]\d{8}$/;
            if(!reg.test(mobile)) {
                layer.alert("手机号码格式错误");
                parent.find("input[name='mobile']").focus();
                return false;
            }
        }
        if(email == "") {

        } else {
            var reg = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if(!reg.test(email) && email != "") {
                //			console.log("5555")
                layer.alert("您的电子邮件格式不正确");
                parent.find("input[name='email']").focus();
                return false;
            }
        }
        if(landline==""){
            layer.alert("请输入电话！");
            parent.find("input[name='landline']").focus();
            return false;
        }
        $.ajax({
            type: 'post',
            url: ajax_url,
            data: {
                type: type,
                name: name,
                job: job,
                mobile: mobile,
                email: email,
                landline: landline,
                theme_id: theme_id,
                id: contactId,
                //酒店2.1 admin:ys time:2017/11/2
                sms_status:sms_status,
            },
            success: function (data) {
                if (contactId == "0") {
                    parent.find("input[name='type']").before('<span style="display:none;">' + type + '</span>');
                    parent.find("input[name='name']").before('<span style="display:none;">' + name + '</span>');
                    parent.find("input[name='job']").before('<span style="display:none;">' + job + '</span>');
                    parent.find("input[name='mobile']").before('<span style="display:none;">' + mobile + '</span>');
                    parent.find("input[name='email']").before('<span style="display:none;">' + email + '</span>');
                    parent.find("input[name='landline']").before('<span style="display:none;">' + landline + '</span>');
                    parent.find("input[name='sms_status']").before('<span style="display:none;">' + sms_status_val + '</span>');
                    _this.parents(".li_item").siblings(".li_item").find("input[type='text']").hide().siblings("span").show();
                    _this.hide().siblings(".edit").show();

                    //保存成功后将data赋值给当前按钮的附加属性data
                    _this.attr('data',data);
                    //保存成功后将data赋值给当前按钮的父级的兄弟元素【删除】的附加属性data
                    _this.parent().siblings(".delete").attr("data",data);
                }
                else {
                    parent.find("input[name='type']").siblings("span").text(type);
                    parent.find("input[name='name']").siblings("span").text(name);
                    parent.find("input[name='job']").siblings("span").text(job);
                    parent.find("input[name='mobile']").siblings("span").text(mobile);
                    parent.find("input[name='email']").siblings("span").text(email);
                    parent.find("input[name='landline']").siblings("span").text(landline);
                    parent.find("input[name='sms_status']").siblings("span").text(sms_status_val);
                    _this.parents(".li_item").siblings(".li_item").find("input[type='text']").hide().siblings("span").show();
                    _this.hide().siblings(".edit").show();

                }
            }
        })
    })
//点击删除联系人
    $("body").on("click", ".li_item>.delete", function () {
        var contactId = $(this).attr('data');
        var _this = $(this);
        if (contactId != "") {
            $.ajax({
                type: 'post',
                url: del_url,
                data: {
                    contactId: contactId,
                },
                success: function (data) {
                    if (data >= 0) {
                        _this.parents(".content_item").remove();
                    }
                }
            })
        }

    })

//房间数量增加
    function add_num(add) {
        $(add).click(function () {
            var val = parseInt($(this).siblings("input[type='text']").val());
            if(val<127)
                val++;
            $(this).siblings("input[type='text']").val(val);
        })
    }

    add_num(".single_house_add");
    add_num(".more_house_add");
    function reduce_num(reduce) {
        $(reduce).click(function () {
            var val = parseInt($(this).siblings("input[type='text']").val());
            val--;
            if (val <= 0) {
                $(this).siblings("input[type='text']").val("1");
                return false;
            }
            $(this).siblings("input[type='text']").val(val);
        })
    }

    reduce_num(".single_house_reduce");

    reduce_num(".more_house_reduce");
//2017年4月25日16:44:04 批量修改房态 有效星期 start
    $(".house_weeks [name='house_week']:checkbox").click(function () {
        allchk("#ftweek_check");
    });
    $(".house_weeks [name='house_week_price']:checkbox").click(function () {
        allchk("#fjweek_check");
    });
//2017年4月25日16:44:04 批量修改房态 有效星期 end


})
//供应商基本信息-验证信息
//验证供应商不能为空
function suppy_name() {
    var suppy = $("#suppy_name").val();
    if (suppy == "" || suppy.substring(0, suppy.length) == 0) {
        $("#suppy_name").siblings("i").show();
        return false;
    } else {
        $("#suppy_name").siblings("i").hide();
    }
}
function suppy_name2() {
    var suppy = $("#suppy_name2").val();
    if (suppy == "" || suppy.substring(0, suppy.length) == 0) {
        $("#suppy_name2").siblings("i").show();
        return false;
    } else {
        $("#suppy_name2").siblings("i").hide();
    }
}
//验证地址不能为空
function add_detail() {
    var suppy = $("#add_detail").val();
    if (suppy == "" || suppy.substring(0, suppy.length) == 0) {
        $("#add_detail").parent(".address_box").siblings("i").show();
        return false;
    } else {
        $("#add_detail").parent(".address_box").siblings("i").hide();
    }
}
//2017年4月25日16:44:04 批量修改房态 有效星期
// 房态全选、取消全选的事件
function CheckAll(node) {
    var collMailNodes = document.getElementsByName("house_week");
    for (var x = 0; x < collMailNodes.length; x++) {
        collMailNodes[x].checked = node.checked;
    }
}
//2017年4月25日16:44:04房价全选、取消全选的事件

function CheckAllfj(node) {
    var collMailNodes = document.getElementsByName("house_week_price");
    for (var x = 0; x < collMailNodes.length; x++) {
        collMailNodes[x].checked = node.checked;
    }
}
//2017年4月25日16:44:04房价子全选、取消全选的事件
function allchk(c) {
    var chknum = $(".house_weeks [name='house_week']:checkbox").size();//选项总个数
    var chk = 0;
    $(".house_weeks [name='house_week']:checkbox").each(function () {
        if ($(this).prop("checked") == true) {
            chk++;
        }
    });
    if (chknum == chk) {//全选
        $(c).prop("checked", true);
    } else {//不全选
        $(c).prop("checked", false);
    }
}
//2017年4月25日16:44:04房价子全选、取消全选的事件 end
