@extends('layouts.app')
@section('app')
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">网签审核</h1>
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
                                    <label>认证结果</label>&nbsp;&nbsp;
                                    <label class="radio-inline"><input type="radio" name="status" value="2" @if($businessSignInfo['status'] != 3 && $businessSignInfo['status'] != 1) checked @endif @if($businessSignInfo['status'] != 1) disabled="disabled" @endif>审核通过</label>
                                    <label class="radio-inline"><input type="radio" name="status" value="3" @if($businessSignInfo['status'] == 3) checked @endif @if($businessSignInfo['status'] != 1) disabled="disabled" @endif>审核失败</label>
                                    <span class="help-block"><strong></strong></span>
                                </div>
                                <div class="form-group">
                                    <label>认证失败原因</label>
                                    <select class="form-control" name="audit_error" @if($businessSignInfo['status'] != 1) disabled="disabled" @endif>
                                        <option value="0">无</option>
                                        @foreach($checkErrorList as $rows)
                                        <option value="{{$rows['id']}}" @if($businessSignInfo['audit_error'] == $rows['id']) selected @endif>{{$rows['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="button" class="btn btn-default" onclick="fromSubmit();" @if($businessSignInfo['status'] != 1) disabled="disabled" @endif>确定</button>
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
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    卖方信息
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>姓名：{{$businessSignInfo['seller_name']}}</label>
                            </div>
                            <div class="form-group">
                                <label>联系电话：{{$businessSignInfo['seller_mobile']}}</label>
                            </div>
                            <div class="form-group">
                                <label>身份证号码：{{$businessSignInfo['seller_ID']}}</label>
                            </div>
                            <div class="form-group">
                                <label>身份证正面</label>
                                <div class="layer-photos">
                                    <img id="sell_id_photo1" picName = "卖方信息-身份证正面" style="cursor:pointer;" layer-src="data:image/png;base64,{{$businessSignInfo['seller_ID1_photo']}}" src="data:image/png;base64,{{$businessSignInfo['seller_ID1_photo']}}" height="100" width="100" alt="卖方身份证正面">&nbsp;&nbsp;
                                </div>
                            </div>
                            <div class="form-group">
                                <label>身份证反面</label>
                                <div class="layer-photos">
                                    <img id="sell_id_photo2" picName = "卖方信息-身份证反面" style="cursor:pointer;" layer-src="data:image/png;base64,{{$businessSignInfo['seller_ID2_photo']}}" src="data:image/png;base64,{{$businessSignInfo['seller_ID2_photo']}}" height="100" width="100" alt="卖方身份证反面">&nbsp;&nbsp;
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
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    买方信息
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>姓名：{{$businessSignInfo['buyer_name']}}</label>
                            </div>
                            <div class="form-group">
                                <label>联系电话：{{$businessSignInfo['buyer_mobile']}}</label>
                            </div>
                            <div class="form-group">
                                <label>身份证号码：{{$businessSignInfo['buyer_ID']}}</label>
                            </div>
                            <div class="form-group">
                                <label>身份证正面</label>
                                <div class="layer-photos">
                                    <img id="buy_id_photo1" picName = "买方信息-身份证正面" style="cursor:pointer;" layer-src="data:image/png;base64,{{$businessSignInfo['buyer_ID1_photo']}}" src="data:image/png;base64,{{$businessSignInfo['buyer_ID1_photo']}}" height="100" width="100" alt="买方身份证正面">&nbsp;&nbsp;
                                </div>
                            </div>
                            <div class="form-group">
                                <label>身份证反面</label>
                                <div class="layer-photos">
                                    <img id="buy_id_photo2"  picName = "买方信息-身份证反面" style="cursor:pointer;" layer-src="data:image/png;base64,{{$businessSignInfo['buyer_ID2_photo']}}" src="data:image/png;base64,{{$businessSignInfo['buyer_ID2_photo']}}" height="100" width="100" alt="买方身份证反面">&nbsp;&nbsp;
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
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    交易信息
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>成交价(元)：{{$businessSignInfo['business_price']}}</label>
                            </div>
                            <div class="form-group">
                                <label>商贷金额(元)：{{$businessSignInfo['business_loan']}}</label>
                            </div>
                            <div class="form-group">
                                <label>公积金贷款金额(元)：{{$businessSignInfo['business_fund']}}</label>
                            </div>
                            <div class="form-group">
                                <label>买卖合同</label>
                                <div class="layer-photos">
                                    <img id="maimai_photo1" picName = "交易信息-买卖合同" style="cursor:pointer;" layer-src="data:image/png;base64,{{$businessSignInfo['business_photo']}}" src="data:image/png;base64,{{$businessSignInfo['business_photo']}}" height="100" width="100" alt="买卖合同">&nbsp;&nbsp;
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
                    其他信息
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>房产地址：{{$businessSignInfo['house_address']}}</label>
                            </div>
                            <div class="form-group" style="float:left;margin-left:30px;text-align:center;">
                                <label>房产证扫描件1</label>
                                <div class="layer-photos">
                                    <img id="other_fc_photo1" picName = "其他信息-房产证扫描件1" style="cursor:pointer;" layer-src="data:image/png;base64,{{$businessSignInfo['house_prove1_photo']}}" src="data:image/png;base64,{{$businessSignInfo['house_prove1_photo']}}" height="100" width="100" alt="房产证扫描件1">&nbsp;&nbsp;
                                </div>
                            </div>
                            <div class="form-group" style="float:left;margin-left:30px;text-align:center;">
                                <label>房产证扫描件2</label>
                                <div class="layer-photos">
                                    <img id="other_fc_photo2" picName = "其他信息-房产证扫描件2"  style="cursor:pointer;" layer-src="data:image/png;base64,{{$businessSignInfo['house_prove2_photo']}}" src="data:image/png;base64,{{$businessSignInfo['house_prove2_photo']}}" height="100" width="100" alt="房产证扫描件2">&nbsp;&nbsp;
                                </div>
                            </div>
                            <div class="form-group" style="float:left;margin-left:30px;text-align:center;">
                                <label>房产证扫描件3</label>
                                <div class="layer-photos">
                                    <img id="other_fc_photo3" picName = "其他信息-房产证扫描件3"  style="cursor:pointer;" layer-src="data:image/png;base64,{{$businessSignInfo['house_prove3_photo']}}" src="data:image/png;base64,{{$businessSignInfo['house_prove3_photo']}}" height="100" width="100" alt="房产证扫描件3">&nbsp;&nbsp;
                                </div>
                            </div>
                            <div class="form-group" style="float:left;margin-left:30px;text-align:center;">
                                <label>房产证扫描件4</label>
                                <div class="layer-photos">
                                    <img id="other_fc_photo4" picName = "其他信息-房产证扫描件4"  style="cursor:pointer;" layer-src="data:image/png;base64,{{$businessSignInfo['house_prove4_photo']}}" src="data:image/png;base64,{{$businessSignInfo['house_prove4_photo']}}" height="100" width="100" alt="房产证扫描件4">&nbsp;&nbsp;
                                </div>
                            </div>
                            <div class="form-group" style="float:left;margin-left:30px;text-align:center;">
                                <label>维修基金发票扫描件</label>
                                <div class="layer-photos">
                                    <img id="other_wxjj_photo1" picName = "其他信息-维修基金发票扫描件"  style="cursor:pointer;" layer-src="data:image/png;base64,{{$businessSignInfo['house_fund_photo']}}" src="data:image/png;base64,{{$businessSignInfo['house_fund_photo']}}" height="100" width="100" alt="维修基金发票扫描件">&nbsp;&nbsp;
                                </div>
                            </div>
                            <div class="form-group" style="float:left;margin-left:30px;text-align:center;">
                                <label>购房证明扫描件</label>
                                <div class="layer-photos">
                                    <img id="other_house_photo1" picName = "其他信息-购房证明扫描件" style="cursor:pointer;" layer-src="data:image/png;base64,{{$businessSignInfo['house_prove_photo']}}" src="data:image/png;base64,{{$businessSignInfo['house_prove_photo']}}" height="100" width="100" alt="购房证明扫描件">&nbsp;&nbsp;
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
	
	
	
	function downImages(){
		var photo = [];
		var count = 0;
		for(var i = 0; i < 2; i++)
		{
			photo.push( $('#sell_id_photo' + (i+1)))
			photo.push( $('#buy_id_photo' + (i+1)))
		}
		photo.push( $('#maimai_photo1'))
		for(var i = 0; i < 4; i++)
		   photo.push( $('#other_fc_photo'+ (i+1)))
		
		photo.push( $('#other_wxjj_photo1'))
		photo.push( $('#other_house_photo1'))
		
		
		
		
	
       var i= setInterval(function() {
           console.info('dd');
           console.info(photo[count].attr('picName'));
		   if(photo[count][0].src != "data:image/png;base64,")
		   {
			   var $a = $("<a></a>").attr("href", photo[count][0].src).attr("download", photo[count].attr('picName') + ".png");
              $a[0].click();
		   }  
		   count++;
           if (count >= 11)
                clearInterval(i);
        }, 100);
		
	 
			  
		   
		
	}
	
</script>
@endsection
