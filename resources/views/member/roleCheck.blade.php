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
                                        <label>姓名</label>
                                        <input class="form-control" value="{{$memberInfo['member']['nickname']}}" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label>认证结果</label>&nbsp;&nbsp;
                                        <label class="radio-inline"><input type="radio" name="status" value="1" @if($memberInfo['status'] == 1) checked @endif>认证中</label>
                                        <label class="radio-inline"><input type="radio" name="status" value="2" @if($memberInfo['status'] == 2) checked @endif>认证成功</label>
                                        <label class="radio-inline"><input type="radio" name="status" value="3" @if($memberInfo['status'] == 3) checked @endif>认证失败</label>
                                    </div>
                                    <div class="form-group">
                                        <label>认证失败原因</label>
                                        <select class="form-control" name="audit_error">
                                            <option value="0">无</option>
                                            @foreach($checkErrorList as $rows)
                                            <option value="{{$rows['id']}}" @if($memberInfo['audit_error'] == $rows['id']) selected @endif>{{$rows['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="button" class="btn btn-default" onclick="fromSubmit();">确定</button>
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
