@extends('mobile.layouts.master')

@section('body')
<body>
<header class="header bg_fff clearfix posr p_t_30 p_b_30 b_b_e5 p_l_24 p_r_24">
    <a class="return fl" href="javascript:window.history.back();"></a>
    <div class="text fl fs_36 t_a_c c_1b1 top_title x_center">余额</div>
    <a class="fr fs_30 p_t_3" href="/mobile/user/coin/history">交易记录</a>
</header>
<div class="fs_36 c_1b1 p_t_85 t_a_c">
    我的余额
</div>
<div class="fs_70 c_298 m_t_60 t_a_c">
    ¥{{ auth()->user()->coins()->sum('amount') }}
</div>
<div class="p_t_15 p_b_15 fs_32 bg_fff m_t_120">
    <a class="c_fff show commonBtn" href="##">
        提现
    </a>
</div>
</body>
@endsection