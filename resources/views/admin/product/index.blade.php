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
    var PRODUCT_STATUSES = {!! json_encode($product_statuses) !!};
    var PRODUCT_TYPES = {!! json_encode([1 => '单个产品', 2 => '组合产品']) !!};

    $(function () {
        $('#j-user').DataTable({
            'processing': true,
            'serverSide': true,
            'ajax': {
                url: '/api/admin/product?format=datatables',
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
                        return data.name;
                    }
                },
                {
                    'data': 'material',
                    'render': function (data) {
                        return data.name;
                    }
                },
                {'data': 'name'},
                {
                    'data': 'type',
                    'render': function (data) {
                        return PRODUCT_TYPES[data];
                    }
                },
                {
                    'data': 'status',
                    'render': function (data) {
                        return PRODUCT_STATUSES[data];
                    }
                },
                {
                    'data': 'id',
                    'render': function (data) {
                        return '<a class="btn btn-danger btn-xs" href="/admin/product/' + data + '/edit" role="button"><i class="fa fa-edit"></i> 编辑</a>';
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
        产品列表
    </h1>
    <ol class="breadcrumb">
        <li><a href="/admin">首页</a></li>
        <li class="active">产品列表</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">产品列表</h3>
                </div>
                <div class="box-body">
                    <table id="j-user" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>类型</th>
                            <th>材质</th>
                            <th>名称</th>
                            <th>类型</th>
                            <th>状态</th>
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