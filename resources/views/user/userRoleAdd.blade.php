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
                                    <label>用户组</label>
                                    <input class="form-control" name="name">
                                    <span class="help-block"><strong></strong></span>
                                </div>
                                <div class="form-group">
                                    <label>权限</label>
                                    @foreach ($menuAdd as $rows)
                                    <div class="form-group">
                                        <label class="checkbox-inline"><input type="checkbox" name="rule[]" value="{{$rows['id']}}" checked>{{$rows['name']}}</label>
                                        @if(isset($rows['child']))
                                        <div class="form-group" style="margin-left: 30px;">
                                            @foreach ($rows['child'] as $rows2)
                                            ┠─&nbsp;&nbsp;<label class="checkbox-inline"><input type="checkbox" name="rule[]" value="{{$rows2['id']}}">{{$rows2['name']}}</label><br/>
                                            @if(isset($rows2['child']))
                                            <div class="form-group" style="margin-left: 60px;">┠─&nbsp;&nbsp;
                                                @foreach ($rows2['child'] as $rows3)
                                                <label class="checkbox-inline"><input type="checkbox" name="rule[]" value="{{$rows3['id']}}">{{$rows3['name']}}</label>
                                                @endforeach
                                            </div>
                                            @endif
                                            @endforeach
                                        </div>
                                        @endif
                                    </div><hr/>
                                    @endforeach
                                </div>
                                <button type="button" class="btn btn-default" onclick="fromSubmit()">确定</button>
                                <button type="button" class="btn btn-default" onclick="fromQuit()">退出</button>
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
                        parent.location.href="/userRole/index";
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