@extends('mobile.layouts.master')

@section('body')
<body class="bg_f2f">
<header class="header bg_fff clearfix posr p_t_30 p_b_30 b_b_e5 p_l_24 p_r_24">
    <a class="return fl" href="##"></a>
    <div class="text fl fs_36 t_a_c c_1b1 top_title x_center">设置</div>
    <a class="confirm fr" href="##"></a>
</header>
<div class="bg_fff">
    <ul>
        <li class="b_b_e5 prl24">
            <a class="s_option s_option1 c_333 fs_30" href="/mobile/user/address">
                <img src="/packages/mobile/images/img/im23.png">
                <span class="p_l_24">收货地址</span>
            </a>
        </li>
        <li class="b_b_e5 prl24">
            <a class="s_option s_option2 c_333 fs_30" href="/mobile/user/password">
                <img src="/packages/mobile/images/img/im24.png">
                <span class="p_l_24">修改密码</span>
            </a>
        </li>
        <li class="b_b_e5 prl24">
            <a class="s_option s_option3 c_333 fs_30" href="/mobile/user/feedback">
                <img src="/packages/mobile/images/img/im25.png">
                <span class="p_l_24">意见反馈</span>
            </a>
        </li>
        <li class="b_b_e5 prl24">
            <a class="s_option4 c_333 fs_30" href="javascript:;">
                <img src="/packages/mobile/images/img/im22.png">
                <span class="p_l_24">客服热线</span>
                <span class="fr">400-888-3512</span>
            </a>
        </li>
    </ul>

</div>
<div class="m_t_120">
    <div class="p_t_15 p_b_15 fs_32">
        <a class="c_fff show commonBtn bg_b3b3" href="/mobile/logout">
            退出登录
        </a>
    </div>
</div>
</body>
@endsection