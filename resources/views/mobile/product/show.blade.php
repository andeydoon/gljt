@extends('mobile.layouts.master')

@section('script')
<script type="text/javascript">
    $(".j-favorite").click(function () {
        var $this = $(this);
        $.jAjax({
            url: '/api/product/favorite',
            type: 'POST',
            data: {id: {{ $product->id }}, type: 'PRODUCT'},
            success: function (data) {
                if (data.status = 'success') {
                    if(data.data.isFavorite){
                        $('.j-favorite').html('<img src="/packages/mobile/images/img/im12.png"><p>取消收藏</p>');
                    }else{
                        $('.j-favorite').html('<img src="/packages/mobile/images/img/im11.png"><p>收藏</p>');
                    }
                }
            }
        })
    });

    $('.j-custom').click(function () {
        if ($('[name="colour_id"]').size()) {
            if (!$('[name="colour_id"]').val()) {
                alert('请选择颜色');
                return;
            } else {
                window.location = '/mobile/product/{{ $product->id }}/custom?colour_id=' + $('[name="colour_id"]').val();
                return;
            }
        }

        window.location = '/mobile/product/{{ $product->id }}/custom';
    });

    $('.pcontent span').click(function () {
        $(this).parent().prev().val($(this).data('id'));
        $('.j-cover').attr('src', $(this).data('picture'));
        $('.j-price').text($(this).data('price'));
        $(this).addClass("active").siblings().removeClass("active");
    });
</script>
@endsection

@section('body')
<body class="bg_fff p_b_100">
<header class="header bg_fff clearfix posr p_t_30 p_b_30 b_b_e5 p_l_24 p_r_24">
    <a class="return fl" href="javascript:window.history.back();"></a>
    <div class="text fl fs_36 t_a_c c_1b1 top_title x_center">产品详情</div>
    <a class="confirm fr" href="/mobile"></a>
</header>
<!-- Product name -->
<div class="pName prl24 pbt24 clearfix">
    <div class="pimgbox fl">
        <img class="j-cover" src="{{ $product->galleries()->value('src') }}">
    </div>
    <div class="ptext fl m_l_15">
        <p class="limitw fs_32 c_000 p_t_15 Singleellipsis">{{ $product->name }}</p>
        <p class="fs_30 c_333 p_t_30">价格：¥@if($product->colours()->count())<i class="j-price">{{ $product->colours()->orderBy('price', 'ASC')->value('price') }}-{{ $product->colours()->orderBy('price', 'DESC')->value('price') }}</i>@else{{ $product->price }}@endif/{{ $product->unit }}</p>
    </div>
</div>
@if($product->colours()->count())
    <div class="null20"></div>
    <div class="pcolor">
        <p class="toptitle fs_32 c_000 b_b_e5 prl24">
            颜色分类
        </p>
        <input type="hidden" name="colour_id">
        <div class="pcontent w702 fs_32 clearfix">
            @foreach($product->colours as $colour)
                <span class="fl" data-id="{{ $colour->id }}" data-price="{{ $colour->price }}" data-picture="{{ $colour->picture }}">{{ $colour->name }}</span>
            @endforeach
        </div>
    </div>
@endif
@if($product->attributes()->count())
    <div class="null20"></div>
    <div class="pcolor">
        <p class="toptitle fs_32 c_000 b_b_e5 prl24">
            参数
        </p>
        <div class="pcontentto w702 fs_30 clearfix p_b_30">
            <ul>
                @foreach($product->attributes as $attribute)
                    <li>
                        <span>{{ $attribute->label }}：</span>
                        <span>{{ $attribute->value }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
<div class="null20"></div>
<!-- 概述 -->
<div class="Summary">
    <p class="gaisu fs_32 c_000 b_b_e5 prl24">概述</p>
    <div class="imgtubox w702 p_b_24 p_t_18">
        {!! $product->overview !!}
    </div>
</div>
<div class="null20"></div>
<!-- pinglun -->
<div class="allpingbox clearfix">
    <div class="topnav prl24 b_b_e5 clearfix">
        <span class="fl fs_32 c_000">用户评论<i>{{ $product->comments->count() }}</i> </span>
    </div>
    @foreach($product->comments as $comment)
        <div class="pingcontent b_b_e5 prl24 clearfix">
            <div class="headportrait fl">
                <img src="/packages/mobile/images/img/imh1.png">
            </div>
            <div class="specificinfo fr fs_30">
                <p class="c_333">{{ substr_replace($comment->user->mobile, '****', 3, 4) }}</p>
                <p class="m_t_15 c_808 fs_24">{{ $comment->created_at }}</p>
                <p class="m_t_15 c_333 heiline13">
                    {{ $comment->product_content }}
                </p>
            </div>
        </div>
    @endforeach
</div>

<div class="fixed_bottom">
    <div class="xianqingbottom bg_fff">
        <a class="fl c_999 fs_24 j-favorite" href="javascript:void(0);">
            @if(auth()->check()&&auth()->user()->favorites()->where('type',1)->where('related_id',$product->id)->exists())
                <img src="/packages/mobile/images/img/im12.png">
                <p>取消收藏</p>
            @else
                <img src="/packages/mobile/images/img/im11.png">
                <p>收藏</p>
            @endif
        </a>
        <a class="fr bg_942 heiline88 c_fff fs_32 j-custom" href="javascript:void(0);">
            定制
        </a>
    </div>
</div>

</body>
@endsection