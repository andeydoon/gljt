$(function () {

    //弹出下拉框
    $('body').on('click', '.js-z_select_div p', function () {
        $(this).next().fadeIn("fast");
    })

    //给input设置值
    $('body').on('click', '.js-z_select_ul li', function () {
        var txt = $(this).text();
        var dataId = $(this).attr('data-id');
        $(this).addClass("active").siblings().removeClass("active");
        $(this).parent().prev("p").html(txt);
        $(this).parent().prev("p").css("color", "#666");
        $(this).parent().parent().prev("input").val(dataId);
        $(this).parent().hide();
    })

    $(".js-z_tubiao").click(function () {
        $(this).prev().fadeIn("fast");
    });

    //删除
    $(".js-z_off").click(function () {
        $(this).parent().remove();
        return false;
    });
    //删除4
    $(".js-z_off_p4").click(function () {
        $(this).parent().parent().parent().parent().remove();
        return false;
    });
    //删除3
    $(".js-z_off_p3").click(function () {
        $(this).parent().parent().parent().remove();
        return false;
    });
    //删除2
    $(".js-z_off_p2").click(function () {
        $(this).parent().parent().remove();
        return false;
    });
    //关闭
    $(".js-z_off2").click(function () {
        $(this).parent().addClass("hide");
        //阴影
        $(".shadow").hide();
    });
    //关闭二级父层2
    $(".js-z_off2_p2").click(function () {
        $(this).parent().parent().addClass("hide");
        //阴影
        $(".shadow").hide();
    });

    $('.js-reduce').click(function () {
        var $quantity = $(this).parent().children('.js-quantity');
        $quantity.val(Math.max(parseInt($quantity.val(), 10) - 1, 1));
    });

    $('.js-plus').click(function () {
        var $quantity = $(this).parent().children('.js-quantity');
        $quantity.val(parseInt($quantity.val(), 10) + 1);
    });
});

//左右剧中定位
function juzhong(b) {
    var w2 = $("body").width();
    var w = $(b).width();
    var w3 = (w2 - w) / 2;
    $(b).css("left", w3);
};

//上下左右剧中定位
function juzhong2(b) {
    var w2 = $("body").width();
    var h2 = $(window).height();
    var w = $(b).width();
    var h = $(b).height();
    var w3 = (w2 - w) / 2;
    var h3 = (h2 - h) / 2;
    $(b).css({"left": w3 + "px", "top": h3 + "px"});

};
