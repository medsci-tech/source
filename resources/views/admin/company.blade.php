@extends('layouts.admin')

@section('title','公司管理')

@section('css')
    @parent
    <link rel="stylesheet" type="text/css" href="{{asset('resources/views/admin/static/css/jquery-ui.css')}}" />
@endsection


@section('content')

    <div class="panel admin-panel">
        <div class="panel-head"><strong><span class="icon-pencil-square-o"></span>公司管理</strong></div>
        <div class="body-content">
            <div class="form-group tool-btns">
                <button class="button bg-main icon-download" type="button" onclick="add()">添加</button>
            </div>
            <form method="post" action="">
                <div class="">

                    <table class="table table-hover text-center" id="list">
                        <thead>
                        <tr>
                            <th>编号</th>
                            <th>公司名称</th>
                            <th>公司简称</th>
                            {{--<th>状态</th>--}}
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($company as $k=>$v)
                        <tr>
                            <td>{{ $k+1 }}</td>
                            <td>{{ $v->full_name }}</td>
                            <td>{{ $v->short_name }}</td>
                            {{--<td>{{ $v->status?'启用':'禁用' }}</td>--}}
                            <td>
                                <div class='button-group'><a type='button' class='button border-main' href='javascript:;' onclick="edit(this)" data='{{ $v->_id }}' status='{{ $v->status }}' full_name='{{ $v->full_name }}' short_name='{{ $v->short_name }}'><span class='icon-edit'></span>编辑</a></div>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>

                    </table>

                    <div class="pagelist"> {{ $company->render() }} </div>
                </div>
            </form>
        </div>
    </div>

    <!--公司管理 添加弹框开始-->
    <div style="display: none;width: 300px;margin-left:-150px;" class="MsgBox clearfix" id="editBox">
        <div class="top">
            <div class="title" class="MsgTitle">添加/编辑</div>
        </div>
        <div class="body l">
            <form class="alert-form clearfix">
                <div class="form-group">
                    <div class="label">
                        <label>公司名称：</label>
                    </div>
                    <div class="field">
                        <input type="text" class="input" name="full_name" id="edit_full_name" value="">
                        <div class="tips"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="label">
                        <label>公司简称：</label>
                    </div>
                    <div class="field">
                        <input type="text" class="input" name="short_name" id="edit_short_name" value="">
                        <div class="tips"></div>
                    </div>
                </div>
                {{--<div class="form-group">
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
                </div>--}}
            </form>
        </div>
        <div class="bottom l" class="MsgBottom" style="height: 50px;">
            <div class="btn MsgBtns">
                <div class="height"></div>
                <input type="button" class="btn" value="确认"  id="sureEdit">　<input type="button" class="btn" value="取消" id="cancleEdit">
                <input type="hidden" name="typeid"  id="typeid" value="" />
            </div>
        </div>
    </div>
    <!--公司管理 添加弹框结束-->
@stop

@section('adminjs')
<script type="text/javascript">
    function edit(obj){
        $("#typeid").val($(obj).attr('data'));
        $("#edit_full_name").val($(obj).attr('full_name'));
        $("#edit_short_name").val($(obj).attr('short_name'));
        $("#editStatus").val($(obj).attr('status'));
        $("#editBox").show();
    }

    function add(){
        $("#typeid").val('');
        $("#edit_full_name").val('');
        $("#edit_short_name").val('');
        $('#editStatus option:eq(0)').attr('selected','selected');
        $("#editBox").show();
    }

    $("#sureEdit").click(function(){
        var id=$("#typeid").val();
        var full_name = $("#edit_full_name").val();
        var short_name = $("#edit_short_name").val();
        var status = $("#editStatus").val();
        if(!full_name || !short_name){
            modelAlert('请输入完整名称!');
            return false;
        }
        $.ajax({
            type: 'post',
            url: '{{url('admin/company/save')}}',
            data: {'id':id,'full_name':full_name,'short_name':short_name,'status':status },
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
                    modelAlert(json.msg);
                    window.location.href="{{url("admin/company/index")}}";
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