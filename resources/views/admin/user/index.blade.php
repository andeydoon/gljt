@extends('admin.layouts.master')

@section('css')
<link rel="stylesheet" href="/packages/admin/plugins/datatables/dataTables.bootstrap.css">
@endsection

@section('js')
<script src="/packages/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/packages/admin/plugins/datatables/dataTables.bootstrap.min.js"></script>
@endsection

@section('script')
<script type="text/javascript">
    $(function () {
        $('#js-user').DataTable({
            'processing': true,
            'serverSide': true,
            'ajax': {
                url: '/api/admin/user?format=datatables',
                headers: {'X-CSRF-TOKEN': Laravel.csrfToken}
            },
            'columnDefs': [
                {'orderable': false, 'targets': -1}
            ],
            'columns': [
                {'data': 'id'},
                {'data': 'public_id'},
                {
                    'data': 'profile',
                    'render': function (data) {
                        return data.realname;
                    }
                },
                {'data': 'mobile'},
                {
                    'data': 'status',
                    'render': function (data) {
                        var types = {
                            0: '待审',
                            1: '通过',
                            2: '拒绝'
                        };
                        return types[data];
                    }
                },
                {
                    'data': 'type',
                    'render': function (data) {
                        var types = {
                            1: '普通用户',
                            2: '师傅',
                            3: '经销商'
                        };
                        return types[data];
                    }
                },
                {'data': 'created_at'},
                {
                    'data': 'id',
                    'render': function (data) {
                        return '<a class="btn btn-danger btn-xs" href="/admin/user/' + data + '/edit" role="button"><i class="fa fa-edit"></i> 编辑</a>';
                    }
                },
            ]
        });
    })
</script>
@endsection

@section('content')
<section class="content-header">
    <h1>
        用户列表
    </h1>
    <ol class="breadcrumb">
        <li><a href="/admin">首页</a></li>
        <li class="active">用户列表</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">用户列表</h3>
                </div>
                <div class="box-body">
                    <table id="js-user" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>公开ID</th>
                            <th>姓名</th>
                            <th>手机</th>
                            <th>状态</th>
                            <th>类型</th>
                            <th>注册时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection