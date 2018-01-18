@extends('layouts.admin')

@section('title','工具分享')

@section('css')
    @parent
    <link rel="stylesheet" type="text/css" href="{{asset('resources/views/admin/static/css/jquery-ui.css')}}" />
@endsection


@section('content')
    <div class="panel admin-panel">
    <div class="panel-head"><strong><span class="icon-pencil-square-o"></span>工具分享</strong></div>
    <div class="body-content">
        <form method="post" class="form-x" action="">
            <div class="form-group">
                <div class="label">
                    <label for="sitename">文件名称：</label>
                </div>
                <div class="field">
                    <input type="text" class="input form-control" name="stitle" id="file_name" value=""/>
                    <div class="tips"></div>
                </div>
            </div>
            <div class="form-group tool-btns">
                <button class="btn btn-success icon-refresh" type="reset" id="reset" onclick ="return false;">重置</button>
                <button class="btn btn-primary icon-search" type="submit" id="search" onclick ="return false;">查询</button>
                <a href="{{url('admin/tools/toolsadd')}}" class="btn btn-danger icon-upload">上传</a>
                {{--<button class="button bg-main icon-download" type="button">下载 </button>--}}
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

    <!--删除数据弹框开始-->
    <div style="width: 300px; display:none;" class="MsgBox clearfix" id="deleteBox">
    <div class="top">
        <div class="title" class="MsgTitle"> 删除</div>
    </div>
    <div class="body l">
        <p>是否删除该条数据</p>
    </div>
    <div class="bottom l" class="MsgBottom" style="height: 60px;">
        <div class="btn MsgBtns">
            <div class="height"></div>
            <input type="button" class="btn" value="确认" id="sureDelete">　<input type="button" class="btn" value="取消" id="cancleDelete">
            <input type="hidden" name="toolsid"  id="toolsid" value="" />
            <div class="height"></div>
        </div>
    </div>
</div>
    <!--删除数据结束-->
@stop

@section('adminjs')
    <script type="text/javascript">
    var page_cur = 1; //当前页
    var total_num, page_size, page_total_num; //总记录数,每页条数,总页数
    var status
    function getData(page) { //获取当前页数据
        var file_name=$("#file_name").val();
        $.ajax({
            type: 'post',
            url: '{{url('admin/tools/ajax')}}',
            data: {'page': page, 'action': 'getlist', 'file_name': file_name},
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
                    var li = "<tr><th width='50'>ID</th><th>文件名称</th><th>上传时间</th><th>文件大小</th><th>上传进度</th><th>操作</th></tr>";
                    var list = json.list;
                    $.each(list, function(index, array) { //遍历返回json
                        if(array.upload_status ==0){
                            array.upload_status='上传失败';
                        }else{
                            array.upload_status='上传成功';
                        }
                        var downloadUrl ="{{url('admin/tools/downloadfile/')}}"+"/"+array._id;
                        li +="<tr><td>"+(page_size*(page_cur-1)+index+1)+"</td><td>"+array.file_name+"</td> <td>"+array.created_at+"</td><td>"+array.file_weight+"</td><td>"+array.upload_status+"</td><td><div class='button-group'><a type='button' class='button border-main' href='"+downloadUrl+"'><span class='icon-download'></span>下载</a><a type='button' class='button border-red' href='javascript:;' onclick='delete1(this)' data='"+array._id+"'><span class='icon-trash-o'></span>删除</a></div></td></tr>";
                    });
                    li +="<tr id ='page-tag'></tr>"
                    $("#list").append(li);
                    getPageBar();
                } else {
                    $("#list").empty();
                    $("#list").append("<tr><td colspan='14'><div class='pagelist' id='pagelist'></div>暂无数据</tr>");
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
        $("#file_name").val('');
        getData(1);
    });


    function delete1(obj){
        $("#toolsid").val($(obj).attr('data'));
        $('#deleteBox').css('display','block');
    }

    $("#sureDelete").click(function(){
        var id=$("#toolsid").val();
        $.ajax({
            type: 'post',
            url: '{{url('admin/tools/ajax')}}',
            data: {'action': 'delete','id':id },
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            beforeSend: function(XMLHttpRequest) {
//                $('body').showLoading();
            },
            success: function(json) {

                if (json.status == 1) {
                    modelAlert(json.msg);
                    window.location.href="{{url("admin/tools/index")}}";
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


    $("#cancleDelete").click(function(){
        $("#deleteBox").css('display','none');
    })
</script>
@stop