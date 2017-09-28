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
</head>
<body>
<div class="comm registerBox">
    <div class="regisWrapper">
        <div class="in">
            <div class="logo"></div>
            <form class="form-horizontal regisForm" style="overflow: visible;">
{{--                {{csrf_field()}}--}}
                <h2></h2>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-5 control-label">手机号</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="doctor_mobile" placeholder="请输入手机号">
                        <div class="tips"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-5 control-label">密码</label>
                    <div class="col-sm-3">
                        <input type="password" class="form-control" name="password" id="password" placeholder="请输入密码">
                        <div class="tips"></div>
                    </div>
                </div>
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
                <div class="form-group">
                    <label class="col-sm-5 control-label">地区</label>
                    <div class="col-sm-3" id="distpicker5" style="width:38%;">
                        <select class="form-control" id="province10"></select>
                        <select class="form-control" id="city10"></select>
                        <select class="form-control" id="district10"></select>
                        <div class="tips" style="margin-top: 41px"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-5 control-label">医院名称</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control"  name="hospital_name" id="hospital_name" placeholder="请输入医院名称">
                        <div class="tips"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-5 control-label">银行卡号</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="bank_card_no" id="bank_card_no" placeholder="请输入银行卡号">
                        <div class="tips"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-5 control-label">账户支行</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="bank_name" id="bank_name" placeholder="请输入账户支行">
                        <div class="tips"></div>
                    </div>
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
                            {{--<option value="all">请选择</option>--}}

                        </select>
                        <div class="tips"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-5 control-label">销售组</label>
                    <div class="col-sm-3">
                        <select class="form-control" id="sales_id">
                            {{--<option value="all">请选择</option>--}}

                        </select>
                        <div class="tips"></div>
                    </div>
                </div>
                {{--<div class="form-group">--}}
                    {{--<label class="col-sm-5 control-label">推荐人身份证号</label>--}}
                    {{--<div class="col-sm-3">--}}
                        {{--<input type="text" class="form-control" name="recommend_id_card" id="recommend_id_card" placeholder="请输入推荐人身份证号">--}}
                        {{--<div class="tips"></div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                <div class=form-group">
                    <div class="ty clearfix">
                        <input type="checkbox" class="l" name="sureCheck" id="sureCheck" checked="checked" value="1">
                        <p class="l">我已经阅读并同意<a href="{{url('agree')}}">《用户协议》</a></p>
                    </div>

                </div>
                <a href="javascript:;" onclick="addDoctor()" class="zhuce"></a>
                <a href="{{url('login')}}" class="wjmm wjmm2" style="margin-left:500px;">我有账号？立即登录</a>
            </form>
        </div>
    </div>
</div>
<script src="{{asset('resources/views/home/static/js/distpicker.data.js')}}"></script>
<script src="{{asset('resources/views/home/static/js/distpicker.js')}}"></script>
<script src="{{asset('resources/views/home/static/js/main.js')}}"></script>
<script>
    $("#distpicker5").distpicker({
        autoSelect: false
    });
</script>
</body>
</html>


<script>

    function addDoctor() {
        var doctor_mobile = $("#doctor_mobile").val();
        var password = $("#password").val();
        var doctor_name = $("#doctor_name").val();
        var id_card = $("#id_card").val();
        var province10 = $("#province10").val();
        var city10 = $("#city10").val();
        var district10 = $("#district10").val();

        var hospital_name = $("#hospital_name").val();
        var bank_card_no = $("#bank_card_no").val();
        var bank_name = $("#bank_name").val();

        var recommend_mobile = $("#recommend_mobile").val();
        var recommend_name = $("#recommend_name").val();
        var big_area_id = $("#big_area_id").val();
        var area_id = $("#area_id").val();
        var sales_id = $("#sales_id").val();
        var recommend_id_card = $("#recommend_id_card").val();
        var sureCheck =$("#sureCheck").val();
        if(doctor_mobile ==''){
//            $("#doctor_mobile").next().text('请输入手机号!');
            alert('请输入手机号!');
            $("#doctor_mobile")[0].focus();
            return false;
        }
        if(doctor_mobile.length != 11){
//            $("#doctor_mobile").next().text('请输入11位手机号!');
            alert('请输入11位手机号!');
            $("#doctor_mobile")[0].focus();
            return false;
        }
        if(password ==''){
//            $("#password").next().text('请输入密码!');
            alert('请输入密码!');
            $("#password")[0].focus();
            return false;
        }
        if(password.length <6){
//            $("#password").next().text('请输入6位数以上密码!');
            alert('请输入6位数以上密码!');
            $("#password")[0].focus();
            return false;
        }
        if(doctor_name ==''){
//            $("#doctor_name").next().text('请输入姓名!');
            alert('请输入姓名!');
            $("#doctor_name")[0].focus();
            return false;
        }
        if(id_card ==''){
//            $("#id_card").next().text('请输入身份证件号!');
            alert('请输入身份证件号!');
            $("#id_card")[0].focus();
            return false;
        }

//        if(id_card.length !=18){
//            $("#id_card").next().text('请输入18位身份证号码!');
//            $("#id_card")[0].focus();
//            return false;
//        }
        if(province10 ==''){
//            $("#province10").next().text('请选择省!');
            alert('请选择省!');
            $("#province10")[0].focus();
            return false;
        }if(city10 ==''){
//            $("#city10").next().text('请选择市!');
            alert('请选择市!');
            $("#city10")[0].focus();
            return false;
        }
        if(district10 ==''){
//            $("#district10").next().text('请选择地区');
//            $("#district10")[0].focus();
//            return false;
        }
        if(hospital_name ==''){
//            $("#hospital_name").next().text('请输入医院名称!');
            alert('请输入医院名称!');
            $("#hospital_name")[0].focus();
            return false;
        }
        if(bank_card_no ==''){
//            $("#bank_card_no").next().text('请输入银行卡号!');
            alert('请输入银行卡号!');
            $("#bank_card_no")[0].focus();
            return false;
        }
        if(bank_name ==''){
//            $("#bank_name").next().text('请输入账户支行!');
            alert('请输入账户支行!');
            $("#bank_name")[0].focus();
            return false;
        }
        if(recommend_mobile ==''){
//            $("#recommend_mobile").next().text('请输入推荐人手机号!');
            alert('请输入推荐人手机号!');
//            $("#recommend_mobile")[0].focus();
            return false;
        }
        if(recommend_name ==''){
//            $("#recommend_name").next().text('请输入推荐人姓名!');
            alert('请输入推荐人姓名!');
            $("#recommend_name")[0].focus();
            return false;
        }
        if(big_area_id =='' || big_area_id =='all'){
//            $("#big_area_id").next().text('请选择大区!');
            alert('请选择大区!');
            $("#big_area_id")[0].focus();
            return false;
        }
        if(area_id =='' || area_id =='all'){
//            $("#area_id").next().text('请选择区域!');
            alert('请选择区域!');
//            $("#area_id")[0].focus();
            return false;
        }
        if(sales_id =='' || sales_id =='all'){
//            $("#sales_id").next().text('请选择销售组!');
            alert('请选择销售组!');
//            $("#sales_id")[0].focus();
            return false;
        }
//        if(recommend_id_card ==''){
//            $("#recommend_id_card").next().text('请输入推荐人省份证号!');
//            $("#recommend_id_card")[0].focus();
//            return false;
//        }
        if(!sureCheck){
            alert('请确认同意协议');
            return false;
        }

        var province_id = $("#province10").find("option:selected").attr('data-code');
        var city_id = $("#city10").find("option:selected").attr('data-code');
        var region_id = $("#district10").find("option:selected").attr('data-code');
        $.ajax({
            type: 'post',
            url: '{{url('index/ajax')}}',
            data: {
                'action': 'addDoctor',
                'doctor_mobile': doctor_mobile,
                'password': password,
                'doctor_name': doctor_name,
                'id_card': id_card,
                'province_name': province10,
                'city_name': city10,
                'region_name': district10,
                'province_id': province_id,
                'city_id': city_id,
                'region_id': region_id,
                'hospital_name': hospital_name,
                'bank_card_no': bank_card_no,
                'bank_name': bank_name,
                'recommend_mobile': recommend_mobile,
                'recommend_name': recommend_name,
                'big_area_id': big_area_id,
                'area_id': area_id,
                'sales_id': sales_id,
//                'recommend_id_card': recommend_id_card
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


    function getRecommendInfo(){
        var recommend_mobile =$("#recommend_mobile").val();
        var doctor_mobile =$("#doctor_mobile").val();
        if(recommend_mobile ==doctor_mobile){
            alert('推荐人手机号不能与医生手机号重复!');
            return false;
        }
        if(recommend_mobile.length != 11){
            alert('请输入11位手机号!');
            return false;
        }
        $.ajax({
            type: 'post',
            url: '{{url('index/ajax')}}',
            data: {'action': 'getRecommendInfo','recommend_mobile':recommend_mobile},
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            beforeSend: function(XMLHttpRequest) {
//                $('body').showLoading();
            },
            success: function(json) {
                if (json.status == 1) {
                    var data =json.data;
                    $("#recommend_name").val(data.recommend_name);
                    $("#recommend_name").attr('readonly','readonly');
                    $("#big_area_id").val(data.big_area_id);
                    $("#area_id").empty();
                    $("#sales_id").empty();
                    $("#area_id").append("<option value='"+data.area_id+"'>"+data.area_name+"</option>");
                    $("#sales_id").append("<option value='"+data.sales_id+"'>"+data.sales_name+"</option>");

//                    .trigger('change');
//                    $("#area_id").val(data.area_id);
//                    $("#sales_id").val(data.sales_id);
//                    $("#recommend_id_card").val(data.recommend_id_card);

                } else {
                    $("#recommend_name").val('');
                    $("#recommend_name").removeAttr("readonly");
                    $("#big_area_id").val('all');
                    $("#area_id").val('all');
                    $("#sales_id").val('all');
                    $("#recommend_id_card").val('');
                }
            },
            complete: function() {

            },
            error: function() {
                alert("服务器繁忙！");
            }
        });
    }


        $("#big_area_id").change(function(){
            var big_area_id =$(this).val();
            if(big_area_id =="all"){
                return false;
            }
        $.ajax({
            type: 'post',
            url: '{{url('index/ajax')}}',
            data: {'action': 'getArea','big_area_id':big_area_id},
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            beforeSend: function(XMLHttpRequest) {
//                $('body').showLoading();
            },
            success: function(json) {
                if (json.status == 1) {
                    var data =json.data;
                    $("#area_id").empty();
                    li="";
                    $.each(data, function(index, value) {
                        li +="<option value='"+value._id+"'>"+value.area_name+"</option>";
                    })
                    $("#area_id").append(li);
                    $("#area_id").trigger('change');
                    } else {
                     alert("非法的请求!");
                }
            },
            complete: function() {

            },
            error: function() {
                alert("服务器繁忙！");
            }
        });
        })

    $("#area_id").change(function(){
        var area_id =$(this).val();
        $.ajax({
            type: 'post',
            url: '{{url('index/ajax')}}',
            data: {'action': 'getSales','area_id':area_id},
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            beforeSend: function(XMLHttpRequest) {
//                $('body').showLoading();
            },
            success: function(json) {
                if (json.status == 1) {
                    var data =json.data;
                    $("#sales_id").empty();
                    li="";
                    $.each(data, function(index, value) {
                        li +="<option value='"+value._id+"'>"+value.sales_name+"</option>";
                    })
                    $("#sales_id").append(li);
                } else {
                    alert("非法的请求!");
                }
            },
            complete: function() {

            },
            error: function() {
                alert("服务器繁忙！");
            }
        });
    })


</script>