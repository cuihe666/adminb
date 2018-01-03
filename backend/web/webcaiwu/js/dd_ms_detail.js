/**
 * Created by lele on 2017/8/17.
 */
$(function(){
    var orderId = zcGetLocationParm("orderId"); // 订单id
    //var showtk = zcGetLocationParm('showtk'); //是否显示时间退款金额
    var absUrl = serveUrl(); // 接口地址
    zc_store.set("jlorderId",orderId); // 订单id 存seesion 同步信息
    var initList = function() {
        bindEvt();// 绑定事件
        getDetail(); // 获取数据
    };
    var bindEvt = function() {
        $('body').on("click",'.o_sure',popBoxsure);//确认弹框
        $('body').on("click",'.o_cancel',popBoxcancel);//取消弹框
        $('body').on("click",'.o_shtg',popBoxshtg);//审核通过弹框
        $('body').on("click",'.o_bhtk',popBoxreject);//驳回退款弹框
        $('body').on("click",'.o_qrwtg',popBoxnopass);//确认未通过弹框
        $("body").on("click",'#sure_sure',sureSure);//确认订单确认按钮
        $("body").on("click",'#cancel_sure',cancelSure);//取消订单确认按钮
        $("body").on("click",'#pass_sure',passSure);//审核通过确认按钮
        $("body").on("click",'#reject_sure',rejectSure);//驳回退款确认按钮
        $("body").on("click",'#nopass_sure',nopassSure);//确认未通过确认按钮
        $('body').on("click",'#applyrefund',popBoxRefund);//申请退款弹框
        $("body").on("click",'#refund_sure',refundSure);//申请退款按钮
        $('body').on("click",'.o_edit',popBoxEdit);// 修改弹框
        $('body').on("click",'#editSure',editSure);// 修改弹框
        $('body').on("click",'.jlrzxz',rzxzPop);// 入住须知弹框
        $("body").on("click",'.gobackList',goBackList); // 返回上一页
    };
    var goBackList = function () { // 返回上一页
        var pagenum = zc_store.get('pagenum');
        var pagesize = zc_store.get('pagesize');
        zc_store.set('jlisdetail',true);// 来源是详情页返回
        zc_store.set('jlisdtl',true);// 来源是详情页返回-c城市
        if(JSON.parse(zc_store.get('ajax_data')).orderStatus!='67'){ // 异常订单 67
            var tabstatus = zc_store.get('tabstatus');
            window.location.href = 'dd_ms_list?pagenum='+pagenum+'&pagesize='+pagesize+'&tabstatus='+tabstatus;
        }else{
            var tabstatus = JSON.parse(zc_store.get('ajax_data')).handledStatus;
            window.location.href = 'dd_ms_abnormal?pagenum='+pagenum+'&pagesize='+pagesize+'&tabstatus='+tabstatus;

        }

    }
    var rzxzPop = function(){ // 入住信息弹框
        $("#myModal2").modal('show');
    }
    var popBoxsure= function () { // 确认弹框
        zc_store.set("jlorderId",zcGetLocationParm("orderId")); // 订单id
        $("#myModalsure").modal('show');
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
                    $("#myModalsure").modal('hide');
                    getDetail();
                }else {
                    layer.msg(res.msg);
                }
            },
            error:function(xhr) {
                console.log('ajax error');
                // alert('ajax error');
            }
        });
    };
    var popBoxcancel= function () { //取消订单弹框

        $("#cancelRemark").val(''); // 输入框值为空
        zc_store.set("jlorderId",zcGetLocationParm("orderId"));
        $("#myModal_cancel").modal('show');
    };
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
                    getDetail();
                }else {
                    layer.msg(res.msg);
                }
            },
            error:function(xhr) {
                console.log('ajax error');
                // alert('ajax error');
            }
        });
    };
    var popBoxshtg= function () { //审核通过
        zc_store.set("jlorderId",zcGetLocationParm("orderId"));
        $("#myModal_pass").modal('show');

    };
    var passSure= function () { //审核通过
        var url = absUrl+'/api/finance/order/audit/pass';
        var orderId =parseInt(zc_store.get("jlorderId")); // 订单id
        var updateBy = $('#opeRate').val(); //操作人id
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
                    $("#myModal_pass").modal('hide');
                    getDetail();
                }else {
                    layer.msg(res.msg);

                }
            },
            error:function(xhr) {
                console.log('ajax error');
                // alert('ajax error');
            }
        });
    };
    var popBoxreject= function () { //驳回退款
        $("#rejectRemark").val(''); // 输入框值为空

        zc_store.set("jlorderId",zcGetLocationParm("orderId"));
        $("#myModal_reject").modal('show');
    };
    var rejectSure= function () { // 驳回退款
        var url = absUrl+'/api/finance/order/audit/refuse';
        var orderId =parseInt(zc_store.get("jlorderId")); // 订单id
        var updateBy = $('#opeRate').val(); //操作人id
        var cancelReason =$("#rejectRemark").val() ;// 备注
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
                    $("#myModal_reject").modal('hide');
                    getDetail();
                }else {
                    layer.msg(res.msg);

                }
            },
            error:function(xhr) {
                console.log('ajax error');
                // alert('ajax error');
            }
        });
    };
    var popBoxnopass= function () { // 确认未通过弹框
        $("#nopassRemark").val();// 输入框为空
        zc_store.set("jlorderId",zcGetLocationParm("orderId"));
        $("#myModal_nopass").modal('show');
    };
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
                    getDetail();
                }else {
                    layer.msg(res.msg);

                }
            },
            error:function(xhr) {
                console.log('ajax error');
                // alert('ajax error');
            }
        });
    };
    var popBoxRefund= function () { // 申请退款弹框
        var url= absUrl+'/api/finance/order/apply/refund/'+orderId;
        $.ajax({
            type: 'GET',
            url: url,
            data: '',
            success: function (res) {
                //console.log(res);
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
            }
        })
    };
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
        if($('#jlstmoney').val()==''||$('#jlstmoney').val()==null){
            alert('请填写实际退款金额');
            return;
        }
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
                        getDetail();
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
    };
    var popBoxEdit= function () { // 修改弹框

        zc_store.set("jlorderId",orderId); // 订单id
        var fdyjmoney = $("#fdys").val();//房东应收
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
        //console.log(ajax_shtgstr)
        $.ajax({
            type:'POST',
            url:url,
            data:ajax_shtgstr,
            contentType:"application/json",
            success:function(res){
                //console.log(res);//
                if(res.code=='0'){
                    $("#myModaledit").modal('hide');
                    // 刷新更改状态
                    ajax_data = JSON.parse(zc_store.get('ajax_data'));
                    ajax_data.pageNum = zc_store.get('pagenum');
                    ajax_data.pageSize = zc_store.get('pagesize');
                    ajax_data.orderStatus = zc_store.get('tabstatus');//订单状态
                    ajax_data.handledStatus = zc_store.get('abstatus'); // 异常订单状态
                    $("li[status="+ajax_data.orderStatus+']').addClass("current").siblings("li").removeClass("current");
                    //console.log(ajax_data,123)
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

    };
    var getDetail = function() {
        var ajax_url = absUrl+'/api/finance/order/orders/'+orderId;
        $.ajax({
            type:'get',
            url:ajax_url,
            data:{},
            beforeSend: function(){
                $(".shade_wrap").fadeIn();
            },
            success:onGetDetailSuccess,
            error:function(xhr) {
                $(".shade_wrap").fadeOut();
                layer.msg('数据请求失败');
                console.log('ajax error');
            }
        });
    };
    var onGetDetailSuccess = function(res) {
        $(".shade_wrap").fadeOut();
        if(res.code=='0') {
            //console.log(res);
            var orderData = []; // 订单数据
            var orderHouseData = []; // 入住信息
            var orderInfo = res.data.orderInfo;
            var orderHouseInfo = res.data.orderHouseInfo;
            var houseInfo = res.data.houseInfo;
            var datePrice = res.data.datePrice; //每日每间房价
            var user = res.data.user; //用户
            var costDetail = res.data.costDetail;//费用明细
            var sfm =2; // 时间参数，显示时分秒
            var deposit = orderHouseInfo.deposit; // 押金
            if(deposit>0){
                var deposit = '¥'+deposit+'（线下收取押金）';
            }else{
                var deposit ='不收押金';
            }
            $("#fdys").val(orderInfo.landladyIncome);
            $("body").on("blur",'#realTk',function(){ // 验证input输入的实际退款金额
                //alert(orderHouseInfo.payAmount)
                if($("#realTk").val()>orderHouseInfo.payAmount){
                    alert('实际退款金额不能大于实付金额');
                    return false;
                }
            });
            var model_housename=[]; //房屋弹框
            var model_xuzhi=[]; // 入住须知
            var model_housePrice =[];// 每日房价
                model_housePrice.push(
                    '<div class="modal-dialog">',
                    '<div class="modal-content">',
                    '<div class="modal-header">',
                    '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>',
                    '<h4 class="modal-title" id="myModalLabel3">房价明细</h4>',
                    '</div>',
                    '<div class="modal-body">',
                    '<div class="table-responsive">',
                    '<table class="table table-condensed">',
                    '<tbody>',
                    '<tr>'
                );
            if(datePrice.length>0){
                $.each(datePrice,function(i,obj){
                    model_housePrice.push(
                        '<td style="background-color: #f4f4f4">',
                        '<span>'+TimeToDate(obj.hotelDate)+'</span>',
                        '<b>('+timeGetDay(obj.hotelDate)+')</b>',
                        '</td>'
                    )
                });
                model_housePrice.push(
                    '</tr>',
                    '<tr>'
                );
                if(ischina){ //房价  国内取字段 money
                    $.each(datePrice,function(i,obj){
                        model_housePrice.push(
                            '<td style="background-color: #f4f4f4">'+obj.money+'</td>'
                        )
                    })
                }else{//房价  国外取字段 raisePrice
                    $.each(datePrice,function(i,obj){
                        model_housePrice.push(
                            '<td style="background-color: #f4f4f4">'+obj.raisePrice+'</td>'
                        )
                    })
                }
            }else{
                model_housePrice.push("暂无");
            }
            model_housePrice.push(
                    '</tr>',
                    '</tbody>',
                    '</table>',
                    '</div>',
                    '</div>',
                    '<div class="modal-footer">',
                    '<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>',
                    '</div>',
                    '</div>',
                    '</div>'
                );
                $("#myModal3").html(model_housePrice.join(''));
            if(houseInfo){ // 新订单有这个字段 是弹框 入住须知
                if(houseInfo.houseIntime!=''){ // 入住时间
                    intime = houseInfo.houseIntime+':00以后';
                }else{
                    intime='-';
                }
                model_xuzhi.push( // 预订须知
                    '<div class="modal-dialog">',
                    '<div class="modal-content">',
                    '<div class="modal-header">',
                    '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>',
                    '<h4 class="modal-title" id="myModalLabel2">入住须知</h4>',
                    '</div>',
                    '<div class="modal-body">',
                    '<div class="row" style="padding:0 15px;font-size: 16px;">',
                    '<div class="col-md-3">押金:</div>',
                    '<div class="col-md-6">'+deposit+'</div>',
                    '</div>',
                    '<div class="row" style="margin-top: 15px;padding:0 15px;font-size: 16px;">',
                    '<div class="col-md-3">最多入住:</div>',
                    '<div class="col-md-6">'+valNull(houseInfo.maxguest)+'人</div>',
                    '</div>',
                    '<div class="row" style="margin-top: 15px;padding:0 15px;font-size: 16px;">',
                    '<div class="col-md-3">入住时间:</div>',
                    '<div class="col-md-6">'+intime+'</div>',
                    '</div>',
                    '<div class="row" style="margin-top: 15px;padding:0 15px;font-size: 16px;">',
                    '<div class="col-md-3">退房时间:</div>',
                    '<div class="col-md-6">'+houseInfo.houseOuttime+':00以前</div>',
                    '</div>',
                    '<div class="row" style="margin-top: 15px;padding:0 15px;font-size: 16px;">',
                    '<div class="col-md-3">房东需求:</div>',
                    '<div class="col-md-6">'+valNull(houseInfo.houseLimit)+'</div>',
                    '</div>',
                    '<div class="row" style="margin-top:15px;padding:0 15px;font-size: 16px;">',
                    '<div class="col-md-3">其他须知：</div>',
                    '<div class="col-md-6">'+valNull(houseInfo.notice)+'</div>',
                    '</div>',
                    //'<div class="row" style="padding:0 15px;margin-top: 10">',
                    //'<p>住房押金:</br>到店后需要支付¥500.00住房押金，离店后无设施损坏等问题押金全额退回</p>',
                    //'</div>',
                    '</div>',
                    '<div class="modal-footer">',
                    '<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>',
                    '<!-- <button type="button" class="btn btn-primary">提交更改</button> -->',
                    '</div>',
                    '</div>',
                    '</div>'
                );
                $("#myModal2").html(model_xuzhi.join(""));
                var roommode = houseInfo.roommode;// 出租方式
                if(roommode==1){
                    roommode = '整租';
                }else if(roommode==2){
                    roommode = '合租';
                }else if(roommode==3){
                    roommode = '床位';
                }else {
                    roommode = '-';
                }
                var isWelcome = houseInfo.isWelcome; //接待外宾
                if(isWelcome){
                    isWelcome = '接待外宾';
                }else{
                    isWelcome ='不接待外宾';
                }
                var sex = houseInfo.sex;
                if(sex==0){
                    sex = '不限性别';
                }else if(sex==1){
                    sex ='限男';
                }else if(sex==2){
                    sex='限女';
                }
                model_housename.push(
                    '<div class="modal-dialog">',
                    '<div class="modal-content">',
                    '<div class="modal-body">',
                    '<div class="row">',
                    '<div class="col-md-1">',
                    '<img src="../webcaiwu/img/house.png" alt="" style="width:40px;">',
                    '</div>',
                    '<div class="col-md-6">',
                    '<b style="font-size: 14px;font-weight: bold;display: block;">'+roommode+'</b>',
                    '<b style="color:#999">'+houseInfo.roomsize+'平米,'+houseInfo.roomnum+'室'+houseInfo.officenum+'厅</b>',
                    '</div>',
                    '</div>',
                    '<div class="row" style="margin-top: 15px;">',
                    '<div class="col-md-1">',
                    '<img src="../webcaiwu/img/partment.png" alt="" style="width:40px;">',
                    '</div>',
                    '<div class="col-md-6">',
                    '<b style="font-size: 14px;font-weight: bold;display: block;">'+houseInfo.roomtypeName+'</b>',
                    //'<b style="color:#999">??????待确认去掉</b>',
                    '</div>',
                    '</div>',
                    '<div class="row" style="margin-top: 15px;">',
                    '<div class="col-md-1">',
                    '<img src="../webcaiwu/img/person.png" alt="" style="width:40px;">',
                    '</div>',
                    '<div class="col-md-6">',
                    '<b style="font-size: 14px;font-weight: bold;display: block;">宜住'+houseInfo.minguest+'人</b>',
                    '<b style="color:#999">'+sex+','+isWelcome+','+houseInfo.minday+'晚起住</b>',
                    '</div>',
                    '</div>',
                    '<div class="row" style="margin-top: 15px;">',
                    '<div class="col-md-1">',
                    '<img src="../webcaiwu/img/bed.png" alt="" style="width:40px;">',
                    '</div>',
                    '<div class="col-md-6">',
                    '<b style="font-size: 14px;font-weight: bold;display: block;">'+houseInfo.bedcount+'张床</b>'
                )
                $.each(houseInfo.houseBeds,function(i,obj){
                    model_housename.push(
                        //'<b style="color:#999">'+obj.bedName+':'+obj.bedLong+'米*'+obj.bedWide+'米,'+obj.bedCount+'张</b>'
                    '<b style="color:#999">'+obj.bedLong+'米*'+obj.bedWide+'米,'+obj.bedCount+'张</b>'
                    )
                })
                model_housename.push(
                    '</div>',
                    '</div>',
                    '</div>',
                    '<div class="modal-footer">',
                    '<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>',
                    '<!-- <button type="button" class="btn btn-primary">提交更改</button> -->',
                    '</div>',
                    '</div>',
                    '</div>'
                )
                $('#myModal').html(model_housename.join(''));
            }else {
                $("#myModal2,#myModal").remove(); // 老订单无入住须知字段所以不让他弹框
            }
            var orderStatus= orderInfo.orderStatus; // 订单状态
            var handledStatus = orderInfo.handledStatus;// 订单异常1,2
            //console.log(orderStatus,"订单状态");
            var btndata=[]; // 详情对应的操作按钮
            if(orderStatus==1){
                orderStatus = '待确认';
                    btndata.push(
                    '<button class="btn btn-primary o_sure" style="margin-top:15px;color: #fff;">确认</button> ',
                        '<button class="btn btn-primary o_cancel" style="margin-top:15px;border:none;color: #fff;">取消</button>  '
                    )
            }else if(orderStatus==11){
                orderStatus = '待付款';
                btndata.push(
                    '<button class="btn btn-primary o_cancel" style="margin-top:15px;border:none;color: #fff;" >取消</button> '
                )

            }else if(orderStatus==12){
                orderStatus = '已拒绝';
            }else if(orderStatus==41){
                orderStatus = '房客支付超时';
            }else if(orderStatus==42){
                orderStatus = '房东确认超时';
            }else if(orderStatus==3){
                orderStatus ='用户已取消';
            }else if(orderStatus==4){
                orderStatus = '客服已取消';
            }else if(orderStatus==21){
                orderStatus = '待入住';
                btndata.push(
                    '<button class="btn btn-primary" style="margin-top:15px;" id="applyrefund">申请退款</button> '
                )
            }else if(orderStatus==31){
                orderStatus = '已入住';
                btndata.push(
                    '<button class="btn btn-primary" style="margin-top:15px;" id="applyrefund">申请退款</button> '
                )
            }else if(orderStatus==32){
                orderStatus = '已完成';
            }else if(orderStatus==34){
                orderStatus = '已结算';
            }else if(orderStatus==51){
                orderStatus = '退款申请中';
                btndata.push(
                    '<button class="o_shtg btn btn-primary " style="margin-top:15px;color: #fff;">审核通过</button> ',
                    '<button class="o_bhtk btn btn-primary " style="margin-top:15px;border:none;color: #fff;" class="">驳回退款</button> '
                )

            }else if(orderStatus==52){
                orderStatus = '退款待确认';
             }else if(orderStatus==57){
                orderStatus = '待退款';
            }else if(orderStatus==56){
                orderStatus = '退款未通过';
                btndata.push(
                    '<button class="o_qrwtg btn btn-primary" style="margin-top:15px;color: #fff;">确认未通过</button> ',
                    '<button class="btn btn-primary" style="margin-top:15px;" id="applyrefund">申请退款</button> '
                )
            }else if(orderStatus==58){
                orderStatus = '财务拒绝';
                btndata.push(
                    '<button class="btn btn-primary" id="applyrefund" style="margin-top:15px;border:none;color: #fff;">申请退款</button> ',
                    '<button class="btn btn-primary o_bhtk" style="margin-top:15px;border:none;color: #fff;">驳回退款</button> '
                )
            }else if(orderStatus==54){
                orderStatus = '退款中';
            }else if(orderStatus==55){
                orderStatus = '退款完成';
            }else if(orderStatus==59){ //  拒绝退款
                orderStatus = '拒绝退款';
            }else if(orderStatus==61){
                orderStatus = '结算待审核';
            }else if(orderStatus==62){
                orderStatus = '结算未通过';
            }else if(orderStatus==63){
                orderStatus = '结算待确认';
            }else if(orderStatus==64) {
                orderStatus = '结算待付款';
            }else if(orderStatus==65) {
                orderStatus = '付款失败';
            }else if(orderStatus==66) {
                orderStatus = '结算拒绝';
            }else if(orderStatus==67){
                orderStatus = '结算异常订单';
                if(handledStatus==2){ // 异常已处理
                }else if(handledStatus==1){// 异常待处理
                    btndata.push(
                        '<button class="btn btn-default o_edit" style="background-color: orange;margin-top:15px;border:none;color:#fff;">修改</button>&nbsp;&nbsp;'
                    )
                }
            }else if(orderStatus==68){
                orderStatus = '已打款';
            }else if(orderStatus==69){
                orderStatus = '付款中';
            }else{
                orderStatus='-';
            }
            btndata.push(
                '<button class="btn btn-default gobackList"  style="background-color: orange;color:#fff;margin-top:15px;border:none">返回上一页</button>'
            );
            var payPlatform = orderInfo.payPlatform; // 支付方式
            if(payPlatform==1){
                payPlatform ="支付宝";
            }else if(payPlatform==2){
                payPlatform ="微信";

            }else if(payPlatform==3){
                payPlatform ="银联";
            }else{
                payPlatform ="暂无";
            }
            var settlementStatus = orderInfo.settlementStatus; // 结算状态
            if(settlementStatus==0){
                settlementStatus = '未结算';
            }else if(settlementStatus==1) {
                settlementStatus = '结算待审核';
            }else if(settlementStatus==2){
                settlementStatus = '结算未通过';
            }else if(settlementStatus==3){
                settlementStatus = '结算待确认';
            }else if(settlementStatus==4){
                settlementStatus = '结算待付款';
            }else if(settlementStatus==5){
                settlementStatus = '付款失败';
            }else if(settlementStatus==6){
                settlementStatus = '结算拒绝';
            }else if(settlementStatus==7){
                settlementStatus = '结算异常';
            }else if(settlementStatus==8){
                settlementStatus = '已付款';
            }else {
                settlementStatus = '-';
            }
            var orderType = orderInfo.orderType; // 订单类型房源来源
            if(orderType==''||orderType=='0'){
                orderType = "棠果";
            }else if(orderType=='1'){
                orderType="番茄";
            }else if(orderType=='2'){
                orderType="同程";
            }
            // 因现在没有区分来源所以现在先隐藏掉 接口传空  2017年11月15日15:30:30 琳涛
            //var orderSource = orderInfo.orderSource; // 订单来源
            //if(orderSource==1){
            //    orderSource = 'app';
            //}else if(orderSource==2){
            //    orderSource = 'H5';
            //}else {
            //    orderSource = '-';
            //}
            if(orderInfo.payAmount){
                payamount = '¥'+orderInfo.payAmount; // 实付金额
            }
            orderData.push(
            '<table class="table table-condensed" style="margin: 10px 0;">',
            '<tbody>',
            '<tr>',
            '<td>订单ID：</td>',
            '<td id="orderId" orderid ='+orderInfo.orderId+'>',
            '<span>'+orderInfo.orderId+'</span>',
            '</td>',
            '<td>订单号：</td>',
            '<td>',
            '<span style="color:#3c8dbc">'+orderInfo.orderNum+'</span>',
            ' </td>',
            '</tr>',
            ' <tr>',
            ' <td>应付金额：</td>',
            ' <td>'+payamount+'</td>',
            '<td>下单时间：</td>',
            '<td>'+TimeToDate(orderInfo.createTime,sfm)+'</td>',
            '</tr>',
            '<tr>',
            '<td>付款时间：</td>',
            ' <td>'+TimeToDate(orderInfo.payTime,sfm)+'</td>',
            '<td>订单状态：</td>',
            '<td>',
            '<span style="color:red">'+orderStatus+'</span>',
            ' </td>',
            ' </tr>',
            ' <tr>',
            '  <td>支付方式：</td>',
            '<td>'+payPlatform+'</td>',
            '<td>结算状态：</td>',
            '<td>'+settlementStatus+'</td>',
            ' </tr>',
            '<tr>',
            '<td>房源来源：</td>',
            '<td>'+orderType+'</td>',
                // 因现在没有区分来源所以现在先隐藏掉 接口传空  2017年11月15日15:30:30 琳涛
                //'<td>订单来源：</td>',
            //'<td>'+orderSource+'</td>',
                '<td></td>',
                '<td></td>',
            '</tr>',
            '</tbody>',
            '</table>'
            );
            $("#orderData").html(orderData.join(""));
            var isRealtime =orderHouseInfo.realtime;//闪电预订
            if(isRealtime){
                isRealtime = '⚡';
            }else{
                isRealtime = '';
            }
            if(orderHouseInfo.inTime){
                rlrq = TimeToDate(orderHouseInfo.inTime)+'  -  '+TimeToDate(orderHouseInfo.outTime)+'     共'+orderHouseInfo.dayNum+'晚';
            }else {
                rlrq = '-';
            }
            if(orderHouseInfo.bookHouseCount){ // 房间
                bookHouseCount = orderHouseInfo.bookHouseCount+'间';
            }else{
                bookHouseCount ='-';
            }
            if(orderHouseInfo.dayNum){
                dayNum = orderHouseInfo.dayNum+'晚';
            }else{
                dayNum ='-';
            }
            if(orderHouseInfo.payAmount){
                payaamount ='￥'+orderHouseInfo.payAmount;
            }else {
                payaamount ='-';
            }
            orderHouseData.push(
            '<table class="table table-condensed" style="margin: 10px 0;">',
            '<tbody>',
            '<tr>',
            '<td>房屋名称:</td>',
            '<td>',
            '<span style="color:#3c8dbc">'+orderHouseInfo.houseTitle+isRealtime+'</span>'
            );
            if(houseInfo){  // 老订单无入住须知字段所以不显示入住须知
                var Hdetail = '<b style="display: inline-block;background-color: #3c8dbc;border-radius: 5px;padding:3px 5px;float: right;cursor:pointer" data-toggle="modal" data-target="#myModal"> ! </b>';
            }else{
                var Hdetail = '';
            }
            if(orderInfo.payStatus!=2){
                var ltrealintime = '-';
                var ltrealouttime = '-';
            }else{
                var ltrealintime = valNull(TimeToDate(orderHouseInfo.realInTime,sfm));
                var ltrealouttime = valNull(TimeToDate(orderHouseInfo.realOutTime,sfm));
            }
            orderHouseData.push(
                ''+Hdetail+'</td>',
            '<td>房屋地址:</td>',
            '<td>'+valNull(orderHouseInfo.houseAddress)+'</td>',
            '</tr>',
            '<tr>',
            '<td>入离日期:</td>',
            '<td>'+rlrq+'</td>',
            '<td>间夜:</td>',
            '<td>'+bookHouseCount+dayNum+'</td>',
            '</tr>',
            '<tr>',
            '<td>实际入住日期:</td>',
            '<td>'+ltrealintime+'</td>',
            '<td>实际离店日期:</td>',
            '<td>'+ltrealouttime+'</td>',
            '</tr>',
            '<tr>',
            '<td>住房押金:</td>',
            '<td>',
            '<span style="color:orange">'+deposit+'</span>',
            //'<b style="display: inline-block;background-color: #3c8dbc;border-radius: 5px;padding:3px 5px;float: right;">!</b>',
            '</td>',
            '<td>房东:</td>',
            ' <td>'+valNull(orderHouseInfo.landlordName)+'/'+valNull(orderHouseInfo.landlordMobile)+'</td>',
            '</tr>',
            '<tr>',
            '<td>入住房客:</td>',
            '<td class="po_re">'
            );
            //console.log(orderHouseInfo.orderGuests,1111111);
            if(orderHouseInfo.orderGuests.length>0){
                $.each(orderHouseInfo.orderGuests,function(i,obj){
                    var guestCardType = obj.guestCardType;  // card类型
                    if(guestCardType==0){
                        guestCardType="身份证";
                    }else if (guestCardType==1){
                        guestCardType="护照";
                    }else if (guestCardType==2){
                        guestCardType="军官证";
                    }else {
                        guestCardType="-";
                    }
                    orderHouseData.push(
                        '<span style="display: block;">'+valNull(obj.guestName)+' / '+guestCardType+'/' +valNull(obj.guestCardNum)+' </span>'
                    )
                })
            }else{
                orderHouseData.push('暂无');
            }
            if(houseInfo){  // 老订单无入住须知字段所以不显示入住须知
                var ruzhuxuzhi = '<b class="po_ab" style="display: inline-block;background-color: #3c8dbc;border-radius: 5px;padding:3px 5px;cursor:pointer;top: 2px;right:2px;" data-toggle="modal" data-target="#myModal2" >入住须知</b>';
            }else{
                var ruzhuxuzhi = '';
            }

            orderHouseData.push(
                ''+ruzhuxuzhi+'</td>',
            '<td>房费:</td>',
            '<td>',
            '<b style="color:orange;font-weight: bold;cursor: pointer" data-toggle="modal" data-target="#myModal3">'+payaamount+'</b>',
            '<span data-toggle="modal" data-target="#myModal3">（点击查看每日每间的房价）</span>',
            '</td>',
            '</tr>',
            '</tbody>',
            '</table>'

        )
            $("#orderHouseData").html(orderHouseData.join(""));
            var userInfo = []; // 用户信息
            userInfo.push(
            '<table class="table table-condensed" style="margin: 10px 0;">',
                '<tbody>',
                '<tr>',
                '<td>用户</td>',
                '<td>'+valNull(user.userId)+'</td>',
            '<td>用户账号</td>',
            '<td>'+valNull(user.userAccount)+'</td>',
            '</tr>',
            ' <tr>',
            '<td>用户昵称</td>',
            '<td>'+valNull(user.nickName)+'</td>',
            '<td>联系人姓名</td>',
            '<td>'+valNull(user.bookName)+'</td>',
            '</tr>',
            '<tr>',
            ' <td>联系人手机号</td>',
            ' <td>'+valNull(user.bookMobile)+'</td>',
            '<td>联系人邮箱</td>',
            '<td>'+valNull(user.bookEmail)+'</td>',
            '</tr>',
            '</tbody>',
            '</table>'
            );
            $("#userInfo").html(userInfo.join(''));
            var priceDetail =[]; //费用明细
            var applyRefund =costDetail.applyRefund; // 申请退款金额
            var realRefund = costDetail.realRefund; // 实际退款金额
            if(costDetail.totalAccount>=0){
                totalAccount = '￥'+costDetail.totalAccount;
            }else {
                totalAccount = '-';
            }
            if(costDetail.realPayAccount>=0){ // 实付金额》0
                //用户未付钱的情况 实付金额为-
                if(orderInfo.orderStatus==1||orderInfo.orderStatus==11||orderInfo.orderStatus==12||orderInfo.orderStatus==41||orderInfo.orderStatus==42||orderInfo.orderStatus==3||orderInfo.orderStatus==4){
                    realPayAccount='-';
                }else{
                    realPayAccount='￥'+valNull(costDetail.realPayAccount);
                }
            }else{
                realPayAccount='-';
            }
            var ischina = orderInfo.ischina; // 是否国内房源
            if(!ischina){ // 海外收取清洁费
                var bHouseCount = costDetail.bookHouseCount;// 海外清洁费房间数
                if(bHouseCount){
                    cleanFee='￥'+costDetail.cleanFee+'x'+bHouseCount+'间&nbsp;&nbsp;共¥'+parseFloat(costDetail.cleanFee*bHouseCount);
                }else{
                    cleanFee='-';
                }
                // 超员费如何收取
                if(costDetail.isOverManFee ==1){ // 不允许超员
                    cyf='不允许超员';
                } else if(costDetail.isOverManFee ==2){ //线下收取超额费用
                    if(Number(costDetail.guestCount)>=0){
                        cyf='<span style="color:orange">￥'+costDetail.overManFee+'x'+costDetail.guestCount+'人x'+orderHouseInfo.dayNum+'夜</span> <span style="color:orange">共￥'+parseFloat(costDetail.overManFee*costDetail.guestCount*orderHouseInfo.dayNum)+'(线下收取)</span>';
                    }else{
                        cyf='0';
                    }
                }else if(costDetail.isOverManFee ==3){//线上支付超额费用
                    if(Number(costDetail.guestCount)>=0){
                        cyf='<span style="color:orange">￥'+costDetail.overManFee+'x'+costDetail.guestCount+'人x'+orderHouseInfo.dayNum+'夜</span> <span style="color:orange">共￥'+parseFloat(costDetail.overManFee*costDetail.guestCount*orderHouseInfo.dayNum)+'(线上支付)</span>';
                    }else{
                        cyf='0';
                    }
                }

            }else{ // 国内
                cleanFee='不收取清洁费';
                cyf = "不收取超员费";
            }
            // 优惠券
            if(costDetail.orderCoupon!=''){
                var coupon = '¥'+costDetail.orderCoupon.money+'('+costDetail.orderCoupon.name+')';
            }else if(costDetail.orderPromotion!=''){
                var coupon ='¥'+costDetail.orderPromotion.money+'('+costDetail.orderPromotion.promotionRules+')' ;

            }else{
                var coupon = '暂无';

            }
            //补贴退款
            if(costDetail.subsidyAmount!=''){
                var subPlatform = costDetail.subsidyPlatform;// 补贴平台
                if(subPlatform==1){ // 棠果
                    subPlatform = '平台补贴';
                }else if (subPlatform==2){ // 商家
                    subPlatform ='商家补贴';
                }
                var bttk = '¥'+costDetail.subsidyAmount+'&nbsp;&nbsp;'+subPlatform;
            }else{
                var bttk = '暂无';
            }
            priceDetail.push(
            '<table class="table table-condensed" style="margin: 10px 0;">',
                '<tbody>',
                '<tr>',
                '<td>房费：</td>',
            '<td>',
            '<span style="color:orange" >'+totalAccount+'</span>',
            '</td>',
            '<td>实付金额：</td>',
            '<td>',
            '<span style="color:orange">'+realPayAccount+'</span>',
                '</td>',
                '</tr>',
            '<tr>',
            '<td>清洁费：</td>',
            '<td>',
            '<span style="color:orange">'+cleanFee+'</span>',
            '</td>',
            '<td>超员费：</td>',
            '<td style="color:orange">'+cyf+'</td>',
            '</tr>',
            '<tr>',
            '<td>已享优惠：</td>',
            '<td  style="color: #00a157">'+coupon+'</td>',
            '<td>申请退款金额：</td>',
            '<td>',
            '<span style="color:orange;font-weight: bold;">'+valNull(applyRefund)+'</span>',
            '</td>',
            '</tr>',
            '<tr>',
            '<td>补贴退款：</td>',
            '<td>'+bttk+'</td>',
            '<td>实际退款金额：</td>',
            '<td>'+valNull(realRefund)+'</td>',
            '</tr>',
            '</tbody>',
            '</table>'
            );
            $("#priceDetail").html(priceDetail.join(''));
            var operateLog = []; // 操作日志
            operateLog.push(
            '<table class="table table-condensed" style="margin: 10px 0;">',
                '<tbody>',
                '<tr>',
                '<td>操作人</td>',
                '<td>时间</td>',
                '<td>操作事件</td>',
                '<td>备注</td>',
                '</tr>'
           )
            $.each(res.data.optLogs,function(i,obj){
                var sfm = 2;
                operateLog.push(
                    '<tr>',
                    '<td>'+obj.optUsername+'</td>',
                    '<td>'+valNull(TimeToDate(obj.createTime,sfm))+'</td>',
                    '<td>'+obj.optEvent+'</td>',
                    '<td>'+valNull(obj.optComment)+'</td>',
                    '</tr>'
                )
            });
            operateLog.push(
            '</tbody>'
            );
            $("#operateLog").html(operateLog.join(''));


            $("#btn_box").html(btndata.join(''));
        }else {
            layer.msg(res.msg);
        }

    };
    initList();
})