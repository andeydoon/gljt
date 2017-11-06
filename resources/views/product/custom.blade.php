@extends('layouts.master')

@section('script')
<script type="text/javascript">
    //地址选择 js-z_shouhuo_ul
    $('.js-z_shouhuo_ul li').click(function(){
        $(this).addClass("active").siblings().removeClass("active");
        $('[name="address_id"]').val($(this).data('id'));
    });
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
    //点阴影关闭 js-shadow_off
    $(".js-shadow_off").click(function(){
        $(".js-prompt").addClass("hide");//发布后的提示
        //阴影
        $(this).hide();
    });
    //发布后的提示 js-prompt
    juzhong2(".js-prompt");

    $('.js-z_shouhuo_ul li.active').trigger('click');

    $('.j-submit').click(function () {
        $.jAjax({
            url: '/api/order/custom',
            type: 'POST',
            data: $('.j-form :input').serialize(),
            success: function (data) {
                if (data.status == 'success') {
                    $('.js-prompt').removeClass('hide');
                }
            }
        });
    })

</script>
@endsection

@section('content')
<div class="z_center119 clearfix z_mt30">
    <div class="z_w68p fl j-form">
        <!--商品信息-->
        <div class="z_mb10 clearfix">
            <div class="z_border z_goods_img fl z_mr20">
                <img src="{{ $product->galleries()->value('src') }}"/>
            </div>
            <div style="margin-left: 222px;">
                <div class="z_text z_color_3 z_lineh30 z_font16">
                    <h2 class="z_font16">{{ $product->name }}</h2>
                    <p>{{ $product->describe }}</p>

                    <div class="z_mt10 z_color_6">您发布需求后，我们将免费上门测量<a href="/process" class="z_color_blue z_ml30" title="了解施工流程">了解施工流程&gt;&gt;</a>
                    </div>
                </div>
                <div class="z_inputbox clearfix z_ptb10" style="height: 30px;">
                    <span class="z_lineh30 z_font12 z_color_3 fl z_mr10">物品数量：</span>
                    <div class="fl" style="">
                        <div class="z_border z_jishuan clearfix">
                            <span class="z_border_r js-reduce">-</span>
                            <input type="text" class="js-quantity" name="quantity" value="1">
                            <span class="z_border_l js-plus">+</span>
                        </div>
                    </div>
                </div>
                <div class="z_font12 z_color_3 z_lineh30">
                    发布时间范围：3天内
                </div>
            </div>
        </div>
        <!--商品信息 end-->
        <!--填写信息-->
        <div class="z_user_msg z_user_msg2 z_w100p clearfix z_mt10">
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            @if(isset($productColour))
                <input type="hidden" name="product_colour_id" value="{{ $productColour->id }}">
            @endif
            <div class="z_inputbox clearfix z_p10">
                <label class="z_w120 z_lineh30 z_font12 z_color_3 fl">服务内容详情：</label>
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
                <label class="z_w120 z_lineh30 z_font12 z_color_3 fl"><span class="z_color_red">*</span>选择收货地址：</label>
                <div class="z_ml140" style="">
                    @if(auth()->user()->addresses()->count())
                        <!--收货地址-->
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
                        <!--收货地址 end-->
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
        </div>
        <div class="z_inputbox z_mt20 z_mb20 z_ml180">
            <input type="button" value="发布 " class="z_btn bar-auburn z_font14 z_w160 j-submit"/>
        </div>
        <!--填写信息 end-->
    </div>
    <div class="z_w285p z_border fr z_box-shadow_l">
        <div class="z_plr10 z_mt30 z_mb40">
            <div class="z_mb30">
                <h2 class="z_border_l-blue-4 z_font14 z_fontn z_color_3 z_pl10">1、接单成功,推送信息提醒（双方）</h2>
                <div class="z_ml40 z_font14 z_lineh24 z_color_6 z_text">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin
                        gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor.
                        Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam
                        fermentum, nulla luctus pharetra vulputate, felis tellus mollis orci, sed rhoncus sapien</p>
                </div>
            </div>
            <div class="z_mb30">
                <h2 class="z_border_l-blue-4 z_font14 z_fontn z_color_3 z_pl10">2、服务工程师准备备货.</h2>
                <div class="z_ml40 z_font14 z_lineh24 z_color_6 z_text">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin
                        gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor.
                        Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam
                        fermentum, nulla luctus pharetra vulputate, felis tellus mollis orci, sed rhoncus sapien</p>
                </div>
            </div>
            <div class="z_mb30">
                <h2 class="z_border_l-blue-4 z_font14 z_fontn z_color_3 z_pl10">3、备货完成，发送物流.</h2>
                <div class="z_ml40 z_font14 z_lineh24 z_color_6 z_text">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin
                        gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor.
                        Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam
                        fermentum, nulla luctus pharetra vulputate, felis tellus mollis orci, sed rhoncus sapien</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!--阴影和弹出框-->
<div class="shadow js-shadow_off" style=""></div>
<!--发布成功-->
<div class="z_popup z_w420 bar-white z_pb20 posf animation bounceIn hide js-prompt">
    <div class="z_mt30 z_mb30 tc">
        <img src="/images/icon/tb31.png" width="72" height="72"/>
    </div>
    <div class="tc z_mb30">
        <h2 class="z_fontn z_color_3 z_font16 z_mb10 z_lineh30">您的需求已发布成功，请等待师傅接单</h2>
        <p class="z_color_6 z_font14 z_lineh24">师傅接单后会联系您上门查看</p>
    </div>
    <div class="z_inputbox z_mb20 tc">
        <input type="button" value="确定" class="z_btn bar-auburn z_font14 z_w140 z_mr20" onclick="window.location='/';"/>
        <a href="/user/publish?custom" class="z_btn bar-Grey-ca z_font14 z_w140 ">查看我的定制</a>
    </div>
</div>
<!--发布成功 end-->
@endsection