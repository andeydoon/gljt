@extends('layouts.master')

@section('css')
<link rel="stylesheet" href="/css/jquery.fileupload.css">
@endsection

@section('js')
<script type="text/javascript" src="/js/superslide.2.1.js"></script>
<script type="text/javascript" src="/js/jquery.ui.widget.js"></script>
<script type="text/javascript" src="/js/jquery.iframe-transport.js"></script>
<script type="text/javascript" src="/js/jquery.fileupload.js"></script>
@endsection

@section('script')
<script type="text/javascript">
    //服务切换 js-z_nav9
    $(".js-z_nav9 li").click(function(){
        var _index =$(this).index();
        $(this).addClass("active").siblings().removeClass("active");
        $(".z_box4").hide().eq(_index).show();
    });
    //地址选择 js-z_shouhuo_ul
    $('.js-z_shouhuo_ul li').click(function(){
        $(this).addClass("active").siblings().removeClass("active");
        $(this).closest('.j-service-form').find('[name="address_id"]').val($(this).data('id'));
    });

    $('.j-service-form').each(function () {
        $('.js-z_shouhuo_ul li', this).eq(0).trigger('click');
    })

    //展开地址 js-open
    $(".js-open").click(function(){
        $(this).addClass("hide").siblings().removeClass("hide");
        $(this).parent().prev().removeClass("z_h80");
    });
    //收起地址
    $(".js-stop").click(function(){
        $(this).addClass("hide").siblings().removeClass("hide");
        $(this).parent().prev().addClass("z_h80");
    });
    //服务 js-service
    juzhong(".js-service");
    //弹出服务 js-service_btn
    $(".js-service_btn").click(function(){
        @if(auth()->check())
            @if(auth()->user()->type==1)
                $(".js-service").removeClass("hide");
                //阴影
                $(".shadow").show();
            @else
                alert('普通用户才能发布需求');
            @endif
        @else
            alert('请先登录');
        @endif
    });
    //点阴影关闭 js-shadow_off
    $(".js-shadow_off").click(function(){
        $(".js-service").addClass("hide");//服务关闭
        $(".js-prompt").addClass("hide");//发布后的提示
        $(".js-gujia").addClass("hide");//免费估价
        //阴影
        $(this).hide();
    });
    //发布后的提示 js-prompt
    juzhong2(".js-prompt");
    //免费估价 js-gujia
    juzhong(".js-gujia");

    $.jAjax({
        url: '/api/category',
        success: function (data) {
            $.each(data.data.categories, function () {
                $('<li/>', {
                    'data-id': this.id,
                    'text': this.name,
                }).appendTo('.j-category_0');
            })
        }
    });

    $('.j-category_0').on('click', 'li', function () {
        $.jAjax({
            url: '/api/category',
            data: {'parent_id': $(this).data('id')},
            success: function (data) {
                $('.j-category_1').empty().prev().text('类型').parent().parent().children(':input').val('');
                $('.j-material').empty().prev().text('材质').parent().parent().children(':input').val('');
                $.each(data.data.categories, function () {
                    $('<li/>', {
                        'data-id': this.id,
                        'text': this.name,
                    }).appendTo('.j-category_1');

                    $.each(this.materials, function () {
                        $('<li/>', {
                            'data-id': this.id,
                            'data-category': this.category_id,
                            'text': this.name,
                            'class': 'hide',
                        }).appendTo('.j-material');
                    })
                })
            }
        });
    });

    $('.j-category_1').on('click', 'li', function () {
        $('.j-material').prev().text('材质').parent().parent().children(':input').val('');
        $('.j-material li').addClass('hide');
        $('.j-material li[data-category="' + $(this).data('id') + '"]').removeClass('hide');
    });


    $.jAjax({
        url: '/api/area',
        success: function (data) {
            $.each(data.data.areas, function () {
                $('<li/>', {
                    'data-id': this.id,
                    'text': this.name,
                }).appendTo('.j-province');
            })
        }
    });

    $('.j-province').on('click', 'li', function () {
        $.jAjax({
            url: '/api/area',
            data: {'parent_id': $(this).data('id')},
            success: function (data) {
                $('.j-city').empty().prev().text('市').parent().parent().children(':input').val('');
                $('.j-district').empty().prev().text('区/县').parent().parent().children(':input').val('');
                $.each(data.data.areas, function () {
                    $('<li/>', {
                        'data-id': this.id,
                        'text': this.name,
                    }).appendTo('.j-city');
                })
            }
        });
    });

    $('.j-city').on('click', 'li', function () {
        $.jAjax({
            url: '/api/area',
            data: {'parent_id': $(this).data('id')},
            success: function (data) {
                $('.j-district').empty().prev().text('区/县').parent().parent().children(':input').val('');
                $.each(data.data.areas, function () {
                    $('<li/>', {
                        'data-id': this.id,
                        'text': this.name,
                    }).appendTo('.j-district');
                })
            }
        });
    });

    $('.j-quote-submit').click(function () {
        $.jAjax({
            url: '/api/quote',
            type: 'POST',
            data: $('.j-quote-form :input').serialize(),
            success: function (data) {
                if (data.status == 'success') {
                    $('.js-gujia .z_color-orange').text(data.data.price_min + '~' + data.data.price_max);
                    for (var i = 0; i < data.data.products.length; i++) {
                        $('.js-gujia .posr p').eq(i).text(data.data.products[i]['name']);
                        $('.js-gujia .posr a').eq(i).prop('href', '/product/' + data.data.products[i]['id']);
                        $('.js-gujia .posr img').eq(i).prop('src', data.data.products[i]['cover']);
                    }
                    $('.js-gujia').removeClass('hide');
                }
            }
        })
    })

    $('.j-service-submit').click(function () {
        var $this = $(this);
        $.jAjax({
            url: '/api/order/service',
            type: 'POST',
            data: $this.closest('.j-service-form').find(':input').serialize(),
            success: function (data) {
                if(data.status=='success'){
                    $('.js-service').addClass('hide');
                    $('.js-prompt').removeClass('hide');
                }
            }
        })
    })

    $('input:file').fileupload({
        url: '/api/upload',
        headers: {'X-CSRF-TOKEN': Laravel.csrfToken},
        formData: {},
        done: function (e, data) {
            $.each(data.result.data.files, function (index, file) {
                var $this = $(e.target);
                $('[name="' + index + '"]').prev().text('上传维修物品图片').parent().parent().append('<div class="z_img_fix fl z_mb10 z_mr10"><img src="' + file + '"/><input type="hidden" name="pictures[]" value="' + file + '"><span class="z_off2 js-z_off"></span></div>')
            });
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $(this).prev().text('上传中(' + progress + '%)');
        }
    });

    $(document).on('click', '.js-z_off', function () {
        $(this).parent().remove();
        return false;
    })

    $('.js-prompt-hide').addClass('hide');
