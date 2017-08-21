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
                                        <input class="form-control" name="name" value="{{$userInfo['name']}}">
                                        <span class="help-block"><strong></strong></span>
                                    </div>
                                    <div class="form-group">
                                        <label>邮箱</label>
                                        <input class="form-control" id="disabledInput" type="text" placeholder="{{$userInfo['email']}}" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label>所属用户组</label>
                                        <select class="form-control" name="roleid">
                                            @foreach($userRoleList as $rows)
                                            <option value="{{$rows['roleid']}}" @if($userInfo['roleid'] == $rows['roleid']) selected @endif>{{$rows['name']}}</option>
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
                        parent.location.href="/user/index";
                    });
                }
            },
            error:function(data){
                $.each(data.responseJSON, function (key, value) {
                    var input = '#form input[name=' + key + ']';
                    $(input + '+span>strong').text(value);
                    $(input).parent().addClass('has-error');
                });
            }
        });
    }
    function fromQuit(){
        parent.layer.close(frameindex);
    }
</script>
@endsection
