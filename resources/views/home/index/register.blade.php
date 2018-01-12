<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="_token" content="{{ csrf_token() }}"/>
    <title>素材收集平台-注册</title>
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('resources/views/home/static/css/global.css')}}">
    <link rel="stylesheet" href="{{asset('resources/views/home/static/css/main.css')}}">

    <script src="{{asset('resources/views/home/static/js/jquery.js')}}"></script>
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap-progressbar/0.9.0/bootstrap-progressbar.min.js"></script>
</head>
<body>
<div class="comm registerBox">
    <div class="header">
        <img src="{{ asset('resources/views/home/static/images/front_logo.png') }}" alt="">
        | <span>素材收集平台</span>
    </div>
    <div class="content">
        <div class="step step1">
            <div class="guide">
            </div>
            <div class="control">
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">手机号:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="doctor_mobile" placeholder="请输入手机号">
                        <div class="tips"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">密码:</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" name="password" id="password" placeholder="请输入密码">
                        <div class="tips"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">确认密码:</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" name="repassword" id="repassword" placeholder="再次输入密码">
                        <div class="tips"></div>
                    </div>
                </div>
                <div class=form-group">
                    <div class="ty clearfix col-sm-offset-3">
                        <input type="checkbox" class="l" name="sureCheck" id="sureCheck" checked="checked" value="1">
                        <p class="l">我已经阅读并同意<a href="{{url('agree')}}">《用户协议》</a></p>
                    </div>

                </div>
                <div class="next col-sm-5 col-sm-offset-2">
                    <button class="btn btn-primary btn-next">下一步</button>
                    <a href="{{url('login')}}">我有账号？立即登录</a>
                </div>
            </div>
        </div>
        <div class="clear"></div>

        <div class="step step2">
            <div class="guide">
            </div>
            <div class="control">
                <div class="form-group">
                    <label class="col-sm-3 control-label">真实姓名:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="doctor_name" id="doctor_name" placeholder="请输入真实姓名">
                        <div class="tips"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">身份证号:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="id_card" id="id_card" placeholder="请输入真实身份证件号">
                        <div class="tips"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">地区:</label>
                    <div class="col-sm-9" id="distpicker5">
                        <select class="form-control" id="province10"></select>
                        <select class="form-control" id="city10"></select>
                        <select class="form-control" id="district10"></select>
                        <div class="tips" style="margin-top: 41px"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">医院名称:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control"  name="hospital_name" id="hospital_name" placeholder="请输入医院名称">
                        <div class="tips"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">银行卡号:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="bank_card_no" id="bank_card_no" placeholder="请输入银行卡号">
                        <div class="tips"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">账户支行:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="bank_name" id="bank_name" placeholder="请输入账户支行">
                        <div class="tips"></div>
                    </div>
                </div>
                <div class="next col-sm-5 col-sm-offset-2">
                    <button class="btn btn-primary btn-next">下一步</button>
                </div>
            </div>
        </div>

        <div class="step step3">
            <div class="guide">
            </div>
            <div class="control">
                <p class="control-tips"> * 请下载协议模板，签字后拍照或扫描上传；上传协议后才能付款</p>
                <div class="text-center">
                    <button class="btn btn-primary" id="upload">上传协议</button>
                    <a class="btn btn-primary download" href="{{ url('protocol') }}" style="margin-left:20px;">下载协议模板</a>
                </div>
                <div style="display: none;">
                    <form method="post" action="http://upload.qiniu.com/" enctype="multipart/form-data">
                    <input type="file" name="txt_file" id="file"/>
                    <input name="token" type="hidden" id="token" value="{{ $token }}">
                    <input id="key" name="key" value="{{ uuid() }}">
                    </form>
                </div>
                <div class="file-show">
                    <img src="{{asset('resources/views/home/static/images/file_150_110.png')}}" alt="">
                    <span id="file_name"></span>
                    <div id="progressbar"><div class="progress-label"></div></div>
                </div>
                <div class="next col-sm-5 col-sm-offset-1">
                    <button class="btn btn-primary btn-next">下一步</button>
                    <a href="javascript:void(0);" class="btn-jump">跳过（下次上传）</a>
                </div>
            </div>
        </div>
        <div class="clear"></div>

        <div class="step step4">
            <div class="guide">
            </div>
            <div class="control">
                <p class="control-tips"> * 协议上传成功，将会在两个工作日（每月15号前）内完成审核</p>
                <dl class="text-dl col-sm-5 col-sm-offset-2">
                    <dt>请将纸质协议邮寄至：</dt>
                    <dd>收件人：秦玲</dd>
                    <dd>收件人电话：18963947102</dd>
                    <dd>收件人地址：湖北武汉高新大道666号光谷生物城C2-4栋迈德科技</dd>

                </dl>
                <div class="next col-sm-5 col-sm-offset-1">
                    <button class="btn btn-primary btn-next">下一步</button>
                </div>
            </div>
        </div>
        <div class="clear"></div>

        <div class="step step5">
            <div class="guide">
            </div>
            <div class="control">
                <div class="col-sm-6 col-sm-offset-3 step5-ok">
                    <img src="{{ asset('resources/views/home/static/images/register_ok.jpg') }}" alt="注册成功">
                    <p>注册成功，点击<a href="{{ url('home/userfile/addmaterial') }}"> 上传素材</a></p>
                </div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
        {{--<div class="in">
            <div class="logo"></div>
            <form class="form-horizontal regisForm" style="overflow: visible;">
                <h2></h2>

                <h3 class="gr"></h3>
                <div class="form-group">
                    <label class="col-sm-5 control-label">姓名</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="doctor_name" id="doctor_name" placeholder="请输入真实姓名">
                        <div class="tips"></div>
                    </div>
                    <div class="tips" style="padding-top:7px;color:grey;">请输入真实姓名!</div>
                </div>
                <div class="form-group">
                    <label class="col-sm-5 control-label">身份证件号</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="id_card" id="id_card" placeholder="请输入真实身份证件号">
                        <div class="tips"></div>
                    </div>
                    <div class="tips" style="padding-top:7px;color:grey;">请输入真实身份证件号!</div>
                </div>

                <h4 class="gr"></h4>
                <div class="form-group">
                    <label class="col-sm-5 control-label">推荐人手机号</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="recommend_mobile" id="recommend_mobile" placeholder="请输入手机号" onblur="getRecommendInfo()">
                        <div class="tips"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-5 control-label">推荐人姓名</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="recommend_name" id="recommend_name" placeholder="请输入推荐人姓名">
                        <div class="tips"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-5 control-label">大区</label>
                    <div class="col-sm-3">
                        <select class="form-control" name="big_area_id" id="big_area_id">
                            <option value="all">请选择</option>
                            @foreach($bigarea as $v)
                            <option value="{{$v->_id}}" >{{$v->big_area_name}}</option>
                            @endforeach
                        </select>
                        <div class="tips"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-5 control-label">区域</label>
                    <div class="col-sm-3">
                        <select class="form-control" name="area_id" id="area_id">


                        </select>
                        <div class="tips"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-5 control-label">销售组</label>
                    <div class="col-sm-3">
                        <select class="form-control" id="sales_id">


                        </select>
                        <div class="tips"></div>
                    </div>
                </div>



            </form>
        </div>--}}

</div>
@include('layouts/common')
<script src="{{asset('resources/views/home/static/js/distpicker.data.js')}}"></script>
<script src="{{asset('resources/views/home/static/js/distpicker.js')}}"></script>
<script src="{{asset('resources/views/home/static/js/main.js')}}"></script>
<script>
    $("#distpicker5").distpicker({
        autoSelect: false
    });
</script>
<script src="{{asset('resources/views/home/static/js/login.js')}}"></script>
</body>
</html>
