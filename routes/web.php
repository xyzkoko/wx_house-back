<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', 'HomeController@index');

Route::group(['namespace' => 'User','middleware' => 'auth.rule'], function(){
    //修改密码
    Route::any('user/putPassword', 'UserController@putPassword')->name('user.putPassword');
    //用户列表
    Route::get('user/index', 'UserController@index')->name('user.index');
    Route::any('user/create', 'UserController@create')->name('user.create');
    Route::any('user/{id}/update', 'UserController@update')->name('user.update');
    Route::delete('user/{id}/destroy', 'UserController@destroy')->name('user.destroy');
    //用户组列表
    Route::get('userRole/index', 'UserRoleController@index')->name('userRole.index');
    Route::any('userRole/create', 'UserRoleController@create')->name('userRole.create');
    Route::any('userRole/{id}/update', 'UserRoleController@update')->name('userRole.update');
    Route::delete('userRole/{id}/destroy', 'UserRoleController@destroy')->name('userRole.destroy');
});

Route::group(['namespace' => 'Member','middleware' => 'auth.rule'], function(){
    //银行会员
    Route::get('member/bankIndex', 'MemberController@bankIndex')->name('member.bankIndex');
    Route::any('member/{uid}/bankCheck', 'MemberController@roleCheck')->name('member.bankCheck');
    Route::any('member/{uid}/bankUpdate', 'MemberController@bankUpdate')->name('member.bankUpdate');
    Route::any('member/bankCreate', 'MemberController@bankCreate')->name('member.bankCreate');
    //中介会员
    Route::get('member/brokerIndex', 'MemberController@brokerIndex')->name('member.brokerIndex');
    Route::any('member/{uid}/brokerCheck', 'MemberController@roleCheck')->name('member.brokerCheck');
    Route::any('member/{uid}/brokerUpdate', 'MemberController@brokerUpdate')->name('member.brokerUpdate');
    //商家会员
    Route::get('member/sellerIndex', 'MemberController@sellerIndex')->name('member.sellerIndex');
    Route::any('member/{uid}/sellerCheck', 'MemberController@roleCheck')->name('member.sellerCheck');
    Route::any('member/{uid}/sellerUpdate', 'MemberController@sellerUpdate')->name('member.sellerUpdate');
    Route::any('member/sellerCreate', 'MemberController@sellerCreate')->name('member.sellerCreate');
});

Route::group(['namespace' => 'Business','middleware' => 'auth.rule'], function(){
    //业务列表
    Route::get('business/index', 'BusinessController@index')->name('business.index');
    Route::any('business/{bid}/status', 'BusinessController@status')->name('business.status');
    Route::any('business/{bid}/signStatus', 'BusinessController@signStatus')->name('business.signStatus');
    Route::any('business/{bid}/assessStatus', 'BusinessController@assessStatus')->name('business.assessStatus');
    Route::any('business/{bid}/type', 'BusinessController@type')->name('business.type');
});

Route::group(['namespace' => 'System','middleware' => 'auth.rule'], function(){
    Route::any('system/putMoney', 'SystemController@putMoney')->name('system.putMoney');
});

Route::group(['namespace' => 'XCX'], function(){
    Route::get('xcx/index', 'XCXController@index');
});


