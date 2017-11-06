@extends('mobile.layouts.master')

@section('style')
<style type="text/css">
    .mui-content {
        background-color: white;
    }

    .mui-content-padded {
        margin: 0px;
    }
</style>
@endsection

@section('script')
<script type="text/javascript">
    $('.j-contact-member').click(function () {
        $('.js_contact .j-mobile').text($(this).data('master-mobile'));
        $('.js_contact .j-name').text($(this).data('master-realname'));
        $('.js_contact .j-call').attr('href', 'tel:' + $(this).data('master-mobile'));
        $('.js_contact').show();
    });
</script>
@endsection

@section('body')
<body class="bg_fff p_b_100">
<div class="f_topnav p_t_15 p_b_15 b_b_e5">
    <nav class="f_nv c_9425 clearfix fs_26">
        <a class="server_active" href="javascript:void(0);">定制</a>
        <a href="/mobile/user/order?service">服务</a>
    </nav>
</div>
<!-- navtop -->
<div class="f_state b_b_e5 clearfix">
    <a class="item fs_30 c_808 show itemes_active" href="##">全部</a>
    <a class="item fs_30 c_808 show" href="##">待付定金</a>
    <a class="item fs_30 c_808 show" href="##">待施工</a>
    <a class="item fs_30 c_808 show" href="##">待评价</a>
</div>
<div class="null24"></div>

<?php $statuses = ['等待接单', '等待测量', '待付定金', '等待制作', '待付尾款', '等待发货', '等待收货', '等待安装', '订单完成', 101=>'订单取消'] ?>
@foreach(auth()->user()->master_orders()->where('type', 1)->orderBy('created_at', 'DESC')->get() as $order)
    <div class="f_Ordercontent">
        <div class="f_number prl24 c_666 fs_26 b_b_e5 pbt_20">
            {{ $order->trade_id }}
        </div>
        <div class="pName prl24 pbt24 clearfix b_b_e5">
            <div class="pimgbox fl">
                <img src="/packages/mobile/images/img/pimg.png">
            </div>
            <div class="ptext fl m_l_15 posr">
                <p class="limitw fs_32 c_000  Singleellipsis">{{ $order->custom->product->name }}</p>
                @if($order->status <= 100)
                    @if($order->status==0)
                        <p class="fs_30 c_333 p_t_30">服务师傅：待接单</p>
                    @else
                        <p class="fs_30 c_333 p_t_30">服务师傅：{{ $order->master->profile->realname }}</p>
                    @endif
                @endif
                @if($order->status >= 2 && $order->status <= 100)
                    <a class="posa programme" href="/mobile/user/order/custom_scheme/{{ $order->trade_id }}">查看方案</a>
                @endif
            </div>
        </div>
        @if($order->status <= 100)
            <!-- 进度条 -->
            <div class="Progressbar clearfix b_b_e5">
                <ul class="custom" clearfix>
                    <li class="fs_24 Probar_active">
                        <span class="option_top">
                            <i class="garden"></i>
                            <em class="cross"></em>
                        </span>
                        <span class="option_bottom">发布</span>
                    </li>
                    <li class="fs_24{{ $order->status>0 ? ' Probar_active' : '' }}">
                        <span class="option_top">
                            <i class="garden all_center"></i>
                            <em class="cross"></em>
                        </span>
                        <span class="option_bottom">接单</span>
                    </li>
                    <li class="fs_24{{ $order->status>1 ? ' Probar_active' : '' }}">
                        <span class="option_top">
                            <i class="garden all_center"></i>
                            <em class="cross"></em>
                        </span>
                        <span class="option_bottom">测量</span>
                    </li>
                    <li class="fs_24{{ $order->status>2 ? ' Probar_active' : '' }}">
                        <span class="option_top">
                            <i class="garden all_center"></i>
                            <em class="cross"></em>
                        </span>
                        <span class="option_bottom">定金</span>
                    </li>
                    <li class="fs_24{{ $order->status>3 ? ' Probar_active' : '' }}">
                        <span class="option_top">
                            <i class="garden all_center"></i>
                            <em class="cross"></em>
                        </span>
                        <span class="option_bottom">制作</span>
                    </li>
                    <li class="fs_24{{ $order->status>4 ? ' Probar_active' : '' }}">
                        <span class="option_top">
                            <i class="garden all_center"></i>
                            <em class="cross"></em>
                        </span>
                        <span class="option_bottom">付尾</span>
                    </li>
                    <li class="fs_24{{ $order->status>5 ? ' Probar_active' : '' }}">
                        <span class="option_top">
                            <i class="garden all_center"></i>
                            <em class="cross"></em>
                        </span>
                        <span class="option_bottom">发货</span>
                    </li>
                    <li class="fs_24{{ $order->status>6 ? ' Probar_active' : '' }}">
                        <span class="option_top">
                            <i class="garden all_center"></i>
                            <em class="cross"></em>
                        </span>
                        <span class="option_bottom">收货</span>
                    </li>
                    <li class="fs_24{{ $order->status>7 ? ' Probar_active' : '' }}">
                        <span class="option_top">
                            <i class="garden"></i>
                            <em class="cross"></em>
                        </span>
                        <span class="option_bottom">安装</span>
                    </li>
                </ul>
            </div>
        @endif

        <div class="f_state_b b_b_e5 fs_28 prl24 ptb_13 clearfix">
            <div class="f_ltime fl c_999 ">
                {{ $statuses[$order->status] }}
            </div>
            @if($order->status <= 100)
                <div class="fr">
                    @if($order->status == 1)<a href="/mobile/user/order/custom_scheme_create/{{ $order->trade_id }}" class="f_rightbottom js_queding fl m_l_24 c_999 ">编辑方案</a>@endif
                    @if($order->status >= 1)<a href="javascript:void(0);" class="f_rightbottom js_queding fl m_l_24 c_999 j-contact-member" data-master-mobile="{{ $order->address->phone }}" data-master-realname="{{ $order->address->name }}">联系客户</a>@endif
                </div>
            @endif
        </div>
    </div>
    <div class="null24"></div>
@endforeach
<!-- 联系师傅模态框 -->
<div class="mask js_contact hide">
    <div class="allfabubox">
        <div class="Masterworker b_b_e5">
            <div class="masterinfo clearfix">
                <div class="masterphoto fl">
                    <img src="/packages/mobile/images/img/master.png">
                </div>
                <div class="mastername fl">
                    <div class="fs_32 c_000 j-name"></div>
                    <div class="fs_26 c_666 m_t_10">联系电话：<span class="j-mobile"></span></div>
                </div>
            </div>
        </div>
        <div class="fabottom">
            <a class=" c_999 fs_36 b_r_e5" href="##">发送消息</a>
            <a class=" c_9b34 fs_36 j-call" href="">拨打电话</a>
        </div>
    </div>
</div>
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