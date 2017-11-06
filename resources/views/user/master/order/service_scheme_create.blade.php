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
<!--输入框-->
<script type="text/html" id="js-input">
    <div class=" z_mt10">
        <input type="text" name="parts[name][]" placeholder="请输入名称" class="z_input z_border z_ptb7 z_w100 z_mr10">
        <input type="text" name="parts[price][]" placeholder="请输入单价" class="z_input z_border z_ptb7 z_w100 z_mr10">
        <input type="text" name="parts[quantity][]" placeholder="请输入数量" class="z_input z_border z_ptb7 z_w100 z_mr10">
        <span class="z_lineh30 z_font12 z_cursor z_color_red js-z_off">删除</span>
    </div>
</script>
<!--输入框 end-->
<script type="text/javascript">
    //删除2
    function delet2() {
        $(".js-z_off").click(function () {
            $(this).parent().remove();
            return false;
        });
    }

    //添加输入框 js-z_add2
    function add2() {
        $(".js-z_add2").click(function () {
            var html = template('js-input');
            console.log(html);
            //	return false;
            $(this).next().append(html);
            //绑定事件
            delet2()
        });
    }

    add2();

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
            url: '/api/user/order/service_scheme_create',
            type: 'POST',
            data: $('.j-form :input').serialize(),
            success: function (data) {
                if (data.status == 'success') {
                    alert('方案提交成功');
                    window.location.href = '/user/order?service';
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
                <label class="z_w80 z_lineh30 z_font12 z_color_3 fl">方案内容：</label>
                <div class="z_ml100" style="width: 520px;">
                    <div class="z_text-wrap z_border z_p10 ">
                        <textarea name="content" class="z_textarea z_h100" placeholder=""></textarea>
                    </div>
                </div>
            </div>
            <div class="z_inputbox clearfix z_mb10">
                <label class="z_w80 z_lineh30 z_font12 z_color_3 fl">人工费用：</label>
                <div class="fl" style="">
                    <input type="text" name="cost_labor" placeholder="" class="z_input z_border z_ptb7 z_w140">
                </div>
            </div>
            <div class="z_inputbox clearfix z_mb10">
                <label class="z_w80 z_lineh30 z_font12 z_color_3 fl">材料配件：</label>
                <div class="fl" style="">
                    <a href="javascript:void(0);"
                       class="z_btn z_border z_color_3 z_font12 z_w100 z_ptb7 bar-Grey-ef js-z_add2">+添加</a>
                    <div class="clearfix">
                        <div class="z_mt10">
                            <input type="text" name="parts[name][]" placeholder="请输入名称"
                                   class="z_input z_border z_ptb7 z_w100 z_mr10">
                            <input type="text" name="parts[price][]" placeholder="请输入单价"
                                   class="z_input z_border z_ptb7 z_w100 z_mr10">
                            <input type="text" name="parts[quantity][]" placeholder="请输入数量"
                                   class="z_input z_border z_ptb7 z_w100 z_mr10">
                            <span class="z_lineh30 z_font12 z_cursor z_color_red js-z_off">删除</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="z_inputbox clearfix z_mb10">
                <label class="z_w80 z_lineh30 z_font12 z_color_3 fl">总费用：</label>
                <div class="fl" style="">
                    <input type="text" name="total" placeholder="" class="z_input z_border z_ptb7 z_w140">
                </div>
            </div>
            @if($order->type==1)
                <!--栏目-->
                <div class=" z_font14 z_mt15 z_lineh30 z_color_3">
                    请添加照片<span class="z_color_9 z_lineh30">（请上传服务前图片，最多上传9张）</span>
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
                <input type="button" value="提交方案 " class="z_btn bar-auburn z_font12 z_w120 z_ptb7 j-submit"/>
            </div>
        </div>
    </div>
    <!--方案编辑 end-->
</div>
@endsection

@section('uc_bottom')
@endsection