@extends('layouts.admin')

@section('title','素材管理')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('resources/views/admin/static/css/jquery-ui.css')}}" />
@endsection


@section('content')
    <div class="panel admin-panel">
        <div class="panel-head"><strong><span class="icon-pencil-square-o"></span>素材管理</strong></div>
        <div class="body-content">
            <form method="post" class="form-x" action="">
                <div class="form-group ml3">
                <div class="label">
                <label>医生姓名：</label>
                </div>
                <div class="field">
                <input type="text" class="input" name="stitle" id="doctor_name" value=""/>
                <div class="tips"></div>
                </div>
                </div>
                {{--<div class="form-group">--}}
                {{--<div class="label">--}}
                {{--<label>医生手机号：</label>--}}
                {{--</div>--}}
                {{--<div class="field">--}}
                {{--<input type="text" class="input" name="surl" id="doctor_mobile"  value=""/>--}}
                {{--</div>--}}
                {{--</div>--}}
                <div class="form-group">
                    <div class="label">
                        <label>素材名称：</label>
                    </div>
                    <div class="field">
                        <input type="text" class="input" name="surl" id="material_name"  value=""/>
                    </div>
                </div>
                {{--<div class="form-group">--}}
                {{--<div class="label">--}}
                {{--<label>素材名称：</label>--}}
                {{--</div>--}}
                {{--<div class="field">--}}
                {{--<input type="text" class="input" name="sentitle"  id="doctor_name"  value=""/>--}}
                {{--<div class="tips"></div>--}}
                {{--</div>--}}
                {{--</div>--}}
                <div class="form-group">
                    <div class="label">
                        <label>素材类型：</label>
                    </div>
                    <div class="field">
                        <select class="input" id="material_type_id">
                            <option value="all" selected="selected">请选择</option>
                            @foreach($materialType as $v)
                                <option value="{{$v->_id}}">{{$v->material_type_name}}</option>
                            @endforeach
                        </select>
                        <div class="tips"></div>
                    </div>
                </div>
                <div class="form-group ml3" style="width:25%">
                    <div class="label">
                        <label>上传时间：</label>
                    </div>
                    <div class="field" style="width:70%">
                        <div class="doc-dd">
                            <input name="act_start_time" type="text" class="input w25" value="" placeholder="开始时间" title="开始时间" readonly="readonly" style="cursor:pointer;" id="begin_time" />
                            <input  style="margin-left:2%;" name="act_stop_time" type="text" class="input w25" value="" placeholder="结束时间" title="结束时间" readonly="readonly" style="cursor:pointer;" id="end_time"/>
                        </div>
                    </div>
                </div>
                {{--<div class="form-group">--}}
                {{--<div class="label">--}}
                {{--<label>推荐人姓名：</label>--}}
                {{--</div>--}}
                {{--<div class="field">--}}
                {{--<input type="text" class="input" name="s_name" id="recommend_name" value=""/>--}}
                {{--<div class="tips"></div>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="form-group">--}}
                {{--<div class="label">--}}
                {{--<label>推荐人手机号：</label>--}}
                {{--</div>--}}
                {{--<div class="field">--}}
                {{--<input type="text" class="input" name="s_name" id="recommend_mobile" value=""/>--}}
                {{--<div class="tips"></div>--}}
                {{--</div>--}}
                {{--</div>--}}
                <div class="form-group">
                    <div class="label">
                        <label>审核状态：</label>
                    </div>
                    <div class="field">
                        <select class="input" id="check_status">
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
                        <select class="input" id="pay_status">
                            <option value="all" selected="selected">请选择</option>
                            <option value="1">已支付</option>
                            <option value="0">未支付</option>
                        </select>
                        <div class="tips"></div>
                    </div>
                </div>

                <div class="form-group w100">
                    <div class="label">
                        <label></label>
                    </div>
                    <div class="field">
                        <button class="button bg-main icon-check-square-o" type="submit" id="reset" onclick ="return false;"> 重置</button>
                        <button class="button bg-main icon-search" type="submit" id="search" onclick ="return false;"> 查询</button>
                        {{--<button class="button bg-main icon-download" type="submit"> 下载</button>--}}
                    </div>
                </div>
            </form>
            <form method="post" action="">
                <div class="panel admin-panel">
                    <!--<div class="panel-head"><strong class="icon-reorder"> 留言管理</strong></div>-->
                    <!--<div class="padding border-bottom">-->
                    <!--<ul class="search">-->
                    <!--<li>-->
                    <!--<button type="button"  class="button border-green" id="checkall"><span class="icon-check"></span> 全选</button>-->
                    <!--<button type="submit" class="button border-red"><span class="icon-trash-o"></span> 批量删除</button>-->
                    <!--</li>-->
                    <!--</ul>-->
                    <!--</div>-->
                    <table class="table table-hover text-center">
                        <thead>
                            <tr>
                                <th width='50'><input type='checkbox' class='check_all' /></th>
                                <th width='50'>ID</th>
                                <th>医生姓名</th>
                                <th>医生手机号</th>
                                <th>上传时间</th>
                                <th>大区</th>
                                <th>地区</th>
                                <th>销售组</th>
                                <th style='width:10%;'>素材名称</th>
                                <th>素材类型</th>
                                <th>素材数量</th>
                                <th>推荐人姓名</th>
                                <th>推荐人手机号</th>
                                <th>审核状态</th>
                                <th>审核通过个数</th>
                                <th>支付状态</th>
                                <th>备注</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody  id="list"></tbody>
                    </table>
                    <div id ='page-tag'>
                        <div class="pull-left" style="width:320px;padding: 10px">
                            <select name='options' class='options'>
                                <option value=''>请选择操作类型</option>
                                <option value='confirm_check'>全部通过</option>
                                <option value='refuse_check'>全部不通过</option>
                                <option value='pay_all'>全部支付</option>
                            </select>
                            <button class="opt_confirm" style="padding: 5px 12px;">确定</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection


