<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Model\CheckError;
use App\Model\Member;
use App\Model\MemberBank;
use App\Model\MemberBroker;
use App\Model\MemberSeller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\Rule;
use JiGuang\JSMS;

class MemberController extends Controller
{
    /**
     * 登录验证
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 中介列表
     * @return view
     */
    public function brokerIndex()
    {
        $memberList = MemberBroker::with('member')->get()->toArray();
        return view('member.broker', ['memberList' => $memberList]);
    }

    /**
     * 中介修改
     *
     * @param Request $request
     * @param int $uid
     * @return json
     */
    public function brokerUpdate(Request $request,$uid)
    {
        if($request->isMethod('get')){      //跳转页面
            $memberInfo = MemberBroker::with('member')->find($uid);
            return view('member.brokerUpdate',['memberInfo' => $memberInfo]);
        }elseif($request->isMethod('post')){        //表单请求
            return $this->brokerUpdatePost($request,$uid);
        }
    }
    private function brokerUpdatePost($request,$uid){
        $this->validate($request, [
            'mobile' => ['required',Rule::unique('pa_user')->ignore($uid,'uid'),'max:11'],
            'points' => 'bail|required|integer',
            'address' => 'required',
        ],[
            'mobile.required' => '手机号不能为空',
            'mobile.unique' => '该手机号已注册',
            'mobile.max' => '手机最大长度为11',
            'points.image' => '积分必须是数字',
            'address.required' => '地址不能为空'
        ]);
        $data = ['status' => 'success','msg' => '修改成功'];
        $memberInfo = Member::find($uid);
        $memberInfo->nickname = $request->input('nickname');
        $memberInfo->mobile = $request->input('mobile');
        $memberInfo->points = $request->input('points');
        $result1 = $memberInfo->save();
        $memberBrokerInfo = MemberBroker::find($uid);
        $memberBrokerInfo->address = $request->input('address');
        if($request->input('licence_photo')){
            $memberBrokerInfo->licence_photo = substr(strstr($request->input('licence_photo'), ','),1);
        }
        if($request->input('head_photo')){
            $memberBrokerInfo->head_photo = substr(strstr($request->input('head_photo'), ','),1);
        }
        $result2 = $memberBrokerInfo->save();
        if(!$result1 || !$result2){
            $data['status'] = 'fail';
            $data['msg'] = '修改失败';
        }
        return json_encode($data);
    }

    /**
     * 银行列表
     * @return view
     */
    public function bankIndex()
    {
        $memberList = MemberBank::with('member')->get()->toArray();
        return view('member.bank', ['memberList' => $memberList]);
    }

    /**
     * 银行修改
     *
     * @param Request $request
     * @param int $uid
     * @return json
     */
    public function bankUpdate(Request $request,$uid)
    {
        if($request->isMethod('get')){      //跳转页面
            $memberInfo = MemberBank::with('member')->find($uid);
            return view('member.bankUpdate',['memberInfo' => $memberInfo]);
        }elseif($request->isMethod('post')){        //表单请求
            return $this->bankUpdatePost($request,$uid);
        }
    }
    private function bankUpdatePost($request,$uid){
        $this->validate($request, [
            'mobile' => ['required',Rule::unique('pa_user')->ignore($uid,'uid'),'max:11'],
            'points' => 'bail|required|integer',
            'bank_name' => 'required',
        ],[
            'mobile.required' => '手机号不能为空',
            'mobile.unique' => '该手机号已注册',
            'mobile.max' => '手机最大长度为11',
            'points.image' => '积分必须是数字',
            'bank_name.required' => '银行名称不能为空'
        ]);
        $data = ['status' => 'success','msg' => '修改成功'];
        $memberInfo = Member::find($uid);
        $memberInfo->nickname = $request->input('nickname');
        $memberInfo->mobile = $request->input('mobile');
        $memberInfo->points = $request->input('points');
        $result1 = $memberInfo->save();
        $memberBankInfo = MemberBank::find($uid);
        $memberBankInfo->bank_name = $request->input('bank_name');
        $result2 = $memberBankInfo->save();
        if(!$result1 || !$result2){
            $data['status'] = 'fail';
            $data['msg'] = '修改失败';
        }
        return json_encode($data);
    }

