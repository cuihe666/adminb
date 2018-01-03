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
    var landlordName=$("#landlordName").val(); //房东姓名
    var landlordMobile=$("#landlordMobile").val(); //房东手机
    var orderStatus=67; //订单状态
    var national=$("#country").val(); //国家code
    var city=$("#city").val();; //城市code
    var province=$("#province").val(); //省份code
    var county=$("#area").val(); //区code
    var pageNum=1; //第几页 必传
    var pageSize=15;//每页几条 必传
    var absUrl = serveUrl();
    var handledStatus =''; // 结算异常订单
    var tabModel = ''; // tab合并订单状态(退款待审核、已结算)
    var ajax_data = {orderNum:orderNum,lodgerName:lodgerName,lodgerMobile:lodgerMobile,timeType:timeType,beginTime:beginTime,endTime:endTime,houseId:houseId,houseName:houseName,houseSource:houseSource,landlordName:landlordName,landlordMobile:landlordMobile,orderStatus:orderStatus,pageNum:pageNum,pageSize:pageSize,national:national,city:city,province:province,county:county,handledStatus:handledStatus,tabModel:tabModel};
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
                        var ajax_data = JSON.parse(zc_store.get('ajax_data'));
                        //console.log(ajax_data);
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
                    console.log(res.msg);
                }
            },
            error:function(xhr) {
                console.log('ajax error');
                // alert('ajax error');
            }
        });
    };
    var bindEvt = function() {
        $("#search").on("click",search);//搜索
        $("#clear").on("click",clearDate);// 清除数据
        $("body").on("click",'#pullExcel',pullExcel); // 导出列表
        $("#detail_ul").on("click",'li',detailDetail); // 统计标签
        $("#pageSize").on("change",pageSizeChange); // 选择每页显示条数
        $("#pagination").on("click",'a',pageClick); // 翻页
        $('body').on("click",'.o_edit',popBoxEdit);// 修改弹框
        $('body').on("click",'#editSure',editSure);// 修改弹框
    };
    var pullExcel = function () { //导出列表
        if($('#ddListData').attr('data')==0){
            layer.msg('暂无数据可导出');
            return;
        }
        var url = absUrl+'/api/finance/order/exportAll';
        var oarr = JSON.parse(zc_store.get('ajax_data'))||ajax_data; // 导出带状态列表的数据参数
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
    var popBoxEdit= function () { // 修改弹框
        zc_store.set("jlorderId",$(this).parents('td').attr("orderId")); // 订单id
        var fdyjmoney = $(this).parents('td').attr('fdys');//房东应收
        var mymodel_editbox=[];
        mymodel_editbox.push(
            '房东应结：<span class="fdyjmoney">'+fdyjmoney+'元</span> <select name="" id="seltype"><option value="-1">减</option><option value="1">加</option></select> ',
            '<input type="text" id="intmoney"  onkeyup="value=value.replace(/[^\\d.]/g,\'\')" width="100">'
        );
        $("#intmoney").val(''); // 输入框默认为空
        $("#mymodel_editbox").html(mymodel_editbox);
        $("#myModaledit").modal('show');
    };
    var editSure = function () {//修改弹框 确定按钮
        var url = absUrl+'/api/finance/order/handler';
        var orderId =parseInt(zc_store.get("jlorderId")); // 订单id
        var addOrSub =parseInt($("#seltype").val()); //修改类型
        var amount = Number($("#intmoney").val()); // 金额
        var optId = $('#opeRate').val(); //操作人id
        var ajax_shtg = {orderId:orderId,addOrSub:addOrSub,amount:amount,optId:optId};
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
                    $("#myModaledit").modal('hide');
                    //  刷新更改状态
                    ajax_data = JSON.parse(zc_store.get('ajax_data'));
                    ajax_data.pageNum = zc_store.get('pagenum');
                    ajax_data.pageSize = zc_store.get('pagesize');
                    ajax_data.orderStatus = zc_store.get('tabstatus');//订单状态
                    ajax_data.handledStatus = zc_store.get('abstatus'); // 异常订单状态
                    $("li[status="+ajax_data.orderStatus+']').addClass("current").siblings("li").removeClass("current");
                    //console.log(ajax_data,123);
                    getDetail(ajax_data);
                }else {
                    console.log(res.msg);
                }
            },
            error:function(xhr) {
                console.log('ajax error');
                // alert('ajax error');
            }
        });

    };
    var pageSizeChange = function () { //每页条数
        var ajax_data = JSON.parse(zc_store.get('ajax_data'))||ajax_data; // session数据或默认数据
        ajax_data.pageSize = $(this).val();
        ajax_data.pageNum = 1;
        getDetail(ajax_data);
    }
    var pageClick = function(){ // 页码点击
        var ajax_data = JSON.parse(zc_store.get('ajax_data'))||ajax_data;
        ajax_data.pageNum =$(this).attr("data-current");
        ajax_data.pageSize = $("#pageSize").val();
        zc_store.set("ajax_data",ajax_data); // 存 session 筛选项
        zc_store.set("pagenum",$(this).attr("data-current")); //
        zc_store.set("pagesize",$("#pageSize").val()); //
        //console.log(ajax_data,1111);
        getDetail(ajax_data);
    }; // 翻页
    var detailDetail =function(){ // 统计标签
        //console.log(ajax_data,11)
        if($(this).hasClass('current')){
            return false;
        }
        var abstatus = $(this).attr("abstatus");
        $(this).addClass('current').siblings('li').removeClass('current');
        if(zc_store.get('ajax_data')){
             ajax_data = JSON.parse(zc_store.get('ajax_data')); // 读session
        }
        //console.log(ajax_data)
        if(abstatus==1){ //待处理
            ajax_data.handledStatus = 1;
        }
        if(abstatus==2){ //已处理
            ajax_data.handledStatus = 2;
        }
        if(abstatus==''){ //全部
            ajax_data.handledStatus = '';
        }
        ajax_data.orderStatus = 67;
        ajax_data.pageNum = 1;
        ajax_data.pageSize = $("#pageSize").val();
        zc_store.set("ajax_data",ajax_data); // 存 session 筛选项
        getDetail(ajax_data);

    }
    var clearDate = function(){
        $("#orderNum,#ydName,#ydMobile,#landlordName,#houseId,#landlordMobile,#houseName,#date_start,#date_end,#selDate,#country,#area,#city,#province,#houseSource").val("");
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
        var landlordName=$("#landlordName").val(); //房东姓名
        var landlordMobile=$("#landlordMobile").val(); //房东手机
        var orderStatus=67; //订单状态
        var national=$("#country").val();; //国家code
        var city=$("#city").val();; //城市code
        var province=$("#province").val(); //省份code
        var county=$("#area").val();; //区code
        var pageNum=$("#pageNum").val(); //第几页
        var pageSize=$("#pageSize").val();//每页几条
        var handledStatus =''; // 结算异常订单
        var tabModel = ''; // 合并状态tab
        //console.log(national,city,county,province);
        var ajax_data = {orderNum:orderNum,lodgerName:lodgerName,lodgerMobile:lodgerMobile,timeType:timeType,beginTime:beginTime,endTime:endTime,houseId:houseId,houseName:houseName,houseSource:houseSource,landlordName:landlordName,landlordMobile:landlordMobile,orderStatus:orderStatus,pageNum:pageNum,pageSize:pageSize,national:national,city:city,province:province,county:county,handledStatus:handledStatus,tabModel:tabModel};
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
                    if($("#detail_ul li").eq(i).attr('abstatus')==val){
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
            $("#houseSource").val(ajax_data.houseSource).selected; //房源来源
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
                $(".shade_wrap").fadeOut();
                layer.msg('数据请求失败');
                console.log('ajax error');
                // alert('ajax error');
            }
        });
    };
    var onGetDetailSuccess = function(res) {
        $(".shade_wrap").fadeOut();
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
                    ' <span style="display: inline-block">商品信息</span>',
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
                    var handledStatus = obj.handledStatus; // 状态 TODO
                    if(handledStatus==1){
                        handledStatus = '待处理';
                        operate = '<span class="o_edit">修改</span>&nbsp;&nbsp;<a href="dd_ms_detail?orderId='+obj.id+'">详情</a> ';
                    }else if(handledStatus==2){
                        handledStatus = '已处理';
                        operate = '<a href="dd_ms_detail?orderId='+obj.id+'">详情</a> ';
                    }else{
                        handledStatus='-';
                    };
                    data.push(
                        '<tr bgcolor="#ffcc99">',
                        '<td colspan="11">',
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
                        '<td>'+handledStatus+'</td>',
                        '<td fdys='+obj.landladyIncome+' ordernum='+obj.orderNum+' orderId='+obj.id+'>'+operate+'</td>',
                        '</tr>'
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
            console.log(res.msg);
        }

    };

    initList();
})