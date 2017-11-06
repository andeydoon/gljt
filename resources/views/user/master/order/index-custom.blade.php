@extends('user.layouts.master-master')

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
            <li class="active">
                定制
                <a href="/user/order?custom" title="定制" class="z_lianjie"></a>
            </li>
            <li>
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
    <!--我的订单-->
    <div class="z_mb10">
        <!--定制-->
        <?php $statuses = ['等待接单', '等待测量', '待付定金', '等待制作', '待付尾款', '等待发货', '等待收货', '等待安装', '订单完成', 101=>'订单取消'] ?>
        <div class="z_box4" style="display: block;">
            @foreach(auth()->user()->master_orders()->where('type', 1)->orderBy('created_at', 'DESC')->get() as $order)
                <div class="bar-LightGrey z_border z_mb10">
                    <div class="z_border_b z_plr10 clearfix z_lineh40">
                        <span class="z_mr10 z_color_3">{{ $order->created_at }}</span>
                        <span>订单号：{{ $order->trade_id }}</span>
                        <span class="fr z_color_9">{{ $statuses[$order->status] }}</span>
                    </div>
                    <div class="z_border_b z_p20 clearfix posr">
                        <div class="posr clearfix z_w60p">
                            <img src="{{ $order->custom->product->galleries()->value('src') }}" class="z_w80 z_h80 z_mr10 fl" />
                            <div class="z_text">
                                <h2 class="z_fontn z_font14 z_color_3 z_lineh40">
                                    <h2 class="z_fontn z_font14 z_color_3 z_lineh40">{{ $order->custom->product->name }}</h2>
                                </h2>
                                @if($order->status <= 100)
                                    姓名：{{ $order->address->name }} 电话：{{ $order->address->phone }}<br>
                                    地址：{{ $order->address->province->name }} {{ $order->address->city->name }} {{ $order->address->district->name }} {{ $order->address->street }}
                                @endif
                            </div>
                        </div>
                        @if($order->status >= 2 && $order->status <= 100)
                            <a href="/user/order/custom_scheme/{{ $order->trade_id }}" title="查看方案" class="z_btn bar-white z_font12 z_w74 z_ptb3-i posa z_right-20 z_bottom-20 z_index-8 z_border_rn z_color_3 z_border" target="_blank">查看方案</a>
                        @endif
                    </div>
                    @if($order->status <= 100)
                        <div class="tc z_plr10 z_ptb20 z_border_b">
                            <img src="/images/icon/tb58-{{ $order->status+1 }}.png" width="670" height="33" />
                        </div>
                        <div class="z_p10 tr">
                            @if($order->status == 1)<a href="/user/order/custom_scheme_create/{{ $order->trade_id }}" class="z_btn bar-auburn z_font12 z_w68 z_ptb3-i z_ml10">编辑方案</a>@endif
                            @if($order->status >= 1)<a href="javascript:void(0);" class="z_btn bar-auburn z_font12 z_w68 z_ptb3-i z_ml10" onclick="$.jAlert('联系电话：{{ $order->member->mobile }}')">联系客户</a>@endif
                            {{--@if($order->status == 8)<a href="javascript:void(0);" class="z_btn bar-auburn z_font12 z_w68 z_ptb3-i z_ml10">查看评论</a>@endif--}}
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
        <!--定制 end-->
    </div>
    <!--我的订单 end-->
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