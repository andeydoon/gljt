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
    mui.previewImage();
</script>
@endsection

@section('body')
<body class="bg_fff">
<header class="header bg_fff clearfix posr p_t_30 p_b_30 b_b_e5 p_l_24 p_r_24">
    <a class="return fl" href="javascript:window.history.back();"></a>
    <div class="text fl fs_36 t_a_c c_1b1 top_title x_center">查看方案</div>
    <a class="confirm fr" href="/mobile"></a>
</header>
<!-- 了解详情 -->
<div class="liaojie prl24 clearfix b_b_e5">
    <span class="fl c_666 liaoj fs_28">这是师傅根据您的真实环境确认的</span>
    <a class=" fr c_1b goliaoj fs_30 bg_fbfa" href="/mobile/process">了解施工流程</a>
</div>
<div class="pName prl24 pbt24 clearfix">
    <div class="pimgbox fl">
        <img src="/packages/mobile/images/img/pimg.png">
    </div>
    <div class="ptext fl m_l_15">
        <p class="limitw fs_32 c_000  Singleellipsis">{{ $order->custom->product->name }}</p>
        <p class="fs_30 c_333 P_t_10">订单号：{{ $order->trade_id }}</p>
        <p class="fs_30 c_333 P_t_10">服务师傅：{{ $order->master->profile->realname }}</p>
    </div>
</div>
<div class="allinfo w702">
    <ul class="position fs_30 c_333">
        <li class="c_000 fs_32">方案</li>
        <li>{{ $order->custom_scheme->content }}</li>
    </ul>

    <ul class="position fs_30 c_333">
        <li class="c_000 fs_32">尺寸</li>
        <li class="lastli clearfix">
            <span class="t_a_l">厚：{{ $order->custom_scheme->thickness }}</span>
            <span class="t_a_c">高：{{ $order->custom_scheme->height }}</span>
            <span class="t_a_r">宽：{{ $order->custom_scheme->width }}</span>
        </li>
    </ul>

    @if($order->custom_scheme->parameters)
        <ul class="position fs_30 c_333">
            <li class="c_000 fs_32">参数</li>
            <li class="lastli clearfix">
                @foreach(unserialize($order->custom_scheme->parameters) as $key=>$value)
                    <span class="t_a_l">{{ $key }}：{{ $value }}</span>
                @endforeach
            </li>
        </ul>
    @endif

    <ul class="Price_product fs_30 c_333">
        <li class="c_000 fs_32">价格</li>
        <li>总价：{{ $order->total }}元</li>
    </ul>
</div>
@if($order->custom_scheme->pictures)
    <!-- 预览图片 -->
    <div class="p_b_30 m_t_50">
        <div class="prl24 c_000 ">方案图</div>
        <div class="mui-content">
            <div class="mui-content-padded">
                <div class="viewimg clearfix p_t_24">
                    @foreach(explode(';', $order->custom_scheme->pictures) as $picture)
                        <img src="{{ $picture }}" data-preview-src="" data-preview-group="1">
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endif
</body>
@endsection