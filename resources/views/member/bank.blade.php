@extends('layouts.app')
@section('app')
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">银行列表</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading" style="overflow:hidden;line-height: 34px;">
                    DataTables Advanced Tables
                    @if(isset($buttonList[18]))<button class="btn btn-primary" type="button" style="float:right;" onclick="memberAdd('{{$buttonList[18]['namespace']}}','{{$buttonList[18]['action']}}','{{$buttonList[18]['name']}}')">添加银行会员</button>@endif
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-admin">
                        <thead>
                        <tr>
                            <th>微信昵称</th>
                            <th>性别</th>
                            <th>地区</th>
                            <th>手机号</th>
                            <th>积分</th>
                            <th>创建时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($memberList as $rows)
                        <tr>
                            <td>{{$rows['member']['nickname']}}</td>
                            <td>@if ($rows['member']['sex'] == 1) 男 @elseif($rows['member']['sex'] == 2) 女 @else 未知 @endif</td>
                            <td>{{$rows['member']['city']}}</td>
                            <td>{{$rows['member']['mobile']}}</td>
                            <td>{{$rows['member']['points']}}</td>
                            <td>{{$rows['create_dt']}}</td>
                            <td class="center">
                                @if(isset($buttonList[17]))
                                    @if ($rows['status'] == 0)
                                    <button class="btn btn-outline btn-info" type="button" onclick="check('{{$buttonList[17]['namespace']}}','{{$buttonList[17]['action']}}','{{$buttonList[17]['name']}}','{{$rows['uid']}}')">未提交</button>
                                    @elseif ($rows['status'] == 1)
                                    <button class="btn btn-outline btn-primary" type="button" onclick="check('{{$buttonList[17]['namespace']}}','{{$buttonList[17]['action']}}','{{$buttonList[17]['name']}}','{{$rows['uid']}}')">认证中</button>
                                    @elseif ($rows['status'] == 2)
                                    <button class="btn btn-outline btn-success" type="button" onclick="check('{{$buttonList[17]['namespace']}}','{{$buttonList[17]['action']}}','{{$buttonList[17]['name']}}','{{$rows['uid']}}')">认证成功</button>
                                    @else
                                    <button class="btn btn-outline btn-danger" type="button" onclick="check('{{$buttonList[17]['namespace']}}','{{$buttonList[17]['action']}}','{{$buttonList[17]['name']}}','{{$rows['uid']}}')">认证失败</button>
                                    @endif
                                @endif
                                @if(isset($buttonList[19]))<button class="btn btn-outline btn-warning" type="button" onclick="window.location.href='{{'/'.$buttonList[19]['namespace'].'/'.$rows['uid'].'/'.$buttonList[19]['action']}}'">修改</button>@endif
                            </td>
                        </tr>
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
/*        @if(Session::has('message'))
            layer.msg('{{Session::get('message')}}',{time:1000});
        @endif*/
    });
    function check(namespace,action,title,id){
        layer.open({
            title :title,
            type: 2,
            area: ['500px', '400px'],
            skin: 'layui-layer-rim', //加上边框
            content: ['/'+namespace+'/'+id+'/'+action, 'no']
        });
    }
    function memberAdd(namespace,action,title){
        layer.open({
            title :title,
            type: 2,
            area: ['500px', '410px'],
            skin: 'layui-layer-rim', //加上边框
            content: ['/'+namespace+'/'+action, 'no']
        });
    }
</script>
@endsection
