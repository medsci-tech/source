<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta name="renderer" content="webkit">
    <title></title>
    <link rel="stylesheet" href="{{asset('resources/views/admin/static/css/pintuer.css')}}">
    <link rel="stylesheet" href="{{asset('resources/views/admin/static/css/admin.css')}}">
    <link rel="stylesheet" href="{{asset('resources/views/admin/static/css/main.css')}}">
    <script src="{{asset('resources/views/admin/static/js/jquery.js')}}"></script>
    <script src="{{asset('resources/views/admin/static/js/pintuer.js')}}"></script>
</head>
<body>
<div class="panel admin-panel">
    <div class="panel-head"><strong><span class="icon-key"></span>上传文件</strong></div>
    <div class="body-content">
        <form name="myform" method="post" class="form-x" action="" enctype="multipart/form-data" onsubmit="return check(this)">
            {{csrf_field()}}
            <div class="form-group">
                <div class="label">
                    <label>文件名称：</label>
                </div>

                <div class="field">
                    <input type="text" class="input" name="file_name" value=""/>
                    <div class="tips"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="label">
                    <label>文件大小：</label>
                </div>
                <div class="field">
                    <input type="text" class="input" name="file_weight" value=""/>(如:10M)
                    <div class="tips"></div>
                </div>
            </div>
            <div class="form-group w100">
                <div class="label">
                    <label>上传工具：</label>
                </div>
                <div class="field">
                    <a href="javascript:;" class="button bg-main icon-upload">上传<input class="" type="file" name="Filedata" ></a>
                </div>
            </div>
            <div class="form-group tool-btns w100">
                <button class="button bg-main icon-search" type="submit">提交</button>
            </div>
        </form>
    </div>
</div>
<!--删除数据弹框开始-->
@if($msg)
<div style="width: 300px;display:block;" class="MsgBox clearfix" id="sureBox">
    <div class="top">
        <div class="title" class="MsgTitle">提示</div>
    </div>
    <div class="body l">
        <p>{{$msg}}</p>
    </div>
    <div class="bottom l" class="MsgBottom" style="height: 45px;">
        <div class="btn MsgBtns">
            <div class="height"></div>
            <input type="button" class="btn" value="确认" id="sure">
        </div>
    </div>
</div>
@endif
<!--删除数据结束-->
</body>
</html>

<script>
    $("#sure").click(function(){
        $("#sureBox").css('display','none');
    })

    function check(form) {

        if(form.file_name.value=='') {
            alert("请输入文件名称!");
            return false;
        }
        if(form.file_weight.value=='') {
            alert("请输入文件大小!");
            return false;
        }
        if(form.Filedata.value=='') {
            alert("请上传文件!");
            return false;
        }

        document.myform.submit();
    }
</script>