@extends('user.layouts.master-member')

@section('script')
<script type="text/javascript">
    //出显编辑界面 js-bianji_btn
    $(".js-bianji_btn").click(function(){
        $(".js-bianji").removeClass("hide");//显示编辑界面
        $(".js-msbox").addClass("hide");//隐藏显示界面
        $(this).addClass("hide");
    });
    //取消编辑 js-cancel
    $(".js-cancel").click(function(){
        $(".js-bianji_btn").removeClass("hide");//编辑按钮
        $(".js-msbox").removeClass("hide");//显示显示界面
        $(".js-bianji").addClass("hide");//隐藏编辑界面
    });

    $('.j-submit').click(function () {
        $.jAjax({
            url: '/api/user/profile',
            type: 'POST',
            data: $('.j-form :input').serialize(),
            success: function (data) {
                alert('资料修改成功');
                window.location.reload();
            }
        })
    })
</script>
@endsection

@section('uc_content')
<div class="z_w82p fr z_minh640">
    @include('user.layouts.card-user')
    <!--标题-->
    <div class="z_border_b">
        <div class="z_border_auburn-l-4 z_pl20 z_lineh30 z_font14 z_mt15 z_mb5 ">
            我的资料
            <span class="fr z_mr20 z_cursor js-bianji_btn">
                <img src="/images/icon/tb49.png" width="14" height="14" class="z_mr10">编辑
            </span>
        </div>
    </div>
    <!--标题 end-->
    <!--我的资料-->
    <div class="z_user_msg z_user_msg2 z_w100p clearfix z_mt20 js-msbox">
        <div class="z_inputbox clearfix z_mb10">
            <label class="z_w120 z_lineh30 z_font14 z_color_3 fl">真实姓名：</label>
            <div class="fl z_lineh30 z_font14 z_color_3" style="">
                {{ auth()->user()->profile->realname }}
            </div>
        </div>
        <div class="z_inputbox clearfix z_mb10">
            <label class="z_w120 z_lineh30 z_font14 z_color_3 fl">性　　别：</label>
            <div class="fl z_lineh30 z_font14 z_color_3" style="">
                <?php $sexes = ['未知', '男', '女'] ?>
                {{ $sexes[auth()->user()->profile->sex] }}
            </div>
        </div>
        <div class="z_inputbox clearfix z_mb10">
            <label class="z_w120 z_lineh30 z_font14 z_color_3 fl">联系电话：</label>
            <div class="fl z_lineh30 z_font14 z_color_3" style="">
                {{ auth()->user()->mobile }}
            </div>
        </div>
        <div class="z_inputbox clearfix z_mb10">
            <label class="z_w120 z_lineh30 z_font14 z_color_3 fl">个性签名：</label>
            <div class="z_ml140 z_lineh30 z_font14 z_color_3" style="">
                {{ auth()->user()->profile->signature }}
            </div>
        </div>
    </div>
    <!--我的资料 end-->
    <!--编辑我的资料-->
    <div class="z_user_msg z_user_msg2 z_w100p clearfix z_mt20 hide js-bianji j-form">
        <div class="z_inputbox clearfix z_mb10">
            <label class="z_w120 z_lineh30 z_font14 z_color_3 fl">真实姓名：</label>
            <div class="fl" style="">
                <input type="text" name="realname" placeholder="" class="z_input z_border z_ptb7" value="{{ auth()->user()->profile->realname }}">
            </div>
        </div>
        <div class="z_inputbox clearfix z_mb10">
            <label class="z_w120 z_lineh30 z_font14 z_color_3 fl">性　　别：</label>
            <div class="fl z_lineh30 z_font14 z_color_3" style="">
                <span class="z_mr10">
                    <input type="radio" name="sex" value="1"@if(auth()->user()->profile->sex == 1) checked="checked"@endif>
                    男
                </span>
                <span class="z_mr10">
                    <input type="radio" name="sex" value="2"@if(auth()->user()->profile->sex == 2) checked="checked"@endif>
                    女
                </span>
            </div>
        </div>
        <div class="z_inputbox clearfix z_mb10">
            <label class="z_w120 z_lineh30 z_font14 z_color_3 fl">个性签名：</label>
            <div class="z_ml140" style="width: 266px;">
                <div class="z_text-wrap z_border z_p10 ">
                    <textarea class="z_textarea z_h100" name="signature" placeholder="请输入您的性签名">{{ auth()->user()->profile->signature }}</textarea>
                </div>
            </div>
        </div>
        <div class="z_inputbox z_mt20 z_mb20 z_ml180">
            <input type="submit" value="保存" class="z_btn bar-auburn z_font12 z_w100 z_ptb7 z_mr20 j-submit"/>
            <input type="button" value="取消" class="z_btn bar-Grey-ca z_font12 z_w100 z_ptb7 js-cancel"/>
        </div>
    </div>
    <!--编辑我的资料 end-->
</div>
@endsection