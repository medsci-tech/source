<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="nofollow" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="renderer" content="webkit">
    <meta name="_token" content="{{ csrf_token() }}"/>
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('favicon.ico')}}"/>
    <title>@yield('title','素材收集平台')</title>
    <link rel="stylesheet" href="{{asset('resources/views/home/static/css/pintuer.css')}}">
    <link rel="stylesheet" href="{{asset('resources/views/home/static/css/admin.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('resources/views/home/static/css/jquery-ui.css')}}" />
    <link rel="stylesheet" href="{{asset('resources/views/home/static/css/main.css')}}">
    <link href="http://apps.bdimg.com/libs/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">
    @section('css')
    @show
    <script src="https://cdn.bootcss.com/jquery/3.3.0/jquery.min.js"></script>
    <script src="http://apps.bdimg.com/libs/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <script src="{{asset('resources/views/home/static/js/pintuer.js')}}"></script>
    @section('js')
    @show

</head>
<body style="background-color:#f2f9fd;">
<div class="header bg-main">
    <div class="margin-big-left l">
        <h1 class="frontLogo"></h1>
    </div>
    <div class="head-med"><button class="btn btn-primary btn-addMaterial">上传素材</button></div>
    <div class="city-info-right clearfix">
        <a href="javascript:;">{{session('user')->doctor_name}}</a>
        <a href="javascript:;">{{session('user')->doctor_mobile}}</a>
        <a href="{{url('home/quit')}}" class=" br0">退出</a>
    </div>
    <div class="clear"></div>
</div>
<div class="leftnav">
    <div class="h50"></div>
    <ul>
        <li @if(Request::is('home/userfile/*')) class="active" @endif><a href="{{url('home/userfile/index')}}">个人文件</a></li>
        <li @if(Request::is('home/sharefile/*')) class="active" @endif><a href="{{url('home/sharefile/index')}}">共享文件</a></li>
        <li @if(Request::is('home/userinfo/index')) class="active" @endif><a href="{{url('home/userinfo/index')}}">个人信息</a></li>
        {{--<li @if(Request::is('home/recommendinfo/*')) class="active" @endif><a href="{{url('home/recommendinfo/index')}}">推荐人信息</a></li>--}}
        <li @if(Request::is('home/userinfo/modifypassword')) class="active" @endif><a href="{{url('home/userinfo/modifypassword')}}">修改密码</a></li>
        <li @if(Request::is('home/userinfo/questions')) class="active" @endif><a href="{{url('home/userinfo/questions')}}">常见问题</a></li>
    </ul>
</div>

<div class="admin">
    {{--<iframe scrolling="auto" rameborder="0" src="{{url('home/userfile/index')}}" name="right" width="100%" height="100%"></iframe>--}}
    @section('content')
    @show
</div>
<!-- 模态框（Modal） -->
@include('layouts/common')

</body>
</html>
@section('addDiv')
@show
@section('floorjs')
@show