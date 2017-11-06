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
        /*width: 86.89458689%;*/
        /*height: auto;*/
        margin-bottom: 0px;
        /*padding: 0px;*/
        -webkit-user-select: none;
        border: none;
        border-radius: 0px;
        outline: 0;
        background-color: #fff;
        -webkit-appearance: none;
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
    $(function($){
        // 单选
        $('.js_checkbox').click(function(){
            var flag=$(this).hasClass('login_checkbox_active');
            $(this).addClass("login_checkbox_active")
                .parents('.labelworp').siblings('.labelworp')
                .find('.js_checkbox').removeClass("login_checkbox_active");

            $('[name="lift"]').val($(this).data('value'));
        })
        // switch
        $('.js_switch').click(function(){
            var flag=$(this).hasClass('switch_bar_active');
            if(flag){
                $(this).removeClass("switch_bar_active");
            }else{
                $(this).addClass("switch_bar_active");
            }
            $('[name="default"]').val(flag?0:1);
        })
    });

    $('.j-submit').click(function () {
        $.jAjax({
            url: '/api/user/address',
            type: 'POST',
            data: $('.j-form :input').serialize(),
            success: function (data) {
                if (data.status == 'success') {
                    alert('地址添加成功');
                    window.location = '/mobile/user/address';
                }
            }
        });
    });

    (function($, doc) {
        $.init();
        $.ready(function() {
            /**
             * 获取对象属性的值
             * 主要用于过滤三级联动中，可能出现的最低级的数据不存在的情况，实际开发中需要注意这一点；
             * @param  {Object} obj 对象
             * @param  {String} param 属性名
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
            var cityResult3 = doc.getElementById('showCityPicker3');
            showCityPickerButton.addEventListener('tap', function(event) {
                cityPicker3.show(function(items) {
                    cityResult3.value = _getParam(items[0], 'text') + " " + _getParam(items[1], 'text') + " " + _getParam(items[2], 'text');

                    jQuery('[name="province_id"]').val(_getParam(items[0], 'value'));
                    jQuery('[name="city_id"]').val(_getParam(items[1], 'value'));
                    jQuery('[name="district_id"]').val(_getParam(items[2], 'value'));

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
<header class="header bg_fff clearfix posr p_t_30 p_b_30 b_b_e5 p_l_24 p_r_24">
    <a class="return fl" href="##"></a>
    <div class="text fl fs_36 t_a_c c_1b1 top_title x_center">添加收货地址</div>
    <a class="fr fs_30 p_t_3" href="##"></a>
</header>
<div class="j-form">
    <input type="hidden" name="lift" value="1">
    <input type="hidden" name="default" value="1">
    <input type="hidden" name="province_id">
    <input type="hidden" name="city_id">
    <input type="hidden" name="district_id">
    <ul class="p_l_24 c_bfb bg_fff">
        <li class="fs_30 b_b_e5 clearfix addli_itme">
            <span class="fl tone">收货人姓名</span>
            <input class="fr fs_30 c_bfb" name="name" type="text">
        </li>
        <li class="fs_30 b_b_e5 clearfix addli_itme">
            <span class="fl tone">手机号码</span>
            <input class="fr fs_30 c_bfb" name="phone" type="text">
        </li>
        <li class="fs_30 b_b_e5 clearfix addli_itme">
            <span class="fl tone">所在地区</span>
            <input class="fr fs_30 c_bfb" id="showCityPicker3" type="text" readonly>
        </li>
        <li class="fs_30 b_b_e5 clearfix addli_itme">
            <span class="fl tone">详细地址：</span>
            <input class="fr fs_30 c_bfb" name="street" type="text">
        </li>
        <li class="fs_30 b_b_e5 clearfix addli_itme">
            <span class="fl tone">楼层信息</span>
            <input class="fr fs_30 c_bfb" name="floor" type="text">
        </li>
        <li class="fs_30  clearfix addli_itme">
            <em class="fl thisem">选择电梯情况</em>
            <label class="labelworp posr">
                <span class="disline y_center js_checkbox login_checkbox login_checkbox_active" data-value="1"></span>
                <i class="ielet">有</i>
            </label>
            <label class="labelworp posr m_l_65">
                <span class="disline y_center js_checkbox login_checkbox" data-value="0"></span>
                <i class="ielet">没有</i>
            </label>
        </li>
    </ul>
    <div class="null20"></div>
    <!-- 设置为默认地址 -->
    <div class=" prl24 p_b_10 P_t_10 clearfix b_b_e5 bg_fff">
        <span class="fl c_666 fs_32 p_t_20 p_b_15">默认</span>
        <div class="fr switch_bar js_switch switch_bar_active"></div>
    </div>
    <div class="fixed_bottom">
        <div class=" ptb15 fs_32 bg_fff">
            <a class="c_fff commonBtn show j-submit" href="javascript:void(0);">
                保存
            </a>
        </div>
    </div>
</div>
</body>
@endsection