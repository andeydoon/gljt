<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>@yield('title', '广铝集团')</title>
    @yield('css')
    <link rel="stylesheet" href="/packages/mobile/css/common.css">
    @yield('style')
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
{!! \Krucas\Notification\Facades\Notification::showAll() !!}
@yield('body')
<script type="text/javascript" src="/packages/mobile/js/jquery.min.js"></script>
@yield('js')
<script type="text/javascript" src="/packages/mobile/js/base.js"></script>
<script type="text/javascript" src="/packages/mobile/js/common.js"></script>
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
</html>