
@extends('layouts.home')

@section('title','推荐人信息')

@section('content')

<div class="panel admin-panel">
    <div class="panel-head"><strong>推荐人信息</strong></div>
    <div class="body-content">

        <form method="post" action="" class="form-x mt15">
            <div class="form-group w100">
                <a href="{{url('home/recommendinfo/addrecommend')}}">
                <button class="button bg-main r mr20" type="button">添加推荐人</button>
                    </a>
            </div>
            <div class="panel admin-panel">
                <table class="table table-hover text-center" id ="list">
                    <tr>
                        <th>推荐人姓名</th>
                        <th>推荐人手机号</th>
                        <th>大区</th>
                        <th>地区</th>
                        <th>销售组</th>
                        <th>绑定时间</th>
                    </tr>
                    @foreach($doctorrecommend as $v)
                    <tr>
                        <td>{{$v->recommend_name}}</td>
                        <td>{{$v->recommend_mobile}}</td>
                        <td>{{$v->big_area_name}}</td>
                        <td>{{$v->area_name}}</td>
                        <td>{{$v->sales_name}}</td>
                        <td>{{$v->created_at}}</td>
                    </tr>
                    @endforeach
                    {{--<tr>--}}
                        {{--<td colspan="14"><div class="pagelist"> <a href="">上一页</a> <span class="current">1</span><a href="">2</a><a href="">3</a><a href="">下一页</a><a href="">尾页</a> </div></td>--}}
                    {{--</tr>--}}
                </table>
            </div>
        </form>
    </div>
</div>

@endsection

@section('floorjs')
    <script type="text/javascript">
    {{--var page_cur = 1; //当前页--}}
    {{--var total_num, page_size, page_total_num; //总记录数,每页条数,总页数--}}
    {{--var status--}}
    {{--function getData(page) { //获取当前页数据--}}

        {{--$.ajax({--}}
            {{--type: 'post',--}}
            {{--url: '{{url('home/recommendinfo/ajax')}}',--}}
            {{--data: {'page': page, 'action': 'getlist'},--}}
            {{--dataType: 'json',--}}
            {{--headers: {--}}
                {{--'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')--}}
            {{--},--}}
            {{--beforeSend: function(XMLHttpRequest) {--}}
{{--//                $('body').showLoading();--}}
            {{--},--}}
            {{--success: function(json) {--}}
                {{--if (json.status == 1) {--}}
                    {{--$("#list").empty();--}}
                    {{--total_num = json.total_num; //总记录数--}}
                    {{--page_size = json.page_size; //每页数量--}}
                    {{--page_cur = page; //当前页--}}
                    {{--page_total_num = json.page_total_num; //总页数--}}
                    {{--var li = "<tr><th>推荐人姓名</th><th>推荐人手机号</th><th>大区</th><th>销售组</th><th>绑定时间</th></tr>";--}}
                    {{--var list = json.list;--}}
                    {{--$.each(list, function(index, array) { //遍历返回json--}}
                        {{--var downloadUrl ="{{url('home/userfile/downloadfile/')}}"+"/"+array._id;--}}
                        {{--li +="<tr><td>"+(page_size*(page_cur-1)+index+1)+"</td><td>"+array.material_name+"</td><td >"+array.recommend_mobile+"</td><td >"+array.big_area_name+"</td><td >"+array.sales_name+"</td><td >"+array.created_at+"</td></tr>";--}}
                    {{--});--}}
                    {{--li +="<tr id ='page-tag'></tr>"--}}
                    {{--$("#list").append(li);--}}
                    {{--getPageBar();--}}
                {{--} else {--}}
                    {{--$("#list").empty();--}}
                    {{--$("#list").append("<tr><td colspan='14'><div class='pagelist' id='pagelist'></div>暂无数据</tr>");--}}
                    {{--alert(json.msg);--}}
                {{--}--}}
            {{--},--}}
            {{--complete: function() {--}}

            {{--},--}}
            {{--error: function() {--}}

                {{--alert("数据异常！");--}}
            {{--}--}}
        {{--});--}}
    {{--}--}}
    {{--function getPageBar() { //js生成分页--}}
        {{--if (page_cur > page_total_num)--}}
            {{--page_cur = page_total_num; //当前页大于最大页数--}}
        {{--if (page_cur < 1)--}}
            {{--page_cur = 1; //当前页小于1--}}
        {{--page_str ="<td colspan='14'><div class='pagelist' id='pagelist'>";--}}
        {{--page_str += "<span>共" + page_total_num + "页</span><span>" + page_cur + "/" + page_total_num + "</span>";--}}
{{--//        page_str ="<tr>";--}}
        {{--//若是第一页--}}
        {{--if (page_cur == 1) {--}}
            {{--page_str += "<span>首页</span><span>上一页</span>";--}}
        {{--} else {--}}
            {{--page_str += "<a href='javascript:void(0)' onclick='aclick(this);' data-page='1'>首页</a><a href='javascript:void(0)' onclick='aclick(this);' data-page='" + (page_cur - 1) + "'>上一页</a>";--}}
        {{--}--}}
        {{--//若是最后页--}}
        {{--if (page_cur >= page_total_num) {--}}
            {{--page_str += "<span>下一页</span><span>尾页</span>";--}}
        {{--} else {--}}
            {{--page_str += "<a href='javascript:void(0)' onclick='aclick(this);' data-page='" + (parseInt(page_cur) + 1) + "'>下一页</a><a href='javascript:void(0)' onclick='aclick(this);' data-page='" + page_total_num + "'>尾页</a>";--}}
        {{--}--}}
        {{--page_str +="</div></td>";--}}
        {{--$("#page-tag").html(page_str);--}}
    {{--}--}}

    {{--$(function() {--}}
        {{--getData(1); //默认第一页--}}
        {{--$("#list tr").on('click', function() { //live 向未来的元素添加事件处理器,不可用bind--}}
            {{--var page = $(this).attr("data-page"); //获取当前页--}}
            {{--getData(page)--}}
        {{--});--}}
    {{--});--}}

    {{--function aclick(obj){--}}
        {{--var page = $(obj).attr("data-page"); //获取当前页--}}
        {{--getData(page);--}}
    {{--}--}}
//    $('#search').click(function() {
//        getData(1);
//    });
//
//    $('#reset').click(function() {
//        $("#material_name").val('');
//        $("#material_type_id").val('all');
//        $("#begin_time").val('');
//        $("#end_time").val('');
//        $("#check_status").val('all');
//        getData(1);
//    });
</script>
@endsection