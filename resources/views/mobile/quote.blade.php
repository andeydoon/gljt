@extends('mobile.layouts.master')

@section('css')
<link rel="stylesheet" type="text/css" href="/packages/mobile/css/mui.min.css">
<link rel="stylesheet" type="text/css" href="/packages/mobile/css/app.css">
<link rel="stylesheet" type="text/css" href="/packages/mobile/css/mui.picker.css">
<link rel="stylesheet" type="text/css" href="/packages/mobile/css/mui.poppicker.css">
@endsection

@section('style')
<style type="text/css">
    input[type="number"], input[type='text'] {
        line-height: 1;
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
</style>
@endsection

@section('js')
<script type="text/javascript" src="/packages/mobile/js/jqwei-xxSlide.js"></script>
<script src="/packages/mobile/js/mui.min.js"></script>
<script src="/packages/mobile/js/mui.picker.js"></script>
<script src="/packages/mobile/js/mui.poppicker.js"></script>
<script src="/packages/mobile/js/city.data-3.js" type="text/javascript" charset="utf-8"></script>
@endsection

@section('script')
<script type="text/javascript">
    (function ($, doc) {
        $.init();
        $.ready(function () {
            /**
             * 获取对象属性的值
             * 主要用于过滤三级联动中，可能出现的最低级的数据不存在的情况，实际开发中需要注意这一点；
             * @param {Object} obj 对象
             * @param {String} param 属性名
             */
            var _getParam = function (obj, param) {
                return obj[param] || '';
            };


            var category0_Picker = new $.PopPicker();
            var category1_Picker = new $.PopPicker();
            var material_Picker = new $.PopPicker();


            var category0_Button = doc.getElementById('category0_Button');
            var category0_Result = doc.getElementById('category0_Result');
            var category1_Button = doc.getElementById('category1_Button');
            var category1_Result = doc.getElementById('category1_Result');
            var material_Button = doc.getElementById('material_Button');
            var material_Result = doc.getElementById('material_Result');

            var category0_Data = [];
            var category1_Data = [];
            var material_Data = [];

            jQuery.jAjax({
                url: '/api/category',
                success: function (data) {
                    category0_Data =[];
                    jQuery.each(data.data.categories, function () {
                        category0_Data.push({value: this.id, text: this.name})
                    })
                    category0_Picker.setData(category0_Data);

                    console.log(category0_Data);

                    category0_Button.addEventListener('tap', function (event) {
                        category0_Picker.show(function (items) {
                            // category0_Result.value = JSON.stringify(items[0].text);
                            category0_Result.value = items[0].text;
                            //返回 false 可以阻止选择框的关闭
                            //return false;

                            category1_Result.value = '选择类型';
                            material_Result.value = '选择材料';

                            jQuery('[name="category_id"]').val('');
                            jQuery('[name="material_id"]').val('');

                            jQuery.jAjax({
                                url: '/api/category',
                                data: {'parent_id': items[0].value},
                                success: function (data) {
                                    category1_Data =[];
                                    material_Data =[];
                                    jQuery.each(data.data.categories, function () {
                                        category1_Data.push({value: this.id, text: this.name});
                                        material_Data[this.id] = [];
                                        jQuery.each(this.materials, function () {
                                            material_Data[this.category_id].push({value: this.id, text: this.name})
                                        })
                                    })
                                    category1_Picker.setData(category1_Data);

                                    console.log(category1_Data);
                                    console.log(material_Data);

                                    category1_Button.addEventListener('tap', function (event) {
                                        category1_Picker.show(function (items) {
                                            // category1_Result.value = JSON.stringify(items[0].text);
                                            category1_Result.value = items[0].text;
                                            jQuery('[name="category_id"]').val(items[0].value);
                                            //返回 false 可以阻止选择框的关闭
                                            //return false;

                                            material_Result.value = '选择材料';
                                            jQuery('[name="material_id"]').val('');

                                            material_Picker.setData(material_Data[items[0].value]);

                                            console.log(material_Data[items[0].value]);

                                            material_Button.addEventListener('tap', function (event) {
                                                material_Picker.show(function (items) {
                                                    // material_Result.value = JSON.stringify(items[0].text);
                                                    material_Result.value = items[0].text;
                                                    jQuery('[name="material_id"]').val(items[0].value);
                                                    //返回 false 可以阻止选择框的关闭
                                                    //return false;
                                                });
                                            }, false);

                                        });
                                    }, false);
                                }
                            });
                        });
                    }, false);
                }
            });

            // 地址选择******************************;


            //-----------------------------------------
            //级联示例
            var cityPicker3 = new $.PopPicker({
                layer: 3
            });
            cityPicker3.setData(cityData3);
            var showCityPickerButton = doc.getElementById('showCityPicker3');
            var cityResult3 = doc.getElementById('cityResult3');
            showCityPickerButton.addEventListener('tap', function (event) {
                cityPicker3.show(function (items) {
                    cityResult3.innerText = _getParam(items[0], 'text') + " " + _getParam(items[1], 'text') + " " + _getParam(items[2], 'text');

                    jQuery('[name="province_id"]').val(_getParam(items[0], 'value'));
                    jQuery('[name="city_id"]').val(_getParam(items[1], 'value'));
                    jQuery('[name="district_id"]').val(_getParam(items[2], 'value'));


                    //返回 false 可以阻止选择框的关闭
                    //return false;
                });
            }, false);


        });

    })(mui, document);


    $('.j-submit').click(function () {
        $.jAjax({
            url: '/api/quote',
            type: 'POST',
            data: $('.j-form :input').serialize(),
            success: function (data) {
                if (data.status == 'success') {
                    $('.j-result .j-price').text(' ' + data.data.price_min + '元~' + data.data.price_max + '元');
                    for (var i = 0; i < data.data.products.length; i++) {
                        $('.j-result .j-products p').eq(i).text(data.data.products[i]['name']);
                        $('.j-result .j-products a').eq(i).prop('href', '/mobile/product/' + data.data.products[i]['id']);
                        $('.j-result .j-products img').eq(i).prop('src', data.data.products[i]['cover']);
                    }
                    $('.j-form').addClass('hide');
                    $('.j-result').removeClass('hide');
                }
            }
        })
    })


</script>
@endsection

@section('body')
<body class="bg_f2f">
<header class="header bg_fff clearfix posr p_t_30 p_b_30 b_b_e5 p_l_24 p_r_24">
    <a class="return fl" href="javascript:window.history.back();"></a>
    <div class="text fl fs_36 t_a_c c_1b1 top_title x_center">免费报价</div>
    <a class="confirm fr" href="/mobile"></a>
</header>
<!-- 选择物品类型 -->
<div class="j-form">
    <input type="hidden" name="category_id">
    <input type="hidden" name="material_id">
    <input type="hidden" name="province_id">
    <input type="hidden" name="city_id">
    <input type="hidden" name="district_id">
    <div class="Waiter_info prl24 p_b_24 bg_fff">
        <div class="c_666 fs_30 p_t_30 p_b_30"> 请输入您想要门窗的基本信息</div>
        <ul>
            <li class="clearfix c_000 fs_34 clearfix">
                <span class="fl p_t_15 boaojw">分类:</span>
                <span id="category0_Button" class="fr baojia_select posr clearfix">
                <input id="category0_Result" class="inputText fs_34" type="text" value="选择分类">
                <i class="down_Arrow posa"></i>
            </span>
            </li>
            <li class="clearfix p_t_24 c_000 fs_34 clearfix">
                <span class="fl p_t_15 boaojw">类型:</span>
                <span id="category1_Button" class="fr baojia_select clearfix posr">
                <input id="category1_Result" class="inputText fs_34" type="text" value="选择类型">
                <i class="down_Arrow posa"></i>
            </span>
            </li>
            <li class="clearfix p_t_24 c_000 fs_34 clearfix">
                <span class="fl p_t_15 boaojw">材料:</span>
                <span id="material_Button" class="fr baojia_select clearfix posr">
                <input id="material_Result" class="inputText fs_34" type="text" value="选择材料">
                <i class="down_Arrow posa"></i>
            </span>
            </li>
            <li class="clearfix p_t_24 c_000 fs_34 clearfix">
                <div class="shurubox clearfix fl">
                    <span class="fl">高：</span>
                    <input class="fr" type="number" name="height">
                </div>
                <div class="shurubox clearfix fl">
                    <span class="fl">宽：</span>
                    <input class="fr" type="number" name="width">
                </div>
                <div class="shurubox clearfix fl">
                    <span class="fl">厚：</span>
                    <input class="fr" type="number" name="thickness">
                </div>
            </li>
        </ul>
    </div>
    <div class="null20"></div>
    <ol class="fs_34 bg_fff">
        <li id="showCityPicker3" class="c_000 clearfix prl24 b_b_e5 ptb30">
            <span class="fl mianselt">所在地区:</span>
            <a id="cityResult3" class="c_999 fl mianfselright Singleellipsis" href="javascript:;">选择地区</a>
        </li>
        <li class="c_000 clearfix prl24  ptb30">
            <span class="fl mianselt">手机号码:</span>
            <input class="c_999 fs_34 fl mianfshuru Singleellipsis" name="phone" type="number" placeholder="请输入手机号码">
        </li>
    </ol>
    <div class="bg_fff pall24 fs_32 abspout">
        <a class="show c_fff commonBtn j-submit" href="javascriot:void(0);">确定</a>
    </div>
</div>
<div class="j-result hide">
    <ul class="prl24 ptb10">
        <li class="clearfix fs_34 c_000">
            <span>价格范围：</span>
            <span class="j-price"></span>
        </li>
        <li class="clearfix fs_34 c_000 m_t_36">
            <span>免设计费： </span>
            <span> 0元</span>
        </li>
        <li class="clearfix fs_34 c_000 m_t_36">
            <span>免费测量：</span>
            <span> 0元</span>
        </li>
    </ul>

    <div class="commonBtn m_b_15 m_t_15 fs_32">
        <a class="show c_fff" href="/mobile/product">选择产品</a>
    </div>
    <div class="null20"></div>
    <ol class=" prl24 pbt24 b_b_e5">
        <li class="clearfix">
            <i calss="fl">*</i>
            <span class="heiline13 tishispan fr">
            稍门窗管家将致电您，为您提供免费咨询服务
             因材料品牌及工程量不同，具体报价以实际定制方
            案为准。
            </span>
        </li>
        <li class="clearfix m_t_15">
            <i calss="fl">*</i>
            <span class="heiline13 tishispan fr">
            稍门窗管家将致电您，为您提供免费咨询服务
             因材料品牌及工程量不同，具体报价以实际定制方
            案为准。
            </span>
        </li>
    </ol>
    <!-- 推荐产品 -->
    <div class="clearfix prl24 tujiansp">
        <span class="fl c_000">推荐产品</span>
        <a class="fr c_999" href="/mobile/product">更多</a>
    </div>
    <!-- 商品图 -->
    <div class="cont_model">
        <div class="w702 p_b_20">
            <div class="contentbox clearfix">
                <ul class="j-products">
                    <li class="fl p_b_24">
                        <a class="warp_link posr" href="">
                            <img src="">
                            <p class="fs30 posa p_l_20 c_fff"></p>
                        </a>
                    </li>
                    <li class="fr p_b_24">
                        <a class="warp_link posr" href="">
                            <img src="">
                            <p class="fs30 posa p_l_20 c_fff"></p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <ol class="c_666 prl24">
        <li class="m_b_15">已累计服务200万业主</li>
        <li class="m_b_15">服务已覆盖150个城市</li>
        <li class="m_b_15">98万入驻师傅、7万入驻门窗厂家</li>
    </ol>
</div>


</body>
@endsection