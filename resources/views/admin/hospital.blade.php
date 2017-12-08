@extends('layouts.admin')

@section('title','医院管理')

@section('js')
    <script src="{{asset('resources/views/admin/static/js/distpicker.data.js')}}"></script>
    <script src="{{asset('resources/views/admin/static/js/distpicker.js')}}"></script>
    <script src="{{asset('resources/views/admin/static/js/main.js')}}"></script>
@stop
@section('content')
    <div class="panel admin-panel">
        <div class="panel-head"><strong><span class="icon-pencil-square-o"></span>医院管理</strong></div>
        <div class="body-content">
            <form method="post" class="form-x" action="">
                <div class="form-group" id="distpicker5">
                    <select class="form-control l input" id="province10" ></select>
                    <select class="form-control l input" id="city10" ></select>
                    <select class="form-control l input" id="district10" ></select>
                </div>
                <div class="form-group ml3 doctor-w200" >
                    <div class="label">
                        <label>医院名称：</label>
                    </div>
                    <div class="field">
                        <input type="text" class="input" name="stitle" value="" id="hospital_name"/>
                        <div class="tips"></div>
                    </div>
                </div>
                <div class="form-group doctor-w200">
                    <select class="form-control l input" id="hospital_level_id">
                        <option value="all">医院级别</option>
                        <option value="1">二甲医院</option>
                        <option value="2">三甲医院</option>
                    </select>
                </div>
                <div class="form-group w100">
                    <div class="field">
                        <button class="button bg-main icon-plus" type="button" onclick="add()">添加</button>
                        {{--<button class="button bg-main icon-sign-in" type="button">导入</button>--}}
                        {{--<button class="button bg-main icon-sign-out" type="button">导出</button>--}}
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
                            {{--<th>省</th>--}}
                            {{--<th>市</th>--}}
                            {{--<th>县/区</th>--}}
                            {{--<th>医院</th>--}}
                            {{--<th>医院级别</th>--}}
                            {{--<th>启用状态</th>--}}
                            {{--<th>操作</th>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td><input type="checkbox" name="id[]" value="1" />1</td>--}}
                            {{--<td>湖北省</td>--}}
                            {{--<td>武汉市</td>--}}
                            {{--<td>洪山区</td>--}}
                            {{--<td>中南医院</td>--}}
                            {{--<td>三级甲等</td>--}}
                            {{--<td>启用</td>--}}
                            {{--<td width="180"><div class="button-group">--}}
                                    {{--<a type="button" class="button border-main" href="#"><span class="icon-edit"></span>编辑</a>--}}
                                    {{--<a type="button" class="button border-red" href="#"><span class="icon-money"></span>禁用</a>--}}

                                {{--</div></td>--}}
                        {{--</tr>--}}

                        {{--<tr>--}}
                            {{--<td colspan="14"><div class="pagelist"> <a href="">上一页</a> <span class="current">1</span><a href="">2</a><a href="">3</a><a href="">下一页</a><a href="">尾页</a> </div></td>--}}
                        {{--</tr>--}}
                    </table>
                </div>
            </form>
        </div>
    </div>

    <!--销售区添加弹框开始-->
    <div style="display: none;width: 300px;margin-left:-150px;" class="MsgBox clearfix" id="editBox">
        <div class="top">
            <div class="title" class="MsgTitle">添加/编辑</div>
        </div>
        <div class="body l">
            <form class="alert-form clearfix">
                <div class="form-groups clearfix hospitalArea">
                    <div class="label l">
                        <label>地区：</label>
                    </div>
                    <div class="field r" id="distpickerAlert">
                        <select class="form-control input l" name="provinceid" id="provinceid"></select>
                        <select class="form-control input l" name="cityid"  id="cityid"></select>
                        <select class="form-control input l" name="regionid"  id="regionid"></select>
                    </div>
                </div>

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
                        <label>医院级别：</label>
                    </div>
                    <div class="field">
                        <select class="input" id="edit_hospital_level_id">

                            <option value="all">医院级别</option>
                            <option value="1">二甲医院</option>
                            <option value="2">三甲医院</option>
                        </select>
                        <div class="tips"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="label">
                        <label>状态：</label>
                    </div>
                    <div class="field">
                        <select class="input" id="editStatus">
                            <option value="1">启用</option>
                            <option value="0">禁用</option>
                        </select>
                        <div class="tips"></div>
                    </div>
                </div>

            </form>
        </div>
        <div class="bottom l" class="MsgBottom" style="height: 45px;">
            <div class="btn MsgBtns">
                <div class="height"></div>
                <input type="button" class="btn" value="确认" id="sureEdit">　<input type="button" class="btn" value="取消" id="cancleEdit">
                <input type="hidden" name="hospitalid"  id="hospitalid" value="" />
            </div>
        </div>
    </div>
    <!--销售区添加弹框结束-->
@stop


