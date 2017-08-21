<?php
namespace App\Repositories;


use App\Model\Route;
use App\Model\User;
use App\Repositories\Interfaces\MenuInterface;
use Illuminate\Support\Facades\Auth;


class MenuRepository implements MenuInterface
{
    protected $menuList = [];

    //导航栏按钮列表
    public function getMenu()
    {
        $id = Auth::id();
        if($id){
            $user = User::with('userRole')->find($id)->toArray();
            $rule = $user['user_role']['rule'];
            if($rule == 'all'){
                $rows = Route::where('display',1)->orderBy('parentid')->orderBy('listorder')->get()->toArray();
            }else{
                $ruleArray = explode(',',$rule);
                $rows = Route::where('display',1)->whereIn('id',$ruleArray)->orderBy('parentid')->orderBy('listorder')->get()->toArray();
            }
            foreach ($rows as $k=>$v){
                if($rows[$k]['parentid'] == 0){
                    $this->menuList[$rows[$k]['id']] = $rows[$k];
                }else{
                    if(isset($this->menuList[$rows[$k]['parentid']])){
                        $this->menuList[$rows[$k]['parentid']]['child'][] = $rows[$k];
                    }
                }
            }
        }
        return $this->menuList;
    }
}