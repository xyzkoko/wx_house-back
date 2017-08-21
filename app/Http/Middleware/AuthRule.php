<?php

namespace App\Http\Middleware;

use App\Model\User;
use App\Model\Route;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route as RouteName;

class AuthRule
{
    protected $button = [];
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //验证权限
        $id = Auth::id();
        $user = User::with('userRole')->find($id)->toArray();
        $rule = $user['user_role']['rule'];
        $path = RouteName::currentRouteName();       //路由名称
        $path = explode('.',$path);
        $namespace = isset($path[0])?$path[0]:null;
        $action = isset($path[1])?$path[1]:null;
        $route = Route::where('namespace',$namespace)->where('action',$action)->first(['id']);
        if($rule != 'all'){
            $ruleArray = explode(',',$rule);
            if(!in_array($route->id,$ruleArray)){
                return redirect('/')->with('message', '没有权限！');
            }
        }
        //返回页面按钮
        view()->share('buttonList', $this->getButton($rule,$route));
        return $next($request);
    }

    private function getButton($rule,$route){
        if($rule == 'all'){
            $buttons = Route::where('parentid',$route->id)->get();
        }else{
            $ruleArray = explode(',',$rule);
            $buttons = Route::where('parentid',$route->id)->whereIn('id',$ruleArray)->get();
        }
        foreach ($buttons as $button) {
            $this->button[$button->id]['name'] = $button->name;
            $this->button[$button->id]['namespace'] = $button->namespace;
            $this->button[$button->id]['action'] = $button->action;
        }
        return $this->button;
    }
}
