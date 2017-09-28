<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>素材收集平台-登录</title>
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('resources/views/home/static/css/global.css')}}">
    <link rel="stylesheet" href="{{asset('resources/views/home/static/css/main.css')}}">
    <script src="{{asset('resources/views/home/static/js/jquery.js')}}"></script>
</head>
<body style="overflow: hidden;height: 100%;">
<div class="comm registerBox loginBox">
    <div class="regisWrapper loginWrapper">
        <div class="in2">
            <div class="logo2"></div>
            <form class="form-horizontal loginForm" method="post" action="{{url('login')}}">
                {{csrf_field()}}
                @if(session('msg'))
                    <div class="tips-center">{{session('msg')}}</div>
                @endif
                <div class="form-group">
                    <label class="col-sm-5 control-label">手机号</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="doctor_mobile">
                        <div class="tips"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-5 control-label">密码</label>
                    <div class="col-sm-4">
                        <input type="password" class="form-control" name="password">
                        <div class="tips"></div>
                    </div>
                </div>
                <a href="{{url('forget')}}" class="wjmm">忘记密码?</a>
                <a href="javascript:;" onclick="$('.loginForm').submit();" class="dl"></a>
                <a href="{{url('register')}}" class="wjmm wjmm2">还没有账号？立即注册</a>
            </form>
        </div>

    </div>
</div>
</body>
</html>