</script>
@endsection

@section('content')
<!--广告-->
<div class="z_guangao z_mb46">
    <a href="javascript:void(0);">
        <img src="/images/other/tp2.png" />
    </a>
</div>
<!--广告 end-->
<div class="z_center7567p bar-white">
    <div class=" clearfix">
        <div class="z_w226p fl">
            <div class="clearfix z_cursor posr z_h130 bar-auburn z_mb10">
                <div class="z_w30p fl tr ver_center pasa">
                    <img src="/images/icon/tb39.png" width="31" height="39" />
                </div>
                <div class="z_w70p fl ver_center pasa z_right-0">
                    <div class="z_ml20">
                        <h2 class="z_font16 z_mb10 z_color_white z_fontn">门窗样例</h2>
                        <p class="z_color_white">海量精美产品图库</p>
                    </div>
                </div>
                <a href="/product" title="门窗样例" class="z_lianjie"></a>
            </div>
            <div class="clearfix z_cursor posr z_h130 bar-blue">
                <div class="z_w30p fl tr ver_center pasa">
                    <img src="/images/icon/tb40.png" width="37" height="37" />
                </div>
                <div class="z_w70p fl ver_center pasa z_right-0">
                    <div class="z_ml20">
                        <h2 class="z_font16 z_mb10 z_color_white z_fontn">发布服务</h2>
                        <p class="z_color_white">新装维装都在行</p>
                    </div>
                </div>
                <a href="javascript:void(0);" title="发布服务" class="z_lianjie js-service_btn"></a>
            </div>
        </div>
        <div class="z_w764p fr bar-LightGrey3 z_h270">
            <div class="z_lineh40  z_color_3 tc">
                <h2 class="z_font20"><span>-</span><span class="z_mlr20">免费报价</span><span>-</span></h2>
            </div>
            <div class="z_lineh30 z_font16 z_color_3 z_pl26">
                <img src="/images/icon/tb38.png"  width="17" height="18" class="z_mr10" />
                （请输入您想要门窗的基本信息）
            </div>
            <div  class="z_mb10 z_pl26">
                <div class="z_user_msg z_user_msg2 z_w100p clearfix j-quote-form">
                    <div class="z_inputbox clearfix z_p10 fl">
                        <label class="z_w60 z_lineh30 z_font12 z_color_3 fl">分　　类：</label>
                        <div class="fl bar-white z_border z_mr10" style="width: 200px;">
                            <input type="hidden" name="" placeholder="" class="z_input ">
                            <div class="z_select_div  js-z_select_div">
                                <p style="">分类</p>
                                <ul class="hide js-z_select_ul j-category_0"></ul>
                                <span class="z_tubiao js-z_tubiao">
                                    <!--图标-->
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="z_inputbox clearfix z_p10 fl">
                        <label class="z_w60 z_lineh30 z_font12 z_color_3 fl">所在地区：</label>
                        <div class="fl bar-white z_border z_mr10" style="width: 110px;">
                            <input type="hidden" name="province_id" placeholder="" class="z_input ">
                            <div class="z_select_div  js-z_select_div">
                                <p style="">省/直辖市</p>
                                <ul class="hide js-z_select_ul j-province"></ul>
                                <span class="z_tubiao js-z_tubiao">
                                    <!--图标-->
                                </span>
                            </div>
                        </div>
                        <div class="fl bar-white z_border z_mr10" style="width: 100px;">
                            <input type="hidden" name="city_id" placeholder="" class="z_input ">
                            <div class="z_select_div  js-z_select_div">
                                <p>市</p>
                                <ul class="hide js-z_select_ul j-city"></ul>
                                <span class="z_tubiao js-z_tubiao">
                                    <!--图标-->
                                </span>
                            </div>
                        </div>
                        <div class="fl bar-white z_border z_mr10" style="width: 110px;">
                            <input type="hidden" name="district_id" placeholder="" class="z_input ">
                            <div class="z_select_div  js-z_select_div">
                                <p>区/县</p>
                                <ul class="hide js-z_select_ul j-district"></ul>
                                <span class="z_tubiao js-z_tubiao">
                                    <!--图标-->
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="z_inputbox clearfix z_p10 fl">
                        <label class="z_w60 z_lineh30 z_font12 z_color_3 fl">类　　型：</label>
                        <div class="fl">
                            <div class="bar-white z_border z_mr10" style="width: 200px;">
                                <input type="hidden" name="category_id" placeholder="" class="z_input ">
                                <div class="z_select_div  js-z_select_div">
                                    <p>类型</p>
                                    <ul class="hide js-z_select_ul j-category_1"></ul>
                                    <span class="z_tubiao js-z_tubiao">
                                        <!--图标-->
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="z_inputbox clearfix z_p10 fl">
                        <label class="z_w60 z_lineh30 z_font12 z_color_3 fl">尺　　寸：</label>
                        <div class="fl">
                            <input type="text" name="height" placeholder="高" value="" class="z_input z_w100 z_ptb7 z_mr10">
                            <input type="text" name="width" placeholder="宽" value="" class="z_input z_w100 z_ptb7 z_mr10">
                            <input type="text" name="thickness" placeholder="厚" value="" class="z_input z_w100 z_ptb7">
                        </div>
                    </div>
                    <div class="z_inputbox clearfix z_p10 fl">
                        <label class="z_w60 z_lineh30 z_font12 z_color_3 fl">材　　质：</label>
                        <div class="fl">
                            <div class="bar-white z_border z_mr10" style="width: 200px;">
                                <input type="hidden" name="material_id" placeholder="" class="z_input ">
                                <div class="z_select_div  js-z_select_div">
                                    <p>材质</p>
                                    <ul class="hide js-z_select_ul j-material"></ul>
                                    <span class="z_tubiao js-z_tubiao">
                                        <!--图标-->
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="z_inputbox clearfix z_p10 fl">
                        <label class="z_w60 z_lineh30 z_font12 z_color_3 fl">手机号码：</label>
                        <input type="text" name="phone" placeholder="请输入您的手机号码" value="" class="z_input z_w200 z_ptb7 fl">
                    </div>
                </div>
                <div class="tc z_mt10">
                    <input type="submit" value="免费报价 " class="z_btn bar-auburn z_font12 z_w120 z_ptb7 j-quote-submit">
                </div>
            </div>
        </div>
    </div>
    <!--列表内容-->
    <!--推荐门窗组合-->
    <div class="z_mt50">
        <div class="z_haed clearfix z_mb36">
            <span class="z_font24 z_fontb z_color_3 z_mr10">推荐门窗组合</span>
            <span class="z_font12 z_color_80">已有 545101 位业主找到灵感</span>
            <div class="z_more fr">
                <a href="/product" class="z_font12 z_color_80">更多&gt;&gt;</a>
            </div>
        </div>
        <div class="z_recommend js-z_recommend">
            <ul class="clearfix">
                @foreach($combines as $combine)
                    <li>
                        <div class="z_img_back">
                            <img src="{{ $combine->galleries()->value('src') }}" />
                            <a href="/product/{{ $combine->id }}" title="" class="z_lianjie"></a>
                        </div>
                        <div class="z_plr10 z-ellipsis z_lineh80 z_font14 z_color_3 z_border">
                            {{ $combine->name }}
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <!--推荐门窗组合 end-->
    <!--推荐产品-->
    <div class="z_mt50">
        <div class="z_haed clearfix z_mb36">
            <span class="z_font24 z_fontb z_color_3 z_mr10">推荐产品</span>
            <span class="z_font12 z_color_80">为你推荐最好的产品</span>
            <div class="z_more fr">
                <a href="/product" class="z_font12 z_color_80">更多&gt;&gt;</a>
            </div>
        </div>
        <div class="z_recommend js-z_recommend">
            <ul class="clearfix">
                @foreach($products as $product)
                    <li>
                        <div class="z_img_back">
                            <img src="{{ $product->galleries()->value('src') }}" />
                            <a href="/product/{{ $product->id }}" title="" class="z_lianjie"></a>
                        </div>
                        <div class="z_plr10 z-ellipsis z_lineh80 z_font14 z_color_3 z_border">
                            {{ $product->name }}
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <!--推荐产品 end-->
    <!--广告-->
    <div class="z_mb10 clearfix z_mt50 ">
        <div class="z_w495p fl posr">
            <img src="/images/other/tp3.png" class="z_img_100p"/>
            <div class="z_w50p z_color_white ver_center z_left-25p z_index-2 tc">
                <h2 class="z_font18 z_fontn z_lineh30">师傅抢单 免费测量</h2>
                <p class="z_font14 z_lineh24">我们有无所经验丰富的师傅，根据您的位置随时接单， 上门测量，免费提供优质服务</p>
            </div>
            <a href="javascript:void(0);" title="" class="z_lianjie"></a>
        </div>
        <div class="z_w495p fr posr">
            <img src="/images/other/tp4.png" class="z_img_100p"/>
            <div class="z_w50p z_color_white ver_center z_left-25p z_index-2 tc">
                <h2 class="z_font18 z_fontn z_lineh30">专业设计 个性定制</h2>
                <p class="z_font14 z_lineh24">拥有上万品牌方案，可按自己选择进行搭配， 打造理想的家</p>
            </div>
            <a href="javascript:void(0);" title="" class="z_lianjie"></a>
        </div>
    </div>
    <!--广告 end-->
    <!--关于我们 -->
    <div class="z_mb30 z_aboutUs z_pt30 z_pb40">
        <div class="z_w70p z_mlrauto">
            <h1 class="tc">关于我们</h1>
            <p>广铝集团有限公司成立于1993年，总部位于广州市，是一家集铝土矿山开采、氧化铝生产、铝冶炼及铝精深产品研发-生产加工-贸易销售、铝质幕墙门窗生产与工程安装于一体的铝全产业链覆盖，多元化投资发展的大型企业集团，是国内外最为完整的铝全产业链生产企业之一</p>
            <p>诚信至上，质量为先。广铝集团先后荣获了中国驰名商标、国家重点新产品生产基地、国家认可实验室、中国节能型材创新企业十强、广东省名牌产品、博士后科研工作站、广东省高新技术企业、广东省企业技术中心、广东省十大守信用提名企业、广东省优秀信用企业、广州市政府重点扶持十大民营企业、建筑幕墙工程设计与施工一级资质证书等多项荣誉资格，成立了铝全产业链专家委员会，并先后通过了ISO9001、ISO14001以及OHSAS18001三大国际认证...</p>
        </div>
        <div class="z_more tc z_mt30">
            <a href="/user/about"class="z_font14 z_color_40 z_color-orange"><span class="z_mr20">查看更多</span>&gt;&gt;</a>
        </div>
    </div>
    <!--关于我们 end-->
    <!--列表内容 end-->
