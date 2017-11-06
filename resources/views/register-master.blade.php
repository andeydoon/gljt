@extends('layouts.master')

@section('title', '注册-师傅')

@section('css')
<link rel="stylesheet" href="/css/jquery.fileupload.css">
@endsection

@section('js')
<script type="text/javascript" src="/js/Popt.js"></script>
<script type="text/javascript" src="/js/cityJson.js"></script>
<script type="text/javascript" src="/js/citySet.js"></script>
<script type="text/javascript" src="/js/jquery.ui.widget.js"></script>
<script type="text/javascript" src="/js/jquery.iframe-transport.js"></script>
<script type="text/javascript" src="/js/jquery.fileupload.js"></script>
@endsection

@section('script')
<script type="text/javascript">
    $(".js-btn").click(function (e) {
        SelCity(this,e,'service_area[]');
    });
    //删除2
    function delet2(){
        $(".js-z_off").click(function(){
            $(this).parent().remove();
            return false;
        });
    }

    $('.js-z_clean').click(function () {
        $(this).closest('.z_inputbox').find('input').val('');
    })

    //发送验证码
    var sleep = 60, interval = null;
    window.onload = function () {
        var btn = document.getElementById('btn');
        btn.onclick = function () {
            var $this = this;

            if (!interval) {

                if (!$('.js-step_1 .js-mobile').val()) {
                    alert('请输入手机号码');
                    return;
                }

                $.jAjax({
                    url: '/api/captcha/sms_send',
                    type: 'POST',
                    data: {'mobile': $('.js-step_1 .js-mobile').val()},
                    success: function (data) {
                        $this.style.backgroundColor = '#f2f2f2';
                        $this.disabled = "disabled";
                        $this.style.cursor = "wait";
                        $this.value = "重新发送 (" + sleep-- + ")";
                        interval = setInterval(function () {
                            if (sleep == 0) {
                                if (!!interval) {
                                    clearInterval(interval);
                                    interval = null;
                                    sleep = 60;
                                    btn.style.cursor = "pointer";
                                    btn.removeAttribute('disabled');
                                    btn.value = "获取验证码";
                                    btn.style.backgroundColor = '';
                                }
                                return false;
                            }
                            btn.value = "重新发送 (" + sleep-- + ")";
                        }, 1000);
                    }
                })
            }
        }
    }

    $('input:file').fileupload({
        url: '/api/upload',
        headers: {'X-CSRF-TOKEN': Laravel.csrfToken},
        formData: {},
        done: function (e, data) {
            $.each(data.result.data.files, function (index, file) {
                $('.js-step_2 .js-' + index).val(file);
                $('.js-step_2 [name="' + index + '"]').prev().hide().prev().removeClass('hide').children('img').prop('src', file);
            });
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $(this).prev().show().text('上传中(' + progress + '%)').prev().addClass('hide');
        }
    });
    
    $('.js-verify').click(function () {
        if (!$('.js-agree').is(':checked')) {
            alert('请阅读并接受《门窗卫士用户服务协议》');
            return;
        }

        $.jAjax({
            url: '/api/captcha/sms_verify',
            type: 'POST',
            data: $('.js-step_1 :input').serialize(),
            success: function (data) {
                $('.js-step_1').hide();
                $('.js-step_2').show();

                $('.js-step_2 .js-mobile').val($('.js-step_1 .js-mobile').val());
                $('.js-step_2 .js-crypt').val(data.data.value);
            }
        })
    });
    
    $('.js-register').click(function () {
        $.jAjax({
            url: '/api/user/register',
            type: 'POST',
            data: $('.js-step_2 :input').serialize(),
            success: function (data) {
                $('.js-step_2').hide();
                $('.js-step_3').show();
            }
        })
    });
</script>
@endsection

