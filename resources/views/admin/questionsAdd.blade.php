@extends('layouts.admin')

@section('title','添加常见问题')

@section('css')
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
@endsection
@section('js')
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script type="text/javascript" charset="utf-8" src="{{ asset('resources/org/ueditor/ueditor.config.js') }}"></script>
    <script type="text/javascript" charset="utf-8" src="{{ asset('resources/org/ueditor/ueditor.all.min.js') }}"> </script>
    <!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
    <!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
    <script type="text/javascript" charset="utf-8" src="{{ asset('resources/org/ueditor/lang/zh-cn/zh-cn.js') }}"></script>
@endsection

@section('content')
    <div class="panel admin-panel">
    <div class="panel-head"><strong><span class="icon-pencil-square-o"></span> 常见问题 -- 添加</strong></div>
    </div>
    <div class="col-sm-offset-2 col-sm-8" style="height: 50px;margin-bottom: 10px;">
        @if(count($errors))
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif
    </div>
    <div class="clear"></div>
    <form class="form-horizontal" method="post" action="" role="form" >
        {{ csrf_field() }}
        @if($question->_id)
        <input type="hidden" name="_id" value="$question->_id">
        @endif
        <div class="form-group">
            <label  class="col-sm-2 control-label">是否发布*:</label>
            <div class="col-sm-10">
                <label class="radio-inline">
                    <input type="radio" name="is_show"  value="1" @if(old('is_show')==1 || $question->is_show) checked @endif> 发布
                </label>
                <label class="radio-inline">
                    <input type="radio" name="is_show"  value="0" @if(old('is_show')!=1) checked @endif> 不发布
                </label>
            </div>

        </div>
        <div class="form-group">
            <label for="title" class="col-sm-2 control-label">标题*:</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" name="title" id="title" placeholder="请填写标题" value="{{ old('title')?:$question->title }}">
            </div>
        </div>
        <div class="form-group">
            <label for="title" class="col-sm-2 control-label">内容*:</label>
            <div class="col-sm-8">
                <script id="container" type="text/plain" name="content">{!! old('content')?:$question->content !!} </script>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary">提交</button>
                <a class="btn btn-default" href="{{ url('admin/questions/index') }}">返回</a>
            </div>
        </div>
    </form>



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
    <script type="text/javascript">
        var ue = UE.getEditor('container',{
            toolbars: [
                ['fullscreen', 'source', 'undo', 'redo'],
                ['bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc']
            ],
            autoHeightEnabled: true,
            autoFloatEnabled: true,
            initialFrameHeight:300
        });
    </script>
@stop