</div>
<!--阴影和弹出框-->
<div class="shadow js-shadow_off" style=""></div>

@if(auth()->check())
    @if(auth()->user()->type==1)
        <!--服务-->
        <div class="z_popup z_w900 bar-white z_pb20 posa animation bounceIn hide js-service">
            <div class="z_border_b">
                <ul class="clearfix z_nav9 js-z_nav9">
                    <?php $i = 0; ?>
                    @foreach($services as $service)
                        <li class="z_li_1{{ !$i ? ' active' : '' }}">
                            <span>{{ $service->name }}</span>
                        </li>
                        <?php $i++; ?>
                    @endforeach
                </ul>
            </div>
            <?php $i = 0; ?>
            @foreach($services as $service)
                <div class="z_box4 j-service-form"{!! !$i ? ' style="display: block;"' : '' !!}>
                    <input type="hidden" name="service_id" value="{{ $service->id }}">
                    <div class="z_user_msg z_user_msg2 z_w100p clearfix z_mt10">
                        <div class="z_inputbox clearfix z_p10">
                            <label class="z_w160 z_lineh30 z_font12 z_color_3 fl">选择服务物品类型：</label>
                            <div class="fl bar-white z_border" style="width: 265px;">
                                <input type="hidden" name="category_id" placeholder="" class="z_input ">
                                <div class="z_select_div  js-z_select_div">
                                    <p style="">选择类型</p>
                                    <ul class="hide js-z_select_ul" style="display: none;">
                                        @foreach($categories as $category)
                                            <li data-id="{{ $category->id }}">{{ $category->name }}</li>
                                        @endforeach
                                    </ul>
                                    <span class="z_tubiao js-z_tubiao">
                                    <!--图标-->
                                </span>
                                </div>
                            </div>
                        </div>
                        @if($service->type==1)
                        <div class="z_inputbox clearfix z_p10">
                            <label class="z_w160 z_lineh30 z_font12 z_color_3 fl">期望维修方案：</label>
                            <div class="fl bar-white z_border" style="width: 265px;">
                                <input type="hidden" name="scheme" placeholder="" class="z_input ">
                                <div class="z_select_div  js-z_select_div">
                                    <p style="">选择方案</p>
                                    <ul class="hide js-z_select_ul" style="display: none;">
                                        <li data-id="1" class="active">翻新</li>
                                        <li data-id="2">维修</li>
                                    </ul>
                                    <span class="z_tubiao js-z_tubiao">
                                    <!--图标-->
                                </span>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="z_inputbox clearfix z_p10">
                            <label class="z_w160 z_lineh30 z_font12 z_color_3 fl">物品数量：</label>
                            <div class="fl" style="">
                                <div class="z_border z_jishuan clearfix">
                                    <span class="z_border_r js-reduce">-</span>
                                    <input type="text" class="js-quantity" name="quantity" value="1">
                                    <span class="z_border_l js-plus">+</span>
                                </div>
                            </div>
                        </div>
                        <div class="z_inputbox clearfix z_p10">
                            <label class="z_w160 z_lineh30 z_font12 z_color_3 fl">服务内容详情：</label>
                            <div class="fl z_w64p" style="">
                                <div class="z_text-wrap z_border z_p10 ">
                                    <textarea class="z_textarea z_h120" name="content" placeholder="请输入您需要的服务内容详情"></textarea>
                                </div>
                                <div class="z_mt10 z_color_6 z_font12">
                                    您还可以输入500字
                                </div>
                            </div>
                        </div>
                        <div class="z_inputbox clearfix z_p10">
                            <input type="hidden" name="address_id">
                            <label class="z_w160 z_lineh30 z_font12 z_color_3 fl">选择服务地址：</label>
                            <div class="z_ml180" style="">
                            @if(auth()->user()->addresses()->count())
                                <!--服务地址-->
                                    <div class="z_mb10 z_h80 over_h">
                                        <ul class="z_shouhuo_ul js-z_shouhuo_ul">
                                            @foreach(auth()->user()->addresses()->with('province', 'city', 'district')->orderBy('default', 'DESC')->get() as $address)
                                                <li data-id="{{ $address->id }}"{!! $address->default ? ' class="active"' : '' !!}>
                                                    <div class="fl z_name z_mr10">
                                                        {{ $address->name }}
                                                    </div>
                                                    <div class="fl">{{ $address->province->name }} {{ $address->city->name }} {{ $address->district->name }} {{ $address->street }} {{ $address->phone }}</div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <!--服务地址 end-->
                                    @if(auth()->user()->addresses()->count() > 2)
                                        <div class="z_mt10">
                                            <spsn class="z_color_3 z_cursor js-open">
                                                显示全部地址
                                                <img src="/images/icon/tb24.png" width="9" height="9"/>
                                            </spsn>
                                            <spsn class="z_color_3 z_cursor hide js-stop">
                                                收起地址
                                                <img src="/images/icon/tb24a.png" width="9" height="9"/>
                                            </spsn>
                                        </div>
                                    @endif
                                @else
                                    <input type="button" value="添加地址 " class="z_btn z_font12 z_w160 z_h40" onclick="window.location.href='/user/address/create'">
                                @endif
                            </div>
                        </div>
                        <div class="z_inputbox clearfix z_p10">
                            <label class="z_w160 z_lineh30 z_font12 z_color_3 fl">上传服务物品图片：</label>
                            <div class="z_ml180" style="">
                                <div class="z_mb10 z_lineh30 z_color_9">
                                    （可将您当前的服务实施物品拍摄上传，方便师傅了解情况，最多可添加9张图片）
                                </div>
                                <div class="clearfix">
                                    <div class="z_img_fix fl z_mb10 z_mr10">
                                        <div class="z_font12 z_color_3 tc z_mt60">
                                            上传服务物品图片
                                        </div>
                                        <input type="file" name="picture"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="z_inputbox z_mt20 z_mb20 z_ml180">
                        <input type="submit" value="发布" class="z_btn bar-auburn z_font14 z_w160 j-service-submit"/>
                    </div>
                </div>
                <?php $i++; ?>
            @endforeach
        </div>
        <!--服务 end-->
        <!--发布成功-->
        <div class="z_popup z_w420 bar-white z_pb20 posf animation bounceIn hide js-prompt">
            <div class="z_mt30 z_mb30 tc">
                <img src="/images/icon/tb31.png" width="72" height="72" />
            </div>
            <div class="tc z_mb30">
                <h2 class="z_fontn z_color_3 z_font16 z_mb10 z_lineh30">您的需求已发布成功，请等待师傅接单</h2>
                <p class="z_color_6 z_font14 z_lineh24">师傅接单后会联系您上门查看</p>
            </div>
            <div class="z_inputbox z_mb20 tc">
                <input type="button" value="确定"  class="z_btn bar-auburn z_font14 z_w140 z_mr20 js-prompt-hide"/>
                <a href="/user/publish?service" class="z_btn bar-Grey-ca z_font14 z_w140 ">查看我的服务</a>
            </div>
        </div>
        <!--发布成功 end-->
    @endif
