@extends('user.layouts.master-member')

@section('script')
<script type="text/javascript">
    $(".j-delete").click(function () {
        var $this = $(this);
        $.jAjax({
            url: '/api/product/favorite',
            type: 'POST',
            data: {id: $this.data('id'), type: 'PRODUCT'},
            success: function (data) {
                if (data.status = 'success') {
                    $this.closest('.z_border').slideUp();
                }
            }
        })
    });
</script>
@endsection

@section('uc_content')
<div class="z_w82p fr z_minh640">
    @include('user.layouts.card-user')
    <!--我的收藏 -->
    <div class="z_mt10 clearfix">
        @foreach(auth()->user()->favorites as $favorite)
            <div class="z_border z_mb10 fl z_w320 z_h120 z_mr40">
                <div class="z_p10 posr">
                    <div class="posr clearfix">
                        <img src="{{ $favorite->product->galleries()->value('src') }}" class="z_w100 z_h100 z_mr10 fl"/>
                        <div class="z_text">
                            <h2 class="z_fontn z_font12 z_color_3 z_lineh30">{{ $favorite->product->name }}</h2>
                        </div>
                        <a href="/product/{{ $favorite->related_id }}" title="{{ $favorite->product->name }}"
                           class="z_lianjie"></a>
                    </div>
                    <input type="button" value="删除"
                           class="z_btn bar-auburn z_font12 z_w68 z_ptb3-i posa z_right-10 z_bottom-10 z_index-8 j-delete"
                           data-id="{{ $favorite->related_id }}"/>
                </div>
            </div>
        @endforeach
    </div>
    <!--我的收藏 end-->
</div>
@endsection