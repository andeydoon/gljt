@extends('admin.layouts.master')

@section('style')
<style type="text/css">
</style>
@endsection

@section('js')
@endsection

@section('script')
<script type="text/javascript">
    $('.select2').select2({
        minimumResultsForSearch: Infinity
    });

    $('#category_parent').change(function () {
        $('#category').empty().append($('<option/>', {'value': '', 'text': '选择类型'}));
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
</script>
@endsection

@section('content')
<section class="content-header">
    <h1>
        材质编辑
    </h1>
    <ol class="breadcrumb">
        <li><a href="/admin">首页</a></li>
        <li><a href="/admin/material">材质列表</a></li>
        <li class="active">材质编辑</li>
    </ol>
</section>
<section class="content">
    {!! \Krucas\Notification\Facades\Notification::showAll() !!}
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <form class="form-horizontal" method="post" action="{{ route('admin.material.update', $material) }}">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="nickname" class="col-sm-2 control-label">ID</label>
                            <div class="col-sm-10">
                                <p class="form-control-static">{{ $material->id }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="category_parent" class="col-sm-2 control-label">分类</label>
                            <div class="col-sm-10">
                                <select class="form-control select2" id="category_parent">
                                    <option value="">选择分类</option>
                                    @foreach($category_parent as $key=>$value)
                                        <option{!! $material->category->parent->id==$value->id ? ' selected="selected"' : '' !!} value="{{ $value->id }}">{{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="category" class="col-sm-2 control-label">类型</label>
                            <div class="col-sm-10">
                                <select class="form-control select2" id="category" name="category_id">
                                    <option value="">选择类型</option>
                                    @foreach($material->category->parent->children as $child)
                                        <option{!! $child->id==$material->category_id ? ' selected="selected"' : '' !!} value="{{ $child->id }}">{{ $child->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">名称</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name" placeholder="名称" name="name" value="{{ $material->name }}">
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-info">提交</button>
                        <a href="javascript:window.history.back();" class="btn btn-default pull-right" role="button">取消</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection