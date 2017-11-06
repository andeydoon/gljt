@extends('mobile.layouts.master')

@section('script')
<script type="text/javascript">

</script>
@endsection

@section('body')
<body class="bg_f2f">
<header class="header bg_fff clearfix posr p_t_30 p_b_30 b_b_e5 p_l_24 p_r_24">
    <a class="return fl" href="javascript:window.history.back();"></a>
    <div class="text fl fs_36 t_a_c c_1b1 top_title x_center">收货地址</div>
    <a class="fr fs_30 p_t_3" href="/mobile/user/address/create">添加</a>
</header>

<!-- 收货地址 -->
@foreach(auth()->user()->addresses as $address)
    <div class="adderss_dao prl24 clearfix posr p_b_18 bg_fff">
        <div class="addre_name fl">
            <ul class="fs_30 c_999">
                <li class="fs_32 c_333 m_t_20 ">收货人：{{ $address->name }} <i>{{ $address->phone }}</i></li>
                <li class="m_t_18 "><i>{{ $address->province->name }}</i> <i>{{ $address->city->name }}</i> <i>{{ $address->district->name }}</i></li>
                <li class="m_t_18 ">{{ $address->street }}</li>
                <li class="m_t_18">楼层信息：{{ $address->floor }}</li>
                <li class="m_t_18">电梯情况：{{ $address->lift ? '有' : '无' }}</li>
            </ul>
        </div>
        <div class="setadderss fr posa y_center">
            <a href="/mobile/user/address/{{ $address->id }}/edit"><span class="edit_icon"></span></a>
        </div>
    </div>
    <div class="null20"></div>
@endforeach
</body>
@endsection