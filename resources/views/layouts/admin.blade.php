<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name=”robots” content=”nofollow” />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('favicon.ico')}}"/>

    <meta name="renderer" content="webkit">
    <meta name="_token" content="{{ csrf_token() }}"/>
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{asset('resources/views/admin/static/css/pintuer.css')}}">
    <link rel="stylesheet" href="{{asset('resources/views/admin/static/css/admin.css')}}">
    <link rel="stylesheet" href="{{asset('resources/views/admin/static/css/main.css')}}">
    @section('css')

    @show
    <script src="{{asset('resources/views/admin/static/js/jquery.js')}}"></script>
    <script src="{{asset('resources/views/admin/static/js/pintuer.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/views/admin/static/js/jquery-ui-1.10.4.custom.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/views/admin/static/js/jquery.ui.datepicker-zh-CN.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/views/admin/static/js/jquery-ui-timepicker-addon.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/views/admin/static/js/jquery-ui-timepicker-zh-CN.js')}}"></script>
    @section('js')

    @show
</head>
<body>
<div class="header">
    <div class="logo margin-big-left fadein-top">
        <h1><img src="{{asset('resources/views/admin/static/images/u11.png')}}" class="radius-circle rotate-hover" height="40" alt="mime医学众包服务平台" />MIME医学众包服务平台</h1>
    </div>
    <div class="head-l"><a class="button button-little bg-green" href="{{url('login')}}" target="_blank">
            <span class="icon-home"></span> 前台首页</a> &nbsp;&nbsp;
        <a href="javascript:;" class="button button-little bg-blue">
            <span class="icon-wrench"></span>&nbsp;&nbsp;{{session('admin')->user_name}}</a> &nbsp;&nbsp;

        <a class="button button-little bg-red" href="{{url('admin/quit')}}"><span class="icon-power-off"></span> 退出登录</a>
    </div>
</div>
<div class="leftnav">
    <div class="h50"></div>
    <ul>
        <li @if(Request::is('admin/material/index')) class="active" @endif><a href="{{url('admin/material/index')}}">素材管理</a></li>

        @if(session('admin')->user_name =='admin')
            <li @if(Request::is('admin/tools/index')) class="active" @endif><a href="{{url('admin/tools/index')}}">工具分享</a></li>
            <li @if(Request::is('admin/doctor/index')) class="active" @endif><a href="{{url('admin/doctor/index')}}">医生管理</a></li>
            <li @if(Request::is('admin/recommend/index')) class="active" @endif><a href="{{url('admin/recommend/index')}}">推荐人管理</a></li>
            <li @if(Request::is('admin/bigarea/index')) class="active" @endif><a href="{{url('admin/bigarea/index')}}">大区管理</a></li>
            <li @if(Request::is('admin/area/index')) class="active" @endif><a href="{{url('admin/area/index')}}">地区管理</a></li>
            <li @if(Request::is('admin/sales/index')) class="active" @endif><a href="{{url('admin/sales/index')}}">销售组管理</a></li>
            <li @if(Request::is('admin/hospital/index')) class="active" @endif><a href="{{url('admin/hospital/index')}}">医院管理</a></li>
            <li @if(Request::is('admin/materialtype/index')) class="active" @endif><a href="{{url('admin/materialtype/index')}}">素材类型管理</a></li>
            <li @if(Request::is('admin/report/index')) class="active" @endif><a href="{{url('admin/report/index')}}">报表管理</a></li>
        @endif
    </ul>
    <!--<h2><span class="icon-pencil-square-o"></span>栏目管理</h2>-->
    <!--<ul>-->
    <!---->
    <!--</ul>  -->
</div>
<script type="text/javascript">
    $(function(){
        $(".leftnav h2").click(function(){
            $(this).next().slideToggle(200);
            $(this).toggleClass("on");
        })
        $(".leftnav ul li a").click(function(){
            $("#a_leader_txt").text($(this).text());
            $(".leftnav ul li a").removeClass("on");
            $(this).addClass("on");
        })
    });
</script>
<ul class="bread">
    <li><a href="{{url('admin/material/index')}}" target="right" class="icon-home"> 首页</a></li>
    <li><a href="javascript:;" id="a_leader_txt">素材管理</a></li>
</ul>
<div class="admin">
    {{--<iframe scrolling="auto" rameborder="0" src="{{url('admin/material/index')}}" name="right" width="100%" height="100%"></iframe>--}}
    @section('content')
    @show
</div>
</body>
</html>
@section('addDiv')
@show
@section('adminjs')
@show