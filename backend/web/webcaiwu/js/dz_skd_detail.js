/**
 * Created by admin on 2017/8/11.
 */
$(function(){
    var receiptNum=zcGetLocationParm("receiptNum"); // 收款单号
    var absUrl = serveUrl();
    var initList = function() {
        bindEvt();
        getDetail(); // 拉数据
    };
    var bindEvt = function() {
        $("#goBack").on("click",goBack);//返回上一页
    };
    var goBack = function(){ // 返回上一页
        var pagenum = zc_store.get('pagenum');
        var pagesize = zc_store.get('pagesize');
        var flagTab = zc_store.get('flagTab');
        zc_store.set('jlisdetail',true);// 来源是详情页返回
        window.location.href = 'dz_skd_list?pagenum='+pagenum+'&pagesize='+pagesize+'&flagTab='+flagTab;
    }
    var getDetail = function() {
        var ajax_url = absUrl+'/api/finance/receipt/receipts/'+receiptNum;
        $.ajax({
            type:'GET',
            url:ajax_url,
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
        //console.log(res);
        var data = [];
        var dataDetail = [];
        if(res.code=='0') {
            var eachData = res.data.receipt;
            var eachDataDetail = res.data.receiptDetail; // 列表信息
            if(eachData.length==0) { // 汇总数据为空
                $("#baseDetail").html("暂无数据");
            }else{
                var skdtype =eachData.receiptType;// 收款单类型
                if(skdtype==1){
                    skdtype = '国内民宿应收';
                }else if(skdtype==2){
                    skdtype = '海外民宿应收';
                }else if(skdtype==3){
                    skdtype = '旅行应收';
                }else if(skdtype==4){
                    skdtype = '旅行退款应收';
                }else{
                    skdtype = '-';
                }
                var sfm=2;
                var skdstatus = eachData.receiptStatus; // 收款单状态
                if(skdstatus==-1){
                    skdstatus = '作废';
                }else if(skdstatus==0){
                    skdstatus = '待收款';
                }else if(skdstatus==1){
                    skdstatus = '已完成';
                }else{
                    skdstatus = '-';
                }
                var payPlatform = eachData.payPlatform; //  支付方式
                if(payPlatform==1){
                    payPlatform='支付宝';
                }else if(payPlatform==2){
                    payPlatform='微信';
                }else{
                    payPlatform='-';
                }
                if(eachData.receiptStatus==0){
                    var endTime = '-';
                }else{
                    var endTime = valNull(TimeToDate(eachData.updateTime,sfm));
                }
                data.push(
                '<table class="table">',
                    '<tr>',
                    '<td colspan="3">基本信息</td>',
                    '</tr>',
                   '<tr>',
                '<td>',
                '<span>收款单号：</span>',
                '<em>'+eachData.receiptNum+'</em>',
                '</td>',
                '<td>',
                '<span>收款单类型：</span>',
                '<em>'+skdtype+'</em>',
                '</td>',
                '<td>',
                '<span>买家姓名：</span>',
                '<em>'+eachData.buyerName+'</em>',
                '</td>',
                '</tr>',
                '<tr>',
                ' <td>',
                '<span>订单编号：</span>',
                '<em>'+eachData.orderNum+'</em>',
                '</td>',
                '<td>',
                '<span>收款单状态：</span>',
                '<em>'+skdstatus+'</em>',
                '</td>',
                '<td>',
                '<span>买家电话：</span>',
                '<em>'+eachData.buyerMobile+'</em>',
                '</td>',
                '</tr>',
                '<tr>',
                '<td>',
                '<span>第三方单号：</span>',
                '<em>'+valNull(eachData.transactionId)+'</em>',
                '</td>',
                '<td>',
                '<span>创建时间：</span>',
                '<em>'+valNull(TimeToDate(eachData.createTime,sfm))+'</em>',
                '</td>',
                '<td>',
                '<span>支付方式：</span>',
                '<em>'+valNull(payPlatform)+'</em>',
                '</td>',
                '</tr>',
                '<tr>',
                '<td>',
                '<span>付款单号：</span>',
                '<em>'+valNull(eachData.paymentNum)+'</em>',
                '</td>',
                '<td>',
                '<span>完成时间：</span>',
                '<em>'+endTime+'</em>',
                '</td>',
                '<td>',
                '<span>支付账号：</span>',
                '<em>'+valNull(eachData.accountNumber)+'</em>',
                '</td>',
                '</tr>',
                '</table>'
                );
                $("#baseDetail").html('');
                $("#baseDetail").html(data.join(''));
            }
            if(eachDataDetail.length==0){
                $("#receiptDetail").html("暂无数据");
            }else{
                if(eachData.receiptType==1){// 国内民宿应收
                    var isFq = eachDataDetail.isFq;
                    if(isFq==0){
                        isFq="否";
                    }else if(isFq==1){
                        isFq="是";
                    }else{
                        isFq="-";

                    }
                    dataDetail.push(
                    '<table class="table table-bordered">',
                    '<tr>',
                    '<td>商品ID</td>',
                    '<td>商品名称</td>',
                    '<td>番茄来了</td>',
                    '<td>应收金额</td>',
                    '<td>底价</td>',
                    '<td>实收金额</td>',
                    '<td>优惠金额</td>',
                    '<td>手续费</td>',
                    '</tr>',
                    '<tr>',
                    '<td>',
                    '<span style="color:blue">'+eachDataDetail.goodId+'</span>',
                    '</td>',
                    '<td>'+eachDataDetail.goodName+'</td>',
                    '<td>'+isFq+'</td>',
                    '<td>'+valNull(eachDataDetail.recAmount)+'</td>',
                    '<td>'+valNull(eachDataDetail.floorPrice)+'</td>',
                    '<td>'+valNull(eachDataDetail.realRecAmount)+'</td>',
                    '<td>'+valNull(eachDataDetail.couponAmount)+'</td>',
                    '<td>'+valNull(eachData.serviceCharge)+'</td>',
                    '</tr>',
                    '</table>'
                    );
                }else if(eachData.receiptType==2){//海外民宿应收
                    dataDetail.push(
                        '<table class="table table-bordered">',
                        '<tr>',
                        '<td>商品ID</td>',
                        '<td>商品名称</td>',
                        '<td>应收金额</td>',
                        '<td>总房费</td>',
                        '<td>清洁费</td>',
                        '<td>超员费</td>',
                        '<td>实收金额</td>',
                        '<td>优惠金额</td>',
                        '<td>手续费</td>',
                        '</tr>',
                        '<tr>',
                        '<td>',
                        '<span style="color:blue">'+eachDataDetail.goodId+'</span>',
                        '</td>',
                        '<td>'+eachDataDetail.goodName+'</td>',
                        '<td>'+valNull(eachDataDetail.recAmount)+'</td>',
                        '<td>'+valNull(eachDataDetail.totalHouse)+'</td>',
                        '<td>'+valNull(eachDataDetail.cleanFee)+'</td>',
                        '<td>'+valNull(eachDataDetail.overManFee)+'</td>',
                        '<td>'+valNull(eachDataDetail.realRecAmount)+'</td>',
                        '<td>'+valNull(eachDataDetail.couponAmount)+'</td>',
                        '<td>'+valNull(eachData.serviceCharge)+'</td>',
                        '</tr>',
                        '</table>'
                    );
                }else if(eachData.receiptType==3){//旅行应收
                    dataDetail.push(
                        '<table class="table table-bordered">',
                        '<tr>',
                        '<td>商品ID</td>',
                        '<td>商品名称</td>',
                        '<td>应收金额</td>',
                        '<td>实收金额</td>',
                        '<td>优惠金额</td>',
                        '<td>手续费</td>',
                        '</tr>',
                        '<tr>',
                        '<td>',
                        '<span style="color:blue">'+eachDataDetail.goodId+'</span>',
                        '</td>',
                        '<td>'+eachDataDetail.goodName+'</td>',
                        '<td>'+valNull(eachDataDetail.recAmount)+'</td>',
                        '<td>'+valNull(eachDataDetail.realRecAmount)+'</td>',
                        '<td>'+valNull(eachDataDetail.couponAmount)+'</td>',
                        '<td>'+valNull(eachData.serviceCharge)+'</td>',
                        '</tr>',
                        '</table>'
                    );
                }else if(eachData.receiptType==4){//旅行退款应收
                    $("#ysk_btn").show();
                    dataDetail.push(
                        '<table class="table table-bordered">',
                        '<tr>',
                        '<td>商品ID</td>',
                        '<td>商品名称</td>',
                        '<td>应收金额</td>',
                        '<td>实收金额</td>',
                        '<td>优惠金额</td>',
                        '<td>手续费</td>',
                        '</tr>',
                        '<tr>',
                        '<td>',
                        '<span style="color:blue">'+eachDataDetail.goodId+'</span>',
                        '</td>',
                        '<td>'+eachDataDetail.goodName+'</td>',
                        '<td>'+valNull(eachDataDetail.recAmount)+'</td>',
                        '<td>'+valNull(eachDataDetail.realRecAmount)+'</td>',
                        '<td>'+valNull(eachDataDetail.couponAmount)+'</td>',
                        '<td>'+valNull(eachData.serviceCharge)+'</td>',
                        '</tr>',
                        '</table>'
                    );
                }

                $("#receiptDetail").html('');
                $("#receiptDetail").html(dataDetail.join(''));
            }
        }else {
            layer.msg(res.msg);

        }

    };
    initList();
})