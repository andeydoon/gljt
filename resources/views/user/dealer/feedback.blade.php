@extends('user.layouts.master-dealer')

@section('script')
<script type="text/javascript">
    $('.js-submit').click(function () {
        $.jAjax({
            url: '/api/feedback',
            type: 'POST',
            data: $('.js-form :input').serialize(),
            success: function (data) {
                alert('反馈提交成功');
                window.location.reload();
            }
        })
    })
</script>
@endsection

@section('uc_content')
<div class="z_w82p fr z_minh640">
    <!--标题-->
    <div class="z_border_b">
        <div class="z_pl20 z_lineh30 z_font14 z_mt10 z_mb5 ">
            投诉建议
        </div>
    </div>
    <!--标题 end-->
    <!--意见反馈 -->
    <div class="clearfix">
        <div class="z_user_msg z_user_msg2 clearfix z_w100p js-form">
            <div class="z_inputbox clearfix z_mb10">
                <div class="z_lineh30 z_font14 z_mt15 z_mb5 ">
                    您有什么想对我们说
                </div>
                <div class="z_w64p" style="">
                    <div class="z_text-wrap z_border z_p10 ">
                        <textarea class="z_textarea z_h120" name="content" placeholder="你们的服务很好，我很满意，希望再接再厉"></textarea>
                    </div>
                </div>
            </div>
            <div class="z_inputbox clearfix z_mt40">
                <div class="z_lineh30 z_font14 z_mt15 z_mb5 ">
                    联系方式
                </div>
                <div class="clearfix" style="">
                    <input type="text" name="phone" placeholder="请填写您的手机号码" class="z_input z_border z_ptb7 z_w130 fl z_mr10">
                    <div class="z_lineh30 z_font12 z_color_9 fl">留下您的联系方式，以便更好的为您服务</div>
                </div>
            </div>
            <div class="z_mt40 z_mb20 z_ml134">
                <input type="submit" value="确认"  class="z_btn bar-auburn z_font12 z_w120 z_ptb9 js-submit"/>
            </div>
        </div>
    </div>
    <!--意见反馈 end-->
</div>
@endsection