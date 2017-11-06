@extends('user.layouts.master-member')

@section('script')
<script type="text/javascript">
</script>
@endsection

@section('uc_content')
<div class="z_w82p fr z_minh640">
    @include('user.layouts.card-user')
    <!--我的积分 -->
    <div class="z_mt20 z_p10 clearfix bar-GreyGreed">
        <div class="z_w20p fl">
            <div class=" tc z_border_r z_h100">
                <p class="z_font16 z_color_3 z_lineh40 z_mt20">积分</p>
                <p class="z_fontb z_color-orange z_font24 z_lineh40">{{ auth()->user()->credits()->sum('score') }}</p>
            </div>

        </div>
        <div class="z_w80p fl">
            <div class="z_text_2 z_text_2-hn z_plr20">
                <h2>Q：什么是积分</h2>
                <p>积分可以购物，积分可以购物，积分可以购物，积分可以购物，积分可以购物，积分可以购物，积分可以购物，积分 积分可以购物，积分可以</p>
                <br />
                <h2>Q：如何使用积分？</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum sonatoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam fermentum, nulla luctus pharetra vulputate, felis tellus mollis orci, sed rhoncus sapien nunc eget.</p>
            </div>
        </div>
    </div>
    <!--表格-->
    <div class="z_mt20">
        <table class="z_table2">
            <thead class="bar-GreyGreed">
            <tr>
                <th class="z_w34p z_border_r tl">
                    <span class="z_ml40">用途/器材</span>
                </th>
                <th class="z_border_r">积分变化</th>
                <th class="z_w34p">日期</th>
            </tr>
            </thead>
            <tbody class="z_font14">
            @foreach(auth()->user()->credits as $credit)
            <tr>
                <td class="tl">
                    <div class="z_mlr30">
                        {{ $credit->item }}
                    </div>
                </td>
                <td class="tc"><span class="z_color-orange"><span class="z_fontb">{{ $credit->score }}</span></span></td>
                <td class="tc"><span class="z_color_9">{{ $credit->created_at }}</span></td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <!--表格 end-->
    <!--我的积分 end-->
</div>
@endsection