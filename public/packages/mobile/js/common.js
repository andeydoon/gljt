$(function($){
	/*登录 密码框*/
	var flag=true;
	$('.js_eye').click(function(){
		if(flag){
			$(this).addClass('tooglebg');
			document.getElementById('inpp').type='text';
			flag=false;
		}else{
			$(this).removeClass('tooglebg');
			document.getElementById('inpp').type='password';
			flag=true;
		}
	})

    $('.j-reduce').click(function () {
        var $quantity = $(this).parent().children('.j-quantity');
        $quantity.val(Math.max(parseInt($quantity.val(), 10) - 1, 1));
    });

    $('.j-plus').click(function () {
        var $quantity = $(this).parent().children('.j-quantity');
        $quantity.val(parseInt($quantity.val(), 10) + 1);
    });
})