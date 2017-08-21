<?php

namespace App\Http\Controllers\User;

use App\Model\User;
use App\Model\UserRole;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * 登录验证
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 用户列表
     * @return view
     */
    public function index()
    {
        $userList = User::with('userRole')->get()->toArray();
        return view('user.user', ['userList' => $userList]);
    }
    /**
     * 添加用户
     *
     * @param Request $request
     * @return json
     */
    public function create(Request $request)
    {
        if($request->isMethod('get')){      //跳转页面
            $userRoleList = UserRole::where('disabled','<>',1)->where('roleid','>=',Auth::user()->roleid)->orderBy('listorder','desc')->get();
            return view('user.userAdd', ['userRoleList' => $userRoleList]);
        }elseif($request->isMethod('post')){        //表单请求
            return $this->createPost($request);
        }
    }
    private function createPost($request){
        $this->validate($request, [
            'name' => 'bail|required|unique:la_users|max:10',
            'email' => 'bail|required|unique:la_users|max:20|email',
            'password' => 'bail|required|max:10'
        ],[
            'name.required' => '姓名不能为空',
            'name.unique' => '姓名不能重复',
            'name.max' => '姓名最大长度为10',
            'email.required' => '邮箱不能为空',
            'email.unique' => '邮箱不能重复',
            'email.max' => '邮箱最大长度为20',
            'email.email' => '邮箱格式不对',
            'password.required' => '密码不能为空',
            'password.max' => '密码最大长度为10'
        ]);
        $data = ['status' => 'success','msg' => '添加成功'];
        $userInfo = new User;
        $userInfo->name = $request->input('name');
        $userInfo->roleid = $request->input('roleid');
        $userInfo->email = $request->input('email');
        $userInfo->password = bcrypt($request->input('password'));
        $result = $userInfo->save();
        if(!$result){
            $data['status'] = 'fail';
            $data['msg'] = '添加失败';
        }
        return json_encode($data);
    }
    /**
     * 更新指定用户
     *
     * @param Request $request
     * @param int $id
     * @return json
     */
    public function update(Request $request,$id)
    {
        if($request->isMethod('get')){      //跳转页面
            $userInfo = User::with('userRole')->find($id);
            $userRoleList = UserRole::where('disabled','<>',1)->where('roleid','>=',Auth::user()->roleid)->orderBy('listorder','desc')->get();
            return view('user.userUpdate',['userInfo' => $userInfo,'userRoleList' => $userRoleList]);
        }elseif($request->isMethod('post')){        //表单请求
            return $this->updatePost($request,$id);
        }
    }
    private function updatePost($request,$id){
        $this->validate($request, [
            'name' => ['required',Rule::unique('la_users')->ignore($id),'max:10']
        ],[
            'name.required' => '姓名不能为空',
            'name.unique' => '姓名不能重复',
            'name.max' => '姓名最大长度为10'
        ]);
        $data = ['status' => 'success','msg' => '修改成功'];
        $userInfo = User::find($id);
        $userInfo->name = $request->input('name');
        $userInfo->roleid = $request->input('roleid');
        $result = $userInfo->save();
        if(!$result){
            $data['status'] = 'fail';
            $data['msg'] = '修改失败';
        }
        return json_encode($data);
    }
    /**
     * 删除指定用户
     *
     * @param int $id
     * @return json
     */
    public function destroy($id)
    {
        $result = User::destroy($id);
        if($result){
            return Redirect::back()->with('message', '删除成功！');
        }
    }

    /**
     * 修改密码
     *
     * @return json
     */
    public function putPassword(Request $request)
    {
        $id = Auth::id();
        if($request->isMethod('get')){      //跳转页面
            $userInfo = User::with('userRole')->find($id);
            return view('user.putPassword',['userInfo' => $userInfo]);
        }elseif($request->isMethod('post')){        //表单请求
            return $this->putPasswordPost($request);
        }
    }

    private function putPasswordPost($request){
        $oldpassword = $request->input('oldpassword');
        $password = $request->input('password');
        $validator = Validator::make($request->all(),
            [
                'oldpassword'=>'bail|required|between:6,20',
                'password'=>'bail|required|between:6,20|confirmed',
            ],[
                'required' => '密码不能为空',
                'between' => '密码必须是6~20位之间',
                'confirmed' => '新密码和确认密码不匹配'
            ]
        );
        $user = Auth::user();
        $validator->after(function($validator) use ($oldpassword, $user) {
            if (!\Hash::check($oldpassword, $user->password)) {
                $validator->errors()->add('oldpassword', '原密码错误');
            }
        });
        if ($validator->fails()) {
            $this->throwValidationException($request, $validator);
        }
        $data = ['status' => 'success','msg' => '修改成功'];
        $user->password = bcrypt($password);
        $result = $user->save();
        if(!$result){
            $data['status'] = 'fail';
            $data['msg'] = '修改失败';
        }
        return json_encode($data);
    }
}
