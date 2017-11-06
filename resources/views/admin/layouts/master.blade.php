<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name', 'Gljt') }}</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="/packages/admin/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/packages/admin/plugins/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/packages/admin/plugins/ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="/packages/admin/plugins/select2/select2.min.css">
    <link rel="stylesheet" href="/packages/admin/plugins/jQueryFileUpload/css/jquery.fileupload.css">
    <link rel="stylesheet" href="/packages/admin/plugins/jQueryFileUpload/css/jquery.fileupload-ui.css">
    @yield('css')
    <link rel="stylesheet" href="/packages/admin/css/AdminLTE.min.css">
    <link rel="stylesheet" href="/packages/admin/css/skins/_all-skins.min.css">
    @yield('style')
    <!--[if lt IE 9]>
    <script src="/packages/admin/plugins/html5shiv/html5shiv.min.js"></script>
    <script src="/packages/admin/plugins/respond/respond.min.js"></script>
    <![endif]-->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    <header class="main-header">
        <a href="/admin" class="logo">
            <span class="logo-mini"><b>GL</b></span>
            <span class="logo-lg"><b>广铝</b>集团</span>
        </a>
        <nav class="navbar navbar-static-top">
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="/packages/admin/img/user-160x160.jpg" class="user-image" alt="User Image">
                            <span class="hidden-xs">{{ auth()->user()->public_id }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="user-header">
                                <img src="/packages/admin/img/user-160x160.jpg" class="img-circle" alt="User Image">
                                <p>
                                    {{ auth()->user()->public_id }}
                                    <small>{{ auth()->user()->created_at }}</small>
                                </p>
                            </li>
                            <li class="user-footer">
                                <div class="pull-left">
                                </div>
                                <div class="pull-right">
                                    <a href="{{ route('admin.logout') }}" class="btn btn-default btn-flat">退出</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <aside class="main-sidebar">
        <section class="sidebar">
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="/packages/admin/img/user-160x160.jpg" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p>{{ auth()->user()->public_id }}</p>
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>
            <ul class="sidebar-menu">
                <li class="header">主导航</li>
                @if(auth()->user()->hasPermission('dashboard'))<li{!! request()->is('admin/dashboard') ? ' class="active"' : '' !!}><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> <span>控制台</span></a></li>@endif
                @if(auth()->user()->hasPermission('order'))<li{!! request()->is('admin/order') ? ' class="active"' : '' !!}><a href="{{ route('admin.order.index') }}"><i class="fa fa-files-o"></i> <span>订单管理</span></a></li>@endif
                @if(auth()->user()->hasPermission('category'))
                    <li class="treeview{{ request()->is('admin/category*') ? ' active' : '' }}">
                        <a href="#">
                            <i class="fa fa-clone"></i>
                            <span>分类管理</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li{!! request()->is('admin/category') ? ' class="active"' : '' !!}><a href="{{ route('admin.category.index') }}"><i class="fa fa-circle-o"></i> 分类列表</a></li>
                            <li{!! request()->is('admin/category/create') ? ' class="active"' : '' !!}><a href="{{ route('admin.category.create') }}"><i class="fa fa-circle-o"></i> 新分类</a></li>
                        </ul>
                    </li>
                @endif
                @if(auth()->user()->hasPermission('material'))
                    <li class="treeview{{ request()->is('admin/material*') ? ' active' : '' }}">
                        <a href="#">
                            <i class="fa fa-recycle"></i>
                            <span>材质管理</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li{!! request()->is('admin/material') ? ' class="active"' : '' !!}><a href="{{ route('admin.material.index') }}"><i class="fa fa-circle-o"></i> 材质列表</a></li>
                            <li{!! request()->is('admin/material/create') ? ' class="active"' : '' !!}><a href="{{ route('admin.material.create') }}"><i class="fa fa-circle-o"></i> 新材质</a></li>
                        </ul>
                    </li>
                @endif
                @if(auth()->user()->hasPermission('product'))
                    <li class="treeview{{ request()->is('admin/product*') ? ' active' : '' }}">
                        <a href="#">
                            <i class="fa fa-cubes"></i>
                            <span>产品管理</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li{!! request()->is('admin/product') ? ' class="active"' : '' !!}><a href="{{ route('admin.product.index') }}"><i class="fa fa-circle-o"></i> 产品列表</a></li>
                            <li{!! request()->is('admin/product/create') ? ' class="active"' : '' !!}><a href="{{ route('admin.product.create') }}"><i class="fa fa-circle-o"></i> 新产品</a></li>
                        </ul>
                    </li>
                @endif
                @if(auth()->user()->hasPermission('user'))
                    <li class="treeview{{ request()->is('admin/user*') ? ' active' : '' }}">
                        <a href="#">
                            <i class="fa fa-users"></i>
                            <span>用户管理</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li{!! request()->is('admin/user') ? ' class="active"' : '' !!}><a href="{{ route('admin.user.index') }}"><i class="fa fa-circle-o"></i> 用户列表</a></li>
{{--                            <li{!! request()->is('admin/user/create') ? ' class="active"' : '' !!}><a href="{{ route('admin.user.create') }}"><i class="fa fa-circle-o"></i> 新用户</a></li>--}}
                        </ul>
                    </li>
                @endif
                @if(auth()->user()->hasPermission('role'))
                    <li class="treeview{{ request()->is('admin/role*') ? ' active' : '' }}">
                        <a href="#">
                            <i class="fa fa-sitemap"></i>
                            <span>角色管理</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li{!! request()->is('admin/role') ? ' class="active"' : '' !!}><a href="{{ route('admin.role.index') }}"><i class="fa fa-circle-o"></i> 角色列表</a></li>
{{--                            <li{!! request()->is('admin/coupon/create') ? ' class="active"' : '' !!}><a href="{{ route('admin.coupon.create') }}"><i class="fa fa-circle-o"></i> 新权限</a></li>--}}
                        </ul>
                    </li>
                @endif
                {{--<li class="treeview{{ request()->is('admin/permission*') ? ' active' : '' }}">--}}
                    {{--<a href="#">--}}
                        {{--<i class="fa fa-random"></i>--}}
                        {{--<span>权限管理</span>--}}
                        {{--<span class="pull-right-container">--}}
                            {{--<i class="fa fa-angle-left pull-right"></i>--}}
                        {{--</span>--}}
                    {{--</a>--}}
                    {{--<ul class="treeview-menu">--}}
                        {{--<li{!! request()->is('admin/permission') ? ' class="active"' : '' !!}><a href="{{ route('admin.permission.index') }}"><i class="fa fa-circle-o"></i> 权限列表</a></li>--}}
                        {{--<li{!! request()->is('admin/permission/create') ? ' class="active"' : '' !!}><a href="{{ route('admin.permission.create') }}"><i class="fa fa-circle-o"></i> 新权限</a></li>--}}
                    {{--</ul>--}}
                {{--</li>--}}
                @if(auth()->user()->hasPermission('coupon'))
                    <li class="treeview{{ request()->is('admin/coupon*') ? ' active' : '' }}">
                        <a href="#">
                            <i class="fa fa-ticket"></i>
                            <span>优惠券管理</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li{!! request()->is('admin/coupon') ? ' class="active"' : '' !!}><a href="{{ route('admin.coupon.index') }}"><i class="fa fa-circle-o"></i> 优惠券列表</a></li>
                            <li{!! request()->is('admin/coupon/create') ? ' class="active"' : '' !!}><a href="{{ route('admin.coupon.create') }}"><i class="fa fa-circle-o"></i> 新优惠券</a></li>
                        </ul>
                    </li>
                @endif
                @if(auth()->user()->hasPermission('configure'))<li{!! request()->is('admin/configure') ? ' class="active"' : '' !!}><a href="{{ route('admin.configure') }}"><i class="fa fa-cogs"></i> <span>配置</span></a></li>@endif
            </ul>
        </section>
    </aside>
    <div class="content-wrapper">
        @yield('content')
    </div>
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 1.0.0
        </div>
        <strong>Copyright &copy; 2017 <a href="http://www.ruanjiekeji.com/" target="_blank">软捷科技</a>.</strong> All
        rights
        reserved.
    </footer>
    <div class="control-sidebar-bg"></div>
</div>
<script src="/packages/admin/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="/packages/admin/bootstrap/js/bootstrap.min.js"></script>
<script src="/packages/admin/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="/packages/admin/plugins/fastclick/fastclick.js"></script>
<script src="/packages/admin/plugins/select2/select2.full.min.js"></script>
<script src="/packages/admin/plugins/ckeditor/ckeditor.js"></script>
<script src="/packages/admin/plugins/jQueryFileUpload/js/vendor/jquery.ui.widget.js"></script>
<script src="/packages/admin/plugins/jQueryFileUpload/js/jquery.iframe-transport.js"></script>
<script src="/packages/admin/plugins/jQueryFileUpload/js/jquery.fileupload.js"></script>
@yield('js')
<script src="/packages/admin/js/app.min.js"></script>
<script type="text/javascript">
    $.extend({
        jAjax: function (url, options) {
            if (typeof url === "object") {
                options = url;
                url = undefined;
            }
            var fn = {
                headers: {},
                error: function (jqXHR, textStatus, errorThrown) {
                },
                success: function (data, textStatus, jqXHR) {
                }
            }
            if (options.headers) {
                fn.headers = options.headers;
            }
            if (options.error) {
                fn.error = options.error;
            }
            if (options.success) {
                fn.success = options.success;
            }
            var options = $.extend(options, {
                headers: $.extend({
                    'X-CSRF-TOKEN': Laravel.csrfToken
                }, fn.headers),
                error: function (jqXHR, textStatus, errorThrown) {
                    fn.error(jqXHR, textStatus, errorThrown);
                },
                success: function (data, textStatus, jqXHR) {
                    if (data.status == 'error') {
                        alert(data.message);
                        return;
                    }
                    if (data.status == 'fail') {
                        var message = '提交内容包含以下错误:\n';
                        $.each(data.data, function (f, m) {
                            message += '\n' + m;
                        })
                        alert(message);
                        return;
                    }
                    fn.success(data, textStatus, jqXHR);
                }
            });
            return $.ajax(url, options);
        }
    });
</script>
@yield('script')
</body>
</html>