    /**
     * 银行添加
     *
     * @param Request $request
     * @param int $uid
     * @return json
     */
    public function bankCreate(Request $request)
    {
        if($request->isMethod('get')){      //跳转页面
            return view('member.bankCreate');
        }elseif($request->isMethod('post')){        //表单请求
            return $this->bankCreatePost($request);
        }
    }
    public function bankCreatePost(Request $request)
    {
        $this->validate($request, [
            'mobile' => [
                'required',
                Rule::unique('pa_user')->where(function ($query) {
                    $query->where('roleid', '1');
                }),
                'max:11'
            ],
            'bank_name' => 'required'
        ],[
            'mobile.required' => '手机号不能为空',
            'mobile.unique' => '该手机号已注册为银行会员',
            'mobile.max' => '手机最大长度为11',
            'bank_name.required' => '银行不能为空'
        ]);
        $data = ['status' => 'success','msg' => '修改成功'];
        $result = Member::where('mobile',$request->input('mobile'))->first();
        if($result){
            $uid = $result->uid;
            MemberSeller::destroy($uid);
            MemberBroker::destroy($uid);
            $memberInfo = Member::find($uid);
        }else{
            $memberInfo = new Member();
        }
        $memberInfo->roleid = 1;
        $memberInfo->mobile = $request->input('mobile');
        $memberInfo->create_dt = date("Y-m-d H:i:s");
        $result1 = $memberInfo->save();
        if($result1){
            $uid = $memberInfo->uid;
            $memberBankInfo = new MemberBank;
            $memberBankInfo->uid = $uid;
            $memberBankInfo->bank_name = $request->input('bank_name');
            $result2 = $memberBankInfo->save();
            if(!$result2){
                $data['status'] = 'fail';
                $data['msg'] = '修改失败';
            }
        }
        if(!$result1){
            $data['status'] = 'fail';
            $data['msg'] = '修改失败';
        }
        return json_encode($data);
    }

    /**
     * 商家列表
     * @return view
     */
    public function sellerIndex()
    {
        $memberList = MemberSeller::with('member')->get()->toArray();
        return view('member.seller', ['memberList' => $memberList]);
    }

    /**
     * 商家修改
     *
     * @param Request $request
     * @param int $uid
     * @return json
     */
    public function sellerUpdate(Request $request,$uid)
    {
        if($request->isMethod('get')){      //跳转页面
            $memberInfo = MemberSeller::with('member')->find($uid);
            return view('member.sellerUpdate',['memberInfo' => $memberInfo]);
        }elseif($request->isMethod('post')){        //表单请求
            return $this->sellerUpdatePost($request,$uid);
        }
    }
    private function sellerUpdatePost($request,$uid){
        $this->validate($request, [
            'mobile' => ['required',Rule::unique('pa_user')->ignore($uid,'uid'),'max:11'],
            'points' => 'bail|required|integer'
        ],[
            'mobile.required' => '手机号不能为空',
            'mobile.unique' => '该手机号已注册',
            'mobile.max' => '手机最大长度为11',
            'points.image' => '积分必须是数字'
        ]);
        $data = ['status' => 'success','msg' => '修改成功'];
        $memberInfo = Member::find($uid);
        $memberInfo->nickname = $request->input('nickname');
        $memberInfo->mobile = $request->input('mobile');
        $memberInfo->points = $request->input('points');
        $result1 = $memberInfo->save();
        $memberSellerInfo = MemberSeller::find($uid);
        if($request->input('licence_photo')){
            $memberSellerInfo->licence_photo = substr(strstr($request->input('licence_photo'), ','),1);
        }
        $result2 = $memberSellerInfo->save();
        if(!$result1 || !$result2){
            $data['status'] = 'fail';
            $data['msg'] = '修改失败';
        }
        return json_encode($data);
    }

    /**
     * 银行添加
     *
     * @param Request $request
     * @param int $uid
     * @return json
     */
    public function sellerCreate(Request $request)
    {
        if($request->isMethod('get')){      //跳转页面
            return view('member.sellerCreate');
        }elseif($request->isMethod('post')){        //表单请求
            return $this->sellerCreatePost($request);
        }
    }
    public function sellerCreatePost(Request $request)
    {
        $this->validate($request, [
            'mobile' => [
                'required',
                Rule::unique('pa_user')->where(function ($query) {
                    $query->where('roleid', '3');
                }),
                'max:11'
            ],
            'licence_photo' => 'required'
        ],[
            'mobile.required' => '手机号不能为空',
            'mobile.unique' => '该手机号已注册商家会员',
            'mobile.max' => '手机最大长度为11',
            'licence_photo.required' => '营业执照不能为空'
        ]);
        $data = ['status' => 'success','msg' => '修改成功'];
        $result = Member::where('mobile',$request->input('mobile'))->first();
        if($result){
            $uid = $result->uid;
            MemberBank::destroy($uid);
            MemberBroker::destroy($uid);
            $memberInfo = Member::find($uid);
        }else{
            $memberInfo = new Member();
        }
        $memberInfo->roleid = 3;
        $memberInfo->mobile = $request->input('mobile');
        $memberInfo->create_dt = date("Y-m-d H:i:s");
        $result1 = $memberInfo->save();
        if($result1){
            $uid = $memberInfo->uid;
            $memberSellerInfo = new MemberSeller;
            $memberSellerInfo->uid = $uid;
            $memberSellerInfo->licence_photo = substr(strstr($request->input('licence_photo'), ','),1);
            $result2 = $memberSellerInfo->save();
            if(!$result2){
                $data['status'] = 'fail';
                $data['msg'] = '修改失败';
            }
        }
        if(!$result1){
            $data['status'] = 'fail';
            $data['msg'] = '修改失败';
        }
        return json_encode($data);
    }

