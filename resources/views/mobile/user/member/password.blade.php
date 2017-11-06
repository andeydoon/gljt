@extends('mobile.layouts.master')

@section('script')
<script type="text/javascript">
    $('.j-submit').click(function () {
        $.jAjax({
            url: '/api/user/password',
            type: 'POST',
            data: $('.j-form :input').serialize(),
            success: function (data) {
                alert('密码修改成功');
                window.location.href = '/mobile';
            }
        })
    })
</script>
@endsection

@section('body')
<body class="bg_f2f">
<header class="header bg_fff clearfix posr p_t_30 p_b_30 b_b_e5 p_l_24 p_r_24">
    <a class="return fl" href="##"></a>
    <div class="text fl fs_36 t_a_c c_1b1 top_title x_center">修改密码</div>
    <a class="fr confirm" href="##"></a>
</header>
<ul class="clearfix xigaimima bg_fff j-form">
    <li class="b_b_e5 prl24">
        <input class="inputsetpass" name="password_old" type="text" placeholder="当前密码">
    </li>
    <li class="b_b_e5 prl24">
        <input class="inputsetpass" name="password" type="text" placeholder="新密码">
    </li>
    <li class="b_b_e5 prl24">
        <input class="inputsetpass" name="password_confirmation" type="text" placeholder="确认密码">
    </li>
</ul>
<div class="tishitext fs_24 c_333 t_a_c m_t_60">
    密码长度8-16位，数字、英文、符号至少包含两种
</div>
<div class="m_t_60">
    <div class="p_t_15 p_b_15 fs_32">
        <a class="c_fff show commonBtn j-submit" href="javascript:void(0);">
            确定
        </a>
    </div>
</div>
</body>
@endsection