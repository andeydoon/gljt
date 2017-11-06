@extends('admin.layouts.master')

@section('style')
<style type="text/css">
    .j-galleries .row {
        margin-top: 15px;
    }

    .j-attributes > div, .j-parameters > div, .j-colours > div {
        margin-top: 15px;
        border-bottom: 1px solid #d2d6de;
    }

    .j-attributes > div:last-child, .j-parameters > div:last-child, .j-colours > div:last-child {
        border-bottom: none;
    }
</style>
@endsection

@section('script')
<script type="text/html" id="attribute">
    <div class="row">
        <div class="col-xs-6">
            <div class="form-group">
                <label class="col-sm-2 control-label">名称</label>
                <div class="col-sm-10">
                    <input type="text" name="attributes[label][]" class="form-control">
                </div>
            </div>
        </div>
        <div class="col-xs-6">
            <div class="form-group">
                <label class="col-sm-2 control-label">数值</label>
                <div class="col-sm-10">
                    <input type="text" name="attributes[value][]" class="form-control">
                </div>
            </div>
        </div>
    </div>
</script>
<script type="text/html" id="parameter">
    <div class="row">
        <div class="col-xs-6">
            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">名称</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="parameters[name][]">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">类型</label>
                        <div class="col-sm-10">
                            <select class="form-control select2" name="parameters[type][]">
                                <option value="">选择类型</option>
                                <option value="1">文本框</option>
                                <option value="2">下拉框</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-6">
            <div class="form-group">
                <label class="col-sm-2 control-label">对应值</label>
                <div class="col-sm-10">
                    <textarea class="form-control" name="parameters[items][]" style="height: 83px;"></textarea>
                </div>
            </div>
        </div>
    </div>
</script>
<script type="text/html" id="colour">
    <div class="row">
        <div class="col-xs-6">
            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">颜色</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="colours[name][]">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">价格</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="colours[price][]">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-6">
            <div class="form-group">
                <label class="col-sm-2 control-label">缩略图</label>
                <div class="col-sm-10">
                <span class="fileinput-button">
                    <span>上传</span>
                    <input type="file" class="fileupload picture" name="picture">
                </span>
                    <img class="img-responsive" src="" style="height: 63px;">
                    <input type="hidden" name="colours[picture][]">
                </div>
            </div>
        </div>
    </div>
</script>
<script type="text/javascript">
    $(function () {

        $('.select2').select2({
            minimumResultsForSearch: Infinity
        });

        var $overview = CKEDITOR.replace('overview', {
            height: 350,
            filebrowserUploadUrl: '/admin/upload'
        });

        $('.j-colours').on('click', '.picture', function () {
            $('.picture').fileupload({
                url: '/api/upload',
                headers: {'X-CSRF-TOKEN': Laravel.csrfToken},
                formData: {},
                done: function (e, data) {
                    $.each(data.result.data.files, function (index, file) {
                        var $this = $(e.target);
                        $this.closest('div').children('img').attr('src', file);
                        $this.closest('div').children(':hidden').attr('value', file);
                    });
                }
            });
        });

        $('.j-galleries').on('click', 'a', function () {
            if (confirm('删除本张图片?')) {
                $(this).closest('div').remove();
            }
        });

        $('.gallery').fileupload({
            url: '/api/upload',
            headers: {'X-CSRF-TOKEN': Laravel.csrfToken},
            formData: {},
            done: function (e, data) {
                $.each(data.result.data.files, function (index, file) {
                    $('<div/>').addClass('col-xs-2').append(
                        $('<a/>').append(
                            $('<img>').addClass('img-responsive').prop('src', file)
                        )
                    ).append(
                        $('<input>').prop('type', 'hidden').prop('name', 'galleries[]').prop('value', file)
                    ).appendTo('.j-galleries .row');
                });
            }
        });

        $('.j-attribute').click(function () {
            $('.j-attributes').append($('#attribute').html());
        });

        $('.j-parameter').click(function () {
            $('.j-parameters').append($('#parameter').html());
        });

        $('.j-colour').click(function () {
            $('.j-colours').append($('#colour').html());
        });

        $('.j-submit').click(function () {
            $('[name="overview"]').val($overview.getData());
            $.jAjax({
                url: '/api/admin/product/{{ $product->id }}',
                type: 'PUT',
                data: $('.j-form :input').serialize(),
                success: function (data) {
                    if (data.status == 'success') {
                        alert('产品编辑成功');
                        window.location.reload();
                    }
                }
            });
        });

        $('#category_parent').change(function () {
            $('#category').empty().append($('<option/>', {'value': '', 'text': '选择类型'}));
            $('#material').empty().append($('<option/>', {'value': '', 'text': '选择材质'}));
            if ($(this).val()) {
                $.jAjax({
                    url: '/api/category',
                    data: {'parent_id': $(this).val()},
                    success: function (data) {
                        $.each(data.data.categories, function () {
                            $('#category').append($('<option/>', {'value': this.id, 'text': this.name}));
                        });
                    }
                });
            }
        });

        $('#category').change(function () {
            $('#material').empty().append($('<option/>', {'value': '', 'text': '选择材质'}));
            if ($(this).val()) {
                $.jAjax({
                    url: '/api/material',
                    data: {'category_id': $(this).val()},
                    success: function (data) {
                        $.each(data.data.materials, function () {
                            $('#material').append($('<option/>', {'value': this.id, 'text': this.name}));
                        });
                    }
                });
            }
        });
    })
