@extends('layouts.home')

@section('title','素材管理')

@section('content')
<div class="panel admin-panel">
    <div class="panel-head"><strong>个人信息</strong></div>
    <div class="body-content">
        <form method="post" class="form-x formp personInfoForm" action="">
            <div class="form-group clearfix">
                <div class="label">
                    <label><span>*</span>原始密码：</label>
                </div>
                <div class="field">
                    <input type="text" class="input" name="oldPassword"  id="oldPassword" value=""/>
                    <div class="tips"></div>
                </div>
            </div>
            <div class="form-group clearfix">
                <div class="label">
                    <label><span>*</span>新密码：</label>
                </div>
                <div class="field">
                    <input type="password" class="input" name="newPassword" id="newPassword" value=""/>
                    <div class="tips"></div>
                </div>
            </div>
            <div class="form-group clearfix">
                <div class="label">
                    <label><span>*</span>确认新密码：</label>
                </div>
                <div class="field">
                    <input type="password" class="input" name="repPassword" id="repPassword" value=""/>
                    <div class="tips"></div>
                </div>
            </div>
            <div class="form-group w100">
                <div class="field">
                    <a class="button bg-main"  onclick ="modifyPassword()" style="margin-left: 25%;">保存</a>
                </div>
            </div>
        </form>

    </div>
</div>
@endsection

@section('floorjs')
    <script>

    function modifyPassword() {
        var oldPassword = $("#oldPassword").val();
        var newPassword = $("#newPassword").val();
        var repPassword = $("#repPassword").val();
//        $("#oldPassword").next().text('');
//        $("#newPassword").next().text('');
//        $("#repPassword").next().text('');
        if(oldPassword ==''){
//            $("#oldPassword").next().text('请输入原密码');
//            $("#oldPassword")[0].focus();
            alert('请输入原密码');
            return false;
        }
        if(newPassword ==''){
//            $("#newPassword").next().text('请输入新密码');
//            $("#newPassword")[0].focus();
            alert('请输入新密码');
            return false;
        }

        if(repPassword ==''){
//            $("#repPassword").next().text('请确认输入新密码');
//            $("#repPassword")[0].focus();
            alert('请确认输入新密码');
            return false;
        }

        if(newPassword !=repPassword){
//            $("#repPassword").next().text('请确认二次输入的密码一致');
//            $("#repPassword")[0].focus();
            alert('请确认二次输入的密码一致');
            return false;
        }

        $.ajax({
            type: 'post',
            url: '{{url('home/userinfo/ajax')}}',
            data: {
                'action': 'modifyPassword',
                'oldPassword': oldPassword,
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
                    alert('修改成功');
                    window.location.href="{{url('home/userfile/index')}}";

                } else {
                    alert('修改失败');
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
@endsection