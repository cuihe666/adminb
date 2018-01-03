$(function() {


	var httpUrl = serveUrl();
	var subListUrl = httpUrl+'/api/subject/getsubjectlist'; //列表
	var subEditUrl = httpUrl+'/api/subject/getSubjectByid';	//修改编辑
	var subUseUrl = httpUrl+'/api/subject/enable';	//启用/禁用
	var subDelUrl = httpUrl+'/api/subject/delete'; //删除

	var totalPage = 0;//列表总页数，默认应该为0
	var perSize = 10;//每页的条数，默认10
	var listData = {enabled:'',theme:'',themUrl:'',pageNum:'1',pageSize:'10'};//拉取列表的obj
	var enableBtn = {2:'启用',	1:'禁用'};
	var enableStatus = {1:'启用',2:'禁用'};
	var renderPagina = true;
		
	
	

	var initList = function() {
		bindEvt();
		getSubList();
	};

	var bindEvt = function() {
		$('.add_new_sub').on('click',onAddNewSubClk);
		$('#p_size').on('change',onPsizeChange);
		$('#zc_tbody').on('click','.fix',onFixClk);
		$('#zc_tbody').on('click','.del',onFixDelUseClk);
		$('#zc_tbody').on('click','.use',onUseClk);
		$('.search_btn').on('click',onSearchBtnClk);
		$('#first_page').on('click',1,onFirstLastPageClk);
		$('#last_page').on('click',2,onFirstLastPageClk);
		$('#confm_sure').on('click',onConfmSureClk);
		$('#confm_cancel').on('click',onConfmCancelClk);
	};

	var onAddNewSubClk = function() {
		window.location.href='pageseditor';
	};

	var onConfmCancelClk = function() {
		$('.confirm_wp').removeClass('show_out');
	};

	var onConfmSureClk= function() {
		var id= $(this).attr('data-id');
		$.ajax({
			type:'POST',
			url:subDelUrl,
			contentType:'application/json;charset=UTF-8',
			data:JSON.stringify({id:id}),
			success:function(res) {
				console.log(res);
				if(res.code==0) {
					$('.confirm_wp').removeClass('show_out');
					getSubList(listData);
				}else {
					console.log(res.code);
				}
			},
			error:function(xhr) {
				console.log('ajax error');
			}
		})
	};

	var onFirstLastPageClk = function(ev) {
		var len = $('#zc_pagination').children().size();
		if(ev.data==1) { //首页
			$('#zc_pagination').children().eq(1).trigger('click');
		}else if(ev.data==2) { //尾页
			$('#zc_pagination').children().eq(len-2).trigger('click');
		}
	};

	var onUseClk = function() {
		var id=$(this).attr('data-id');	
		var ajaxUrl = subUseUrl;
		$.ajax({
			type:'POST',
			url:ajaxUrl,
			contentType:'application/json;charset=UTF-8',
			data:JSON.stringify({id:id,enabled:0}),
			success:function(res) {
				console.log(res);
				if(res.code==0) {

					getSubList(listData);
				}else {
					console.log(res.code);
				}
			},
			error:function(xhr) {
				console.log('ajax error');
			}
		})
	};

	var onSearchBtnClk = function() { //点击搜索查询列表
		var srname = $('.srh_name').val();
		var srword = $('.srh_word').val();
		var sruse = $('#use_status').val();
		var curr_obj = $.extend(listData,{theme:srname,themUrl:srword,enabled:sruse})
		getSubList(curr_obj);
	};

	var onFixDelUseClk = function(ev) {
		var id=$(this).attr('data-id');	
		$('.confirm_wp').addClass('show_out');
		$('#confm_sure').attr('data-id',id);
	};

	var onFixClk = function() { //修改
		var id=$(this).attr('data-id');	
		console.log(id);
		window.location.href='pageseditor?id='+id+'';
		// var data = {subjectId:id};
		// var data_ajax_str = JSON.stringify(data);
		// $.ajax({
		// 	type:'POST',
		// 	url:subEditUrl,
		// 	contentType:'application/json;charset=UTF-8',
		// 	data:data_ajax_str,
		// 	success:function(res) {
		// 		console.log(res);
		// 	},
		// 	error:function(xhr) {
		// 		console.log('ajax error');
		// 	}
		// })
	};

	var onPsizeChange = function() { //切换每页条数
		var val = $(this).val();
		renderPagina=false;
		perSize=listData.pageSize = val;
		setPagina(val,totalPage,'$');
		renderPagina=false;
	};

	var getSubList = function(data) { //获取列表
		data = data || {enabled:'',theme:'',themUrl:'',pageNum:'1',pageSize:'10'};
		$.ajax({
			type:'POST',
			url:subListUrl,
			contentType:'application/json;charset=UTF-8',
			// data:JSON.stringify({enabled:3}),
			data:JSON.stringify(data),
			success:function(res) {

				var arr = [];
				var data = res.pageInfo.list;
				listData.pageNum = res.pageInfo.pageNum;
				console.log(res);

				if(res.code==0) {
					totalPage=res.pageInfo.total;
					perSize = res.pageInfo.pageSize;
					if(totalPage!=res.pageInfo.total) {
						renderPagina=true;
						totalPage=res.pageInfo.total;
					}
					if(renderPagina) {
						setPagina(perSize,totalPage);//TODO 做分页
						renderPagina = false;
					}
					$.each(data, function(i, obj) {
						arr.push(
							'<tr>',
								'<td>'+(i+1)+'</td>',
								'<td>'+obj.theme+'</td>',
								'<td class="link">'+obj.themUrl+'?id='+obj.id+'</td>',
								'<td class="related_time">'+getLocalTimeByMs(obj.createTime)+'</td>',
								'<td class="related_time">'+getLocalTimeByMs(obj.updateTime)+'</td>',
								'<td>'+enableStatus[obj.enabled]+'</td>',
								'<td>'+obj.operatingName+'</td>',
								'<td class="handle">',
									'<span class="fix handleBtn" data-id='+obj.id+'>修改</span>',
									'<span class="del handleBtn" data-id='+obj.id+'>删除</span>',
									'<span class="use handleBtn" data-id='+obj.id+'>'+enableBtn[obj.enabled]+'</span>',
								'</td>',
							'</tr>'
						)
					});
					$('#zc_tbody').html(arr.join(''));
				}else {
					console.log('code:'+res.code);
				}
			},
			error:function(xhr) {
				console.log('ajax error');
			}
		})
	};

	function setPagina(pageSize,total,prevent) {
		$("#zc_pagination").pagination(total, {
		    num_edge_entries:2,
		    num_display_entries:2,
		    callback: pageselectCallback,
		    items_per_page:pageSize,
		    prev_text:'上一页',
		    next_text:'下一页'
		});

		function pageselectCallback(a,b) {
			// console.log(a); //页数
			// console.log(b);
			listData.pageNum=prevent?1:Number(a)+1;
			getSubList(listData);
			return false;//阻止掉a链接的默认跳转，#默认事件，页面将返回顶部
		}
	}




































	initList();
})