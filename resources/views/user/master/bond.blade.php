@extends('user.layouts.master-master')

@section('script')
<script type="text/javascript">
</script>
@endsection

@section('uc_content')
<div class="z_w82p fr z_minh640">
    @include('user.layouts.card-user')
    <div class="z_border_b z_mt10 z_mb10  clearfix">
        <div class="z_font14 z_color_3 z_lineh40">
            保证金
        </div>
    </div>
    <div class="z_color_3 z_font14 z_lineh30 z_mb20 z_ml30">
        要在平台上抢单，需要交纳1500元押金（押金可退）
    </div>
    <!--保证金-->
    <!--支付方式-->
    <div class="z_plr10 z_border_t z_pb10">
        <div class="clearfix z_lineh30 z_color_3 z_font14 z_mt10 z_mb10">
            <span>支付方式</span>
        </div>
        <div class="clearfix z_font12 z_color_3 z_lineh24">
            <ul class="clearfix z_zifu_ul js-z_zifu_ul">
                <li class="active">
                    支付宝支付
                    <!--选中标识-->
                    <span class="z_biaoshi2"></span>
                    <!--选中标识 end-->
                </li>
                <li>
                    微信支付
                    <!--选中标识-->
                    <span class="z_biaoshi2"></span>
                    <!--选中标识 end-->
                </li>
            </ul>
        </div>
    </div>
    <!--支付方式 end-->
    <div class="z_p10 tc z_mt20">
        <a href="javascript:void(0);" class="z_btn bar-auburn z_font14 z_w110 z_ptb7">充值押金</a>
    </div>
    <!--保证金 end-->
</div>
@endsection