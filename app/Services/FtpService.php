<?php
namespace App\Services;

use Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use File;
use Config;

class FtpService {

    // Session::put(AuthService::$sessionToken, $token);

    public static function _initialize(){
        $systemOption = new \App\Repositories\SystemOptionRepository;
        $systemData = $systemOption->getDataAll();
        if(count($systemData) == 0){
            return false;
        }
        $userName = $systemData[0]['ftp_user'];
        if($userName == ''){
            return false;
        }
        $userPwd = $systemData[0]['ftp_pwd'];
        if($userPwd == ''){
            return false;
        }
        $host = $systemData[0]['ftp_url'];
        if($host == ''){
            return false;
        }
        Config::set('filesystems.disks.ftp.username', $userName);
        Config::set('filesystems.disks.ftp.password', $userPwd);
        Config::set('filesystems.disks.ftp.host', $host);
        return true;
    }

    /**
     * 檢查
     */
    public static function checkExist($filename) {
        return Storage::disk('ftp')->exists('new/'.$filename);
    }

    /**
     * 下載
     */
    public static function download($file_name) {
        // 抓取檔案內容
        $data = Storage::get('new/'.$file_name);
        $path = 'server/'.$file_name;
        if(is_null($data)){
            return false;
        }
        $num = Storage::disk('public')->put($path,$data);
        if(!$num){
            return false;
        }
        // $url = Storage::disk('public')->url($path);
        return $path;
    }

    /**
     * 上傳
     */
    public static function upload() {

    }
}
