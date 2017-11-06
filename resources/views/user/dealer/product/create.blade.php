@extends('user.layouts.master-dealer')

@section('css')
<link rel="stylesheet" href="/css/jquery.fileupload.css">
@endsection

@section('js')
<script type="text/javascript" src="/js/jquery.ui.widget.js"></script>
<script type="text/javascript" src="/js/jquery.iframe-transport.js"></script>
<script type="text/javascript" src="/js/jquery.fileupload.js"></script>
<script type="text/javascript" src="/packages/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="/js/template.js"></script>
@endsection

@section('script')
<script type="text/html" id="list">
    <div class="z_user_msg z_user_msg2 z_w100p clearfix posr">
        <span class="z_off2 js-z_off"></span>
        <div class="fl z_mr20">
            <div class="z_inputbox clearfix z_mb10">
                <label class="z_w60 z_lineh30 z_font12 z_color_6 fl"><span class="z_color_red">*</span>颜色</label>
                <div class="fl" style="">
                    <input type="text" name="colours[name][]" placeholder="" value="" class="z_input z_border z_ptb7 z_w200">
                </div>
            </div>
            <div class="z_inputbox clearfix z_mb10">
                <label class="z_w60 z_lineh30 z_font12 z_color_6 fl"><span class="z_color_red">*</span>价格</label>
                <div class="fl" style="">
                    <input type="text" name="colours[price][]" placeholder="" value="" class="z_input z_border z_ptb7 z_w200">
                </div>
            </div>
        </div>
        <div class="fl">
            <label class="z_w80 z_lineh30 z_font12 z_color_6 fl"><span class="z_color_red">*</span>对应缩略图</label>
            <div class="fl clearfix" style="">
                <div class="z_img_fix z_img_fix2 fl z_mb10 z_mr10">
                    <div class="z_img hide">
                        <img/>
                    </div>
                    <div class="z_font12 z_color_3 tc z_mt60"></div>
                    <input type="file" name="picture">
                    <input type="hidden" name="colours[picture][]">
                </div>
            </div>
        </div>
    </div>
</script>
<script type="text/html" id="list_attribute">
    <div class="z_user_msg z_user_msg2 z_w100p clearfix posr">
        <span class="z_off2 js-z_off"></span>
        <div class="fl z_mr20">
            <div class="z_inputbox clearfix z_mb10">
                <label class="z_w60 z_lineh30 z_font12 z_color_6 fl"><span class="z_color_red">*</span>名称</label>
                <div class="fl" style="">
                    <input type="text" name="attributes[label][]" placeholder="" value="" class="z_input z_border z_ptb7 z_w200">
                </div>
            </div>
        </div>
        <div class="fl">
            <div class="z_inputbox clearfix z_mb10">
                <label class="z_w60 z_lineh30 z_font12 z_color_6 fl"><span class="z_color_red">*</span>数值</label>
                <div class="fl" style="">
                    <input type="text" name="attributes[value][]" placeholder="" value="" class="z_input z_border z_ptb7 z_w200">
                </div>
            </div>
        </div>
    </div>
</script>
<script type="text/html" id="list_parameter">
    <div class="z_user_msg z_user_msg2 z_w100p clearfix posr">
        <span class="z_off2 js-z_off"></span>
        <div class="fl z_mr20">
            <div class="z_inputbox clearfix z_mb10">
                <label class="z_w60 z_lineh30 z_font12 z_color_6 fl"><span class="z_color_red">*</span>名称</label>
                <div class="fl" style="">
                    <input type="text" name="parameters[name][]" placeholder="" value="" class="z_input z_border z_ptb7 z_w200">
                </div>
            </div>
            <div class="z_inputbox clearfix z_mb10">
                <label class="z_w60 z_lineh30 z_font12 z_color_6 fl"><span class="z_color_red">*</span>类型</label>
                <div class="fl bar-white z_border z_w200">
                    <input type="hidden" name="parameters[type][]" placeholder="" class="z_input ">
                    <div class="z_select_div  js-z_select_div">
                        <p style="">选择类型</p>
                        <ul class="hide js-z_select_ul" style="display: none;">
                            <li data-id="1" class="active">文本框</li>
                            <li data-id="2">下拉框</li>
                        </ul>
                        <span class="z_tubiao js-z_tubiao">
                            <!--图标-->
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="fl">
            <label class="z_w80 z_lineh30 z_font12 z_color_6 fl"><span class="z_color_red">*</span>对应值</label>
            <div class="fl clearfix" style="">
                <div class="z_text-wrap z_border z_p10">
                    <textarea class="z_textarea z_h50 z_w300" name="parameters[items][]" placeholder="每行一个"></textarea>
                </div>
            </div>
        </div>
    </div>
