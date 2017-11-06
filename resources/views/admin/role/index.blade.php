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
        $('#j-user').DataTable({
            'processing': true,
            'serverSide': true,
            'ajax': {
                url: '/api/admin/role?format=datatables',
                headers: {'X-CSRF-TOKEN': Laravel.csrfToken}
            },
            'columnDefs': [
                {'orderable': false, 'targets': -1}
            ],
            'columns': [
                {'data': 'id'},
                {'data': 'display_name'},
                {'data': 'description'},
                {
                    'data': 'id',
                    'render': function (data) {
                        return '<a class="btn btn-danger btn-xs" href="/admin/role/' + data + '/edit" role="button"><i class="fa fa-edit"></i> 编辑</a>';
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
        角色列表
    </h1>
    <ol class="breadcrumb">
        <li><a href="/admin">首页</a></li>
        <li class="active">角色列表</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">角色列表</h3>
                </div>
                <div class="box-body">
                    <table id="j-user" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>名称</th>
                            <th>描述</th>
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