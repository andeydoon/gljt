@extends('mobile.layouts.master')

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
<!--输入框-->
<script type="text/html" id="itembox">
    <li class="clearfix edite_items b_b_e5">
        <input type="text" class="fl fs_34 t_a_c" name="parts[name][]" placeholder="请输入名称">
        <input type="number" class="fl fs_34 t_a_c" name="parts[price][]" placeholder="请输入数量">
        <input type="text" class="fl fs_34 t_a_c" name="parts[quantity][]" placeholder="请输入单价">
    </li>
</script>
<!--输入框 end-->
<script type="text/javascript">
    $('.js_upload').click(function(){
        $(this).next('input').click();
    })

    $('.uploadbox').on('click','.bgClose',function () {
        $(this).parents('.uploadimgbox').remove();
    })

    // 添加一栏配置;
    var result=[];
    $('.js_calc').click(function(){
        var html = template('itembox');
        $('.show_addbox').append(html);
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
            url: '/api/user/order/service_scheme_create',
            type: 'POST',
            data: $('.j-form :input').serialize(),
            success: function (data) {
                if (data.status == 'success') {
                    alert('方案提交成功');
                    window.location.href = '/mobile/user/order?service';
                }
            }
        })
    });

    $('body').on('keyup', '[name="cost_labor"],[name="parts[price][]"],[name="parts[quantity][]"]', function () {
        var total = 0;
        total += (parseInt($('[name="cost_labor"]').val()) || 0);
        $('[name="parts[price][]"]').each(function () {
            total += (parseInt($(this).val()) || 0) * (parseInt($(this).next().val()) || 0);
        })
        $('[name="total"]').val(total)
    })
</script>
@endsection

@section('body')
<body class="bg_f2f p_b_100">
<header class="header bg_fff clearfix posr p_t_30 p_b_30 b_b_e5 p_l_24 p_r_24">
    <a class="return fl" href="##"></a>
    <div class="text fl fs_36 t_a_c c_1b1 top_title x_center">编辑方案</div>
    <a class="confirm fr" href="##"></a>
</header>
<div class="liaojie prl24 clearfix b_b_e5 bg_fff">
    <span class="fl c_666 liaoj fs_28">这是师傅根据您的真实环境确认的</span>
    <a class=" fr c_1b goliaoj fs_30 bg_fbfa" href="##">了解施工流程</a>
</div>
<div class="j-form">
    <input type="hidden" name="order" value="{{ $order->trade_id }}">
    <div class="bg_fff ">
        <p class="fs_36 c_333 prl24 ptb30 b_b_e5">{{ $order->service->service->name }}</p>
        <ul class="p_l_24 js_add_lielemt">
            <li class="clearfix edit_fanan b_b_e5">
                <span class="fl fs_34 c_000">*方案详情</span>
                <input class="fr fs_34 p_l_20" type="text" name="content" placeholder="请输入方案详情">
            </li>
            <li class="clearfix edit_fanan b_b_e5">
                <span class="fl fs_34 c_000">*人工费用</span>
                <input class="fr fs_34 p_l_20" type="text" name="cost_labor" placeholder="请输入人工费用">
            </li>
            <li class="clearfix edit_fanan b_b_e5">
                <span class="fl fs_34 c_000">*总费用</span>
                <input class="fr fs_34 p_l_20" type="text" name="total" placeholder="请输入总费用">
            </li>
        </ul>
    </div>
    <div class="bg_fff ">
        <p class="fs_36 c_333 prl24 ptb30 b_b_e5">材料配件</p>
        <ol class="w_702 show_addbox">
            <li class="clearfix edite_items b_b_e5">
                <input type="text" class="fl fs_34 t_a_c" name="parts[name][]" placeholder="请输入名称">
                <input type="number" class="fl fs_34 t_a_c" name="parts[price][]" placeholder="请输入数量">
                <input type="text" class="fl fs_34 t_a_c" name="parts[quantity][]" placeholder="请输入单价">
            </li>
        </ol>
        <p class="add_eadititem p_l_24 pbt24">
            <a class="js_calc c_1b goliaoj fs_30 bg_fbfa" href="javascript:;">增加一栏配件</a>
        </p>
    </div>
    <!-- 上传服务图片 -->
    <div class="bg_fff">
        <div class="uploadbox w702 p_b_24">
            <p class="fs_28 c_888 heiline90 h90">请上传方案图片：</p>
            <div class="clearfix">
                <div class="uploadimgbox js_upload fl">
                    <img src="/packages/mobile/images/img/im4.png">
                </div>
                <input class="hide" type="file" name="pictures">
            </div>
        </div>
    </div>
    <div class="fixed_bottom">
        <div class="p_t_15 p_b_15 fs_32 bg_fff">
            <a class="c_fff show commonBtn j-submit" href="javascript:void(0);">
                提交方案
            </a>
        </div>
    </div>
</div>
</body>
@endsection