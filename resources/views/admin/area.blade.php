@extends('layouts.admin')

@section('title','地区管理')

@section('content')
    <div class="panel admin-panel">
        <div class="panel-head"><strong><span class="icon-pencil-square-o"></span>地区管理</strong></div>
        <div class="body-content">
            <form method="post" class="form-x" action="">
                <div class="form-group  doctor-w200" style="min-width: 660px;">
                    <div class="label ml10">
                        <label>公司：</label>
                    </div>
                    <select class="form-control l input company_id" id="company_id" style="width:20%">
                        <option value="all">选择公司</option>
                        @foreach($company as $v)
                        <option value="{{$v->_id}}">{{$v->full_name}}</option>
                        @endforeach
                    </select>
                    <div class="label ml10">
                        <label>大区：</label>
                    </div>
                    <select class="form-control l input big_area_id" id="big_area_id" style="width:20%">
                        <option value="all">选择大区</option>

                    </select>
                    <div class="label ml10">
                        <label>地区：</label>
                    </div>
                    <div class="field" style="width:20%">
                        <input type="text" class="form-control" name="stitle" value="" id="area_name"/>
                        <div class="tips"></div>
                    </div>
                </div>

                <div class="form-group  tool-btns">
                    <button class="btn btn-primary icon-refresh" type="button" id="reset" onclick ="return false;">重置</button>
                    <button class="btn btn-success icon-search" type="button" id="search" onclick ="return false;">查询</button>
                    <button class="btn btn-danger icon-plus" type="button" onclick="add()">添加</button>
                </div>
            </form>
            <form method="post" action="">
                <div class="">
                    <table class="table table-hover text-center" id="list">
                    </table>
                </div>
            </form>
        </div>
    </div>

    <!--地区管理 添加弹框开始-->
    <div style="display: none;width: 300px;margin-left:-150px;" class="MsgBox clearfix" id="editBox">
        <div class="top">
            <div class="title" class="MsgTitle">添加/编辑</div>
        </div>
        <div class="body l">
            <form class="alert-form clearfix">
                <div class="form-group">
                    <div class="label">
                        <label>公司：</label>
                    </div>
                    <div class="field">
                        <select class="input company_id" id="companyId">
                            <option value="">请选择公司...</option>
                            @foreach($company as $v)
                            <option value="{{$v->_id}}">{{$v->full_name}}</option>
                            @endforeach
                        </select>
                        <div class="tips"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="label">
                        <label>大区：</label>
                    </div>
                    <div class="field">
                        <select class="input big_area_id" id="bigAreaId">
                            <option value="">请选择大区...</option>
                        </select>
                        <div class="tips"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="label">
                        <label>地区：</label>
                    </div>
                    <div class="field">
                        <input type="text" class="input" id="editAreaName">
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
                {{--<div class="form-group">--}}
                    {{--<div class="label">--}}
                        {{--<label>销售组：</label>--}}
                    {{--</div>--}}
                    {{--<div class="field">--}}
                        {{--<input type="text" class="input">--}}
                        {{--<div class="tips"></div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            </form>
        </div>
        <div class="bottom l" class="MsgBottom" style="height: 60px;">
            <div class="btn MsgBtns">
                <div class="height"></div>
                <input type="button" class="btn" value="确认" id="sureEdit">　<input type="button" class="btn" value="取消" id="cancleEdit">
                <input type="hidden" name="areaid"  id="areaid" value="" />
                <div class="height"></div>
            </div>
        </div>
    </div>
    <!--地区管理 添加弹框结束-->

@stop

@section('adminjs')
<script type="text/javascript">
    var page_cur = 1; //当前页
    var total_num, page_size, page_total_num; //总记录数,每页条数,总页数
    var status
    function getData(page) { //获取当前页数据
        var big_area_id=$("#big_area_id").val();
        var area_name=$("#area_name").val();
        $.ajax({
            type: 'post',
            url: '{{url('admin/area/ajax')}}',
            data: {'page': page, 'action': 'getlist', 'big_area_id': big_area_id, 'area_name': area_name},
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
                    var li = "<tr><th>序号</th><th>公司</th><th>大区</th><th>地区</th><th>启用状态</th><th>操作</th></tr>";
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
                        li +="  <tr><td>"+(page_size*(page_cur-1)+index+1)+"</td><td>"+array.company_name+"</td><td>"+array.big_area_name+"</td><td>"+array.area_name+"</td><td>"+array.status_button+"</td><td width='180'><div class='button-group'><a type='button' class='button border-main' href='javascript:;' onclick='edit(this)' data='"+array._id+"' areaName='"+array.area_name+"' status='"+array.status+"' bigAreaId='"+array.big_area_id+"'><span class='icon-edit'></span>编辑</a></div></td></tr>";
                    });
                    li +="<tr id ='page-tag'></tr>"
//                    page_str=getPageBar();
//                    alert(page_str);
//                    li += page_str;
                    $("#list").append(li);
                    getPageBar();
                } else {
                    $("#list").empty();
                    $("#list").append("<tr><td colspan='14'><div class='pagelist' id='pagelist'></div>暂无数据</tr>");
//                    modelAlert(json.msg);
                }
            },
            complete: function() {
//                getPageBar(); //js生成分页，可用程序代替
//                $('body').hideLoading();
            },
            error: function() {
//                $('body').hideLoading();
                modelAlert("数据异常！");
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
        $("#company_id").val('');
        $("#big_area_id").val('all');
        $("#area_name").val('');
        getData(1);
    });




    function edit(obj){
        $("#companyId").val($(obj).attr('data'));
        $("#areaid").val($(obj).attr('data'));
        $("#editAreaName").val($(obj).attr('areaName'));
        $("#editStatus").val($(obj).attr('status'));
        $("#bigAreaId").val($(obj).attr('bigAreaId'));
        $("#editBox").fadeIn()
    }

    function add(){
        $("#areaid").val('');
        $("#editAreaName").val('');
        $('#bigAreaId option:eq(0)').attr('selected','selected');
        $('#editStatus option:eq(0)').attr('selected','selected');
        $("#areaid").val('');
        $('#editStatus option:eq(0)').attr('selected','selected');
        $("#editBox").fadeIn();
    }

    $("#sureEdit").click(function(){
        var id=$("#areaid").val();
        var company_id=$("#companyId").val();
        var area_name=$("#editAreaName").val();
        var status=$("#editStatus").val();
        var big_area_id=$("#bigAreaId").val();
        if(area_name ==''){
            modelAlert('请输入区域名称!');
            return false;
        }
        $.ajax({
            type: 'post',
            url: '{{url('admin/area/ajax')}}',
            data: {'action': 'edit','id':id,'big_area_id':big_area_id,'company_id':company_id,'status':status,'area_name':area_name },
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            beforeSend: function(XMLHttpRequest) {
//                $('body').showLoading();
            },
            success: function(json) {

                if (json.status == 1) {
                    $("#editBox").fadeOut();
//                    modelAlert(json.msg);
                    window.location.href="{{url("admin/area/index")}}";
                } else {
                    modelAlert(json.msg);
                }
            },
            complete: function() {

            },
            error: function() {
                modelAlert("数据异常！");
            }
        });

    })


    $("#cancleEdit").click(function(){
        $("#editBox").fadeOut();
    })
</script>
@stop