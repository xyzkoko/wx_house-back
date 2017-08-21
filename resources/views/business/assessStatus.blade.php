@extends('layouts.app')
@section('app')
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">评估审核</h1>
        </div>
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
                                    <label>认证结果</label>
                                    <label class="radio-inline"><input type="radio" name="status" value="2" @if($businessAssessInfo['status'] != 4 && $businessAssessInfo['status'] != 1) checked @endif @if($businessAssessInfo['status'] != 1 || ($businessAssessInfo['business_sign']['status'] != 2 && $businessAssessInfo['business']['sign'])) disabled="disabled" @endif>审核通过</label>
                                    <label class="radio-inline"><input type="radio" name="status" value="4" @if($businessAssessInfo['status'] == 4) checked @endif @if($businessAssessInfo['status'] != 1 || ($businessAssessInfo['business_sign']['status'] != 2 && $businessAssessInfo['business']['sign'])) disabled="disabled" @endif>审核失败</label>
                                    <span class="help-block"><strong></strong></span>
                                </div>
                                <div class="form-group">
                                    <label>评估所需金额</label>
                                    <input class="form-control" name="money" value="{{$businessAssessInfo['money']}}" @if($businessAssessInfo['status'] != 1 || ($businessAssessInfo['business_sign']['status'] != 2 && $businessAssessInfo['business']['sign'])) disabled @endif>
                                    <span class="help-block"><strong></strong></span>
                                </div>
                                <div class="form-group">
                                    <label>认证失败原因</label>
                                    <select class="form-control" name="audit_error" @if($businessAssessInfo['status'] != 1 || ($businessAssessInfo['business_sign']['status'] != 2 && $businessAssessInfo['business']['sign'])) disabled="disabled" @endif>
                                        <option value="0">无</option>
                                        @foreach($checkErrorList as $rows)
                                        <option value="{{$rows['id']}}" @if($businessAssessInfo['audit_error'] == $rows['id']) selected @endif>{{$rows['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @if($businessAssessInfo['business_sign']['status'] != 2 && $businessAssessInfo['business']['sign'])
                                <div class="form-group has-error">
                                    <span class="help-block"><strong>请先审核通过网签</strong></span>
                                </div>
                                @endif
                                <button type="button" class="btn btn-default" onclick="fromSubmit();" @if($businessAssessInfo['status'] != 1 || ($businessAssessInfo['business_sign']['status'] != 2 && $businessAssessInfo['business']['sign'])) disabled="disabled" @endif>确定</button>
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
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>报告使用银行：{{$businessAssessInfo['bank_name']}}</label>
                            </div>
                        </div>
                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    房屋外部照片
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group" style="float:left;margin-left:30px;text-align:center;">
                                <label>外部图1</label>
                                <div class="layer-photos">
                                    <img id="head_photo1" picName = "房屋外部照片-外部图1" style="cursor:pointer;" layer-src="data:image/png;base64,{{$businessAssessInfo['house_out1_photo']}}" src="data:image/png;base64,{{$businessAssessInfo['house_out1_photo']}}" height="100" width="100" alt="外部图1">&nbsp;&nbsp;
                                </div>
                            </div>
                            <div class="form-group" style="float:left;margin-left:30px;text-align:center;">
                                <label>外部图2</label>
                                <div class="layer-photos">
                                    <img id="head_photo2" picName = "房屋外部照片-外部图2" style="cursor:pointer;" layer-src="data:image/png;base64,{{$businessAssessInfo['house_out2_photo']}}" src="data:image/png;base64,{{$businessAssessInfo['house_out2_photo']}}" height="100" width="100" alt="外部图2">&nbsp;&nbsp;
                                </div>
                            </div>
                            <div class="form-group" style="float:left;margin-left:30px;text-align:center;">
                                <label>外部图3</label>
                                <div class="layer-photos">
                                    <img id="head_photo3" picName = "房屋外部照片-外部图3" style="cursor:pointer;" layer-src="data:image/png;base64,{{$businessAssessInfo['house_out3_photo']}}" src="data:image/png;base64,{{$businessAssessInfo['house_out3_photo']}}" height="100" width="100" alt="外部图3">&nbsp;&nbsp;
                                </div>
                            </div>
                            <div class="form-group" style="float:left;margin-left:30px;text-align:center;">
                                <label>外部图4</label>
                                <div class="layer-photos">
                                    <img id="head_photo4" picName = "房屋外部照片-外部图4" style="cursor:pointer;" layer-src="data:image/png;base64,{{$businessAssessInfo['house_out4_photo']}}" src="data:image/png;base64,{{$businessAssessInfo['house_out4_photo']}}" height="100" width="100" alt="外部图4">&nbsp;&nbsp;
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    房屋内部照片
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group" style="float:left;margin-left:30px;text-align:center;">
                                <label>卧室1</label>
                                <div class="layer-photos">
                                    <img id="inner_photo1" picName = "房屋内部照片-卧室1" style="cursor:pointer;" layer-src="data:image/png;base64,{{$businessAssessInfo['house_bedroom1_photo']}}" src="data:image/png;base64,{{$businessAssessInfo['house_bedroom1_photo']}}" height="100" width="100" alt="卧室1">&nbsp;&nbsp;
                                </div>
                            </div>
                            <div class="form-group" style="float:left;margin-left:30px;text-align:center;">
                                <label>卧室2</label>
                                <div class="layer-photos">
                                    <img id="inner_photo2" picName = "房屋内部照片-卧室2" style="cursor:pointer;" layer-src="data:image/png;base64,{{$businessAssessInfo['house_bedroom2_photo']}}" src="data:image/png;base64,{{$businessAssessInfo['house_bedroom2_photo']}}" height="100" width="100" alt="卧室2">&nbsp;&nbsp;
                                </div>
                            </div>
                            <div class="form-group" style="float:left;margin-left:30px;text-align:center;">
                                <label>卧室3</label>
                                <div class="layer-photos">
                                    <img id="inner_photo3" picName = "房屋内部照片-卧室3" style="cursor:pointer;" layer-src="data:image/png;base64,{{$businessAssessInfo['house_bedroom3_photo']}}" src="data:image/png;base64,{{$businessAssessInfo['house_bedroom3_photo']}}" height="100" width="100" alt="卧室3">&nbsp;&nbsp;
                                </div>
                            </div>
                            <div class="form-group" style="float:left;margin-left:30px;text-align:center;">
                                <label>客厅1</label>
                                <div class="layer-photos">
                                    <img id="inner_photo4" picName = "房屋内部照片-客厅1" style="cursor:pointer;" layer-src="data:image/png;base64,{{$businessAssessInfo['house_living1_photo']}}" src="data:image/png;base64,{{$businessAssessInfo['house_living1_photo']}}" height="100" width="100" alt="客厅1">&nbsp;&nbsp;
                                </div>
                            </div>
                            <div class="form-group" style="float:left;margin-left:30px;text-align:center;">
                                <label>客厅2</label>
                                <div class="layer-photos">
                                    <img id="inner_photo5" picName = "房屋内部照片-客厅2" style="cursor:pointer;" layer-src="data:image/png;base64,{{$businessAssessInfo['house_living2_photo']}}" src="data:image/png;base64,{{$businessAssessInfo['house_living2_photo']}}" height="100" width="100" alt="客厅2">&nbsp;&nbsp;
                                </div>
                            </div>
                            <div class="form-group" style="float:left;margin-left:30px;text-align:center;">
                                <label>客厅3</label>
                                <div class="layer-photos">
                                    <img id="inner_photo6" picName = "房屋内部照片-客厅3" style="cursor:pointer;" layer-src="data:image/png;base64,{{$businessAssessInfo['house_living3_photo']}}" src="data:image/png;base64,{{$businessAssessInfo['house_living3_photo']}}" height="100" width="100" alt="客厅3">&nbsp;&nbsp;
                                </div>
                            </div>
                            <div class="form-group" style="float:left;margin-left:30px;text-align:center;">
                                <label>厨房1</label>
                                <div class="layer-photos">
                                    <img id="inner_photo7" picName = "房屋内部照片-厨房1" style="cursor:pointer;" layer-src="data:image/png;base64,{{$businessAssessInfo['house_kitchen1_photo']}}" src="data:image/png;base64,{{$businessAssessInfo['house_kitchen1_photo']}}" height="100" width="100" alt="厨房1">&nbsp;&nbsp;
                                </div>
                            </div>
                            <div class="form-group" style="float:left;margin-left:30px;text-align:center;">
                                <label>厨房2</label>
                                <div class="layer-photos">
                                    <img id="inner_photo8" picName = "房屋内部照片-厨房2" style="cursor:pointer;" layer-src="data:image/png;base64,{{$businessAssessInfo['house_kitchen2_photo']}}" src="data:image/png;base64,{{$businessAssessInfo['house_kitchen2_photo']}}" height="100" width="100" alt="厨房2">&nbsp;&nbsp;
                                </div>
                            </div>
                            <div class="form-group" style="float:left;margin-left:30px;text-align:center;">
                                <label>卫生间1</label>
                                <div class="layer-photos">
                                    <img id="inner_photo9" picName = "房屋内部照片-卫生间1" style="cursor:pointer;" layer-src="data:image/png;base64,{{$businessAssessInfo['house_toilet1_photo']}}" src="data:image/png;base64,{{$businessAssessInfo['house_toilet1_photo']}}" height="100" width="100" alt="卫生间1">&nbsp;&nbsp;
                                </div>
                            </div>
                            <div class="form-group" style="float:left;margin-left:30px;text-align:center;">
                                <label>卫生间2</label>
                                <div class="layer-photos">
                                    <img id="inner_photo10" picName = "房屋内部照片-卫生间2" style="cursor:pointer;" layer-src="data:image/png;base64,{{$businessAssessInfo['house_toilet2_photo']}}" src="data:image/png;base64,{{$businessAssessInfo['house_toilet2_photo']}}" height="100" width="100" alt="卫生间2">&nbsp;&nbsp;
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
		<div class="col-sm-12 col-xs-12">
		<button onClick = "downImages()" type="button" style="font-size:40px;padding-left:30px;padding-right:30px;color:#ffffff;background-color:#258ee7;margin-bottom:100px" class="btn col-sm-12 col-xs-12">批量下载</button>
		</div>
    </div>
</div>
<script>
    $(document).ready(function() {
        layer.photos({
            photos: '.layer-photos',
            anim: 5 //0-6的选择，指定弹出图片动画类型，默认随机（请注意，3.0之前的版本用shift参数）
        });
		
	
    });
var Sys = {}; 
var ua = navigator.userAgent.toLowerCase(); 
if (window.ActiveXObject) 
Sys.ie = ua.match(/msie ([\d.]+)/)[1] 
else if (document.getBoxObjectFor) 
Sys.firefox = ua.match(/firefox\/([\d.]+)/)[1] 
else if (window.MessageEvent && !document.getBoxObjectFor) 
Sys.chrome = ua.match(/chrome\/([\d.]+)/)[1] 
else if (window.opera) 
Sys.opera = ua.match(/opera.([\d.]+)/)[1] 
else if (window.openDatabase) 
Sys.safari = ua.match(/version\/([\d.]+)/)[1]; 
//以下进行测试 
if(Sys.ie) document.write('IE: '+Sys.ie); 
if(Sys.firefox) document.write('Firefox: '+Sys.firefox); 
if(Sys.chrome) {document.write('Chrome: '+Sys.chrome);alert('hs')} 
if(Sys.opera) document.write('Opera: '+Sys.opera); 
if(Sys.safari) document.write('Safari: '+Sys.safari); 
	
	function downImages(){
		var photo = [];
		var count = 0;
		for(var i = 0; i < 4; i++)
		{
			photo.push( $('#head_photo' + (i+1)))
			//console.info(photo[i][0].src);
			
		}
		
		for(var i = 0; i < 10; i++)
		{
			photo.push( $('#inner_photo' + (i+1)))
			//console.info(photo[i][0].src);
			
		}
		
		
		
	
       var i= setInterval(function() {
           console.info('dd');
           console.info(photo[count].attr('picName'));
			   var $a = $("<a></a>").attr("href", photo[count][0].src).attr("download", photo[count].attr('picName') + ".png");
              $a[0].click();
			  
			 count++;
            if (count >= 14)
                clearInterval(i);
        }, 100);
		
	 
			  
		   
		
	}
	
    function fromSubmit(){
        $('.help-block>strong').text('');
        $('.help-block').parent().removeClass('has-error');
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
                        window.location.href="/business/index";
                    });
                }
            },
            error:function(data){
                $.each(data.responseJSON, function (key, value) {
                    $('.help-block>strong').text(value);
                    $('.help-block').parent().addClass('has-error');
                });
            }
        });
    }
    function fromQuit(){
        window.location.href="/business/index";
    }
</script>
@endsection
