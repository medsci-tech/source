<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="_token" content="{{ csrf_token() }}"/>
    <title>忘记密码</title>
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('resources/views/home/static/css/global.css')}}">
    <link rel="stylesheet" href="{{asset('resources/views/home/static/css/main.css')}}">
    <script src="{{asset('resources/views/home/static/js/jquery.js')}}"></script>
</head>
<body style="overflow: hidden;height: 100%;">
<div class="comm registerBox loginBox">
    <div class="regisWrapper loginWrapper">
        <div class="in2">
            <div class="forgetlogo2"></div>
            <div class="tips-cente tips-center-h2">找回密码</div>
            <form class="form-horizontal forgetForm">
                <div class="form-group clearfix">
                    <label class="col-sm-5 control-label">手机号：</label>
                    <div class="col-sm-4">
                        <input type="number" class="form-control" name="doctor_mobile" id="doctor_mobile">
                        <div class="tips"></div>
                    </div>
                </div>
                <div class="form-group clearfix">
                    <label class="col-sm-5 control-label">身份证号：</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="id_card" id="id_card">
                        <div class="tips"></div>
                    </div>
                </div>
                <div class="form-group clearfix">
                    <label class="col-sm-5 control-label">新密码：</label>
                    <div class="col-sm-4">
                        <input type="password" class="form-control" name="newPassword" id="newPassword">
                        <div class="tips"></div>
                    </div>
                </div>
                <div class="form-group clearfix">
                    <label class="col-sm-5 control-label">确认新密码：</label>
                    <div class="col-sm-4">
                        <input type="password" class="form-control" name="repPassword" id="repPassword">
                        <div class="tips"></div>
                    </div>
                </div>
                <a href="javascript:;" class="tj" onclick="resetPassword()">提交</a>
                <a href="{{url('register')}}" class="wjmm wjmm2">还没有账号？立即注册</a>
            </form>
        </div>

    </div>
</div>
</body>
</html>

<script>

    function resetPassword() {
        var doctor_mobile = $("#doctor_mobile").val();
        var id_card = $("#id_card").val();
        var newPassword = $("#newPassword").val();
        var repPassword = $("#repPassword").val();
        if(doctor_mobile ==''){
            alert('请输入手机号码');
            return false;
        }
        if(id_card ==''){
            alert('请输入身份证号码');
            return false;
        }
        if(newPassword ==''){
            alert('请输入新密码');
            return false;
        }
        if(repPassword ==''){
            alert('请确认输入新密码');
            return false;
        }

        if(newPassword !=repPassword){
            alert('请确认二次输入的密码一致');
            return false;
        }

        $.ajax({
            type: 'post',
            url: '{{url('index/ajax')}}',
            data: {
                'action': 'resetPassword',
                'doctor_mobile': doctor_mobile,
                'id_card': id_card,
                'newPassword': newPassword,
                'repPassword': repPassword,
            },
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            beforeSend: function (XMLHttpRequest) {

            },
            success: function (json) {
                if (json.status == 1) {
                    alert(json.msg);
                    window.location.href="{{url('login')}}";

                } else {
                    alert(json.msg);
                }
            },
            complete: function () {
            },
            error: function () {
                alert("服务器繁忙！");
            }
        });
    }

</script>