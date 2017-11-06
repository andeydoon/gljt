@extends('user.layouts.master-master')

@section('css')
<link rel="stylesheet" href="/css/jquery.fileupload.css">
@endsection

@section('js')
<script type="text/javascript" src="/js/jquery.ui.widget.js"></script>
<script type="text/javascript" src="/js/jquery.iframe-transport.js"></script>
<script type="text/javascript" src="/js/jquery.fileupload.js"></script>
<script type="text/javascript" src="/js/template.js"></script>
@endsection

@section('script')
<script type="text/javascript">
    $('input:file').fileupload({
        url: '/api/upload',
        headers: {'X-CSRF-TOKEN': Laravel.csrfToken},
        formData: {},
        done: function (e, data) {
            $.each(data.result.data.files, function (index, file) {
                var $this = $(e.target);
                $('[name="' + index + '"]').prev().hide().parent().parent().append('<div class="z_img_fix z_img_fix2 fl z_mb10 z_mr10"><img src="' + file + '"/><input type="hidden" name="pictures[]" value="' + file + '"><span class="z_off2 js-z_off"></span></div>')
            });
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $(this).prev().show().text('上传中(' + progress + '%)').prev().addClass('hide');
        }
    });

    $('.j-submit').click(function () {
        $.jAjax({
            url: '/api/user/order/make',
            type: 'POST',
            data: $('.j-form :input').serialize(),
            success: function (data) {
                if (data.status == 'success') {
                    alert('标识[制作完成]成功');
                    window.location.href = '/user/order?custom';
                }
            }
        })
    });
</script>
@endsection

@section('uc_content')
<div class="z_w82p fr z_minh640">
    <!--标题-->
    <div class="z_border_b">
        <div class=" z_lineh40 z_font14 z_color_3">
            制作完成<span class="z_font12 z_color_9"></span>
        </div>
    </div>
    <!--标题 end-->
    <!--方案编辑-->
    <div class="z_mb10">
        <div class="z_user_msg z_user_msg2 z_w100p clearfix z_mt20 j-form">
            <input type="hidden" name="order" value="{{ $order->trade_id }}">
            @if($order->type==1)
                <!--栏目-->
                <div class=" z_font14 z_mt15 z_lineh30 z_color_3">
                    请添加照片<span class="z_color_9 z_lineh30">（请上传图片，最多上传9张）</span>
                </div>
                <!--栏目 end-->
                <div class="clearfix z_mt20 z_mb20">
                    <div class="z_img_fix z_img_fix2 fl z_mb10 z_mr10">
                        <div class="z_font12 z_color_3 tc z_mt60"></div>
                        <input type="file" name="pictures"/>
                    </div>
                </div>
            @endif
            <div class="z_inputbox z_mt20 z_mb20 z_ml180">
                <input type="button" value="提交 " class="z_btn bar-auburn z_font12 z_w120 z_ptb7 j-submit"/>
            </div>
        </div>
    </div>
    <!--方案编辑 end-->
</div>
@endsection

@section('uc_bottom')
@endsection