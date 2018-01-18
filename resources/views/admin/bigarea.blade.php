@extends('layouts.admin')

@section('title','大区管理')


@section('content')
    <div class="panel admin-panel">
        <div class="panel-head"><strong><span class="icon-pencil-square-o"></span>大区管理</strong></div>
        <div class="body-content">
            <form method="post" class="form-x" action="">
                <div class="form-group">
                    <div class="label" style="float: left;">
                        <label>公司：</label>
                    </div>
                    <div class="field" style="float: left;">
                        <select class="input form-control" name="company_id" id="company_id">
                            <option value="">请选择公司...</option>
                            @foreach($company as $v)
                            <option value="{{ $v->_id }}">{{ $v->full_name }}</option>
                            @endforeach
                        </select>
                        <div class="tips"></div>
                    </div>
                </div>
                <div class="form-group  tool-btns">
                    <button class="btn btn-success icon-refresh" type="reset" id="reset" onclick ="return false;">重置</button>
                    <button class="btn btn-primary icon-search" type="button" id="search" onclick ="return false;">查询</button>
                    <button class="btn btn-danger icon-plus" type="button" onclick="add()">添加</button>
                </div>
            </form>
            <form method="post" action="">
                <div class="">
                    <table class="table table-hover text-center" id="list">
                        {{--<tr>--}}
                            {{--<th>序号</th>--}}
                            {{--<th>大区</th>--}}
                            {{--<th>启用状态</th>--}}
                            {{--<th>操作</th>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>1</td>--}}
                            {{--<td>华北大区</td>--}}
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


    <!--大区管理 添加弹框开始-->
    <div style="display: none;width: 300px;margin-left:-150px;" class="MsgBox clearfix" id="editBox">
        <div class="top">
            <div class="title" class="MsgTitle">添加/编辑</div>
        </div>
        <div class="body l">
            <form class="alert-form clearfix">
                <div class="form-group">
                    <div class="label">
                        <label>大区：</label>
                    </div>
                    <div class="field">
                        <input type="text" class="input" id="editAreaName">
                        <div class="tips"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="label">
                        <label>公司：</label>
                    </div>
                    <div class="field">
                        <select class="input" name="company_id" id="editcompanyId">
                            @foreach($company as $v)
                                <option value="{{ $v->_id }}">{{ $v->full_name }}</option>
                            @endforeach
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
        <div class="bottom l" class="MsgBottom" style="height: 60px;">
            <div class="btn MsgBtns">
                <div class="height"></div>
                <input type="button" class="btn" value="确认" id="sureEdit">　<input type="button" class="btn" value="取消" id="cancleEdit">
                <input type="hidden" name="bigAreaid"  id="bigAreaid" value="" />
                <div class="height"></div>
            </div>
        </div>
    </div>
    <!--大区管理 添加弹框结束-->
@stop


@section('adminjs')
    <script type="text/javascript">
    var page_cur = 1; //当前页
    var total_num, page_size, page_total_num; //总记录数,每页条数,总页数
    function getData(page) { //获取当前页数据
        var company_id=$("#company_id").val();
        $.ajax({
            type: 'post',
            url: '{{url('admin/bigarea/ajax')}}',
            data: {'page': page, 'action': 'getlist', 'company_id': company_id},
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
                    var li = "<tr><th>序号</th><th>大区</th><th>公司</th><th>启用状态</th><th>操作</th></tr>";
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
                        li +="   <tr><td>"+(page_size*(page_cur-1)+index+1)+"</td><td>"+array.big_area_name+"</td><td>"+array.company+"</td><td>"+array.status_button+"</td><td width='180'><div class='button-group'><a type='button' class='button border-main' href='javascript:;' onclick='edit(this)' data='"+array._id+"' areaName='"+array.big_area_name+"' companyId='"+array.company_id+"' status='"+array.status+"'><span class='icon-edit'></span>编辑</a></div></td></tr>";
                    });
                    li +="<tr id ='page-tag'></tr>"
                    $("#list").append(li);
                    getPageBar();
                } else {
                    $("#list").empty();
                    $("#list").append("<tr><td colspan='5'><div class='pagelist' id='pagelist'></div>暂无数据</tr>");
                    modelAlert(json.msg);
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
        page_str ="<td colspan='5'><div class='pagelist' id='pagelist'>";
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
        getData(1);
    });



    function edit(obj){
        $("#bigAreaid").val($(obj).attr('data'));
        $("#editAreaName").val($(obj).attr('areaName'));
        $("#editcompanyId").val($(obj).attr('companyId'));
        $("#editStatus").val($(obj).attr('status'));
        $("#editBox").css('display','block');
    }

    function add(){
        $("#bigAreaid").val('');
        $("#editAreaName").val('');
        $("#bigAreaid").val('');
        $('#editStatus option:eq(0)').attr('selected','selected');
        $("#editBox").css('display','block');
    }

    $("#sureEdit").click(function(){
        var id=$("#bigAreaid").val();
        var big_area_name=$("#editAreaName").val();
        var companyId=$("#editcompanyId").val();
        var status=$("#editStatus").val();
        if(!big_area_name || !companyId){
            modelAlert('请填写完整信息!');
            return false;
        }
        $.ajax({
            type: 'post',
            url: '{{url('admin/bigarea/ajax')}}',
            data: {'action': 'edit','id':id,'big_area_name':big_area_name,'company_id':companyId,'status':status },
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
                    window.location.href="{{url("admin/bigarea/index")}}";
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
        $("#editBox").css('display','none');
    })
</script>
@stop