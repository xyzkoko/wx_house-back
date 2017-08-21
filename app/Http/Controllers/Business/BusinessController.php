<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Model\Business;
use App\Model\BusinessAssess;
use App\Model\BusinessSign;
use Illuminate\Http\Request;
use App\Model\CheckError;

class BusinessController extends Controller
{
    /**
     * 登录验证
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 业务列表
     * @return view
     */
    public function index()
    {
        $businessList = Business::with(['business_sign'=>function($query1){
            $query1->select('bid','money','status');
        }])->with(['business_assess'=>function($query2){
            $query2->select('bid','money','status');
        }])->with('member')->where('status','!=','0')->get()->toArray();
        return view('business.index', ['businessList' => $businessList]);
    }

    /**
     * 网签审核
     * @return view
     */
    public function signStatus(Request $request,$bid)
    {
        if($request->isMethod('get')){      //跳转页面
            $businessSignInfo = BusinessSign::with('member')->find($bid);
            $checkErrorList = CheckError::all()->toArray();
            return view('business.signStatus',['businessSignInfo' => $businessSignInfo,'checkErrorList' => $checkErrorList]);
        }elseif($request->isMethod('post')){        //表单请求
            return $this->signStatusPost($request,$bid);
        }
    }
    public function signStatusPost(Request $request,$bid)
    {
        $this->validate($request, [
            'status' => ['required']
        ],[
            'status.required' => '请选择审核状态'
        ]);
        $data = ['status' => 'success','msg' => '修改成功'];
        $businessSignInfo = BusinessSign::find($bid);
        $businessSignInfo->status = $request->input('status');
        if($request->input('status') == 3){
            $businessSignInfo->audit_error = $request->input('audit_error');
        }
        $businessSignInfo->update_dt = date("Y-m-d H:i:s");
        $result1 = $businessSignInfo->save();
        if(!$result1){
            $data['status'] = 'fail';
            $data['msg'] = '修改失败';
        }
        return json_encode($data);
    }

    /**
     * 评估审核
     * @return view
     */
    public function assessStatus(Request $request,$bid)
    {
        if($request->isMethod('get')){      //跳转页面
            $businessAssessInfo = BusinessAssess::with('member')
                ->with(['business_sign'=>function($query1){
                $query1->select('bid','status');
            }])->with(['business'=>function($query2){
                    $query2->select('bid','sign');
                }])->find($bid);
            $checkErrorList = CheckError::all()->toArray();
            return view('business.assessStatus',['businessAssessInfo' => $businessAssessInfo,'checkErrorList' => $checkErrorList]);
        }elseif($request->isMethod('post')){        //表单请求
            return $this->assessStatusPost($request,$bid);
        }
    }
    public function assessStatusPost(Request $request,$bid)
    {
        $this->validate($request, [
            'status' => ['required'],
            'money' => ['required']
        ],[
            'status.required' => '请选择审核状态',
            'money.required' => '请填写评估所需金额'
        ]);
        $data = ['status' => 'success','msg' => '修改成功'];
        $businessAssessInfo = BusinessAssess::find($bid);
        $businessAssessInfo->status = $request->input('status');
        if($request->input('status') == 4){
            $businessAssessInfo->audit_error = $request->input('audit_error');
        }
        $businessAssessInfo->money = $request->input('money');
        $businessAssessInfo->update_dt = date("Y-m-d H:i:s");
        $result1 = $businessAssessInfo->save();
        if(!$result1){
            $data['status'] = 'fail';
            $data['msg'] = '修改失败';
        }
        return json_encode($data);
    }

    /**
     * 查看物流信息
     * @return view
     */
    public function type(Request $request,$bid)
    {
        if($request->isMethod('get')){      //跳转页面
            $businessInfo = Business::with(['business_sign'=>function($query1){
                $query1->select('bid','money','status');
            }])->with(['business_assess'=>function($query2){
                $query2->select('bid','money','status');
            }])->find($bid);
            return view('business.type',['businessInfo' => $businessInfo]);
        }elseif($request->isMethod('post')){        //表单请求
            return $this->typePost($request,$bid);
        }
    }
    public function typePost(Request $request,$bid)
    {
        $data = ['status' => 'success','msg' => '修改成功'];
        if($request->input('status')){
            $businessInfo = Business::find($bid);
            $businessInfo->status = $request->input('status');
            $result1= $businessInfo->save();
            if(!$result1){
                $data['status'] = 'fail';
                $data['msg'] = '修改失败';
            }
        }
        return json_encode($data);
    }
}
