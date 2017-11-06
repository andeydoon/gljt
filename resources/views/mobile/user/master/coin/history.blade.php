@extends('mobile.layouts.master')

@section('body')
<body class="bg_fff">
<header class="header bg_fff clearfix posr p_t_30 p_b_30 b_b_e5 p_l_24 p_r_24">
    <a class="return fl" href="javascript:window.history.back();"></a>
    <div class="text fl fs_36 t_a_c c_1b1 top_title x_center">交易记录</div>
    <a class="confirm fr" href="/mobile"></a>
</header>
<div class="bg_fff js_waropjilu">
    <!-- 提现记录 -->
    <ul class="w702">
        @foreach(auth()->user()->coins as $coin)
            <li class="pbt_20 clearfix b_b_e5">
                <div class="timeorname fl">
                    <p class="fs_34 c_1a1a">{{ $coin->remark }}</p>
                    <p class="fs24 c_808 fs_26 m_t_15">{{ $coin->created_at }}</p>
                </div>
                <div class="bluejifen fr fs_36 c_298 p_t_18 p_b_18">
                    已通过
                </div>
            </li>
        @endforeach
    </ul>
</div>
</body>
@endsection