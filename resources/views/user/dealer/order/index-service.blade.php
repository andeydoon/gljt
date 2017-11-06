@extends('user.layouts.master-dealer')

@section('script')
<script type="text/javascript">
    //取消服务 提示 js-quxiao
    juzhong2(".js-quxiao");
    //弹出取消服务 提示 js-quxiao_btn
    $(".js-quxiao_btn").click(function(){
        $(".js-quxiao").removeClass("hide");
        //阴影
        $(".shadow").show();
    });
    //确认服务提示 js-tishi
    juzhong2(".js-tishi");
    //弹出确认服务 提示 js-tishi_btn
    $(".js-tishi_btn").click(function(){
        $(".js-tishi").removeClass("hide");
        //阴影
        $(".shadow").show();
    });
    //点阴影关闭 js-shadow_off
    $(".js-shadow_off").click(function(){
        $(".js-tishi").addClass("hide");//确认安装
        //阴影
        $(this).hide();
    });
</script>
@endsection

@section('uc_content')
<div class="z_w82p fr z_minh640">
    @include('user.layouts.card-user')
    <div class="z_border_b z_mt10 z_mb10  clearfix">
        <ul class="clearfix z_nav11 z_w40p fl js-z_nav11">
            <li>
                定制
                <a href="/user/order?custom" title="定制" class="z_lianjie"></a>
            </li>
            <li class="active">
                服务
                <a href="/user/order?service" title="服务" class="z_lianjie"></a>
            </li>
        </ul>
        <div class="z_form z_border z_w340  posr fr z_mb4">
            <div class="z_inputbox clearfix posr">
                <input type="text"  placeholder="输入订单号或商品进行搜索" class="z_input z_w240 z_ptb5 fl"/>
                <button class="z_w90 tc bar-Grey-f8 z_btn z_font12 z_color_6 z_border_l-i z_cursor z_ptb5 z_border_rn fr">
                    订单搜索
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('uc_bottom')
<!--阴影和弹出框-->
<div class="shadow js-shadow_off" style=""></div>
<!--确认服务 提示-->
<div class="z_popup z_w340 bar-white z_pb20 posf animation bounceIn hide js-tishi">
    <div class="tc z_font16 z_color_3 z_lineh24 z_mt30 z_mb40 z_plr22">
        已请求客户确认服务结束
    </div>
    <div class="z_mt20 tc">
        <input type="button" value="确定 "  class="z_btn bar-auburn z_font14 z_w120 z_ptb7 z_mr20"/>
    </div>
</div>
<!--确认服务 提示 end-->
@endsection