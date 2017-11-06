@extends('mobile.layouts.master')

@section('script')
<script type="text/javascript">
    var sleep = 60, interval = null;
    window.onload = function () {
        var btn = document.getElementById('btn');
        btn.onclick = function () {
            var $this = this;
            if (!interval) {

                if (!$('.j-mobile').val()) {
                    alert('请输入手机号码');
                    return;
                }

                $.jAjax({
                    url: '/api/captcha/sms_send',
                    type: 'POST',
                    data: {'mobile': $('.j-mobile').val()},
                    success: function (data) {
                        $this.disabled = "disabled";
                        $this.style.cursor = "wait";
                        $this.innerHTML = "重新发送 (" + sleep-- + ")";
                        interval = setInterval(function () {
                            if (sleep == 0) {
                                if (!!interval) {
                                    clearInterval(interval);
                                    interval = null;
                                    sleep = 60;
                                    btn.style.cursor = "pointer";
                                    btn.removeAttribute('disabled');
                                    btn.innerHTML = "发送验证码";
                                    btn.style.backgroundColor = '';
                                }
                                return false;
                            }
                            btn.innerHTML = "重新发送 (" + sleep-- + ")";
                        }, 1000);
                    }
                });
            }
        }
    };

    $('.j-submit').click(function () {
        $.jAjax({
            url: '/api/user/register',
            type: 'POST',
            data: $('.j-form :input').serialize(),
            success: function (data) {
                if (data.status == 'success') {
                    alert('注册成功');
                    window.location.href = '/mobile';
                }
            }
        })
    })
</script>
@endsection

@section('body')
<body class="bg_f2f">
<div class="p_b_100 bg_fff">
    <header class="header bg_fff clearfix posr p_t_30 p_b_30 b_b_e5 p_l_24 p_r_24">
        <a class="return fl" href="javascript:window.history.back();"></a>
        <div class="text fl fs_36 t_a_c c_1b1 top_title x_center">普通会员</div>
        <a class="" href="##"></a>
    </header>
    <ul class="fs_34 prl24 bg_fff j-form">
        <input type="hidden" name="type" value="MEMBER">
        <li class="clearfix p_t_30 p_b_30 b_b_f4 m_t_50">
            <input class="fl heiline13 input_phone c_999 fs_34 j-mobile" name="mobile" type="text" placeholder="请输入手机号">
            <span id="btn" class=" fr heiline13 yanzenma t_a_r c_999 bleft1">发送验证码</span>
        </li>
        <li class="clearfix p_t_30 p_b_30 b_b_f4 m_t_36">
            <input class="fl c_999 fs_34" name="code" type="text" placeholder="短信验证码">
        </li>
        <li class="clearfix p_t_30 p_b_30 b_b_f4 m_t_36">
            <input class="fl c_999 fs_34" name="password" type="password" placeholder="请输入密码">
        </li>
    </ul>
    <a class="commonBtn m_t_160 fs_36 j-submit" href="javascript:void(0);">完成</a>
</div>
</body>
@endsection