@endif
<!--免费估价-->
<div class="z_popup z_w840 bar-white z_pb20 posa animation bounceIn hide js-gujia">
    <div class="z_w84p z_mlrauto z_font18 z_color_3 z_fontb z_lineh40 z_mt20 z_mb10">
        价格范围：<span class="z_color-orange"></span>元
    </div>
    <div class="z_mb30 z_w84p z_mlrauto">
        <ul class="clearfix z_ul2">
            <li>已经累计服务200万业主</li>
            <li>服务已覆盖150个城市</li>
            <li>98万入住师傅、7万入住门窗厂家</li>
        </ul>
    </div>
    <!--轮播图-->
    <div class="z_mb20 z_w84p z_mlrauto">
        <div class="fullSlide">
            <div class="bd">
                <ul>
                    <li>
                        <div class="fl z_mr30 z_ml30 posr" style="width: 284px;height: 100%;">
                            <div class="z_img_back">
                                <img src="" />
                                <a href="" title="" class="z_lianjie"></a>
                                <div class="z_title_y">
                                    <p></p>
                                </div>
                            </div>
                        </div>
                        <div class="fl z_mr30 z_ml30 posr" style="width: 284px;height: 100%;">
                            <div class="z_img_back">
                                <img src="" />
                                <a href="" title="" class="z_lianjie"></a>
                                <div class="z_title_y">
                                    <p></p>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!--轮播图 end-->
    <div class="z_mb30 clearfix z_w84p z_mlrauto z_font12 z_color_3 z_lineh24">
        <p>Tips：稍后门窗管家将致电您，为你提供免费咨询服务</p>
        <p>因材料品牌及工程量不同，具体报价以实际定制方案为准。</p>
    </div>
</div>
@endsection