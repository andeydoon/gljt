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
                <li{!! request()->is('user/product*') ? ' class="active"' : '' !!}>
                    我的产品
                    <a href="/user/product" title="我的产品" class="z_lianjie"></a>
                </li>
                {{--<li{!! request()->is('user/project') ? ' class="active"' : '' !!}>--}}
                    {{--我的案例--}}
                    {{--<a href="/user/project" title="我的案例" class="z_lianjie"></a>--}}
                {{--</li>--}}
                <li{!! request()->is('user/order*') ? ' class="active"' : '' !!}>
                    我的订单
                    <a href="/user/order" title="我的订单" class="z_lianjie"></a>
                </li>
                <li{!! request()->is('user/apply') ? ' class="active"' : '' !!}>
                    师傅申请
                    <a href="/user/apply" title="师傅申请" class="z_lianjie"></a>
                </li>
                <li{!! request()->is('user/bond') ? ' class="active"' : '' !!}>
                    保证金
                    <a href="/user/bond" title="保证金" class="z_lianjie"></a>
                </li>
                <li{!! request()->is('user/coin') ? ' class="active"' : '' !!}>
                    余额
                    <a href="/user/coin" title="余额" class="z_lianjie"></a>
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