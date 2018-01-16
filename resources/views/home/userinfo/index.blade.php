@extends('layouts.home')

@section('title','个人信息')

@section('content')
    <div class="panel admin-panel">
        <div class="panel-head"><strong>个人信息</strong></div>
        <div class="body-content">
            <div class="content-info">
                <div class="row">
                    <div class="col-sm-1"></div>
                    <div class="col-xs-3 col-sm-2 text-right">用户名：</div>
                    <div class="col-xs-8 col-sm-4">{{$doctor->doctor_name}}</div>
                </div>
                <div class="row">
                    <div class="col-sm-1"></div>
                    <div class="col-xs-3 col-sm-2 text-right">手机号：</div>
                    <div class="col-xs-8 col-sm-4">{{$doctor->doctor_mobile}}</div>
                </div>
                <div class="row">
                    <div class="col-sm-1"></div>
                    <div class="col-xs-3 col-sm-2 text-right">协议状态：</div>
                    <div class="col-xs-8 col-sm-4">
                        @unless($doctor->have_protocol)
                            协议未上传 &nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-primary" href="{{ url('home/userinfo/protocol') }}">上传协议</a>
                        @else
                            @if($doctorProtocol->check_status ==='0')
                                待审核
                            @elseif($doctorProtocol->check_status ==='1')
                                通过审核
                            @else
                                未通过  <b> (原因：{{ $doctorProtocol->comment }})</b>&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-primary" href="{{ url('home/userinfo/protocol') }}">重新上传</a>
                            @endif
                        @endunless
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-1"></div>
                    <div class="col-xs-3 col-sm-2 text-right">地址：</div>
                    <div class="col-xs-8 col-sm-4">{{$doctor->province_name}}{{$doctor->city_name}}{{$doctor->region_name}}</div>
                </div>
                <div class="row">
                    <div class="col-sm-1"></div>
                    <div class="col-xs-3 col-sm-2 text-right">医院：</div>
                    <div class="col-xs-8 col-sm-4">{{$doctor->hospital_name}}</div>
                </div>
                <div class="row">
                    <div class="col-sm-1"></div>
                    <div class="col-xs-3 col-sm-2 text-right">银行卡号：</div>
                    <div class="col-xs-8 col-sm-4">{{$doctor->bank_card_no}}</div>
                </div>
                <div class="row">
                    <div class="col-sm-1"></div>
                    <div class="col-xs-3 col-sm-2 text-right">账户支行：</div>
                    <div class="col-xs-8 col-sm-4">{{$doctor->bank_name}}</div>
                </div>
                <div class="row">
                    <div class="col-xs-8 col-sm-6 col-sm-offset-3"><a href="{{ url('home/userinfo/edit') }}" class="btn btn-primary">修改资料</a></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('floorjs')
    <script>
        $(function(){


        })
    </script>
@endsection
