@extends('layouts.home')

@section('title','上传素材')

@section('css')
    <link href="{{ asset('resources/views/home/static/css/bootstrap4.0.0.min.css') }}" rel="stylesheet">
    <link href="{{ asset('resources/views/home/static/css/fileinput.css') }}" media="all" rel="stylesheet" type="text/css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" media="all" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('resources/views/home/static/css/theme.css') }}" media="all" rel="stylesheet" type="text/css"/>

@endsection

@section('js')
    <script src="{{asset('resources/views/home/static/js/pintuer.js')}}"></script>
    <script src="{{ asset('resources/views/home/static/js/fileinput.js') }}" type="text/javascript"></script>
    <script src="{{ asset('resources/views/home/static/js/zh.js')}}" type="text/javascript"></script>
    <script src="{{ asset('resources/views/home/static/js/theme.js') }}" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" type="text/javascript"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" type="text/javascript"></script>
@endsection

@section('content')
    <div class="panel admin-panel">
    <div class="panel-head"><strong>上传素材</strong></div>
    <div class="body-content">
        @if(count($errors))
        <p class="toolps" style="text-indent: 2em;color:red">{{$errors->first()}}</p>
        @endif
        <form name="myform" method="post" class="form-horizontal" action="" enctype="multipart/form-data" >
            <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
            <div class="form-group" style="float: none;width: 100%;">
                <label for="material_type_id" class="col-md-4 control-label">素材类型：</label>
                <div class="col-md-6">
                    <select class="form-control" name="material_type_id" id="material_type_id">
                        <option value="">请选择</option>
                        @foreach($materialType as $v)
                        <option value="{{$v->_id}}" @if(old('material_type_id') == $v->_id) selected @endif>{{$v->material_type_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group" style="float: none;width: 100%;">
                <label for="material_name" class="col-md-4 control-label">素材名称：</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" name="material_name" value="{{ old('material_name') }}" id="material_name">
                </div>
            </div>


            <div class="form-group" style="float: none;width: 100%;">
                <label for="attachments" class="col-md-4 control-label">素材数量：</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" name="attachments" value="{{ old('attachments') }}" id="attachments">
                </div>
            </div>
            <div class="form-group" style="float: none;width: 100%;">
            <label for="recommend_id" class="col-md-4 control-label">推荐人手机号：</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" name="recommend_id" value="{{ old('recommend_id') }}" id="recommend_id" placeholder="请输入推荐人手机号">
                </div>
            </div>

            <div class="form-group kv-main" style="width: auto;float: none;margin-left: 2%;">
                <label class="col-md-4 control-label">文件上传：</label>
                <div class="col-md-6 file-loading">
                    <input id="kv-explorer" type="file" multiple name="files[]">
                </div>
            </div>
            <div class="clear"></div>
            <br>
            <div style="padding-left:15px;">
                <button type="submit" class="btn btn-primary">确定</button>
                <button class="btn btn-default">取消</button>
            </div>

        </form>

    </div>
</div>
@endsection

@section('floorjs')

    <script>
        $(document).ready(function () {

            $("#kv-explorer").fileinput({
                theme: 'explorer-fa',
                language: 'zh',
                uploadUrl: '#',
                showRemove:false,
                showUpload: false,
                uploadAsync:false,
                overwriteInitial: true,
                dropZoneEnabled: false
            });
            /*
            $("#test-upload").on('fileloaded', function(event, file, previewId, index) {
            alert('i = ' + index + ', id = ' + previewId + ', file = ' + file.name);
            });
            */
        });
    </script>
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
                    alert("请填写素材数量");
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

@endsection