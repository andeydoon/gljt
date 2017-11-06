@extends('admin.layouts.master')

@section('script')
<script type="text/javascript">
    $('[name="roles[]"]').change(function () {
        $(this).closest('.col-xs-2').siblings().find(':checkbox').attr('checked', false);

    });
</script>
@endsection

@section('content')
<section class="content-header">
    <h1>
        用户编辑
    </h1>
    <ol class="breadcrumb">
        <li><a href="/admin">首页</a></li>
        <li><a href="/admin/user">用户列表</a></li>
        <li class="active">用户编辑</li>
    </ol>
</section>
<section class="content">
    {!! \Krucas\Notification\Facades\Notification::showAll() !!}
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <form class="form-horizontal" method="post" action="{{ route('admin.user.update', $user) }}">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="nickname" class="col-sm-2 control-label">ID</label>
                            <div class="col-sm-10">
                                <p class="form-control-static">{{ $user->id }}</p>
                            </div>
                        </div>
                        @if($user->parent)
                            <div class="form-group">
                                <label for="nickname" class="col-sm-2 control-label">上级</label>
                                <div class="col-sm-10">
                                    <p class="form-control-static">{{ $user->parent->profile->realname }} ({{ $user->parent->public_id }})</p>
                                </div>
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="nickname" class="col-sm-2 control-label">时间</label>
                            <div class="col-sm-10">
                                <p class="form-control-static">{{ $user->created_at }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="realname" class="col-sm-2 control-label">姓名</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="realname" placeholder="姓名" name="profile[realname]" value="{{ $user->profile->realname }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="mobile" class="col-sm-2 control-label">手机</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="mobile" placeholder="手机" name="mobile" value="{{ $user->mobile }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password" class="col-sm-2 control-label">密码</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="password" placeholder="不修改请留空" name="password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">类型</label>
                            <div class="col-sm-10">
                                <select class="form-control select2" id="type" name="type">
                                    <option{!! $user->type==1 ? ' selected="selected"' : '' !!} value="1">普通用户</option>
                                    <option{!! $user->type==2 ? ' selected="selected"' : '' !!} value="2">师傅</option>
                                    <option{!! $user->type==3 ? ' selected="selected"' : '' !!} value="3">经销商</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">状态</label>
                            <div class="col-sm-10">
                                <select class="form-control select2" id="status" name="status">
                                    <option{!! $user->status==0 ? ' selected="selected"' : '' !!} value="0">待审</option>
                                    <option{!! $user->status==1 ? ' selected="selected"' : '' !!} value="1">通过</option>
                                    <option{!! $user->status==2 ? ' selected="selected"' : '' !!} value="2">拒绝</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">角色</label>
                            <div class="col-sm-10">
                                <div class="row">
                                    @foreach($roles as $role)
                                        <div class="col-xs-2">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="roles[]" value="{{ $role->name }}"{{ $user->hasRole($role->name) ? ' checked' : '' }}> {{ $role->display_name }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password" class="col-sm-2 control-label">绑定ID</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="text" placeholder="绑定ID" name="bind_id" value="{{ $user->bind_id }}">
                                <span class="help-block">角色为师傅或经销商时，请输入绑定ID</span>
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
        @if(in_array($user->type,[2,3]))
            <div class="col-xs-12">
                <div class="box box-success">
                    <div class="box-header with-border">申请资料</div>
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 100px;">真实姓名</th>
                            <td>{{ $user->profile->realname }}</td>
                        </tr>
                        <tr>
                            <th>身份证号码</th>
                            <td>{{ $user->profile->card_number }}</td>
                        </tr>
                        <tr>
                            <th>服务项目</th>
                            <td>
                                @foreach(explode('|', $user->profile->service_item) as $item)
                                    <span class="label label-info">{{ $item }}</span>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th>身份证正面</th>
                            <td><a href="{{ $user->profile->card_front }}" target="_blank"><img src="{{ $user->profile->card_front }}" class="col-xs-3 img-thumbnail"></a></td>
                        </tr>
                        <tr>
                            <th>身份证反面</th>
                            <td><a href="{{ $user->profile->card_back }}" target="_blank"><img src="{{ $user->profile->card_back }}" class="col-xs-3 img-thumbnail"></a></td>
                        </tr>
                        <tr>
                            <th>身份证手持</th>
                            <td><a href="{{ $user->profile->card_hold }}" target="_blank"><img src="{{ $user->profile->card_hold }}" class="col-xs-3 img-thumbnail"></a></td>
                        </tr>
                        @if($user->type==3)
                            <tr>
                                <th>营业执照</th>
                                <td><a href="{{ $user->profile->business_license }}" target="_blank"><img src="{{ $user->profile->business_license }}" class="col-xs-3 img-thumbnail"></a></td>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>
        @endif
    </div>
</section>
@endsection