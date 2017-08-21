@extends('layouts.app')
@section('app')
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">用户列表</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading" style="overflow:hidden;line-height: 34px;">
                    DataTables Advanced Tables
                    @if(isset($buttonList[3]))<button class="btn btn-primary" type="button" style="float:right;" onclick="userAdd('{{$buttonList[3]['namespace']}}','{{$buttonList[3]['action']}}','{{$buttonList[3]['name']}}')">{{$buttonList[3]['name']}}</button>@endif
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-admin">
                        <thead>
                        <tr>
                            <th>姓名</th>
                            <th>用户组</th>
                            <th>邮箱</th>
                            <th>创建时间</th>
                            <th>最近登陆</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($userList as $rows)
                        @if($rows['roleid'] >= Auth::user()->roleid)
                            <tr>
                                <td>{{$rows['name']}}</td>
                                <td>{{$rows['user_role']['name']}}</td>
                                <td>{{$rows['email']}}</td>
                                <td>{{$rows['created_at']}}</td>
                                <td class="center">{{$rows['updated_at']}}</td>
                                <td class="center">
                                    @if(isset($buttonList[8]) && $rows['id'] != Auth::user()->id && $rows['roleid'] >= Auth::user()->roleid)<button class="btn btn-outline btn-warning" type="button" onclick="userUpdate('{{$buttonList[8]['namespace']}}','{{$buttonList[8]['action']}}','{{$buttonList[8]['name']}}','{{$rows['id']}}')">修改</button>@endif&nbsp;&nbsp;
                                    @if(isset($buttonList[9]) && $rows['id'] != Auth::user()->id && $rows['roleid'] >= Auth::user()->roleid)
                                        <form id="from" action="/{{$buttonList[9]['namespace'].'/'.$rows['id'].'/'.$buttonList[9]['action']}}" method="POST" style="display: inline;">
                                            {{ method_field('DELETE') }}
                                            {{ csrf_field() }}
                                            <button type="button" class="btn btn-outline btn-danger" onclick="layer.confirm('确定要删除吗?', {btn: ['确定','返回']}, function(){$('#from').submit();});">删除</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#dataTables-admin').DataTable({
            responsive: true
        });
    });
    function userAdd(namespace,action,title){
        layer.open({
            title :title,
            type: 2,
            area: ['500px', '550px'],
            skin: 'layui-layer-rim', //加上边框
            content: ['/'+namespace+'/'+action, 'no']
        });
    }
    function userUpdate(namespace,action,title,id){
        layer.open({
            title :title,
            type: 2,
            area: ['500px', '450px'],
            skin: 'layui-layer-rim', //加上边框
            content: ['/'+namespace+'/'+id+'/'+action, 'no']
        });
    }
</script>
@endsection
