@extends('layouts.master')

@section('title', '注册-普通会员')

@section('script')
<script type="text/javascript">
    $('.js-z_clean').click(function () {
        $(this).closest('.z_inputbox').find('input').val('');
    })

    //发送验证码
    var sleep = 60, interval = null;
    window.onload = function () {
        var btn = document.getElementById('btn');
        btn.onclick = function () {
            var $this = this;

            if (!interval) {

                if (!$('.js-mobile').val()) {
                    alert('请输入手机号码');
                    return;
                }

                $.jAjax({
                    url: '/api/captcha/sms_send',
                    type: 'POST',
                    data: {'mobile': $('.js-mobile').val()},
                    success: function (data) {
                        $this.style.backgroundColor = '#f2f2f2';
                        $this.disabled = "disabled";
                        $this.style.cursor = "wait";
                        $this.value = "重新发送 (" + sleep-- + ")";
                        interval = setInterval(function () {
                            if (sleep == 0) {
                                if (!!interval) {
                                    clearInterval(interval);
                                    interval = null;
                                    sleep = 60;
                                    btn.style.cursor = "pointer";
                                    btn.removeAttribute('disabled');
                                    btn.value = "获取验证码";
                                    btn.style.backgroundColor = '';
                                }
                                return false;
                            }
                            btn.value = "重新发送 (" + sleep-- + ")";
                        }, 1000);
                    }
                })
            }
        }
    }

    $('.js-register').click(function () {
        if (!$('.js-agree').is(':checked')) {
            alert('请阅读并接受《门窗卫士用户服务协议》');
            return;
        }

        $.jAjax({
            url: '/api/user/register',
            type: 'POST',
            data: $('.js-step_1 :input').serialize(),
            success: function (data) {

                $('.js-step_1').hide();
                $('.js-step_2').show();

                $('.js-message span').text(data.data.mobile);

                var counttime = $('.js-countdown').text();
                $('.js-countdown').text(counttime--);
                setInterval(function () {
                    if (counttime == 0) {
                        window.location.href = '/';
                    }
                    $('.js-countdown').text(counttime--);
                }, 1000);
            }
        })
    })
</script>
@endsection

@section('content')
<div class="z_body">
    <div class="z_center119">
        <div class="z_bg_img clearfix">
            <div class="fr z_loginbox z_border z_minh363">
                <div class="z_nav z_border_b z_mt10">
                    <ul class="clearfix z_pl30">
                        <li class="active">
                            普通会员
                            <a href="/register?member" title="普通会员" class="z_lianjie"></a>
                        </li>
                        <li>
                            师傅
                            <a href="/register?master" title="师傅" class="z_lianjie"></a>
                        </li>
                        <li>
                            经销商
                            <a href="/register?dealer" title="经销商" class="z_lianjie"></a>
                        </li>
                    </ul>
                </div>
                <div class="z_plr10 js-step_1">
                    <input type="hidden" name="type" value="MEMBER">
                    <div class="z_inputbox z_mt30 z_border clearfix">
                        <label class="fl z_border_r z_w60 tc">
                            手机号
                        </label>
                        <input type="text" name="mobile" placeholder="请输入手机号" class="z_input z_ptb13 js-mobile"/>
                        <label class="fr z_cursor">
                            <img src="/images/icon/tb43.png" height="16" width="16" class="js-z_clean"/>
                        </label>

                    </div>
                    <div class="z_inputbox z_mt20 z_border clearfix">
                        <label class="fl z_border_r z_w60 tc">
                            验证码
                        </label>
                        <input type="text" name="code" placeholder="请输入手机验证码" class="z_input z_ptb13"/>
                        <input id="btn" type="button" value="获取验证码" class="z_verificationCode z_w80 fr"/>
                    </div>
                    <div class="z_inputbox z_mt20 z_border clearfix">
                        <label class="fl z_border_r z_w60 tc">
                            密　码
                        </label>
                        <input type="password" name="password" placeholder="6~20位字母、数字、字符" class="z_input z_ptb13"/>
                    </div>
                    <div class="z_box z_mt20 clearfix">
                        <input type="checkbox" name="agree" class="js-agree" value="1">
                        <span> 我已阅读并接受<span class="z_color_blue">《门窗卫士用户服务协议》</span></span>

                    </div>
                    <div class="z_inputbox z_mt20 z_mb40">
                        <input type="button" value="立即注册" class="z_btn bar-auburn z_font14 js-register"/>
                    </div>
                </div>
                <!--注册成功-->
                <div class="z_mt40 z_plr10 hide js-step_2">
                    <div class="clearfix">
                        <img src="/images/icon/tb44.png" width="18" height="18" class="z_mr10 fl"/>
                        <div class="z_ml30">
                            <p class="z_fontb z_color_3 z_font15 z_mb10 js-message">恭喜，手机<span>-</span>验证成功</p>
                            <p class="z_color_6 z_font14 z_lineh24"><span class="z_color-auburn js-countdown">5</span>秒钟后自动跳转到首页</p>
                        </div>
                        <div class="z_ml30 z_mt20">
                            <a href="/" title="去首页" class="z_btn z_border z_w100 z_color_6 z_font15 z_ptb8">去首页</a>
                        </div>
                    </div>

                </div>
                <!--注册成功 end-->
            </div>
        </div>
    </div>
</div>
@endsection