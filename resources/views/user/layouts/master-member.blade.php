@extends('layouts.master')

@section('content')
<div class="z_center119">
    <div class="z_w82p z_mlrauto clearfix">
        <div class="z_w168p fl bar-GreyGreed z_minh640">
            <ul class="z_menu_a">
                <li{!! request()->is('user') ? ' class="active"' : '' !!}>
                    个人中心
                    <a href="/user" title="个人中心" class="z_lianjie"></a>
                </li>
                <li{!! request()->is('user/publish*') ? ' class="active"' : '' !!}>
                    我的发布
                    <a href="/user/publish" title="我的发布" class="z_lianjie"></a>
                </li>
                <li{!! request()->is('user/favorite') ? ' class="active"' : '' !!}>
                    我的收藏
                    <a href="/user/favorite" title="我的收藏" class="z_lianjie"></a>
                </li>
                <li{!! request()->is('user/credit') ? ' class="active"' : '' !!}>
                    我的积分
                    <a href="/user/credit" title="我的积分" class="z_lianjie"></a>
                </li>
                <li{!! request()->is('user/coupon') ? ' class="active"' : '' !!}>
                    优惠券
                    <a href="/user/coupon" title="优惠券" class="z_lianjie"></a>
                </li>
                <li{!! request()->is('user/coin') ? ' class="active"' : '' !!}>
                    余额
                    <a href="/user/coin" title="余额" class="z_lianjie"></a>
                </li>
                <li{!! request()->is('user/address*') ? ' class="active"' : '' !!}>
                    收货地址
                    <a href="/user/address" title="收货地址" class="z_lianjie"></a>
                </li>
                <li{!! request()->is('user/password') ? ' class="active"' : '' !!}>
                    修改密码
                    <a href="/user/password" title="修改密码" class="z_lianjie"></a>
                </li>
                <li{!! request()->is('user/feedback') ? ' class="active"' : '' !!}>
                    意见反馈
                    <a href="/user/feedback" title="意见反馈" class="z_lianjie"></a>
                </li>
                <li{!! request()->is('user/about') ? ' class="active"' : '' !!}>
                    关于我们
                    <a href="/user/about" title="关于我们" class="z_lianjie"></a>
                </li>
            </ul>
        </div>
        @yield('uc_content')
    </div>
</div>
@yield('uc_bottom')
@endsection