/**
 * Created by lele on 2017/8/17.
 */
$(function(){
    var orderNum =$("#orderNum").val();// 订单单号
    var lodgerName=$("#ydName").val(); // 预订人姓名
    var lodgerMobile=$("#ydMobile").val(); // 预订人手机
    var timeType=$("#selDate").val(); //时间类型
    var beginTime =$("#date_start").val(); //开始时间
    var endTime=$("#date_end").val(); // 结束时间
    var houseId=$("#houseId").val(); // 房源id
    var houseName =$("#houseName").val();//房源名
    var houseSource=$("#houseSource").val(); //房源来源
    // 因现在没有区分来源所以现在先隐藏掉 接口传空  2017年11月15日15:30:30 琳涛
    //var orderSource=$("#orderSource").val(); //订单来源
    var orderSource=''; //订单来源
    var landlordName=$("#landlordName").val(); //房东姓名
    var landlordMobile=$("#landlordMobile").val(); //房东手机
    var orderStatus=$("#orderStatus").val(); //订单状态
    var national=$("#country").val(); //国家code
    var city=$("#city").val();; //城市code
    var province=$("#province").val(); //省份code
    var county=$("#area").val(); //区code
    var pageNum=1; //第几页 必传
    var pageSize=$('#pageSize').val();//每页几条 必传
    var tabModel = ''; // tab合并订单状态(退款待审核、已结算)
    var absUrl = serveUrl();
    var ajax_data = {orderNum:orderNum,lodgerName:lodgerName,lodgerMobile:lodgerMobile,timeType:timeType,beginTime:beginTime,endTime:endTime,houseId:houseId,houseName:houseName,houseSource:houseSource,orderSource:orderSource,landlordName:landlordName,landlordMobile:landlordMobile,orderStatus:orderStatus,pageNum:pageNum,pageSize:pageSize,national:national,city:city,province:province,county:county,tabModel:tabModel};
    var initList = function() {
        bindEvt();  // 事件
        getCity();//城市四级联动
        getDetail(ajax_data);
    };
    var getCity = function(){//城市四级联动
            var cityurl = absUrl+'/api/dt/cityall';
            $.ajax({
                type:'GET',
                url:cityurl,
                data:'',
                beforeSend: function(){
                    $("#load").fadeIn();
                },
                success:function(res){
                    $("#load").fadeOut();
                    if(res.code=='0') {
                        var country = res.data.nation; // 国家
                        var province = res.data.province; // 省份
                        var city = res.data.city; //城市
                        var area = res.data.area; //地区
                        var dataCountry = [];
                        var dataProvince = [];
                        var dataCity = [];
                        var dataArea = [];
                        //console.log(country,province,city,area);
                        dataCountry.push(
                            '<select id="country">',
                            '<option value="">国家</option>'
                        );
                        $.each(country, function (i, obj) {
                            dataCountry.push(
                                '<option value=' + obj.code + '>' + obj.name + '</option>'
                            );
                        });
                        dataCountry.push('</select>');
                        $("#country").html('');
                        $("#country").html(dataCountry.join(''));
                        $("#country").on("change", function () {
                            if ($(this).val() != '10001' && $(this).val() != '') { // 中国四级 国外三级
                                $("#area").hide();
                            } else {
                                $("#area").show();
                            }
                            dataProvince = [];
                            dataCity = [];
                            dataArea = [];
                            dataProvince.push(
                                '<select id="province">',
                                '<option value="" >省</option>'
                            );
                            $.each(province, function (i, obj) {
                                if ($("#country").val() == obj.parent) {
                                    dataProvince.push(
                                        '<option value=' + obj.code + '>' + obj.name + '</option>'
                                    );
                                }
                            });
                            dataProvince.push(
                                '</select>'
                            );
                            $("#province").html('');
                            $("#city").html('<option value="">市</option>');
                            $("#area").html('<option value="">区</option>');
                            $("#province").html(dataProvince.join(''));
                        })
                        $("#province").on("change", function () {
                            $("#city").html('');
                            $("#area").html('<option value="">区</option>');
                            dataCity = [];
                            dataArea = [];
                            dataCity.push(
                                '<select id="city">',
                                '<option value="">市</option>'
                            );
                            $.each(city, function (i, obj) {
                                if ($("#province").val() == obj.parent) {
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
                        $("#city").on("change", function () {
                            $("#area").html('');
                            dataArea = [];
                            dataArea.push(
                                '<select id="area">',
                                '<option value="">区</option>'
                            );
                            $.each(area, function (i, obj) {
                                if ($("#city").val() == obj.parent) {
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
                        if (zc_store.get('jlisdtl') == 'true') {
                            //session 里有数据 回显城市
                            ajax_data = JSON.parse(zc_store.get('ajax_data'));
                            //console.log(ajax_data)
                            if (ajax_data.city != '' || ajax_data.national != '' || ajax_data.province != '' || ajax_data.county != '') {
                                //console.log(country, province, city, area);
                                var reloadCity = function (arr, paragu, dataarr, id, name) {
                                    if (arr.length > 0) {
                                        dataarr.push('<option value="">' + name + '</option>');
                                        $.each(arr, function (i, obj) {
                                            if (paragu == obj.parent) {
                                                dataarr.push(
                                                    '<option value=' + obj.code + '>' + obj.name + '</option>'
                                                );
                                                $(id).html(dataarr.join(''));
                                            }
                                        })
                                    }
                                };
                                if (ajax_data.national != '10001' && ajax_data.national != '') { // 中国四级 国外三级
                                    $("#area").hide();
                                } else {
                                    $("#area").show();
                                }
                                reloadCity(province, ajax_data.national, dataProvince, '#province', '省份');
                                reloadCity(city, ajax_data.province, dataCity, '#city', '城市');
                                reloadCity(area, ajax_data.city, dataArea, '#area', '区');
                                $("#country").val(ajax_data.national).selected;//国家
                                $("#province").val(ajax_data.province).selected;//省份
                                $("#city").val(ajax_data.city).selected;//城市
                                if (ajax_data.county != '') {
                                    $("#area").val(ajax_data.county).selected; // 区
                                }
                            }
                            zc_store.set('jlisdtl', false);

                        }
                    }else{
                        layer.msg(res.msg);
                    }
                },
                error:function(xhr) {
                    console.log('ajax error');
                    // alert('ajax error');
                }
            });



    }
    var bindEvt = function() {
        $("#search").on("click",search);//搜索
        $("#clear").on("click",clearDate);// 清除数据
        $("body").on("click",'#pullExcel',pullExcel); // 导出列表
        $("#detail_ul").on("click",'li',detailDetail); // 统计标签
        $("#pageSize").on("change",pageSizeChange); // 选择每页显示条数
        $("#pagination").on("click",'a',pageClick); // 翻页
        $('body').on("click",'.o_sure',popBoxsure);//确认弹框
        $('body').on("click",'.o_cancel',popBoxcancel);//取消弹框
        $('body').on("click",'.o_shtg',popBoxshtg);//审核通过弹框
        $('body').on("click",'.o_bhtk',popBoxreject);//驳回退款弹框
        $('body').on("click",'.o_qrwtg',popBoxnopass);//确认未通过弹框
        $('body').on("click",'.jlsqtk',popBoxRefund);//申请退款弹框
        $("body").on("click",'#sure_sure',sureSure);//确认订单确认按钮
        $("body").on("click",'#cancel_sure',cancelSure);//取消订单确认按钮
        $("body").on("click",'#pass_sure',passSure);//审核通过确认按钮
        $("body").on("click",'#reject_sure',rejectSure);//驳回退款确认按钮
        $("body").on("click",'#nopass_sure',nopassSure);//确认未通过确认按钮
        $("body").on("click",'#refund_sure',refundSure);//申请退款按钮
        $("body").on('click','.godetail',goDetail);// 跳转详情页
    };
    var goDetail = function () {
        zc_store.set("ajax_data",ajax_data); // 存 session 筛选项
    }
    var pullExcel = function () { //导出列表
        if($('#ddListData').attr('data')==0){
            layer.msg('暂无数据可导出');
            return;
        }
        var url = absUrl+'/api/finance/order/exportAll';
        var oarr = JSON.parse(zc_store.get('ajax_data'))||ajax_data; // 导出带状态列表的数据参数
        //console.log(oarr);
        var arr = [];
        var str='';
        for(var i in oarr) {
            arr.push([i, oarr[i]]);
        }
        $.each(arr, function (i,obj) {
            str+='&'+obj[0]+'='+obj[1];
        })
        window.location.href = url+'?123'+str; // 导出
    }
    var popBoxsure= function () { // 确认弹框
        zc_store.set("jlorderId",$(this).parents('td').attr("orderId")); // 订单id
        $("#myModal").modal('show');
    };
    var sureSure = function () {//确认订单 确定按钮
        var url = absUrl+'/api/finance/order/confirm';
        var orderId =zc_store.get("jlorderId"); // 订单id
        var updateBy = parseInt($('#opeRate').val()); //操作人id
        var ajax_shtg = {orderId:orderId,updateBy:updateBy};
        var ajax_shtgstr = JSON.stringify(ajax_shtg);
        //console.log(ajax_shtgstr);
        $.ajax({
            type:'POST',
            url:url,
            data:ajax_shtgstr,
            contentType:"application/json",
            success:function(res){
                //console.log(res);//
                if(res.code=='0'){
                    $("#myModal").modal('hide');
                    // 刷新更改状态
                    ajax_data = JSON.parse(zc_store.get('ajax_data'))||ajax_data;// session没值用默认
                    ajax_data.pageNum = zc_store.get('pagenum');
                    ajax_data.pageSize = zc_store.get('pagesize');
                    getDetail(ajax_data);
                }else {
                    layer.msg(res.msg);

                }
            },
            error:function(xhr) {
                console.log('ajax error');
                // alert('ajax error');
            }
        });

    }
    var popBoxcancel= function () { //取消订单弹框
        $("#cancelRemark").val(''); // 输入框值为空
        zc_store.set("jlorderId",$(this).parents('td').attr("orderId"));
        $("#myModal_cancel").modal('show');
    }
    var cancelSure = function () { //取消订单 确定按钮
        var url = absUrl+'/api/finance/order/reject';
        var orderId =zc_store.get("jlorderId"); // 订单id
        var updateBy = parseInt($('#opeRate').val()); //操作人id
        var cancelReason = $("#cancelRemark").val(); // 备注
        var ajax_shtg = {orderId:orderId,updateBy:updateBy,cancelReason:cancelReason};
        var ajax_shtgstr = JSON.stringify(ajax_shtg);
        //console.log(ajax_shtgstr)
        $.ajax({
            type:'POST',
            url:url,
            data:ajax_shtgstr,
            contentType:"application/json",
            success:function(res){
                //console.log(res);
                if(res.code=='0'){
                    $("#myModal_cancel").modal('hide');
                    // 刷新更改状态
                    ajax_data = JSON.parse(zc_store.get('ajax_data'))||ajax_data;// session没值用默认
                    ajax_data.pageNum = zc_store.get('pagenum');
                    ajax_data.pageSize = zc_store.get('pagesize');
                    getDetail(ajax_data);
                }else {
                    layer.msg(res.msg);

                }
            },
            error:function(xhr) {
                console.log('ajax error');
                // alert('ajax error');
            }
        });
    }

    var popBoxshtg= function () { //审核通过
        zc_store.set("jlorderId",$(this).parents('td').attr("orderId"));
        $("#myModal_pass").modal('show');

    }
    var passSure= function () { //审核通过
        var url = absUrl+'/api/finance/order/audit/pass';
        var orderId =parseInt(zc_store.get("jlorderId")); // 订单id
        var updateBy = $('#opeRate').val(); //操作人id
        var ajax_shtg = {orderId:orderId,updateBy:updateBy};
        var ajax_shtgstr = JSON.stringify(ajax_shtg);
        //console.log(updateBy,ajax_shtgstr);
        $.ajax({
            type:'POST',
            url:url,
            data:ajax_shtgstr,
            contentType:"application/json",
            success:function(res){
                //console.log(res);
                if(res.code=='0'){
                    $("#myModal_pass").modal('hide');
                    // 刷新更改状态
                    ajax_data = JSON.parse(zc_store.get('ajax_data'))||ajax_data;// session没值用默认
                    ajax_data.pageNum = zc_store.get('pagenum');
                    ajax_data.pageSize = zc_store.get('pagesize');
                    //console.log(ajax_data,ajax_data.orderStatus)
                    getDetail(ajax_data);
                }else {
                    layer.msg(res.msg);

                }
            },
            error:function(xhr) {
                console.log('ajax error');
                // alert('ajax error');
            }
        });

    }

    var popBoxreject= function () { //驳回退款
        $("#rejectRemark").val(''); // 输入框值为空
        zc_store.set("jlorderId",$(this).parents('td').attr("orderId"));
        $("#myModal_reject").modal('show');
    }
    var rejectSure= function () { // 驳回退款
        var url = absUrl+'/api/finance/order/audit/refuse';
        var orderId =parseInt(zc_store.get("jlorderId")); // 订单id
        var updateBy = $('#opeRate').val(); //操作人id
        var cancelReason = $("#rejectRemark").val();// 驳回原因
        var ajax_shtg = {orderId:orderId,updateBy:updateBy,cancelReason:cancelReason};
        var ajax_shtgstr = JSON.stringify(ajax_shtg);
        //console.log(cancelReason,ajax_shtgstr);
        $.ajax({
            type:'POST',
            url:url,
            data:ajax_shtgstr,
            contentType:"application/json",
            success:function(res){
                //console.log(res);//
                if(res.code=='0'){
                    $("#myModal_reject").modal('hide');
                    //刷新状态
                    ajax_data = JSON.parse(zc_store.get('ajax_data'))||ajax_data;// session没值用默认
                    ajax_data.pageNum = zc_store.get('pagenum');
                    ajax_data.pageSize = zc_store.get('pagesize');
                    getDetail(ajax_data);

                }else {
                    layer.msg(res.msg);

                }
            },
            error:function(xhr) {
                console.log('ajax error');
                // alert('ajax error');
            }
        });

    }
    var popBoxnopass= function () { // 确认未通过弹框
        $("#nopassRemark").val('');// 输入框为空
        zc_store.set("jlorderId",$(this).parents('td').attr("orderId"));
        $("#myModal_nopass").modal('show');
    }
    var nopassSure= function () { // 确认未通过弹框
        var url = absUrl+'/api/finance/order/reaudit/refuse';
        var orderId =parseInt(zc_store.get("jlorderId")); // 订单id
        var updateBy = parseInt($('#opeRate').val()); //操作人id
        var cancelReason = $("#nopassRemark").val();// 备注
        var ajax_shtg = {orderId:orderId,updateBy:updateBy,cancelReason:cancelReason};
        var ajax_shtgstr = JSON.stringify(ajax_shtg);
        //console.log(ajax_shtgstr);
        $.ajax({
            type:'POST',
            url:url,
            data:ajax_shtgstr,
            contentType:"application/json",
            success:function(res){
                //console.log(res);//
                if(res.code=='0'){
                    $("#myModal_nopass").modal('hide');
                    //刷新状态
                    ajax_data = JSON.parse(zc_store.get('ajax_data'))||ajax_data;// session没值用默认
                    ajax_data.pageNum = zc_store.get('pagenum');
                    ajax_data.pageSize = zc_store.get('pagesize');
                    getDetail(ajax_data);
                }else {
                    layer.msg(res.msg);

                }
            },
            error:function(xhr) {
                console.log('ajax error');
                // alert('ajax error');
            }
        });

    }
    var popBoxRefund= function () { // 申请退款弹框
        zc_store.set("jlorderId",$(this).parents('td').attr("orderId"));
        var orderId = $(this).parents('td').attr("orderId");
        var url= absUrl+'/api/finance/order/apply/refund/'+orderId;
        $("#refundRemark").val('');
        //console.log(url)
        $.ajax({
            type: 'GET',
            url: url,
            data: '',
            success: function (res) {
                //console.log(res)
                if(res.code=='0') {
                    $('#refundAmount').html('¥' + res.data).attr("val",res.data);
                    if(res.data<0){
                        res.data = 0;
                    }
                    $('#jlstmoney').val(res.data).attr("placeholder",res.data);
                    $("#myModal_refund").modal('show');
                }else{
                    layer.msg(res.msg);

                }
            },
            error:function(xhr) {
                console.log('ajax error');
                // alert('ajax error');
            }
        })

    }
    var refundSure= function () { // 申请退款确定按钮
        var url = absUrl+'/api/finance/order/apply/refund';
        var orderId =parseInt(zc_store.get("jlorderId")); // 订单id
        var updateBy = parseInt($('#opeRate').val()); //操作人id
        var cancelReason = $("#refundRemark").val();// 备注
        var actualAmount =$('#jlstmoney').val() ; //实际退款金额
        var subsidyPlatform = $("input[name=butie]:checked").val();//补贴平台
        var refundAmount = $("#refundAmount").attr('val');//申请退款金额
        //console.log(subsidyPlatform,'subsidyPlatform');
        var ajax_shtg = {orderId:orderId,updateBy:updateBy,actualAmount:actualAmount,subsidyPlatform:subsidyPlatform,cancelReason:cancelReason,refundAmount:refundAmount};
        var ajax_shtgstr = JSON.stringify(ajax_shtg);
        //console.log(ajax_shtgstr);
        //console.log(actualAmount,refundAmount)
        if(Number(actualAmount)>=Number(refundAmount)){
            $.ajax({
                type:'POST',
                url:url,
                data:ajax_shtgstr,
                contentType:"application/json",
                success:function(res){
                    //console.log(res);//
                    if(res.code=='0'){

                        $("#myModal_refund").modal('hide');
                        //刷新状态
                        ajax_data = JSON.parse(zc_store.get('ajax_data'))||ajax_data;// session没值用默认
                        ajax_data.pageNum = zc_store.get('pagenum');
                        ajax_data.pageSize = zc_store.get('pagesize');
                        getDetail(ajax_data);
                    }else {
                        layer.msg(res.msg);

                    }
                },
                error:function(xhr) {
                    console.log('ajax error');
                    // alert('ajax error');
                }
            });
        }else{
            alert('实退金额应大于等于应退金额');
            return ;
        }


    }

    var pageSizeChange = function () { // 每页显示条数
        ajax_data = JSON.parse(zc_store.get('ajax_data'))||ajax_data;
        ajax_data.pageSize = $(this).val();
        ajax_data.pageNum = 1;
        getDetail(ajax_data);
    }
    var pageClick = function(){ // 页码点击
        ajax_data = JSON.parse(zc_store.get('ajax_data'))||ajax_data;
        ajax_data.pageNum =$(this).attr("data-current");
        ajax_data.pageSize = $("#pageSize").val();
        zc_store.set("ajax_data",ajax_data); // 存 session 筛选项
        zc_store.set("pagenum",$(this).attr("data-current")); //
        zc_store.set("pagesize",$("#pageSize").val()); //
        //console.log(ajax_data,1111);
        getDetail(ajax_data);
    }; // 翻页
    var detailDetail =function(){ // 统计标签
        if($(this).hasClass('current')){
            return false;
        }
        var status = $(this).attr("status"); // orderstatus
        var tabmodel = $(this).attr("tabmodel");// 合并状态
        $(this).addClass('current').siblings('li').removeClass('current');
        if(zc_store.get('ajax_data')){
            ajax_data = JSON.parse(zc_store.get('ajax_data'));// 读session
        }
        //console.log(ajax_data,112);

        if(status==''){ // 全部订单
            ajax_data.orderStatus = '';
        }
        if(status==11){ // 待付款
            ajax_data.orderStatus = 11;
        }
        if(status==1){ // 待确认
            ajax_data.orderStatus = 1;
        }
        if(status==21){ // 待入住
            ajax_data.orderStatus = 21;
        }
        if(status==31){ // 已入住
            ajax_data.orderStatus = 31;
        }
        if(status==32){ // 已完成
            ajax_data.orderStatus = 32;
        }
        if(tabmodel==1){ //退款待审核 合并数据
            ajax_data.tabModel = 1;
        }else if(tabmodel==2){ // 已结算
            ajax_data.tabModel = 2; // 合并数据
        }else{
            ajax_data.tabModel = ''; // 不合并数据
        }
        ajax_data.pageNum = 1;
        ajax_data.pageSize = $("#pageSize").val();
        zc_store.set("ajax_data",ajax_data); // 存 session 筛选项
        getDetail(ajax_data);
    };
    var clearDate = function(){ //清空
        $("#orderNum,#ydName,#ydMobile,#landlordName,#houseId,#landlordMobile,#houseName,#date_start,#date_end,#selDate,#country,#area,#city,#province,#orderStatus,#orderSource,#houseSource").val("");
    }
    var search = function () { // 搜索
        //默认状态为全部订单
        $("#detailAll").addClass("current").siblings("li").removeClass("current");
        var orderNum =$("#orderNum").val();// 订单单号
        var lodgerName=$("#ydName").val(); // 预订人姓名
        var lodgerMobile=$("#ydMobile").val(); // 预订人手机
        var timeType=$("#selDate").val(); //时间类型
        var beginTime =$("#date_start").val(); //开始时间
        var endTime=$("#date_end").val(); // 结束时间
        var houseId=$("#houseId").val(); // 房源id
        var houseName =$("#houseName").val();//房源名
        var houseSource=$("#houseSource").val(); //房源来源
        // 因现在没有区分来源所以现在先隐藏掉 接口传空  2017年11月15日15:30:30 琳涛
        //var orderSource=$("#orderSource").val(); //订单来源
        var orderSource=''; //订单来源
        var landlordName=$("#landlordName").val(); //房东姓名
        var landlordMobile=$("#landlordMobile").val(); //房东手机
        var orderStatus=$("#orderStatus").val(); //订单状态
        var national=$("#country").val();; //国家code
        var city=$("#city").val();; //城市code
        var province=$("#province").val(); //省份code
        var county=$("#area").val();; //区code
        var pageNum=$("#pageNum").val(); //第几页
        var pageSize=$("#pageSize").val();//每页几条
        var tabModel = '';// 合并状态
        //console.log(national,city,county,province);
        ajax_data = {orderNum:orderNum,lodgerName:lodgerName,lodgerMobile:lodgerMobile,timeType:timeType,beginTime:beginTime,endTime:endTime,houseId:houseId,houseName:houseName,houseSource:houseSource,orderSource:orderSource,landlordName:landlordName,landlordMobile:landlordMobile,orderStatus:orderStatus,pageNum:pageNum,pageSize:pageSize,national:national,city:city,province:province,county:county,tabModel:tabModel};
        zc_store.set("ajax_data",ajax_data); // 存 session 筛选项
        if(beginTime==null && endTime!=null || beginTime==''&& endTime!=''||beginTime!=null && endTime==null || beginTime!=''&& endTime==''){
            layer.msg("请选择时间范围");
            return false;
        }
        //if(beginTime=="" && endTime==''&&orderNum=='' && lodgerName=='' && lodgerMobile=='' && landlordName=='' && landlordMobile=='' &&  houseId=='' && houseName==''&&county==''&& city=='' && province=="" && national==""){
        //    layer.msg("查询条件不能为空");
        //    return false;
        //}
        //console.log(ajax_data);
        getDetail(ajax_data);
    }
    var getDetail = function(ajax_data) { // 拉数据
        var ajax_url = absUrl+'/api/finance/order/orders';
        //console.log(ajax_data);
           if(zc_store.get('jlisdetail')=='true'){
               ajax_data = JSON.parse(zc_store.get('ajax_data'));

               if(zcGetLocationParm("pagenum")!=''){
                   ajax_data.pageNum =zcGetLocationParm("pagenum");
               }
               if(zcGetLocationParm("pagesize")!=''){
                   ajax_data.pageSize =zcGetLocationParm("pagesize");
               }
               if(zcGetLocationParm("tabstatus")!=''){
                   var val = zcGetLocationParm('tabstatus');
                   for(var i=0;i<$("#detail_ul li").length;i++){
                       if($("#detail_ul li").eq(i).attr('status')==val){
                           $("#detail_ul li").eq(i).addClass("current").siblings('li').removeClass("current");
                       }
                   }
               }
               $("#orderNum").val(ajax_data.orderNum);// 订单号
               $("#ydName").val(ajax_data.lodgerName);// 预订人姓名
               $('#selDate').val(ajax_data.timeType).selected; // 日期类型
               $("#date_start").val(ajax_data.beginTime); //开始日期
               $("#date_end").val(ajax_data.endTime); //结束日期
                $("#ydMobile").val(ajax_data.lodgerMobile);// 预订人手机号
               $("#country").val(ajax_data.national).selected;//国家
               $("#province").val(ajax_data.province).selected;//省份
               $("#city").val(ajax_data.city).selected;//城市
               $("#area").val(ajax_data.county).selected; // 区
               $('#landlordName').val(ajax_data.landlordName);//房东姓名
               $("#houseId").val(ajax_data.houseId); // 房源id
               $("#landlordMobile").val(ajax_data.landlordMobile); //房东手机
               $("#houseName").val(ajax_data.houseName);//房源名
               $("#orderStatus").val(ajax_data.orderStatus).selected; //订单状态
               $("#houseSource").val(ajax_data.houseSource).selected; //房源来源

               // 因现在没有区分来源所以现在先隐藏掉 接口传空  2017年11月15日15:30:30 琳涛
               //$("#orderSource").val(ajax_data.orderSource).selected; //订单来源

               $("#pageSize").val(ajax_data.pageSize).selected; // 条数选定
               zc_store.set('jlisdetail',false);
           }else{
               zc_store.set('ajax_data',ajax_data);
           }
        //console.log(ajax_data);
        ajax_data_str = JSON.stringify(ajax_data);
        //console.log(ajax_data_str);
        $.ajax({
            type:'POST',
            url:ajax_url,
            data:ajax_data_str,
            contentType:"application/json",
            beforeSend: function(){
                $(".shade_wrap").fadeIn();
            },
            success:onGetDetailSuccess,
            error:function(xhr) {
                layer.msg('加载数据失败');
                $(".shade_wrap").fadeOut();
                console.log('ajax error');
            }
        });
    };
    var onGetDetailSuccess = function(res) {
        $(".shade_wrap").fadeOut(); // 加载蒙层隐藏
        $("#ddListData").html(''); // 列表数据
        $("#pagination").html(""); // 翻页
        //console.log(res);
        if(res.code=='0') {
            var page_num = 0;
            //console.log(res.pageInfo.total,000000000000,$("#pageSize").val())
            if(Number(res.pageInfo.total) == 0){
                $("#ddListData").html("暂时没有数据").attr('data',0);
            }else if(Number(res.pageInfo.total) < $("#pageSize").val()){
                page_num = 1;
                $("#ddListData").attr('data',1);
            }else{
                $("#ddListData").attr('data',1);
                var pagesize = parseInt($("#pageSize").val());//页码
                if(parseInt(res.pageInfo.total % pagesize)==0){
                    page_num = parseInt(res.pageInfo.total / pagesize);
                }else{
                    page_num = parseInt(res.pageInfo.total / pagesize)+1;

                }
                //console.log(page_num,'页码')
            }
            $("#totalNum").html(page_num);// 总页
            var data = [];
            var opeRate = $("#opeRate").val();// 操作者id
            var eachData = res.pageInfo.list;
            if(eachData.length==0) { // 汇总数据为空
                $("#ddListData").html("暂无数据");
            }else{
                data.push(
                    '<table class="table table-bordered" style="width: 1500px;">',
                    '<tbody>',
                    '<tr bgcolor="#f5f6fa">',
                    '<td style="width: 12%;">',
                    ' <span style="display:inline-block">商品信息</span>',
                    ' </td>',
                    ' <td style="width: 6%;">城市</td>',
                    ' <td style="width: 6%;">订单总价</td>',
                    ' <td style="width: 6%;">实际支付金额</td>',
                    ' <td style="width: 6%;">申请退款金额</td>',
                    ' <td style="width: 6%;">优惠金额</td>',
                    ' <td style="width: 15%;">入住时间</td>',
                    ' <td style="width: 5%;">间夜</td>',
                    ' <td style="width: 8%;">支付方式</td>',
                    ' <td style="width: 8%;">订单状态</td>',
                    ' <td style="width: 12%;">操作</td>',
                    ' </tr>'
                );
                $.each(eachData, function (i,obj) {
                    var houseTitle=obj.houseTitle;
                    if(houseTitle.length>8){ //房源名称不大于8个字
                        houseTitle = houseTitle.substr(0,8)+'...';
                    }
                    var sfm=2;
                    var isRealtime =obj.realtime;//闪电预订
                    if(isRealtime){
                        isRealtime = '⚡';
                    }else{
                        isRealtime = '';
                    }
                    var payPlatform = obj.payPlatform;
                    if(payPlatform==1){
                        payPlatform ="支付宝";
                    }else if(payPlatform==2){
                        payPlatform ="微信";

                    }else if(payPlatform==3){
                        payPlatform ="银联";
                    }else{
                        payPlatform ="--";
                    }
                    var operate = '';// 操作
                    var orderStauts = obj.orderStauts; // 订单状态
                    if(orderStauts==1){
                        orderStauts = '待确认';
                        operate = '<span class="o_sure">确认</span>&nbsp;&nbsp;<span class="o_cancel">取消</span>&nbsp;&nbsp;<a href="dd_ms_detail?orderId='+obj.id+'" class="godetail">详情</a> ';
                    }else if(orderStauts==11){
                        orderStauts = '待付款';
                        operate = '<span class="o_cancel">取消</span>&nbsp;&nbsp;<a href="dd_ms_detail?orderId='+obj.id+'" class="godetail">详情</a> ';
                    }else if(orderStauts==12){
                        orderStauts = '已拒绝';
                        operate = '<a href="dd_ms_detail?orderId='+obj.id+'" class="godetail">详情</a> ';
                    }else if(orderStauts==41){
                        orderStauts = '房客支付超时';
                        operate = '<a href="dd_ms_detail?orderId='+obj.id+'" class="godetail">详情</a> ';
                    }else if(orderStauts==42){
                        orderStauts = '房东确认超时';
                        operate = '<a href="dd_ms_detail?orderId='+obj.id+'" class="godetail">详情</a> ';

                    }else if(orderStauts==3){
                        orderStauts ='用户已取消';
                        operate = '<a href="dd_ms_detail?orderId='+obj.id+'" class="godetail" class="godetail">详情</a> ';

                    }else if(orderStauts==4){
                        orderStauts = '客服已取消';
                        operate = '<a href="dd_ms_detail?orderId='+obj.id+'" class="godetail">详情</a> ';

                    }else if(orderStauts==21){
                        orderStauts = '待入住';
                        operate = '<span class="jlsqtk">申请退款</span>&nbsp;&nbsp;<a href="dd_ms_detail?orderId='+obj.id+'" class="godetail">详情</a> ';

                    }else if(orderStauts==31){
                        orderStauts = '已入住';
                        operate = '<span class="jlsqtk">申请退款</span>&nbsp;&nbsp;<a href="dd_ms_detail?orderId='+obj.id+'" class="godetail">详情</a> ';
                    }else if(orderStauts==32){
                        orderStauts = '已完成';
                        operate = '<a href="dd_ms_detail?orderId='+obj.id+'" class="godetail">详情</a> '; //正确
                    }else if(orderStauts==34){
                        orderStauts = '已结算';
                        operate = '<a href="dd_ms_detail?orderId='+obj.id+'" class="godetail" class="godetail">详情</a> ';
                    }else if(orderStauts==51){
                        orderStauts = '退款申请中';
                        operate = '<span class="o_shtg">审核通过</span>&nbsp;&nbsp;<span class="o_bhtk">驳回退款</span>&nbsp;&nbsp;<a href="dd_ms_detail?orderId='+obj.id+'" class="godetail">详情</a> ';

                    }else if(orderStauts==52){
                        orderStauts = '退款待确认';
                        operate = '<a href="dd_ms_detail?orderId='+obj.id+'" class="godetail">详情</a> ';

                    }else if(orderStauts==57){
                        orderStauts = '待退款';
                        operate = '<a href="dd_ms_detail?orderId='+obj.id+'" class="godetail">详情</a> ';

                    }else if(orderStauts==56){
                        orderStauts = '退款未通过';
                        operate = '<span class="o_qrwtg">确认未通过</span>&nbsp;&nbsp;<span class="jlsqtk">申请退款</span>&nbsp;&nbsp;<a href="dd_ms_detail?orderId='+obj.id+'" class="godetail">详情</a> ';

                    }else if(orderStauts==58){
                        orderStauts = '财务拒绝';
                        operate = '<span class="jlsqtk">申请退款</span>&nbsp;&nbsp;<span class="o_bhtk">驳回退款</span>&nbsp;&nbsp;<a href="dd_ms_detail?orderId='+obj.id+'" class="godetail">详情</a> ';

                    }else if(orderStauts==54){
                        orderStauts = '退款中';
                        operate = '<a href="dd_ms_detail?orderId='+obj.id+'" class="godetail">详情</a> ';

                    }else if(orderStauts==55){
                        orderStauts = '退款完成';
                        operate = '<a href="dd_ms_detail?orderId='+obj.id+'" class="godetail">详情</a> ';

                    }else if(orderStauts==59){
                        orderStauts = '拒绝退款';
                        operate = '<a href="dd_ms_detail?orderId='+obj.id+'" class="godetail">详情</a> ';

                    }else if(orderStauts==61){
                        orderStauts = '结算待审核';
                        operate = '<a href="dd_ms_detail?orderId='+obj.id+'" class="godetail">详情</a> ';

                    }else if(orderStauts==62){
                        orderStauts = '结算未通过';
                        operate = '<a href="dd_ms_detail?orderId='+obj.id+'" class="godetail" class="godetail">详情</a> ';

                    }else if(orderStauts==63){
                        orderStauts = '结算待确认';
                        operate = '<a href="dd_ms_detail?orderId='+obj.id+'" class="godetail">详情</a> ';

                    }else if(orderStauts==64){
                        orderStauts = '结算待打款';
                        operate = '<a href="dd_ms_detail?orderId='+obj.id+'" class="godetail">详情</a> ';

                    }else if(orderStauts==65) {
                        orderStauts = '付款失败';
                        operate = '<a href="dd_ms_detail?orderId='+obj.id+'" class="godetail">详情</a> ';

                    }else if(orderStauts==66) {
                        orderStauts = '结算拒绝';
                        operate = '<a href="dd_ms_detail?orderId='+obj.id+'" class="godetail">详情</a> ';

                    }else if(orderStauts==67) {
                        orderStauts = '结算异常订单';
                        operate = '<a href="dd_ms_detail?orderId='+obj.id+'" class="godetail">详情</a> ';

                    }else if(orderStauts==68){
                        orderStauts = '已付款';
                        operate = '<a href="dd_ms_detail?orderId='+obj.id+'" class="godetail">详情</a> ';
                    }else if(orderStauts==69){
                        orderStauts = '付款中';
                        operate = '<a href="dd_ms_detail?orderId='+obj.id+'" class="godetail">详情</a> ';
                    }else{
                        orderStauts='-';
                    }

                    data.push(
                        '<tr bgcolor="#ffcc99">',
                        '<td colspan="11"  style="text-align: left">',
                        ' <em>订单ID：'+obj.id+'</em>',
                        '<em>订单编号：'+obj.orderNum+'</em>',
                        ' <em>下单日期:'+TimeToDate(obj.createTime,sfm)+'</em>',
                        ' <em>支付日期:'+TimeToDate(obj.payTime,sfm)+'</em>',
                        ' <em>用户名/用户电话:'+obj.reallyName+'/'+obj.mobile+'</em>',
                        ' </td>',
                        ' </tr>',
                        '<tr>',
                        '<td>',
                        '<span>'+isRealtime+houseTitle+'</span>',
                        '<em style="display:block">房源ID:'+obj.houseId+'</em>',
                        '</td>',
                        '<td>'+valNull(obj.houseCityName)+'</td>',
                        '<td>'+obj.total+'</td>',
                        '<td>'+valNull(obj.payAmount)+'</td>',
                        '<td>'+valNull(obj.refundAmount)+'</td>',
                        '<td>'+valNull(obj.couponAmount)+'</td>',
                        '<td>'+TimeToDate(obj.inTime)+'至'+TimeToDate(obj.outTime)+'</td>',
                        '<td>'+obj.bookHouseCount+'间|'+obj.dayNum+'晚</td>',
                        '<td>'+payPlatform+'</td>',
                        '<td>'+orderStauts+'</td>',
                        '<td ordernum='+obj.orderNum+' orderId='+obj.id+'>'+operate+'</td>',
                        ' </tr>'
                    )
                });
                data.push(
                    '</tbody>',
                    '</table>'
                );
                $("#ddListData").html(data.join(''));
                //分页，PageCount是总条目数，这是必选参数，其它参数都是可选
                $("#pagination").pagination({
                    currentPage: res.pageInfo.pageNum, //当前页
                    maxentries: res.pageInfo.total, // 总条数
                    items_per_page:  4,
                    num_display_entries: 5,
                    totalPage: page_num,
                    num_edge_entries: 2,       //两侧首尾分页条目数
                    homePageText: "首页",
                    endPageText: "尾页",
                    prevPageText: "上一页",
                    nextPageText: "下一页"
                    //callback: pageselectCallback // 回调函数

                });
                //function pageselectCallback (page_index) {
                //    ajax_data.pageNum = page_index;
                //    getDetail(ajax_data);
                //    return false;
                //}

            }
            if($("#detail_ul li").hasClass("current")){
                zc_store.set("tabstatus",$("#detail_ul li.current").attr('status')); // 存 session 筛选项
            }
            zc_store.set("pagesize",$("#pageSize").val()); // 存 session 每页几条
            zc_store.set("pagenum",res.pageInfo.pageNum); // 存 session 第几页

        }else {
            layer.msg(res.msg);
        }

    };

    initList();
})