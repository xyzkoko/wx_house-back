@extends('layouts.app')
@section('app')
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">中介会员修改</h1>
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
                                        <input type="file" id="file_input1" style="display:inline-block;"/>
                                        <input style="display: none;" name="licence_photo" value="">
                                        <span class="help-block"><strong></strong></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>门头照片</label>
                                    <div class="layer-photos">
                                        <img id="head_photo" style="cursor:pointer;" layer-src="data:image/png;base64,{{$memberInfo['head_photo']}}" src="data:image/png;base64,{{$memberInfo['head_photo']}}" height="100" width="100" alt="门头照片">&nbsp;&nbsp;
                                        <input type="file" id="file_input2" style="display:inline-block;"/>
                                        <input style="display: none;" name="head_photo" value="">
                                        <span class="help-block"><strong></strong></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>地址</label>
                                    <input class="form-control" name="address" value="{{$memberInfo['address']}}">
                                    <span class="help-block"><strong></strong></span>
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
                        window.location.href="/member/brokerIndex";
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
        window.location.href="/member/brokerIndex";
    }
    //图片提交
    var licence_photo = document.getElementById("licence_photo");
    var head_photo = document.getElementById("head_photo");
    var file_input1 = document.getElementById("file_input1");
    var file_input2 = document.getElementById("file_input2");
    var input1 = '#form input[name=licence_photo]';
    var input2 = '#form input[name=head_photo]';
    if(typeof FileReader === 'undefined'){
        $(input1 + '+span>strong').text("抱歉，你的浏览器不支持 FileReader");
        $(input1).parent().addClass('has-error');
        $(input2 + '+span>strong').text("抱歉，你的浏览器不支持 FileReader");
        $(input2).parent().addClass('has-error');
        file_input1.setAttribute('disabled','disabled');
        file_input2.setAttribute('disabled','disabled');
    }else{
        file_input1.addEventListener('change',readFile1,false);
        file_input2.addEventListener('change',readFile2,false);
    }
    function readFile1(){
        $(input1 + '+span>strong').text("");
        $(input1).parent().removeClass('has-error');
        var file = this.files[0];
        if(!/image\/\w+/.test(file.type)){
            $(input1 + '+span>strong').text("请确保文件为图像类型");
            $(input1).parent().addClass('has-error');
            return false;
        }
        var reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = function(e){
            licence_photo.setAttribute('src',this.result);
            licence_photo.setAttribute('layer-src',this.result);
            $(input1).val(this.result);
        }
    }
    function readFile2(){
        $(input2 + '+span>strong').text("");
        $(input2).parent().removeClass('has-error');
        var file = this.files[0];
        if(!/image\/\w+/.test(file.type)){
            $(input2 + '+span>strong').text("请确保文件为图像类型");
            $(input2).parent().addClass('has-error');
            return false;
        }
        var reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = function(e){
            head_photo.setAttribute('src',this.result);
            head_photo.setAttribute('layer-src',this.result);
            $(input2).val(this.result);
        }
    }
</script>
@endsection