@section('addDiv')
    <!--审核弹框开始-->
    <div style="width: 300px; display: none;" class="MsgBox clearfix" id="checkbox">
        <div class="top">
            <div class="title" class="MsgTitle">审核</div>
        </div>
        <div class="body l">
            <form class="alert-form clearfix">
                <div class="form-group mt12">
                    <div class="label">
                        <label>审核：</label>
                    </div>
                    <div class="field">
                        <select class="input" id="check_status_box">
                            <option value="1">通过</option>
                            <option value="2">不通过</option>
                        </select>
                        <div class="tips"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="label">
                        <label>通过素材数：</label>
                    </div>
                    <div class="field">
                        <input type="text" name="pass_amount_box"  id="pass_amount_box" valeu="">
                        {{--<select class="input" id="pass_amount_box">--}}
                        {{--<option value="1">1</option>--}}
                        {{--<option value="2">2</option>--}}
                        {{--<option value="3">3</option>--}}
                        {{--<option value="4">4</option>--}}
                        {{--<option value="5">5</option>--}}
                        {{--<option value="6">6</option>--}}
                        {{--<option value="7">7</option>--}}
                        {{--<option value="8">8</option>--}}
                        {{--<option value="9">9</option>--}}
                        {{--<option value="10">10</option>--}}
                        {{--</select>--}}
                        <div class="tips"></div>
                    </div>
                </div>
                <textarea name="comment" id="comment" class="infotextarea"></textarea>
            </form>
        </div>
        <div class="bottom l" class="MsgBottom" style="height: 45px;">
            <div class="btn MsgBtns">
                <div class="height"></div>
                <input type="button" class="btn" value="确认" id="checkboxSure">　<input type="button" id="checkboxCancle" class="btn" value="取消">
                <input type="hidden" name="check_pay_amount"  id="check_pay_amount" value="" />
                <input type="hidden" name="max_pass_amount"  id="max_pass_amount" value="" />
            </div>
        </div>
    </div>
    <!--审核弹框结束-->

    <!--附件弹框开始-->
    <div style="display: none;width:400px;left:45%;top:25%;" class="MsgBox clearfix" id="uploadBox">
        <div class="top">
            <div class="title" class="MsgTitle">素材下载列表</div>
        </div>
        <div class="body l">
            <form method="post" action="" class="alert-form">
                <div class="panel admin-panel">
                    <table class="table table-hover text-center" id="uploadurllist">
                        {{--<tr>--}}
                        {{--<th>文件名</th>--}}
                        {{--<th>下载地址</th>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                        {{--<td>xxx</td>--}}
                        {{--<td>--}}
                        {{--<div class="button-group">--}}
                        {{--<a type="button" class="button border-main" href="#"><span class="icon-download"></span>下载</a>--}}

                        {{--</div>--}}
                        {{--</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                        {{--<td>xxx</td>--}}
                        {{--<td>--}}
                        {{--<div class="button-group">--}}
                        {{--<a type="button" class="button border-main" href="#"><span class="icon-download"></span>下载</a>--}}

                        {{--</div>--}}
                        {{--</td>--}}
                        {{--</tr>--}}
                    </table>
                </div>
            </form>
        </div>
        <div class="bottom l" class="MsgBottom" style="height: 45px;">
            <div class="btn MsgBtns">
                <div class="height"></div>
                <input type="button" class="btn" value="关闭" onclick="uploadurlclose()">
                <input type="hidden" name="checkid"  id="checkid" value="" />
            </div>
        </div>
    </div>
    <!--附件弹框结束-->

    <!--支付据弹框开始-->
    <div style="width: 300px;display:none;" class="MsgBox clearfix" id="paybox">
        <div class="top">
            <div class="title" class="MsgTitle">支付</div>
        </div>
        <div class="body l">
            <p>您确认支付/取消支付该素材吗?</p>
            <form class="alert-form clearfix">
                <div class="form-group">
                    <div class="label" style="width:25%;margin-left:15%">
                        <label>支付价格：</label>
                    </div>
                    <div class="field">
                        <input type="text" class="input" id="pay_amount">
                        <div class="tips"></div>
                    </div>
                </div>
            </form>
            {{--支付价格:<input type="text" class="input" id="editAreaName" style="width:50%;">--}}
        </div>
        {{--<div class="body l">--}}
        {{--<div class="form-group">--}}
        {{--<div class="label">--}}
        {{--<label>地区：</label>--}}
        {{--</div>--}}
        {{--<div class="field">--}}
        {{--<input type="text" class="input" id="editAreaName">--}}
        {{--<div class="tips"></div>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--<div class="form-group">--}}
        {{--<div class="label">--}}
        {{--<label>地区：</label>--}}
        {{--</div>--}}
        {{--<div class="field">--}}
        {{--<input type="text" class="input" id="editAreaName">--}}
        {{--<div class="tips"></div>--}}
        {{--</div>--}}
        {{--</div>--}}
        <div class="bottom l" class="MsgBottom" style="height: 45px;">
            <div class="btn MsgBtns">
                <div class="height"></div>
                <input type="button" class="btn" value="确认" id="paySure">　<input type="button" class="btn" value="取消" id="payCancle">
                <input type="hidden" name="payid"  id="payid" value="" />
                <input type="hidden" name="paystatus"  id="paystatus" value="" />
            </div>
        </div>
    </div>
    <!--支付弹框结束-->
@endsection



@section('adminjs')
    <script type="text/javascript">
        $( "input[name='act_start_time'],input[name='act_stop_time']" ).datetimepicker();
    </script>


    <script type="text/javascript">
        var page_cur = 1; //当前页
        var total_num, page_size, page_total_num; //总记录数,每页条数,总页数
        var status;

        function getData(page) { //获取当前页数据
            var doctor_name=$("#doctor_name").val();
            var doctor_mobile=$("#doctor_mobile").val();
            var material_name=$("#material_name").val();
            var material_type_id=$("#material_type_id").val();
            var begin_time=$("#begin_time").val();
            var end_time=$("#end_time").val();
            var recommend_name=$("#recommend_name").val();
            var recommend_mobile=$("#recommend_mobile").val();
            var check_status=$("#check_status").val();
            var pay_status=$("#pay_status").val();
            $.ajax({
                type: 'post',
                url: '{{url('admin/material/ajax')}}',
                data: {'page': page, 'action': 'getlist', 'doctor_name': doctor_name, 'doctor_mobile': doctor_mobile, 'material_name': material_name, 'material_type_id': material_type_id, 'begin_time': begin_time, 'end_time': end_time, 'recommend_name': recommend_name, 'recommend_mobile': recommend_mobile, 'check_status': check_status, 'pay_status': pay_status},
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
                        var li = '';
                        var list = json.list;
                        $.each(list, function(index, array) { //遍历返回json
                            var showbutton ='';
                            if(array.check_status ==0){
                                array.check_status_button='未审核';
                                showbutton +="<a class='button border-red' href='javascript:void(0)' onclick='checkPass(this)' data='"+array._id+"'  attachments ='"+array.attachments+"'><span class='icon-wrench'></span> 审核</a>";
                                @if($username =='admin')
                                    showbutton +="<a type='button' class='button border-red' href='javascript:void(0)' onclick='delete1(this)' data='"+array._id+"'><span class='icon-trash-o'></span>删除</a>";
                                @endif
                            }else if(array.check_status ==1){
                                array.check_status_button='审核通过';
                            }else{
                                array.check_status_button='审核未通过';
                            }
                            @if($username =='admin')
                            if(array.check_status ==1)
                            {
                                if (array.pay_status == 1) {
                                    array.pay_status = '已支付';
                                    showbutton += "<a type='button' class='button border-main' href='javascript:void(0)' onclick='pay(this)' data='" + array._id + "' status='0'><span class='icon-money'></span>取消支付</a>";
                                } else {
                                    array.pay_status = '未支付';
                                    showbutton += "<a type='button' class='button border-main' href='javascript:void(0)' onclick='pay(this)' data='" + array._id + "' price='" + array.price + "' status='1'><span class='icon-money'></span>支付</a>";
                                }
                            }else{
                                array.pay_status = '未支付';
                                showbutton += "<a type='button' class='button border-main' href='javascript:void(0)' onclick='pay(this)' data='" + array._id + "' price='" + array.price + "' status='1'><span class='icon-money'></span>支付</a>";

                            }
                            @endif
                            //                        <a type="button" class="button border-red" href="#"><span class="icon-trash-o"></span>删除</a>

                            {{--var downloadUrl ="{{url('admin/material/downloadfile/')}}"+"/"+array._id;--}}
                                li +="<tr><td><input type='checkbox' class='check_one' value='"+array._id+"'/></td><td>"+(page_size*(page_cur-1)+index+1)+"</td><td>"+array.doctor_name+"</td><td>"+array.doctor_mobile+"</td><td>"+array.created_at+"</td><td>"+array.big_area_name+"</td><td>"+array.area_name+"</td><td>"+array.sales_name+"</td><td style='width:10%;'>"+array.material_name+"</td><td>"+array.material_type_name+"</td><td>"+array.attachments+"</td><td>"+array.recommend_name+"</td><td>"+array.recommend_mobile+"</td><td>"+array.check_status_button+"</td><td>"+array.pass_amount+"</td><td>"+array.pay_status+"</td> <td>"+array.comment+"</td><td><div class='button-group'><a type='button' class='button border-main' href='javascript:;' onclick='uploadurl(this)' doctor_id='" + array.doctor_id + "' upload_code='" + array.upload_code + "'><span class='icon-download'></span>下载</a>";
                            li += showbutton +"</div></td></tr>";
                        });

//                    page_str=getPageBar();
//                    alert(page_str);
//                    li += page_str;
                        $("#list").append(li);
                        getPageBar();
                    } else {
                        $("#list").empty();
                        $("#list").append("<tr><td colspan='18'><div class='pagelist' id='pagelist'></div>暂无数据</tr>");
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
            page_str ="<div class='pagelist pull-left' id='pagelist'>";
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
            page_str +="到第<input type='text' id='input_number' style='width:50px' onblur=aGo(this.value) />页</div>";
            $("#page-tag").append(page_str);
        }

        $(function() {
            getData(1); //默认第一页
            $("#list tr").on('click', function() { //live 向未来的元素添加事件处理器,不可用bind
                var page = $(this).attr("data-page"); //获取当前页
                getData(page)
            });
            //复选框选中
            $('.check_all').click(function(){
                if($(this).prop('checked')){
                    $('.check_one').prop('checked',true);
                }else{
                    $('.check_one').prop('checked',false);
                };
            })
            $('.opt_confirm').click(function(e){
                e.preventDefault();
                var opt_val = $('.options').val();
                if(!opt_val){
                    alert('请选择操作类型');
                    return false;
                }
                var arr = [];
                $('.check_one').each(function(elem){
                    if($(this).prop('checked')){
                        arr.push($(this).val());
                    }
                })
                console.log(arr);
                if(arr.length === 0){
                    alert('请选择需要操作的行');
                    return false;
                }
            })
        });

        function aclick(obj){
            var page = $(obj).attr("data-page"); //获取当前页
            getData(page);
        }
        function aGo(page){

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



        function checkPass(obj){
            $("#checkid").val($(obj).attr('data'));
            $("#max_pass_amount").val($(obj).attr('attachments'));
            $("#checkbox").css('display','block');
        }

        $("#checkboxSure").click(function(){
            var check_status =$("#check_status_box").val();
            var pass_amount =$("#pass_amount_box").val();
            var comment =$("#comment").val();
            var id=$("#checkid").val();
            $.ajax({
                type: 'post',
                url: '{{url('admin/material/ajax')}}',
                data: {'action': 'check', 'check_status': check_status, 'pass_amount': pass_amount,'id':id,'comment':comment },
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                beforeSend: function(XMLHttpRequest) {
//                $('body').showLoading();
                },
                success: function(json) {

                    if (json.status == 1) {
                        $("#checkbox").css('display','none');
                        alert(json.msg);
                        window.location.reload();
                        //window.location.href="{{url("admin/material/index")}}";
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

        $("#checkboxCancle").click(function(){
            $("#checkbox").css('display','none');
        })





        function pay(obj){
            $("#payid").val($(obj).attr('data'));
            $("#pay_amount").val($(obj).attr('price'));
            $("#paystatus").val($(obj).attr('status'));
            if($(obj).attr('status') ==0){
                $("#pay_amount").val('0');
                $("#pay_amount").attr('readonly','readonly');
            }
            $("#paybox").css('display','block');
        }

        $("#paySure").click(function(){
            var id=$("#payid").val();
            var pay_status=$("#paystatus").val();
            var pay_amount=$("#pay_amount").val();
            if(!pay_amount){
                alert('请输入支付价格!');
                return false;
            }
            $.ajax({
                type: 'post',
                url: '{{url('admin/material/ajax')}}',
                data: {'action': 'pay','id':id ,'pay_status':pay_status,'pay_amount':pay_amount},
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                beforeSend: function(XMLHttpRequest) {
//                $('body').showLoading();
                },
                success: function(json) {

                    if (json.status == 1) {
                        $("#paybox").css('display','none');
                        alert(json.msg);
                        window.location.href="{{url("admin/material/index")}}";
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


        $("#payCancle").click(function(){
            $("#paybox").css('display','none');
        })


        function delete1(obj){
            var id=$(obj).attr('data');
            if(!confirm("确定要删除该条素材吗？")){
                return false;
            }
            $.ajax({
                type: 'post',
                url: '{{url('admin/material/ajax')}}',
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
                        window.location.reload();
                        //window.location.href="{{url("admin/material/index")}}";
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


        $("#pass_amount_box").change(function(){
            var select_pass_amount=$("#pass_amount_box").val();
            var max_pass_amount=$("#max_pass_amount").val();
            if(select_pass_amount >max_pass_amount){
                alert('审核通过的素材数量不能大于上传的素材数量!');
                $("#pass_amount_box").val(1);
            }

        });

        function uploadurl(obj){
//        $("#uploadBox").css('display','block');
            var doctor_id=$(obj).attr('doctor_id');
            var upload_code=$(obj).attr('upload_code');
            $.ajax({
                type: 'post',
                url: '{{url('admin/material/ajax')}}',
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

                            li +="<tr><td style='max-width:150px;'>"+array.filename+"</td><td><div class='button-group'><a type='button' class='button border-main' href='"+array.lenovoUrl+"'><span class='icon-download'></span>下载</a></div></td></tr>";

                        });
                        $("#uploadurllist").append(li);
                        $("#uploadBox").css('display','block');
                    } else {
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


        function uploadurlclose(){
            $("#uploadBox").css('display','none');

        }

        $(window).scroll(function () {
            //console.log($(this).scrollTop());
            var scrollTop = $(this).scrollTop();
            var winWidth = $(this).height();
            var width =  $('#uploadBox').css('top');
            console.log($('#uploadBox').css('margin-top',scrollTop));
        });
    </script>
@endsection

