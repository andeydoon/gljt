@extends('user.layouts.master-dealer')

@section('css')
@endsection

@section('js')
@endsection

@section('script')
@endsection

@section('uc_content')
<div class="z_w82p fr">
    <div class="z_mtb10 clearfix">
        <span class="z_font14 z_color_3 z_lineh40 z_fontb">查看方案</span>
    </div>
    <!--方案-->
    <div class="z_border z_mb10">
        <div class="z_border_b z_plr10 clearfix z_lineh40">
            <span>订单号：{{ $order->trade_id }}</span>
        </div>
        <div class="z_border_b z_p20 clearfix posr bar-GreyGreed">
            <div class="posr clearfix z_w60p ">
                <img src="/images/other/tp1.png" class="z_w80 z_h80 z_mr10 fl"/>
                <div class="z_text">
                    <h2 class="z_fontn z_font14 z_color_3 z_lineh40">{{ $order->service->service->name }}</h2>
                    <p>服务师傅：{{ $order->master->profile->realname }}</p>
                </div>
            </div>
        </div>
        <div class="z_plr10 z_border_b z_pb20">
            <div class="clearfix z_lineh30 z_color_3 z_font14 z_mt10">
                <span>方案</span>
            </div>
            <div class="clearfix z_font12 z_color_3 z_lineh24">
                {{ $order->service_scheme->content }}
            </div>
        </div>
        <div class="z_plr10 z_border_b z_pb20">
            <div class="clearfix z_lineh30 z_color_3 z_font14 z_mt10">
                <span>人工费用</span>
            </div>
            <div class="clearfix z_font12 z_color_3 z_lineh24">
                {{ $order->service_scheme->cost_labor }}元
            </div>
        </div>
        <!--材料-->
        <div class="z_plr10 z_border_b z_pb20">
            <div class="clearfix z_lineh30 z_color_3 z_font14 z_mt10">
                <span>材料</span>
            </div>
            <div class="clearfix z_font12 z_color_3 z_lineh24">
                @foreach(unserialize($order->service_scheme->parts) as $part)
                    <ul class="clearfix">
                        <li class="z_w30p fl">名称：{{ $part['name'] }}</li>
                        <li class="z_w30p fl">单价：{{ $part['price'] }}</li>
                        <li class="z_w30p fl">数量：{{ $part['quantity'] }}</li>
                    </ul>
                @endforeach
            </div>
        </div>
        <!--材料 end-->
        <!--价格-->
        <div class="z_plr10 z_pb20">
            <div class="clearfix z_lineh30 z_color_3 z_font14 z_mt10">
                <span>价格</span>
            </div>
            <div class="clearfix z_font12 z_color_3 z_lineh24">
                <ul class="clearfix">
                    <li>总价：<span class="z_font14 z_color-orange z_fontb">{{ $order->total }}元</span></li>
                </ul>
            </div>
        </div>
        <!--价格 end-->
    </div>
    @if($order->service_scheme->pictures)
    <!--图片-->
    <div class="clearfix z_mb10 z_mt20">
        <ul class="clearfix z_ul_img">
            @foreach(explode(';', $order->service_scheme->pictures) as $picture)
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
    <!--方案 end-->
</div>
@endsection

@section('uc_bottom')
@endsection