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
        $('#j-order').DataTable({
            'processing': true,
            'serverSide': true,
            'ajax': {
                url: '/api/admin/order',
                headers: {'X-CSRF-TOKEN': Laravel.csrfToken}
            },
            'columnDefs': [
                {'orderable': false, 'targets': -1}
            ],
            'columns': [
                {'data': 'id'},
                {'data': 'trade_id'},
                {
                    'data': 'member',
                    'name': 'member.mobile',
                    'render': function (data) {
                        return data.mobile;
                    }
                },
                {
                    'data': 'type',
                    'render': function (data) {
                        var types = {
                            1: '定制',
                            2: '服务'
                        };
                        return types[data];
                    }
                },
                {'data': 'total'},
                {
                    'data': status,
                    'render': function (data, type, row) {
                        var statuses = {
                            1: {
                                0: '等待接单',
                                1: '等待测量',
                                2: '待付定金',
                                3: '等待制作',
                                4: '待付尾款',
                                5: '等待发货',
                                6: '等待收货',
                                7: '等待安装',
                                8: '订单完成',
                                101: '订单取消'
                            },
                            2: {
                                0: '等待接单',
                                1: '等待上门',
                                2: '等待付款',
                                3: '等待服务',
                                4: '订单完成',
                                101: '订单取消'
                            }
                        };

                        return statuses[row.type][row.status];
                    }
                },
                {
                    'data': 'id',
                    'render': function (data) {
                        return '<a class="btn btn-danger btn-xs" href="/admin/order/' + data + '/edit" role="button"><i class="fa fa-edit"></i> 编辑</a>';
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
        订单列表
    </h1>
    <ol class="breadcrumb">
        <li><a href="/admin">首页</a></li>
        <li class="active">订单列表</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">订单列表</h3>
                </div>
                <div class="box-body">
                    <table id="j-order" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>流水号</th>
                            <th>用户</th>
                            <th>类型</th>
                            <th>金额</th>
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