@extends('user.layouts.master-member')

@section('css')
@endsection

@section('js')
@endsection

@section('script')
<script type="text/javascript">
    //选择支付方式 js-z_zifu_ul
    $('.js-z_zifu_ul li').click(function(){
        $(this).addClass("active").siblings().removeClass("active");
        $('#platform').val($(this).data('platform'));
    });

    $('.j-pay').click(function () {
        switch ($('#platform').val()) {
            case 'alipay':
                $.jAjax({
                    url: '/api/third/alipay/purchase',
                    type: 'POST',
                    data: {'id':'{{ $order->trade_id }}'},
                    success: function (data) {
                        if (data.status == 'success') {
                            window.location = data.data.url;
                        }
                    }
                });
                break;
            case 'wechat':
                alert('微信支付未开通');
                break;
            case 'unionpay':
                alert('银联支付未开通');
                break;
        }

    });
</script>
@endsection

@section('uc_content')
<div class="z_w82p fr">
    <div class="z_mtb10 clearfix">
        <span class="z_font14 z_color_3 z_lineh40 z_fontb">确认订单详情</span>
    </div>
    <!--订单结算-->
    <div class="z_border z_mb10">
        <div class="z_border_b z_plr10 clearfix z_lineh40">
            <span class="z_mr10 z_color_3">{{ $order->created_at }}</span>
            <span>订单号：{{ $order->trade_id }}</span>
        </div>
        <div class="z_border_b z_p20 clearfix posr bar-GreyGreed">
            <div class="posr clearfix z_w60p ">
                <img src="{{ $order->custom->product->galleries()->value('src') }}" class="z_w80 z_h80 z_mr10 fl" />
                <div class="z_text">
                    <h2 class="z_fontn z_font14 z_color_3 z_lineh40">{{ $order->custom->product->name }}</h2>
                    <p>服务师傅：{{ $order->master->profile->realname }}</p>
                </div>
            </div>
            <span class="z_font12 z_lineh24 posa z_right-20 z_bottom-20 z_index-8 z_color_3">总额：<span class="z_color-orange">￥<span class="z_fontb z_font14">{{ $order->total }}</span></span></span>
        </div>
        <!--支付方式-->
        <div class="z_plr10 z_border_b z_pb10">
            <div class="clearfix z_lineh30 z_color_3 z_font14 z_mt10 z_mb10">
                <span>支付方式</span>
            </div>
            <div class="clearfix z_font12 z_color_3 z_lineh24">
                <input type="hidden" id="platform" value="alipay">
                <ul class="clearfix z_zifu_ul js-z_zifu_ul">
                    <li class="active" data-platform="alipay">
                        支付宝支付
                        <!--选中标识-->
                        <span class="z_biaoshi2"></span>
                        <!--选中标识 end-->
                    </li>
                    <li data-platform="wechat">
                        微信支付
                        <!--选中标识-->
                        <span class="z_biaoshi2"></span>
                        <!--选中标识 end-->
                    </li>
                    <li data-platform="unionpay">
                        银联支付
                        <!--选中标识-->
                        <span class="z_biaoshi2"></span>
                        <!--选中标识 end-->
                    </li>
                </ul>
            </div>
        </div>
        <!--支付方式 end-->
        <!--结算 -->
        <div class="bar-Grey-f4">
            <div class="clearfix z_p10  z_font12 z_color_6 z_lineh24 z_border_b">
                <ul class="clearfix fr" style="display: inline-block;">
                    <li>商品总额：<span class="z_ml40">￥<span>{{ $order->total }}</span></span></li>
                    <li>已付定金：<span class="z_ml40">￥<span>{{ $pay_part1 }}</span></span></li>
                    <li>剩余尾款：<span class="z_ml40">￥<span>{{ $pay_part2 }}</span></span></li>
                </ul>
            </div>
            <div class="z_plr10 z_font12 z_lineh40 z_color_6 tr">
                应付总额：<span class="z_color-orange">￥<span class="z_fontb z_font14">{{ $pay_part2 }}</span></span>
            </div>
        </div>
        <!--结算 end-->
    </div>

    @if($order->custom->make)
        @if($order->custom->make->pictures)
            <!--图片-->
            <div class="clearfix z_mb10 z_mt20">
                <ul class="clearfix z_ul_img">
                    @foreach(explode(';', $order->custom->make->pictures) as $picture)
                        <li class="z_h120">
                            <div class="z_img_back ">
                                <img src="{{ $picture }}"/>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            <!--图片 end-->
        @endif
    @endif

    <div class="z_p10 tr z_mb40">
        <a href="javascript:void(0);" class="z_btn bar-auburn z_font14 z_w110 z_ptb7 j-pay">确认订单</a>
    </div>
    <!--订单结算 end-->
</div>
@endsection

@section('uc_bottom')
@endsection