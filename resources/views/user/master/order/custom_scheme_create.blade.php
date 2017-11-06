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
            url: '/api/user/order/custom_scheme_create',
            type: 'POST',
            data: $('.j-form :input').serialize(),
            success: function (data) {
                if (data.status == 'success') {
                    alert('方案提交成功');
                    window.location.href = '/user/order?custom';
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
                $('[name="parameters[{{ $parameter->name }}]"]').parent().find('li[data-id="{{ preg_replace("/\r\n|\r|\n/", '', unserialize($order_custom_scheme_draft->parameters)[$parameter->name]) }}"]').trigger('click');
            @endif
        @endforeach
    });
</script>
@endsection

@section('uc_content')
<div class="z_w82p fr z_minh640">
    <!--标题-->
    <div class="z_border_b">
        <div class=" z_lineh40 z_font14 z_color_3">
            方案编辑<span class="z_font12 z_color_9">（师傅需将测量后的每个门窗结果记录下来）</span>
        </div>
    </div>
    <!--标题 end-->
    <!--方案编辑-->
    <div class="z_mb10">
        <div class="z_user_msg z_user_msg2 z_w100p clearfix z_mt20 j-form">
            <input type="hidden" name="order" value="{{ $order->trade_id }}">
            <div class="z_inputbox clearfix z_mb10">
                <label class="z_w80 z_lineh30 z_font14 z_color_3 fl">方案内容：</label>
                <div class="z_ml100" style="width: 520px;">
                    <div class="z_text-wrap z_border z_p10 ">
                        <textarea name="content" class="z_textarea z_h100" placeholder="请输入电梯或楼梯的大小宽高">{{ $order_custom_scheme_draft->content }}</textarea>
                    </div>
                </div>
            </div>
            @foreach($order->custom->product->parameters as $parameter)
                <div class="z_inputbox clearfix z_mb10">
                    <label class="z_w80 z_lineh30 z_font14 z_color_3 fl">{{ $parameter->name }}：</label>
                    @if($parameter->type == 1)
                        <div class="z_ml100" style="">
                            <input type="text" name="parameters[{{ $parameter->name }}]" placeholder="" class="z_input z_border z_ptb7 z_w136" value="{{ unserialize($order_custom_scheme_draft->parameters)[$parameter->name] }}">
                        </div>
                    @endif
                    @if($parameter->type == 2)
                        <div class="fl bar-white z_border" style="width: 136px;">
                            <input type="hidden" name="parameters[{{ $parameter->name }}]" placeholder="" class="z_input ">
                            <div class="z_select_div  js-z_select_div">
                                <p style="">选择{{ $parameter->name }}</p>
                                <ul class="hide js-z_select_ul" style="display: none;">
                                    @foreach(preg_split('/\n|\r\n?/', $parameter->items) as $item)
                                        <li data-id="{{ $item }}">{{ $item }}</li>
                                    @endforeach
                                </ul>
                                <span class="z_tubiao js-z_tubiao">
                                    <!--图标-->
                                </span>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
            <div class="z_inputbox clearfix z_mb10">
                <label class="z_w80 z_lineh30 z_font14 z_color_3 fl">高(cm)：</label>
                <div class="z_ml100" style="">
                    <input type="text" name="height" placeholder="" class="z_input z_border z_ptb7 z_w136" value="{{ $order_custom_scheme_draft->height }}">
                </div>
            </div>
            <div class="z_inputbox clearfix z_mb10">
                <label class="z_w80 z_lineh30 z_font14 z_color_3 fl">宽(cm)：</label>
                <div class="z_ml100" style="">
                    <input type="text" name="width" placeholder="" class="z_input z_border z_ptb7 z_w136" value="{{ $order_custom_scheme_draft->width }}">
                </div>
            </div>
            <div class="z_inputbox clearfix z_mb10">
                <label class="z_w80 z_lineh30 z_font14 z_color_3 fl">厚(cm)：</label>
                <div class="z_ml100" style="">
                    <input type="text" name="thickness" placeholder="" class="z_input z_border z_ptb7 z_w136" value="{{ $order_custom_scheme_draft->thickness }}">
                </div>
            </div>

            <div class="z_inputbox clearfix z_mb10">
                <label class="z_w80 z_lineh30 z_font14 z_color_3 fl">费用：</label>
                <div class="z_ml100" style="">
                    <input type="text" name="total" placeholder="" class="z_input z_border z_ptb7 z_w140" value="{{ $order_custom_scheme_draft->total }}">
                </div>
            </div>
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
                    @if(!empty($order_custom_scheme_draft->pictures))
                        @foreach(explode(';', $order_custom_scheme_draft->pictures) as $picture)
                            <div class="z_img_fix z_img_fix2 fl z_mb10 z_mr10">
                                <img src="{{ $picture }}"/>
                                <input type="hidden" name="pictures[]" value="{{ $picture }}">
                                <span class="z_off2 js-z_off"></span>
                            </div>
                        @endforeach
                    @endif
                </div>
            @endif
            <div class="z_inputbox z_mt20 z_mb20 z_ml180">
                <input type="button" value="保存方案 " class="z_btn bar-auburn z_font12 z_w120 z_ptb7 j-draft"/>
                <input type="button" value="提交方案 " class="z_btn bar-auburn z_font12 z_w120 z_ptb7 j-submit"/>
            </div>
        </div>
    </div>
    <!--方案编辑 end-->
</div>
@endsection

@section('uc_bottom')
@endsection