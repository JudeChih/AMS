<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\Auth\JWTController;
use App\Services\AuthService;
use \Firebase\JWT\JWT;

class LoginController extends Controller
{

    use AuthenticatesUsers;
    use JWTController;

    protected $redirectTo = '/index';
    protected $redirectToLogOut = '/login';

    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * 執行登入
     * @param \Illuminate\Http\Request $request
     * @return boolean
     */
    function login(\Illuminate\Http\Request$request) {
        try {
            //檢查帳號密碼是否有填寫
            if (!isset($request->ud_loginname) || !isset($request->ud_loginpwd)) {
                AuthService::clearToken();
                return redirect()->back()->withInput()->withErrors(['error' => '帳號或密碼錯誤！！']);
            }
            //檢查是否有這個使用者資料
            $userdata = $this->checkUserPassword($request->ud_loginname, $request->ud_loginpwd);
            if (!isset($userdata)) {
                AuthService::clearToken();
                return redirect()->back()->withInput()->withErrors(['error' => '帳號或密碼錯誤！！']);
            }

            //建立「JWT Token」
            $jwttoken = $this->generateJWTToken($userdata);
            if (!isset($jwttoken)) {
                AuthService::clearToken();
                return redirect()->back()->withInput()->withErrors(['error' => '帳號或密碼錯誤！！']);
            }
            //儲存「Token」
            AuthService::saveToken($jwttoken, $userdata);

            return redirect('/index');
        } catch (Exception $ex) {
            AuthService::clearToken();
            return redirect()->back()->withInput()->withErrors(['error' => '帳號或密碼錯誤！！']);
        }
    }

    /**
     * 執行登出
     * @param \Illuminate\Http\Request $request
     * @return type
     */
    function logOut(\Illuminate\Http\Request$request) {
        //清除「Token」
        AuthService::clearToken();
        return redirect('/login');
    }

    /**
     * 檢查使用者帳號密碼，並取得使用者資料
     * @param type $userName 使用者帳號
     * @param type $userPassword 使用者密碼
     * @return type 使用者資料 [ ud_id ,ud_name ,auth ]
     */
    private function checkUserPassword($userName, $userPassword) {
        $Ams_userdata = new \App\Repositories\UserDataRepository;
        $userdata = $Ams_userdata->getDataByNickPass($userName, $userPassword);
        if (count($userdata) > 0) {
            // 做成Json格式回傳
            return json_decode(json_encode(['ud_guid' => $userdata[0]->ud_guid, 'ud_name' => $userdata[0]->ud_name]));
        } else {
            return null;
        }
    }
}
