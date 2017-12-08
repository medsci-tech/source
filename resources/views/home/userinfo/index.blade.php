@extends('layouts.home')

@section('title','个人信息')

@section('content')
    <div class="panel admin-panel">
        <div class="panel-head"><strong>个人信息</strong></div>
        <div class="body-content">
            <form method="post" class="form-x formp personInfoForm" action="">
                <div class="form-group">
                    <div class="label">
                        <label>手机号：</label>
                    </div>
                    <div class="field">
                        <input type="text" class="input" name="doctor_mobile" id="doctor_mobile"  readonly ="readonly" value="{{$doctor->doctor_mobile}}"/>
                        <div class="tips"></div>
                    </div>
                    {{--<div class="rightops clearfix">--}}
                    {{--<a href="modifyNumber.html" class="l">更改手机号</a>--}}
                    {{--<a href="modifyPassword.html" class="l">修改密码</a>--}}
                    {{--</div>--}}
                </div>

                <div class="form-group">
                    <div class="label">
                        <label>姓名：</label>
                    </div>
                    <div class="field">
                        <input type="text" class="input" name="doctor_name" id="doctor_name" value="{{$doctor->doctor_name}}"/>
                        <div class="tips"></div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="label">
                        <label>身份证号：</label>
                    </div>
                    <div class="field">
                        <input type="text" class="input" name="id_card" id="id_card" value="{{$doctor->id_card}}"/>
                        <div class="tips"></div>
                    </div>
                </div>

                <div class="form-group clearfix" id="distpicker5">
                    <div class="label">
                        <label>地区：</label>
                    </div>
                    <select class="form-control" id="province10" style="width:auto;">
                    </select>
                    <select class="form-control" id="city10" style="width:auto;">
                    </select>
                    <select class="form-control" id="district10" style="width:auto;">
                    </select>
                    <div class="tips"></div>
                </div>
                <input type="hidden" name="province_name" id="province_name" value="{{$doctor->province_name}}" data-code="{{$doctor->province_id}}" />
                <input type="hidden" name="city_name" id="city_name" value="{{$doctor->city_name}}" data-code="{{$doctor->city_id}}"/>
                <input type="hidden" name="region_name" id="region_name" value="{{$doctor->region_name}}" data-code="{{$doctor->region_id}}" />
                <div class="form-group">
                    <div class="label">
                        <label>医院名称：</label>
                    </div>
                    <div class="field">
                        <input type="text" class="input" name="hospital_name" id="hospital_name" value="{{$doctor->hospital_name}}"/>
                        <div class="tips"></div>
                    </div>
                </div>


                <div class="form-group">
                    <div class="label">
                        <label>银行卡号：</label>
                    </div>
                    <div class="field">
                        <input type="text" class="input" name="bank_card_no" id="bank_card_no" value="{{$doctor->bank_card_no}}"/>
                        <div class="tips"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="label">
                        <label>账号支行：</label>
                    </div>
                    <div class="field">
                        <input type="text" class="input" name="bank_name" id="bank_name" value="{{$doctor->bank_name}}"/>
                        <div class="tips"></div>
                    </div>
                </div>

                <div class="form-group w100">
                    <div class="label">
                        <label></label>
                    </div>
                    <div class="field">
                        <a href="javascript::" class="button bg-main"  onclick="updateUserInfo()">保存</a>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection

@section('floorjs')
    <script src="{{asset('resources/views/home/static/js/distpicker.data.js')}}"></script>
    <script src="{{asset('resources/views/home/static/js/distpicker.js')}}"></script>
    <script src="{{asset('resources/views/home/static/js/main.js')}}"></script>
    <script>
        $("#distpicker5").distpicker({
            autoSelect: false
        });
    </script>
    <script>

        function updateUserInfo() {
            var doctor_name = $("#doctor_name").val();
            var id_card = $("#id_card").val();
            var province10 = $("#province10").val();
            var city10 = $("#city10").val();
            var district10 = $("#district10").val();

            var hospital_name = $("#hospital_name").val();
            var bank_card_no = $("#bank_card_no").val();
            var bank_name = $("#bank_name").val();

            if(doctor_name ==''){
                $("#doctor_name").next().text('请输入姓名');
                $("#doctor_name")[0].focus();
                return false;
            }
            if(id_card ==''){
                $("#id_card").next().text('请输入身份证号');
                $("#id_card")[0].focus();
                return false;
            }
            if(province10 ==''){
//            alert('请选择省');
                $("#province10").parent().children(":last").text('请选择省');
//            $("#province10")[0].focus();
                return false;
            }
            if(city10 ==''){
//            alert('请选择市');
                $("#city10").parent().children(":last").text('请选择地市');
//            $("#city10")[0].focus();
                return false;
            }
            if(district10 ==''){
//            alert('请选择区');
//            $("#district10").next().text('请选择地区');
//            $("#district10")[0].focus();
//            return false;
            }
            if(hospital_name ==''){
                $("#hospital_name").next().text('请输入医院名称');
                $("#hospital_name")[0].focus();
                return false;
            }
            if(bank_card_no ==''){
                $("#bank_card_no").next().text('请输入银行卡号');
                $("#bank_card_no")[0].focus();
                return false;
            }
            if(bank_name ==''){
                $("#bank_name").next().text('请输入账户支行');
                $("#bank_name")[0].focus();
                return false;
            }
            var province_id = $("#province10").find("option:selected").attr('data-code');
            var city_id = $("#city10").find("option:selected").attr('data-code');
            var region_id = $("#district10").find("option:selected").attr('data-code');
            $.ajax({
                type: 'post',
                url: '{{url('home/userinfo/ajax')}}',
                data: {
                    'action': 'updateUserInfo',
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
                        window.location.href="{{url('home/userinfo/index')}}";

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

        $(function(){
            var province_name=$('#province_name').val();
            var province_id=$('#province_name').attr('data-code');
            var city_name=$('#city_name').val();
            var city_id=$('#city_name').attr('data-code');
            var region_name=$('#region_name').val();
            var region_id=$('#region_name').attr('data-code');
            if(province_name) {
                $("#province10").prepend("<option value='" + province_name + "' data-code='" + province_id + "'>" + province_name + "</option>");
                $("#province10").val(province_name);
            }
            if(city_name) {
                $("#city10").prepend("<option value='" + city_name + "' data-code='" + city_id + "'>" + city_name + "</option>");
                $("#city10").val(city_name);
            }
            if(region_name) {
                $("#district10").prepend("<option value='"+region_name+"' data-code='" + region_id + "'>"+region_name+"</option>");
                $("#district10").val(region_name);
            }

        })
    </script>
@endsection
