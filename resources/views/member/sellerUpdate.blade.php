@extends('layouts.app')
@section('app')
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">商家会员修改</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Basic Form Elements
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <form id="form" action="" method="post">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label>姓名</label>
                                    <input class="form-control" name="nickname" value="{{$memberInfo['member']['nickname']}}">
                                    <span class="help-block"><strong></strong></span>
                                </div>
                                <div class="form-group">
                                    <label>手机号</label>
                                    <input class="form-control" name="mobile" value="{{$memberInfo['member']['mobile']}}">
                                    <span class="help-block"><strong></strong></span>
                                </div>
                                <div class="form-group">
                                    <label>积分</label>
                                    <input class="form-control" name="points" value="{{$memberInfo['member']['points']}}">
                                    <span class="help-block"><strong></strong></span>
                                </div>
                                <div class="form-group">
                                    <label>营业执照</label>
                                    <div class="layer-photos">
                                        <img id="licence_photo" style="cursor:pointer;" layer-src="data:image/png;base64,{{$memberInfo['licence_photo']}}" src="data:image/png;base64,{{$memberInfo['licence_photo']}}" height="100" width="100" alt="营业执照">&nbsp;&nbsp;
                                        <input type="file" id="file_input" style="display:inline-block;"/>
                                        <input style="display: none;" name="licence_photo" value="">
                                        <span class="help-block"><strong></strong></span>
                                    </div>
                                </div>

                                <button type="button" class="btn btn-default" onclick="fromSubmit();">确定</button>
                                <button type="button" class="btn btn-default" onclick="fromQuit();">返回</button>
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
<script>
    $(document).ready(function() {
        layer.photos({
            photos: '.layer-photos',
            anim: 5 //0-6的选择，指定弹出图片动画类型，默认随机（请注意，3.0之前的版本用shift参数）
        });
    });
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
                        window.location.href="/member/sellerIndex";
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
        window.location.href="/member/sellerIndex";
    }
    //图片提交
    var licence_photo = document.getElementById("licence_photo");
    var file_input = document.getElementById("file_input");
    var input = '#form input[name=licence_photo]';
    if(typeof FileReader === 'undefined'){
        $(input + '+span>strong').text("抱歉，你的浏览器不支持 FileReader");
        $(input).parent().addClass('has-error');
        file_input.setAttribute('disabled','disabled');
    }else{
        file_input.addEventListener('change',readFile,false);
    }
    function readFile(){
        $(input + '+span>strong').text("");
        $(input).parent().removeClass('has-error');
        var file = this.files[0];
        if(!/image\/\w+/.test(file.type)){
            $(input + '+span>strong').text("请确保文件为图像类型");
            $(input).parent().addClass('has-error');
            return false;
        }
        var reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = function(e){
            licence_photo.setAttribute('src',this.result);
            licence_photo.setAttribute('layer-src',this.result);
            $(input).val(this.result);
        }
    }
</script>
@endsection
