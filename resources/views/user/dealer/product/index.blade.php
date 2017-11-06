@extends('user.layouts.master-dealer')

@section('script')
<script type="text/javascript">
    $('.js-z_select_ul li').click(function () {
        window.location = '/user/product?status=' + $(this).data('value');
    })

    $('.j-status a').click(function () {
        var $this = $(this);
        $.jAjax({
            url: '/api/user/product/' + $this.data('id') + '/patch',
            type: 'PATCH',
            data: {status: $this.data('value')},
            success: function (data) {
                if (data.status == 'success') {
                    alert($this.text() + '成功');
                    window.location.reload();
                }
            }
        });
    })
</script>
@endsection

@section('uc_content')
<div class="z_w82p fr z_minh640">
    @include('user.layouts.card-user')
    <!--标题-->
    <div class="z_border_b">
        <div class="z_lineh30 z_font14 z_mt15 z_mb5 ">
            我的产品
            <div class="fr clearfix z_mt5 ">
                <a href="/user/product/create" title="发布单个产品" class="bar-auburn z_color_white z_plr10 z_ptb3 z_font12 z_mr10">发布单个产品</a>
                <a href="/user/combine/create" title="发布组合产品" class="bar-auburn z_color_white z_plr10 z_ptb3 z_font12 z_mr10">发布组合产品</a>
            </div>

        </div>
    </div>
    <!--标题 end-->
    <!--我的产品-->
    <div class="z_mb10">
        <div class="clearfix z_mt10 z_mb20">
            <div class="z_inputbox clearfix fl z_mt5">
                <label class="z_w60 z_lineh30 z_font14 z_color_3 fl z_mr10">上架状态</label>
                <div class="fl" style="">
                    <div class="fl bar-white z_border z_mr10" style="width: 120px;">
                        <input type="hidden" name="" placeholder="" class="z_input "/>
                        <div class="z_select_div  js-z_select_div">
                            <p>{{ !$status ? '所有产品' : $product_statuses[$status] }}</p>
                            <ul class="hide js-z_select_ul">
                                <li data-value="">所有产品</li>
                                @foreach($product_statuses as $key=>$value)
                                    <li data-value="{{ $key }}">{{ $value }}</li>
                                @endforeach
                            </ul>
                            <span class="z_tubiao js-z_tubiao">
                                <!--图标-->
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="z_form z_border z_w360  posr fr">
                <div class="z_inputbox clearfix posr">
                    <span class="z_border_r z_ml10 z_pr10">
                        <img src="/images/icon/tb26.png" width="18" height="19" />
                    </span>
                    <input type="text"  placeholder="产品名称" class="z_input z_w240"/>
                    <button class="z_w74 tc bar-Grey-f8 z_butn z_font14 z_color_6 z_border_l-i z_cursor">
                        搜索
                    </button>
                </div>
            </div>
        </div>
        <!--列表-->
        <div class="z_mb10">
            @foreach($products as $product)
                <div class="z_border clearfix bar-Grey-fa z_mb10 j-product">
                    <div class="z_w36p fl">
                        <div class="clearfix z_p10 z_h74 over_h z_border_r">
                            <div class="z_w100 z_h74 z_mr10 fl">
                                <div class="z_img_back ">
                                    <img src="{{ $product->galleries()->value('src') }}" />
                                </div>
                            </div>
                            <div class="fl z_font14 z_color_3">
                                {{ $product->name }}
                            </div>
                        </div>
                    </div>
                    <div class="z_w36p fl">
                        <div class="clearfix z_p10 z_h74 over_h z_border_r z_font14 z_color_3 z_lineh74 tc">
                            @if($product->colours()->count())
                                价格范围：<span class="z_fontb z_color-orange">￥{{ $product->colours()->orderBy('price', 'ASC')->value('price') }}~{{ $product->colours()->orderBy('price', 'DESC')->value('price') }}</span>
                            @else
                                价格：<span class="z_fontb z_color-orange">￥{{ $product->price }}</span>

                            @endif
                        </div>
                    </div>
                    <div class="z_w28p fl">
                        <div class="clearfix z_p10 z_h74 over_h  z_font12 z_color_3 tc">
                            @if($product->status==1)
                                <div class="z_lineh24">
                                    <a href="/product/{{ $product->id }}" title="查看" class="z_color_3">查看</a>
                                </div>
                            @endif
                            <div class="z_lineh24">
                                <a href="/user/product/{{ $product->id }}/edit" title="编辑" class="z_color_3">编辑</a>
                            </div>
                            <div class="z_lineh24 j-status">
                                @if($product->status==-1)
                                    <a href="javascript:void(0);" title="提审" class="z_color_3" data-id="{{ $product->id }}" data-value="0">提审</a>
                                @elseif($product->status==0)
                                    待审
                                @elseif($product->status==1)
                                    <a href="javascript:void(0);" title="下架" class="z_color_3" data-id="{{ $product->id }}" data-value="3">下架</a>
                                @elseif($product->status==2)
                                    <a href="javascript:void(0);" title="下架" class="z_color_3" data-id="{{ $product->id }}" data-value="0">重审</a>
                                @elseif($product->status==3)
                                    <a href="javascript:void(0);" title="下架" class="z_color_3" data-id="{{ $product->id }}" data-value="1">上架</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <!--列表 end-->
    </div>
    <!--我的产品 end-->
</div>
@endsection