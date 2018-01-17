@extends('layouts.admin')

@section('title','推荐人管理')

@section('content')
    <div class="panel admin-panel">
        <div class="panel-head"><strong><span class="icon-pencil-square-o"></span>推荐人管理</strong></div>
        <div class="body-content">
            <form method="post" class="form-x" action="">
                <div class="form-group w33" style="width:40%">
                    <select class="form-control l input"  id="big_area_id"  style="min-width:110px">
                        <option value="all">大区</option>
                        @foreach($bigarea as $v)
                        <option value="{{$v->_id}}">{{$v->big_area_name}}</option>
                        @endforeach
                    </select>
                    <select class="form-control l input"  id="area_id" style="min-width:110px">
                        <option value="all">地区</option>
                        @foreach($area as $v)
                            <option value="{{$v->_id}}">{{$v->area_name}}</option>
                        @endforeach
                    </select>
                    <select class="form-control l input"  id="sales_id" style="min-width:110px">
                        <option value="all">销售组</option>
                        @foreach($sales as $v)
                            <option value="{{$v->_id}}">{{$v->sales_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group ml3 doctor-w200">
                    <div class="label">
                        <label>推荐人姓名：</label>
                    </div>
                    <div class="field">
                        <input type="text" class="input" name="stitle" value="" id="recommend_name"/>
                        <div class="tips"></div>
                    </div>
                </div>

                <div class="form-group doctor-w200">
                    <div class="label">
                        <label>推荐人手机号：</label>
                    </div>
                    <div class="field">
                        <input type="text" class="input" name="surl" value="" id="recommend_mobile"/>
                    </div>
                </div>

                <div class="form-group w100">
                    <div class="field">
                        <button class="button bg-main icon-plus" type="button" onclick="add()">添加</button>
                        {{--<button class="button bg-main icon-sign-out" type="button">导出</button>--}}
                        <button class="button bg-main icon-refresh" type="reset" id="reset" onclick ="return false;">重置</button>
                        <button class="button bg-main icon-search" type="button" id="search" onclick ="return false;">查询</button>
                    </div>
                </div>
            </form>
            <form method="post" action="">
                <div class="">
                    <table class="table table-hover text-center" id="list">
                        {{--<tr>--}}
                            {{--<th>大区</th>--}}
                            {{--<th>地区</th>--}}
                            {{--<th>销售组</th>--}}
                            {{--<th>推荐人姓名</th>--}}
                            {{--<th>推荐人手机号</th>--}}
                            {{--<th>添加时间</th>--}}
                            {{--<th>操作</th>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>华北大区</td>--}}
                            {{--<td>河北</td>--}}
                            {{--<td>秦皇岛</td>--}}
                            {{--<td>张三</td>--}}
                            {{--<td>13000000001</td>--}}
                            {{--<td>2016-04-12 12:30</td>--}}
                            {{--<td width="180"><div class="button-group">--}}
                                    {{--<a type="button" class="button border-main" href="#"><span class="icon-edit"></span>编辑</a>--}}
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

    <!--推荐人管理 添加弹框开始-->
    <div style="display: none;width: 300px;margin-left:-150px;" class="MsgBox clearfix" id="updateBox">
        <div class="top">
            <div class="title" class="MsgTitle">编辑</div>
        </div>
        <div class="body l">
            <form class="alert-form clearfix">
                <div class="form-group">
                    <div class="label">
                        <label>大区：</label>
                    </div>
                    <div class="field">
                        <select class="input" id="edit_big_area_id">
                            <option value="all">请选择</option>
                            @foreach($bigarea as $v)
                                <option value="{{$v->_id}}">{{$v->big_area_name}}</option>
                            @endforeach
                        </select>
                        <div class="tips"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="label">
                        <label>地区：</label>
                    </div>
                    <div class="field">
                        <select class="input" id="edit_area_id">
                            {{--<option value="all">请选择</option>--}}
                            {{--@foreach($area as $v)--}}
                                {{--<option value="{{$v->_id}}">{{$v->area_name}}</option>--}}
                            {{--@endforeach--}}
                        </select>
                        <div class="tips"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="label">
                        <label>销售组：</label>
                    </div>
                    <div class="field">
                        <select class="input" id="edit_sales_id">
                            {{--<option value="all">请选择</option>--}}
                            {{--@foreach($sales as $v)--}}
                                {{--<option value="{{$v->_id}}">{{$v->sales_name}}</option>--}}
                            {{--@endforeach--}}
                        </select>
                        <div class="tips"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="label">
                        <label>推荐人名称：</label>
                    </div>
                    <div class="field">
                        <input type="text" class="input" id="edit_recommend_name">
                        <div class="tips"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="label">
                        <label>推荐人手机号：</label>
                    </div>
                    <div class="field">
                        <input type="text" class="input" id="edit_recommend_mobile">
                        <div class="tips"></div>
                    </div>
                </div>
                {{--<div class="form-group">
                    <div class="label">
                        <label>推荐人身份证号码：</label>
                    </div>
                    <div class="field">
                        <input type="text" class="input" id="edit_recommend_id_card">
                        <div class="tips"></div>
                    </div>
                </div>--}}

            </form>
        </div>
        <div class="bottom l" class="MsgBottom" style="height: 60px;">
            <div class="btn MsgBtns">
                <div class="height"></div>
                <input type="button" class="btn" value="确认" id="sureEdit">　<input type="button" class="btn" value="取消" id="cancleEdit">
                <input type="hidden" name="recommend_id" id="recommend_id" value="">
                <div class="height"></div>
            </div>
        </div>
    </div>
    <!--推荐人管理 添加弹框结束-->
@stop

@section('adminjs')
    <script type="text/javascript">
        var page_cur = 1; //当前页
        var total_num, page_size, page_total_num; //总记录数,每页条数,总页数
        function getData(page) { //获取当前页数据
            var big_area_id=$("#big_area_id").val();
            var area_id=$("#area_id").val();
            var sales_id=$("#sales_id").val();
            var recommend_name=$("#recommend_name").val();
            var recommend_mobile=$("#recommend_mobile").val();
            $.ajax({
                type: 'post',
                url: '{{url('admin/recommend/ajax')}}',
                data: {'page': page, 'action': 'getlist', 'big_area_id': big_area_id, 'area_id': area_id, 'sales_id': sales_id, 'recommend_name': recommend_name, 'recommend_mobile': recommend_mobile},
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                beforeSend: function(XMLHttpRequest) {
    //                $('body').showLoading();
                },
                success: function(json) {
                    console.log(json);
                    if (json.status == 1) {
                        console.log(json);
    //                    json = json.msg;
                        $("#list").empty();
                        total_num = json.total_num; //总记录数
                        page_size = json.page_size; //每页数量
                        page_cur = page; //当前页
                        page_total_num = json.page_total_num; //总页数businessScope unix_to_datetime(unix);   getLocalTime(parseInt(array.ctime,10)) SProductName out_logi_no
                        var li = "<tr><th>序号</th><th>大区</th><th>地区</th><th>销售组</th><th>推荐人姓名</th><th>推荐人手机号</th><th>添加时间</th><th>操作</th></tr>";
                        var list = json.list;
                        $.each(list, function(index, array) { //遍历返回json
                            li +=" <tr><td>"+(page_size*(page_cur-1)+index+1)+"</td><td>"+array.big_area_name+"</td><td>"+array.area_name+"</td><td>"+array.sales_name+"</td><td>"+array.recommend_name+"</td><td>"+array.recommend_mobile+"</td><td>"+array.created_at+"</td><td width='180'><div class='button-group'><a type='button' class='button border-main' href='javascript:;' onclick='edit(this)' recommend_id='"+array._id+"' edit_big_area_id='"+array.big_area_id+"' edit_area_id='"+array.area_id+"' edit_sales_id='"+array.sales_id+"' edit_recommend_name='"+array.recommend_name+"' edit_recommend_mobile='"+array.recommend_mobile+"' edit_recommend_id_card='"+array.recommend_id_card+"'><span class='icon-edit'></span>编辑</a></div></td></tr>";
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
            $("#big_area_id").val('all');
            $("#area_id").val('all');
            $("#sales_id").val('all');
            $("#recommend_name").val('');
            $("#recommend_mobile").val('');
            getData(1);
        });


        function getRecommend(obj){
            var recommend_id=$(obj).attr('data');
            $('#updateBox').css('display','block');
            $('#recommend_id').val(recommend_id);
            $.ajax({
                type: 'post',
                url: '{{url('admin/recommend/ajax')}}',
                data: {'action': 'getRecommendInfo','recommend_id':recommend_id},
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                beforeSend: function(XMLHttpRequest) {
    //                $('body').showLoading();
                },
                success: function(json) {
                    if (json.status == 1) {
                        var data =json.list;
                        $("#edit_recommend_name").val(data.recommend_name);
                        $("#edit_recommend_mobile").val(data.recommend_mobile);
    //                    $("#edit_recommend_name").attr('readonly','readonly');
                        $("#edit_big_area_id").val(data.big_area_id);
                        $("#edit_area_id").val(data.area_id);
                        $("#edit_sales_id").val(data.sales_id);
                        $("#edit_recommend_id_card").val(data.recommend_id_card);

                    }else{
                        modelAlert(json.msg);
                    }
                },
                complete: function() {

                },
                error: function() {
                    modelAlert("服务器繁忙！");
                }
            });
        }


        function edit(obj){
            $("#recommend_id").val($(obj).attr('recommend_id'));
            $("#edit_recommend_name").val($(obj).attr('edit_recommend_name'));
            $("#edit_recommend_mobile").val($(obj).attr('edit_recommend_mobile'));
            $("#edit_big_area_id").val($(obj).attr('edit_big_area_id'));
            $("#edit_area_id").empty();
            $("#edit_sales_id").empty();
            $("#edit_area_id").val($(obj).attr('edit_area_id'));
            $("#edit_sales_id").val($(obj).attr('edit_sales_id'));
            $("#edit_recommend_id_card").val($(obj).attr('edit_recommend_id_card'));
            $("#updateBox").css('display','block');
        }

        function add(){
            $("#recommend_id").val('');
            $("#edit_recommend_name").val('');
            $("#edit_recommend_mobile").val('');
            $("#edit_recommend_id_card").val('');
            $('#edit_big_area_id option:eq(0)').attr('selected','selected');
            $('#edit_area_id option:eq(0)').attr('selected','selected');
            $('#edit_sales_id option:eq(0)').attr('selected','selected');
            $("#updateBox").css('display','block');
        }




        $("#sureEdit").click(function(){
            var recommend_mobile = $("#edit_recommend_mobile").val();
            var recommend_name = $("#edit_recommend_name").val();
            var big_area_id = $("#edit_big_area_id").val();
            var area_id = $("#edit_area_id").val();
            var sales_id = $("#edit_sales_id").val();
            var recommend_id_card = $("#edit_recommend_id_card").val();
            var recommend_id =$("#recommend_id").val();

            if(big_area_id =='all'){
                modelAlert('请选择大区!');
                return false;
            }
            if(area_id =='all'){
                modelAlert('请选择地区!');
                return false;
            }
            if(sales_id =='all'){
                modelAlert('请选择销售组!');
                return false;
            }
            if(recommend_name ==''){
                modelAlert('请输入推荐人姓名!');
                return false;
            }

            if(recommend_mobile ==''){
                modelAlert('请输入推荐人手机号码!');
                return false;
            }
            /*if(recommend_id_card ==''){
                modelAlert('请输入推荐人身份证号!');
                return false;
            }*/
            $.ajax({
                type: 'post',
                url: '{{url('admin/recommend/ajax')}}',
                data: {'action': 'updateRecommend','recommend_id':recommend_id,'recommend_mobile':recommend_mobile,'recommend_name':recommend_name,'big_area_id':big_area_id,'area_id':area_id,'sales_id':sales_id,/*'recommend_id_card':recommend_id_card,*/},
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                beforeSend: function(XMLHttpRequest) {
    //                $('body').showLoading();
                },
                success: function(json) {
                    if (json.status == 1) {
    //                    $("#updateBox").css('display','none');
//                        modelAlert(json.msg);
                        window.location.href="{{url("admin/recommend/index")}}";
                    }else{
                        modelAlert(json.msg);
                    }
                },
                complete: function() {

                },
                error: function() {
                    modelAlert("服务器繁忙！");
                }
            });
        })

        $("#cancleEdit").click(function(){
            $("#updateBox").css('display','none');
        })



    </script>


    <script>

    $("#edit_big_area_id").change(function(){
        var edit_big_area_id=$("#edit_big_area_id").val();
        var big_area_id =$(this).val();
        if(big_area_id =="all"){
            return false;
        }
        $.ajax({
            type: 'post',
            url: '{{url('admin/recommend/ajax')}}',
            data: {'action': 'getArea','big_area_id':edit_big_area_id},
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
                    $("#edit_area_id").empty();
                    li="";
                    $.each(data, function(index, value) {
                        li +="<option value='"+value._id+"'>"+value.area_name+"</option>";
                    })
                    $("#edit_area_id").append(li);
                    $("#edit_area_id").trigger('change');
                } else {
                    modelAlert("非法的请求!");
                }
            },
            complete: function() {

            },
            error: function() {
                modelAlert("服务器繁忙！");
            }
        });
    })

    $("#edit_area_id").change(function(){
        var area_id =$(this).val();
        $.ajax({
            type: 'post',
            url: '{{url('admin/recommend/ajax')}}',
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
                    $("#edit_sales_id").empty();
                    li="";
                    $.each(data, function(index, value) {
                        li +="<option value='"+value._id+"'>"+value.sales_name+"</option>";
                    })
                    $("#edit_sales_id").append(li);
                } else {
                    modelAlert("非法的请求!");
                }
            },
            complete: function() {

            },
            error: function() {
                modelAlert("服务器繁忙！");
            }
        });
    })
</script>
@stop