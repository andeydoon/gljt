@extends('mobile.layouts.master')

@section('js')
<script type="text/javascript" src="/packages/mobile/js/TouchSlide.1.1.js"></script>
@endsection

@section('script')
<script>
    TouchSlide({
        slideCell: "#slideBox",
        titCell: ".hd li",
        mainCell: ".bd ul",
        delayTime: 1000,
        interTime: 3500,
        autoPlay: true,
        titOnClassName: 'now_li'
    });
</script>
@endsection

@section('body')
<body class="bg_f2f p_b_100">
<div class="fixed_top">
    <header class="indexheader posr clearfix p_b_10">
        <a class="fl fs_18 left_location" href="##">
            <img src="/packages/mobile/images/icon/location.png">
            <p class="m_t_5">广州</p>
        </a>
        <form class="posr search_bar fl">
            <input type="text">
            <i class="search_icon posa"></i>
        </form>
        <a class="fr fs_18 right_message posr" href="/mobile/message">
            <i class="message_icon posa"></i>
            <img src="/packages/mobile/images/icon/ic27.png">
            <p class="m_t_5">消息</p>
        </a>
    </header>
</div>
<!-- banner -->
<div class="banner posr">
    <div class="" id="slideBox">
        <div class="bd">
            <ul class="tempWrap">
                <li class="fl">
                    <a href="##">
                        <img src="/packages/mobile/images/img/banner1.png">
                    </a>
                </li>
                <li class="fl">
                    <a href="##">
                        <img src="/packages/mobile/images/img/banner1.png">
                    </a>
                </li>
                <li class="fl">
                    <a href="##">
                        <img src="/packages/mobile/images/img/banner1.png">
                    </a>
                </li>
                <li class="fl">
                    <a href="##">
                        <img src="/packages/mobile/images/img/banner1.png">
                    </a>
                </li>
                <li class="fl">
                    <a href="##">
                        <img src="/packages/mobile/images/img/banner1.png">
                    </a>
                </li>
                <li class="fl">
                    <a href="##">
                        <img src="/packages/mobile/images/img/banner1.png">
                    </a>
                </li>
            </ul>
        </div>

        <ol class="hd hdindex clearfix posa">
            <li class="fl bg_999"></li>
            <li class="fl bg_999"></li>
            <li class="fl bg_999"></li>
            <li class="fl bg_999"></li>
        </ol>

    </div>
</div>
<!--  门窗产品图 -->
<a class="chan_img clearfix p_b_35 p_t_35" href="/mobile/product">
    <div class="fl m_l_40 leftbgimg"><img src="/packages/mobile/images/img/im13.png"></div>
    <div class="fl m_l_20">
        <p class="fs_34 c_012 m_t_10 m_b_10">门窗产品图</p>
        <p class="fs_22 c_0126">海量精美产品图库</p>
    </div>
</a>
<div class="clearfix prl24 pbt24">
    <a class="sigon fl" href="/mobile/process">
        <img src="/packages/mobile/images/img/im14.png">
        <p class="m_t_15 fs_34 c_012">施工流程</p>
        <p class="m_t_15 fs_22 c_0126">带你玩转订单服务</p>
    </a>
    <a class="sigon fr" href="/mobile/service">
        <img src="/packages/mobile/images/img/im15.png">
        <p class="m_t_15 fs_34 c_012">我要服务</p>
        <p class="m_t_15 fs_22 c_0126">新装、维装都在行</p>
    </a>
</div>
<!-- list to -->
<div class="bgbox bg_fff clearfix">
    <div class="w702 p_b_20">
        <div class="toptite clearfix">
            <div class="left_navto fl fs_30 c_333">
                <a href="#"> 推荐组合</a>
            </div>
            <div class="more fr fs_26 c_999">
                <a href="/mobile/product"> 更多</a>
            </div>
        </div>
        <div class="contentbox clearfix">
            <ul>
                <?php $i = 1; ?>
                @foreach($combines as $combine)
                    <li class="{{ $i%2 ? 'fl' : 'fr' }}">
                        <a class="warp_link posr" href="/mobile/product/{{ $combine->id }}">
                            <img src="{{ $combine->galleries()->value('src') }}">
                            <p class="fs30 posa p_l_20 c_fff">{{ $combine->name }}</p>
                        </a>
                    </li>
                    <?php $i++; ?>
                @endforeach
            </ul>
        </div>
    </div>
</div>
<div class="bgbox bg_fff clearfix">
    <div class="w702 p_b_20">
        <div class="toptite clearfix">
            <div class="left_navto fl fs_30 c_333">
                <a href="#"> 推荐产品</a>
            </div>
            <div class="more fr fs_26 c_999">
                <a href="/mobile/product"> 更多</a>
            </div>
        </div>
        <div class="contentbox clearfix">
            <ul>
                <?php $i = 1; ?>
                @foreach($products as $product)
                    <li class="{{ $i%2 ? 'fl' : 'fr' }}">
                        <a class="warp_link posr" href="/mobile/product/{{ $product->id }}">
                            <img src="{{ $product->galleries()->value('src') }}">
                            <p class="fs30 posa p_l_20 c_fff">{{ $product->name }}</p>
                        </a>
                    </li>
                    <?php $i++; ?>
                @endforeach
            </ul>
        </div>
    </div>
</div>
<!-- 免费估价 -->
<a class="filexdgujia" href="/mobile/quote">
    <img src="/packages/mobile/images/img/im5.png">
</a>
<div class="null20"></div>
<div class="fixed_bottom">
    <?php $paths = [1 => 'publish', 2 => 'order', 3 => 'order']; ?>
    <footer class="fonterbar clearfix">
        <a class="fl P_t_10 wtab-item{{ request()->is('mobile') ? ' tab_ative' : '' }}" href="/mobile">
            <span class="show bgicon"></span>
            <p class=" m_t_5">首页</p>
        </a>
        <a class="fl P_t_10 wtab-item{{ auth()->check()&&request()->is('mobile/user/'.$paths[auth()->user()->type].'*') ? ' tab_ative' : '' }}" href="{{ auth()->check() ? '/mobile/user/'.$paths[auth()->user()->type] : '/mobile/user/to_order' }}">
            <span class="show bgicon"></span>
            <p class=" m_t_5">订单中心</p>
        </a>
        <a class="fl P_t_10 wtab-item{{ auth()->check()&&!request()->is('mobile/user/'.$paths[auth()->user()->type].'*')&&request()->is('mobile/user*') ? ' tab_ative' : '' }}" href="/mobile/user">
            <span class="show  bgicon"></span>
            <p class=" m_t_5">个人中心</p>
        </a>
    </footer>
</div>
</body>
@endsection