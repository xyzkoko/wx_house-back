<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Model\System;
use Illuminate\Http\Request;

class SystemController extends Controller
{
    /**
     * 登录验证
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 中介修改
     *
     * @param Request $request
     * @param int $uid
     * @return json
     */
    public function putMoney(Request $request)
    {
        if($request->isMethod('get')){      //跳转页面
            $systemInfo = System::find(1);
            return view('system.putMoney',['systemInfo' => $systemInfo]);
        }elseif($request->isMethod('post')){        //表单请求
            return $this->putMoneyPost($request);
        }
    }
    private function putMoneyPost($request){
        $this->validate($request, [
            'sign_money' => 'integer'
        ],[
            'sign_money.integer' => '网签金额必须是数字'
        ]);
        $data = ['status' => 'success','msg' => '修改成功'];
        $systemInfo = System::find(1);
        $systemInfo->common_value = $request->input('sign_money');
        $result = $systemInfo->save();
        if(!$result){
            $data['status'] = 'fail';
            $data['msg'] = '修改失败';
        }
        return json_encode($data);
    }
}
