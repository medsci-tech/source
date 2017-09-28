<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta name="renderer" content="webkit">
    <meta name="_token" content="{{ csrf_token() }}"/>
    <title>添加推荐人</title>
    <link rel="stylesheet" href="{{asset('resources/views/admin/static/css/pintuer.css')}}">
    <link rel="stylesheet" href="{{asset('resources/views/admin/static/css/admin.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('resources/views/admin/static/css/jquery-ui.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('resources/views/admin/static/css/main.css')}}">
    <script src="{{asset('resources/views/admin/static/js/jquery.js')}}"></script>
    <script src="{{asset('resources/views/admin/static/js/pintuer.js')}}"></script>
</head>
<body>

<div class="panel admin-panel">
    <div class="panel-head"><strong>添加推荐人</strong></div>
    <div class="body-content">
        <p class="toolps" style="display: none;text-indent: 2em;">发布成功</p>
        <form method="post" class="form-x sucai" action="">

            <div class="form-group">
                <div class="label">
                    <label>推荐人手机号：</label>
                </div>
                <div class="field">
                    <input type="text" class="input" name="recommend_mobile"  id="recommend_mobile" value="" value="" placeholder="请输入手机号" onblur="getRecommendInfo()"/>
                    <div class="tips"></div>
                </div>
            </div>

            <div class="form-group">
                <div class="label">
                    <label>推荐人姓名：</label>
                </div>
                <div class="field">
                    <input type="text" class="input" name="recommend_name" id="recommend_name" value=""/>
                    <div class="tips"></div>
                </div>
            </div>


            <div class="form-group">
                <div class="label">
                    <label>大区：</label>
                </div>
                <div class="field">
                    <select class="input" name="big_area_id" id="big_area_id">
                        <option value="all">请选择</option>
                        @foreach($bigarea as $v)
                            <option value="{{$v->_id}}">{{$v->big_area_name}}</option>
                        @endforeach
                    </select>
                    <div class="tips"></div>
                </div>
            </div>
            <div class="form-group mr30">
                <div class="label">
                    <label>销售组：</label>
                </div>
                <div class="field">
                    <select class="input" id="sales_id">
                        <option value="all">请选择</option>
                        @foreach($sales as $v)
                            <option value="{{$v->_id}}">{{$v->sales_name}}</option>
                        @endforeach
                    </select>
                    <div class="tips"></div>
                </div>
            </div>
            <div class="form-group" style="width:30%">
                <div class="label">
                    <label>推荐人身份证号：</label>
                </div>
                <div class="field">
                    <input type="text" class="input" name="recommend_id_card" id="recommend_id_card" value="" placeholder="请输入推荐人身份证号码" value=""/>
                    <div class="tips"></div>
                </div>
            </div>
            <div class="form-group w100">
                <div class="field">
                    <a class="button bg-main" href="javascript:;" onclick ="addRecommend()">提交</a>
                </div>
            </div>
            <input type="hidden" name="doctor_id" id="doctor_id" value="{{$doctor_id}}">
        </form>
    </div>
</div>
</body>
</html>

<script>

    function getRecommendInfo(){
        var recommend_mobile =$("#recommend_mobile").val();
        var doctor_id =$("#doctor_id").val();
        $.ajax({
            type: 'post',
            url: '{{url('admin/doctor/ajax')}}',
            data: {'action': 'getRecommendInfo','recommend_mobile':recommend_mobile,'doctor_id':doctor_id},
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
                    $("#sales_id").val(data.sales_id);
                    $("#recommend_id_card").val(data.recommend_id_card);

                } else {
                    $("#recommend_name").val('');
                    $("#recommend_name").removeAttr("readonly");
                    $("#big_area_id").val('all');
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


    function addRecommend() {
        var recommend_mobile = $("#recommend_mobile").val();
        var recommend_name = $("#recommend_name").val();
        var big_area_id = $("#big_area_id").val();
        var sales_id = $("#sales_id").val();
        var recommend_id_card = $("#recommend_id_card").val();
        var doctor_id =$("#doctor_id").val();
        if(recommend_mobile ==''){
            alert('请输入推荐人手机号码!');
            return false;
        }
        if(recommend_name ==''){
            alert('请输入推荐人姓名!');
            return false;
        }
        if(big_area_id ==''){
            alert('请选择大区!');
            return false;
        }
        if(sales_id ==''){
            alert('请选择销售组!');
            return false;
        }
        if(recommend_id_card ==''){
            alert('请输入推荐人身份证号!');
            return false;
        }


        $.ajax({
            type: 'post',
            url: '{{url('admin/doctor/ajax')}}',
            data: {
                'action': 'addRecommend',
                'recommend_mobile': recommend_mobile,
                'recommend_name': recommend_name,
                'big_area_id': big_area_id,
                'sales_id': sales_id,
                'recommend_id_card': recommend_id_card,
                'doctor_id':doctor_id,
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

</script>