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
            url: '/api/user/order/custom_scheme_create',
            type: 'POST',
            data: $('.j-form :input').serialize(),
            success: function (data) {
                if (data.status == 'success') {
                    alert('方案提交成功');
                    window.location.href = '/mobile/user/order?custom';
                }
            }
        })
    });

    $('.j-draft').click(function () {
        $.jAjax({
            url: '/api/user/order/custom_scheme_draft',
            type: 'POST',
            data: $('.j-form :input').serialize(),
            success: function (data) {
                if (data.status == 'success') {
                    alert('方案草稿保存成功，后续仍需进行提交操作');
                }
            }
        })
    });

    $(function () {
        @foreach($order->custom->product->parameters as $parameter)
            @if($parameter->type == 2)
                $('[name="parameters[{{ $parameter->name }}]"] option[value="{{ preg_replace("/\r\n|\r|\n/", '', unserialize($order_custom_scheme_draft->parameters)[$parameter->name]) }}"]').attr('selected', true);
            @endif
        @endforeach
    });
</script>
@endsection

@section('body')
<body class="bg_fff p_b_100">
<header class="header bg_fff clearfix posr p_t_30 p_b_30 b_b_e5 p_l_24 p_r_24">
    <a class="return fl" href="##"></a>
    <div class="text fl fs_36 t_a_c c_1b1 top_title x_center">测量</div>
    <a class="confirm fr" href="##"></a>
</header>
<div class="serverType prl24 bg_fff clearfix b_b_e5">
    <div class="c_666 fs_26 ptb30">
        师傅需将测量后的每个门窗结果记录下来
    </div>
</div>
<div class="j-form">
    <input type="hidden" name="order" value="{{ $order->trade_id }}">
    <div>
        <ul>
            <li class="c_333 fs_36 prl24 pbt24">{{ $order->custom->product->name }}</li>
        </ul>
        <ol class="w702">
            <li class="clearfix b_b_e5 new_measure">
                <span class="fl fs_34 c_000">高</span>
                <input class="fr fs_34" type="text" name="height" placeholder="请输入cm" value="{{ $order_custom_scheme_draft->height }}">
            </li>
            <li class="clearfix b_b_e5 new_measure">
                <span class="fl fs_34 c_000">宽</span>
                <input class="fr fs_34" type="text" name="width" placeholder="请输入cm" value="{{ $order_custom_scheme_draft->width }}">
            </li>
            <li class="clearfix b_b_e5 new_measure">
                <span class="fl fs_34 c_000">厚</span>
                <input class="fr fs_34" type="text" name="thickness" placeholder="请输入cm" value="{{ $order_custom_scheme_draft->thickness }}">
            </li>
            <li class="clearfix new_measure">
                <span class="fl fs_34 c_000">总价</span>
                <input class="fr fs_34" type="text" name="total" placeholder="请输入总价" value="{{ $order_custom_scheme_draft->total }}">
            </li>
        </ol>
    </div>
    <div class="null20"></div>

    <div>
        <ol class="w702">
            @foreach($order->custom->product->parameters as $parameter)
                <li class="clearfix b_b_e5 new_measure">
                    <span class="fl fs_34 c_000">{{ $parameter->name }}</span>
                    @if($parameter->type==1)
                        <input class="fr fs_34" type="text" name="parameters[{{ $parameter->name }}]" placeholder="请输入{{ $parameter->name }}" value="{{ unserialize($order_custom_scheme_draft->parameters)[$parameter->name] }}">
                    @endif
                    @if($parameter->type == 2)
                        <select class="fr fs_34" name="parameters[{{ $parameter->name }}]" style="width: 79.34472934%; padding-left: .1rem !important; height: .88rem; line-height: .88rem;">
                            <option value="">选择{{ $parameter->name }}</option>
                            @foreach(preg_split('/\n|\r\n?/', $parameter->items) as $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    @endif
                </li>
            @endforeach
        </ol>
    </div>
    <div class="null20"></div>

    <!-- 长传图片 -->
    <div class="uploadbox w702 p_b_24">
        <p class="fs_28 c_888 heiline90 h90">请上传方案图片：</p>
        <div class="clearfix">
            @if(!empty($order_custom_scheme_draft->pictures))
                @foreach(explode(';', $order_custom_scheme_draft->pictures) as $picture)
                    <div class="uploadimgbox fl m_r_20 posr">
                        <input type="hidden" name="pictures[]" value="{{ $picture }}">
                        <img src="{{ $picture }}">
                        <div class="bgClose posa"></div>
                    </div>
                @endforeach
            @endif
            <div class="uploadimgbox js_upload fl">
                <img src="/packages/mobile/images/img/im4.png">
            </div>
            <input class="hide" type="file" name="pictures">
        </div>
    </div>
    <div class="null20"></div>
    <div class="server_conten fs_34 p_b_24">
        <div class="shurutext w702 m_t_30">
            <textarea class="fs_34" name="content" placeholder="请输入电梯或楼梯的大小宽高">{{ $order_custom_scheme_draft->content }}</textarea>
        </div>
    </div>
    <div class="null20"></div>
    <div class="fixed_bottom bg_fff">
        <div class="bg_fff ptb15 prl24 clearfix grab_center b_t_e5">
            <a class="fs_32 c_999 fl j-draft" href="javascript:void(0);">保存方案</a>
            <a class="fs_32 c_999 setbtnc fr j-submit" href="javascript:void(0);">提交方案</a>
        </div>
    </div>
</div>
</body>
@endsection