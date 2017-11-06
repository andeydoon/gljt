@extends('layouts.master')

@section('script')
<script type="text/javascript">
</script>
@endsection

@section('content')
    <div class="z_border_b z_border_t z_mt30 bar-Grey-fb">
        <div class="z_center119 clearfix">
            <div class="fl z_font14 z_lineh40">
                搜索关键词 &gt;
            </div>
            <div class="fl z_mt10 z_ml10 clearfix">
                <div class="z_jiguo fl z_mr10">
                    {{ old('q') }}
                </div>
            </div>
            <div class="fl z_ml20 z_font14 z_lineh40 z_color_9">
                共 {{ $products->total() }} 结果
            </div>
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
        <div class="pageControl clearfix tc z_m50p z_mlrauto z_mb50" id="" role="page-box">
            {{ $products->appends($queries)->links() }}
        </div>
    </div>

@endsection