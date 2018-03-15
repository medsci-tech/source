@extends('layouts.home')

@section('title','上传素材')

@section('css')

    <link href="https://cdn.bootcss.com/bootstrap-select/2.0.0-beta1/css/bootstrap-select.min.css" rel="stylesheet">
    <link href="{{ asset('resources/views/home/static/css/fileinput.css') }}" media="all" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('resources/views/home/static/css/font-awesome.min.css') }}" media="all" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('resources/views/home/static/css/theme.css') }}" media="all" rel="stylesheet" type="text/css"/>

@endsection

@section('js')
    <script src="{{asset('resources/views/home/static/js/pintuer.js')}}"></script>
    <script src="{{asset('resources/views/home/static/js/cos-js-sdk-v5.js')}}"></script>
    <script src="{{ asset('resources/views/home/static/js/fileinput.js') }}" type="text/javascript"></script>
    <script src="{{ asset('resources/views/home/static/js/zh.js')}}" type="text/javascript"></script>
    <script src="{{ asset('resources/views/home/static/js/theme.js') }}" type="text/javascript"></script>
    <script src="{{ asset('resources/views/home/static/js/popper.min.js')}}" type="text/javascript"></script>
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
            {{--<input id="file-selector" type="file">--}}
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
<div class="mask"></div>
<div id="preloader_3"><span>0</span></div>
@endsection

@section('floorjs')

    <script>
        $(document).ready(function () {
            var uploadFiles = '';//上传的文件
            var fileNum = 0;
            var fileSize = 0;

            var Bucket = 'source-1252490301';
            var Region = 'ap-beijing';

// 初始化实例
            var cos = new COS({
                getAuthorization: function (options, callback) {
                    // 异步获取签名
                    $.get('/sign', {
                        method: (options.Method || 'get').toLowerCase(),
                        pathname: '/' + (options.Key || '')
                    }, function (authorization) {
                        callback(authorization);
                    }, 'text');
                }
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $("#kv-explorer").fileinput({
                theme: 'explorer-fa',
                language: 'zh',
                uploadUrl: '/home/userfile/qcloudUpload?uuid={{ $uuid }}',
                showRemove:false,
                showUpload: false,
                uploadAsync:true,
                overwriteInitial: false,
                maxFileSize:81920,
                enctype:'multipart/form-data',
                dropZoneEnabled: false,
                layoutTemplates:{
                    actionDelete:'',//隐藏删除按钮
                }
            }).on("filebatchselected", function(event, files) {
                //选择文件后处理事件
//                console.log(files)
                uploadFiles = files;
                //计算文件的中大小
                fileSize = 0;
                uploadFiles.forEach(function (ele) {
                    fileSize += ele.size;
                })
//                console.log(fileSize);
            })/*.on("fileselect", function(event, numFiles, label) {

                console.log(event,numFiles,label)
                fileNum += numFiles;//当前页上传文件的总数
            })*/.on('fileremoved', function(event, id, index) {
//                console.log(event,'id = ' + id + ', index = ' + index);
            })/*.on('change', function(event) {

//                console.log(event);

            }).on('filedeleted', function(event, id) {

                console.log('Uploaded thumbnail successfully removed',id);

            })*/;



            $('form').on('submit',function(e){
                e.preventDefault();

                var length = uploadFiles.length;

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
//                $("#kv-explorer").fileinput("upload");
                $('.mask').toggle();
                $('#preloader_3').toggle();
                // 分片上传文件
                var uploadSize = 0;
                var prevSize = 0;
                var percent = 0;
                var timer;
                var fileInfo = [];
                uploadFiles.forEach(function (file,index) {
                    var date = new Date();
                    var now = date.getTime() + '-';
                    fileInfo.push( {fileName:file.name,key:now+file.name});
                    cos.sliceUploadFile({
                        Bucket: Bucket,
                        Region: Region,
                        Key: now+file.name,
                        Body: file,
                        onProgress: function (progressData) {
//                            console.log(JSON.stringify(progressData));
                            uploadSize = prevSize + progressData.loaded;//已上传的文件大小
                            var percent_up = parseInt(uploadSize/fileSize*100);
                            timer = setInterval(function () {
                                if(percent< percent_up){
                                    $('#preloader_3 span').html(percent++);
                                }else{
                                    clearInterval(timer);
                                }
                            },30)
                            if(progressData.percent == 1){
                                prevSize+= progressData.total;
                            }

                        }
                    }, function (err, data) {
                        console.log(err, data);
                        if(err){
                            modelAlert('文件上传失败');
                            return ;
                        }else{
                            if(index+1>=length ){
                                formData += '&file='+ JSON.stringify(fileInfo);
                                $.ajax({
                                    type:'post',
                                    data:formData,
//                    processData: false,
//                    contentType: false,
                                    success:function(res){
//                                        console.log(res);
                                        if(res.code==200){
                                            location = '/home/userfile/index';
                                        }else{
                                            modelAlert(res.msg);
                                        }
                                    }
                                })
                                $('.mask').toggle();
                                $('#preloader_3').toggle();
                            }

                        }

                    });
                })


                /*$("#kv-explorer").on("fileuploaded", function (event, data, previewId, index) {
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
                    modelAlert('文件上传失败');
                });*/

//                var formData = new FormData(this);

            })

            $('#recommend').on('keyup','input',function(){
                var val = $(this).val();
                $.post('/home/userfile/ajax',{val:val,action:'getRecommend'},function(res){
//                    console.log(res);
                    var txt='';
                    for(var i = 0;i <res.length;i++){
                        txt += '<option value="'+(res[i].phone || res[i].recommend_mobile)+'">' +( res[i].name || res[i].recommend_name) + (res[i].phone || res[i].recommend_mobile) +'</option>';
                    }
//                    console.log(txt);//
                    $('#recommend_id').html(txt);
                    $('.selectpicker').selectpicker('refresh');
                });
            })
        });
    </script>

@endsection