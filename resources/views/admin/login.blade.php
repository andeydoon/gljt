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
    <link rel="stylesheet" href="/packages/admin/css/AdminLTE.min.css">
    <link rel="stylesheet" href="/packages/admin/plugins/iCheck/square/blue.css">
    <!--[if lt IE 9]>
    <script src="/packages/admin/plugins/html5shiv/html5shiv.min.js"></script>
    <script src="/packages/admin/plugins/respond/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>广铝</b>集团</a>
    </div>
    <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <form action="" method="post">
            {{ csrf_field() }}
            <div class="form-group has-feedback{{ $errors->has('mobile') ? ' has-error' : '' }}">
                <input type="text" class="form-control" placeholder="手机" name="mobile" value="{{ old('mobile') }}">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                @if ($errors->has('mobile'))
                    <span class="help-block">
                        <strong>{{ $errors->first('mobile') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
                <input type="password" class="form-control" placeholder="密码" name="password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> 记住我
                        </label>
                    </div>
                </div>
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">登录</button>
                </div>
            </div>
        </form>

    </div>
</div>
<script src="/packages/admin/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="/packages/admin/bootstrap/js/bootstrap.min.js"></script>
<script src="/packages/admin/plugins/iCheck/icheck.min.js"></script>
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%'
        });
    });
</script>
</body>
</html>