</script>
@endsection

@section('content')
<section class="content-header">
    <h1>
        产品编辑
    </h1>
    <ol class="breadcrumb">
        <li><a href="/admin">首页</a></li>
        <li><a href="/admin/role">产品列表</a></li>
        <li class="active">产品编辑</li>
    </ol>
</section>
<section class="content">
    {!! \Krucas\Notification\Facades\Notification::showAll() !!}
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <form class="form-horizontal j-form" method="post" action="{{ route('admin.product.update', $product) }}">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="nickname" class="col-sm-2 control-label">ID</label>
                            <div class="col-sm-10">
                                <p class="form-control-static">{{ $product->id }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">用　　户</label>
                            <div class="col-sm-10">
                                <select class="form-control select2" name="user_id">
                                    <option value="0">无</option>
                                    @foreach($dealers as $dealer)
                                        <option{!! $product->user_id==$dealer->id ? ' selected="selected"' : '' !!} value="{{ $dealer->id }}">{{ $dealer->profile->realname }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">状　　态</label>
                            <div class="col-sm-10">
                                <select class="form-control select2" name="status">
                                    @foreach($product_statuses as $key=>$value)
                                        <option{!! $product->status==$key ? ' selected="selected"' : '' !!} value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="category_parent" class="col-sm-2 control-label">分　　类</label>
                            <div class="col-sm-10">
                                <select class="form-control select2" id="category_parent">
                                    <option value="">选择分类</option>
                                    @foreach($category_parent as $category)
                                        <option{!! $category->id==$product->category->parent_id ? ' selected="selected"' : '' !!} value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="category" class="col-sm-2 control-label">类　　型</label>
                            <div class="col-sm-10">
                                <select class="form-control select2" id="category" name="category_id">
                                    <option value="">选择类型</option>
                                    @foreach($product->category->parent->children as $child)
                                        <option{!! $child->id==$product->category_id ? ' selected="selected"' : '' !!} value="{{ $child->id }}">{{ $child->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="material" class="col-sm-2 control-label">材　　质</label>
                            <div class="col-sm-10">
                                <select class="form-control select2" id="material" name="material_id">
                                    <option value="">选择材料</option>
                                    @foreach($product->category->materials as $material)
                                        <option{!! $material->id==$product->material_id ? ' selected="selected"' : '' !!} value="{{ $material->id }}">{{ $material->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-sm-2 control-label">产品名称</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name" placeholder="产品名称" name="name" value="{{ $product->name }}">
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('describe') ? ' has-error' : '' }}">
                            <label for="describe" class="col-sm-2 control-label">产品描述</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="describe" placeholder="产品描述" name="describe" value="{{ $product->describe }}">
                                @if ($errors->has('describe'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('describe') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('unit') ? ' has-error' : '' }}">
                            <label for="unit" class="col-sm-2 control-label">计量单位</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="unit" placeholder="计量单位" name="unit" value="{{ $product->unit }}">
                                @if ($errors->has('unit'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('unit') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                            <label for="price" class="col-sm-2 control-label">单位价格</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="price" placeholder="单位价格" name="price" value="{{ $product->price }}">
                                @if ($errors->has('price'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">产品参数</label>
                            <div class="col-sm-10">
                                <button type="button" class="btn btn-success j-parameter">添加</button>
                                <div class="j-parameters">
                                    @foreach($product->parameters as $parameter)
                                        <div class="row">
                                            <div class="col-xs-6">
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">名称</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" name="old_parameters[{{ $parameter->id }}][name]" value="{{ $parameter->name }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">类型</label>
                                                            <div class="col-sm-10">
                                                                <select class="form-control select2" name="old_parameters[{{ $parameter->id }}][type]">
                                                                    <option value="">选择类型</option>
                                                                    <option{!! $parameter->type==1 ? ' selected="selected"' : '' !!} value="1">文本框</option>
                                                                    <option{!! $parameter->type==2 ? ' selected="selected"' : '' !!} value="2">下拉框</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-6">
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">对应值</label>
                                                    <div class="col-sm-10">
                                                        <textarea class="form-control" name="old_parameters[{{ $parameter->id }}][items]" style="height: 83px;">{{ $parameter->items }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">产品属性</label>
                            <div class="col-sm-10">
                                <button type="button" class="btn btn-success j-attribute">添加</button>
                                <div class="j-attributes">
                                    @foreach($product->attributes as $attribute)
                                        <div class="row">
                                            <div class="col-xs-6">
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">名称</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="old_attributes[{{ $attribute->id }}][label]" class="form-control" value="{{ $attribute->label }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-6">
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">数值</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="old_attributes[{{ $attribute->id }}][value]" class="form-control" value="{{ $attribute->value }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">可选颜色</label>
                            <div class="col-sm-10">
                                <button type="button" class="btn btn-success j-colour">添加</button>
                                <div class="j-colours">
                                    @foreach($product->colours as $colour)
                                        <div class="row">
                                            <div class="col-xs-6">
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">颜色</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" name="old_colours[{{ $colour->id }}][name]" value="{{ $colour->name }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">价格</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" name="old_colours[{{ $colour->id }}][price]" value="{{ $colour->price }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-6">
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">缩略图</label>
                                                    <div class="col-sm-10">
                                                        <span class="fileinput-button">
                                                            <span>上传</span>
                                                            <input type="file" class="fileupload picture" name="picture">
                                                        </span>
                                                        <img class="img-responsive" src="{{ $colour->picture }}" style="height: 63px;">
                                                        <input type="hidden" name="old_colours[{{ $colour->id }}][picture]" value="{{ $colour->picture }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">产品大图</label>
                            <div class="col-sm-10 j-galleries">
                                <span class="btn btn-success fileinput-button">
                                    <span>上传</span>
                                    <input type="file" class="fileupload gallery" name="gallery">
                                </span>
                                <div class="row">
                                    @foreach($product->galleries as $gallery)
                                        <div class="col-xs-2">
                                            <a>
                                                <img class="img-responsive" src="{{ $gallery->src }}">
                                            </a>
                                            <input type="hidden" name="old_galleries[{{ $gallery->id }}]" value="{{ $gallery->src }}">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="overview" class="col-sm-2 control-label">产品详情</label>
                            <div class="col-sm-10">
                                <textarea id="overview" name="overview">
                                    {{ $product->overview }}
                                </textarea>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="button" class="btn btn-info j-submit">提交</button>
                        <a href="javascript:window.history.back();" class="btn btn-default pull-right" role="button">取消</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection