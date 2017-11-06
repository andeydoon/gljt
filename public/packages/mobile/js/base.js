$(function($){
		$(window).on('resize',function(event) {
		var screen={max:750,min:320,px:100};
		var w=$(this).width();
			if (w<screen.min) {
				w=screen.min;
			}else if (w>screen.max) {
				w=screen.max;
			}

		$("html").css("font-size",screen.px*w/screen.max+"px");
		}).trigger('resize');
	})
