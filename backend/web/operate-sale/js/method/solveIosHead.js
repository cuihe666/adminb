+function(window,document,$,undefined) {
	$(function() {
		var u = navigator.userAgent;
		var isIOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/);
		// var $divIosShow = $('<div/>',{id:"ios_show",class:"ios_show",css:{'height': '20px', 'border': 'none',' background-color': '#ffffff', 'position': 'fixed', 'width': '100%', 'top': '0', 'z-index': '2'} });
		var $h_top = $('.h_top');
		var h_top_height = $h_top.height();
		var $h_top_next = $h_top.next();
		var nextMt = h_top_height+20+'px';
		console.log($h_top);
		// console.log($divIosShow);
		// var headerHeight = $header.height();
		// var $headerNext = $header.next();
		// var nextTop = Number(headerHeight)+20+'px';
		// var nextCssPosition = $headerNext.css('position');
		// var $nextSecond = $headerNext.next();
		// var headerNextHeight = $headerNext.height();
		// var thirdDomTop = headerNextHeight+headerHeight+20+'px';
		// console.log(nextCssPosition);
		// console.log(headerNextHeight);
		if(isIOS) {
			// $('#ios_show').addClass('ios_show');
			$h_top.css('padding-top','20px');
			$h_top_next.css('margin-top',nextMt);
			// $('body').prepend($divIosShow);
			// if(nextCssPosition==='fixed'){
			// 	$headerNext.css('top',nextTop);
			// 	$nextSecond.css('margin-top',thirdDomTop);
			// }else {
			// 	$headerNext.css('margin-top',nextTop);
			// }
			
		}
	})
	

}(window,document,Zepto)