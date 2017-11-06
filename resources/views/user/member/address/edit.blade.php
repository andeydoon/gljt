@extends('user.layouts.master-member')

@section('script')
<script type="text/javascript">
    $.jAjax({
        url: '/api/area',
        success: function (data) {
            $.each(data.data.areas, function () {
                $('<li/>', {
                    'data-id': this.id,
                    'text': this.name,
                }).appendTo('.j-province');
            })

            $('.j-province li[data-id="' + $('[name="province_id"]').val() + '"]').trigger('click');
        }
    });

    $('.j-province').on('click', 'li', function () {
        $.jAjax({
            url: '/api/area',
            data: {'parent_id': $(this).data('id')},
            success: function (data) {
                $('.j-city').empty().prev().text('市');
                $('.j-district').empty().prev().text('区/县');
                $.each(data.data.areas, function () {
                    $('<li/>', {
                        'data-id': this.id,
                        'text': this.name,
                    }).appendTo('.j-city');
                })


                $('.j-city li[data-id="' + $('[name="city_id"]').val() + '"]').trigger('click');
            }
        });
    });

    $('.j-city').on('click', 'li', function () {
        $.jAjax({
            url: '/api/area',
            data: {'parent_id': $(this).data('id')},
            success: function (data) {
                $('.j-district').empty().prev().text('区/县');
                $.each(data.data.areas, function () {
                    $('<li/>', {
                        'data-id': this.id,
                        'text': this.name,
                    }).appendTo('.j-district');
                })

                $('.j-district li[data-id="' + $('[name="district_id"]').val() + '"]').trigger('click');
            }
        });
    });

    $('.j-district').on('click', 'li', function () {
    });

    $('.j-submit').click(function () {
        $.jAjax({
            url: '/api/user/address/{{ $userAddress->id }}',
            type: 'PUT',
            data: $('.j-form :input').serialize(),
            success: function (data) {
                if (data.status == 'success') {
                    alert('地址编辑成功');
                    window.location = '/user/address';
                }
            }
        });
    });
</script>
@endsection

@section('uc_content')
<div class="z_w82p fr z_minh640">
    @include('user.layouts.card-user')
    <div class="z_mtb10  z_border_b clearfix">
        <span class="z_font14 z_color_3 z_lineh40">编辑收货地址</span>
    </div>
    <!--收货地址 -->
    <div class="clearfix z_mt10">
        <div class="z_user_msg z_user_msg2 z_w100p clearfix z_mt20 j-form">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="z_inputbox clearfix z_mb10">
                <label class="z_w120 z_lineh30 z_font14 z_color_3 fl">收货人姓名</label>
                <div class="fl" style="">
                    <input type="text" name="name" placeholder="" class="z_input z_border z_ptb7" value="{{ $userAddress->name }}">
                </div>
            </div>
            <div class="z_inputbox clearfix z_mb10">
                <label class="z_w120 z_lineh30 z_font14 z_color_3 fl">手机号码</label>
                <div class="fl" style="">
                    <input type="text" name="phone" placeholder="" class="z_input z_border z_ptb7" value="{{ $userAddress->phone }}">
                </div>
            </div>
            <div class="z_inputbox clearfix z_mb10">
                <label class="z_w120 z_lineh30 z_font14 z_color_3 fl">所在地区</label>
                <div class="fl clearfix">
                    <div class="fl bar-white z_border z_mr10" style="width: 139px;">
                        <input type="hidden" name="province_id" placeholder="" class="z_input " value="{{ $userAddress->province_id }}"/>
                        <div class="z_select_div  js-z_select_div">
                            <p>省/直辖市</p>
                            <ul class="hide js-z_select_ul j-province"></ul>
                            <span class="z_tubiao js-z_tubiao">
                                <!--图标-->
                            </span>
                        </div>
                    </div>
                    <div class="fl bar-white z_border z_mr10" style="width: 139px;">
                        <input type="hidden" name="city_id" placeholder="" class="z_input " value="{{ $userAddress->city_id }}"/>
                        <div class="z_select_div  js-z_select_div">
                            <p>市</p>
                            <ul class="hide js-z_select_ul j-city"></ul>
                            <span class="z_tubiao js-z_tubiao">
                                <!--图标-->
                            </span>
                        </div>
                    </div>
                    <div class="fl bar-white z_border z_mr10" style="width: 139px;">
                        <input type="hidden" name="district_id" placeholder="" class="z_input " value="{{ $userAddress->district_id }}"/>
                        <div class="z_select_div  js-z_select_div">
                            <p>区/县</p>
                            <ul class="hide js-z_select_ul j-district"></ul>
                            <span class="z_tubiao js-z_tubiao">
                                <!--图标-->
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="z_inputbox clearfix z_mb10">
                <label class="z_w120 z_lineh30 z_font14 z_color_3 fl">详细地址</label>
                <div class="z_ml140" style="width: 366px;">
                    <div class="z_text-wrap z_border z_p10 ">
                        <textarea class="z_textarea z_h70" name="street" placeholder="请输入您的详细地址">{{ $userAddress->street }}</textarea>
                    </div>
                </div>
            </div>
            <div class="z_inputbox clearfix z_mb10">
                <label class="z_w120 z_lineh30 z_font14 z_color_3 fl">楼层信息</label>
                <div class="fl" style="">
                    <input type="text" name="floor" placeholder="" class="z_input z_border z_ptb7" value="{{ $userAddress->floor }}">
                </div>
            </div>
            <div class="z_inputbox clearfix z_mb10">
                <label class="z_w120 z_lineh30 z_font14 z_color_3 fl">选择电梯情况</label>
                <div class="fl z_lineh30 z_font14 z_color_3" style="">
                    <input type="radio" name="lift" value="1"{{ $userAddress->lift==1 ? ' checked' : '' }}> 有
                    <input type="radio" name="lift" value="0"{{ $userAddress->lift==0 ? ' checked' : '' }}> 没有
                </div>
            </div>
            <div class="z_inputbox clearfix z_mb10">
                <label class="z_w120 z_lineh30 z_font14 z_color_3 fl">设置为默认地址</label>
                <div class="fl z_lineh30 z_font14 z_color_3" style="">
                    <input type="checkbox" name="default" value="1"{{ $userAddress->default==1 ? ' checked' : '' }}>
                </div>
            </div>
            <div class="z_inputbox z_mt20 z_mb20 z_ml180">
                <input type="submit" value="保存收货地址"  class="z_btn bar-auburn z_font12 z_w120 z_ptb9 j-submit"/>
            </div>
        </div>
    </div>
    <!--收货地址 end-->

</div>
@endsection