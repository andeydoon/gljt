@extends('mobile.layouts.master')

@section('css')
<link rel="stylesheet" href="/css/jquery.fileupload.css">
@endsection

@section('style')
<style type="text/css">
</style>
@endsection

@section('js')
<script type="text/javascript" src="/js/jquery.ui.widget.js"></script>
<script type="text/javascript" src="/js/jquery.iframe-transport.js"></script>
<script type="text/javascript" src="/js/jquery.fileupload.js"></script>
@endsection

@section('script')
<script type="text/javascript">
    $('.js_upload').click(function(){
        $(this).next('input').click();
    })

    $('.uploadbox').on('click','.bgClose',function () {
        $(this).parents('.uploadimgbox').remove();
    })

    $('input:file').fileupload({
        url: '/api/upload',
        headers: {'X-CSRF-TOKEN': Laravel.csrfToken},
        formData: {},
        done: function (e, data) {
            $.each(data.result.data.files, function (index, file) {
                $('[name="' + index + '"]').parent().prepend('<div class="uploadimgbox fl m_r_20 posr"><input type="hidden" name="pictures[]" value="' + file + '"><img src="' + file + '"><div class="bgClose posa"></div></div>');
            });
        },
        progressall: function (e, data) {
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
                    window.location.href = '/mobile/user/order?custom';
                }
            }
        })
    });
</script>
@endsection

@section('body')
<body class="bg_fff p_b_100">
<header class="header bg_fff clearfix posr p_t_30 p_b_30 b_b_e5 p_l_24 p_r_24">
    <a class="return fl" href="##"></a>
    <div class="text fl fs_36 t_a_c c_1b1 top_title x_center">制作完成</div>
    <a class="confirm fr" href="##"></a>
</header>
<div class="j-form">
    <input type="hidden" name="order" value="{{ $order->trade_id }}">

    <!-- 长传图片 -->
    <div class="uploadbox w702 p_b_24">
        <p class="fs_28 c_888 heiline90 h90">请上传图片：</p>
        <div class="clearfix">
            <div class="uploadimgbox js_upload fl">
                <img src="/packages/mobile/images/img/im4.png">
            </div>
            <input class="hide" type="file" name="pictures">
        </div>
    </div>
    <div class="null20"></div>
    <div class="fixed_bottom bg_fff">
        <div class="bg_fff ptb15 prl24 clearfix grab_center b_t_e5">
            <a class="fs_32 c_999 setbtnc fl j-submit" href="javascript:void(0);">提交</a>
            <a class="fs_32 c_999 fr j-submit" href="javascript:window.history.back();">取消</a>
        </div>
    </div>
</div>
</body>
@endsection