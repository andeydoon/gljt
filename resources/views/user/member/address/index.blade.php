@extends('user.layouts.master-member')

@section('script')
<script type="text/javascript">
</script>
@endsection

@section('uc_content')
<div class="z_w82p fr z_minh640">
    @include('user.layouts.card-user')
    <div class="z_mtb10  z_border_b clearfix">
        <span class="z_font14 z_color_3 z_lineh40">收货地址</span>
        <a href="/user/address/create" title="新增" class="bar-auburn z_color_white z_ptb3 z_plr10 fr z_mt10">+新增</a>
    </div>
    <!--收货地址 -->
    <div class="clearfix z_mt10">
        @foreach(auth()->user()->addresses as $address)
            <div class="z_ptb10 posr bar-GreyGreed z_w370 z_mb20 z_mr20 fl z_daddress{!! $address->default ? ' active' : '' !!}">
                <div class="z_plr20">
                    <ul class="z_font12 z_color_6 z_lineh24">
                        <li>
                            收货人：<span>{{ $address->name }}</span>
                        </li>
                        <li>
                            手机号码：<span>{{ $address->phone }}</span>
                        </li>
                        <li>
                            楼层信息：<span>{{ $address->floor }}</span>
                        </li>
                        <li>
                            电梯情况：<span>{{ $address->lift ? '有' : '无' }}</span>
                        </li>
                        <li style="height: 48px;">
                            所在地区：<span>{{ $address->street }}</span>
                        </li>
                    </ul>
                </div>
                <div class="z_plr20 tr z_mt10">
                    <a href="/user/address/{{ $address->id }}/edit"  class="z_btn bar-auburn z_font12 z_w68 z_ptb3-i z_mr10">编辑</a>
                </div>
                <!--默认地址 标记-->
                <span  class="bar-GreyAuburn z_color-auburn z_more_span">默认地址</span>
                <!--默认地址 标记 end-->
            </div>
        @endforeach
    </div>
    <!--收货地址 end-->

</div>
@endsection