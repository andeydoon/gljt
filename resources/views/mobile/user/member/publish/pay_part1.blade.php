@extends('mobile.layouts.master')

@section('css')
@endsection

@section('js')
@endsection

@section('script')
<script type="text/javascript">
    $('.js_checkbox').click(function () {
        $(this).addClass("login_checkbox_active").parents('li').siblings("li")
            .children(".js_checkbox").removeClass("login_checkbox_active")
    })
</script>
@endsection

@section('body')
<body class="bg_fff p_b_100">
<header class="header bg_fff clearfix posr p_t_30 p_b_30 b_b_e5 p_l_24 p_r_24">
    <a class="return fl" href="##"></a>
    <div class="text fl fs_36 t_a_c c_1b1 top_title x_center">支付定金</div>
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
    <li>定金比例：30%</li>
    <li>需付定金：{{ $pay_part1 }}元</li>
</ul>
<div class="null20"></div>
<div class="fixed_bottom">
    <div class="clearfix you_gopay fs_32">
        <span class="fl p_l_24 c_333 bg_fff ">合计：¥{{ $pay_part1 }}</span>
        <a class="fr fs_36 bg_942 c_fff t_a_c" href="##">去付款</a>
    </div>
</div>
</body>
@endsection