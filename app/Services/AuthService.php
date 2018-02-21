<?php
namespace App\Services;

use Session;
use App\Http\Controllers\Auth\JWTController;

class AuthService {

    use JWTController;

    private static $sessionToken = 'jwttoken';
    private static $sessionUserData = 'userdata';
    private static $sessionUserName = 'ud_name';
    private static $sessionUserID = 'ud_guid';
    private static $sessionUserAuth = 'authLevel';

    /**
     * 儲存「JWT Token」
     * @param type $token
     */
    public static function saveToken($token, $userdata) {

        if (!isset($token) || !isset($userdata)) {
            return \Illuminate\Support\Facades\Redirect::route('logout');
        }

        Session::put(AuthService::$sessionToken, $token);
        Session::put(AuthService::$sessionUserData, $userdata);
        Session::put(AuthService::$sessionUserName, $userdata->ud_name);
        Session::put(AuthService::$sessionUserID, $userdata->ud_guid);

        $authLevel = \App\Models\UserAuthority::join('ams_function_d','ams_userauthority.fd_id','ams_function_d.fd_id')->where('ams_userauthority.ud_guid',$userdata->ud_guid)->where('ams_userauthority.uda_browse',1)->get();

        Session::put(AuthService::$sessionUserAuth,$authLevel);

        $fm = \App\Models\Function_m::where('fm_platform',2)->get();

        Session::put('fm',$fm);
    }

    /**
     * 清除「JWT Token」
     */
    public static function clearToken() {
        Session::flush();
    }

    /**
     * 取得「JWT Token」
     * @return type
     */
    public static function token() {
        return Session::get(AuthService::$sessionToken);
    }

    /**
     * 使用者資料
     * @return type
     */
    public static function userData() {
        return Session::get(AuthService::$sessionUserData);
    }

    /**
     * 使用者名稱
     * @return type
     */
    public static function userName() {
        return Session::get(AuthService::$sessionUserName);
    }

    /**
     * 使用者代碼
     * @return type
     */
    public static function userID() {
        return Session::get(AuthService::$sessionUserID);
    }

    /**
     * 權限「Level」
     * @return type
     */
    public static function authLevel() {
        return Session::get(AuthService::$sessionUserAuth);
    }

    /**
     * 檢查使用者密碼
     * @param type $password
     * @return type
     */
    public static function checkPassword($password) {
        $repository = new \App\Repositories\UserDataRepository;
        return $repository->checkUserPassword(AuthService::userID(), $password);
    }

}
