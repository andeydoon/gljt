@extends('user.layouts.master-member')

@section('script')
<script type="text/javascript">
    //取消服务 提示 js-quxiao
    juzhong2(".js-quxiao");
    //弹出取消服务 提示 js-quxiao_btn
    $(".js-quxiao_btn").click(function(){
        $(".js-quxiao").data('id', $(this).data('id')).removeClass("hide");
        //阴影
        $(".shadow").show();
    });
    //收货提示 js-shouhuo
    juzhong2(".js-shouhuo");
    //弹出收货提示 js-shouhuo_btn
    $(".js-shouhuo_btn").click(function(){
        $(".js-shouhuo").data('id', $(this).data('id')).removeClass("hide");
        //阴影
        $(".shadow").show();
    });

    $('.j-cancel').click(function () {
        var id = $('.js-quxiao').data('id');
        $.jAjax({
            url: '/api/user/publish/cancel',
            type: 'POST',
            data: {id: id},
            success: function (data) {
                if (data.status == 'success') {
                    alert('取消成功');
                    window.location.reload();
                }
            }
        })
    });

    $('.j-take').click(function () {
        var id = $('.js-shouhuo').data('id');
        $.jAjax({
            url: '/api/user/publish/take',
            type: 'POST',
            data: {id: id},
            success: function (data) {
                if (data.status == 'success') {
                    alert('收货确认成功');
                    window.location.reload();
                }
            }
        })
    });
</script>
@endsection

@section('uc_content')
<div class="z_w82p fr z_minh640">
    @include('user.layouts.card-user')
    <div class="z_border_b z_mt10 z_mb10 z_border_l clearfix">
        <ul class="clearfix z_nav11 z_w40p fl js-z_nav11">
            <li class="active">
                定制
                <a href="/user/publish?custom" title="定制" class="z_lianjie"></a>
            </li>
            <li>
                服务
                <a href="/user/publish?service" title="服务" class="z_lianjie"></a>
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
    <!--我的发布 -->
    <!--定制-->
    <?php $statuses = ['等待接单', '等待测量', '待付定金', '等待制作', '待付尾款', '等待发货', '等待收货', '等待安装', '订单完成', 101=>'订单取消'] ?>
    <div class="z_box4" style="display: block;">
        @foreach(auth()->user()->member_orders()->where('type', 1)->orderBy('created_at', 'DESC')->get() as $order)
            <div class="bar-LightGrey z_border z_mb10 j-order-{{ $order->trade_id }}">
                <div class="z_border_b z_plr10 clearfix z_lineh40">
                    <span class="z_mr10 z_color_3">{{ $order->created_at }}</span>
                    <span>订单号：{{ $order->trade_id }}</span>
                    <span class="fr z_color_9">{{ $statuses[$order->status] }}</span>
                </div>
                <div class="z_border_b z_p20 clearfix posr">
                    <div class="posr clearfix z_w60p">
                        <img src="{{ $order->custom->product->galleries()->value('src') }}" class="z_w80 z_h80 z_mr10 fl" />
                        <div class="z_text">
                            <h2 class="z_fontn z_font14 z_color_3 z_lineh40">{{ $order->custom->product->name }}</h2>
                        </div>
                        @if($order->status <= 100)
                            @if($order->status==0)
                                <p>服务师傅：等待接单</p>
                            @else
                                <p>服务师傅：{{ $order->master->profile->realname }}</p>
                            @endif
                        @endif
                    </div>
                    @if($order->status >= 2 && $order->status <= 100)
                        <a href="/user/publish/custom_scheme/{{ $order->trade_id }}" title="查看方案" class="z_btn bar-white z_font12 z_w74 z_ptb3-i posa z_right-20 z_bottom-20 z_index-8 z_border_rn z_color_3 z_border" target="_blank">查看方案</a>
                    @endif
                </div>
                @if($order->status <= 100)
                    <div class="tc z_plr10 z_ptb20 z_border_b">
                        <img src="/images/icon/tb58-{{ $order->status+1 }}.png" width="670" height="33" />
                    </div>
                    <div class="z_p10 tr">
                        @if($order->status == 2)<a href="/user/publish/pay_part1/{{ $order->trade_id }}" class="z_btn bar-auburn z_font12 z_w68 z_ptb3-i z_ml10">付定金</a>@endif
                        @if($order->status == 4)<a href="/user/publish/pay_part2/{{ $order->trade_id }}" class="z_btn bar-auburn z_font12 z_w68 z_ptb3-i z_ml10">付款</a>@endif
                        @if($order->status >= 1)<a href="javascript:void(0);" class="z_btn bar-auburn z_font12 z_w68 z_ptb3-i z_ml10" onclick="$.jAlert('联系电话：{{ $order->master->mobile }}')">联系师傅</a>@endif
                        @if($order->status <= 2)<a href="javascript:void(0);" class="z_btn bar-Grey-9 z_font12 z_w68 z_ptb3-i z_ml10 js-quxiao_btn" data-id="{{ $order->trade_id }}">取消</a>@endif
                        @if($order->status == 6)<a href="javascript:void(0);" class="z_btn bar-auburn z_font12 z_w68 z_ptb3-i z_ml10 js-shouhuo_btn" data-id="{{ $order->trade_id }}">确认收货</a>@endif
                        @if($order->status == 6)<a href="javascript:void(0);" class="z_btn bar-auburn z_font12 z_w68 z_ptb3-i z_ml10">查看物流</a>@endif
                        @if($order->status == 7)<a href="/user/publish/comment/{{ $order->trade_id }}" class="z_btn bar-auburn z_font12 z_w68 z_ptb3-i z_ml10">确认安装</a>@endif
                        {{--@if($order->status == 8)<a href="javascript:void(0);" class="z_btn bar-auburn z_font12 z_w68 z_ptb3-i z_ml10">申请售后</a>@endif--}}
                        {{--@if($order->status == 8)<a href="javascript:void(0);" class="z_btn bar-auburn z_font12 z_w68 z_ptb3-i z_ml10">申请发票</a>@endif--}}
                    </div>
                @endif
            </div>
        @endforeach
    </div>
    <!--定制 end-->
    <!--我的发布 end -->
