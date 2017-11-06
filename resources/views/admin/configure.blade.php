@extends('admin.layouts.master')

@section('css')
<link rel="stylesheet" href="/packages/admin/plugins/daterangepicker/daterangepicker.css">
@endsection

@section('js')
<script src="/packages/admin/plugins/daterangepicker/moment.js"></script>
<script src="/packages/admin/plugins/daterangepicker/daterangepicker.js"></script>
@endsection

@section('script')
<script type="text/javascript">
    $(function () {
        CKEDITOR.replace('register_agreement', {
            height: 350,
            filebrowserUploadUrl: '/admin/upload'
        });

        CKEDITOR.replace('custom_explain', {
            height: 350,
            filebrowserUploadUrl: '/admin/upload'
        });


    })
</script>
@endsection

@section('content')
<section class="content-header">
    <h1>
        配置
    </h1>
    <ol class="breadcrumb">
        <li><a href="/admin">首页</a></li>
        <li class="active">配置</li>
    </ol>
</section>
<section class="content">
    {!! \Krucas\Notification\Facades\Notification::showAll() !!}
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <form class="form-horizontal" method="post" action="{{ route('admin.configure') }}">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="password_old" class="col-sm-2 control-label">保证金</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="bond_amount" value="{{ $bond_amount }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password_old" class="col-sm-2 control-label">定金比例</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="deposit_percent" value="{{ $deposit_percent }}">
                                <span class="help-block">比例数值范围为0-100</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="content" class="col-sm-2 control-label">注册协议</label>
                            <div class="col-sm-10">
                                <textarea id="register_agreement" name="register_agreement">
                                    {{ $register_agreement }}
                                </textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="content" class="col-sm-2 control-label">定制说明</label>
                            <div class="col-sm-10">
                                <textarea id="custom_explain" name="custom_explain">
                                    {{ $custom_explain }}
                                </textarea>
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