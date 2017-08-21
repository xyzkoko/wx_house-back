@extends('layouts.head')
@section('head')
<body>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">&nbsp;</div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <form id="form" action="" method="post">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label>派送方式：
                                            @if($businessInfo['type'] == 1) 自取
                                            @elseif($businessInfo['type'] == 2) 统一派送银行
                                            @elseif($businessInfo['type'] == 3) 快递
                                            @endif
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label>收取人姓名：{{$businessInfo['name']}}</label>
                                    </div>
                                    <div class="form-group">
                                        <label>收取人电话：{{$businessInfo['mobile']}}</label>
                                    </div>
                                    <div class="form-group">
                                        <label>收取人地址：{{$businessInfo['address']}}</label>
                                    </div>
                                    <div class="form-group">
                                        <label>派送状态</label>
                                        <select class="form-control" name="status" @if(($businessInfo['business_sign']['status'] != 2 && $businessInfo['sign']) || ($businessInfo['business_assess']['status'] != 3 && $businessInfo['assess'])) disabled="disabled" @endif>
                                            <option value="1" @if($businessInfo['status'] == 1) selected @endif>未配送</option>
                                            <option value="2" @if($businessInfo['status'] == 2) selected @endif>物流配送</option>
                                            <option value="3" @if($businessInfo['status'] == 3) selected @endif>已接收</option>
                                        </select>
                                    </div>
                                    @if(($businessInfo['business_sign']['status'] != 2 && $businessInfo['sign']) || ($businessInfo['business_assess']['status'] != 3 && $businessInfo['assess']))
                                    <div class="form-group has-error">
                                        <span class="help-block"><strong>请先审核通过网签和评估</strong></span>
                                    </div>
                                    @endif
                                    <button type="button" class="btn btn-default" onclick="fromSubmit();" @if(($businessInfo['business_sign']['status'] != 2 && $businessInfo['sign']) || ($businessInfo['business_assess']['status'] != 3 && $businessInfo['assess'])) disabled="disabled" @endif>确定</button>
                                    <button type="button" class="btn btn-default" onclick="fromQuit();">退出</button>
                                </form>
                            </div>
                        </div>
                        <!-- /.row (nested) -->
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>
    </div>
</body>
<script>
    var frameindex= parent.layer.getFrameIndex(window.name);
    function fromSubmit(){
        $('input+span>strong').text('');
        $('input').parent().removeClass('has-error');
        var data = $('#form').serialize();
        var url = "";
        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            dataType: 'json',
            success: function(data){
                if(data.status=='success'){
                    layer.msg(data.msg, {time:1000}, function(){
                        parent.location.reload();
                    });
                }
            }
        });
    }
    function fromQuit(){
        parent.layer.close(frameindex);
    }
</script>
@endsection
