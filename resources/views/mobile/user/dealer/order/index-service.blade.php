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
</script>
@endsection

@section('body')
<body class="bg_fff p_b_100">
<div class="f_topnav p_t_15 p_b_15 b_b_e5">
    <nav class="f_nv c_9425 clearfix fs_26">
        <a href="/mobile/user/order?custom">定制</a>
        <a class="server_active" href="javascript:void(0);">服务</a>
    </nav>
</div>
<!-- navtop -->
<div class="f_state b_b_e5 clearfix">
    <a class="item fs_30 c_808 show itemes_active" href="##">全部</a>
    <a class="item fs_30 c_808 show" href="##">待付定金</a>
    <a class="item fs_30 c_808 show" href="##">待服务</a>
    <a class="item fs_30 c_808 show" href="##">待评价</a>
</div>
<div class="null24"></div>
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