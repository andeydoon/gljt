@extends('mobile.layouts.master')

@section('css')
<link rel="stylesheet" type="text/css" href="/packages/mobile/css/mui.min.css">
<link rel="stylesheet" type="text/css" href="/packages/mobile/css/app.css">
<link rel="stylesheet" type="text/css" href="/packages/mobile/css/mui.picker.css">
<link rel="stylesheet" type="text/css" href="/packages/mobile/css/mui.poppicker.css">
<link rel="stylesheet" href="/css/jquery.fileupload.css">
@endsection

@section('style')
<style type="text/css">
    input[type="number"], input[type='text'], input[type="password"] {
        line-height: 1;
        width: 86.89458689%;
        height: auto;
        margin-bottom: 0px;
        padding: 0px;
        -webkit-user-select: none;
        border: none;
        border-radius: 0px;
        outline: 0;
        background-color: #fff;
        -webkit-appearance: none;
    }
    .j-step_1 .input_phone {
        width: 4.7rem;
    }
</style>
@endsection

@section('js')
<script type="text/javascript" src="/packages/mobile/js/jqwei-xxSlide.js"></script>
<script src="/packages/mobile/js/mui.min.js"></script>
<script src="/packages/mobile/js/mui.picker.js"></script>
<script src="/packages/mobile/js/mui.poppicker.js"></script>
<script src="/packages/mobile/js/city.data-3.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="/js/jquery.ui.widget.js"></script>
<script type="text/javascript" src="/js/jquery.iframe-transport.js"></script>
<script type="text/javascript" src="/js/jquery.fileupload.js"></script>
@endsection

@section('script')
<script type="text/javascript">
    //发送验证码
    var sleep = 60, interval = null;
    window.onload = function () {
        var btn = document.getElementById('btn');
        btn.onclick = function () {
            var $this = this;
            if (!interval) {

                if (!$('.j-step_1 .j-mobile').val()) {
                    alert('请输入手机号码');
                    return;
                }

                $.jAjax({
                    url: '/api/captcha/sms_send',
                    type: 'POST',
                    data: {'mobile': $('.j-step_1 .j-mobile').val()},
                    success: function (data) {
                        $this.disabled = "disabled";
                        $this.style.cursor = "wait";
                        $this.innerHTML = "重新发送 (" + sleep-- + ")";
                        interval = setInterval(function () {
                            if (sleep == 0) {
                                if (!!interval) {
                                    clearInterval(interval);
                                    interval = null;
                                    sleep = 60;
                                    btn.style.cursor = "pointer";
                                    btn.removeAttribute('disabled');
                                    btn.innerHTML = "发送验证码";
                                    btn.style.backgroundColor = '';
                                }
                                return false;
                            }
                            btn.innerHTML = "重新发送 (" + sleep-- + ")";
                        }, 1000);
                    }
                });
            }
        }
    };

    $('input:file').fileupload({
        url: '/api/upload',
        headers: {'X-CSRF-TOKEN': Laravel.csrfToken},
        formData: {},
        done: function (e, data) {
            $.each(data.result.data.files, function (index, file) {
                $('.j-step_2 .j-' + index).val(file);
                $('.j-step_2 [name="' + index + '"]').prev().find('p').hide().prev().prop('src', file);
            });
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $(this).prev().find('p').show().text('上传中(' + progress + '%)');
        }
    });
    
    $('.j-verify').click(function () {
        $.jAjax({
            url: '/api/captcha/sms_verify',
            type: 'POST',
            data: $('.j-step_1 :input').serialize(),
            success: function (data) {
                $('.j-step_1').hide();
                $('.j-step_2').show();

                $('.j-step_2 .j-mobile').val($('.j-step_1 .j-mobile').val());
                $('.j-step_2 .j-crypt').val(data.data.value);
            }
        })
    });
    $('.j-submit').click(function () {
        $.jAjax({
            url: '/api/user/register',
            type: 'POST',
            data: $('.j-step_2 :input').serialize(),
            success: function (data) {
                alert('注册成功，请等待审核');
                window.location.href = '/mobile';
            }
        })
    });


    $('.js_upload').click(function(){
        $(this).next('input').click();
    })

    //显示模态框;
    $('.selectbtn').click(function(){
        $('.js_modle').show();
        // 弹框设置纵向的滚动滚动;
        $.gosider('warpsscoll','ulscoll');
        // 固定网页,防止底部页面也跟着滑动;
        $('body').css({
            'overflow':'hidden',
            'position': 'fixed',
            'top':0,
        });
    })
    // 复选框
    $('.js_checkbox').click(function(){
        var flag=$(this).hasClass("login_checkbox_active");
        if(flag){
            $(this).removeClass("login_checkbox_active")
        }
        else {
            $(this).addClass("login_checkbox_active");
        }
    })
    // 取消;
    $('.js_cancel').click(function(){
        $(this).parents('.js_modle').hide();
        $('body').css({
            'overflow':'auto',
            'position': 'static',
            'top': 'auto'
        });
    })
    //确认
    $('.js_ok').click(function(){
        $('.j-step_2 [name="service_item[]"]').remove();
        $('.login_checkbox_active').each(function () {
            $('<input/>',{
                type: 'hidden',
                name: 'service_item[]',
                value: $(this).prev('span').text()
            }).prependTo('.j-step_2');
        });
        var val=$('.login_checkbox_active').prev('span').text();
        $('.textdata').text(val);
//        console.log(val);
        $(this).parents('.js_modle').hide();
        $('body').css({
            'overflow':'auto',
            'position': 'static',
            'top': 'auto'
        });
    });

    (function($, doc) {
        $.init();
        $.ready(function() {
            /**
             * 获取对象属性的值
             * 主要用于过滤三级联动中，可能出现的最低级的数据不存在的情况，实际开发中需要注意这一点；
             * @param {Object} obj 对象
             * @param {String} param 属性名
             */
            var _getParam = function(obj, param) {
                return obj[param] || '';
            };

            //-----------------------------------------
            //级联示例
            var cityPicker3 = new $.PopPicker({
                layer: 3
            });
            cityPicker3.setData(cityData3);
            var showCityPickerButton = doc.getElementById('showCityPicker3');
            var cityResult3 = doc.getElementById('cityResult3');
            showCityPickerButton.addEventListener('tap', function(event) {
                cityPicker3.show(function(items) {
                    cityResult3.innerText = _getParam(items[0], 'text') + " " + _getParam(items[1], 'text') + " " + _getParam(items[2], 'text');
                    jQuery('.j-step_2 [name="service_area[]"]').remove();
                    jQuery('<input/>',{
                        type: 'hidden',
                        name: 'service_area[]',
                        value: _getParam(items[2], 'value')
                    }).prependTo('.j-step_2');
                    //返回 false 可以阻止选择框的关闭
                    //return false;
                });
            }, false);
        });
    })(mui, document);


