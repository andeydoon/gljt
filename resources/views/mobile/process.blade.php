@extends('mobile.layouts.master')

@section('css')
<link rel="stylesheet" href="/packages/mobile/css/rest.css">
@endsection

@section('body')
<body class="bg_fff">
<header class="header bg_fff clearfix posr p_t_30 p_b_30 b_b_e5 p_l_24 p_r_24">
    <a class="return fl" href="javascript:window.history.back();"></a>
    <div class="text fl fs_36 t_a_c c_1b1 top_title x_center">施工流程</div>
    <a class="confirm fr" href="/mobile"></a>
</header>
<div class="liucheng w702 fs_34">
    <ul>
        <li class="content ">
            <p class="pbt24">1、发布需求</p>
            <p class="heiline15">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin
                gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum
                sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam fermentum,
                nulla luctus pharetra vulputate, felis tellus mollis orci, sed rhoncus sapien nunc eget.
            </p>
        </li>
        <li class="content m_t_15">
            <p class="pbt24">2、师傅接单</p>
            <p class="heiline15">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin
                gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum
                sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam fermentum,
                nulla luctus pharetra vulputate, felis tellus mollis orci, sed rhoncus sapien nunc eget.
            </p>
        </li>
        <li class="content m_t_15">
            <p class="pbt24">2、免费上门测量</p>
            <p class="heiline15">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin
                gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum
                sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam fermentum,
                nulla luctus pharetra vulputate, felis tellus mollis orci, sed rhoncus sapien nunc eget.
            </p>
        </li>
    </ul>
</div>
</body>
@endsection