@section('content')
<div class="z_body">
    <div class="z_center119">
        <div class="z_bg_img clearfix">
            <div class="fr z_loginbox z_border z_minh363">
                <div class="z_nav z_border_b z_mt10">
                    <ul class="clearfix z_pl30">
                        <li>
                            普通会员
                            <a href="/register?member" title="普通会员" class="z_lianjie"></a>
                        </li>
                        <li class="active">
                            师傅
                            <a href="/register?master" title="师傅" class="z_lianjie"></a>
                        </li>
                        <li>
                            经销商
                            <a href="/register?dealer" title="经销商" class="z_lianjie"></a>
                        </li>
                    </ul>
                </div>
                <div class="z_plr10 js-step_1">
                    <input type="hidden" name="module" value="register-master">
                    <div class="z_inputbox z_mt30 z_border clearfix">
                        <label class="fl z_border_r z_w60 tc">
                            手机号
                        </label>
                        <input type="text" name="mobile" placeholder="请输入手机号" class="z_input z_ptb13 js-mobile"/>
                        <label class="fr z_cursor">
                            <img src="/images/icon/tb43.png" height="16" width="16" class="js-z_clean"/>
                        </label>
                    </div>
                    <div class="z_inputbox z_mt20 z_border clearfix">
                        <label class="fl z_border_r z_w60 tc">
                            验证码
                        </label>
                        <input type="text" name="code" placeholder="请输入手机验证码" class="z_input z_ptb13"/>
                        <input id="btn" type="button" value="获取验证码" class="z_verificationCode z_w80 fr"/>
                    </div>

                    <div class="z_box z_mt20 clearfix">
                        <input type="checkbox" name="agree" class="js-agree" value="1">
                        <span> 我已阅读并接受<span class="z_color_blue">《门窗卫士用户服务协议》</span></span>
                    </div>
                    <div class="z_inputbox z_mt20 z_mb40">
                        <input type="button" value="下一步" class="z_btn bar-auburn z_font14 js-verify"/>
                    </div>
                </div>
                <!--第二步-->
                <div class="z_plr10 hide js-step_2">
                    <input type="hidden" name="type" value="MASTER">
                    <input type="hidden" name="mobile" class="js-mobile">
                    <input type="hidden" name="crypt" class="js-crypt">
                    <input type="hidden" name="card_front" class="js-card_front">
                    <input type="hidden" name="card_back" class="js-card_back">
                    <input type="hidden" name="card_hold" class="js-card_hold">
                    <div class="z_inputbox z_mt20 z_border clearfix">
                        <label class="fl z_border_r z_w60 tc">
                            真实姓名
                        </label>
                        <input type="text" name="realname" placeholder="请输入您的真实姓名" class="z_input z_ptb13"/>
                    </div>
                    <div class="z_inputbox z_mt20 z_border clearfix">
                        <label class="fl z_border_r z_w60 tc">
                            身份证号
                        </label>
                        <input type="text" name="card_number" placeholder="请输入您的身份证号" class="z_input z_ptb13 z_w240"/>
                    </div>
                    <div class="z_inputbox z_mt20 z_border clearfix">
                        <label class="fl z_border_r z_w60 tc">
                            密　　码
                        </label>
                        <input type="password" name="password" placeholder="6~20位字母、数字、字符" class="z_input z_ptb13"/>
                    </div>
                    <div class="z_inputbox z_mt20 z_border clearfix z_ptb10">
                        <label class="fl z_border_r z_w60 tc z_lineh20">
                            服务项目
                        </label>
                        <div class="z_ml60 z_lineh20 z_plr10">
                            <ul class="clearfix z_ul_line">
                                <li>
                                    <input type="checkbox" name="service_item[]" value="测量">
                                    测量
                                </li>
                                <li>
                                    <input type="checkbox" name="service_item[]" value="安装">
                                    安装
                                </li>
                                <li>
                                    <input type="checkbox" name="service_item[]" value="设计">
                                    设计
                                </li>
                                <li>
                                    <input type="checkbox" name="service_item[]" value="开锁">
                                    开锁
                                </li>
                                <li>
                                    <input type="checkbox" name="service_item[]" value="门窗维修、更换">
                                    门窗维修、更换
                                </li>
                                <li>
                                    <input type="checkbox" name="service_item[]" value="门面清洗">
                                    门面清洗
                                </li>
                                <li>
                                    <input type="checkbox" name="service_item[]" value="门窗清洗">
                                    门窗清洗
                                </li>
                                <li>
                                    <input type="checkbox" name="service_item[]" value="大楼高空清洗">
                                    大楼高空清洗
                                </li>
                                <li>
                                    <input type="checkbox" name="service_item[]" value="空调清洗">
                                    空调清洗
                                </li>
                                <li>
                                    <input type="checkbox" name="service_item[]" value="吸油烟机清洗">
                                    吸油烟机清洗
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="z_inputbox z_mt20 z_border clearfix z_ptb10 posr">
                        <label class="fl z_border_r z_w60 tc z_lineh20">
                            服务区域
                        </label>
                        <div class="z_ml60 z_lineh20 z_plr10 clearfix">
                                <span class="fr z_cursor z_w50 tc js-btn">
                                    <img src="/images/icon/tb2.png" width="16" height="16" class="tva-3"/>
                                </span>
                            <div class="z_quyu js-z_quyu">
                            </div>
                        </div>
                    </div>
                    <div class="z_inputbox z_mt20 clearfix">
                        <div class="z_mb10 clearfix">
                            <div class="z_img_fix fl">
                                <div class="z_img hide">
                                    <img/>
                                </div>
                                <div class="z_font12 z_color_3 tc z_mt60">
                                    上传身份证正面
                                </div>
                                <input type="file" name="card_front" />
                            </div>
                            <div class="z_img_fix fr">
                                <div class="z_img hide">
                                    <img/>
                                </div>
                                <div class="z_font12 z_color_3 tc z_mt60">
                                    上传身份证反面
                                </div>
                                <input type="file" name="card_back" />
                            </div>
                        </div>
                        <div class="z_mb10 clearfix">
                            <div class="z_img_fix fl">
                                <img src="/images/icon/tb9.png" />
                            </div>
                            <div class="z_img_fix fr">
                                <div class="z_img hide">
                                    <img/>
                                </div>
                                <div class="z_font12 z_color_3 tc z_mt60">
                                    上传手持身份证照片
                                </div>
                                <input type="file" name="card_hold" />
                            </div>
                        </div>
                    </div>
                    <div class="z_inputbox z_mb20 z_border clearfix">
                        <label class="fl z_border_r z_w60 tc">
                            推荐编号
                        </label>
                        <input type="text" name="finder" placeholder="推荐您的经销商编码" class="z_input z_ptb13"/>
                    </div>
                    <div class="z_inputbox z_mb40">
                        <input type="button" value="提交审核"  class="z_btn bar-auburn z_font14 js-register"/>
                    </div>
                </div>
                <!--第二步 end-->
                <!--注册成功-->
                <div class="z_mt40 z_plr10 hide js-step_3">
                    <div class="clearfix">
                        <img src="/images/icon/tb44.png" width="18" height="18" class="z_mr10 fl" />
                        <div class="z_ml30">
                            <p class="z_fontb z_color_3 z_font15 z_mb10">您的信息已提交，请等待审核。</p>
                            <p class="z_color_6 z_font14 z_lineh24">审核结果会通过电话通知您 请注意查收短信或消息。</p>
                        </div>
                        <div class="z_ml30 z_mt20">
                            <a  href="/" title="去首页" class="z_btn z_border z_w100 z_color_6 z_font15 z_ptb8">去首页</a>
                        </div>
                    </div>

                </div>
                <!--注册成功 end-->
            </div>
        </div>
    </div>
</div>
@endsection