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
</script>
@endsection

@section('content')
<section class="content-header">
    <h1>
        分类编辑
    </h1>
    <ol class="breadcrumb">
        <li><a href="/admin">首页</a></li>
        <li><a href="/admin/category">分类列表</a></li>
        <li class="active">分类编辑</li>
    </ol>
</section>
<section class="content">
    {!! \Krucas\Notification\Facades\Notification::showAll() !!}
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <form class="form-horizontal" method="post" action="{{ route('admin.category.update', $category) }}">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="nickname" class="col-sm-2 control-label">ID</label>
                            <div class="col-sm-10">
                                <p class="form-control-static">{{ $category->id }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="parent" class="col-sm-2 control-label">父级</label>
                            <div class="col-sm-10">
                                <select class="form-control select2" id="parent" name="parent_id">
                                    <option value="0">无</option>
                                    @foreach($category_parent as $key=>$value)
                                        <option{!! $category->parent_id==$value->id ? ' selected="selected"' : '' !!} value="{{ $value->id }}">{{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">名称</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name" placeholder="名称" name="name" value="{{ $category->name }}">
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