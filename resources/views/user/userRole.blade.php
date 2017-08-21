@extends('layouts.app')
@section('app')
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">用户组列表</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading" style="overflow:hidden;line-height: 34px;">
                    DataTables Advanced Tables
                    @if(isset($buttonList[6]))<button class="btn btn-primary" type="button" style="float:right;" onclick="userRoleAdd('{{$buttonList[6]['namespace']}}','{{$buttonList[6]['action']}}','{{$buttonList[6]['name']}}')">{{$buttonList[6]['name']}}</button>@endif
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-admin">
                        <thead>
                        <tr>
                            <th>姓名</th>
                            <th>权限</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($userRoleList as $rows)
                        @if($rows['roleid'] >= Auth::user()->roleid)
                        <tr>
                            <td>{{$rows['name']}}</td>
                            <td>{{$rows['rule']}}</td>
                            <td>@if($rows['disabled']) 禁用 @else 可用 @endif</td>
                            <td class="center">
                                @if(isset($buttonList[10]) && $rows['roleid'] > Auth::user()->roleid)<button class="btn btn-outline btn-warning" type="button" onclick="userRoleUpdate('{{$buttonList[10]['namespace']}}','{{$buttonList[10]['action']}}','{{$buttonList[10]['name']}}','{{$rows['roleid']}}')">修改</button>@endif&nbsp;&nbsp;
                                @if(isset($buttonList[11]) && $rows['roleid'] > Auth::user()->roleid)
                                <form id="from" action="/{{$buttonList[11]['namespace'].'/'.$rows['roleid'].'/'.$buttonList[11]['action']}}" method="POST" style="display: inline;">
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
    function userRoleAdd(namespace,action,title){
        layer.open({
            title :title,
            type: 2,
            area: ['500px', '550px'],
            skin: 'layui-layer-rim', //加上边框
            content: ['/'+namespace+'/'+action, 'yes']
        });
    }
    function userRoleUpdate(namespace,action,title,id){
        layer.open({
            title :title,
            type: 2,
            area: ['500px', '550px'],
            skin: 'layui-layer-rim', //加上边框
            content: ['/'+namespace+'/'+id+'/'+action, 'yes']
        });
    }
</script>
@endsection
