@extends('layouts.home')

@section('title','个人文件')
@section('js')
    <script type="text/javascript" src="{{asset('resources/views/home/static/js/jquery-ui-1.10.4.custom.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/views/home/static/js/jquery.ui.datepicker-zh-CN.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/views/home/static/js/jquery-ui-timepicker-addon.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/views/home/static/js/jquery-ui-timepicker-zh-CN.js')}}"></script>
@endsection
@section('content')
<div class="panel admin-panel">
    <div class="panel-head"><strong>个人文件</strong>
        <div class="pull-right">
            <button class="btn btn-primary btn-addMaterial">上传素材</button>
            {{--<button class="button bg-main" type="button">下载</button>--}}
        </div></div>
    <div class="body-content">
        <form method="post" class="form-x" action="">
            <div class="form-group ml3" style="width:30%;margin-left: 20px;">
                <div class="label">
                    <label>上传时间：</label>
                </div>
                <div class="field" style="width:75%;">
                    <div class="doc-dd">
                        <input name="act_start_time" type="text" class="form-control input w25" value="" placeholder="开始时间" title="开始时间" readonly="readonly" style="cursor:pointer;width: 40%;" id="begin_time"/>

                        <input name="act_stop_time" type="text" class="form-control input w25" value="" placeholder="结束时间" title="结束时间" readonly="readonly" style="cursor:pointer;width: 40%;margin-left:2%;" id="end_time"/>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="label">
                    <label>素材类型：</label>
                </div>
                <div class="field">
                    <select class="form-control input" id="material_type_id">
                        <option value="all">请选择</option>
                        @foreach($materialType as $v)
                        <option value="{{$v->_id}}">{{$v->material_type_name}}</option>
                        @endforeach
                    </select>
                    <div class="tips"></div>
                </div>
            </div>


            <div class="form-group">
                <div class="label">
                    <label>审核状态：</label>
                </div>
                <div class="field">
                    <select class="form-control input" id="check_status">
                        <option value="all">请选择</option>
                        <option value="0">未审核</option>
                        <option value="1">通过</option>
                        <option value="2">未通过</option>
                    </select>
                    <div class="tips"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="label">
                    <label>素材名称：</label>
                </div>
                <div class="field">
                    <input type="text" class="form-control input" name="s_name" value="" id="material_name"/>
                    <div class="tips"></div>
                </div>
            </div>

        </form>

        <form method="post" action="" class="form-x mt20">
            <div class="form-group w100">
                {{--<div class="label">--}}
                    {{--<label>全部素材</label>--}}
                {{--</div>--}}
                <button class="btn btn-primary l mr20" type="button" id="reset" style="margin-left: 20px;">重置</button>
                <button class="btn btn-danger l mr20" type="button" id="search" style="margin-left: 20px;">查询</button>
            </div>
            <div class="clear"></div>
            <div class="panel admin-panel">
                <table class="table table-hover text-center table-striped" id="list">

                </table>
                <div class='pagelist' id='pagelist'></div>
            </div>
        </form>
    </div>
</div>

@endsection


