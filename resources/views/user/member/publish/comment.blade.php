@extends('user.layouts.master-member')

@section('css')
<link rel="stylesheet" href="/css/jquery.fileupload.css">
@endsection

@section('js')
<script type="text/javascript" src="/js/jquery.ui.widget.js"></script>
<script type="text/javascript" src="/js/jquery.iframe-transport.js"></script>
<script type="text/javascript" src="/js/jquery.fileupload.js"></script>
<script type="text/javascript" src="/js/template.js"></script>
@endsection

@section('script')
<script type="text/javascript">
    function addstart() {
        //添加服务评价星星状态
        $(".j-score_in_box span.score_star").on("click", function () {
            var thisIndex = $(this).index() + 1;
            console.log(thisIndex);
            $('[name="' + $(this).parent().data('target') + '_score"]').val(thisIndex);
            var star_length = $(this).parent().find("span.score_star").length;
            //$(this).parent().find("span.score").text(thisIndex);
            for (i = 0; i <= thisIndex; i++) {
                $(this).parent().find("span.score_star").eq(i).find("img").attr("src", "/images/icon/tb62a.png");
            }
            for (i = thisIndex; i < star_length; i++) {
                $(this).parent().find("span.score_star").eq(i).find("img").attr("src", "/images/icon/tb62.png");
            }
        });
    }

    addstart();

    $('input:file').fileupload({
        url: '/api/upload',
        headers: {'X-CSRF-TOKEN': Laravel.csrfToken},
        formData: {},
        done: function (e, data) {
            $.each(data.result.data.files, function (index, file) {
                var $this = $(e.target);
                $('[name="' + index + '"]').prev().hide().parent().parent().append('<div class="z_img_fix z_img_fix2 fl z_mb10 z_mr10"><img src="' + file + '"/><input type="hidden" name="pictures[]" value="' + file + '"><span class="z_off2 js-z_off"></span></div>')
            });
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $(this).prev().show().text('上传中(' + progress + '%)').prev().addClass('hide');
        }
    });


    $('.j-submit').click(function () {
        $.jAjax({
            url: '/api/user/publish/comment',
            type: 'POST',
            data: $('.j-form :input').serialize(),
            success: function (data) {
                if (data.status == 'success') {
                    alert('提交成功');
                    window.location.href = '/user/publish?{{ $order->type==1 ? 'custom' : 'service' }}';
                }
            }
        })
    });
</script>
@endsection

@section('uc_content')
<div class="z_w82p fr j-form">
    <input type="hidden" name="order" value="{{ $order->trade_id }}">
    <input type="hidden" name="type" value="{{ $order->type }}">
    <input type="hidden" name="service_score">
    <input type="hidden" name="product_score">
    <div class="z_mtb10 clearfix">
        <span class="z_font14 z_color_3 z_lineh40 z_fontb">确认安装</span>
    </div><!--确认安装-->
    <div class="z_border z_mb10">
        <div class="z_border_b z_plr10 clearfix z_lineh40">
            <span>订单号：{{ $order->trade_id }}</span>
        </div>
        <div class="z_border_b z_p20 clearfix posr bar-GreyGreed">
            <div class="posr clearfix z_w60p ">
                <img src="/images/other/tp1.png" class="z_w80 z_h80 z_mr10 fl" />
                <div class="z_text">
                    <h2 class="z_fontn z_font14 z_color_3 z_lineh40">{{ $order->type==1 ? $order->custom->product->name : $order->service->service->name }}</h2>
                </div>
            </div>
        </div>
        <!--师傅评价-->
        <div class="z_plr10 z_border_b z_pb20">
            <div class="clearfix z_lineh30 z_color_3 z_font14 z_mt10">
                <span>师傅评价</span>
            </div>
            <!--个人头像信息-->
            <div class="z_personal_h  clearfix z_mt10 posr">
                <div class="clearfix">
                    <div class="z_mlr10 z_personal_h_img fl">
                        <img src="/images/other/tp4.png" />
                    </div>
                    <div class="z_text2">
                        <h2 class="z_font16 z_lineh30">{{ $order->master->profile->realname }}</h2>
                    </div>
                </div>
            </div>
            <!--个人头像信息 end-->
        </div>
        <!--服务分数-->
        <div class="z_plr10 z_border_b z_pb10">
            <div class="clearfix z_lineh30 z_color_3 z_font14 z_mt10">
                <span>服务分数</span>
            </div>
            <div class="magnify j-goods_img" style="">
                <div class="score_in_box j-score_in_box " data-target="service">
                    <span class="score_star"><img src="/images/icon/tb62.png" alt="star"></span>
                    <span class="score_star"><img src="/images/icon/tb62.png" alt="star"></span>
                    <span class="score_star"><img src="/images/icon/tb62.png" alt="star"></span>
                    <span class="score_star"><img src="/images/icon/tb62.png" alt="star"></span>
                    <span class="score_star"><img src="/images/icon/tb62.png" alt="star"></span>
                </div>
            </div>
            <div class="z_mt20" style="">
                <div class="z_text-wrap z_border z_p10 ">
                    <textarea class="z_textarea z_h80" name="service_content" placeholder="关于服务你想说的"></textarea>
                </div>
            </div>
        </div>
        <!--服务分数 end-->
        @if($order->type == 1)
            <!--产品评价-->
            <div class="z_plr10 z_border_b z_pb10">
                <div class="clearfix z_lineh30 z_color_3 z_font14 z_mt10">
                    <span>产品评价</span>
                </div>
                <div class="clearfix">
                    <div class="z_w100 z_h60 fl z_mr10">
                        <div class="z_img_back">
                            <img src="/images/other/tp9.png">
                        </div>
                    </div>
                    <div class="z_text2">
                        <h2 class="z_font16 z_lineh30">{{ $order->custom->product->name }}</h2>
                    </div>
                </div>
                <div class="magnify j-goods_img" style="">
                    <div class="score_in_box j-score_in_box " data-target="product">
                        <span class="score_star"><img src="/images/icon/tb62.png" alt="star"></span>
                        <span class="score_star"><img src="/images/icon/tb62.png" alt="star"></span>
                        <span class="score_star"><img src="/images/icon/tb62.png" alt="star"></span>
                        <span class="score_star"><img src="/images/icon/tb62.png" alt="star"></span>
                        <span class="score_star"><img src="/images/icon/tb62.png" alt="star"></span>
                    </div>
                </div>
                <div class="z_mt20" style="">
                    <div class="z_text-wrap z_border z_p10 ">
                        <textarea class="z_textarea z_h80" name="product_content" placeholder="关于产品你想说的"></textarea>
                    </div>
                </div>
            </div>
            <!--产品评价 end-->
        @endif
        <!--请添加照片 -->
        <div class="z_plr10">
            <div class="clearfix z_lineh30 z_color_3 z_font14 z_mt10">
                <span>请添加照片（最多添加九张）</span>
            </div>
            <div class="clearfix">
                <div class="z_img_fix z_img_fix2 fl z_mb10 z_mr10">
                    <div class="z_font12 z_color_3 tc z_mt60"></div>
                    <input type="file" name="pictures"/>
                </div>
            </div>
        </div>
        <!--请添加照片 end-->
        <!--师傅评价 end-->
    </div>
    <div class="z_p10 tr z_mb40">
        <a href="javascript:void(0);" class="z_btn bar-auburn z_font14 z_w110 z_ptb7 j-submit">确认提交</a>
    </div>
    <!--确认安装 end-->
</div>
@endsection

@section('uc_bottom')
@endsection