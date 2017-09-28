<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta name="renderer" content="webkit">
    <meta name="_token" content="{{ csrf_token() }}"/>
    <title>上传素材</title>
    <link rel="stylesheet" href="{{asset('resources/views/home/static/css/pintuer.css')}}">
    <link rel="stylesheet" href="{{asset('resources/views/home/static/css/admin.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('resources/views/home/static/css/jquery-ui.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('resources/views/home/static/css/main.css')}}">
    <script src="{{asset('resources/views/home/static/js/jquery.js')}}"></script>
    <script src="{{asset('resources/views/home/static/js/pintuer.js')}}"></script>
</head>
<body onunload="checkLeave()">

<div class="panel admin-panel">
    <div class="panel-head"><strong>上传素材</strong></div>
    <div class="body-content">
        @if($msg)
        <p class="toolps" style="text-indent: 2em;color:#0ae">{{$msg}}</p>
        @endif
        <form name="myform" method="post" class="form-x sucai" action="" enctype="multipart/form-data" >
{{--            <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />--}}
            <div class="form-group">
                <div class="label">
                    <label>素材类型：</label>
                </div>
                <div class="field">
                    <select class="input" name="material_type_id" id="material_type_id">
                        <option value="all">请选择</option>
                        @foreach($materialType as $v)
                        <option value="{{$v->_id}}">{{$v->material_type_name}}</option>
                            @endforeach
                    </select>
                    <div class="tips"></div>
                </div>
            </div>

            <div class="form-group">
                <div class="label">
                    <label>素材名称：</label>
                </div>
                <div class="field">
                    <input type="text" class="input" name="material_name" value="" id="material_name"/>
                    <div class="tips"></div>
                </div>
            </div>


            <div class="form-group">
                <div class="label">
                    <label>素材数量：</label>
                </div>
                <div class="field">
                    {{--<div class="field">--}}
                        <input type="text" class="input" name="attachments" value="" id="attachments" />
                        <div class="tips"></div>
                </div>
                    {{--<select class="input" name="attachments" id="attachments">--}}
                        {{--<option value="all">请选择</option>--}}
                        {{--<option value="1">1</option>--}}
                        {{--<option value="2">2</option>--}}
                        {{--<option value="3">3</option>--}}
                        {{--<option value="4">4</option>--}}
                        {{--<option value="5">5</option>--}}
                        {{--<option value="6">6</option>--}}
                        {{--<option value="7">7</option>--}}
                        {{--<option value="8">8</option>--}}

                    {{--</select>--}}
                    {{--<div class="tips"></div>--}}
                {{--</div>--}}
            </div>
            <div class="form-group mr30" style="height:45px;">
                <div class="label">
                    <label>推荐人：</label>
                </div>
                <div class="field">
                    <select class="input" name="recommend_id" id="recommend_id">
                        <option value="all">请选择</option>
                        @foreach($doctorrecommend as $v)
                        <option value="{{$v->recommend_id}}">{{$v->recommend_name}}</option>
                            @endforeach
                    </select>
                    <div class="tips"></div>
                </div>
            </div>
            <input type="hidden" name="uploadcode" id="uploadcode" value="{{$uuid}}"/>
            <div class="form-group" style="width:36%;">
            <a href="javascript:;" class="button bg-main upload l" id="openAlert">上传附件</a>
                <span style="margin-left:10px;color:red;">如果有多个文件请使用打包的方式上传文件!</span>
            </div>
            {{--<a href="javascript:;" class="button bg-main upload l">上传附件<input class="" type="file" id="material" name="fileData"></a>--}}
            {{--<a href="javascript:;" class="button bg-main" style="margin-left:10px;" id="openAlert">打开</a>--}}
            <div class="form-group w100">
                {{--<div class="field">--}}
                    {{--<button class="button bg-main">提交</button>--}}
                {{--</div>--}}
            </div>
            <a class="button bg-main" style="position: fixed;bottom:0px;left:50%;width:200px;height: 40px;line-height: 40px;border:none;margin-left: -100px;cursor:pointer;display:none;" id="openAlert1">关闭</a>
        </form>
            <iframe src="https://box.lenovo.com/uploadFrame/index.html?sessid=r3kv8sojik6uairfcbvqhqnce6&url=encodeURI(https://box.lenovo.com)&dir=/test&uid=512&language=zh&callbackurl=encodeURI(CALLBACKURL)&Command=CALLBACKFUNCTION" id="iframeshow" style="display:none;width: 710px;height: 368px;position: absolute;top: 55%;left: 50%;margin-top: -184px;margin-left:-350px;border:1px solid #3b93ff" ></iframe>
    </div>
</div>
</body>
</html>

<script type="text/javascript">
//    function check(form) {

//        if(form.material_name.value=='') {
//            alert("请输入素材名称!");
//            return false;
//        }
//        if(form.material.value=='') {
//            alert("请输上传素材!");
//            return false;
//        }

