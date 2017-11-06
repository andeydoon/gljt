@extends('user.layouts.master-dealer')

@section('script')
<script type="text/javascript">
    $('.j-status p').text($('.j-status li[selected]').text());

    $('.js-z_select_ul li').click(function () {
        window.location = '/user/apply?status=' + $(this).data('value');
    })

    $('.j-accept,.j-reject').click(function () {
        var $this = $(this);
        $.jAjax({
            url: '/api/user/apply/' + $this.data('id') + '/patch',
            type: 'PATCH',
            data: {status: $this.data('value')},
            success: function (data) {
                if (data.status == 'success') {
                    alert($this.val() + '操作成功');
                    window.location.reload();
                }
            }
        });
    });
</script>
@endsection

@section('uc_content')
<div class="z_w82p fr z_minh640">
    @include('user.layouts.card-user')
    <!--标题-->
    <div class="z_border_b">
        <div class="z_lineh30 z_font14 z_mt15 z_mb5 z_color_3">
            师傅申请
        </div>
    </div>
    <!--标题 end-->
    <!--师傅申请-->
    <div class="z_mb10">
        <div class="clearfix z_mt10 z_mb20">
            <div class="z_inputbox clearfix fl z_mt5 j-status">
                <label class="z_w60 z_lineh30 z_font14 z_color_3 fl z_mr10">审核状态</label>
                <div class="fl" style="">
                    <div class="fl bar-white z_border z_mr10" style="width: 90px;">
                        <input type="hidden" name="" placeholder="" class="z_input "/>
                        <div class="z_select_div  js-z_select_div">
                            <p></p>
                            <ul class="hide js-z_select_ul">
                                <li data-value=""{!! old('status')==''?' selected':'' !!}>全部</li>
                                <li data-value="0"{!! old('status')=='0'?' selected':'' !!}>待审</li>
                                <li data-value="1"{!! old('status')=='1'?' selected':'' !!}>通过</li>
                                <li data-value="2"{!! old('status')=='2'?' selected':'' !!}>拒绝</li>
                            </ul>
                            <span class="z_tubiao js-z_tubiao">
                                <!--图标-->
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="z_form z_border z_w360  posr fr">
                <div class="z_inputbox clearfix posr">
                    <span class="z_border_r z_ml10 z_pr10">
                        <img src="/images/icon/tb26.png" width="18" height="19" />
                    </span>

                    <input type="text"  placeholder="师傅名称、手机号" class="z_input z_w240"/>
                    <button class="z_w74 tc bar-Grey-f8 z_butn z_font14 z_color_6 z_border_l-i z_cursor">
                        搜索
                    </button>
                </div>
            </div>
        </div>
        <!--师傅列表-->
        <div class="clearfix">
            @foreach($masters as $master)
                <div class="z_border bar-Grey-fa z_mb10">
                    <table class="z_table4">
                        <tbody>
                        <tr>
                            <td class="z_border_r z_plr10">
                                {{ $master->profile->realname }}
                            </td>
                            <td class="z_border_r z_plr10">
                                {{ $master->mobile }}
                            </td>
                            <td class="z_border_r z_plr10">
                                {{ $master->profile->card_number }}
                            </td>
                            <td class="z_border_r z_plr10">
                                @foreach(explode('|',$master->profile->service_item) as $value)
                                    <p>{{ $value }}</p>
                                @endforeach
                            </td>
                            <td class="z_w100">
                                @if(!$master->status)
                                    <div class="z_mb5 tc">
                                        <input type="button" value="通过"
                                               class="z_btn bar-Grey-ef z_font12 z_w60 z_ptb3-i z_border z_color_3 j-accept"
                                               data-id="{{ $master->public_id }}" data-value="1">
                                    </div>
                                    <div class="tc">
                                        <input type="button" value="拒绝"
                                               class="z_btn bar-Grey-ef z_font12 z_w60 z_ptb3-i z_border z_color_3 j-reject"
                                               data-id="{{ $master->public_id }}" data-value="2">
                                    </div>
                                @else
                                    @if($master->status==1)
                                        已通过
                                    @endif
                                    @if($master->status==2)
                                        已拒绝
                                    @endif
                                @endif
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            @endforeach
        </div>
        <!--师傅列表 end-->
    </div>
    <!--师傅申请 end-->
</div>
@endsection