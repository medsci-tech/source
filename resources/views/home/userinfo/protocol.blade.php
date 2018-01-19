@extends('layouts.home')

@section('title','上传协议')

@section('content')
    <div class="panel admin-panel">
        <div class="panel-head"><strong>上传协议</strong></div>
        <div class="body-content">
            <div class="protocol protocol1">
                <div class="protocol-guide">
                </div>
                <div class="protocol-content">
                    <p> * 请下载协议模板，签字后拍照或扫描上传；上传协议后才能付款</p>
                    <div class="protocol-text text-center">
                        <button class="btn btn-primary" id="upload">上传协议</button>
                        <button class="btn btn-primary download" style="margin-left:20px;">下载协议模板</button>
                    </div>
                    <div style="display: none;">
                        <form enctype="multipart/form-data">
                            <input type="file" id="file"/>
                            <input type="hidden" id="token" value="{{ $token }}">
                            <input id="key" value="">
                        </form>
                    </div>
                    <div class="file-show">
                        <img src="{{asset('resources/views/home/static/images/file_150_110.png')}}" alt="">
                        <span id="file_name"></span>
                        <div id="progressbar"><div class="progress-label"></div></div>
                    </div>
                    <div class="protocol-next">
                        <button class="btn btn-primary btn-next">下一步</button>
                    </div>
                </div>
            </div>
            <div class="protocol protocol2">
                <div class="protocol-content">
                    <div class="protocol-ok">
                        <img src="{{ asset('resources/views/home/static/images/register_ok.jpg') }}" alt="注册成功">
                        <p>协议上传成功，等待审核通过</p>
                    </div>
                    <div class="protocol-address">
                        <p class="protocol-address-title">* 请将纸质协议邮寄至：</p>
                        <p class="protocol-address-info">  收件人：秦玲</p>
                        <p class="protocol-address-info">  收件人电话：18963947102</p>
                        <p class="protocol-address-info">  收件人地址：湖北武汉高新大道666号光谷生物城C2-4栋迈德科技</p>

                    </div>
                    <div class="protocol-next">
                        <a class="btn btn-primary btn-next" href="{{ url('home/userinfo/index') }}">确定</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('floorjs')
    <script>
        $(function(){
            var data = {};
            $('#upload').click(function(){
                $('#file').click();
            })

            $('#file').on('change',function(){
                var filename = $(this).val();
                var pos1 = filename.lastIndexOf('/');
                var pos2 = filename.lastIndexOf('\\');
                var pos = Math.max(pos1, pos2);
                if (pos > 0) {
                    filename =  filename.substring(pos + 1);
                }
                $('#file_name').text(filename).parent().show();
                // alert(filename);
            })

            //七牛云上传文件
            var Qiniu_UploadUrl = "http://up-z2.qiniu.com";
            $(".protocol1 .btn-next").click(function() {
                var filename = $('#file_name').text();
                if(!filename){
                    modelAlert('请选择要上传的协议')
                }
                //普通上传
                var Qiniu_upload = function(f, token, key) {
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', Qiniu_UploadUrl, true);
                    var formData;
                    formData = new FormData();
                    if (key !== null && key !== undefined) formData.append('key', key);
                    formData.append('token', token);
                    formData.append('file', f);
                    xhr.onreadystatechange = function(response) {
                        if (xhr.readyState == 4 && xhr.status == 200 && xhr.responseText != "") {
                            var blkRet = JSON.parse(xhr.responseText);
//                            console && console.log(blkRet);
                            //上传成功，跳转下一页
                            data.file = blkRet.key;
                            data.filename = filename;
                            addDoctor(data);
                        }
                    };
                    xhr.send(formData);
                };
                var token = $("#token").val();
                var date = new Date();
                var key = date.getTime() + $("#file")[0].files[0].name;
                if ($("#file")[0].files.length > 0 && token != "") {
                    Qiniu_upload($("#file")[0].files[0], token, key);
                } else {
                    modelAlert("请选择要上传的文件");
                }
            })

            function addDoctor(data) {
                $.ajax({
                    type: 'post',
                    url: '/home/userinfo/ajax',
                    data: {
                        'action': 'addProtocol',
                        'doc_data':data,
                    },
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },

                    success: function (json) {
                        if (json.status == 1) {
//                            modelAlert(json.msg);
                            $('.protocol1').hide();
                            $('.protocol2').show();
                        } else {
                            modelAlert(json.msg);
                        }
                    },
                    complete: function () {
                    },
                    error: function () {
                        modelAlert("服务器繁忙！");
                    }
                });
            }
        })

    </script>
@endsection
