@extends('mobile.layouts.master')

@section('body')
<body class="bg_fff">
<header class="header bg_fff clearfix posr p_t_30 p_b_30 b_b_e5 p_l_24 p_r_24">
    <a class="return fl" href="javascript:window.history.back();"></a>
    <div class="text fl fs_36 t_a_c c_1b1 top_title x_center">门窗产品</div>
    <a class="confirm fr" href="/mobile"></a>
</header>
<div class="fs_30 c_808 productnav clearfix b_b_e5">
    @foreach($categories as $category)
        <a class="option fl {{ $category_parent->id==$category->id ? 'bder_active' : '' }}" href="/mobile/product?category_id={{ $category->id }}"> {{ $category->name }}</a>
    @endforeach
</div>
<div class="productType fs_28 p_l_24">
    <span class="c_808">产品类型：</span>
    @foreach($category_parent->children as $child)
        <a class="c_333" href="/mobile/product?category_id={{ $child->id }}">{{ $child->name }}</a>
    @endforeach
</div>
<div class="w702 p_b_20">
    <div class="contentbox clearfix">
        <ul>
            <?php $i = 1; ?>
            @foreach($products as $product)
                <li class="{{ $i%2 ? 'fl' : 'fr' }} p_b_24">
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
</body>
@endsection