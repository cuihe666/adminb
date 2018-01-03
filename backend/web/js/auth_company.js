$(function(){
    /**
     * Created by Administrator on 2017/5/26 0026.
     */
//认证信息 公司/组织
    //港澳台海外旅行社
    //银行卡号和支付切换
    //         银行卡号和支付切换
    $("#bank_c").on("click",function(){
        $(this).parents("li").siblings("li.card_show").show();
        $(this).parents("li").siblings("li.zfb_show").hide();
    })
    $("#zfb_c").on("click",function(){
        $(this).parents("li").siblings("li.card_show").hide();
        $(this).parents("li").siblings("li.zfb_show").show();
    })

//companyadd 页面 next_btn  下一步
    $(".next_btn").on("click",function(){
        var company_country_val = $("#regcity").val(); //公司注册国家省市
        var travelcompany_name = $("#travelcompany-name").val();//公司全称
        var travelcompany_add = $("#travelcompany-company_address").val();//公司地址
        var travelcompany_ins = $("#travelcompany-recommend").val();//公司介绍
        var travelcompany_bankname = $("#travelcompany-brandname").val();//主页品牌名称

        var file_upload1 = $("[name='TravelCompany[travel_avatar]']").val(); // 头像

        var travelcompany_businessname = $("#travelcompany-business_name").val();//业务联系人姓名
        var travelcompany_tel = $("#travelcompany-business_tel").val();//业务联系人电话
        var travelcompany_email = $("#travelcompany-business_email").val();//业务联系人邮箱
        var regtel =/^[\d-]*$/; // 电话、手机号
        var regemail = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((.[a-zA-Z0-9_-]{2,3}){1,2})$/; //邮箱
        var checkprotocol = $("#check_c");
        var head_portrait  = $("#avatar").val()

        if(company_country_val=="" |company_country_val==" "){ //公司注册国家省市
            $("#regcity").siblings("i").text("请填写公司注册国家省市");
            return false;
        }else{
            $("#regcity").siblings("i").text("");
        }

        if(travelcompany_name=="" |travelcompany_name==" "){//公司全称
            $("#travelcompany-name").siblings("i").text("请填写公司全称");
            return false;
        }else{
            $("#travelcompany-name").siblings("i").text("");
        }

        if(travelcompany_add=="" |travelcompany_add==" "){//公司地址
            $("#travelcompany-company_address").siblings("i").text("请填写公司地址");
            return false;
        }else{
            $("#travelcompany-company_address").siblings("i").text("");
        }

        if(travelcompany_ins=="" |travelcompany_ins==" "){//公司介绍
            $("#travelcompany-recommend").siblings("i").text("请填写公司介绍");
            return false;
        }else{
            $("#travelcompany-recommend").siblings("i").text("");
        }

        if(travelcompany_bankname=="" |travelcompany_bankname==" "){//主页品牌名称
            $("#travelcompany-brandname").siblings("i").text("请填写主页品牌名称");
            return false;
        }else{
            $("#travelcompany-brandname").siblings("i").text("");
        }
        if(head_portrait == "" | head_portrait == "0"){// 头像
            $("#file").siblings("i").text("请添加头像信息");
            return false;
        }else{
            $("#file").siblings("i").text("");
        }
        if(file_upload1==""|file_upload1==" "){
            $("[name='TravelCompany[travel_avatar]']").parents(".file").siblings("i").text("请上传头像");
            return false;
        }else{
            $("[name='TravelCompany[travel_avatar]']").parents(".file").siblings("i").text("");
        }
        if(travelcompany_businessname=="" |travelcompany_businessname==" "){//业务联系人姓名
            $("#travelcompany-business_name").siblings("i").text("请填写业务联系人姓名");
            return false;
        }else{
            $("#travelcompany-business_name").siblings("i").text("");
        }
        if(travelcompany_tel=="" |travelcompany_tel==" "){//业务联系人电话
            $("#travelcompany-business_tel").siblings("i").text("请填写业务联系人电话");
            return false;
        }else{
            $("#travelcompany-business_tel").siblings("i").text("");
        }
        //else if(!regtel.test(travelcompany_tel)){
        //    $("#travelcompany-business_tel").siblings("i").text("请正确填写业务联系人电话");
        //    return false;
        //}

        if(travelcompany_email=="" |travelcompany_email==" "){// 邮箱
            $("#travelcompany-business_email").siblings("i").text("请填写邮箱");
            return false;
        }else if(!regemail.test(travelcompany_email)){
            $("#travelcompany-business_email").siblings("i").text("请正确填写邮箱");
            return false;
        }else{
            $("#travelcompany-business_email").siblings("i").text("");
        }

        if(checkprotocol.is(':checked')){
            checkprotocol.siblings("i").text("");
        }else{
            checkprotocol.siblings("i").text("请阅读并勾选协议");
            return false;

        }
    //跳转页面

    })

    //删除图片
    $("body").on("click",".close",function(){
        $(this).siblings("[type='hidden']").val("");
        $(this).siblings(".pic_box").attr("src"," ");
        $(this).parents(".tgpic_item").find(".close").hide();
    })


})