<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="renderer" content="webkit">
    <meta name="_token" content="{{ csrf_token() }}"/>
    <title>销售组管理</title>
    <link rel="stylesheet" href="{{asset('resources/views/admin/static/css/pintuer.css')}}">
    <link rel="stylesheet" href="{{asset('resources/views/admin/static/css/admin.css')}}">
    <link rel="stylesheet" href="{{asset('resources/views/admin/static/css/main.css')}}">
    <script src="{{asset('resources/views/admin/static/js/jquery.js')}}"></script>

</head>
<body>
<div class="panel admin-panel">
    <div class="panel-head"><strong><span class="icon-pencil-square-o"></span>销售组管理</strong></div>
    <div class="body-content">
        <form method="post" class="form-x" action="">

            <div class="form-group ">
                <select class="form-control l input" id="big_area_id" style="min-width:110px">
                    <option value="all">选择大区</option>
                    @foreach($bigarea as $v)
                        <option value="{{$v->_id}}">{{$v->big_area_name}}</option>
                    @endforeach
                </select>
            </div>


                <div class="form-group ">
                <select class="form-control l input" id="area_id">
                    <option value="all">选择区域</option>
                    @foreach($area as $v)
                        <option value="{{$v->_id}}">{{$v->big_area_name}}</option>
                    @endforeach
                </select>
                </div>

                <div class="form-group">
                <div class="label">
                    <label>销售组：</label>
                </div>
                <div class="field">
                    <input type="text" class="input" name="stitle" value="" id="sales_name"/>
                    <div class="tips"></div>
                </div>
                </div>

            </div>

            <div class="form-group  tool-btns">
                <button class="button bg-main icon-refresh" type="reset" id="reset" onclick ="return false;">重置</button>
                <button class="button bg-main icon-search" type="button" id="search" onclick ="return false;">查询</button>
                <button class="button bg-main icon-plus" type="button" onclick="add()">添加</button>
            </div>
        </form>
        <form method="post" action="">
            <div class="panel admin-panel">
                <table class="table table-hover text-center" id="list">
                    {{--<tr>--}}
                        {{--<th>序号</th>--}}
                        {{--<th>大区</th>--}}
                        {{--<th>地区</th>--}}
                        {{--<th>销售组</th>--}}
                        {{--<th>启用状态</th>--}}
                        {{--<th>操作</th>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                        {{--<td>1</td>--}}
                        {{--<td>华北大区</td>--}}
                        {{--<td>湖北</td>--}}
                        {{--<td>湖北1大区混合01组</td>--}}
                        {{--<td>启用</td>--}}
                        {{--<td width="180"><div class="button-group">--}}
                                {{--<a type="button" class="button border-main" href="#"><span class="icon-edit"></span>编辑</a>--}}
                                {{--<a type="button" class="button border-red" href="#"><span class="icon-money"></span>禁用</a>--}}
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

<!--地区管理 添加弹框开始-->
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
                        <option value="all">请选择</option>
                        @foreach($area as $v)
                            <option value="{{$v->_id}}">{{$v->area_name}}</option>
                        @endforeach
                    </select>
                    <div class="tips"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="label">
                    <label>销售组：</label>
                </div>
                <div class="field">
                    <input type="text" class="input" id="edit_sales_name">
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
            <input type="hidden" name="sales_id"  id="sales_id" value="" />
        </div>
    </div>
</div>
<!--地区管理 添加弹框结束-->
<!--编辑价格弹框开始-->
<div style="display: none;width: 300px;margin-left:-150px;" class="MsgBox clearfix" id="editPriceBox">
    <div class="top">
        <div class="title" class="MsgTitle">添加/编辑</div>
    </div>
    <div class="body l">
        <form class="alert-form clearfix">

            <div class="form-group">
                <div class="label">
                    <label id="editPriceSalesName">销售组：</label>
                </div>
            </div>
            <div class="form-group" >
                <div class="label">
                    <label>素材类型：</label>
                </div>
                <div class="field">
                    <select class="input" id="editMaterialType">
                        @foreach($materialType as $v)
                            <option value="{{$v->_id}}">{{$v->material_type_name}}</option>
                        @endforeach
                    </select>
                    <div class="tips"></div>
                </div>
            </div>
            <div class="form-group" >
                <div class="label">
                    <label>素材价格：</label>
                </div>
                <div class="field">
                    <input type="text" class="input" id="edit_price">
                    <div class="tips"></div>
                </div>
            </div>
        </form>
    </div>
    <div class="bottom l" class="MsgBottom" style="height: 45px;">
        <div class="btn MsgBtns">
            <div class="height"></div>
            <input type="button" class="btn" value="确认" id="sureEditPrice">　<input type="button" class="btn" value="取消" id="cancleEditPrice">
            <input type="hidden" name="edit_price_sales_id"  id="edit_price_sales_id" value="" />
        </div>
    </div>
</div>
<!--编辑价格弹框结束-->

</body>
</html>
<script type="text/javascript">
    var page_cur = 1; //当前页
    var total_num, page_size, page_total_num; //总记录数,每页条数,总页数
    var status
    function getData(page) { //获取当前页数据
        var big_area_id=$("#big_area_id").val();
        var area_id=$("#area_id").val();
        var sales_name=$("#sales_name").val();
        $.ajax({
            type: 'post',
            url: '{{url('admin/sales/ajax')}}',
            data: {'page': page, 'action': 'getlist', 'big_area_id': big_area_id, 'area_id': area_id, 'sales_name': sales_name},
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
                    var li = "<tr><th>序号</th><th>大区</th><th>地区</th><th>销售组</th><th>启用状态</th><th>操作</th> </tr>";
                    var list = json.list;
                    var status_button;
                    $.each(list, function(index, array) { //遍历返回json
                        if(array.status==1){
                            array.status_button='启用';

                        }else{
                            array.status_button='禁用';
                        }
                        li +="<tr><td>"+(page_size*(page_cur-1)+index+1)+"</td><td>"+array.big_area_name+"</td><td>"+array.area_name+"</td><td>"+array.sales_name+"</td><td>"+array.status_button+"</td><td width='180'><div class='button-group'><a type='button' class='button border-main' href='javascript:;' onclick='edit(this)' sales_id='"+array._id+"' edit_big_area_id='"+array.big_area_id+"' edit_area_id='"+array.area_id+"' edit_sales_name='"+array.sales_name+"' status='"+array.status+"' ><span class='icon-edit'></span>编辑</a><a type='button' class='button border-main' href='javascript:;' onclick='editPrice(this)' sales_id='"+array._id+"'  edit_sales_name='"+array.sales_name+"'><span class='icon-edit'></span>编辑价格</a></div></td></tr>";
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
        $("#sales_name").val('');
        $("#big_area_id").val('all');
        $("#area_id").val('all');
        getData(1);
    });



    function edit(obj){
        $("#sales_id").val($(obj).attr('sales_id'));
        $("#edit_big_area_id").val($(obj).attr('edit_big_area_id'));
        $("#edit_area_id").val($(obj).attr('edit_area_id'));
        $("#edit_sales_name").val($(obj).attr('edit_sales_name'));
        $("#editStatus").val($(obj).attr('status'));
//        $("#editMaterialType1").css('display','none');
//        $("#edit_price1").css('display','none');
        $("#editBox").css('display','block');
    }

    function add(){
        $("#sales_id").val('');
        $("#edit_sales_name").val('');
//        $("#edit_price").val('');
        $('#edit_big_area_id option:eq(0)').attr('selected','selected');
        $('#edit_area_id option:eq(0)').attr('selected','selected');
        $('#editStatus option:eq(0)').attr('selected','selected');
        $("#editMaterialType1").css('display','block');
//        $("#edit_price1").css('display','block');
        $("#editBox").css('display','block');
    }

    $("#sureEdit").click(function(){
        var big_area_id = $("#edit_big_area_id").val();
        var area_id = $("#edit_area_id").val();
        var sales_name = $("#edit_sales_name").val();
        var status = $("#editStatus").val();
        var sales_id =$("#sales_id").val();
        if(big_area_id ==''){
            alert('请选择大区!');
            return false;
        }
        if(area_id ==''){
            alert('请选择区域!');
            return false;
        }
        if(sales_name ==''){
            alert('请输入销售组名称!');
            return false;
        }
        $.ajax({
            type: 'post',
            url: '{{url('admin/sales/ajax')}}',
            data: {
                'action': 'editSales',
                'big_area_id': big_area_id,
                'area_id': area_id,
                'sales_name': sales_name,
                'status': status,
                'sales_id': sales_id,
            },
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            beforeSend: function (XMLHttpRequest) {

            },
            success: function (json) {
                if (json.status == 1) {
                    alert(json.msg)
                    window.location.href="{{url("admin/sales/index")}}";
                } else {
                    alert(json.msg)
                }
            },
            complete: function () {

            },
            error: function () {
                alert("数据异常！");
            }
        });

    })

    $("#cancleEdit").click(function(){
        $("#editBox").css('display','none');
    })


    function editPrice(obj){
        $("#editPriceSalesName").text('销售组:'+$(obj).attr('edit_sales_name'));
        $("#edit_price_sales_id").val($(obj).attr('sales_id'));
        $("#editPriceBox").css('display','block');
    }

    $("#sureEditPrice").click(function(){
        var sales_id = $("#edit_price_sales_id").val();
        var material_type_id = $("#editMaterialType").val();
        var price = $("#edit_price").val();
        if(price ==''){
            alert('请输入价格!');
            return false;
        }
        $.ajax({
            type: 'post',
            url: '{{url('admin/sales/ajax')}}',
            data: {
                'action': 'editPrice',
                'price': price,
                'sales_id': sales_id,
                'material_type_id': material_type_id,
            },
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            beforeSend: function (XMLHttpRequest) {

            },
            success: function (json) {
                if (json.status == 1) {
                    alert(json.msg)
                    $("#editPriceBox").css('display','none');
                    {{--window.location.href="{{url("admin/sales/index")}}";--}}
                } else {
                    alert(json.msg)
                }
            },
            complete: function () {

            },
            error: function () {
                alert("数据异常！");
            }
        });

    })

    $("#cancleEditPrice").click(function(){
        $("#editPriceBox").css('display','none');
    })
</script>