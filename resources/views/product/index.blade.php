@extends('layouts.master')

@section('script')
<script type="text/javascript">
    //选择条件 js-z_menu2
    $(".js-z_menu2 li").click(function(){
        var _index =$(this).index();
        $(this).addClass("active").siblings().removeClass("active");
        $(".z_box4").hide().eq(_index).show();
        var h =$(".z_box4").eq(_index).height();
        if(h>160){
            $(this).parent().parent().css("height",h)
        }
        //console.log(h);
    });
    //二级条件选择 js-z_ul_list
    $(".js-z_ul_list li").click(function(){
        window.location = '/product?category_id='+$(this).data('category');
    });

    var $category = $('.z_box4 li[data-category="{{ old('category_id') }}"]');
    var $category_parent = $('.js-z_menu2 [data-category_parent="{{ old('category_id') }}"]');
    if ($category.size()) {
        $category.addClass('active');
        var $category_parent = $category.closest('.z_box4');
        $category_parent.show()
        $('li[data-category_parent="' + $category_parent.data('category_parent') + '"]').addClass('active');
    } else if ($category_parent.size()) {
        $category_parent.trigger('click');
    } else {
        $('.js-z_menu2 li:first').trigger('click');
    }
</script>
@endsection

@section('content')
<div class="z_center119  z_mt30">
    <div class="z_border">
        @if(isset($category))
            <div class="z_border_b clearfix">
                <div class="fl z_font14 z_lineh40 z_ml20">
                    类型 &gt;
                    @if($category->parent)
                        <a href="/product?category_id={{ $category->parent->id }}" class="z_color_6">{{ $category->parent->name }}</a>
                        &gt;
                    @endif
                </div>
                <div class="fl z_mt10 z_ml10 clearfix">
                    <div class="z_jiguo fl z_mr10">
                        {{ $category->name }}
                    </div>
                </div>
                <div class="fl z_ml20 z_font14 z_lineh40 z_color_9">
                    共 {{ $products->total() }} 结果
                </div>
            </div>
        @endif
        <!--选择条件-->
        <div class="clearfix">
            <div class="z_border_r fl bar-Grey-f8">
                <ul class="z_menu2 js-z_menu2">
                    @foreach($categories as $category)
                        <li data-category_parent="{{ $category->id }}">{{ $category->name }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="fl">
                @foreach($categories as $category)
                    <div class="z_box4" data-category_parent="{{ $category->id }}">
                        <ul class="clearfix z_ul_list js-z_ul_list">
                            @foreach($category->children as $child)
                                <li data-category="{{ $child->id }}">{{ $child->name }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
        <!--选择条件 end-->
    </div>

</div>
<div class="z_center119">
    <div class="z_mtb20 clearfix"></div>
    <!--列表-->
    <div class="z_mb20">
        <ul class="clearfix z_ul_4">
            @foreach($products as $product)
                <li>
                    <div class="posr" style="height: 100%;">
                        <div class="z_img_back">
                            <img src="{{ $product->galleries()->value('src') }}" />
                            <a href="/product/{{ $product->id }}" title="{{ $product->name }}" class="z_lianjie"></a>
                            <div class="z_title_y">
                                <p class="z-ellipsis z_font14">{{ $product->name }}</p>
                            </div>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
    <!--列表 end-->
    <!--页数-->
    <div class="pageControl clearfix tc z_m50p z_mlrauto z_mb50" id="" role="page-box">
        {{ $products->appends($queries)->links() }}
    </div>
    <!--页数 end-->
</div>
@endsection