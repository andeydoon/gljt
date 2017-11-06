@extends('mobile.layouts.master')

@section('css')
<link rel="stylesheet" type="text/css" href="/packages/mobile/css/mui.min.css">
<link rel="stylesheet" type="text/css" href="/packages/mobile/css/app.css">
<link rel="stylesheet" type="text/css" href="/packages/mobile/css/mui.picker.css">
<link rel="stylesheet" type="text/css" href="/packages/mobile/css/mui.poppicker.css">
@endsection

@section('style')
<style type="text/css" media="screen">
    input[type="number"], input[type='text'] {
        line-height: 1;
        /* width: 100%; */
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

    textarea {
        margin: 0px;
        padding: 0px;
    }
</style>
@endsection

@section('js')
<script type="text/javascript" src="/packages/mobile/js/jqwei-xxSlide.js"></script>
<script src="/packages/mobile/js/mui.min.js"></script>
<script src="/packages/mobile/js/mui.picker.js"></script>
<script src="/packages/mobile/js/mui.poppicker.js"></script>
@endsection

@section('script')
<script type="text/javascript">
    $('.j-submit').click(function () {
        $.jAjax({
            url: '/api/order/custom',
            type: 'POST',
            data: $('.j-form :input').serialize(),
            success: function (data) {
                if (data.status == 'success') {
                    $('.js_fabu').show();
                }
            }
        });
    });


    $('.setyears').click(function(){
        $('.js_maskbox').show();
        // 弹框设置纵向的滚动滚动;
        $.gosider('warpsscoll','ulscoll');
        // 固定网页,防止底部页面也跟着滑动;
        $('body').css({
            'overflow':'hidden',
            'position': 'fixed',
            'top':0,
        });

        $('.js_maskbox .js_checkbox').removeClass('select_address_active');
        $('.js_maskbox [data-id='+$('[name="address_id"]').val()+'] .js_checkbox').addClass('select_address_active');
    });

    // 取消
    $('.js_c').click(function(){
        $(this).parents('.js_maskbox').hide();
        $('body').css({
            'overflow':'auto',
            'position': 'static',
            'top': 'auto'
        });
    });

    //确认
    $('.js_o').click(function(){
        var $sel = $('.selecwp');
        $sel.empty();
        // 姓名和电话赋值;
        var $idom = $('.select_address_active').parents('.adderss_dao').find('ul li:first').find('i');
        $sel.append(' <li> <i class="isname">'+$idom.eq(0).text()+'</i> <i>'+ $idom.eq(1).text()+'</i> </li>');
        // 楼层信息赋值;
        var $lidom = $('.select_address_active').parents('.adderss_dao').find('ul li').not('li:first');
        $.each($lidom,function(index, el) {
            $sel.append('<li class="Singleellipsis">'+$(el).text()+'</li>');
        });

        $(this).parents('.js_maskbox').hide();
        $('body').css({
            'overflow':'auto',
            'position': 'static',
            'top': 'auto'
        });

        $('[name="address_id"]').val($('.select_address_active').parents('.adderss_dao').data('id'));
    });

    // 选择地址模态框选择按钮;
    $('.js_checkbox').click(function(){
        $(this).addClass("select_address_active")
            .parents('.adderss_dao')
            .siblings(".adderss_dao")
            .find('.js_checkbox')
            .removeClass("select_address_active");
    })

</script>
@endsection

@section('body')
<body class="bg_fff">
<header class="header bg_fff clearfix posr p_t_30 p_b_30 b_b_e5 p_l_24 p_r_24">
    <a class="return fl" href="javascript:window.history.back();"></a>
    <div class="text fl fs_36 t_a_c c_1b1 top_title x_center">产品定制</div>
    <a class="confirm fr" href="/mobile"></a>
</header>
<!-- 了解详情 -->
<div class="liaojie prl24 clearfix b_b_e5">
    <span class="fl c_666 liaoj fs_28">您发布需求后，我们将免费上门测量</span>
    <a class=" fr c_1b goliaoj fs_30 bg_fbfa" href="##">了解施工流程</a>
</div>
<div class="pName prl24 pbt24 clearfix">
    <div class="pimgbox fl">
        <img src="/packages/mobile/images/img/pimg.png">
    </div>
    <div class="ptext fl m_l_15">
        <p class="limitw fs_32 c_000  Singleellipsis">铝合金窗</p>
    </div>
</div>
<div class="null20"></div>
<div class="j-form">
    <input type="hidden" name="product_id" value="{{ $product->id }}">
    @if(isset($productColour))
        <input type="hidden" name="product_colour_id" value="{{ $productColour->id }}">
    @endif
    <!-- 服务地址 -->
    <div class="server_dizhi">
        <p class="fs_34 b_b_e5 heiline90 h90 prl24 c_000">服务地址:</p>
        @if(auth()->user()->addresses()->count())
            <div class="select_dizi prl24 fs_30 setyears">
                <?php $address = auth()->user()->addresses()->with('province', 'city', 'district')->orderBy('default', 'DESC')->first() ?>
                <input type="hidden" name="address_id" value="{{ $address->id }}">
                <ul class="selecwp heiline15 fs_30">
                    <li><i class="isname">{{ $address->name }}</i> <i>{{ $address->phone }}</i></li>
                    <li class="Singleellipsis">{{ $address->province->name }} {{ $address->city->name }} {{ $address->district->name }}</li>
                    <li class="Singleellipsis">{{ $address->street }}</li>
                    <li class="Singleellipsis">楼层信息：{{ $address->floor }}</li>
                    <li class="Singleellipsis">电梯情况：{{ $address->lift ? '有' : '无' }}</li>
                </ul>
            </div>
        @else
            <a class="select_dizi prl24 fs_30" href="/mobile/user/address/create" style="padding: .24rem;">
                <ul class="selecwp heiline15 fs_30">
                    <li></li>
                    <li>点击进行地址添加</li>
                </ul>
            </a>
        @endif
    </div>
    <div class="null20"></div>
    <!--  -->
    <div class="Waiter_info w702">
        <ul>
            <li class="clearfix p_t_24 c_000 fs_34 clearfix">
                <span class="fl p_t_15 ">物品数量:</span>
                <p class="waropbox fr clearfix w400">
                <span class="fl calc_box posr clearfix">
                    <input class="j-reduce" type="button" value="-">
                    <input class="j-quantity" type="number" value="1" name="quantity">
                    <input class="j-plus" type="button" value="+">
                </span>
                </p>
            </li>
            <li class="clearfix p_t_24 p_b_24 c_000 fs_34 ">
                <textarea class="b_alle6e6 pExplain" name="content" placeholder="输入你的特殊需求"></textarea>
            </li>
        </ul>
    </div>
    <div class="null20"></div>
    <div class="commonBtn m_b_15 m_t_15 fs_32">
        <a class="show c_fff j-submit" href="javascript:void(0);">确定发布</a>
    </div>
</div>
<!-- 模态框 -->
<div class="mask js_fabu hide">
    <div class="fabumodel allfabubox">
        <ul class="topcontentbox b_b_e5">
            <li>你的需求已发布成功,请等待师傅接接单，师傅将免费为你测量</li>
        </ul>
        <div class="fabottom">
            <a class="c_999 b_r_e5 js_quechild" href="/mobile">确定</a>
            <a class="c_9b34" href="/mobile/user/publish?custom">查看我的发布</a>
        </div>
    </div>
</div>
<!-- 选择服务地址模态框start -->
<div class="mask hide js_maskbox">
    <div class="all_center alwarp">
        <div class="warpsscoll">
            <div class="fs_34 bg_fff heiline11 ulscoll">
                <p class="clearfix p_t_20 p_b_20 b_b_f4 fs_34 prl24">
                    <a href="javascript:;">添加地址</a>
                </p>
                @foreach(auth()->user()->addresses()->with('province', 'city', 'district')->orderBy('default', 'DESC')->get() as $address)
                    <div class="adderss_dao prl24 clearfix posr p_b_18 bg_fff b_b_e5" data-id="{{ $address->id }}">
                        <div class="left_hook fl posa y_center">
                            <span class="login_checkbox show js_checkbox"></span>
                        </div>
                        <div class="addre_name fl">
                            <ul class="fs_30 c_999">
                                <li class="fs_32 c_333 m_t_20 Singleellipsis">
                                    收货人：<i>{{ $address->name }}</i> <i>{{ $address->phone }}</i>
                                </li>
                                <li class="m_t_18 Singleellipsis">{{ $address->province->name }} {{ $address->city->name }} {{ $address->district->name }}</li>
                                <li class="m_t_18 Singleellipsis">{{ $address->street }}</li>
                                <li class="m_t_18 Singleellipsis">楼层信息：{{ $address->floor }}</li>
                                <li class="m_t_18 Singleellipsis">电梯情况：{{ $address->lift ? '有' : '无' }}</li>
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="prl24 clearfix b_t_e5 bg_fff">
            <span class="fl p_b_20 p_t_20 js_c">取消</span>
            <span class="fr p_b_20 p_t_20 js_o">确定</span>
        </div>
    </div>
</div>
<!-- 选择服务地址模态框end -->
</body>
@endsection