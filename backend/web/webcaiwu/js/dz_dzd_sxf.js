/**
 * Created by admin on 2017/8/11.
 */
$(function(){
    var orderNum=$("#dd_number").val(); // 订单单号
    var financeNum =$("#cw_number").val();// 财务单单号
    var financeType = $("#djtype").val();// 财务单类型
    var serviceLine =$("#ywx").val();// 业务线
    var beginTime =$("#date_start").val();//开始时间
    var endTime=$("#date_end").val(); //结束时间
    var pageNum=1; //第几页 必传
    var pageSize=$('#pageSize').val();//每页几条 必传
    var absUrl = serveUrl();
    var ajax_data = {orderNum:orderNum,financeNum:financeNum,financeType:financeType,serviceLine:serviceLine,beginTime:beginTime,endTime:endTime,pageNum:pageNum,pageSize:pageSize};
    var initList = function() {
        bindEvt();
        getDetail(ajax_data);
    };
    var bindEvt = function() {
        $("#search").on("click",search);//搜索
        $("#clear").on("click",clearDate);// 清除数据
        $("#pullOut").on("click",pullOut);// 导出
        $("#pageSize").on("change",pageSizeChange); // 选择每页显示条数
        $("#pagination").on("click",'a',pageClick); // 翻页
    };
    var pullOut = function(){
        if($(".form_table").attr('data')==0){ // 判断是否有数据
            layer.msg('暂无数据可导出');
            return;
        }
        var url = absUrl+'/api/finance/exportAll';
        var arr = [];
        var str='';
        for(var i in ajax_data) {
            arr.push([i, ajax_data[i]]);
        }
        $.each(arr, function (i,obj) {
            str+='&'+obj[0]+'='+obj[1];
        });
        window.location.href = url+'?123'+str; // 导出
    }
    var clearDate = function(){ // 清空
        $("#cw_number,#dd_number,#date_start,#date_end,#djtype,#ywx").val("");
    }
    var search = function () {
         orderNum=$("#dd_number").val(); // 订单单号
         financeNum =$("#cw_number").val();// 财务单单号
         financeType = $("#djtype").val();// 财务单类型
         serviceLine =$("#ywx").val();// 业务线
         beginTime =$("#date_start").val();//开始时间
         endTime=$("#date_end").val(); //结束时间
        pageNum=1; //第几页 必传
        pageSize=$('#pageSize').val();//每页几条 必传
         ajax_data = {orderNum:orderNum,financeNum:financeNum,financeType:financeType,serviceLine:serviceLine,beginTime:beginTime,endTime:endTime,pageNum:pageNum,pageSize:pageSize};
        if(beginTime==null && endTime!=null || beginTime==''&& endTime!=''||beginTime!=null && endTime==null || beginTime!=''&& endTime==''){
            layer.msg("请选择时间范围");
            return false;
        }
        //if(beginTime=="" && endTime==''&& financeNum==''&& orderNum==''){
        //    layer.msg("查询条件不能为空");
        //    return false;
        //}
        //console.log(ajax_data);
        getDetail(ajax_data);
    };
    var pageSizeChange = function () { // 每页显示条数
        ajax_data.pageSize = $(this).val();
        ajax_data.pageNum = 1;
        getDetail(ajax_data);
    }
    var pageClick = function(){ // 页码点击
        ajax_data.pageNum =$(this).attr("data-current");
        ajax_data.pageSize = $("#pageSize").val();
        getDetail(ajax_data);
    }; // 翻页
    var getDetail = function(ajax_data) {
        var ajax_url = absUrl+'/api/finance/statistics/charge';
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
        $(".shade_wrap").fadeOut(); // 加载蒙层隐藏
        $("#ddListData").html(''); // 列表数据
        $("#pagination").html(""); // 翻页
        //console.log(res);
        var data = [];
        if(res.code=='0') {
            var page_num = 0;
            //console.log(res.pageInfo.total,$("#pageSize").val());
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
                    '<tr>',
                    '<td>',
                    ' <span style="display:inline-block">日期</span>',
                    '</td>',
                    '<td>',
                    ' <span>订单编号</span>',
                    ' </td>',
                    '<td>',
                    '<span>业务线</span>',
                    '</td>',
                    '<td>',
                    '<span>收款单号</span>',
                    '</td>',
                    '<td>',
                    '<span>退款单号</span>',
                    '</td>',
                    '<td>',
                    ' <span>结算单号</span>',
                    ' </td>',
                    '<td>',
                    '<span>手续费</span>',
                    '</td>',
                    '</tr>'
                );
                $.each(eachData, function (i,obj) {
                    var ywx = obj.serviceLine;// 业务线
                    if(ywx==1){ // 民宿
                        ywx = '民宿';
                    }else if(ywx==2){ // 旅行
                        ywx = '旅行';
                    }else{
                        ywx = '-';
                    }
                    var sfm = 2; // 时间格式 时分秒
                    data.push(
                        '<tr>',
                        '<td>'+TimeToDate(obj.completeTime,sfm)+'</td>',
                        '<td>'+valNull(obj.orderNum)+'</td>',
                        '<td>'+ywx+'</td>',
                        '<td>'+valNull(obj.receiptNum)+'</td>',
                        '<td>'+valNull(obj.refundNum)+'</td>',
                        '<td>'+valNull(obj.settlementNum)+'</td>',
                        '<td>'+valNull(obj.charge)+'</td>',
                        '</tr>'
                    )
                });
                data.push(
                    '<tr>',
                    '<td>汇总：</td>',
                    '<td>-</td>',
                    '<td>-</td>',
                    '<td>-</td>',
                    '<td>-</td>',
                    '<td>-</td>',
                    '<td>'+res.data+'</td>',
                    '</tr>',
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
        }else {
            layer.msg(res.msg);
        }
    };
    initList();
})