</script>
<script type="text/javascript">
    $(document).on('click', '.js-z_off', function () {
        $(this).parent().remove();
        return false;
    })

    //添加商品输入 js-z_add
    $(".js-z_add").click(function () {
        var html = template('list');
        console.log(html);
        //	return false;
        $('.js-inputbox').append(html);
    });

    $(".js-z_add_attribute").click(function () {
        var html = template('list_attribute');
        console.log(html);
        //	return false;
        $('.js-inputbox_attribute').append(html);
    });

    $(".js-z_add_parameter").click(function () {
        var html = template('list_parameter');
        console.log(html);
        //	return false;
        $('.js-inputbox_parameter').append(html);
    });

    $(document).on('click', 'input:file', function () {
        $('input:file').fileupload({
            url: '/api/upload',
            headers: {'X-CSRF-TOKEN': Laravel.csrfToken},
            formData: {},
            done: function (e, data) {
                $.each(data.result.data.files, function (index, file) {
                    var $this = $(e.target);
                    if (index == 'picture') {
                        $this.next().val(file);
                        $this.prev().hide().prev().removeClass('hide').children('img').prop('src', file);
                    }
                    if (index == 'gallery') {
                        $('[name="' + index + '"]').prev().hide().parent().parent().append('<div class="z_img_fix z_img_fix2 fl z_mb10 z_mr10"><img src="' + file + '"/><input type="hidden" name="galleries[]" value="' + file + '"><span class="z_off2 js-z_off"></span></div>')
                    }
                });
            },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $(this).prev().show().text('上传中(' + progress + '%)').prev().addClass('hide');
            }
        });
    })


    $.jAjax({
        url: '/api/category',
        success: function (data) {
            $.each(data.data.categories, function () {
                $('<li/>', {
                    'data-id': this.id,
                    'text': this.name,
                }).appendTo('.j-category_0');
            })
        }
    });

    $('.j-category_0').on('click', 'li', function () {
        $.jAjax({
            url: '/api/category',
            data: {'parent_id': $(this).data('id')},
            success: function (data) {
                $('.j-category_1').empty().prev().text('类型').parent().parent().children(':input').val('');
                $('.j-material').empty().prev().text('材质').parent().parent().children(':input').val('');
                $.each(data.data.categories, function () {
                    $('<li/>', {
                        'data-id': this.id,
                        'text': this.name,
                    }).appendTo('.j-category_1');

                    $.each(this.materials, function () {
                        $('<li/>', {
                            'data-id': this.id,
                            'data-category': this.category_id,
                            'text': this.name,
                            'class': 'hide',
                        }).appendTo('.j-material');
                    })
                })
            }
        });
    });

    $('.j-category_1').on('click', 'li', function () {
        $('.j-material').prev().text('材质').parent().parent().children(':input').val('');
        $('.j-material li').addClass('hide');
        $('.j-material li[data-category="' + $(this).data('id') + '"]').removeClass('hide');
    });

    var $overview = CKEDITOR.replace('overview', {
        height: 350,
        filebrowserUploadUrl: '/api/upload?from=ckeditor',
    });

    $('.j-submit').click(function () {
        $('[name="overview"]').val($overview.getData());
        $.jAjax({
            url: '/api/user/product',
            type: 'POST',
            data: $('.j-form :input').serialize(),
            success: function (data) {
                if (data.status == 'success') {
                    alert('产品添加成功');
                    window.location = '/user/product';
                }
            }
        });
    });

</script>
@endsection

