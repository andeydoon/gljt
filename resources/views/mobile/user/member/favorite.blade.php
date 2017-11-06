@extends('mobile.layouts.master')

@section('js')
@endsection

@section('script')
@endsection

@section('body')
<body>
<header class="header bg_fff clearfix posr p_t_30 p_b_30 b_b_e5 p_l_24 p_r_24">
    <a class="return fl" href="javascript:window.history.back();"></a>
    <div class="text fl fs_36 t_a_c c_1b1 top_title x_center">我的收藏</div>
    <a class="confirm fr" href="/mobile"></a>
</header>
<div class="">
    <ul>
        @foreach(auth()->user()->favorites as $favorite)
            <li class="shouchang clearfix prl24 pbt24 b_b_e5">
                <a class="show clearfix" href="/mobile/product/{{ $favorite->related_id }}">
                    <div class=" fl leftimgbox">
                        <img src="{{ $favorite->product->galleries()->value('src') }}">
                    </div>
                    <div class="fl rightbox fs_32 c_000">
                        {{ mb_substr($favorite->product->name, 0, 18) }}
                    </div>
                </a>
            </li>
        @endforeach
    </ul>

</div>
</body>
@endsection