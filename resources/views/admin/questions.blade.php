@extends('layouts.admin')

@section('title','常见问题')


@section('content')
    <div class="panel admin-panel">
        <div class="panel-head"><strong><span class="icon-pencil-square-o"></span>常见问题</strong><a class="btn btn-primary" style="float: right;" href="{{ url('admin/questions/saveinfo') }}">添加</a>
        </div>
        <div class="clear"></div>
    <div class="body-content">
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>编号</th>
                <th>标题</th>
                <th>创建时间</th>
                <th>是否发布</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($questions as $k=>$question)
            <tr>
                <td>{{ $k + 1 }}</td>
                <td>{{ $question->title }}</td>
                <td>{{ $question->created_at }}</td>
                <td>
                    @if($question->is_show)
                        <span class="btn btn-primary">发布</span>
                    @else
                        <span class="btn btn-danger">未发布</span>
                    @endif
                </td>
                <td><a href="{{ url('admin/questions/saveinfo',['id'=>$question->_id]) }}" class="btn btn-success">编辑</a></td>
            </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pagelist">
        {{ $questions->render() }}
        </div>
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
    <div class="bottom l" class="MsgBottom" style="height: 45px;">
        <div class="btn MsgBtns">
            <div class="height"></div>
            <input type="button" class="btn" value="确认" id="sureDelete">　<input type="button" class="btn" value="取消" id="cancleDelete">
            <input type="hidden" name="toolsid"  id="toolsid" value="" />
        </div>
    </div>
</div>
    <!--删除数据结束-->
@stop

@section('adminjs')

@stop