@extends('mobile.layouts.master')

@section('body')
<body class="bg_f2f">
<header class="header bg_fff clearfix posr p_t_30 p_b_30 b_b_e5 p_l_24 p_r_24">
    <a class="return fl" href="javascript:window.history.back();"></a>
    <div class="text fl fs_36 t_a_c c_1b1 top_title x_center">消息</div>
    <a class="confirm fr" href="/mobile"></a>
</header>
@foreach(auth()->user()->notifications as $notification)
<div class="w702 bg_fff posr info_list m_t_24 posr">
    <a class="show" href="#">
        <p class="fs_30 c_1b1 inofmeass Singleellipsis">{!! $notification->data['content'] !!}</p>
        <p class="fs_24 c_999 p_l_20 inofdata">{{ $notification->created_at }}</p>
        <i class="newPrompt posa"></i>
    </a>
</div>
@endforeach
</body>
@endsection