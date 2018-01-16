@extends('layouts.home')

@section('title','常见问题')

@section('content')
    <div class="panel admin-panel">
    <div class="panel-head"><strong>常见问题</strong></div>
    <div class="body-content">
        <div class="panel-group" id="accordion">
            @foreach($questions as $k=>$question)
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion"
                           href="#collapse{{ $k }}" style="display:block;height: 100%;font-size: 20px;">
                            {{ $question->title }}
                        </a>
                    </h4>
                </div>
                <div id="collapse{{ $k }}" class="panel-collapse collapse {{--@if($k === 0 )in @endif--}}">
                    <div class="panel-body">
                        {!! $question->content !!}
                    </div>
                </div>
            </div>
            @endforeach

        </div>


    </div>
</div>
@endsection
