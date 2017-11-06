@extends('mobile.layouts.master')

@section('script')
<script type="text/javascript">
    $('.j-submit').click(function () {
        $.jAjax({
            url: '/api/feedback',
            type: 'POST',
            data: $('.j-form :input').serialize(),
            success: function (data) {
                alert('反馈提交成功');
                window.location.href = '/mobile';
            }
        })
    })
</script>
@endsection

@section('body')
<body class="bg_f2f">
<header class="header bg_fff clearfix posr p_t_30 p_b_30 b_b_e5 p_l_24 p_r_24">
    <a class="return fl" href="##"></a>
    <div class="text fl fs_36 t_a_c c_1b1 top_title x_center">意见反馈</div>
    <a class="fr fs_30 p_t_3 j-submit" href="javascript:void(0);">提交</a>
</header>
<div class="bg_fff j-form">
    <div class="null20"></div>
    <div class="prl24 clearfix posr p_b_18 bg_fff">
        <input class="fs_34" name="phone" placeholder="请输入手机号码">
    </div>
    <div class="null20"></div>
    <div class="prl24 clearfix posr p_b_18 bg_fff">
        <textarea class="fs_34" name="content" placeholder="请输入反馈内容..."></textarea>
    </div>
</div>
</body>
@endsection