<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::group(['middleware' => 'api'],function(){
	Route::post('/signup','APIControllers\SignUpHostController@SignUpHost');
	Route::post('/checkclient','APIControllers\CheckClientVersionController@CheckClientVersion');
	Route::post('/gethost','APIControllers\GetHostParameterController@GetHostParameter');
	Route::post('/updatehost','APIControllers\UpdateHostDataController@UpdateHostData');
});

