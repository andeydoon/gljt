@extends('admin.layouts.master')

@section('style')
<style type="text/css">
    .j-order_service_picture img { padding: 5px; }
</style>
@endsection

@section('js')
@endsection

@section('script')
<script type="text/javascript">
    $('.select2').select2({
        minimumResultsForSearch: Infinity
    });

    $('.j-status-submit').click(function () {
        $.jAjax({
            url: '/api/admin/order/{{ $order->id }}',
            type: 'PATCH',
            data: $('.j-status-modal :input').serialize(),
            success: function (data) {
                if (data.status == 'success') {
                    $('.j-status-modal').modal('hide');
                    $('.j-status-modal').on('hidden.bs.modal', function (e) {
                        alert('修改成功');
                        window.location.reload();
                    });
                }
            }
        });
    });

    $('.j-assign-submit').click(function () {
        $.jAjax({
            url: '/api/admin/order/{{ $order->id }}',
            type: 'PATCH',
            data: $('.j-assign-modal :input').serialize(),
            success: function (data) {
                if (data.status == 'success') {
                    $('.j-assign-modal').modal('hide');
                    $('.j-assign-modal').on('hidden.bs.modal', function (e) {
                        alert('修改成功');
                        window.location.reload();
                    });
                }
            }
        });
    });

    $('.j-assign-modal .j-dealer').change(function () {
        $('.j-assign-modal .j-master option[value!=0]').remove();
        var $this = $(this);
        if ($this.val()) {
            $.jAjax({
                url: '/api/admin/user',
                type: 'GET',
                data: {'type': 2, 'status': 1, 'finder_id': $this.val()},
                success: function (data) {
                    if (data.status == 'success') {
                        $.each(data.data.users, function () {
                            $('.j-assign-modal .j-master').append($('<option/>', {
                                value: this.id,
                                text: this.profile.realname,
                            }))
                        })
                    }
                }
            });
        }
    });
</script>
@endsection

@section('content')
<?php $statuses = [1 => ['等待接单', '等待测量', '待付定金', '等待制作', '待付尾款', '等待发货', '等待收货', '等待安装', '订单完成', 101 => '订单取消'], 2 => ['等待接单', '等待上门', '等待付款', '等待服务', '订单完成', 101 => '订单取消']] ?>
<section class="content-header">
    <h1>
        订单列表
    </h1>
    <ol class="breadcrumb">
        <li><a href="/admin">首页</a></li>
        <li><a href="/admin/order">订单列表</a></li>
        <li class="active">订单编辑</li>
    </ol>
