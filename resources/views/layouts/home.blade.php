<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name=”robots” content=”nofollow” />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="renderer" content="webkit">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('favicon.ico')}}"/>
    <title>素材搜集平台</title>
    <link rel="stylesheet" href="{{asset('resources/views/home/static/css/pintuer.css')}}">
    <link rel="stylesheet" href="{{asset('resources/views/home/static/css/admin.css')}}">
    <script src="{{asset('resources/views/home/static/js/jquery.js')}}"></script>
    <link rel="stylesheet" href="{{asset('resources/views/home/static/css/main.css')}}">
</head>
<body style="background-color:#f2f9fd;">
<div class="header bg-main">
    <div class="margin-big-left l">
        <h1 class="frontLogo"></h1>
    </div>
    <div class="city-info-right clearfix">
        <a href="javascript:;">{{$user->doctor_name}}</a>
        <a href="javascript:;">{{$user->doctor_mobile}}</a>
        <a href="{{url('home/quit')}}" class=" br0">退出</a>
    </div>

</div>
<div class="leftnav">
    <div class="h50"></div>
    <ul style="display:block">
        <li><a href="{{url('home/userfile/index')}}" target="right">个人文件</a></li>
        <li><a href="{{url('home/sharefile/index')}}" target="right">共享文件</a></li>
        <li><a href="{{url('home/userinfo/index')}}" target="right">个人信息</a></li>
        <li><a href="{{url('home/recommendinfo/index')}}" target="right">推荐人信息</a></li>
        <li><a href="{{url('home/userinfo/modifypassword')}}" target="right">修改密码</a></li>
    </ul>
</div>

<div class="admin">
    <iframe scrolling="auto" rameborder="0" src="{{url('home/userfile/index')}}" name="right" width="100%" height="100%"></iframe>
</div>

</body>
</html>