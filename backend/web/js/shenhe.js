
$(function(){
	$(".part_two label").click(function(){
		$(this).addClass("checked");
		$(".part_two .dis-sxh").addClass("current-dis");
		$(".part_two .dis-sxh2").removeClass("current-dis");
		$(".label2").removeClass("checked");
		$('.ok').attr('checked', 'checked');
		$('.no').removeAttr('checked', 'checked');


	})

	$(".part_two .label2").click(function(){
		$(this).addClass("checked");
		$(".part_two .dis-sxh2").addClass("current-dis");
		$(".part_two .dis-sxh").removeClass("current-dis");
		$(".label").removeClass("checked");
		$('.no').attr('checked', 'checked');
		$('.ok').removeAttr('checked', 'checked');
	})
	//$('label').click(function() {
	//	var radioId = $(this).attr('name');
	//	$(this).addClass("checked").siblings().removeClass("checked");
	//	$('input[type="radio"]').removeAttr('checked') && $('#' + radioId).attr('checked', 'checked');
	//});



})
