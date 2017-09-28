<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="renderer" content="webkit">
    <meta name="_token" content="{{ csrf_token() }}"/>
    <title>医生管理</title>
    <link rel="stylesheet" href="{{asset('resources/views/admin/static/css/pintuer.css')}}">
    <link rel="stylesheet" href="{{asset('resources/views/admin/static/css/admin.css')}}">
    <link rel="stylesheet" href="{{asset('resources/views/admin/static/css/main.css')}}">
    <script src="{{asset('resources/views/admin/static/js/jquery.js')}}"></script>

</head>
<body>
<div class="panel admin-panel">
    <div class="panel-head"><strong><span class="icon-pencil-square-o"></span>医生管理</strong></div>
    <div class="body-content">
        <form method="post" class="form-x" action="">
            <div class="form-group" id="distpicker5">
                <select class="form-control l input" id="province10" name="province_id"></select>
                <select class="form-control l input" id="city10" name="city_id"></select>
                <select class="form-control l input" id="district10" name="region_id"></select>
            </div>
            <div class="form-group ml3 doctor-w200">
                <div class="label">
                    <label>医生姓名：</label>
                </div>
                <div class="field">
                    <input type="text" class="input" name="stitle"  id="doctor_name" value=""/>
                    <div class="tips"></div>
                </div>
            </div>
            <div class="form-group doctor-w200">
                <div class="label">
                    <label>医生手机号：</label>
                </div>
                <div class="field">
                    <input type="text" class="input" name="surl" id="doctor_mobile" value=""/>
                </div>
            </div>
            <div class="form-group doctor-w200">
                <div class="label">
                    <label>身份证号码：</label>
                </div>
                <div class="field">
                    <input type="text" class="input" name="surl" id="id_card" value=""/>
                </div>
            </div>
            <div class="form-group w100">
                <div class="field">
                    <button class="button bg-main icon-plus" type="button" onclick ="add()">添加</button>
                    {{--<button class="button bg-main icon-sign-out" type="button" onclick ="return false;">导出</button>--}}
                    <button class="button bg-main icon-refresh" type="reset" id="reset" onclick ="return false;">重置</button>
                    <button class="button bg-main icon-search" type="button" id="search" onclick ="return false;">查询</button>
                </div>
            </div>
        </form>
        <form method="post" action="">
            <div class="panel admin-panel">
                <table class="table table-hover text-center" id="list">
                    {{--<tr>--}}
                        {{--<th width="50">ID</th>--}}
                        {{--<th>医生姓名</th>--}}
                        {{--<th>医生手机号</th>--}}
                        {{--<th>省</th>--}}
                        {{--<th>市</th>--}}
                        {{--<th>县/区</th>--}}
                        {{--<th>医院</th>--}}
                        {{--<th>身份证号码</th>--}}
                        {{--<th>开户行</th>--}}
                        {{--<th>银行卡号</th>--}}
                        {{--<th>操作</th>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                        {{--<td><input type="checkbox" name="id[]" value="1" />1</td>--}}
                        {{--<td>神夜</td>--}}
                        {{--<td>13420925611</td>--}}
                        {{--<td>湖北省</td>--}}
                        {{--<td>武汉市</td>--}}
                        {{--<td>洪山区</td>--}}
                        {{--<td>中南医院</td>--}}
                        {{--<td>xxxxxxxxxxxx</td>--}}
                        {{--<td>xxxxxxxxxxxxx</td>--}}
                        {{--<td>xxxxxxxxxxxx</td>--}}
                        {{--<td width="180"><div class="button-group">--}}
                                {{--<a type="button" class="button border-main" href="#"><span class="icon-edit"></span>编辑</a>--}}
                                {{--<a type="button" class="button border-red" href="#"><span class="icon-money"></span>禁用</a>--}}
                                {{--<a type="button" class="button border-main" href="#"><span class="icon-user-md"></span>推荐人</a>--}}
                            {{--</div></td>--}}
                    {{--</tr>--}}

                    <tr>
                        <td colspan="14"><div class="pagelist"> <a href="">上一页</a> <span class="current">1</span><a href="">2</a><a href="">3</a><a href="">下一页</a><a href="">尾页</a> </div></td>
                    </tr>
                </table>
            </div>
        </form>
    </div>
</div>

<!--医生管理 添加 编辑弹框开始-->
<div style="width: 600px; display: none;margin-left:-300px;" class="MsgBox clearfix" id="editBox1">
    <div class="top">
        <div class="title" class="MsgTitle">添加/编辑</div>
    </div>
    <div class="body l">
        <form class="alert-form clearfix">
            <div class="form-groups clearfix">
                <div class="form-group">
                    <div class="label">
                        <label>医生姓名：</label>
                    </div>
                    <div class="field">
                        <input type="text" class="input" id="edit_doctor_name">
                        <div class="tips"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="label">
                        <label>医生手机号：</label>
                    </div>
                    <div class="field">
                        <input type="text" class="input" id="edit_doctor_mobile">
                        <div class="tips"></div>
                    </div>
                </div>
            </div>
            <div class="form-groups clearfix">
                <div class="form-group">
                    <div class="label">
                        <label>登陆密码：</label>
                    </div>
                    <div class="field">
                        <input type="text" class="input" id="edit_password">
                        <div class="tips"></div>
                    </div>
                </div>
            </div>
            <div class="form-groups clearfix doctorArea">
                <div class="label l">
                    <label>地区：</label>
                </div>
                <div class="field l" id="distpickerAlert">
                    <select class="form-control input l" name="provinceid" id="provinceid"></select>
                    <select class="form-control input l" name="cityid"  id="cityid"></select>
                    <select class="form-control input l" name="regionid"  id="regionid"></select>
                </div>
            </div>
            <div class="form-groups clearfix">
                <div class="form-group">
                    <div class="label">
                        <label>医院：</label>
                    </div>
                    <div class="field">
                        <input type="text" class="input" id="edit_hospital_name">
                        <div class="tips"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="label">
                        <label>身份证账号：</label>
                    </div>
                    <div class="field">
                        <input type="text" class="input" id="edit_id_card">
                        <div class="tips"></div>
                    </div>
                </div>
            </div>
            <div class="form-groups clearfix">
                <div class="form-group">
                    <div class="label">
                        <label>开户行：</label>
                    </div>
                    <div class="field">
                        <input type="text" class="input" id="edit_bank_name">
                        <div class="tips"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="label">
                        <label>银行卡号：</label>
                    </div>
                    <div class="field">
                        <input type="text" class="input" id="edit_bank_card_no">
                        <div class="tips"></div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="bottom l" class="MsgBottom" style="height: 45px;">
        <div class="btn MsgBtns">
            <div class="height"></div>
            <input type="button" class="btn" value="确认" id="sureEdit1">　<input type="button" class="btn" id="cancleEdit1" value="取消">
            <input type="hidden" name="doctorid"  id="doctorid" value="" />
        </div>
    </div>
</div>
<!--医生管理 添加结束-->

<!--禁用数据弹框开始-->
<div style="width: 300px; display:none;" class="MsgBox clearfix">
    <div class="top">
        <div class="title" class="MsgTitle">提示</div>
    </div>
    <div class="body l">
        <p>是否禁用该条数据</p>
    </div>
    <div class="bottom l" class="MsgBottom" style="height: 45px;">
        <div class="btn MsgBtns">
            <div class="height"></div>
            <input type="button" class="btn" value="确认">　<input type="button" class="btn" value="取消">

        </div>
    </div>
</div>
<!--删除数据结束-->

<!--推荐人弹框开始-->
<div style="display: none;width: 800px;margin-left:-400px;" class="MsgBox clearfix" id="recommendBox">
    <div class="top">
        <div class="title" class="MsgTitle">推荐人</div>
    </div>
    <div class="body l">
        <form method="post" action="" class="alert-form">
            <div class="panel admin-panel">
                <table class="table table-hover text-center" id="recommendList">
                    {{--<tr>--}}
                        {{--<th>推荐人姓名</th>--}}
                        {{--<th>推荐人手机号</th>--}}
                        {{--<th>大区</th>--}}
                        {{--<th>地区</th>--}}
                        {{--<th>销售组</th>--}}
                        {{--<th>绑定时间</th>--}}
                        {{--<th width="120px">操作</th>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                        {{--<td>xxx</td>--}}
                        {{--<td>xxx</td>--}}
                        {{--<td>xxx</td>--}}
                        {{--<td>xxx</td>--}}
                        {{--<td>xxx</td>--}}
                        {{--<td>xxx</td>--}}
                        {{--<td>--}}
                            {{--<div class="button-group">--}}
                                {{--<a type="button" class="button border-main" href="#"><span class="icon-plus"></span>添加</a>--}}
                                {{--<a class="button border-red" href="javascript:void(0)" ><span--}}
                                            {{--class="icon-book"></span>删除</a>--}}
                            {{--</div>--}}
                            {{--<input type="hidden" name="doctor_recommend_id"  id="doctor_recommend_id" value="" />--}}
                        {{--</td>--}}
                    {{--</tr>--}}
                </table>
            </div>
        </form>
    </div>
    <div class="bottom l" class="MsgBottom" style="height: 45px;">
        <div class="btn MsgBtns">
            <div class="height"></div>
            <input type="button" class="btn" value="关闭" onclick="close1()">
        </div>
    </div>
</div>
<!--推荐人弹框结束-->

<!--销售区添加弹框开始-->
<div style="display: none;width: 300px;margin-left:-150px;" class="MsgBox clearfix" id="editBox2">
    <div class="top">
        <div class="title" class="MsgTitle">添加</div>
    </div>
    <div class="body l">
        <form class="alert-form clearfix">
            <div class="form-group">
                <div class="label">
                    <label>大区：</label>
                </div>
                <div class="field">
                    <select class="input">
                        <option value="1">1</option>
                        <option value="1">1</option>
                        <option value="1">1</option>
                        <option value="1">1</option>
                    </select>
                    <div class="tips"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="label">
                    <label>地区：</label>
                </div>
                <div class="field">
                    <select class="input">
                        <option value="1">1</option>
                        <option value="1">1</option>
                        <option value="1">1</option>
                        <option value="1">1</option>
                    </select>
                    <div class="tips"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="label">
                    <label>销售组：</label>
                </div>
                <div class="field">
                    <select class="input">
                        <option value="1">1</option>
                        <option value="1">1</option>
                        <option value="1">1</option>
                        <option value="1">1</option>
                    </select>
                    <div class="tips"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="label">
                    <label>推荐人名称：</label>
                </div>
                <div class="field">
                    <input type="text" class="input">
                    <div class="tips"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="label">
                    <label>推荐人手机号：</label>
                </div>
                <div class="field">
                    <input type="text" class="input">
                    <div class="tips"></div>
                </div>
            </div>

        </form>
    </div>
    <div class="bottom l" class="MsgBottom" style="height: 45px;">
        <div class="btn MsgBtns">
            <div class="height"></div>
            <input type="button" class="btn" value="确认" id="sureEdit2">　<input type="button"  id='cancleEdit2' class="btn" value="取消">
        </div>
    </div>
</div>
<!--销售区添加弹框结束-->


<script src="{{asset('resources/views/admin/static/js/distpicker.data.js')}}"></script>
<script src="{{asset('resources/views/admin/static/js/distpicker.js')}}"></script>
<script src="{{asset('resources/views/admin/static/js/main.js')}}"></script>
<script>
    $("#distpicker5").distpicker({
        autoSelect: false
    });
    $("#distpickerAlert").distpicker({
        autoSelect: false
    });
</script>
</body>
</html>
<script type="text/javascript">
    var page_cur = 1; //当前页
    var total_num, page_size, page_total_num; //总记录数,每页条数,总页数
    var status
    function getData(page) { //获取当前页数据
        var doctor_name=$("#doctor_name").val();
        var doctor_mobile=$("#doctor_mobile").val();
        var province_id=$("#province_id").val();
        var city_id=$("#city_id").val();
        var region_id=$("#region_id").val();
        var id_card=$("#id_card").val();
        var doctor_name=$.ajax({
            type: 'post',
            url: '{{url('admin/doctor/ajax')}}',
            data: {'page': page, 'action': 'getlist','doctor_name': doctor_name, 'doctor_mobile': doctor_mobile, 'province_id': province_id, 'city_id': city_id, 'region_id': region_id, 'id_card': id_card},
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            beforeSend: function(XMLHttpRequest) {
//                $('body').showLoading();
            },
            success: function(json) {
                if (json.status == 1) {
                    $("#list").empty();
                    total_num = json.total_num; //总记录数
                    page_size = json.page_size; //每页数量
                    page_cur = page; //当前页
                    page_total_num = json.page_total_num; //总页数businessScope unix_to_datetime(unix);   getLocalTime(parseInt(array.ctime,10)) SProductName out_logi_no

                    var li = "<tr><th width='50'>ID</th><th>医生姓名</th><th>医生手机号</th><th>省</th><th>市</th> <th>县/区</th><th>医院</th><th>身份证号码</th><th>开户行</th><th>银行卡号</th><th>操作</th></tr>";
                    var list = json.list;
                    $.each(list, function(index, array) { //遍历返回json
                        var recommendAdd ="{{url('admin/doctor/recommendadd/')}}"+"/"+array._id;
                        li +="<tr><td>"+(page_size*(page_cur-1)+index+1)+"</td><td>"+array.doctor_name+"</td> <td>"+array.doctor_mobile+"</td><td>"+array.province_name+"</td><td>"+array.city_name+"</td><td>"+array.region_name+"</td><td>"+array.hospital_name+"</td><td>"+array.id_card+"</td> <td>"+array.bank_name+"</td><td>"+array.bank_card_no+"</td><td width='180'><div class='button-group'><a type='button' class='button border-main' href='javascript:;' onclick='edit(this)' doctorid='"+array._id+"' edit_doctor_name='"+array.doctor_name+"' edit_doctor_mobile='"+array.doctor_mobile+"' edit_password='"+array.password+"' edit_hospital_name='"+array.hospital_name+"' edit_id_card='"+array.id_card+"' edit_bank_name='"+array.bank_name+"' edit_bank_card_no='"+array.bank_card_no+"' province_id='"+array.province_id+"' region_id='"+array.region_id+"' city_id='"+array.city_id+"' province_name='"+array.province_name+"' region_name='"+array.region_name+"' city_name='"+array.city_name+"'><span class='icon-edit'></span>编辑</a><a type='button' class='button border-main' href='javascript:;' onclick='recommend(this)' doctorid='"+array._id+"'><span class='icon-user-md'></span>推荐人</a><a type='button' class='button border-main' href='"+recommendAdd+"'><span class='icon-user-md'></span>添加推荐人</a></div></td></tr>";
                    });
                    li +="<tr id ='page-tag'></tr>"
                    $("#list").append(li);
                    getPageBar();
                } else {
                    $("#list").empty();
                    $("#list").append("<tr><td colspan='14'><div class='pagelist' id='pagelist'></div>暂无数据</tr>");
                    alert(json.msg);
                }
            },
            complete: function() {
//                getPageBar(); //js生成分页，可用程序代替
//                $('body').hideLoading();
            },
            error: function() {
//                $('body').hideLoading();
                alert("数据异常！");
            }
        });
    }
    function getPageBar() { //js生成分页
        if (page_cur > page_total_num)
            page_cur = page_total_num; //当前页大于最大页数
        if (page_cur < 1)
            page_cur = 1; //当前页小于1
        page_str ="<td colspan='14'><div class='pagelist' id='pagelist'>";
        page_str += "<span>共" + page_total_num + "页</span><span>" + page_cur + "/" + page_total_num + "</span>";
//        page_str ="<tr>";
        //若是第一页
        if (page_cur == 1) {
            page_str += "<span>首页</span><span>上一页</span>";
        } else {
            page_str += "<a href='javascript:void(0)' onclick='aclick(this);' data-page='1'>首页</a><a href='javascript:void(0)' onclick='aclick(this);' data-page='" + (page_cur - 1) + "'>上一页</a>";
        }
        //若是最后页
        if (page_cur >= page_total_num) {
            page_str += "<span>下一页</span><span>尾页</span>";
        } else {
            page_str += "<a href='javascript:void(0)' onclick='aclick(this);' data-page='" + (parseInt(page_cur) + 1) + "'>下一页</a><a href='javascript:void(0)' onclick='aclick(this);' data-page='" + page_total_num + "'>尾页</a>";
        }
        page_str +="</div></td>";
        $("#page-tag").html(page_str);
    }

    $(function() {
        getData(1); //默认第一页
        $("#list tr").on('click', function() { //live 向未来的元素添加事件处理器,不可用bind
            var page = $(this).attr("data-page"); //获取当前页
            getData(page)
        });
    });

    function aclick(obj){
        var page = $(obj).attr("data-page"); //获取当前页
        getData(page);
    }
    $('#search').click(function() {
        getData(1);
    });

    $('#reset').click(function() {
        $("#doctor_name").val('');
        $("#doctor_mobile").val('');
        $("#province_id").val('');
        $("#city_id").val('');
        $("#region_id").val('');
        $("#id_card").val('');
        getData(1);
    });


    function recommend(obj){
        var doctor_id =$(obj).attr('doctorid');
        $.ajax({
            type: 'post',
            url: '{{url('admin/doctor/ajax')}}',
            data: {'action': 'getRecommend','doctor_id':doctor_id},
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            beforeSend: function(XMLHttpRequest) {
//                $('body').showLoading();
            },
            success: function(json) {
                if (json.status == 1) {
                    $("#recommendList").empty();
                    var li ="<tr><th>推荐人姓名</th><th>推荐人手机号</th><th>大区</th><th>地区</th><th>销售组</th> <th>绑定时间</th><th width='120px'>操作</th></tr>";
                    $.each(json.list, function(index, array) { //遍历返回json

                        li +="<tr><td>"+array.recommend_name+"</td><td>"+array.recommend_mobile+"</td><td>"+array.big_area_name+"</td><td>"+array.area_name+"</td><td>"+array.sales_name+"</td><td>"+array.created_at+"</td><td> <div class='button-group'><a class='button border-red' href='javascript:void(0)' onclick='del(this)' recommend_id='"+array.recommend_id+"'  doctor_id='"+array.doctor_id+"'><span class='icon-book'></span>删除</a></div></td></tr>";
                    });
                    $("#recommendList").append(li);
                    $('#recommendBox').css('display','block');
                } else {
                    alert(json.msg);
                }
            },
            complete: function() {

            },
            error: function() {
                alert("数据异常！");
            }
        });
    }



    function del(obj){
        var delObj =$(obj);
        var recommend_id=delObj.attr('recommend_id');
        var doctor_id=delObj.attr('doctor_id');
        if(confirm("确定要删除该推荐人吗？")){
            $.ajax({
                type: 'post',
                url: '{{url('admin/doctor/ajax')}}',
                data: {'action': 'delRecommend','recommend_id':recommend_id,'doctor_id':doctor_id},
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                beforeSend: function(XMLHttpRequest) {
//                $('body').showLoading();
                },
                success: function(json) {
                    if (json.status == 1) {
                        delObj.parent().parent().parent().remove();
                        alert(json.msg);

                    } else {
                        alert(json.msg);
                    }
                },
                complete: function() {

                },
                error: function() {
                    alert("数据异常！");
                }
            });
        }
    }

    function close1(){
        $('#recommendBox').css('display','none');
    }

//添加修改医生信息
    function edit(obj){

        $("#doctorid").val($(obj).attr('doctorid'));
        $("#edit_doctor_name").val($(obj).attr('edit_doctor_name'));
        $("#edit_doctor_mobile").val($(obj).attr('edit_doctor_mobile'));
        $("#edit_password").val($(obj).attr('edit_password'));
        $("#edit_hospital_name").val($(obj).attr('edit_hospital_name'));
        $("#edit_id_card").val($(obj).attr('edit_id_card'));
        $("#edit_bank_name").val($(obj).attr('edit_bank_name'));
        $("#edit_bank_card_no").val($(obj).attr('edit_bank_card_no'));

        var province_id =$(obj).attr('province_id');
        var city_id =$(obj).attr('city_id');
        var region_id =$(obj).attr('region_id');
        var province_name =$(obj).attr('province_name');
        var city_name =$(obj).attr('city_name');
        var region_name =$(obj).attr('region_name');
        if(province_id) {
            $("#provinceid").prepend("<option value='" + province_name + "' data-code='" + province_id + "'>" + province_name + "</option>");
            $("#provinceid").val(province_name);
        }
        if(city_id) {
            $("#cityid").prepend("<option value='" + city_name + "' data-code='" + city_id + "'>" + city_name + "</option>");
            $("#cityid").val(city_name);
        }
        if(region_id) {
            $("#regionid").prepend("<option value='"+region_name+"' data-code='" + region_id + "'>"+region_name+"</option>");
            $("#regionid").val(region_name);
        }

        $('#editBox1').css('display','block');
    }

    function add(){
        $("#edit_doctor_name").val('');
        $("#edit_doctor_mobile").val('');
        $("#edit_password").val('');
        $("#edit_hospital_name").val('');
        $("#edit_id_card").val('');
        $("#edit_bank_name").val('');
        $("#edit_bank_card_no").val('');
        $("#doctorid").val('');


        $('#provinceid option:eq(0)').attr('selected','selected');
        $('#cityid option:eq(0)').attr('selected','selected');
        $('#regionid option:eq(0)').attr('selected','selected');
        $("#editBox1").css('display','block');
    }

    $("#sureEdit1").click(function(){
        var id=$("#doctorid").val();
        var doctor_name=$("#edit_doctor_name").val();
        var doctor_mobile=$("#edit_doctor_mobile").val();
        var password=$("#edit_password").val();
        var hospital_name=$("#edit_hospital_name").val();
        var id_card=$("#edit_id_card").val();
        var bank_name=$("#edit_bank_name").val();
        var bank_card_no=$("#edit_bank_card_no").val();

        var province_id=$("#provinceid").find("option:selected").attr('data-code');
        var city_id=$("#cityid").find("option:selected").attr('data-code');
        var region_id=$("#regionid").find("option:selected").attr('data-code');
        var province_name=$("#provinceid").val();
        var city_name=$("#cityid").val();
        var region_name=$("#regionid").val();
        if(doctor_name ==''){
            alert('请输入医生名称!');
            return false;
        }
        if(doctor_mobile ==''){
            alert('请输入医生电话!');
            return false;
        }
        if(password ==''){
            alert('请输入密码!');
            return false;
        }
        $.ajax({
            type: 'post',
            url: '{{url('admin/doctor/ajax')}}',
            data: {'action': 'docotrEdit','id':id,'doctor_name':doctor_name,'doctor_mobile':doctor_mobile,'password':password,'hospital_name':hospital_name,'id_card':id_card,'bank_name':bank_name,'bank_card_no':bank_card_no,'province_id':province_id,'city_id':city_id,'region_id':region_id,'province_name':province_name,'city_name':city_name,'region_name':region_name },
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            beforeSend: function(XMLHttpRequest) {
//                $('body').showLoading();
            },
            success: function(json) {
                if (json.status == 1) {
//                    $("#editBox1").css('display','none');
                    alert(json.msg);
                    window.location.href="{{url("admin/doctor/index")}}";
                } else {
                    alert(json.msg);
                }
            },
            complete: function() {

            },
            error: function() {
                alert("数据异常！");
            }
        });

    })


    $("#cancleEdit1").click(function(){
        $("#editBox1").css('display','none');
    })


    //添加修改推荐人信息

</script>