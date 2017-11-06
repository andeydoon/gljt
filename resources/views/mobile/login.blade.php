@extends('mobile.layouts.master')

@section('body')
<body>
<header class="header posr p_t_30 p_b_30 b_b_e5">
    <div class="text fs_38 t_a_c c_1b1">登录</div>
</header>
<div class="logobox">
    <img src="/packages/mobile/images/img/logo.png">
</div>
<!-- 登录 -->
<form class="z_plr10" method="post">
    {{ csrf_field() }}
    <ul class="parentinput fs_30">
        <li class="clearfix p_t_15 p_b_15 b_b_f4">
            <span class="fl ic_a"></span>
            <input class="name_in p_t_8 p_b_8 fs_30" name="mobile" type="text" value="{{ old('mobile') }}">
        </li>
        @if ($errors->has('mobile'))
            <li class="clearfix p_t_15 p_b_15">{{ $errors->first('mobile') }}</li>
        @endif
        <li class="clearfix posr m_t_70 p_t_15 p_b_15 b_b_f4">
            <span class="fl ic_b"></span>
            <input id="inpp" class="pass_in p_t_8 p_b_8 fs_30" name="password" type="password">
            <span class="fr y_center openeye js_eye"></span>
        </li>
        @if ($errors->has('password'))
            <li class="clearfix p_t_15 p_b_15">{{ $errors->first('password') }}</li>
        @endif
    </ul>
    <button type="submit" class="logon fs_36 bg_942 c_fff t_a_c show">登录</button>
</form>
<div class="otherlogin clearfix fs_30 c_666 p_t_40">
    <a class="fl" href="/mobile/register">注册</a>
    <a class="fr" href="#">忘记密码</a>
</div>
</body>
@endsection