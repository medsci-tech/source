@extends('layouts.admin')

@section('title','素材类型管理')

@section('css')
    @parent
    <link rel="stylesheet" type="text/css" href="{{asset('resources/views/admin/static/css/jquery-ui.css')}}" />
@endsection


@section('content')

    <div class="panel admin-panel">
        <div class="panel-head"><strong><span class="icon-pencil-square-o"></span>素材类型管理</strong></div>
        <div class="body-content">
            <form method="post" class="form-x" action="">
                <div class="form-group">
                    <div class="label">
                        <label for="sitename">素材类型：</label>
                    </div>
                    <div class="field">
                        <input type="text" class="input" name="stitle" value="" id="material_type_name"/>
                        <div class="tips"></div>
                    </div>
                </div>
                <div class="form-group tool-btns">
                    <button class="button bg-main icon-refresh" type="reset" id="reset" onclick ="return false;">重置</button>
                    <button class="button bg-main icon-search" type="submit" id="search" onclick ="return false;">查询</button>
                    <!--<a href="javascript:;" class="button bg-main icon-upload">上传<input class="" type="file"></input></a>-->
                    <button class="button bg-main icon-download" type="button" onclick="add()">添加</button>
                </div>
            </form>
            <form method="post" action="">
                <div class="">

                    <table class="table table-hover text-center" id="list">
                        {{--<tr>--}}
                            {{--<th>序号</th>--}}
                            {{--<th>素材类型</th>--}}
                            {{--<th>启用状态</th>--}}
                            {{--<th>操作</th>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>1</td>--}}
                            {{--<td>视频</td>--}}
                            {{--<td>启用</td>--}}
                            {{--<td><div class="button-group">--}}
                                    {{--<a type="button" class="button border-main" href="#"><span class="icon-edit"></span>编辑</a>--}}
                                    {{--<a type="button" class="button border-red" href="#"><span class="icon-money"></span>禁用</a>--}}
                                {{--</div>--}}
                            {{--</td>--}}
                        {{--</tr>--}}

                        <tr>
                            <td colspan="14"><div class="pagelist"> <a href="">上一页</a> <span class="current">1</span><a href="">2</a><a href="">3</a><a href="">下一页</a><a href="">尾页</a> </div></td>
                        </tr>
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
                        <label>素材类型：</label>
                    </div>
                    <div class="field">
                        <input type="text" class="input" name="edit_material_type_name" id="edit_material_type_name" value="">
                        <div class="tips"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="label">
                        <label>默认价格：</label>
                    </div>
                    <div class="field">
                        <input type="text" class="input" name="edit_material_price" id="edit_material_price" value="">
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
                <input type="button" class="btn" value="确认"  id="sureEdit">　<input type="button" class="btn" value="取消" id="cancleEdit">
                <input type="hidden" name="typeid"  id="typeid" value="" />
            </div>
        </div>
    </div>
    <!--大区管理 添加弹框结束-->
@stop

@section('adminjs')
<script type="text/javascript">
    var page_cur = 1; //当前页
    var total_num, page_size, page_total_num; //总记录数,每页条数,总页数
    var status
    function getData(page) { //获取当前页数据
        var material_type_name=$("#material_type_name").val();
        $.ajax({
            type: 'post',
            url: '{{url('admin/materialtype/ajax')}}',
            data: {'page': page, 'action': 'getlist', 'material_type_name': material_type_name},
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
                    var li = "<tr><th>序号</th><th>素材类型</th><th>素材价格(￥)</th><th>启用状态</th><th>操作</th></tr>";
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
                        li +="<tr><td>"+(page_size*(page_cur-1)+index+1)+"</td><td>"+array.material_type_name+"</td><<td>"+array.price+"</td><td>"+array.status_button+"</td><td><div class='button-group'><a type='button' class='button border-main' href='javascript:;' onclick='edit(this)' data='"+array._id+"' status='"+array.status+"' material_type_name='"+array.material_type_name+"' price='"+array.price+"'><span class='icon-edit'></span>编辑</a></div></td></tr>";
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
        $("#material_type_name").val('');
        getData(1);
    });


    function edit(obj){
        $("#typeid").val($(obj).attr('data'));
        $("#edit_material_type_name").val($(obj).attr('material_type_name'));
        $("#edit_material_price").val($(obj).attr('price'));
        $("#editStatus").val($(obj).attr('status'));
        $("#editBox").css('display','block');
    }

    function add(){
        $("#typeid").val('');
        $("#edit_material_type_name").val('');
        $("#edit_material_price").val(300);
        $("#typeid").val('');
        $('#editStatus option:eq(0)').attr('selected','selected');
        $("#editBox").css('display','block');
    }

    $("#sureEdit").click(function(){
        var id=$("#typeid").val();
        var material_type_name = $("#edit_material_type_name").val();
        var price = $("#edit_material_price").val();
        var status = $("#editStatus").val();
        if(material_type_name ==''){
            alert('请输入素材类型名称!');
            return false;
        }
        $.ajax({
            type: 'post',
            url: '{{url('admin/materialtype/ajax')}}',
            data: {'action': 'edit','id':id,'material_type_name':material_type_name,'price':price,'status':status },
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
                    window.location.href="{{url("admin/materialtype/index")}}";
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