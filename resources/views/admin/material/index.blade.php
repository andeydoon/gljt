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
        var $table = $('#j-material').DataTable({
            'processing': true,
            'serverSide': true,
            'language': {
                searchPlaceholder: '输入名称'
            },
            'ajax': {
                url: '/api/admin/material',
                headers: {'X-CSRF-TOKEN': Laravel.csrfToken}
            },
            'columnDefs': [
                {'orderable': false, 'targets': -1}
            ],
            'columns': [
                {'data': 'id'},
                {
                    'data': 'category',
                    'render': function (data) {
                        if (data == null) {
                            return '-';
                        }

                        return data.name;
                    }
                },
                {'data': 'name'},
                {
                    'data': 'id',
                    'render': function (data) {
                        return '<a class="btn btn-danger btn-xs" href="/admin/material/' + data + '/edit" role="button"><i class="fa fa-edit"></i> 编辑</a> <button type="button" class="btn btn-warning btn-xs j-delete" data-id="' + data + '"><i class="fa fa-trash"></i> 删除</button> ';
                    }
                },
            ]
        });

        $('#j-material').on('click', '.j-delete', function () {
            if (confirm('您确定删除此行数据吗？')) {
                var id = $(this).data('id');
                $.jAjax({
                    type: 'DELETE',
                    url: '/api/admin/material/' + id,
                    headers: {'X-CSRF-TOKEN': Laravel.csrfToken},
                    dataType: 'json',
                    success: function (data) {
                        if (data.status == 'success') {
                            $table.ajax.reload(null, false);
                        }
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
        材质列表
    </h1>
    <ol class="breadcrumb">
        <li><a href="/admin">首页</a></li>
        <li class="active">材质列表</li>
    </ol>
</section>
<section class="content">
    {!! \Krucas\Notification\Facades\Notification::showAll() !!}
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">材质列表</h3>
                </div>
                <div class="box-body">
                    <table id="j-material" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>类型</th>
                            <th>名称</th>
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