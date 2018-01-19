@extends('layouts.home')

@section('title','上传素材')

@section('css')

    <link href="https://cdn.bootcss.com/bootstrap-select/2.0.0-beta1/css/bootstrap-select.min.css" rel="stylesheet">
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
    <script src="https://cdn.bootcss.com/bootstrap-select/2.0.0-beta1/js/bootstrap-select.min.js"></script>
@endsection

@section('content')
    <div class="panel admin-panel">
    <div class="panel-head"><strong>上传素材</strong></div>
    <div style="padding-top:20px; ">
        <form method="post" class="form-horizontal" id="form" action="" enctype="multipart/form-data" role="form">
            <input type="hidden" name="uuid" value="{{ $uuid }}" />
            <div class="form-group" id="recommend">
                <label for="recommend_id" class="col-md-1 control-label">推荐人：</label>
                <div class="col-md-6">
                    {{--<input type="text" class="form-control" name="recommend_id" value="{{ old('recommend_id') }}" id="recommend_id" placeholder="请输入推荐人手机号">--}}
                    <select id="recommend_id" name="recommend" class="selectpicker show-tick form-control" data-live-search="true">
                        <option value="">请输入推荐人手机号</option>
                       {{-- @foreach($vol as $v)
                            <option value="{{ $v->phone }}">{{ $v->name.'('.$v->phone.')' }}</option>
                        @endforeach--}}
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="material_type_id" class="col-md-1 control-label">素材类型：</label>
                <div class="col-md-6">
                    <select class="form-control" name="material_type_id" id="material_type_id">
                        <option value="">请选择</option>
                        @foreach($materialType as $v)
                        <option value="{{$v->_id}}" @if(old('material_type_id') == $v->_id) selected @endif>{{$v->material_type_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="material_name" class="col-md-1 control-label">素材名称：</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" name="material_name" value="{{ old('material_name') }}" id="material_name">
                </div>
            </div>

            {{--<div class="form-group">
                <label for="attachments" class="col-md-1 control-label">素材数量：</label>
                <div class="col-md-2">
                    <input type="number" class="form-control" name="attachments" value="{{ old('attachments') }}" id="attachments">
                </div>
            </div>--}}
            <input type="hidden" name="attachments" id="attachments">

            <div class="form-group kv-main">
                <label class="col-md-1 control-label">文件上传：</label>
                <div class="col-md-6 file-loading">
                    <input id="kv-explorer" type="file" multiple name="files[]">
                </div>
            </div>
            <div class="clear"></div>
            <br>
            <div class="form-group">
                <div class="col-md-offset-1">
                    <button type="submit" class="btn btn-primary">确定</button>
                    <button class="btn btn-default">取消</button>
                </div>
            </div>

        </form>

    </div>
</div>

@endsection

@section('floorjs')

    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $("#kv-explorer").fileinput({
                theme: 'explorer-fa',
                language: 'zh',
                uploadUrl: '/home/userfile/upload?uuid={{ $uuid }}',
                showRemove:false,
                showUpload: false,
                uploadAsync:true,
//                overwriteInitial: true,
                maxFileSize:81920,
                enctype:'multipart/form-data',
                dropZoneEnabled: false
            });
            /*
            $("#test-upload").on('fileloaded', function(event, file, previewId, index) {
            alert('i = ' + index + ', id = ' + previewId + ', file = ' + file.name);
            });
            */
            $('#recommend').on('keyup','input',function(){
                var val = $(this).val();
                $.post('/home/userfile/ajax',{val:val,action:'getRecommend'},function(res){
                    var txt='';
                    for(var i = 0;i <res.length;i++){
                        txt += '<option value="'+res[i].phone+'">' + res[i].name + res[i].phone +'</option>';
                    }
//                    console.log(txt);//
                    $('#recommend_id').html(txt);
                    $('.selectpicker').selectpicker('refresh');
                });
            })

            $('form').on('submit',function(e){
                e.preventDefault();
                var length = $('.kv-preview-thumb').length;
                /*if($('#recommend_id').val()==''){
                    modelAlert('请选择推荐人');
                    return false;
                }*/

                if($('[name="material_type_id"]').val()==''){
                    modelAlert('请选择素材类型');
                    return false;
                }
                if($('[name="material_name"]').val()==''){
                    modelAlert('请输入素材名称');
                    return false;
                }
                if(!length){
                    modelAlert('请选择要上传的文件');
                    return false;
                }

                $('#attachments').val(length);
                var formData = $(this).serialize();
                //上传文件
                $("#kv-explorer").fileinput("upload");
                $("#kv-explorer").on("fileuploaded", function (event, data, previewId, index) {
                    if(length <= index +1){
                        $.ajax({
                            type:'post',
                            data:formData,
//                    processData: false,
//                    contentType: false,
                            success:function(res){
                                if(res.code==200){
                                    location = '/home/userfile/index';
                                }else{
                                    modelAlert(res.msg);
                                }
                            }
                        })
                    }

                });
                //异步上传出错
                $("#kv-explorer").on("fileuploaderror", function (event, data, msg) {
//                    console.log(event);
//                    console.log(data);
//                    console.log(msg);
                    modelAlert('文件大小不能超过80M');
                });

//                var formData = new FormData(this);

            })


        });
    </script>

@endsection