/**
 * Created by admin on 2017/8/11.
 */
$(function(){
    var paymentNum =$("#fk_number").val();// 付款单号
    var receiptNum=$("#sk_number").val(); // 收款单单号
    var orderNum=$("#dd_number").val(); // 订单单号
    var goodId=$("#sp_number").val(); //商品id
    var  paymentStatus =$("#fkd_state").val(); //付款单状态
    var paymentType=$("#fkd_lei").val(); // 付款单类型
    var timeType=$("#changeTime").val(); // 时间类型
    var beginTime =$("#date_start").val();//开始时间
    var endTime=$("#date_end").val();; //结束时间
    var absUrl = serveUrl();
    var pageNum=1; //第几页 必传
    var pageSize=$('#pageSize').val();//每页几条 必传
    var ajax_data = {receiptNum:receiptNum,orderNum:orderNum,goodId:goodId,paymentNum:paymentNum,paymentType:paymentType,timeType:timeType,beginTime:beginTime,endTime:endTime,paymentStatus:paymentStatus,pageNum:pageNum,pageSize:pageSize};
    var initList = function() {
        bindEvt();
        getDetail(ajax_data);
    };
    var bindEvt = function() {
        $("#search").on("click",search);//搜索
        $("#clear").on("click",clearDate);// 清除数据
        $("#pageSize").on("change",pageSizeChange); // 选择每页显示条数
        $("#pagination").on("click",'a',pageClick); // 翻页
        $("body").on('click','#pullOut',pullOutExt); // 导出
        $('body').on('click','.seedetail',goDetail); // 查看
    };
    var pageSizeChange = function () { // 每页显示条数
        ajax_data = JSON.parse(zc_store.get('dz_fkd_ajax'))||ajax_data;
        ajax_data.pageSize = $(this).val();
        ajax_data.pageNum = 1;
        getDetail(ajax_data);
    }
    var pageClick = function(){ // 页码点击
        ajax_data = JSON.parse(zc_store.get('dz_fkd_ajax'))||ajax_data;
        ajax_data.pageNum =$(this).attr("data-current");
        ajax_data.pageSize = $("#pageSize").val();
        zc_store.set("dz_fkd_ajax",ajax_data); // 存 session 筛选项
        zc_store.set("pagenum",$(this).attr("data-current")); //
        zc_store.set("pagesize",$("#pageSize").val()); //
        //console.log(ajax_data,1111);
        getDetail(ajax_data);
    }; // 翻页
    var goDetail = function(){
        zc_store.set('dz_fkd_ajax',ajax_data); // 存session
    }
    var pullOutExt = function () { //导出
        if($(".form_table").attr('data')==0){ // 判断是否有数据
            layer.msg('暂无数据可导出');
            return;
        }
        var url = absUrl+'/api/finance/payment/exportAll';
        var oarr = JSON.parse(zc_store.get('dz_fkd_ajax'))|| ajax_data; // 导出带状态列表的数据参数

        var arr = [];
        var str='';
        for(var i in oarr) {
            arr.push([i, oarr[i]]);
        }
        $.each(arr, function (i,obj) {
            str+='&'+obj[0]+'='+obj[1];
        })
        window.location.href = url+'?123'+str; // 导出
    };
    var clearDate = function(){
        $("#fk_number,#sk_number,#dd_number,#sp_number,#date_start,#date_end,#fkd_lei,#changeTime,#fkd_state").val("");
    };
    var search = function () {
         paymentNum =$("#fk_number").val();// 付款单号
         receiptNum=$("#sk_number").val(); // 收款单单号
         orderNum=$("#dd_number").val(); // 订单单号
         goodId=$("#sp_number").val(); //商品id
         paymentStatus=$("#fkd_state").val(); //付款单状态
         paymentType=$("#fkd_lei").val(); // 付款单类型
         timeType=$("#changeTime").val(); // 时间类型
         beginTime =$("#date_start").val();//开始时间
         endTime=$("#date_end").val(); //结束时间
         pageNum=1; //第几页 必传
         pageSize=$('#pageSize').val();//每页几条 必传
         ajax_data = {receiptNum:receiptNum,orderNum:orderNum,goodId:goodId,paymentNum:paymentNum,paymentType:paymentType,timeType:timeType,beginTime:beginTime,endTime:endTime,paymentStatus:paymentStatus,pageSize:pageSize,pageNum:pageNum};
        if(beginTime==null && endTime!=null || beginTime==''&& endTime!=''||beginTime!=null && endTime==null || beginTime!=''&& endTime==''){
            layer.msg("请选择时间范围");
            return false;
        }
        //if(beginTime=="" && endTime==''&& receiptNum==''&& orderNum==''&& goodId==''&& paymentNum==''){
        //    layer.msg("查询条件不能为空");
        //    return false;
        //}
        //console.log(ajax_data);
        getDetail(ajax_data);
        zc_store.set('dz_fkd_ajax',ajax_data); // 存session
    };
    var getDetail = function(ajax_data) {
        var ajax_url = absUrl+'/api/finance/payment/payments';
        if(zc_store.get('jlisdetail')=='true'){
            ajax_data = JSON.parse(zc_store.get('dz_fkd_ajax'));

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
            $("#fk_number").val(ajax_data.paymentNum);// // 付款单号
            $("#sk_number").val(ajax_data.receiptNum);// 收款单号
            $("#dd_number").val(ajax_data.orderNum); // 订单号
            $("#sp_number").val(ajax_data.goodId); // 商品id
            $("#changeTime").val(ajax_data.timeType).selected; //时间类型
            $("#date_start").val(ajax_data.beginTime); //开始日期
            $("#date_end").val(ajax_data.endTime); //结束日期
            $("#fkd_lei").val(ajax_data.paymentType).selected;//付款单类型
            $("#fkd_state").val(ajax_data.paymentStatus).selected;//付款单状态
            $("#pageSize").val(ajax_data.pageSize).selected; // 条数选定
            zc_store.set('jlisdetail',false);
        }else{
            zc_store.set('dz_fkd_ajax',ajax_data);
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
                $(".shade_wrap").fadeOut();
                layer.msg('数据请求失败');
                console.log('ajax error');
                // alert('ajax error');
            }
        });
    };
    var onGetDetailSuccess = function(res) {
        $(".shade_wrap").fadeOut();
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
                $(".form_table").attr('data',1);
                data.push(
                    '<table class="table table-bordered">',
                    '<tbody>',
                    '<tr bgcolor="#ffcc99">',
                    '<td>',
                    ' <span style="display:inline-block">付款单号</span>',
                    '</td>',
                    '<td>',
                    ' <span>订单编号</span>',
                    ' </td>',
                    '<td>',
                    '<span>收款单号</span>',
                    '</td>',
                    '<td>',
                    '<span>商品ID</span>',
                    '</td>',
                    '<td>',
                    '<span>付款单类型</span>',
                    '</td>',
                    '<td>',
                    ' <span>付款单状态</span>',
                    ' </td>',
                    '<td>',
                    '<span>创建时间</span>',
                    '</td>',
                    '<td>',
                    ' <span>完成时间</span>',
                    ' </td>',
                    '<td>',
                    '<span>付款方式</span>',
                    '</td>',
                    '<td>',
                    ' <span>操作</span>',
                    '</td>',
                    '</tr>'
                );
                $.each(eachData, function (i,obj) {
                    var fkdtype = obj.paymentType;// 付款单类型
                    if(fkdtype==1){
                        fkdtype = '国内房东应付';
                    }else if(fkdtype==2){
                        fkdtype = '海外房东应付';

                    }else if(fkdtype==3){
                        fkdtype = '合伙人应付';

                    }else if(fkdtype==4){
                        fkdtype = '番茄来了房东应付';

                    }else if(fkdtype==5){
                        fkdtype = '旅行达人应付';

                    }else{
                        fkdtype = '-';
                    }
                    var payPlatform = obj.payPlatform; // 付款方式
                    //只有付款单的支付宝类型为2
                    if(payPlatform==2){
                        payPlatform ="支付宝";
                    }else if(payPlatform==1){
                        payPlatform ="微信";

                    }else if(payPlatform==3){
                        payPlatform ="银联";
                    }else{
                        payPlatform ="-";
                    }
                    var fkdstatus = obj.paymentStatus; // 付款单状态
                    if(fkdstatus==-1){
                        fkdstatus = '作废';
                    }else if(fkdstatus==0){
                        fkdstatus = '待付款';
                    }else if(fkdstatus==1){
                        fkdstatus = '已完成';
                    }else{
                        fkdstatus = '-';
                    }
                    var sfm = 2; // 时间格式 时分秒
                    //付款 单状态是待付款 不显示完成时间
                    if(obj.paymentStatus==0){
                        var jlupdateTime = '-';
                    }else{
                        var jlupdateTime = TimeToDate(obj.updateTime,sfm);
                    }
                    data.push(
                        '<tr>',
                        '<td class="skdh">'+obj.paymentNum+'</td>',
                        '<td class="ddbh">'+obj.orderNum+'</td>',
                        '<td>'+valNull(obj.receiptNum)+'</td>',
                        '<td>'+obj.goodId+'</td>',
                        '<td>'+fkdtype+'</td>',
                        '<td>'+fkdstatus+'</td>',
                        '<td>'+TimeToDate(obj.createTime,sfm)+'</td>',
                        '<td>'+jlupdateTime+'</td>',
                        '<td>'+payPlatform+'</td>',
                        '<td><a href="dz_fkd_detail?paymentNum='+obj.paymentNum+'">查看</a></td>',
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
        }else {
            layer.msg(res.msg);

        }

    };
    initList();
})