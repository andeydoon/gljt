@extends('user.layouts.master-master')

@section('script')
<script type="text/javascript">
</script>
@endsection

@section('uc_content')
<div class="z_w82p fr z_minh640">
    @include('user.layouts.card-user')
    <div class="z_m10 tr">
        <a href="/user/card" title="银行卡管理" class="bar-auburn z_color_white z_ptb3 z_plr10">银行卡管理</a>
    </div>
    <!--余额 -->
    <div class="clearfix z_p10">
        <div class="z_border">
            <table class="z_table3">
                <thead class="bar-GreyGreed">
                <tr>
                    <th colspan="4" class="tl z_font14"><span class="z_ml20">交易记录</span></th>
                </tr>
                </thead>
                <tbody>
                @foreach(auth()->user()->coins as $coin)
                    <tr>
                        <td class="tl">
                            <span class="z_ml20">{{ $coin->created_at }}</span>
                        </td>
                        <td>{{ $coin->amount }}</td>
                        <td>{{ $coin->remark }}</td>
                        <td><span class="z_color-auburn">交易成功</span></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!--余额 end-->
</div>
@endsection