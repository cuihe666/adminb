/**
 * Created by admin on 2017/8/11.
 */
$(function(){
    var paymentNum=zcGetLocationParm("paymentNum");
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
        window.location.href = 'dz_fkd_list?pagenum='+pagenum+'&pagesize='+pagesize;
    }
    var getDetail = function() {
        var ajax_url = absUrl+'/api/finance/payment/payments/'+paymentNum;
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
            var eachData = res.data.payment;
            var eachDataDetail = res.data.paymentDetail;
            if(eachData.length==0) { // 汇总数据为空
                $("#baseDetail").html("暂无数据");
            }else{
                var skdtype =eachData.paymentType;// 收款单类型
                if(skdtype==1){
                    skdtype = '国内房东应付';
                }else if(skdtype==2){
                    skdtype = '海外房东应付';

                }else if(skdtype==3){
                    skdtype = '合伙人应付';

                }else if(skdtype==4){
                    skdtype = '番茄来了房东应付';

                }else if(skdtype==5){
                    skdtype = '旅行达人应付';

                }else{
                    skdtype = '-';
                }
                var sfm=2;
                var skdstatus = eachData.paymentStatus; //付款单状态
                if(skdstatus==-1){
                    skdstatus = '作废';
                }else if(skdstatus==0){
                    skdstatus = '待付款';
                }else if(skdstatus==1){
                    skdstatus = '已完成';
                }else{
                    skdstatus = '-';
                }
                var payPlatform = eachData.payPlatform; //  支付方式
                //只有付款单的支付宝类型为2
                if(payPlatform==2){
                    payPlatform='支付宝';
                }else if(payPlatform==1){
                    payPlatform='微信';
                }else if(payPlatform==3){
                    payPlatform='银联';
                }else{
                    payPlatform='-';
                }
                if(eachData.paymentStatus==0){
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
                    '<span>付款单号：</span>',
                    '<em>'+valNull(eachData.paymentNum)+'</em>',
                    '</td>',
                    '<td>',
                    '<span>付款单类型：</span>',
                    '<em>'+skdtype+'</em>',
                    '</td>',
                    '<td>',
                    '<span>商家姓名：</span>',
                    '<em>'+valNull(eachData.sellerName)+'</em>',
                    '</td>',
                    '</tr>',
                    '<tr>',
                    ' <td>',
                    '<span>订单编号：</span>',
                    '<em>'+valNull(eachData.orderNum)+'</em>',
                    '</td>',
                    '<td>',
                    '<span>付款单状态：</span>',
                    '<em>'+skdstatus+'</em>',
                    '</td>',
                    '<td>',
                    '<span>商家电话：</span>',
                    '<em>'+valNull(eachData.sellerMobile)+'</em>',
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
                    '<span>付款方式：</span>',
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
                    '<span>收款人姓名：</span>',
                    '<em>'+valNull(eachData.accountNumber)+'</em>',
                    '</td>',
                    '</tr>',
                    '</table>'
                );
                $("#fkdBase").html('');
                $("#fkdBase").html(data.join(''));
            }
            if(eachDataDetail.length==0){
                $(".form_table2").html("暂无数据");
            }else{
                if(eachData.paymentType==1){ // 国内房东应付
                    dataDetail.push(
                        '<table class="table table-bordered">',
                        '<tr>',
                        '<td>商品ID</td>',
                        '<td>商品名称</td>',
                        '<td>城市</td>',
                        '<td>应收金额</td>',
                        '<td>实际消费金额</td>',
                        '<td>佣金比例</td>',
                        '<td>应付金额</td>',
                        '<td>变更金额</td>',
                        '<td>实付金额</td>',
                        '<td>补贴优惠金额</td>',
                        '<td>补贴退款</td>',
                        '</tr>',
                        '<tr>',
                        '<td>',
                        '<span style="color:blue">'+valNull(eachDataDetail.goodId)+'</span>',
                        '</td>',
                        '<td>'+valNull(eachDataDetail.goodName)+'</td>',
                        '<td>'+valNull(eachDataDetail.cityName)+'</td>',
                        '<td>'+valNull(eachDataDetail.recAmount)+'</td>',
                        '<td>'+valNull(eachDataDetail.realConsume)+'</td>',
                        '<td>'+valNull(eachDataDetail.commissionRate)+'%</td>',
                        '<td>'+valNull(eachDataDetail.payAmount)+'</td>',
                        '<td>'+valNull(eachDataDetail.modifyAmount)+'</td>',
                        '<td>'+valNull(eachDataDetail.realPayAmount)+'</td>',
                        '<td>'+valNull(eachDataDetail.couponAmount)+'</td>',
                        '<td>'+valNull(eachDataDetail.subsidyRefund)+'</td>',
                        '</tr>',
                        '</table>'
                    );
                }else if(eachData.paymentType==2){ //海外房东应付
                    dataDetail.push(
                        '<table class="table table-bordered">',
                        '<tr>',
                        '<td>商品ID</td>',
                        '<td>商品名称</td>',
                        '<td>城市</td>',
                        '<td>应收金额</td>',
                        '<td>实际消费金额</td>',
                        '<td>底价</td>',
                        '<td>实际消费底价</td>',
                        '<td>佣金比例</td>',
                        '<td>应付金额</td>',
                        '<td>变更金额</td>',
                        '<td>实付金额</td>',
                        '<td>补贴优惠金额</td>',
                        '<td>补贴退款</td>',
                        '</tr>',
                        '<tr>',
                        '<td>',
                        '<span style="color:blue">'+valNull(eachDataDetail.goodId)+'</span>',
                        '</td>',
                        '<td>'+valNull(eachDataDetail.goodName)+'</td>',
                        '<td>'+valNull(eachDataDetail.cityName)+'</td>',
                        '<td>'+valNull(eachDataDetail.recAmount)+'</td>',
                        '<td>'+valNull(eachDataDetail.realConsume)+'</td>',
                        '<td>'+valNull(eachDataDetail.floorPrice)+'</td>',
                        '<td>'+valNull(eachDataDetail.realFloorPrice)+'</td>',
                        '<td>'+valNull(eachDataDetail.commissionRate)+'%</td>',
                        '<td>'+valNull(eachDataDetail.payAmount)+'</td>',
                        '<td>'+valNull(eachDataDetail.modifyAmount)+'</td>',
                        '<td>'+valNull(eachDataDetail.realPayAmount)+'</td>',
                        '<td>'+valNull(eachDataDetail.couponAmount)+'</td>',
                        '<td>'+valNull(eachDataDetail.subsidyRefund)+'</td>',
                        '</tr>',
                        '</table>'
                    );
                }else if(eachData.paymentType==3){//合伙人应付
                    var isFq = eachDataDetail.isFq;
                    if(isFq==0){
                        isFq="否";
                    }else if(isFq==1){
                        isFq="是";
                    }
                    dataDetail.push(
                        '<table class="table table-bordered">',
                        '<tr>',
                        '<td>商品ID</td>',
                        '<td>商品名称</td>',
                        '<td>城市</td>',
                        '<td>番茄来了</td>',
                        '<td>应收金额</td>',
                        '<td>实际消费金额</td>',
                        '<td>底价</td>',
                        '<td>实际消费底价</td>',
                        '<td>佣金比例</td>',
                        '<td>实付金额</td>',
                        '<td>补贴优惠金额</td>',
                        '</tr>',
                        '<tr>',
                        '<td>',
                        '<span style="color:blue">'+valNull(eachDataDetail.goodId)+'</span>',
                        '</td>',
                        '<td>'+valNull(eachDataDetail.goodName)+'</td>',
                        '<td>'+valNull(eachDataDetail.cityName)+'</td>',
                        '<td>'+isFq+'</td>',
                        '<td>'+valNull(eachDataDetail.recAmount)+'</td>',
                        '<td>'+valNull(eachDataDetail.realConsume)+'</td>',
                        '<td>'+valNull(eachDataDetail.floorPrice)+'</td>',
                        '<td>'+valNull(eachDataDetail.realFloorPrice)+'</td>',
                        '<td>'+valNull(eachDataDetail.commissionRate)+'%</td>',
                        '<td>'+valNull(eachDataDetail.realPayAmount)+'</td>',
                        '<td>'+valNull(eachDataDetail.couponAmount)+'</td>',
                        '</tr>',
                        '</table>'
                    );
                }else if(eachData.paymentType==4){//番茄来了房东应付
                    $("#ysk_btn").show();
                    dataDetail.push(
                        '<table class="table table-bordered">',
                        '<tr>',
                        '<td>商品ID</td>',
                        '<td>商品名称</td>',
                        '<td>城市</td>',
                        '<td>应收金额</td>',
                        '<td>实际消费金额</td>',
                        '<td>底价</td>',
                        '<td>实际消费底价</td>',
                        '<td>佣金比例</td>',
                        '<td>应付金额</td>',
                        '<td>变更金额</td>',
                        '<td>实付金额</td>',
                        '<td>补贴优惠金额</td>',
                        '<td>补贴退款</td>',
                        '</tr>',
                        '<tr>',
                        '<td>',
                        '<span style="color:blue">'+valNull(eachDataDetail.goodId)+'</span>',
                        '</td>',
                        '<td>'+valNull(eachDataDetail.goodName)+'</td>',
                        '<td>'+valNull(eachDataDetail.cityName)+'</td>',
                        '<td>'+valNull(eachDataDetail.recAmount)+'</td>',
                        '<td>'+valNull(eachDataDetail.realConsume)+'</td>',
                        '<td>'+valNull(eachDataDetail.floorPrice)+'</td>',
                        '<td>'+valNull(eachDataDetail.realFloorPrice)+'</td>',
                        '<td>'+valNull(eachDataDetail.commissionRate)+'%</td>',
                        '<td>'+valNull(eachDataDetail.payAmount)+'</td>',
                        '<td>'+valNull(eachDataDetail.modifyAmount)+'</td>',
                        '<td>'+valNull(eachDataDetail.realPayAmount)+'</td>',
                        '<td>'+valNull(eachDataDetail.couponAmount)+'</td>',
                        '<td>'+valNull(eachDataDetail.subsidyRefund)+'</td>',
                        '</tr>',
                        '</table>'
                    );
                }else if(eachData.paymentType==5){//旅行达人应付
                    dataDetail.push(
                        '<table class="table table-bordered">',
                        '<tr>',
                        '<td>商品ID</td>',
                        '<td>商品名称</td>',
                        '<td>城市</td>',
                        '<td>应收金额</td>',
                        '<td>佣金比例</td>',
                        '<td>实付金额</td>',
                        '<td>补贴优惠金额</td>',
                        '</tr>',
                        '<tr>',
                        '<td>',
                        '<span style="color:blue">'+valNull(eachDataDetail.goodId)+'</span>',
                        '</td>',
                        '<td>'+valNull(eachDataDetail.goodName)+'</td>',
                        '<td>'+valNull(eachDataDetail.cityName)+'</td>',
                        '<td>'+valNull(eachDataDetail.recAmount)+'</td>',
                        '<td>'+valNull(eachDataDetail.commissionRate)+'%</td>',
                        '<td>'+valNull(eachDataDetail.realPayAmount)+'</td>',
                        '<td>'+valNull(eachDataDetail.couponAmount)+'</td>',
                        '</tr>',
                        '</table>'
                    );
                };
                $(".form_table2").html('');
                $(".form_table2").html(dataDetail.join(''));
                var data3 = [];
                var bankVo = res.data.bankVo;
                var type = bankVo.type;
                if(type==1){
                    type='微信';
                }else if(type==2){
                    type='支付宝';
                }else if(type==3){
                    type='银行卡';
                }else{
                    type='-';
                }
                var  accountType = bankVo.accountType; // 账户属性
                if(accountType==1){
                    accountType = '对公';
                }else if(accountType ==0 ){
                    accountType = '对私';
                }else{
                    accountType = '-';
                }
                data3.push(
                '<table class="table">',
                    '<tbody>',
                '<tr>',
                '<td colspan="3">商家账号信息</td>',
                '</tr><tr>',
                ' <td><span>开户名：</span><em>'+valNull(bankVo.name)+'</em></td>',
                ' <td><span>银行名称：</span><em>'+valNull(bankVo.bank)+'</em></td>',
                //' <td><span>备注：</span><em>????</em></td>',
                ' </tr><tr>',
                ' <td><span>收款账号：</span><em>'+valNull(bankVo.accountNumber)+'</em></td>',
                ' <td><span>开户行：</span><em>'+valNull(bankVo.bankBranch)+'</em></td>',
                '</tr><tr>',
                '<td><span>银行卡类型：</span><em>'+type+'</em></td>',
                ' <td><span>账号属性：</span><em>'+accountType+'</em></td>',
                ' </tr></tbody></table>'
                );
                $("#sjDetail").html(data3.join(''));
            }
        }else {
            layer.msg(res.msg);

        }

    };
    initList();
})