</div>
@endsection

@section('uc_bottom')
<!--阴影和弹出框-->
<div class="shadow" style=""></div>
<!--取消服务-->
<div class="z_popup z_w340 bar-white z_pb20 posf animation bounceIn hide js-quxiao">
    <span class="z_off js-z_off2"></span>
    <div class="tc z_font16 z_color_3 z_lineh24 z_mt30 z_mb40 z_plr22">
        你确定要取消本次服务吗
    </div>
    <div class="z_mt20 tc">
        <input type="button" value="确定 "  class="z_btn bar-auburn z_font14 z_w120 z_ptb7 z_mr20 j-cancel"/>
        <input type="button" value="取消"   class="z_btn bar-Grey-ca z_font14 z_w120 z_ptb7 " onclick="$('.js-z_off2').trigger('click');"/>
    </div>
</div>
<!--取消服务 end-->
<!--确认收货-->
<div class="z_popup z_w340 bar-white z_pb20 posf animation bounceIn hide js-shouhuo">
    <span class="z_off js-z_off2"></span>
    <div class="z_font16 z_color_3 z_lineh24 z_mt30 z_mb40 z_plr22">
        建议您前往微信端扫描二维码进行确认收货，如您在此确认将无法验证货品，您确定要进行收货操作吗？
    </div>
    <div class="z_mt20 tc">
        <input type="button" value="确定 "  class="z_btn bar-auburn z_font14 z_w120 z_ptb7 z_mr20 j-take"/>
        <input type="button" value="取消 "   class="z_btn bar-Grey-ca z_font14 z_w120 z_ptb7 " onclick="$('.js-z_off2').trigger('click');"/>
    </div>
</div>
@endsection