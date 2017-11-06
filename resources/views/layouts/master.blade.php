<?php
$agent = new \Jenssegers\Agent\Agent();
if ($agent->isMobile()) {
    header('Location: /mobile/' . request()->path());
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>@yield('title', '广铝集团')</title>
    <link rel="stylesheet" href="/css/animation.css"/>
    <link rel="stylesheet" href="/css/index.css"/>
    @yield('css')
    @yield('style')
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
{!! \Krucas\Notification\Facades\Notification::showAll() !!}
<div class="z_head bar-Grey-f2">
    <div class="bar-Grey-f2 z_border_b">
        <div class="z_center7567p bar-Grey-f2 clearfix">
            <div class="z_text-wrap fl js-z_text-wrap">
                <span class="z_text-wrap_span">广东</span>
                <span class="z_color_red z_cursor">[切换]</span>
                <div class="z_dorpdown-layer z_border bar-white hide js-z_dorpdown-layer">
                    <div class="z_border_b z_lineh30 z_font14">请选择收货地区</div>
                    <dl>
                        <dt>A</dt>
                        <dd class="active">安徽</dd>
                        <dd>澳门</dd>
                    </dl>
                    <dl>
                        <dt>B</dt>
                        <dd class="">北京</dd>
                    </dl>
                    <dl>
                        <dt>C</dt>
                        <dd class="">重庆</dd>
                    </dl>
                    <dl>
                        <dt>F</dt>
                        <dd class="">福建</dd>
                    </dl>
                    <dl>
                        <dt>G</dt>
                        <dd class="">广东</dd>
                        <dd>广西</dd>
                        <dd>贵州</dd>
                        <dd>甘肃</dd>
                    </dl>
                    <dl>
                        <dt>H</dt>
                        <dd class="">河北</dd>
                        <dd>河南</dd>
                        <dd>黑龙江</dd>
                        <dd>海南</dd>
                        <dd>湖北</dd>
                        <dd>湖南</dd>
                    </dl>
                    <dl>
                        <dt>J</dt>
                        <dd class="">江苏</dd>
                        <dd>吉林</dd>
                        <dd>江西</dd>
                    </dl>
                    <dl>
                        <dt>L</dt>
                        <dd class="">辽宁</dd>
                    </dl>
                    <dl>
                        <dt>N</dt>
                        <dd class="">内蒙古</dd>
                        <dd>宁夏</dd>
                    </dl>
                    <dl>
                        <dt>Q</dt>
                        <dd class="">青海</dd>
                    </dl>
                    <dl>
                        <dt>S</dt>
                        <dd class="">上海</dd>
                        <dd>山东</dd>
                        <dd>山西</dd>
                        <dd>四川</dd>
                        <dd>陕西</dd>
                    </dl>
                    <dl>
                        <dt>T</dt>
                        <dd class="">台湾</dd>
                        <dd>天津</dd>
                    </dl>
                    <dl>
                        <dt>X</dt>
                        <dd class="">西藏</dd>
                        <dd>香港</dd>
                        <dd>新疆</dd>
                    </dl>
                    <dl>
                        <dt>Y</dt>
                        <dd class="">云南</dd>
                    </dl>
                    <dl>
                        <dt>Z</dt>
                        <dd class="">浙江</dd>
                    </dl>
                </div>
            </div>
            <div class="fr z_head_rmsg clearfix">
                @if(auth()->check())
                    <a href="/user" title="{{ auth()->user()->mobile }}"
                       class="z_a"><span>{{ auth()->user()->mobile }}</span></a>
                    <a href="/logout" title="注销" class="z_a"><span>注销</span></a>
                    <a href="/message" title="消息" class="z_a z_ml10">
                        <span class="z_span z_news_span posr{{ auth()->user()->unreadNotifications()->count() ? 'active' : '' }}">
                            消息@if(auth()->user()->unreadNotifications()->count())
                                <i>({{ auth()->user()->unreadNotifications()->count() }}条)</i>@endif
                        </span>
                    </a>
                    @if(auth()->user()->type==1)
                        <a href="/user/publish" title="我的发布" class="z_a z_ml10">
                            <span class="z_span z_fabu posr">
                                我的发布
                            </span>
                        </a>
                    @endif
                    <a href="/user/feedback" title="意见反馈" class="z_a"><span>意见反馈</span></a>
                @else
                    <a href="/login" title="登录" class="z_a z_color_red">登录</a>
                    <a href="/register" title="登录" class="z_a"><span>注册</span></a>
                @endif
                <div class="z_a z_ml40">咨询热线：4006-900-288</div>
            </div>
        </div>
    </div>
    <div class="bar-white z_border_b">
        <div class="z_center7567p clearfix bar-white">
            <div class="z_head_logo z_w219 fl z_mr10 z_mtb30">
                <img src="/images/icon/logo.png" alt="" width="147" height="34"/>
            </div>
            <div class="z_border_l z_color_9 z_mtb30 fl z_font14 z_lineh34 z_pl10">
                打造门窗定制第一平台
            </div>
            <div class="fl z_mt20">
                <div class="z_nav">
                    <ul class="clearfix z_pl30">
                        <li{!! request()->is('/') ? ' class="active"' : '' !!}>
                            首页
                            <a href="/" title="首页" class="z_lianjie"></a>
                        </li>
                        <li{!! request()->is('product') ? ' class="active"' : '' !!}>
                            门窗图库
                            <a href="/product" title="门窗图库" class="z_lianjie"></a>
                        </li>
                        <li{!! request()->is('process') ? ' class="active"' : '' !!}>
                            施工流程
                            <a href="/process" title="施工流程" class="z_lianjie"></a>
                        </li>
                        <li{!! request()->is('contact') ? ' class="active"' : '' !!}>
                            联系我们
                            <a href="/contact" title="联系我们" class="z_lianjie"></a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="fr z_mtb30 ">
                <div class="z_form z_border_b z_w200  posr">
                    <div class="z_inputbox clearfix">
                        <form method="get" action="/search">
                            <input type="text" placeholder="搜索您想要查看门窗样例" name="q" class="z_input z_w150"
                                   value="{{ old('q') }}"/>
                            <button type="submit" class="z_w50 tc bar-white z_butn">
                                <img src="/images/icon/tb27.png" width="14" height="14"/>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@yield('content')
<footer class="bar-black-1f z_footer z_pb10 z_border_auburn-t-4">
    <div class="z_center119 bar-black-1f">
        <div class="z_mt25">
            <p>
                <a href="/user/about" title="关于我们">关于我们</a>
                <a href="/contact" title="联系我们">联系我们</a>
                <a href="javascript:;" title="联系客服">联系客服</a>
                <a href="javascript:;" title="商家入驻">商家入驻</a>
                <a href="javascript:;" title="广告服务">广告服务</a>
            </p>
        </div>
        <div class="z_mb25 z_mt25">
            <p>
                <span class="z_mr10">Copyright &copy; 2005-2018</span>&nbsp;广铝集团版权所有
            </p>
        </div>
    </div>
</footer>
<script type="text/javascript" src="/js/jquery-1.12.4.min.js"></script>
<script type="text/javascript" src="/js/h_public.js"></script>
@yield('js')
<script type="text/javascript">
    //地址移出显示 js-z_text-wrap
    $(".js-z_text-wrap span.z_cursor").mousemove(function () {
        $(this).next().removeClass("hide");
        $(this).prev().addClass("active");
    });
    //移出隐藏
    $(".js-z_text-wrap").mouseleave(function () {
        $(this).find(".z_dorpdown-layer").addClass("hide");
        $(this).find("span").removeClass("active");
    });
    //地址选中状态 js-z_dorpdown-layer
    $(".js-z_dorpdown-layer dl dd").click(function () {
        var _text = $(this).text();
        $(this).addClass("active").siblings().removeClass("active");
        $(this).parent().siblings().find("dd").removeClass("active");

        //赋值
        $(this).parent().parent().parent().find("span").eq(0).html(_text);
        //关闭
        $(this).parent().parent().prev("span").removeClass("active");
        $(this).parent().parent().addClass("hide");
    });

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
        },
        jAlert: function (msg) {
            $('body').append('<div class="shadow j-alert-mask"></div><div class="z_popup z_w340 bar-white z_pb20 posf animation bounceIn hide j-alert-panel"><div class="tc z_font16 z_color_3 z_lineh24 z_mt30 z_mb40 z_plr22">'+msg+'</div><div class="z_mt20 tc"><input type="button" value="确定" class="z_btn bar-auburn z_font14 z_w120 z_ptb7 j-alert-confirm" onclick="$(\'.j-alert-panel,.j-alert-mask\').remove();"/></div></div>');
            $('.j-alert-panel').removeClass("hide");
            $('.j-alert-mask').show();
        }
    });
</script>
@yield('script')
</body>
</html>