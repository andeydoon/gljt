@extends('mobile.layouts.master')


@section('body')
<body>
<header class="header bg_fff clearfix posr p_t_30 p_b_30 b_b_e5 p_l_24 p_r_24">
    <a class="return fl" href="javascript:window.history.back();"></a>
    <div class="text fl fs_36 t_a_c c_1b1 top_title x_center">我的积分</div>
    <a class="confirm fr" href="/mobile"></a>
</header>
<div class="jfeng t_a_c">
    <span class="">{{ auth()->user()->credits()->sum('score') }}</span><span>分</span>
</div>
<div class="p_t_70">
    <ul class="w702">
        <li class="fs_30 c_666 t_a_c p_b_30 b_b_e5">积分明细</li>
        @foreach(auth()->user()->credits as $credit)
            <li class="pbt_20 clearfix b_b_e5">
                <div class="timeorname fl">
                    <p class="fs_34 c_1a1a">{{ $credit->item }}</p>
                    <p class="fs24 c_808 m_t_15">{{ $credit->created_at }}</p>
                </div>
                <div class="bluejifen fr fs_36 c_298 p_t_18 p_b_18">
                    {{ $credit->score }}
                </div>
            </li>
        @endforeach
    </ul>
</div>
</body>
@endsection