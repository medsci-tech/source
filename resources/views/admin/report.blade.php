@extends('layouts.admin')

@section('title','报表管理')

@section('css')
    @parent
    <link rel="stylesheet" type="text/css" href="{{asset('resources/views/admin/static/css/jquery-ui.css')}}" />
@endsection

@section('js')
    <script src="{{asset('resources/views/admin/static/js/distpicker.data.js')}}"></script>
    <script src="{{asset('resources/views/admin/static/js/distpicker.js')}}"></script>
    <script src="{{asset('resources/views/admin/static/js/main.js')}}"></script>
@endsection


@section('content')
    <div class="panel admin-panel">
    <div class="panel-head"><strong><span class="icon-pencil-square-o"></span>报表管理</strong></div>
    <div class="body-content">
        <form method="get" class="form-x" action="">

            {{--按素材搜索--}}
            <div class="w100 clearfix">
                <div class="w100 clearfix">
                    <div class="form-group">
                        <div class="field" style="margin-top:3px;width: 20px;">
                            <input type="radio" class="input r" checked ="checked" name="s_name" value="all"/>
                            <div class="tips"></div>
                        </div>
                        <div class="label">
                            <label>默认</label>
                        </div>
                    </div>
                </div>

                <div class="form-group" style="width:35%">
                    <div class="label">
                        <label>上传时间：</label>
                    </div>
                    <div class="field" style="width:80%">
                        <input name="act_start_time" type="text" class="input w25" value="" placeholder="开始时间" title="开始时间" readonly="readonly" style="cursor:pointer;" id="begin_time" />
                        <input  style="margin-left:2%;" name="act_stop_time" type="text" class="input w25" value="" placeholder="结束时间" title="结束时间" readonly="readonly" style="cursor:pointer;" id="end_time"/>
                    </div>
                </div>
            </div>


                <div class="w100 clearfix">
                    <div class="w100 clearfix">
                    <div class="form-group">
                        <div class="field" style="margin-top:3px;width: 20px;">
                            <input type="radio" class="input r" name="s_name" value="material"/>
                            <div class="tips"></div>
                        </div>
                        <div class="label">
                            <label>按素材搜索</label>
                        </div>

                    </div>
                    </div>

                <div class="form-group">
                    <div class="label">
                        <label>素材名称：</label>
                    </div>
                    <div class="field">
                        <input type="text" class="input" name="material_name" id="material_name" value=""/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="label">
                        <label>素材类型：</label>
                    </div>
                    <div class="field">
                        <select class="input l" id="material_type_id">
                            <option value="all" selected="selected">请选择</option>
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
                        <select class="input l input" id="check_status">
                            <option value="all" selected="selected">请选择</option>
                            <option value="0">未审核</option>
                            <option value="1">审核通过</option>
                            <option value="2">审核未通过</option>
                        </select>
                        <div class="tips"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="label">
                        <label>支付状态：</label>
                    </div>
                    <div class="field">
                        <select class="input l" id="pay_status">
                            <option value="all" selected="selected">请选择</option>
                            <option value="1">已支付</option>
                            <option value="0">未支付</option>
                        </select>
                        <div class="tips"></div>
                    </div>
                </div>
            </div>

            {{--按医生搜索--}}
            <div class="w100 clearfix">
                <div class="w100 clearfix">
                    <div class="form-group">
                        <div class="field" style="margin-top:3px;width: 20px;">
                            <input type="radio" class="input r" name="s_name" value="doctor"/>
                            <div class="tips"></div>
                        </div>
                        <div class="label">
                            <label>按医生搜索</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="label">
                        <label>医生名称：</label>
                    </div>
                    <div class="field">
                        <input type="text" class="input" name="doctor_name" id="doctor_name" value=""/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="label">
                        <label>医生手机号：</label>
                    </div>
                    <div class="field">
                        <input type="text" class="input" name="doctor_mobile" id="doctor_mobile" value=""/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="label">
                        <label>身份证号：</label>
                    </div>
                    <div class="field">
                        <input type="text" class="input" name="doctor_id_card" id="doctor_id_card" value=""/>
                    </div>
                </div>
            </div>

            {{--推荐人--}}
            <div class="w100 clearfix">
                <div class="form-group">
                 <div class="field" style="margin-top:3px;width: 20px;">
                   <input type="radio" class="input r" name="s_name" value="recommend"/>
                   <div class="tips"></div>
                 </div>
                 <div class="label">
                   <label>按推荐人搜索</label>
                  </div>
                </div>
            </div>
                <div class="form-group w33" style="width:40%">

                    <select class="form-control l input"  id="company_id"  style="min-width:110px">
                        <option value="all">公司</option>
                        @foreach($company as $v)
                            <option value="{{$v->_id}}">{{$v->full_name}}</option>
                        @endforeach
                    </select>
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
                <div class="form-group">
                    <div class="label">
                        <label>推荐人姓名：</label>
                    </div>
                    <div class="field">
                        <input type="text" class="input" name="recommend_name" value="" id="recommend_name"/>
                        <div class="tips"></div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="label">
                        <label>推荐人手机号：</label>
                    </div>
                    <div class="field">
                        <input type="text" class="input" name="recommend_mobile" value="" id="recommend_mobile"/>
                    </div>
                </div>

            {{--<div class="w100 clearfix">--}}
                {{--<div class="form-group">--}}
                    {{--<div class="field" style="margin-top:3px;width: 20px;">--}}
                        {{--<input type="radio" class="input r" name="s_name" value="hospital"/>--}}
                        {{--<div class="tips"></div>--}}
                    {{--</div>--}}
                    {{--<div class="label">--}}
                        {{--<label>按医院搜索</label>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}

                {{--<div class="form-group">--}}
                    {{--<div class="label">--}}
                        {{--<label>医院名称：</label>--}}
                    {{--</div>--}}
                    {{--<div class="field">--}}
                        {{--<input type="text" class="input" name="hospital_name" value="" id="hospital_name"/>--}}
                        {{--<div class="tips"></div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="form-group">--}}
                    {{--<select class="form-control l input" id="hospital_level_id">--}}
                        {{--<option value="all">医院级别</option>--}}
                        {{--<option value="1">二甲医院</option>--}}
                        {{--<option value="2">三甲医院</option>--}}
                    {{--</select>--}}
                {{--</div>--}}


            {{--</div>--}}




            <div class="form-group w100">
                <div class="label">
                    <label></label>
                </div>
                <div class="field">
                    <button class="button bg-main icon-refresh" type="submit" id="reset" onclick ="return false;"> 重置</button>
                    <button class="button bg-main icon-search" type="submit" id="search" onclick ="return false;"> 查询</button>
                    <a  href="{{url('admin/report/reportexcel')}}"class="button bg-main icon-download" type="submit">下载报表</a>
                </div>
            </div>
        </form>
        <form method="post" action="">
            <div class="" style="overflow-x: auto">
                <table style="white-space: nowrap; " class="table table-hover text-center table-responsive" id="list">

                </table>
            </div>
        </form>
        <div class="panel admin-panel" id="page_bar" style="text-align: center;">
            <div class='pagelist' id='pagelist'></div>暂无数据
        </div>
    </div>
</div>
@stop


@section('adminjs')
    <script type="text/javascript">
        $( "input[name='act_start_time'],input[name='act_stop_time']" ).datetimepicker();
    </script>

    <script>
        $("#distpicker5").distpicker({
            autoSelect: false
        });
    </script>


    <script type="text/javascript">
    var page_cur = 1; //当前页
    var total_num, page_size, page_total_num; //总记录数,每页条数,总页数
    var status
    function getData(page) { //获取当前页数据
        var material_name=$("#material_name").val();
        var material_type_id=$("#material_type_id").val();
        var check_status=$("#check_status").val();
        var pay_status=$("#pay_status").val();

        var doctor_name=$("#doctor_name").val();
        var doctor_mobile=$("#doctor_mobile").val();
        var doctor_id_card=$("#doctor_id_card").val();

        var company_id=$("#company_id").val();
        var big_area_id=$("#big_area_id").val();
        var area_id=$("#area_id").val();
        var sales_id=$("#sales_id").val();
        var recommend_name=$("#recommend_name").val();
        var recommend_mobile=$("#recommend_mobile").val();

//        var hospital_name=$("#hospital_name").val();
//        var hospital_level_id=$("#hospital_level_id").val();  begin_time
        var begin_time=$("#begin_time").val();
        var end_time=$("#end_time").val();

        var searchType=$('input:radio:checked').val() ? $('input:radio:checked').val() : 'all';
        $.ajax({
                type: 'post',
                url: '{{url('admin/report/ajax')}}',
            data: {'page': page, 'action': 'getlist','material_name':material_name,'material_type_id':material_type_id,'check_status':check_status,'pay_status':pay_status,'doctor_name':doctor_name,'doctor_mobile':doctor_mobile,'id_card':doctor_id_card,'company_id':company_id,'big_area_id':big_area_id,'area_id':area_id,'sales_id':sales_id,'recommend_name':recommend_name,'recommend_mobile':recommend_mobile,'searchType':searchType,'begin_time':begin_time,'end_time':end_time},
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
                $("#list").empty();
                total_num = json.total_num; //总记录数
                page_size = json.page_size; //每页数量
                page_cur = page; //当前页
                page_total_num = json.page_total_num; //总页数businessScope unix_to_datetime(unix);   getLocalTime(parseInt(array.ctime,10)) SProductName out_logi_no pay_amount
                var li = "<tr> <th width='50'>ID</th> <th>医生姓名</th> <th>医生手机号</th> " +
                        "<th>医生省市区</th><th>医生医院</th><th>医生身份证号</th><th>医生开户行</th><th>医生银行卡号</th>" +
                        "<th>上传时间</th> <th>素材名称</th><th>素材类型</th><th>素材数量</th><th>公司</th><th>大区</th><th>区域</th><th>销售组</th><th>推荐人姓名</th><th>推荐人手机号</th><th>审核状态</th><th>支付金额</th><th>审核通过个数</th><th>支付状态</th><th>备注</th></tr>";
                var list = json.list;
                $.each(list, function(index, array) { //遍历返回json
                    if(array.check_status ==0){
                        array.check_status='未审核';
                        array.pay_amount=0;
                    }else if(array.check_status ==1){
                        array.check_status='审核通过';
                    }else{
                        array.check_status='审核未通过';
                    }
                    if(array.pay_status != 0){
                        array.pay_status='已支付';
                    }else{
                        array.pay_status='未支付';
                    }
                    li +="<tr>";
                    li +="<td>"+(page_size*(page_cur-1)+index+1)+"</td><td>"+array.doctor_name+"</td><td>"+array.doctor_mobile+"</td>" +
                            "<td>"+array.doctor_province+array.doctor_city+array.doctor_region+"</td><td>"+array.doctor_hospital+"</td><td>"+array.doctor_id_card+"</td><td>"+array.doctor_bank_name+"</td><td>"+array.doctor_bank_card_no+"</td>" +
                            "<td>"+array.created_at+"</td><td>"+array.material_name+"</td><td>"+array.material_type_name+"</td><td>"+array.attachments+"</td><td>"+array.company_name+"</td><td>"+array.big_area_name+"</td><td>"+array.area_name+"</td><td>"+array.sales_name+"</td><td>"+array.recommend_name+"</td><td>"+array.recommend_mobile+"</td><td>"+array.check_status+"</td><td>"+array.pay_amount+"</td><td>"+array.pass_amount+"</td><td>"+array.pay_status+"</td><td>"+array.comment+"</td>";
                    li +="</tr>";
                });
                li +="<tr><td colspan='6'>已支付金额</td><td colspan='6'>"+json.hasPayAmount+"</td><td colspan='6'>预支付金额</td><td colspan='5'>"+json.waitPayAmount+"</td></tr>";
//                li +="<tr id ='page-tag'></tr>";

                $("#list").append(li);
                getPageBar();
            } else {
                $("#list").empty();
                $("#page_bar").html("<div class='pagelist' id='pagelist'></div>暂无数据");

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
        page_str ="<div class='pagelist' id='pagelist'>";
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
        page_str +="</div>";
        $("#page_bar").html(page_str);
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
        $("#material_name").val('');
        $("#material_type_id").val('all');
        $("#begin_time").val('');
        $("#end_time").val('');
        $("#recommend_name").val('');
        $("#recommend_mobile").val('');
        $("#check_status").val('all');
        $("#pay_status").val('all');
        getData(1);
    });
</script>
@stop