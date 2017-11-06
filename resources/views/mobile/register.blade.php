@extends('mobile.layouts.master')

@section('body')
<body class="bg_f2f">
<header class="header bg_fff clearfix posr p_t_30 p_b_30 b_b_e5 p_l_24 p_r_24">
    <a class="return fl" href="javascript:window.history.back();"></a>
    <div class="text fl fs_36 t_a_c c_1b1 top_title x_center">注册</div>
    <a class="" href="##"></a>
</header>
<ul class="fs_34 bg_fff">
    <li class="clearfix  b_b_f4 prl24">
        <a class="c_333 a_linkzhuce p_t_30 p_b_30" href="/mobile/register?member">普通会员</a>
    </li>
    <li class="clearfix posr  b_b_f4 prl24">
        <a class="c_333 a_linkzhuce p_t_30 p_b_30" href="/mobile/register?master">师傅</a>
    </li>
    <li class="clearfix posr  b_b_f4 prl24">
        <a class="c_333 a_linkzhuce p_t_30 p_b_30" href="/mobile/register?dealer">经销商</a>
    </li>
</ul>
</body>
@endsection