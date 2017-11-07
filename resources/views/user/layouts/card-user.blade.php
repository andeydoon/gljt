<!--个人头像信息-->
<div class="z_personal_h bar-GreyGreed clearfix z_mt10 posr">
    <div class="z_w50p fl clearfix">
        <div class="z_mlr20 z_mtb20  z_personal_h_img fl">
            <img src="/images/other/tp4.png"/>
        </div>
        <div class="z_text2 z_mt20">
            <h2 class="z_font16 z_lineh30">{{ auth()->user()->mobile }}</h2>
            <p class="z_font12 z_color_6">账号ID：<span>{{ auth()->user()->public_id }}</span></p>
        </div>
    </div>

    @if(request()->is('user/coin'))
        <div class="z_w30p  fr z_border z_m10 z_border_ra-5">
            <div class="z_p10 bar-white z_border_ra-5 z_h70 clearfix">
                <div class="z_w63p fl tc">
                    <p class="z_color_6 z_font16 z_lineh40">账户余额</p>
                    <p class="z_color-orange z_font14"><span class="z_font20 z_fontb">{{ auth()->user()->coins()->sum('amount') }}</span>元</p>
                </div>
                <a href="#" title="提现" class="z_btn bar-Grey-e4 z_font14 z_w70 z_ptb3-i z_color_3 z_border-c z_mt20">提现</a>
            </div>
        </div>
    @else
        @if(auth()->user()->type==1)
            <div class="z_w50p posa z_right-10 z_bottom-10 clearfix">
                <div class="z_nav2 bar-white z_ptb10 fr" style="display: inline-block;">
                    <ul class="clearfix">
                        <li class="">
                            全部
                            <a href="javascript:void(0);" title="全部" class="z_lianjie"></a>
                            <!--有新信息标记-->
                            <em class="z_yuan"></em>
                        </li>
                        <li>
                            待付定金
                            <a href="javascript:void(0);" title="待付定金" class="z_lianjie"></a>
                        </li>
                        <li>
                            待施工
                            <a href="javascript:void(0);" title="待施工" class="z_lianjie"></a>
                        </li>
                    </ul>
                </div>
            </div>
        @else
            @php $score = auth()->user()->profile->score; @endphp
            <div class="fr clearfix z_mr10 z_mt10">
                <div class="z_ewema fl z_mr20 z_mt10">
                    <div class="z_img_back">
                        <img src="/images/other/tp13.png">
                    </div>
                </div>
                <div class="fl bar-white z_border z_w200 z_border_ra-5 z_p10">
                    <div class="tc z_font28 z_fontb">
                        {{ round($score*20) }}
                    </div>
                    <div class="magnify" style="">
                        <div class="score_in_box tc z_mt0-i">
                            @for($i=0; $i<round($score); $i++)
                                <span class="score_star"><img src="/images/icon/tb62a.png" alt="star"></span>
                            @endfor

                        </div>
                    </div>
                </div>
            </div>

        @endif
    @endif
</div>
<!--个人头像信息 end-->