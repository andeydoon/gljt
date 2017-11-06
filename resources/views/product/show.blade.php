@extends('layouts.master')

@section('script')
<script type="text/javascript">
    //收藏 js-z_collection
    $(".js-z_collection").click(function () {
        var $this = $(this);
        $.jAjax({
            url: '/api/product/favorite',
            type: 'POST',
            data: {id: {{ $product->id }}, type: 'PRODUCT'},
            success: function (data) {
                if (data.status = 'success') {
                    $this.toggleClass("active", data.data.isFavorite);

                    var number = parseInt($('span', $this).text(), 10);
                    number += data.data.isFavorite ? 1 : -1;
                    console.log(number);
                    $('span', $this).text(number);
                }
            }
        })
    });
    //条件选择 js-z_ul_list2
    $('.js-z_ul_list2 li').click(function () {
        $(this).parent().prev().val($(this).data('id'));
        $('.j-cover').attr('src', $(this).data('picture'));
        $('.j-price').text($(this).data('price'));
        $(this).addClass("active").siblings().removeClass("active");
    });
    //详情导航 js-z_nav10
    $('.js-z_nav10 li').click(function () {
        var _index = $(this).index();
        $(this).addClass("active").siblings().removeClass("active");
        $(".z_box4").hide().eq(_index).show();
    });

    //产品大图 js-sanping_big_img
    juzhong(".js-sanping_big_img");
    //弹出产品大图 js-sanping_big_img_btn
    $(".js-sanping_big_img_btn").click(function () {
        $(".js-sanping_big_img").removeClass("hide");
        //阴影
        $(".shadow").show();
    });
    //点阴影关闭 js-shadow_off
    $(".js-shadow_off").click(function () {
        $(".js-sanping_big_img").addClass("hide");//产品大图
        //阴影
        $(this).hide();
    });

    var index = 0;
    var timer = 0;
    var ulist = $('.img_list ul');
    var blist = $('.btn_list ul');
    var list = ulist.find('li');
    var llength = list.length;//li的个数，用来做边缘判断
    var nwidth = $(".js-sanping_big_img").width() * 0.7;//总盒子宽度
    list.css("width", nwidth);
    //console.log(nwidth);
    var lwidth = $(list[0]).width();//每个li的长度，ul每次移动的距离
    var uwidth = llength * lwidth;//ul的总宽度
    ulist.css("width", uwidth);

    function init() {
        //生成按钮(可以隐藏)
        addBtn(list);
        //显示隐藏左右点击开关
        $('.link').css('display', 'block');
        $('.link').bind('click', function (event) {
            var elm = $(event.target);
            doMove(elm.attr('id'));
            return false;
        });

        //初始化描述
        var text = ulist.find('li').eq(0).find('img').attr('alt');
        var link = ulist.find('li').eq(0).find('a').attr('href');
        $('.img_intro .text a').text(text);
        $('.img_intro .text a').attr('href', link);
        //auto();
    }

    function auto() {
        //定时器
        timer = setInterval("doMove('toRight')", 3000);

        $('.img_list li, .btn_list li').hover(function () {
            clearInterval(timer);
        }, function () {
            timer = setInterval("doMove('toRight')", 3000);
        });
    }

    function changeBtn(i) {
        blist.find('li').eq(i).addClass('on').siblings().removeClass('on');
        var text = ulist.find('li').eq(i).find('img').attr('alt');
        var link = ulist.find('li').eq(i).find('a').attr('href');
        $('.img_intro .text a').text(text);
        $('.img_intro .text a').attr('href', link);
    }

    function addBtn(list) {
        for (var i = 0; i < list.length; i++) {
            var imgsrc = $(list[i]).find('img').attr('src');
            var listCon = '<li><img src="' + imgsrc + '""></li>';
            $(listCon).appendTo(blist);
            //隐藏button中的数字
            //list.css('text-indent', '10000px');
        }
        ;
        blist.find('li').first().addClass('on');
        blist.find('li').click(function (event) {
            var _index = $(this).index();
            doMove(_index);
        });
    }

    function doMove(direction) {
        //向右按钮
        if (direction == "toRight") {
            index++;
            if (index < llength) {
                uwidth = lwidth * index;
                ulist.css('left', -uwidth);
                //ulist.animate({left: -uwidth}, 1000);

            } else {
                ulist.css('left', '0px');
                index = 0;
            }
            ;
            //向左按钮
        } else if (direction == "toLeft") {
            index--;
            if (index < 0) {
                index = llength - 1;
            }
            uwidth = lwidth * index;
            ulist.css('left', -uwidth);
            //ulist.animate({left: -uwidth}, "slow");
            //点击数字跳转
        } else {
            index = direction;
            uwidth = lwidth * index;
            ulist.css('left', -uwidth);
        }
        ;
        changeBtn(index);
    }

    init();

    $('.j-custom').click(function () {
        if ($('[name="colour_id"]').size()) {
            if (!$('[name="colour_id"]').val()) {
                alert('请选择颜色');
                return;
            } else {
                window.location = '/product/{{ $product->id }}/custom?colour_id=' + $('[name="colour_id"]').val();
                return;
            }
        }

        window.location = '/product/{{ $product->id }}/custom';
    });

</script>
@endsection

