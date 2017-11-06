@extends('layouts.master')

@section('content')
<div class="z_center119">
    <div class="z_w764p z_mlrauto">
        <div class="clearfix">
            <div class="z_lineh40 z_font20 z_mt15 z_mb10 z_color_3">
                消息中心
            </div>
        </div>
        @if(auth()->user()->notifications)
            <!--消息box-->
            <div class="z_mb10">
                @foreach(auth()->user()->notifications as $notification)
                    <div class="z_border_t z_mb10">
                        <div class="clearfix z_lineh40 z_mt10">
                            <span class="z_plr10 z_border_auburn-l-4 z_font18 z_color_3">系统信息</span>
                            <span class="z_font14 z_color_9 z_ml10">{{ $notification->created_at }}</span>
                        </div>
                        <div class="z_plr10 z_pb20 clearfix posr">
                            <div class="posr clearfix">
                                <div class="z_text z_font16 z_lineh24">
                                    {!! $notification->data['content'] !!}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <!--消息box end-->
        @else
            <!--没有信息时-->
            <div class="z_mb10">
                <div class="z_border_t z_mb10">
                    <div class="z_plr10 z_pb20 clearfix posr">
                        <div class="posr clearfix">
                            <div class="z_text z_font16 z_lineh24 z_color_9 z_mt10">
                                <p>暂时没有消息~</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--没有信息时 end-->
        @endif
    </div>
</div>
@endsection