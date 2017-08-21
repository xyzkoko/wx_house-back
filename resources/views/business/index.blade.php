@extends('layouts.app')
@section('app')
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">业务列表</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading" style="overflow:hidden;line-height: 34px;">
                    DataTables Advanced Tables
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-admin">
                        <thead>
                        <tr>
                            <th>业务id</th>
                            <th>申请人</th>
                            <th>网签报告</th>
                            <th>评估报告</th>
                            <th>物流信息</th>
                            <th>代办</th>
                            <th>创建时间</th>
                            <th>状态</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($businessList as $rows)
                        <tr>
                            <td>{{$rows['bid']}}</td>
                            <td>{{$rows['member']['nickname']}}</td>
                            @if($rows['sign'])
                            <td>金额：{{$rows['business_sign']['money']}}&nbsp;&nbsp;
                                @if(isset($buttonList[26]))
                                <button type="button" onclick="window.location.href='{{'/'.$buttonList[26]['namespace'].'/'.$rows['bid'].'/'.$buttonList[26]['action']}}'"
                                @if ($rows['business_sign']['status'] == 0) class="btn btn-outline btn-info" disabled>未提交
                                @elseif ($rows['business_sign']['status'] == 1) class="btn btn-outline btn-warning" >待审核
                                @elseif ($rows['business_sign']['status'] == 2) class="btn btn-outline btn-success">审核成功
                                @elseif ($rows['business_sign']['status'] == 3) class="btn btn-outline btn-danger">审核失败
                                @elseif ($rows['business_sign']['status'] == 4) class="btn btn-outline btn-danger">业务取消
                                @endif
                                </button>
                                @endif
                            </td>
                            @else
                            <td>无</td>
                            @endif
                            @if($rows['assess'])
                            <td>金额：{{$rows['business_assess']['money']}}&nbsp;&nbsp;
                                @if(isset($buttonList[27]))
                                    <button type="button" onclick="window.location.href='{{'/'.$buttonList[27]['namespace'].'/'.$rows['bid'].'/'.$buttonList[27]['action']}}'"
                                    @if ($rows['business_assess']['status'] == 0) class="btn btn-outline btn-info" disabled>未提交
                                    @elseif ($rows['business_assess']['status'] == 1) class="btn btn-outline btn-warning">待审核
                                    @elseif ($rows['business_assess']['status'] == 2) class="btn btn-outline btn-primary">待支付
                                    @elseif ($rows['business_assess']['status'] == 3) class="btn btn-outline btn-success">支付成功
                                    @elseif ($rows['business_assess']['status'] == 4) class="btn btn-outline btn-danger">审核失败
                                    @elseif ($rows['business_assess']['status'] == 5) class="btn btn-outline btn-danger">业务取消
                                    @endif
                                    </button>
                                @endif
                            </td>
                            @else
                            <td>无</td>
                            @endif
                            <td>
                                @if($rows['type'] == 1) 用户自取
                                @elseif($rows['type'] == 2) 派送银行
                                @elseif($rows['type'] == 3) 发送快递
                                @endif &nbsp;&nbsp;
                                @if(isset($buttonList[28]) && $rows['type'])
                                <button class="btn btn-outline btn-success" type="button" onclick="check('{{$buttonList[28]['namespace']}}','{{$buttonList[28]['action']}}','{{$buttonList[28]['name']}}','{{$rows['bid']}}')">详情</button>
                                @endif
                            </td>
                            <td>
                                @if($rows['isAgency'])
                                是
                                @else
                                否
                                @endif
                            </td>
                            <td>{{$rows['create_dt']}}</td>
                            <td>
                                @if(isset($buttonList[25]))
                                    <button  type="button" onclick="check('{{$buttonList[25]['namespace']}}','{{$buttonList[25]['action']}}','{{$buttonList[25]['name']}}','{{$rows['bid']}}')"
                                    @if ($rows['status'] == 0) class="btn btn-default" disabled>未提交
                                    @elseif ($rows['status'] == 1) class="btn btn-warning" disabled>受理中
                                    @elseif ($rows['status'] == 2) class="btn btn-primary" disabled>物流配送
                                    @elseif ($rows['status'] == 3) class="btn btn-success" disabled>业务成功
                                    @elseif ($rows['status'] == 4) class="btn btn-danger" disabled>业务取消
                                    @endif
                                    </button>
                                @endif
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
    });
    function check(namespace,action,title,id){
        layer.open({
            title :title,
            type: 2,
            area: ['500px', '405px'],
            skin: 'layui-layer-rim', //加上边框
            content: ['/'+namespace+'/'+id+'/'+action, 'no']
        });
    }
</script>
@endsection