@section('content')
<div class="z_center119 clearfix z_mt30">
    <!--商品信息-->
    <div class="z_mb30 clearfix">
        <div class="z_border z_goods_img2 fl posr">
            <img src="{{ $product->galleries()->value('src') }}" class="j-cover"/>
            <span class="z_see js-sanping_big_img_btn"></span>
        </div>
        <div class="z_w63p fr">
            <div class="clearfix">
                <div class="z_text z_color_3 z_lineh30 z_font14 z_w70p fl z_border_b-d z_pb10">
                    <h2 class="z_font16">{{ $product->name }}</h2>
                    <p>{{ $product->describe }}</p>
                </div>
                <div class="z_w30p fl">
                    <span class="z_collection js-z_collection{{ (auth()->check()&&auth()->user()->favorites()->where('type',1)->where('related_id',$product->id)->exists())?' active':'' }}">收藏<span>{{ $product->favorites()->count() }}</span>（人气）</span>
                </div>
            </div>
            <!--价格信息和其他-->
            <div class="z_w70p z_border_b-d z_ptb20">
                <table class="z_table">
                    <tbody>
                    <tr>
                        <td class="z_w60">价格：</td>
                        <td>
                            <span class="z_color_red z_fontb">¥@if($product->colours()->count())<i class="j-price">{{ $product->colours()->orderBy('price', 'ASC')->value('price') }}-{{ $product->colours()->orderBy('price', 'DESC')->value('price') }}</i>@else{{ $product->price }}@endif/{{ $product->unit }}</span>
                        </td>
                    </tr>
                    @if($product->colours()->count())
                        <tr>
                            <td class="z_w60">颜色：</td>
                            <td>
                                <input type="hidden" name="colour_id">
                                <ul class="clearfix z_ul_list2 js-z_ul_list2">
                                    @foreach($product->colours as $colour)
                                        <li data-id="{{ $colour->id }}" data-price="{{ $colour->price }}" data-picture="{{ $colour->picture }}">{{ $colour->name }}</li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
            <!--价格信息和其他 end-->
            <!--参数-->
            @if($product->attributes()->count())
                <div class="z_mb10">
                    <div class="z_font14 z_color_3 z_lineh30">参数</div>
                    <ul class="clearfix z_ul_2p">
                        @foreach($product->attributes as $attribute)
                            <li>{{ $attribute->label }}：{{ $attribute->value }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <!--参数 end-->
            <div class="z_inputbox z_mt20 z_mb20">
                <input type="button" value="定制" class="z_btn bar-auburn z_font14 z_w120 z_ptb10 j-custom"/>
            </div>
        </div>
    </div>
    <!--商品信息 end-->
    <!--商品详情-->
    <div class="z_border">
        <div class="bar-Grey-fa z_border_b">
            <ul class="clearfix z_nav10 js-z_nav10">
                <li class="active">概述</li>
                <li>评论</li>
                <li>
                    施工流程
                    <a href="/process" class="z_lianjie"></a>
                </li>
            </ul>
        </div>
        <div class="z_p10">
            <!--概述-->
            <div class="z_box4" style="display: block;">
                <div class="z_p10 z_text2">
                    {!! $product->overview !!}
                </div>
            </div>
            <!--概述 end-->
            <!--评论-->
            <div class="z_box4" style="">
                <div class="z_mb50">
                    @foreach($product->comments as $comment)
                        <div class="z_rope clearfix z_border_b-d z_ptb10">
                            <div class="z_use_h z_w10p fl">
                                <div class="z_use_h_ms">
                                    <img src="{{ $product->galleries()->value('src') }}"/>
                                    <span>{{ substr_replace($comment->user->mobile, '****', 3, 4) }}</span>
                                </div>
                                <div class="z_time">{{ $comment->created_at }}</div>
                            </div>
                            <div class="fl z_w90p">
                                <div class="z_rope_text">
                                    <div>{{ $comment->product_content }}</div>
                                    @if($comment->pictures)
                                        <div>
                                            @foreach(explode(';', $comment->pictures) as $picture)
                                                <img src="{{ $picture }}"/>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <!--评论 end-->
        </div>
    </div>
    <!--商品详情 end-->
</div>
<!--阴影和弹出框-->
<div class="shadow js-shadow_off" style=""></div>

<!--产品大图-->
<div class="z_popup z_w680 bar-LightGrey3 z_p15 posf animation bounceIn hide js-sanping_big_img">
    <div class="bar-white clearfix">
        <div class=" z_w70p fl">
            <div class="z_border">
                <div class="z_bannerbox js-z_bannerbox">
                    <div class="img_list">
                        <ul>
                            @foreach($product->galleries as $gallery)
                            <li>
                                <a href="javascript:void(0)" target="">
                                    <img src="{{ $gallery->src }}" alt="">
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="img_intro hide">
                        <div class="text"><a href="javascript:void(0);" target="_blank"></a></div>
                        <div class="img_intro_bg"></div>
                    </div>
                    <a href="javascript:void(0);" id="toLeft" class="link toLeft"></a>
                    <a href="javascript:void(0);" id="toRight" class="link toRight"></a>
                </div>
            </div>
        </div>
        <div class="z_w30p fl">
            <!--商品名-->
            <div class="z_mb20 z_mt30 z_plr10 z_color_3 z_fontb z_font16 z_lineh24">
                中控钢化玻璃推拉窗铝合金 窗GAC120系列节能双层窗
            </div>
            <!--商品名-->
            <!--图片对应缩略图的按钮-->
            <div class="btn_list z_p10">
                <ul class="clearfix">
                </ul>
            </div>
            <!--图片对应缩略图的按钮 end-->
        </div>
    </div>
</div>
@endsection