</script>
@endsection

@section('body')
<body class="bg_f2f">
<div class="p_b_100 bg_fff">
    <header class="header bg_fff clearfix posr p_t_30 p_b_30 b_b_e5 p_l_24 p_r_24">
        <a class="return fl" href="javascript:window.history.back();"></a>
        <div class="text fl fs_36 t_a_c c_1b1 top_title x_center">师傅注册</div>
        <a class="" href="##"></a>
    </header>
    <div class="j-step_1">
        <input type="hidden" name="module" value="register-master">
        <ul class="fs_34 prl24 bg_fff">
            <li class="clearfix p_t_30 p_b_30 b_b_f4 m_t_50">
                <input class="fl heiline13 input_phone c_999 fs_34 j-mobile" name="mobile" type="text" placeholder="请输入手机号">
                <span id="btn" class=" fr heiline13 yanzenma t_a_r c_999 bleft1 ">发送验证码</span>
            </li>
            <li class="clearfix p_t_30 p_b_30 b_b_f4 m_t_36">
                <input class="fl c_999 fs_34" name="code" type="text" placeholder="短信验证码">
            </li>
        </ul>
        <a class="commonBtn m_t_160 fs_36 j-verify" href="javascript:void(0);">下一步</a>
    </div>
    <div class="j-step_2 hide">
        <input type="hidden" name="type" value="MASTER">
        <input type="hidden" name="mobile" class="j-mobile">
        <input type="hidden" name="crypt" class="j-crypt">
        <input type="hidden" name="card_front" class="j-card_front">
        <input type="hidden" name="card_back" class="j-card_back">
        <input type="hidden" name="card_hold" class="j-card_hold">
        <ul class="fs_34 prl24 bg_fff ">
            <li class="clearfix p_t_30 p_b_30 b_b_f4">
                <input class="fl  c_999 fs_34 ww100" name="realname" type="text" placeholder="请输入真实姓名">
            </li>
            <li class="clearfix p_t_30 p_b_30 b_b_f4">
                <input class="fl c_999 fs_34 ww100" name="card_number" type="number" placeholder="请输入身份证号">
            </li>
            <li class="clearfix posr p_t_30 p_b_30 b_b_f4">
                <input id="inpp" class=" pass_in_to fl c_999 fs_34 " name="password" type="passsword" placeholder="请输入密码">
                <span class="fr y_center openeye js_eye"></span>
            </li>
        </ul>
        <div class="null20"></div>
        <!-- 选择技能 -->
        <ul class="fs_34 bg_fff">
            <li class="clearfix  b_b_f4 prl24 c_333">
                <a class="selectbtn c_333 a_linkzhuce p_t_30 p_b_30" href="javascript:void(0);">选择擅长领域</a>
            </li>
            <li class="clearfix  b_b_f4 prl24 bg_f2f fs_30">
                <a class="c_333 show p_t_30 p_b_30" href="javascript:;">
                    <span>已选择领域：</span> <span class="textdata heiline11">未选择</span>
                </a>
            </li>
            <li class="clearfix posr  b_b_f4 prl24 c_333">
                <a id="showCityPicker3" class="c_333  a_linkzhuce p_t_30 p_b_30" href="javascript:void(0);">选择服务区域</a>
            </li>
            <li class="clearfix  b_b_f4 prl24 bg_f2f fs_30">
                <a class="c_333 show p_t_30 p_b_30" href="javascript:void(0);">
                    <span>已选择地区：</span> <span id="cityResult3">未选择</span>
                </a>
            </li>
        </ul>
        <div class="login_upload bg_fff prl24 p_t_20 clearfix">
            <div class="upload_worp fl">
                <div class="js_upload papers posr m_b_20 c_ada fs_30 t_a_c of">
                    <img src="/packages/mobile/images/img/ic35.png">
                    <p class="posa">上传身份证正面</p>
                </div>
                <input class="hide" type="file" name="card_back">
            </div>
            <div class="upload_worp fr">
                <div class="js_upload papers posr m_b_20  c_ada fs_30 t_a_c of">
                    <img src="/packages/mobile/images/img/ic35.png">
                    <p class=" posa">上传身份证背面</p>
                </div>
                <input class="hide" type="file" name="card_front">
            </div>
            <!-- 例 -->
            <div class="upload_worp fl m_b_20">
                <img src="/packages/mobile/images/img/im2.png">
            </div>
            <div class="upload_worp fr">
                <div class="js_upload papers posr m_b_20 c_ada fs_30 t_a_c of">
                    <img src="/packages/mobile/images/img/ic35.png">
                    <p class=" posa">上传手持身份证照片</p>
                </div>
                <input class="hide" type="file" name="card_hold">
            </div>
        </div>
        <div class="null20"></div>

        <a class="commonBtn m_t_10 fs_36 j-submit" href="javascript:void(0);">完成</a>
        <!-- 选择擅长领域 start-->
        <div class="mask hide js_modle">
            <div class="all_center alwarp">
                <div class="warpsscoll">
                    <ul class="fs_34 bg_fff heiline11 ulscoll">
                        <li class="clearfix p_t_30 p_b_30 b_b_f4 prl24">
                            <span class='c_808'>可以多选</span>
                        </li>
                        <li class="clearfix p_t_20 p_b_20 b_b_f4 fs_34 prl24">
                            <span class="fl set_label c_1b1 p_t_5">测量</span>
                            <span class="fr js_checkbox login_checkbox"></span>
                        </li>
                        <li class="clearfix p_t_20 p_b_20 b_b_f4 fs_34 prl24">
                            <span class="fl set_label c_1b1 p_t_5">安装</span>
                            <span class="fr js_checkbox login_checkbox"></span>
                        </li>
                        <li class="clearfix p_t_20 p_b_20 b_b_f4 fs_34 prl24">
                            <span class="fl set_label c_1b1 p_t_5">门窗维修、更换</span>
                            <span class="fr js_checkbox login_checkbox"></span>
                        </li>
                        <li class="clearfix p_t_20 p_b_20 b_b_f4 fs_34 prl24">
                            <span class="fl set_label c_1b1 p_t_5">开锁</span>
                            <span class="fr js_checkbox login_checkbox"></span>
                        </li>
                        <li class="clearfix p_t_20 p_b_20 b_b_f4 fs_34 prl24">
                            <span class="fl set_label c_1b1 p_t_5">门窗清洗</span>
                            <span class="fr js_checkbox login_checkbox"></span>
                        </li>
                        <li class="clearfix p_t_20 p_b_20 b_b_f4 fs_34 prl24">
                            <span class="fl set_label c_1b1 p_t_5">门面清洗</span>
                            <span class="fr js_checkbox login_checkbox"></span>
                        </li>
                        <li class="clearfix p_t_20 p_b_20 b_b_f4 fs_34 prl24">
                            <span class="fl set_label c_1b1 p_t_5">大楼高空清洗</span>
                            <span class="fr js_checkbox login_checkbox"></span>
                        </li>
                        <li class="clearfix p_t_20 p_b_20 b_b_f4 fs_34 prl24">
                            <span class="fl set_label c_1b1 p_t_5">排油烟机清洗</span>
                            <span class="fr js_checkbox login_checkbox"></span>
                        </li>
                        <li class="clearfix p_t_20 p_b_20 b_b_f4 fs_34 prl24">
                            <span class="fl set_label c_1b1 p_t_5">测试测试数据</span>
                            <span class="fr js_checkbox login_checkbox"></span>
                        </li>
                    </ul>
                </div>
                <div class="prl24 clearfix b_t_e5 bg_fff">
                    <span class="fl p_b_20 p_t_20 js_cancel">取消</span>
                    <span class="fr p_b_20 p_t_20 js_ok">确定</span>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
@endsection