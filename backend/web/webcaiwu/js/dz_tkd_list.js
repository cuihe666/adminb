/**
 * Created by admin on 2017/8/11.
 */
$(function(){
    var refundNum =$("#tk_number").val();// 退款单号
    var receiptNum=$("#sk_number").val(); // 收款单单号
    var orderNum=$("#dd_number").val(); // 订单单号
    var goodId=$("#sp_number").val(); //商品id
    var  refundStatus =$("#tk_state").val(); //退款单状态
    var refundType=$("#tk_lei").val(); // 退款单类型
    var timeType=$("#changeTime").val(); // 时间类型
    var beginTime =$("#date_start").val();//开始时间
    var endTime=$("#date_end").val(); //结束时间
    var absUrl = serveUrl();
    var pageNum=1; //第几页 必传
    var pageSize=$('#pageSize').val();//每页几条 必传
    var ajax_data = {receiptNum:receiptNum,orderNum:orderNum,goodId:goodId,refundNum:refundNum,refundType:refundType,timeType:timeType,beginTime:beginTime,endTime:endTime,refundStatus:refundStatus,pageNum:pageNum,pageSize:pageSize};
    var initList = function() {
        bindEvt();
        getDetail(ajax_data);
    };
    var bindEvt = function() {
        $("#search").on("click",search);//搜索
        $("#clear").on("click",clearDate);// 清除数据
	$('body').on('click','.seedetail',goDetail); // 查看
        $("#pullOut").on("click",pullOut);//导出
        $("#pageSize").on("change",pageSizeChange); // 选择每页显示条数
        $("#pagination").on("click",'a',pageClick); // 翻页
    };
    var pageSizeChange = function () { // 每页显示条数
        ajax_data = JSON.parse(zc_store.get('dz_tkd_ajax'))||ajax_data;
        ajax_data.pageSize = $(this).val();
        ajax_data.pageNum = 1;
        getDetail(ajax_data);
    }
    var pageClick = function(){ // 页码点击
        ajax_data = JSON.parse(zc_store.get('dz_tkd_ajax'))||ajax_data;
        ajax_data.pageNum =$(this).attr("data-current");
        ajax_data.pageSize = $("#pageSize").val();
        zc_store.set("dz_tkd_ajax",ajax_data); // 存 session 筛选项
        zc_store.set("pagenum",$(this).attr("data-current")); //
        zc_store.set("pagesize",$("#pageSize").val()); //
        //console.log(ajax_data,1111);
        getDetail(ajax_data);
    }; // 翻页
    var goDetail = function(){
        zc_store.set('dz_tkd_ajax',ajax_data); // 存session
    }
    var pullOut = function () { // 导出
        if($(".form_table").attr('data')==0){ // 判断是否有数据
            layer.msg('暂无数据可导出');
            return;
        }
        var url = absUrl+'/api/finance/refund/exportAll';
        var oarr = JSON.parse(zc_store.get('dz_tkd_ajax'))|| ajax_data; // 导出带状态列表的数据参数

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
    var clearDate = function(){
        $("#tk_number,#sk_number,#dd_number,#sp_number,#date_start,#date_end").val("");
        $("#tk_lei,#changeTime").val("");
        $("#tk_state").val("");// 退款单状态
    }
    var search = function () {
         refundNum =$("#tk_number").val();// 退款单号
         receiptNum=$("#sk_number").val(); // 收款单单号
         orderNum=$("#dd_number").val(); // 订单单号
         goodId=$("#sp_number").val(); //商品id
        refundStatus=$("#tk_state").val(); //退款单状态
          refundType=$("#tk_lei").val(); // 退款单类型
         timeType=$("#changeTime").val(); // 时间类型
         beginTime =$("#date_start").val();//开始时间
         endTime=$("#date_end").val(); //结束时间
        pageNum=1; //第几页 必传
        pageSize=$('#pageSize').val();//每页几条 必传
         ajax_data = {receiptNum:receiptNum,orderNum:orderNum,goodId:goodId,refundNum:refundNum,refundType:refundType,timeType:timeType,beginTime:beginTime,endTime:endTime,refundStatus:refundStatus,pageNum:pageNum,pageSize:pageSize};
        if(beginTime==null && endTime!=null || beginTime==''&& endTime!=''||beginTime!=null && endTime==null || beginTime!=''&& endTime==''){
            layer.msg("请选择时间范围");
            return false;
        }
        //if(beginTime=="" && endTime==''&& receiptNum==''&& orderNum==''&& goodId==''&& refundNum==''){
        //    layer.msg("查询条件不能为空");
        //    return false;
        //}
        zc_store.set('dz_tkd_ajax',ajax_data); //存session
        getDetail(ajax_data);
    }
    var getDetail = function(ajax_data) { //拉数据
        var ajax_url = absUrl+'/api/finance/refund/refunds';
        if(zc_store.get('jlisdetail')=='true'){
            ajax_data = JSON.parse(zc_store.get('dz_tkd_ajax'));

            if(zcGetLocationParm("pagenum")!=''){
                ajax_data.pageNum =zcGetLocationParm("pagenum");
            }
            if(zcGetLocationParm("pagesize")!=''){
                ajax_data.pageSize =zcGetLocationParm("pagesize");
            }
           
            $("#tk_number").val(ajax_data.refundNum);// // 退款单号
            $("#sk_number").val(ajax_data.receiptNum);// 收款单单号
            $("#dd_number").val(ajax_data.orderNum);// 订单单号
            $('#sp_number').val(ajax_data.goodId); // 商品id
            $("#changeTime").val(ajax_data.timeType).selected; //时间类型
            $("#date_start").val(ajax_data.beginTime); //开始日期
            $("#date_end").val(ajax_data.endTime); //结束日期
            $("#tk_lei").val(ajax_data.refundType).selected;//退款单类型
            $("#tk_state").val(ajax_data.refundStatus).selected;//退款单状态
            $("#pageSize").val(ajax_data.pageSize).selected; // 条数选定
            zc_store.set('jlisdetail',false);
        }else{
            zc_store.set('dz_tkd_ajax',ajax_data);
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
                layer.msg('数据加载失败');
                console.log('ajax error');
                // alert('ajax error');
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
                $(".form_table").attr('data',1);
                data.push(
                    '<table class="table table-bordered">',
                    '<tbody>',
                    '<tr bgcolor="#ffcc99">',
                    '<td>',
                    ' <span style="display:inline-block">退款单号</span>',
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
                    '<span>退款单类型</span>',
                    '</td>',
                    '<td>',
                    ' <span>退款单状态</span>',
                    ' </td>',
                    '<td>',
                    '<span>创建时间</span>',
                    '</td>',
                    '<td>',
                    ' <span>完成时间</span>',
                    ' </td>',
                    '<td>',
                    '<span>退款方式</span>',
                    '</td>',
                    '<td>',
                    ' <span>操作</span>',
                    '</td>',
                    '</tr>'
                );
                $.each(eachData, function (i,obj) {
                    var tktype = obj.refundType;// 退款单类型
                    if(tktype==1){
                        tktype = '民宿应退';
                    }else if(tktype==2){
                        tktype = '旅行应退';
                    }else{
                        tktype = '-';
                    }
                    var payPlatform = obj.payPlatform; // 退款方式
                    if(payPlatform==1){
                        payPlatform ="支付宝";
                    }else if(payPlatform==2){
                        payPlatform ="微信";

                    }else if(payPlatform==3){
                        payPlatform ="银联";
                    }else{
                        payPlatform ="-";

                    }
                    var tkstatus = obj.refundStatus; // 退款单状态
                    if(tkstatus==-1){
                        tkstatus = '作废';
                    }else if(tkstatus==0){
                        tkstatus = '待退款';
                    }else if(tkstatus==1){
                        tkstatus = '已完成';
                    }else{
                        tkstatus = '？？？';
                    }
                    var sfm = 2; // 时间格式 时分秒
                    //退款单状态 完成时间为0
                    if(obj.refundStatus=='0'){
                        var updateTime = '-';
                    }else{
                        var updateTime = TimeToDate(obj.updateTime,sfm);

                    }
                    data.push(
                        '<tr>',
                        '<td class="skdh">'+obj.refundNum+'</td>',
                        '<td class="ddbh">'+obj.orderNum+'</td>',
                        '<td>'+valNull(obj.receiptNum)+'</td>',
                        '<td>'+obj.goodId+'</td>',
                        '<td>'+tktype+'</td>',
                        '<td>'+tkstatus+'</td>',
                        '<td>'+TimeToDate(obj.createTime,sfm)+'</td>',
                        '<td>'+updateTime+'</td>',
                        '<td>'+payPlatform+'</td>',
                        '<td><a href="dz_tkd_detail?refundNum='+obj.refundNum+'">查看</a></td>',
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