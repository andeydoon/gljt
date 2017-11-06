@extends('admin.layouts.master')

@section('content')
<section class="content-header">
    <h1>
        角色编辑
    </h1>
    <ol class="breadcrumb">
        <li><a href="/admin">首页</a></li>
        <li><a href="/admin/role">角色列表</a></li>
        <li class="active">角色编辑</li>
    </ol>
</section>
<section class="content">
    {!! \Krucas\Notification\Facades\Notification::showAll() !!}
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <form class="form-horizontal" method="post" action="{{ route('admin.role.update', $role) }}">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="nickname" class="col-sm-2 control-label">ID</label>
                            <div class="col-sm-10">
                                <p class="form-control-static">{{ $role->id }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nickname" class="col-sm-2 control-label">名称</label>
                            <div class="col-sm-10">
                                <p class="form-control-static">{{ $role->display_name }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nickname" class="col-sm-2 control-label">描述</label>
                            <div class="col-sm-10">
                                <p class="form-control-static">{{ $role->description }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nickname" class="col-sm-2 control-label">权限</label>
                            <div class="col-sm-10">
                                <div class="row">
                                    @foreach($permissions as $permission)
                                        <div class="col-xs-2">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"{{ $role->hasPermission($permission->name) ? ' checked' : '' }}> {{ $permission->display_name }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
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