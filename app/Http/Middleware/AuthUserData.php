<?php
namespace App\Http\Middleware;

use Closure;
use Session;
use Request;
use App\Http\Controllers\Auth\JWTController;
use \App\Services\AuthService;

class AuthUserData {

    use JWTController;

    public function handle($request, Closure $next) {
        $token = AuthService::token();
        if (!isset($token)) {
            return redirect('/logout');
        }
        //檢查「Token」
        if (!$this->checkSignature($token)) {
            return redirect('/logout');
        }

        //展延「Token」
        //產生新的「Token」
        $newToken = $this->generateJWTToken(AuthService::userData());
        //存入Session
        AuthService::saveToken($newToken, AuthService::userData());

        //根據權限進入各個網頁
        //如果沒權限就導到首頁
        $a = 0;
        foreach(AuthService::authLevel() as $qqq){
            $aa = \App\Models\Function_d::where('fd_id',$qqq->fd_id)->select('fd_path')->get();
            $arraypath = explode('/',Request::path());
            if(str_replace('/','',$aa[0]['fd_path']) == $arraypath[0]){
                $a = 1;
            }
        }
        if(Request::path() == 'index'){
            $a = 1;
        }

        if($a == 0){
            return redirect('/index');
        }else if($a == 1){
            return $next($request);
        }
        return $next($request);
    }

}