@section('floorjs')
    <script type="text/javascript">
        $( "input[name='act_start_time'],input[name='act_stop_time']" ).datetimepicker();
    </script>
    <script type="text/javascript">
        var page_cur = 1; //当前页
        var total_num, page_size, page_total_num; //总记录数,每页条数,总页数
        function getData(page) { //获取当前页数据
            var material_name=$("#material_name").val();
            var material_type_id=$("#material_type_id").val();
            var begin_time=$("#begin_time").val();
            var end_time=$("#end_time").val();
            var check_status=$("#check_status").val();
//        var pay_status=$("#pay_status").val();
            $.ajax({
                type: 'post',
                url: '{{url('home/userfile/ajax')}}',
                data: {'page': page, 'action': 'getlist', 'material_name': material_name, 'material_type_id': material_type_id, 'begin_time': begin_time, 'end_time': end_time,'check_status': check_status},
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
                        var li = "<thead><tr><th width='120'>ID</th><th>素材名称</th><th>素材类型</th><th>素材数量</th><th>审核状态</th><th>金额</th><th>审核备注</th><th>支付状态</th><th>上传时间</th><th>操作</th></tr></thead><tbody>";
                        var list = json.list;
                        $.each(list, function(index, array) { //遍历返回json
                            showbutton ='';
                            if(array.check_status ==0){
                                array.check_status='未审核';
                                array.pay_amount= 0;
                                showbutton +="<a type='button' class='button border-red' href='javascript:void(0)' onclick='delete1(this)' data='" + array._id + "' style='margin-left:5px;'><span class='icon-money'></span>删除</a>";
                            }else if(array.check_status ==1){
                                array.check_status='审核通过';
                            }else{
                                array.check_status='审核未通过';
                                array.pay_amount=0;
                            }
                            if(array.pay_status !=0){
                                array.pay_status='已支付';
                            }else{
                                array.pay_status='未支付';
                            }
                            {{--var downloadUrl ="{{url('home/userfile/downloadfile/')}}"+"/"+array._id;--}}
                            //                        <input type='checkbox' name='id[]' value='1' />1
                            li +="<tr><td>"+(page_size*(page_cur-1)+index+1)+"</td><td>"+array.material_name+"</td><td >"+array.material_type_name+"</td><td>"+array.attachments+"</td><td>"+array.check_status+"</td><td>"+array.pay_amount+"</td><td>"+array.comment+"</td> <td>"+array.pay_status+"</td> <td>"+array.created_at+"</td><td><div class='button-group'><a type='button' class='button border-main' href='javascript:;' onclick='uploadurl(this)' doctor_id='" + array.doctor_id + "' source_location='" + array.location + "' upload_code='" + array.upload_code + "'><span class='icon-download'>下载</span></a>";
                            li += showbutton +"</div></td></tr>";
                        });

                        li +="</tbody>"
                        $("#list").append(li);
                        getPageBar();
                    } else {
                        $("#list").empty();
                        $("#list").append("<tr><td colspan='14'><div class='pagelist' id='pagelist'></div>暂无数据</tr>");
//                        modelAlert(json.msg);
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
            page_str ="";
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
//            page_str +="</div>";
            $("#pagelist").html(page_str);
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
            $("#material_name").val('');
            $("#material_type_id").val('all');
            $("#begin_time").val('');
            $("#end_time").val('');
            $("#check_status").val('all');
            getData(1);
        });

        function delete1(obj){
            var id=$(obj).attr('data');
            if(!confirm("确定要删除该条素材吗？")){
                return false;
            }
            $.ajax({
                type: 'post',
                url: '{{url('home/userfile/ajax')}}',
                data: {'action': 'delete','id':id},
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                beforeSend: function(XMLHttpRequest) {
//                $('body').showLoading();
                },
                success: function(json) {

                    if (json.status == 1) {
                        window.location.href="{{url("home/userfile/index")}}";
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

        }


        function uploadurl(obj){
            var doctor_id=$(obj).attr('doctor_id');
            var upload_code=$(obj).attr('upload_code');
            $.ajax({
                type: 'post',
                url: '{{url('home/userfile/ajax')}}',
                data: { 'action': 'getuploadurllist', 'doctor_id': doctor_id, 'upload_code': upload_code},
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                beforeSend: function(XMLHttpRequest) {
//                $('body').showLoading();
                },
                success: function(json) {
                    if (json.status == 1) {
                        $("#uploadurllist").empty();
                        var li = "<tr><th>文件名</th><th>下载地址</th></tr>";
                        var list = json.list;
                        $.each(list, function(index, array) { //遍历返回json

                            li +="<tr><td style='max-width:150px;'>"+array.filename+"</td><td><div class='button-group'><a type='button' class='button border-main' href='"+array.url+"'><span class='icon-download'></span>下载</a></div></td></tr>";

                        });
                        $("#uploadurllist").append(li);
                        $("#uploadBox").css('display','block');
                    } else {
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


        function uploadurlclose(){
            $("#uploadBox").css('display','none');

        }
    </script>
@endsection
@section('addDiv')
    <!--附件弹框开始-->
    <div class="MsgBox clearfix" style="display: none;width:400px;left:45%;" id="uploadBox">
        <div class="top">
            <div class="title" class="MsgTitle">素材下载列表</div>
        </div>
        <div class="body l">
            <form method="post" action="" class="alert-form">
                <div class="panel admin-panel">
                    <table class="table table-hover text-center" id="uploadurllist">
                    </table>
                </div>
            </form>
        </div>
        <div class="bottom l" class="MsgBottom" style="height: 60px;">
            <div class="btn MsgBtns">
                <div class="height"></div>
                <button class="btn btn-primary" onclick="uploadurlclose()">关闭</button>
                <div class="height"></div>
            </div>
        </div>
    </div>
    <!--附件弹框结束-->
@endsection


