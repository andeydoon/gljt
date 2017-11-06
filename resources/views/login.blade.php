@extends('layouts.master')

@section('title', '登录')

@section('script')
<script type="text/javascript">
    $('.js-z_clean').click(function () {
        $(this).closest('.z_inputbox').find('input').val('');
    })
</script>
@endsection

@section('content')
<div class="z_body">
    <div class="z_center119">
        <div class="z_bg_img clearfix">
            <div class="fr z_loginbox z_border z_minh363">
                <h2 class="z_border_b clearfix z_font16 ">
                    <spsn class="z_color-auburn">用户登录</spsn>
                    <span class="fr z_fontn z_font14">
                    没有账号？ 直接<a href="/register"><span class="z_cursor z_color-auburn">注册</span></a>
                    <img src="/images/icon/tb5.png" width="8" height="7"/>
                </span>
                </h2>
                <form class="z_plr10" method="post">
                    {{ csrf_field() }}
                    <div class="z_inputbox z_mt30 z_border clearfix">
                        <label class="fl z_border_r">
                            <img src="/images/icon/tb6.png"/>
                        </label>
                        <input type="text" name="mobile" placeholder="手机号码" class="z_input z_ptb13" value="{{ old('mobile') }}"/>
                        <label class="fr z_cursor">
                            <img src="/images/icon/tb43.png" height="16" width="16" class="js-z_clean"/>
                        </label>
                    </div>
                    @if ($errors->has('mobile'))
                        <div>{{ $errors->first('mobile') }}</div>
                    @endif
                    <div class="z_inputbox z_mt20 z_border clearfix">
                        <label class="fl z_border_r">
                            <img src="/images/icon/tb7.png"/>
                        </label>
                        <input type="password" name="password" placeholder="6~20位字母、数字、字符" class="z_input z_ptb13"/>
                    </div>
                    @if ($errors->has('password'))
                        <div>{{ $errors->first('password') }}</div>
                    @endif
                    <div class="z_box z_mt20 clearfix">
                        <input type="checkbox" name="remember" class="js-z_remember" {{ old('remember') ? 'checked' : '' }}> <span>下次自动登录</span>
                        <a href="ForgotPassword.html" title="密码" class="fr  z_color_9">忘记密码？</a>
                    </div>
                    <div class="z_inputbox z_mt20">
                        <input type="submit" value="立即登录 " class="z_btn bar-auburn z_font14"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection