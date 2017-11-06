@extends('user.layouts.master-master')

@section('script')
<script type="text/javascript">
    $('.js-submit').click(function () {
        $.jAjax({
            url: '/api/user/password',
            type: 'POST',
            data: $('.js-form :input').serialize(),
            success: function (data) {
                alert('密码修改成功');
                window.location.reload();
            }
        })
    })
</script>
@endsection

@section('uc_content')
<div class="z_w82p fr z_minh640">
    @include('user.layouts.card-user')
    <!--修改密码 -->
    <div class="z_mt50 clearfix">
        <div class="z_user_msg z_user_msg2 clearfix z_mlrauto js-form">
            <div class="z_inputbox clearfix z_mb10">
                <label class="z_w120 z_lineh30 z_font14 z_color_3 fl">旧密码：</label>
                <div class="fl" style="">
                    <input type="password" name="password_old" placeholder="" class="z_input z_border z_ptb7">
                </div>
            </div>
            <div class="z_inputbox clearfix z_mb10">
                <label class="z_w120 z_lineh30 z_font14 z_color_3 fl">新密码：</label>
                <div class="fl" style="">
                    <input type="password" name="password" placeholder="" class="z_input z_border z_ptb7">
                </div>
            </div>
            <div class="z_inputbox clearfix z_mb10">
                <label class="z_w120 z_lineh30 z_font14 z_color_3 fl">确认新密码：</label>
                <div class="fl" style="">
                    <input type="password" name="password_confirmation" placeholder="" class="z_input z_border z_ptb7">
                </div>
            </div>
            <div class="z_mt40 z_mb20 tc">
                <input type="submit" value="确认"  class="z_btn bar-auburn z_font12 z_w100 z_ptb9 js-submit"/>
            </div>
        </div>
    </div>
    <!--修改密码 end-->
</div>
@endsection