@extends('mobile.layouts.master')

@section('js')
@endsection

@section('script')
@endsection

@section('body')
<body class="bg_f2f p_b_100">
<header class="gerenz">
    <div class="Headportrait t_a_c">
        <img src="/packages/mobile/images/img/me.png">
    </div>
    <a class="shownames c_fff fs_36 m_t_20" href="##">{{ auth()->user()->mobile }}</a>
    <p class="c_fff fs_30 m_t_20 t_a_c">会员号：{{ auth()->user()->public_id }}</p>
</header>
<div class="clearfix gerennav c_333 posr pbt24 w702">
    <a class="a1 fl" href="/mobile/user/credit">
        <img src="/packages/mobile/images/icon/ic44.png">
        <p class="fs_30 m_t_15">我的积分</p>
    </a>
    <a class="a2 fl" href="/mobile/user/favorite">
        <img src="/packages/mobile/images/icon/ic21.png">
        <p class="fs_30 m_t_15">我的收藏</p>
    </a>
    <a class="a3 fl posr" href="/mobile/message">
        <p class="posr">
            <img src="/packages/mobile/images/icon/ic48.png">
            <span class="{{ auth()->user()->unreadNotifications()->count() ? 'small_Dot ' : '' }}posa"></span>
        </p>
        <p class="fs_30 m_t_15">消息中心</p>
    </a>

</div>
<div class="gerenoption bg_fff">
    <ul>
        <li class=" clearfix posr">
            <span class="fl gl_icon bgclass1 posa"> </span>
            <a class="fr gego p_r_24 fs_30 c_333 b_b_e5" href="/mobile/user/coupon">优惠劵</a>
        </li>
        <li class=" clearfix posr">
            <span class="fl gl_icon bgclass2 posa"> </span>
            <a class="fr gego p_r_24 fs_30 c_333 b_b_e5" href="/mobile/user/coin">余额</a>
        </li>
        <li class=" clearfix posr">
            <span class="fl gl_icon bgclass3 posa"> </span>
            <a class="fr gego p_r_24 fs_30 c_333 b_b_e5" href="/mobile/user/address">收货地址</a>
        </li>
        <li class=" clearfix posr">
            <span class="fl gl_icon bgclass4 posa"> </span>
            <a class="fr gego p_r_24 fs_30 c_333 " href="/mobile/user/about">关于我们</a>
        </li>
        <li class="null20"></li>
        <li class=" clearfix posr">
            <span class="fl gl_icon bgclass5 posa"> </span>
            <a class="fr gego p_r_24 fs_30 c_333 " href="/mobile/user/setting">设置</a>
        </li>

    </ul>
</div>

<div class="null20"></div>
<div class="fixed_bottom">
    <?php $paths = [1 => 'publish', 2 => 'order', 3 => 'order']; ?>
    <footer class="fonterbar clearfix">
        <a class="fl P_t_10 wtab-item{{ request()->is('mobile') ? ' tab_ative' : '' }}" href="/mobile">
            <span class="show bgicon"></span>
            <p class=" m_t_5">首页</p>
        </a>
        <a class="fl P_t_10 wtab-item{{ request()->is('mobile/user/'.$paths[auth()->user()->type].'*') ? ' tab_ative' : '' }}" href="{{ '/mobile/user/'.$paths[auth()->user()->type] }}">
            <span class="show bgicon"></span>
            <p class=" m_t_5">订单中心</p>
        </a>
        <a class="fl P_t_10 wtab-item{{ !request()->is('mobile/user/'.$paths[auth()->user()->type].'*')&&request()->is('mobile/user*') ? ' tab_ative' : '' }}" href="/mobile/user">
            <span class="show  bgicon"></span>
            <p class=" m_t_5">个人中心</p>
        </a>
    </footer>
</div>
</body>
@endsection