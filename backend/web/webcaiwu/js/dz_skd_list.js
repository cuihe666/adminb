/**
 * Created by admin on 2017/8/11.
 */
$(function(){
    var receiptNum=$(".sk_number").val(); // 收款单号
    var orderNum=$(".dd_number").val(); // 订单号
    var goodId=$(".sp_number").val(); // 商品id
    var beginTime =$("#date_start").val(); // 开始日期
    var endTime=$("#date_end").val(); // 结束日期
    var receiptType=$('#skdType').val(); // 收款 单类型
    var receiptStatus=$("#skdStatus").val(); // 收款单状态
    var timeType=$("#changeTime").val(); // 时间类型
    var absUrl = serveUrl();
    var flag = ''; // 待处理标记 待处理为1
    var pageNum=1; //第几页 必传
    var pageSize=$('#pageSize').val();//每页几条 必传
    var ajax_data = {receiptNum:receiptNum,orderNum:orderNum,goodId:goodId,receiptType:receiptType,receiptStatus:receiptStatus,timeType:timeType,beginTime:beginTime,endTime:endTime,flag:flag,pageNum:pageNum,pageSize:pageSize};
    var initList = function() {
        bindEvt();
        getDetail(ajax_data);
    };
    var bindEvt = function() {
        $("#search").on("click",search);//搜索
        $("#clear").on("click",clearDate);// 清除数据
        $('body').on('click','.seedetail',goDetail); // 查看
        $("#flagTab").on('click','li',flagTabClk); //数据 全部、待处理切换
        $('.form_table').on("click",".ysk_pop",yskPop); // 已收款按钮
        $("#pullOut").on("click",pullOut);//导出
        $("#pageSize").on("change",pageSizeChange); // 选择每页显示条数
        $("#pagination").on("click",'a',pageClick); // 翻页
    };
    var pageSizeChange = function () { // 每页显示条数
        ajax_data = JSON.parse(zc_store.get('dz_skd_ajax'))||ajax_data;
        ajax_data.pageSize = $(this).val();
        ajax_data.pageNum = 1;
        getDetail(ajax_data);
    }
    var pageClick = function(){ // 页码点击
        ajax_data = JSON.parse(zc_store.get('dz_skd_ajax'))||ajax_data;
        ajax_data.pageNum =$(this).attr("data-current");
        ajax_data.pageSize = $("#pageSize").val();
        zc_store.set("dz_skd_ajax",ajax_data); // 存 session 筛选项
        zc_store.set("pagenum",$(this).attr("data-current")); //
        zc_store.set("pagesize",$("#pageSize").val()); //
        //console.log(ajax_data,1111);
        getDetail(ajax_data);
    }; // 翻页
    var goDetail = function(){
        zc_store.set('dz_skd_ajax',ajax_data); // 存session
    }
    var flagTabClk = function () {//数据 全部、待处理切换
        clearDate();// 切换时清空
        zc_store.set('flagTab',$(this).attr('status'));
        if($(this).hasClass('current-top')){
            return false;
        }
        //console.log(ajax_data,111)
        $(this).addClass('current-top').siblings('li').removeClass('current-top');
        $.each(ajax_data, function (i,obj) {
            ajax_data[i] = '';
        });
        //console.log(ajax_data,222);
        if($(this).attr('status')=='1'){
            ajax_data.flag=1; // 待处理
        }else{
            ajax_data.flag = '';
        }
        ajax_data.pageNum =1;
        ajax_data.pageSize = $('#pageSize').val();
        getDetail(ajax_data);
        zc_store.set('dz_skd_ajax',ajax_data);
    }
    var pullOut = function () { // 导出
        if($(".form_table").attr('data')==0){ // 判断是否有数据
            layer.msg('暂无数据可导出');
            return;
        }
        var url = absUrl+'/api/finance/receipt/exportAll';
        var oarr = JSON.parse(zc_store.get('dz_skd_ajax'))|| ajax_data; // 导出带状态列表的数据参数
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
    var yskPop = function () {// 操作 已收款 弹框
        var ysk = layer.confirm('确认已收到商家退款？确认后订单将进入退款待审核列表进行处理', {
            btn: ['确定','取消'] //按钮
        }, function(){
            //确定订单分配 //TODO
            var popurl  = absUrl+'/api/finance/receipt/confirm';
            var updateBy = $('#opeRate').val();// 操作者id
            var receiptNum =$(this).parent().siblings(".skdh").text();// 收款单号
            var orderNum = $(this).parent().siblings(".ddbh").text();//订单单号
            var adata ={updateBy:updateBy,receiptNum:receiptNum,orderNum:orderNum};
            var ajaxdata = JSON.stringify(adata);
            $.ajax({
                type:'POST',
                url:popurl,
                data:ajaxdata,
                contentType:"application/json",
                success:function(res){
                    //console.log(res);
                    if(res.code=='0'){ // TODO
                        layer.msg(res.msg);
                    }else{
                        layer.msg(res.msg);
                    }
                },
                error:function(xhr) {
                    console.log('ajax error');
                    // alert('ajax error');
                }
            });
            layer.close(ysk);
        }, function(){
            layer.close(ysk);
        });
    }
    var clearDate = function(){ // 清空
        $(".sk_number,.dd_number,.sp_number,#date_start,#date_end,#skdType,#changeTime,#skdStatus").val("");
    }
    var search = function () {
        receiptNum=$(".sk_number").val();
        orderNum=$(".dd_number").val();
        goodId=$(".sp_number").val();
        beginTime =$("#date_start").val();
        endTime=$("#date_end").val();
        receiptType=$('#skdType').val();
        receiptStatus=$("#skdStatus").val();
        timeType=$("#changeTime").val();
        flag = Number($("#flagTab li.current-top").attr('status'));
        pageNum=1; //第几页 必传
        pageSize=$('#pageSize').val();//每页几条 必传
        if(beginTime==null && endTime!=null || beginTime==''&& endTime!=''||beginTime!=null && endTime==null || beginTime!=''&& endTime==''){
            layer.msg("请选择时间范围");
            return false;
        }
        //if(beginTime=="" && endTime==''&& receiptNum==''&& orderNum==''&& goodId==''&&receiptStatus==''){
        //    layer.msg("查询条件不能为空");
        //    return false;
        //}
        ajax_data = {receiptNum:receiptNum,orderNum:orderNum,goodId:goodId,receiptType:receiptType,receiptStatus:receiptStatus,timeType:timeType,beginTime:beginTime,endTime:endTime,flag:flag,pageNum:pageNum,pageSize:pageSize};
        zc_store.set('dz_skd_ajax',ajax_data); // 存session
        getDetail(ajax_data);
    }
    var getDetail = function(ajax_data) { //拉数据
        var ajax_url = absUrl+'/api/finance/receipt/receipts';
        if(zc_store.get('jlisdetail')=='true'){
            ajax_data = JSON.parse(zc_store.get('dz_skd_ajax'));

            if(zcGetLocationParm("pagenum")!=''){
                ajax_data.pageNum =zcGetLocationParm("pagenum");
            }
            if(zcGetLocationParm("pagesize")!=''){
                ajax_data.pageSize =zcGetLocationParm("pagesize");
            }
            if(zcGetLocationParm("flagtab")!=''){
                var val = zcGetLocationParm('flagtab');
                for(var i=0;i<$("#flagTab li").length;i++){
                    if($("#flagTab li").eq(i).attr('status')==val){
                        $("#flagTab li").eq(i).addClass("current").siblings('li').removeClass("current");
                    }
                }
            }
            $(".sk_number").val(ajax_data.receiptNum);// // 收款单号
            $(".dd_number").val(ajax_data.orderNum);// 订单号
            $('.sp_number').val(ajax_data.goodId); // 商品id
            $("#changeTime").val(ajax_data.timeType).selected; //时间类型
            $("#date_start").val(ajax_data.beginTime); //开始日期
            $("#date_end").val(ajax_data.endTime); //结束日期
            $("#skdType").val(ajax_data.receiptType).selected;//收款单类型
            $("#skdStatus").val(ajax_data.receiptStatus).selected;//收款单状态
            $("#pageSize").val(ajax_data.pageSize).selected; // 条数选定
            zc_store.set('jlisdetail',false);
        }else{
            zc_store.set('dz_skd_ajax',ajax_data);
        }
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
        $(".form_table").html(''); // 列表数据
        $("#pagination").html(""); // 翻页
        //console.log(res);
        var data = [];
        if(res.code=='0') {
            var page_num = 0;
            //console.log(res.pageInfo.total,000000000000,$("#pageSize").val())
            if(Number(res.pageInfo.total) == 0){
                $(".form_table").html("暂时没有数据").attr('data',0);
            }else if(Number(res.pageInfo.total) < $("#pageSize").val()){
                page_num = 1;
                $(".form_table").attr('data',1);
            }else{
                $(".form_table").attr('data',1);
                var pagesize = parseInt($("#pageSize").val());//页码
                if(parseInt(res.pageInfo.total % pagesize)==0){
                    page_num = parseInt(res.pageInfo.total / pagesize);
                }else{
                    page_num = parseInt(res.pageInfo.total / pagesize)+1;

                }
                //console.log(page_num,'页码')
            }
            $("#totalNum").html(page_num);// 总页


            var eachData = res.pageInfo.list;
            if(eachData.length==0) { // 汇总数据为空
                $(".form_table").html("暂无数据").attr('data',0);
            }else{
                $('.form_table').attr('data',1);
                data.push(
                    '<table class="table table-bordered">',
                    '<tbody>',
                    '<tr bgcolor="#ffcc99">',
                    '<td>',
                    ' <span style="display: inline-block">收款单号</span>',
                    '</td>',
                    '<td>',
                    ' <span>订单编号</span>',
                    ' </td>',
                    '<td>',
                    '<span>商品ID</span>',
                    '</td>',
                    '<td>',
                    '<span>收款单类型</span>',
                    '</td>',
                    '<td>',
                    ' <span>收款单状态</span>',
                    ' </td>',
                    '<td>',
                    '<span>创建时间</span>',
                    '</td>',
                    '<td>',
                    ' <span>完成时间</span>',
                    ' </td>',
                    '<td>',
                    '<span>收款方式</span>',
                    '</td>',
                    '<td>',
                    ' <span>操作</span>',
                    '</td>',
                    '</tr>'
                );
                $.each(eachData, function (i,obj) {
                    var skdtype = obj.receiptType;// 收款单类型
                    var skdstatus = obj.receiptStatus; // 收款单状态
                    var operate = '';// 操作明细的内容依据状态
                    if(skdtype==4&&skdstatus==0){
                        operate= '<span class="ysk_pop">已收款</span><a href="dz_skd_detail?receiptNum='+obj.receiptNum+'" class="seedetail">查看</a>';
                    }else{
                        operate= '<a href="dz_skd_detail?receiptNum='+obj.receiptNum+'" class="seedetail">查看</a>'
                    }
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
                    var payPlatform = obj.payPlatform; // 收款方式
                    if(payPlatform==1){
                        payPlatform ="支付宝";
                    }else if(payPlatform==2){
                        payPlatform ="微信";

                    }else if(payPlatform==3){
                        payPlatform ="银联";
                    }else{
                        payPlatform ="-";
                    }
                    if(skdstatus==-1){ // 收款单状态
                        skdstatus = '作废';
                    }else if(skdstatus==0){
                        skdstatus = '待收款';
                    }else if(skdstatus==1){
                        skdstatus = '已完成';
                    }else{
                        skdstatus = '--';
                    }
                    var sfm = 2;
                    //待付款状态时 不显示完成时间
                    if(obj.receiptStatus==0){
                        var updatetime = '-';
                    }else{
                        var updatetime = TimeToDate(obj.updateTime,sfm)
                    }
                    data.push(
                        '<tr>',
                        '<td class="skdh">'+obj.receiptNum+'</td>',
                        '<td class="ddbh">'+obj.orderNum+'</td>',
                        '<td>'+obj.goodId+'</td>',
                        '<td>'+skdtype+'</td>',
                        '<td>'+skdstatus+'</td>',
                        '<td>'+TimeToDate(obj.createTime,sfm)+'</td>',
                        '<td>'+updatetime+'</td>',
                        '<td>'+payPlatform+'</td>',
                        '<td updateBy='+obj.updateBy+' >'+operate+'</td>',
                        '</tr>'
                    )
                });
                data.push(
                    '</tbody>',
                    '</table>'
                );
                $(".form_table").html('');
                $(".form_table").html(data.join(''));
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
            }
            zc_store.set("pagesize",$("#pageSize").val()); // 存 session 每页几条
            zc_store.set("pagenum",res.pageInfo.pageNum); // 存 session 第几页
            zc_store.set("flagTab",$('#flagTab li.current-top').attr('status')); // 存 session 第几页
        }else {
            layer.msg(res.msg);

        }

    };
    initList();
})