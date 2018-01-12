@extends('layouts.home')

@section('title','常见问题')

@section('css')
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

@endsection

@section('js')
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
@endsection

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
                           href="#collapse{{ $k }}" style="display:block;">
                            {{ $question->title }}
                        </a>
                    </h4>
                </div>
                <div id="collapse{{ $k }}" class="panel-collapse collapse @if($k === 0 )in @endif">
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
