@extends('user.layouts.master-member')

@section('script')
<script type="text/javascript">
    $('.j-delete').click(function () {
        var $this= $(this);
        var id = $this.data('id');
        $.jAjax({
            url:'/api/user/card/'+id,
            type:'DELETE',
            success:function (data) {
                if(data.status=='success'){
                    $this.closest('.z_border').slideUp();
                }
            }
        })
    })
</script>
@endsection

@section('uc_content')
<div class="z_w82p fr z_minh640">
    <!--导航-->
    <div class="clearfix">
        <div class="z_font14 z_lineh40">
            <a href="/user/coin" title="余额" class="z_color_6">余额</a>
            &gt;
            <a href="/user/card" title="银行卡管理" class="z_color_6">银行卡管理</a>
        </div>
    </div>
    <!--导航 end-->
    <!--银行卡管理 -->
    <div class="z_pl20 clearfix">
        @foreach(auth()->user()->cards as $card)
            <div class="z_border z_mb20 fl z_w244 z_mr10">
                <div class="z_p10 posr">
                    <div class="z_text z_font14">
                        <div class="z_lineh30 z_mb10">
                            <span>{{ $card->bank }} {{ $card->name }}</span>
                        </div>
                        <p class="z_mb10">{{ substr_replace($card->number, '*', 0, -4) }}</p>
                    </div>
                    <input type="button" value="删除"
                           class="z_btn bar-Grey-e4 z_font12 z_w68 z_ptb3-i posa z_right-10 z_bottom-10 z_index-8 z_border-c z_color_6 j-delete"
                           data-id="{{ $card->id }}"/>
                </div>
            </div>
        @endforeach
        <div class="z_border z_mb20 fl z_w244 z_mr10">
            <a href="/user/card/create" title="添加银行卡">
                <img src="/images/icon/tb56.png" />
            </a>
        </div>
    </div>
    <!--银行卡管理 end-->
</div>
@endsection