</section>
<section class="content">
    {!! \Krucas\Notification\Facades\Notification::showAll() !!}
    <div class="row">
        <div class="col-xs-6">
            <div class="box box-primary">
                <form class="form-horizontal" method="post" action="{{ route('admin.order.update', $order) }}">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="nickname" class="col-sm-2 control-label">ID</label>
                            <div class="col-sm-10">
                                <p class="form-control-static">{{ $order->id }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nickname" class="col-sm-2 control-label">流水号</label>
                            <div class="col-sm-10">
                                <p class="form-control-static">{{ $order->trade_id }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sn" class="col-sm-2 control-label">用户</label>
                            <div class="col-sm-10">
                                <p class="form-control-static">{{ $order->member->mobile }}</p>
                            </div>
                        </div>
                        @if($order->dealer)
                            <div class="form-group">
                                <label for="sn" class="col-sm-2 control-label">经销商</label>
                                <div class="col-sm-10">
                                    <p class="form-control-static">{{ $order->dealer->profile->realname }}</p>
                                </div>
                            </div>
                        @endif
                        @if($order->master)
                            <div class="form-group">
                                <label for="sn" class="col-sm-2 control-label">师傅</label>
                                <div class="col-sm-10">
                                    <p class="form-control-static">{{ $order->master->profile->realname }}</p>
                                </div>
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="sn" class="col-sm-2 control-label">类型</label>
                            <div class="col-sm-10">
                                <?php $types = [1 => '定制', 2 => '服务'] ?>
                                <p class="form-control-static">{{ $types[$order->type] }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sn" class="col-sm-2 control-label">金额</label>
                            <div class="col-sm-10">
                                <p class="form-control-static">{{ $order->total }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="status" class="col-sm-2 control-label">状态</label>
                            <div class="col-sm-10">
                                <p class="form-control-static">{{ $statuses[$order->type][$order->status] }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target=".j-status-modal">修改状态</button>
                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target=".j-assign-modal">修改分配</button>
                        <a href="javascript:window.history.back();" class="btn btn-default pull-right" role="button">取消</a>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-xs-6">
            <div class="row">
                @if($order->type==1)
                    <div class="col-xs-12">
                        <div class="box box-success">
                            <div class="box-header with-border">定制</div>
                            <table class="table table-bordered">
                                <tr>
                                    <th>名称</th>
                                    <td>{{ $order->custom->product->name }}</td>
                                </tr>
                                <tr>
                                    <th>颜色</th>
                                    <td>{{ $order->custom->product_colour->name }}</td>
                                </tr>
                                <tr>
                                    <th>数量</th>
                                    <td>{{ $order->quantity }}</td>
                                </tr>
                                <tr>
                                    <th>单价</th>
                                    <td>{{ $order->custom->product->price }}</td>
                                </tr>
                                <tr>
                                    <th>总价</th>
                                    <td>{{ $order->total }}</td>
                                </tr>
                                <tr>
                                    <th>详情</th>
                                    <td>{{ $order->custom->content }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                @endif
                @if($order->type==2)
                    <div class="col-xs-12">
                        <div class="box box-success">
                            <div class="box-header with-border">服务</div>
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 100px;">名称</th>
                                    <td>{{ $order->service->service->name }}</td>
                                </tr>
                                <tr>
                                    <th>数量</th>
                                    <td>{{ $order->quantity }}</td>
                                </tr>
                                <tr>
                                    <th>总价</th>
                                    <td>{{ $order->total }}</td>
                                </tr>
                                <tr>
                                    <th>详情</th>
                                    <td>{{ $order->service->content }}</td>
                                </tr>
                                <tr>
                                    <th>图片</th>
                                    <td class="row j-order_service_picture">
                                        @foreach(explode(';', $order->service->pictures) as $picture)
                                            <a href="{{ $picture }}" target="_blank"><img src="{{ $picture }}" class="col-xs-3 img-thumbnail"></a>
                                        @endforeach
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                @endif
                <div class="col-xs-12">
                    <div class="box box-success">
                        <div class="box-header with-border">地址</div>
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 100px;">姓名</th>
                                <td>{{ $order->address->name }}</td>
                            </tr>
                            <tr>
                                <th>电话</th>
                                <td>{{ $order->address->phone }}</td>
                            </tr>
                            <tr>
                                <th>地区</th>
                                <td>{{ $order->address->province->name }} {{ $order->address->city->name }} {{ $order->address->district->name }}</td>
                            </tr>
                            <tr>
                                <th>地址</th>
                                <td>{{ $order->address->street }}</td>
                            </tr>
                            <tr>
                                <th>楼层</th>
                                <td>{{ $order->address->floor }}</td>
                            </tr>
                            <tr>
                                <th>电梯</th>
                                <td>{{ $order->address->lift ? '有' : '无' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade j-status-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">修改状态</h4>
                </div>
                <div class="modal-body">
                    <select class="form-control" name="status">
                        @if($order->type==1)
                            @foreach(['等待接单', '等待测量', '待付定金', '等待制作', '待付尾款', '等待发货', '等待收货', '等待安装', '订单完成', 101=>'订单取消'] as $key=>$value)
                                <option{!! $order->status==$key ? ' selected="selected"' : '' !!} value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        @endif
                        @if($order->type==2)
                            @foreach(['等待接单', '等待上门', '等待付款', '等待服务', '订单完成', 101=>'订单取消'] as $key=>$value)
                                <option{!! $order->status==$key ? ' selected="selected"' : '' !!} value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary j-status-submit">提交</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade j-assign-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">修改分配</h4>
                </div>
                <div class="modal-body">
                    @if($order->type==1)
                        <select class="form-control j-dealer" name="dealer_id">
                            <option{!! !$order->dealer_id ? ' selected="selected"' : '' !!} value="0">选择经销商</option>
                            @foreach($dealers as $dealer)
                                <option{!! $order->dealer_id==$dealer->id ? ' selected="selected"' : '' !!} value="{{ $dealer->id }}">{{ $dealer->profile->realname }}</option>
                            @endforeach
                        </select>
                    @endif
                    <select class="form-control j-master" name="master_id">
                        <option{!! !$order->master_id ? ' selected="selected"' : '' !!} value="0">选择师傅</option>
                        @if(isset($masters))
                            @foreach($masters as $master)
                                <option{!! $order->master_id==$master->id ? ' selected="selected"' : '' !!} value="{{ $master->id }}">{{ $master->profile->realname }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary j-assign-submit">提交</button>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection