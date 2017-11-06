@extends('mobile.layouts.master')

@section('css')
<link rel="stylesheet" type="text/css" href="/packages/mobile/css/mui.min.css">
<link rel="stylesheet" type="text/css" href="/packages/mobile/css/Viewbigpicture.css">
@endsection

@section('style')
<style type="text/css">
    input[type="number"], input[type='text'] {
        line-height: 1;
        height: auto;
        margin-bottom: 0px;
        padding: 0px;
        -webkit-user-select: none;
        border: none;
        border-radius: 0px;
        outline: 0;
        background-color: #fff;
        -webkit-appearance: none;
    }

    p {
        margin-bottom: 0px;
    }

    .mui-content {
        background-color: white;
    }

    .mui-content-padded {
        margin: 0px;
    }
</style>
@endsection

@section('js')
<script type="text/javascript" src="/packages/mobile/js/mui.min.js"></script>
<script type="text/javascript" src="/packages/mobile/js/mui.zoom.js"></script>
<script type="text/javascript" src="/packages/mobile/js/mui.previewimage.js"></script>
@endsection

@section('script')
<script type="text/javascript">
    $('.js_checkbox').click(function () {
        $(this).addClass("login_checkbox_active").parents('li').siblings("li")
            .children(".js_checkbox").removeClass("login_checkbox_active")
    });

    mui.previewImage();
</script>
@endsection

@section('body')
<body class="bg_fff p_b_100">
<header class="header bg_fff clearfix posr p_t_30 p_b_30 b_b_e5 p_l_24 p_r_24">
    <a class="return fl" href="##"></a>
    <div class="text fl fs_36 t_a_c c_1b1 top_title x_center">支付尾款</div>
    <a class="confirm fr" href="##"></a>
</header>

<div class="server_dizhi c_000">
    <a class="select_dizi prl24" href="##">
        <div class="selecwp Singleellipsis">
            <p class="m_t_20"><i class="isname">{{ $order->address->name }}</i>{{ $order->address->phone }}</p>
            <p class="m_t_20 Singleellipsis">{{ $order->address->province->name }} {{ $order->address->city->name }} {{ $order->address->district->name }} {{ $order->address->street }}</p>
        </div>
    </a>
</div>
<div class="null20"></div>
<!-- 选择支付方式 -->
<ul>
    <li class="fs_30 c_666 prl24 b_b_e5 pbt_20">选择支付方式</li>
    <li class="fs_30 c_666 prl24 b_b_e5 pbt_20 clearfix">
        <div class="fl">
            <span class="paylogo"><img src="/packages/mobile/images/img/im20.png"></span>
            <span class="c_1a1a heiline45 m_l_35">微信支付</span>
        </div>
        <span class="fr js_checkbox login_checkbox"></span>
    </li>
    <li class="fs_30 c_666 prl24 b_b_e5 pbt_20 clearfix">
        <div class="fl">
            <span class="blanklogo"><img src="/packages/mobile/images/img/im21.png"></span>
            <span class="c_1a1a heiline45 m_l_20">银联支付</span>
        </div>
        <span class="fr js_checkbox login_checkbox"></span>
    </li>
</ul>

<div class="null20"></div>
<div class="pName prl24 pbt24 clearfix b_b_e5">
    <div class="pimgbox fl">
        <img src="/packages/mobile/images/img/pimg.png">
    </div>
    <div class="ptext fl m_l_15">
        <p class="limitw fs_32 c_000  Singleellipsis">{{ $order->custom->product->name }}</p>
        <p class="fs_30 c_333 p_t_30 clearfix">
            <span class="fl fs_36 c_ff2">{{ $order->custom->product->price }}元</span>
            <span class="fr fs_32 c_808">x{{ $order->quantity }}</span>
        </p>
    </div>
</div>

<ul class="Totalamount fs_30 c_333 prl24 p_b_20 ">
    <li>商品总额：{{ $order->total }}元</li>
    <li>已付定金：{{ $pay_part1 }}元</li>
    <li>需付尾款：{{ $pay_part2 }}元</li>
</ul>
<div class="null20"></div>
@if($order->custom->make)
    @if($order->custom->make->pictures)
        <!-- 预览图片 -->
        <div class="">
            <div class="mui-content">
                <div class="mui-content-padded">
                    <div class="viewimg clearfix p_t_24">
                        @foreach(explode(';', $order->custom->make->pictures) as $picture)
                            <img src="{{ $picture }}" data-preview-src="" data-preview-group="1">
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="null20"></div>
    @endif
@endif
<div class="fixed_bottom">
    <div class="clearfix you_gopay fs_32">
        <span class="fl p_l_24 c_333 bg_fff ">合计：¥{{ $pay_part2 }}</span>
        <a class="fr fs_36 bg_942 c_fff t_a_c" href="##">去付款</a>
    </div>
</div>
</body>
@endsection