@section('uc_content')
<div class="z_w82p fr z_minh640">
    @include('user.layouts.card-user')
    <!--标题-->
    <div class="z_border_b">
        <div class="z_lineh30 z_font14 z_mt15 z_mb5 ">
            新增产品
        </div>
    </div>
    <!--标题 end-->
    <!--新增产品-->
    <div class="z_mb10 j-form">
        <div class="z_user_msg z_user_msg2 z_w100p clearfix z_mt20">
            <div class="z_inputbox clearfix z_mb10">
                <label class="z_w60 z_lineh30 z_font12 z_color_6 fl"><span class="z_color_red">*</span>分　　类</label>
                <div class="fl" style="">
                    <div class="bar-white z_border z_mr10" style="width: 200px;">
                        <input type="hidden" name="" placeholder="" class="z_input "/>
                        <div class="z_select_div  js-z_select_div">
                            <p>分类</p>
                            <ul class="hide js-z_select_ul j-category_0"></ul>
                            <span class="z_tubiao js-z_tubiao">
                                <!--图标-->
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="z_inputbox clearfix z_mb10">
                <label class="z_w60 z_lineh30 z_font12 z_color_6 fl"><span class="z_color_red">*</span>类　　型</label>
                <div class="fl" style="">
                    <div class="bar-white z_border z_mr10" style="width: 200px;">
                        <input type="hidden" name="category_id" placeholder="" class="z_input "/>
                        <div class="z_select_div  js-z_select_div">
                            <p>类型</p>
                            <ul class="hide js-z_select_ul j-category_1"></ul>
                            <span class="z_tubiao js-z_tubiao">
                                <!--图标-->
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="z_inputbox clearfix z_mb10">
                <label class="z_w60 z_lineh30 z_font12 z_color_6 fl"><span class="z_color_red">*</span>材　　质</label>
                <div class="fl" style="">
                    <div class="bar-white z_border z_mr10" style="width: 200px;">
                        <input type="hidden" name="material_id" placeholder="" class="z_input "/>
                        <div class="z_select_div  js-z_select_div">
                            <p>材质</p>
                            <ul class="hide js-z_select_ul j-material"></ul>
                            <span class="z_tubiao js-z_tubiao">
                                <!--图标-->
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="z_inputbox clearfix z_mb10">
                <label class="z_w60 z_lineh30 z_font12 z_color_6 fl"><span class="z_color_red">*</span>产品名称</label>
                <div class="fl" style="">
                    <input type="text" name="name" placeholder="" value="" class="z_input z_border z_ptb7 z_w200">
                </div>
            </div>
            <div class="z_inputbox clearfix z_mb10">
                <label class="z_w60 z_lineh30 z_font12 z_color_6 fl"><span class="z_color_red">*</span>产品描述</label>
                <div class="fl" style="">
                    <input type="text" name="describe" placeholder="" value="" class="z_input z_border z_ptb7 z_w200">
                </div>
            </div>
            <div class="z_inputbox clearfix z_mb10">
                <label class="z_w60 z_lineh30 z_font12 z_color_6 fl"><span class="z_color_red">*</span>计量单位</label>
                <div class="fl" style="">
                    <input type="text" name="unit" placeholder="" value="" class="z_input z_border z_ptb7 z_w200">
                </div>
            </div>
            <div class="z_inputbox clearfix z_mb10">
                <label class="z_w60 z_lineh30 z_font12 z_color_6 fl">单位价格</label>
                <div class="fl" style="">
                    <input type="text" name="price" placeholder="填写颜色将以颜色价格为准" value="" class="z_input z_border z_ptb7 z_w200">
                </div>
            </div>
        </div>
        <!--栏目-->
        <div class="z_border_b">
            <div class=" z_font14 z_mt15 z_mb5 ">
                产品参数<span class="z_color_9 z_lineh30">（可添加多个参数）</span>
                <a href="javascript:void(0);"
                   class="z_btn bar-Grey-ef z_color_3 z_font12 z_border z_ptb6 z_w100 js-z_add_parameter">+添加</a>
            </div>
        </div>
        <!--栏目 end-->
        <div class="z_mb30 z_mt20 js-inputbox_parameter">
            <div class="z_user_msg z_user_msg2 z_w100p clearfix posr">
                <span class="z_off2 js-z_off"></span>
                <div class="fl z_mr20">
                    <div class="z_inputbox clearfix z_mb10">
                        <label class="z_w60 z_lineh30 z_font12 z_color_6 fl"><span class="z_color_red">*</span>名称</label>
                        <div class="fl" style="">
                            <input type="text" name="parameters[name][]" placeholder="" value="" class="z_input z_border z_ptb7 z_w200">
                        </div>
                    </div>
                    <div class="z_inputbox clearfix z_mb10">
                        <label class="z_w60 z_lineh30 z_font12 z_color_6 fl"><span class="z_color_red">*</span>类型</label>
                        <div class="fl bar-white z_border z_w200">
                            <input type="hidden" name="parameters[type][]" placeholder="" class="z_input ">
                            <div class="z_select_div  js-z_select_div">
                                <p style="">选择类型</p>
                                <ul class="hide js-z_select_ul" style="display: none;">
                                    <li data-id="1" class="active">文本框</li>
                                    <li data-id="2">下拉框</li>
                                </ul>
                                <span class="z_tubiao js-z_tubiao">
                                    <!--图标-->
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="fl">
                    <label class="z_w80 z_lineh30 z_font12 z_color_6 fl"><span class="z_color_red">*</span>对应值</label>
                    <div class="fl clearfix" style="">
                        <div class="z_text-wrap z_border z_p10">
                            <textarea class="z_textarea z_h50 z_w300" name="parameters[items][]" placeholder="每行一个"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--栏目-->
        <div class="z_border_b">
            <div class=" z_font14 z_mt15 z_mb5 ">
                产品属性<span class="z_color_9 z_lineh30">（可添加多个属性）</span>
                <a href="javascript:void(0);"
                   class="z_btn bar-Grey-ef z_color_3 z_font12 z_border z_ptb6 z_w100 js-z_add_attribute">+添加</a>
            </div>
        </div>
        <!--栏目 end-->
        <div class="z_mb30 z_mt20 js-inputbox_attribute">
            <div class="z_user_msg z_user_msg2 z_w100p clearfix posr">
                <span class="z_off2 js-z_off"></span>
                <div class="fl z_mr20">
                    <div class="z_inputbox clearfix z_mb10">
                        <label class="z_w60 z_lineh30 z_font12 z_color_6 fl"><span class="z_color_red">*</span>名称</label>
                        <div class="fl" style="">
                            <input type="text" name="attributes[label][]" placeholder="" value="" class="z_input z_border z_ptb7 z_w200">
                        </div>
                    </div>
                </div>
                <div class="fl">
                    <div class="z_inputbox clearfix z_mb10">
                        <label class="z_w60 z_lineh30 z_font12 z_color_6 fl"><span class="z_color_red">*</span>数值</label>
                        <div class="fl" style="">
                            <input type="text" name="attributes[value][]" placeholder="" value="" class="z_input z_border z_ptb7 z_w200">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--栏目-->
        <div class="z_border_b">
            <div class=" z_font14 z_mt15 z_mb5 ">
                可选颜色<span class="z_color_9 z_lineh30">（可添加多个选项）</span>
                <a href="javascript:void(0);"
                   class="z_btn bar-Grey-ef z_color_3 z_font12 z_border z_ptb6 z_w100 js-z_add">+添加</a>
            </div>
        </div>
        <!--栏目 end-->
        <div class="z_mb30 z_mt20 js-inputbox">
            <div class="z_user_msg z_user_msg2 z_w100p clearfix posr">
                <span class="z_off2 js-z_off"></span>
                <div class="fl z_mr20">
                    <div class="z_inputbox clearfix z_mb10">
                        <label class="z_w60 z_lineh30 z_font12 z_color_6 fl"><span class="z_color_red">*</span>颜色</label>
                        <div class="fl" style="">
                            <input type="text" name="colours[name][]" placeholder="" value="" class="z_input z_border z_ptb7 z_w200">
                        </div>
                    </div>
                    <div class="z_inputbox clearfix z_mb10">
                        <label class="z_w60 z_lineh30 z_font12 z_color_6 fl"><span class="z_color_red">*</span>价格</label>
                        <div class="fl" style="">
                            <input type="text" name="colours[price][]" placeholder="" value="" class="z_input z_border z_ptb7 z_w200">
                        </div>
                    </div>
                </div>
                <div class="fl">
                    <label class="z_w80 z_lineh30 z_font12 z_color_6 fl"><span class="z_color_red">*</span>对应缩略图</label>
                    <div class="fl clearfix" style="">
                        <div class="z_img_fix z_img_fix2 fl z_mb10 z_mr10">
                            <div class="z_img hide">
                                <img/>
                            </div>
                            <div class="z_font12 z_color_3 tc z_mt60"></div>
                            <input type="file" name="picture">
                            <input type="hidden" name="colours[picture][]">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--栏目-->
        <div class="z_border_b">
            <div class=" z_font14 z_mt15 z_mb5 ">
                <span class="z_color_red">*</span>产品大图<span class="z_color_9 z_lineh30">（最多可添加6张图片）</span>
            </div>
        </div>
        <!--栏目 end-->
        <div class="clearfix z_mt20 z_mb20">
            <div class="z_img_fix z_img_fix2 fl z_mb10 z_mr10">
                <div class="z_font12 z_color_3 tc z_mt60"></div>
                <input type="file" name="gallery"/>
            </div>
        </div>
        <div class="z_border_b">
            <div class=" z_font14 z_mt15 z_mb5 ">
                <span class="z_color_red">*</span>产品详情说明
            </div>
        </div>
        <div class="clearfix z_mt20 z_mb20">
            <div class="z_w600">
                <textarea name="overview"></textarea>
            </div>
        </div>
    </div>
    <div class="tc z_mb40">
        <input type="button" value="添加" class="z_btn bar-auburn z_font14 z_w120 z_ptb7 j-submit"/>
    </div>
    <!--新增产品 end-->
</div>
@endsection