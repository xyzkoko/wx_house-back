<?php

namespace App\Http\Controllers\User;

use App\Model\UserRole;
use App\Model\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class UserRoleController extends Controller
{
    /**
     * 登录验证
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 用户组列表
     *
     * @param Request $request
     * @return json
     */
    public function index()
    {
        $userRoleList = UserRole::all()->toArray();
        return view('user.userRole', ['userRoleList' => $userRoleList]);
    }

    /**
     * 添加用户组
     *
     * @param Request $request
     * @return json
     */
    public function create(Request $request)
    {
        if($request->isMethod('get')){      //跳转页面
            $menuAdd = array();
            $rows = Route::orderBy('parentid','ASC')->orderBy('listorder','ASC')->get()->toArray();
            foreach ($rows as $k=>$v){
                if($v['parentid'] == 0){
                    $menuAdd[$v['id']] = $v;
                }elseif(array_key_exists($v['parentid'],$menuAdd)){
                    $menuAdd[$v['parentid']]['child'][$v['id']] = $v;
                }else{
                    foreach($menuAdd as $k2=>$v2){
                        if(isset($v2['child'])){
                            if(array_key_exists($v['parentid'],$v2['child'])){
                                $menuAdd[$k2]['child'][$v['parentid']]['child'][$v['id']] = $v;
                            }
                        }
                    }
                }
            }
            return view('user.userRoleAdd',['menuAdd' => $menuAdd]);
        }elseif($request->isMethod('post')){        //表单请求
            return $this->createPost($request);
        }
    }

    private function createPost($request){
        $this->validate($request, [
            'name' => 'bail|required|unique:la_users_role|max:10'
        ],[
            'name.required' => '名称不能为空',
            'name.unique' => '名称不能重复',
            'name.max' => '名称最大长度为10'
        ]);
        $data = ['status' => 'success','msg' => '添加成功'];
        $rule = implode(',',$request->input('rule'));
        $userRoleInfo = new UserRole;
        $userRoleInfo->name = $request->input('name');
        $userRoleInfo->rule = $rule;
        $result = $userRoleInfo->save();
        if(!$result){
            $data['status'] = 'fail';
            $data['msg'] = '添加失败';
        }
        return json_encode($data);
    }

    /**
     * 更新指定用户组
     *
     * @param Request $request
     * @param int $id
     * @return json
     */
    public function update(Request $request,$roleid)
    {
        if($request->isMethod('get')){      //跳转页面
            $menuAdd = array();
            $rows = Route::orderBy('parentid','ASC')->orderBy('listorder','ASC')->get()->toArray();
            $userRoleInfo = UserRole::find($roleid);
            foreach ($rows as $k=>$v){
                $v['select'] = 0;
                if(in_array($v['id'],explode(',',$userRoleInfo['rule']))){
                    $v['select'] = 1;
                }
                if($v['parentid'] == 0){
                    $menuAdd[$v['id']] = $v;
                }elseif(array_key_exists($v['parentid'],$menuAdd)){
                    $menuAdd[$v['parentid']]['child'][$v['id']] = $v;
                }else{
                    foreach($menuAdd as $k2=>$v2){
                        if(isset($v2['child'])){
                            if(array_key_exists($v['parentid'],$v2['child'])){
                                $menuAdd[$k2]['child'][$v['parentid']]['child'][$v['id']] = $v;
                            }
                        }
                    }
                }
            }
            return view('user.userRoleUpdate',['userRoleInfo' => $userRoleInfo,'menuAdd' => $menuAdd]);
        }elseif($request->isMethod('post')){        //表单请求
            echo 111;exit;
            return $this->updatePost($request,$roleid);
        }
    }
    private function updatePost($request,$roleid){
        $this->validate($request, [
            'name' => ['required',Rule::unique('la_users_role')->ignore($roleid,'roleid'),'max:10']
        ],[
            'name.required' => '姓名不能为空',
            'name.unique' => '姓名不能重复',
            'name.max' => '姓名最大长度为10'
        ]);
        $data = ['status' => 'success','msg' => '修改成功'];
        $rule = implode(',',$request->input('rule'));
        $userRoleInfo = UserRole::find($roleid);
        $userRoleInfo->name = $request->input('name');
        $userRoleInfo->rule = $rule;
        $result = $userRoleInfo->save();
        if(!$result){
            $data['status'] = 'fail';
            $data['msg'] = '修改失败';
        }
        return json_encode($data);
    }

    /**
     * 删除指定用户组
     *
     * @param int $roleid
     * @return json
     */
    public function destroy($id)
    {
        $result = User::destroy($id);
        if($result){
            return Redirect::back()->with('message', '删除成功！');
        }
    }

}
