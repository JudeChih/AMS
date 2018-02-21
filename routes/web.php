<?php
///測試API用
Route::get('/testapi','testApiController@testApi');

//////////////////
//Basic settings//
/////////////////////////////////////////////////////////////
// Route::get('/', function () {
//     return view('__ams_head');
// });
/////////////////////////////////////////////////////////////

// 登入頁面 //
/////////////////////////////////////////////////////////////
Route::get('/login', function () {
  return \Illuminate\Support\Facades\View::make('login');
});
Route::post('/login', 'Auth\LoginController@login');
/////////////////////////////////////////////////////////////
Route::get('/logout', [
    'as' => 'logout',
    'uses' => 'Auth\LoginController@logout'
]);
/////////////////////////////////////////////////////////////

Route::group(['middleware' => 'userdata'],function(){
	//////////////////
	//Basic settings//
	/////////////////////////////////////////////////////////////
	Route::get('/', function () {
	  return \Illuminate\Support\Facades\View::make('__ams_head');
	});
	Route::get('/index', function () {
		$username = Session::get('ud_name');
	  return \Illuminate\Support\Facades\View::make('__ams_head',compact('username'));
	});
	/////////////////////////////////////////////////////////////

	//////////////
	///主機列表///
	/////////////////////////////////////////////////////////////
	Route::get('/hostdata','ViewControllers\HostDataController@listData');
	Route::get('/hostdata/create','ViewControllers\HostDataController@create');
	Route::get('/hostdata/detail/{guid}','ViewControllers\HostDataController@detail');
	Route::get('/hostdata/detail/{guid}/download','ViewControllers\HostDataController@download');
	Route::post('/hostdata/save','ViewControllers\HostDataController@save');
	/////////////////////////////////////////////////////////////

	//////////////////
	///主機排程設定///
	/////////////////////////////////////////////////////////////
	Route::get('/hosttask','ViewControllers\HostTaskController@listData');
	Route::get('/hosttask/create','ViewControllers\HostTaskController@create');
	Route::get('/hosttask/modify/{guid}/{task_id}','ViewControllers\HostTaskController@modify');
	Route::post('/hosttask/save','ViewControllers\HostTaskController@save');
	/////////////////////////////////////////////////////////////

	//////////////////
	///程式版本資料///
	/////////////////////////////////////////////////////////////
	Route::get('/appversion','ViewControllers\AppVersionController@listData');
	Route::get('/appversion/create','ViewControllers\AppVersionController@create');
	Route::post('/appversion/save','ViewControllers\AppVersionController@save');
	/////////////////////////////////////////////////////////////

	//////////////
	///系統設定///
	/////////////////////////////////////////////////////////////
	Route::get('/systemoption','ViewControllers\SystemOptionController@listData');
	Route::get('/systemoption/modify/{option_id}','ViewControllers\SystemOptionController@modify');
	Route::get('/systemoption/download/{option_id}','ViewControllers\SystemOptionController@download');
	Route::post('/systemoption/save','ViewControllers\SystemOptionController@save');
	/////////////////////////////////////////////////////////////

	////////////////
	///使用者資料/// 一般使用者
	/////////////////////////////////////////////////////////////
	Route::get('/userdata','ViewControllers\UserDataController@listData');
	Route::post('/userdata/save','ViewControllers\UserDataController@save');
	Route::post('/userdata/modifypwd','ViewControllers\UserDataController@modifypwd');
	/////////////////////////////////////////////////////////////

	////////////////
	///使用者資料/// 管理者
	/////////////////////////////////////////////////////////////
	Route::get('/userdatalist','ViewControllers\UserDataListController@listData');
	Route::get('/userdatalist/create','ViewControllers\UserDataListController@create');
	Route::post('/userdatalist/auth','ViewControllers\UserDataListController@auth');
	Route::post('/userdatalist/modify','ViewControllers\UserDataListController@modify');
	Route::post('/userdatalist/save','ViewControllers\UserDataListController@save');
	/////////////////////////////////////////////////////////////

});