@section('adminjs')
    <script>
        $("#distpicker5").distpicker({
            autoSelect: false
        });
        $("#distpickerAlert").distpicker({
            autoSelect: false
        });
    </script>

    <script type="text/javascript">
    var page_cur = 1; //当前页
    var total_num, page_size, page_total_num; //总记录数,每页条数,总页数
    var status
    function getData(page) { //获取当前页数据
        var province_id = $("#province10").val();
        var city_id = $("#city10").val();
        var region_id = $("#district10").val();
        var hospital_name = $("#hospital_name").val();
        var hospital_level_id = $("#hospital_level_id").val();
        $.ajax({
            type: 'post',
            url: '{{url('admin/hospital/ajax')}}',
            data: {'page': page, 'action': 'getlist', 'province_id': province_id, 'city_id': city_id, 'region_id': region_id, 'hospital_name': hospital_name, 'hospital_level_id': hospital_level_id},
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
                    var li = "<tr><th width='50'>ID</th><th>省</th><th>市</th><th>县/区</th><th>医院</th><th>医院级别</th><th>启用状态</th><th>操作</th></tr>";
                    var list = json.list;
                    var status_button;
                    $.each(list, function(index, array) { //遍历返回json
                        if(array.status==1){
                            array.status_button='启用';
//                            status_button ='禁用';
                        }else{
                            array.status_button='禁用';
//                            status_button ='启用';
                        }
                        li +="<tr><td>"+(page_size*(page_cur-1)+index+1)+"</td><td>"+array.province_name+"</td> <td>"+array.city_name+"</td><td>"+array.region_name+"</td><td>"+array.hospital_name+"</td><td>"+array.hospital_level_name+"</td><td>"+array.status_button+"</td><td width='180'><div class='button-group'><a type='button' class='button border-main' href='javascript:;' onclick='edit(this)' hospitalid='"+array._id+"' edit_hospital_name='"+array.hospital_name+"' edit_hospital_level_id='"+array.hospital_level_id+"' status='"+array.status+"' province_id='"+array.province_id+"' region_id='"+array.region_id+"' city_id='"+array.city_id+"' province_name='"+array.province_name+"' region_name='"+array.region_name+"' city_name='"+array.city_name+"'><span class='icon-edit'></span>编辑</a></div></td> </tr>";
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
        $("#province10").val('');
        $("#city10").val('');
        $("#district10").val('');
        $("#hospital_name").val('');
        $("#hospital_level_id").val('all');
        getData(1);
    });


    function edit(obj){
        $("#hospitalid").val($(obj).attr('hospitalid'));
        $("#edit_hospital_name").val($(obj).attr('edit_hospital_name'));
        $("#edit_hospital_level_id").val($(obj).attr('edit_hospital_level_id'));
        $("#editStatus").val($(obj).attr('status'));

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
        $("#editBox").css('display','block');
    }

    function add(){
        $("#edit_hospital_name").val('');
        $("#edit_hospital_level_id").val('all');
        $("#hospitalid").val('');
        $('#editStatus option:eq(0)').attr('selected','selected');

        $('#provinceid option:eq(0)').attr('selected','selected');
        $('#cityid option:eq(0)').attr('selected','selected');
        $('#regionid option:eq(0)').attr('selected','selected');
        $("#editBox").css('display','block');
    }

    $("#sureEdit").click(function(){
        var id=$("#hospitalid").val();
        var hospital_name=$("#edit_hospital_name").val();
        var hospital_level_id=$("#edit_hospital_level_id").val();
        var status=$("#editStatus").val();

        var province_id=$("#provinceid").find("option:selected").attr('data-code');
        var city_id=$("#cityid").find("option:selected").attr('data-code');
        var region_id=$("#regionid").find("option:selected").attr('data-code');
        var province_name=$("#provinceid").val();
        var city_name=$("#cityid").val();
        var region_name=$("#regionid").val();
        if(hospital_name ==''){
            alert('请输入医院名称!');
            return false;
        }
        if(hospital_level_id =='all'){
            alert('请选择医院级别!');
            return false;
        }
        var hospital_level_name=$('#edit_hospital_level_id option:selected').text();
        $.ajax({
            type: 'post',
            url: '{{url('admin/hospital/ajax')}}',
            data: {'action': 'edit','id':id,'hospital_name':hospital_name,'hospital_level_id':hospital_level_id,'hospital_level_name':hospital_level_name,'status':status,'province_id':province_id,'city_id':city_id,'region_id':region_id,'province_name':province_name,'city_name':city_name,'region_name':region_name },
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            beforeSend: function(XMLHttpRequest) {
//                $('body').showLoading();
            },
            success: function(json) {

                if (json.status == 1) {
                    $("#editBox").css('display','none');
                    alert(json.msg);
                    window.location.href="{{url("admin/hospital/index")}}";
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


    $("#cancleEdit").click(function(){
        $("#editBox").css('display','none');
    })
</script>
@stop