//        document.myform.submit();
//    }


    $(function() {
        var flag=false;
        $("#openAlert").click(function() {
            var obj =$(this);
            if(!flag) {

                var material_name =$('#material_name').val();
                var material_type_id =$('#material_type_id').val();
                var attachments =$('#attachments').val();
                var recommend_id =$('#recommend_id').val();
                var uuid =$('#uploadcode').val();
                if(material_type_id=='all') {
                    alert("请选择素材类型!");
                    return false;
                }
                if(material_name=='') {
                    alert("请输入素材名称!");
                    return false;
                }
                if(attachments=='') {
                    alert("请选择素材数量");
                    return false;
                }
                if(recommend_id=='all') {
                    alert("请选择推荐人!");
                    return false;
                }
                $("#material_name").attr("disabled","disabled");
                $("#material_type_id").attr("disabled","disabled");
                $("#attachments").attr("disabled","disabled");
                $("#recommend_id").attr("disabled","disabled");
                $.ajax({
                    type: 'post',
                    url: '{{url('home/userfile/ajax')}}',
                    data: {'action': 'lenovo','material_name': material_name,'material_type_id': material_type_id,'attachments': attachments,'recommend_id': recommend_id,'uuid': uuid},
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    beforeSend: function(XMLHttpRequest) {

                    },
                    success: function(json) {
                        obj.text('关闭');
                        json.data += "&callbackurl="+encodeURI(json.callBackUrl)+"&Command="+json.command;
//                        console.log(json.data);
                        $("#iframeshow").attr('src',json.data);

                        $("#iframeshow").show();
                        $("#openAlert1").show();
                        flag=true;
                    },
                    complete: function() {

                    },
                    error: function() {
                        alert("服务器繁忙！");
                    }
                });

            } else {
                obj.text('上传素材');
                $("#material_name").removeAttr("disabled");
                $("#material_type_id").removeAttr("disabled");
                $("#attachments").removeAttr("disabled");
                $("#recommend_id").removeAttr("disabled");
                $("#iframeshow").hide();
                $("#openAlert1").hide();
                flag=false;
            }

        });

        $("#openAlert1").click(function(){
            $("#openAlert").text('上传素材');
            $("#material_name").removeAttr("disabled");
            $("#material_type_id").removeAttr("disabled");
            $("#attachments").removeAttr("disabled");
            $("#recommend_id").removeAttr("disabled");
            $("#iframeshow").hide();
            $("#openAlert1").hide();
            flag=false;
        });



    });


//$(window).bind('beforeunload',function(){
//    alert('您输入的内容尚未保存，确定离开此页面吗？');
//});
//window.onbeforeunload = function(){
//    return "您的文章尚未保存！啊啊啊啊啊啊啊啊啊啊啊啊";
//}
//$(window).unload(function(){
//    alert("Goodbye!");
//});
//$(window).bind('beforeunload', function() {
//    return '您输入的内容尚未保存，确定离开此页面吗？';
//});
{{--//$(window).bind("beforeunload", function(){--}}
{{--//    return "确定？类目下内容为空,离开后将会自动删除当前类目";--}}

    {{--$.ajax({--}}
        {{--type: 'post',--}}
        {{--url: '{{url('home/userfile/ajax')}}',--}}
        {{--data: {'action': 'aaaaa'},--}}
        {{--dataType: 'json',--}}
        {{--headers: {--}}
            {{--'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')--}}
        {{--},--}}
        {{--beforeSend: function(XMLHttpRequest) {--}}

        {{--},--}}
        {{--success: function(json) {--}}

        {{--},--}}
        {{--complete: function() {--}}

        {{--},--}}
        {{--error: function() {--}}
            {{--alert("服务器繁忙！");--}}
        {{--}--}}
    {{--});--}}
{{--//});--}}

//$(window).unload(function(){
//    alert("Goodbye!");
//});

//window.onbeforeunload = function(){return 'aa';}

//window.onbeforeunload=function (){
//    alert("===onbeforeunload===");
//    if(event.clientX>document.body.clientWidth && event.clientY < 0 || event.altKey){
//        alert("你关闭了浏览器");
//    }else{
//        alert("你正在刷新页面");
//    }
//}
</script>

<script>
//    window.onload = function() {
//        alert('你好，欢迎光临!');//各浏览器均正常弹出
//        return true;
//    }

//window.onbeforeunload=function (){
//    alert("===onbeforeunload===");
//    if(event.clientX>document.body.clientWidth && event.clientY < 0 || event.altKey){
//        alert("你关闭了浏览器");
//    }else{
//        alert("你正在刷新页面");
//    }
//}

//$(window).bind("beforeunload", function(){
//    return "确定？类目下内容为空,离开后将会自动删除当前类目";

{{--$(window).bind("beforeunload", function(){--}}
    {{--return "确定？类目下内容为空,离开后将会自动删除当前类目";--}}
{{--alert(1)--}}
{{--$.ajax({--}}
    {{--type: 'post',--}}
    {{--url: '{{url('home/userfile/ajax')}}',--}}
    {{--data: {'action': 'aaaaa'},--}}
    {{--dataType: 'json',--}}
    {{--headers: {--}}
        {{--'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')--}}
    {{--},--}}
    {{--beforeSend: function(XMLHttpRequest) {--}}

    {{--},--}}
    {{--success: function(json) {--}}

    {{--},--}}
    {{--complete: function() {--}}

    {{--},--}}
    {{--error: function() {--}}
        {{--alert("服务器繁忙！");--}}
    {{--}--}}
{{--});--}}
{{--});--}}

//        window.onbeforeunload = function(event) {
//    alert(2);
//    return confirm("您输入的内容尚未保存，确定离开此页面吗？");
//    alert(3);
//}
//window.onbeforeunload = function()
//{
//    setTimeout(onunloadcancel, 10);
//    alert(111);
//    return "真的离开?";
//}
//
//window.onunloadcancel = function()
//{
//    alert("取消离开");
//}
//
//window.onunload = function()
//{
//    alert("离开!");
//}
//window.onunload = function()
//{
//    alert("离开1111!");
//}
//function checkLeave(){
//    event.returnValue="确定离开当前页面吗？";
//}
//window.onbeforeunload = function()
//{
//    alert(1);
//    return confirm("exit?");
//}
//window.onbeforeunload = function (e) {
//    return (e || window.event).returnValue = '有信息未保存，确认离开？！';
//}
</script>