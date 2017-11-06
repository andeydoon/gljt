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

    // 点亮星星;
    $('.warp_star_state .swarp').click(function(event) {
        $(this).addClass('hots_active');
        $(this).prevAll('.swarp').addClass('hots_active');
        $(this).nextAll('.swarp').removeClass('hots_active');

        $('[name="' + $(this).parent().data('target') + '"]').val($(this).prevAll('.swarp').size() + 1);

    });

    $('.j-submit').click(function () {
        $.jAjax({
            url: '/api/user/publish/comment',
            type: 'POST',
            data: $('.j-form :input').serialize(),
            success: function (data) {
                if (data.status == 'success') {
                    alert('提交成功');
                    window.location.href = '/mobile/user/publish?{{ $order->type==1 ? 'custom' : 'service' }}';
                }
            }
        })
    });

</script>
@endsection

@section('body')
<body class="bg_fff">
<header class="header bg_fff clearfix posr p_t_30 p_b_30 b_b_e5 p_l_24 p_r_24">
    <a class="return fl" href="##"></a>
    <div class="text fl fs_36 t_a_c c_1b1 top_title x_center">请您确认{{ $order->type==1 ? '安装' : '服务' }}</div>
    <a class="confirm fr" href="##"></a>
</header>
<div class="j-form">
    <input type="hidden" name="order" value="{{ $order->trade_id }}">
    <input type="hidden" name="type" value="{{ $order->type }}">
    <input type="hidden" name="service_score" value="5">
    <input type="hidden" name="product_score" value="5">
    <!-- 上传 -->
    <div class="uploadbox">
        <p class="fs_30 c_666 b_b_e5 heiline88 prl24">请上传安装结果图片</p>
        <div class="p_t_24 p_b_24 prl24 clearfix">
            <div class="uploadimgbox js_upload fl">
                <img src="/packages/mobile/images/img/im4.png">
            </div>
            <input class="hide" type="file" name="picture">
        </div>
    </div>
    <div class="null20"></div>
    <div class="Masterevaluation">
        <p class="fs_30 c_666 b_b_e5 heiline88 p_l_24">服务师傅评价</p>
        <div class="youmasterinfo w702 p_b_24 posr">
            <div class="a_names clearfix pbt24">
                <div class="a_lphot fl">
                    <img src="/packages/mobile/images/img/mas.png">
                </div>
                <div class="a_infos fl p_l_24 ">
                    <p><i class="fs_32">{{ $order->master->profile->realname }}</i> <span class="renzheng m_l_24 fs_20">认证</span></p>
                    <p class=" m_t_20 fs_30 c_666"></p>
                </div>
                <span class="c_fff a_shitip posa fs_24">服务师傅</span>
            </div>
            <div class="p_b_35 ">
                <p class="fs_30 c_666 pbt_20">服务分数</p>
                <div class="warp_star_state" data-target="service_score">
                    <p class="disline swarp hots_active"> </p>
                    <p class="disline swarp hots_active"> </p>
                    <p class="disline swarp hots_active"> </p>
                    <p class="disline swarp hots_active"> </p>
                    <p class="disline swarp hots_active"> </p>
                </div>
            </div>
            <div class="shurutext">
                <textarea class="fs_34" name="service_content" placeholder="写下你想说的..."></textarea>
            </div>
        </div>
    </div>
    @if($order->type == 1)
        <!-- 产品评价 -->
        <div class="null20"></div>
        <div class="p_b_24">
            <p class="fs_30 c_666 b_b_e5 heiline88 p_l_24">产品评价</p>
            <div class="pName w702 pbt24 clearfix b_b_e5">
                <div class="pimgbox fl">
                    <img src="/packages/mobile/images/img/pimg.png">
                </div>
                <div class="ptext fl m_l_15">
                    <p class="limitw fs_32 c_000  Singleellipsis">{{ $order->custom->product->name }}</p>
                    <p class="fs_30 c_666 p_t_30 clearfix"></p>
                </div>
            </div>
            <div class="p_b_35 w702">
                <p class="fs_30 c_666 pbt_20">服务分数</p>
                <div class="warp_star_state" data-target="product_score">
                    <p class="disline swarp hots_active"> </p>
                    <p class="disline swarp hots_active"> </p>
                    <p class="disline swarp hots_active"> </p>
                    <p class="disline swarp hots_active"> </p>
                    <p class="disline swarp hots_active"> </p>
                </div>
            </div>
            <div class="shurutext w702 ">
                <textarea class="fs_34" name="product_content" placeholder="写下你想说的..."></textarea>
            </div>
        </div>
    @endif
    <div class="null20"></div>

    <div class="commonBtn m_b_15 m_t_15 fs_32 js_queding">
        <a class="c_fff show j-submit" href="javascript:void(0);">
            确定
        </a>
    </div>
</div>

</body>
@endsection