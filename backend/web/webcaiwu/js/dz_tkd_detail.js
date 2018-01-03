/**
 * Created by admin on 2017/8/11.
 */
$(function(){
    var refundNum=zcGetLocationParm("refundNum");
    var absUrl = serveUrl();
    var initList = function() {
        bindEvt();
        getDetail();
    };
    var bindEvt = function() {
        $("#goback").on("click",goBack);

    };
    var goBack = function(){ // 返回上一页
        var pagenum = zc_store.get('pagenum');
        var pagesize = zc_store.get('pagesize');
        zc_store.set('jlisdetail',true);// 来源是详情页返回
        window.location.href = 'dz_tkd_list?pagenum='+pagenum+'&pagesize='+pagesize;
    }
    var getDetail = function(){
        var ajax_url = absUrl+'/api/finance/refund/refunds/'+refundNum;
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
            var eachData = res.data.refund;
            var eachDataDetail = res.data.refundDetail;
            if(eachData.length==0) { // 汇总数据为空
                $("#baseDetail").html("暂无数据");
            }else{
                var tktype =eachData.refundType;// 退款单类型
                if(tktype==1){
                    tktype = '民宿应退';

                }else if(tktype==2){
                    tktype = '旅行应退';

                }else{
                    tktype = '-';
                }
                var sfm=2;
                var tkstatus = eachData.refundStatus; // 退款单状态
                if(tkstatus==-1){
                    tkstatus = '作废';
                }else if(tkstatus==0){
                    tkstatus = '待退款';
                }else if(tkstatus==1){
                    tkstatus = '已完成';
                }else{
                    tkstatus = '？？？';
                }
                var payPlatform = eachData.payPlatform; //  支付方式
                if(payPlatform==1){
                    payPlatform='支付宝';
                }else if(payPlatform==2){
                    payPlatform='微信';
                }else if(payPlatform==3){
                    payPlatform='银联';
                }else{
                    payPlatform='--';
                }
                if(eachData.refundStatus==0){
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
                    '<span>退款单号：</span>',
                    '<em>'+eachData.refundNum+'</em>',
                    '</td>',
                    '<td>',
                    '<span>退款单类型：</span>',
                    '<em>'+tktype+'</em>',
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
                    '<span>退款单状态：</span>',
                    '<em>'+tkstatus+'</em>',
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
                    '<em>'+TimeToDate(eachData.createTime,sfm)+'</em>',
                    '</td>',
                    '<td>',
                    '<span>支付方式：</span>',
                    '<em>'+payPlatform+'</em>',
                    '</td>',
                    '</tr>',
                    '<tr>',
                    '<td>',
                    '<span>收款单号：</span>',
                    '<em>'+valNull(eachData.receiptNum)+'</em>',
                    '</td>',
                    '<td>',
                    '<span>完成时间：</span>',
                    '<em>'+endTime+'</em>',
                    '</td>',
                    '<td>',
                    '<span>支付账号：</span>',
                    //'<em>'+eachData.accountNumber+'</em>',// 数据里没有这个字段 TODO
                    '<em>-</em>',
                    '</td>',
                    '</tr>',
                    '</table>'
                );
                $("#baseDetail").html('');
                $("#baseDetail").html(data.join(''));
            }
            if(eachDataDetail.length==0){
                $(".tdkDetail").html("暂无数据");
            }else{
                if(eachData.refundType==1){ // 民宿应退
                    dataDetail.push(
                        '<table class="table table-bordered">',
                        '<tr>',
                        '<td>商品ID</td>',
                        '<td>商品名称</td>',
                        '<td>应收金额</td>',
                        '<td>实收金额</td>',
                        '<td>实际消费金额</td>',
                        '<td>应退金额</td>',
                        '<td>实退金额</td>',
                        '<td>补贴退款</td>',
                        '<td>退还优惠券</td>',
                        '<td>使用优惠金额</td>',
                        '<td>退还手续费</td>',
                        '</tr>',
                        '<tr>',
                        '<td>',
                        '<span style="color:blue">'+eachDataDetail.goodId+'</span>',
                        '</td>',
                        '<td>'+eachDataDetail.goodName+'</td>',
                        '<td>'+valNull(eachDataDetail.recAmount)+'</td>',
                        '<td>'+valNull(eachDataDetail.realRecAmount)+'</td>',
                        '<td>'+valNull(eachDataDetail.realConsume)+'</td>',
                        '<td>'+valNull(eachDataDetail.refundAmount)+'</td>',
                        '<td>'+valNull(eachDataDetail.realRefund)+'</td>',
                        '<td>'+valNull(eachDataDetail.subsidyRefund)+'</td>',
                        '<td>'+valNull(eachDataDetail.refundCoupon)+'</td>',
                        '<td>'+valNull(eachDataDetail.couponAmount)+'</td>',
                        '<td>'+valNull(eachData.refundCharge)+'</td>',
                        '</tr>',
                        '</table>'
                    );
                }else if(eachData.refundType==2){ //旅行应退
                    dataDetail.push(
                        '<table class="table table-bordered">',
                        '<tr>',
                        '<td>商品ID</td>',
                        '<td>商品名称</td>',
                        '<td>应收金额</td>',
                        '<td>实收金额</td>',
                        '<td>应退金额</td>',
                        '<td>实退金额</td>',
                        '<td>退还优惠券</td>',
                        '<td>使用优惠金额</td>',
                        '<td>退还手续费</td>',
                        '</tr>',
                        '<tr>',
                        '<td>',
                        '<span style="color:blue">'+eachDataDetail.goodId+'</span>',
                        '</td>',
                        '<td>'+eachDataDetail.goodName+'</td>',
                        '<td>'+valNull(eachDataDetail.recAmount)+'</td>',
                        '<td>'+valNull(eachDataDetail.realRecAmount)+'</td>',
                        '<td>'+valNull(eachDataDetail.refundAmount)+'</td>',
                        '<td>'+valNull(eachDataDetail.realRefund)+'</td>',
                        '<td>'+valNull(eachDataDetail.refundCoupon)+'</td>',
                        '<td>'+valNull(eachDataDetail.couponAmount)+'</td>',
                        '<td>'+valNull(eachData.refundCharge)+'</td>',
                        '</tr>',
                        '</table>'
                    );
                }
                $(".tdkDetail").html('');
                $(".tdkDetail").html(dataDetail.join(''));
            }
        }else {
            layer.msg(res.msg);

        }

    };
    initList();
})