    /**
     * 角色认证
     *
     * @param Request $request
     * @param int $uid
     * @return json
     */
    public function roleCheck(Request $request,$uid)
    {
        if($request->isMethod('get')){      //跳转页面
            $memberInfo = Member::find($uid);
            switch($memberInfo->roleid){
                case 1:
                    $memberInfo = MemberBank::with('member')->find($uid);
                    break;
                case 2:
                    $memberInfo = MemberBroker::with('member')->find($uid);
                    break;
                case 3:
                    $memberInfo = MemberSeller::with('member')->find($uid);
                    break;
            }
            $checkErrorList = CheckError::all()->toArray();
            return view('member.roleCheck',['memberInfo' => $memberInfo,'checkErrorList' => $checkErrorList]);
        }elseif($request->isMethod('post')){        //表单请求
            return $this->roleCheckPost($request,$uid);
        }
    }

    private function roleCheckPost($request,$uid){
        $data = ['status' => 'success','msg' => '修改成功'];
        $memberInfo = Member::find($uid);
        switch($memberInfo->roleid){
            case 1:
                $memberInfo = MemberBank::with('member')->find($uid);
                break;
            case 2:
                $memberInfo = MemberBroker::with('member')->find($uid);
                break;
            case 3:
                $memberInfo = MemberSeller::with('member')->find($uid);
                break;
        }
        $memberInfo->status = $request->input('status');
        if($request->input('status') == 2){
            $memberInfo->audit_error = null;
        }
        if($request->input('status') == 3){
            $memberInfo->audit_error = $request->input('audit_error');
        }
        $result = $memberInfo->save();
        if(!$result){
            $data['status'] = 'fail';
            $data['msg'] = '修改失败';
        }else{
            $app_key = Config::get('constants.jsms.appkey');
            $master_secret = Config::get('constants.jsms.DevSecret');
            $client = new JSMS($app_key, $master_secret, [ 'ssl_verify' => false ]);
            if($memberInfo->status == 2){
                $memberInfo = Member::find($uid);
                //$result = $client->sendMessage($memberInfo->mobile, '125170');
                $send['touser'] = $memberInfo->openid;
                $send['template_id'] = 'qmY3BDT1XsQ1F3BRyp2G-3nkK8ag70S506BHA6MXizA';
                $send['url'] = 'http://www.allwinits.com/?service=WeiChat.Index&state=userInfo';
                $send['data']['first']['value'] = '审核结果提醒';
                $send['data']['first']['color'] = '#173177';
                $send['data']['keyword1']['value'] = $memberInfo->nickname;
                $send['data']['keyword1']['color'] = '#173177';
                $send['data']['keyword2']['value'] = $memberInfo->mobile;
                $send['data']['keyword2']['color'] = '#173177';
                $send['data']['keyword3']['value'] = '审核通过';
                $send['data']['keyword3']['color'] = '#173177';
                $send['data']['remark']['value'] = '您的资料审核已经通过，感谢您的使用！';
                $send['data']['remark']['color'] = '#173177';
                $res = $this->curl('http://www.allwinits.com/?service=WeiChat.SendTemplate',$send);
            }elseif($memberInfo->status == 3){
                if($request->input('audit_error')){
                    $memberInfo = Member::find($uid);
                    //$result = $client->sendMessage($memberInfo->mobile, $request->input('audit_error'),array());
                }
            }
        }
        return json_encode($res);
    }

    private function curl($url,$data = null){
        $context   = stream_context_create(array('http' => array(
            'method' => 'POST',
            'header'  => 'Content-type: application/x-www-form-urlencoded',
            'content' => http_build_query($data),
            'timeout' => 20
        )));
        return file_get_contents($url,false,$context);
    }
}
