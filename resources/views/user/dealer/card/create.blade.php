@extends('user.layouts.master-dealer')

@section('script')
<script type="text/javascript">
    $('.j-submit').click(function () {
        $.jAjax({
            url: '/api/user/card',
            type: 'POST',
            data: $('.j-form :input').serialize(),
            success: function (data) {
                if (data.status == 'success') {
                    alert('银行卡添加成功');
                    window.location = '/user/card';
                }
            }
        });
    });
</script>
@endsection

@section('uc_content')
<div class="z_w82p fr z_minh640">
    <!--导航-->
    <div class="clearfix">
        <div class="z_font14 z_lineh40">
            <a href="/user/coin" title="余额" class="z_color_6">余额</a>
            &gt;
            <a href="/user/card" title="银行卡管理" class="z_color_6">银行卡管理</a>
        </div>

    </div>
    <!--导航 end-->
    <!--添加银行卡 -->
    <div class="z_user_msg z_user_msg2 clearfix z_mt30 j-form">
        <div class="z_inputbox clearfix z_mb20">
            <label class="z_w120 z_lineh30 z_font14 z_color_3 fl">收款人姓名</label>
            <div class="fl" style="">
                <input type="text" name="name" placeholder="" class="z_input z_border z_ptb7 z_w180">
            </div>
        </div>
        <div class="z_inputbox clearfix z_mb20">
            <label class="z_w120 z_lineh30 z_font14 z_color_3 fl">银行卡号</label>
            <div class="fl" style="">
                <input type="text" name="number" placeholder="" class="z_input z_border z_ptb7 z_w180">
            </div>
        </div>
        <div class="z_inputbox clearfix z_mb20">
            <label class="z_w120 z_lineh30 z_font14 z_color_3 fl">所属银行</label>
            <div class="fl" style="">
                <div class="bar-white z_border z_mr10" style="width: 180px;">
                    <input type="hidden" name="bank" placeholder="" class="z_input ">
                    <div class="z_select_div js-z_select_div">
                        <p>选择银行</p>
                        <ul class="hide js-z_select_ul">
                            <li data-id="中国银行">中国银行</li>
                            <li data-id="中国建设银行">中国建设银行</li>
                            <li data-id="中国工商银行">中国工商银行</li>
                            <li data-id="中国农业银行">中国农业银行</li>
                            <li data-id="招商银行">招商银行</li>
                        </ul>
                        <span class="z_tubiao js-z_tubiao">
                            <!--图标-->
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="z_mt40 z_mb20 tc">
            <input type="submit" value="确认 " class="z_btn bar-auburn z_font12 z_w100 z_ptb7 j-submit"/>
        </div>
    </div>
    <!--添加银行卡 end-->
</div>
@endsection