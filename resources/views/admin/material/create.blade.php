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
        新材质
    </h1>
    <ol class="breadcrumb">
        <li><a href="/admin">首页</a></li>
        <li><a href="/admin/material">材质列表</a></li>
        <li class="active">新材质</li>
    </ol>
</section>
<section class="content">
    {!! \Krucas\Notification\Facades\Notification::showAll() !!}
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <form class="form-horizontal" method="post" action="{{ route('admin.material.store') }}">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group{{ $errors->has('category_parent') ? ' has-error' : '' }}">
                            <label for="category_parent" class="col-sm-2 control-label">分类</label>
                            <div class="col-sm-10">
                                <select class="form-control select2" id="category_parent">
                                    <option value="">选择分类</option>
                                    @foreach($category_parent as $key=>$value)
                                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('category_parent'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('category_parent') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('category_id') ? ' has-error' : '' }}">
                            <label for="category" class="col-sm-2 control-label">类型</label>
                            <div class="col-sm-10">
                                <select class="form-control select2" id="category" name="category_id">
                                    <option value="">选择类型</option>
                                </select>
                                @if ($errors->has('category_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('category_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-sm-2 control-label">名称</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name" placeholder="名称" name="name" value="{{ old('name') }}">
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
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