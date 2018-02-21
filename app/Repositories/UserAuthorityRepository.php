<?php
namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\UserAuthority;
use Carbon\Carbon;
use DB;
use App\Services\AuthService;

class UserAuthorityRepository {

  /**
   * 依傳入的ud_guid取得資料
   * @param  string  $ud_guid
   */
  public function getDataByUdGuid($ud_guid){
    return UserAuthority::join('ams_Function_m','ams_Function_m.fm_id','ams_UserAuthority.fm_id')->join('ams_Function_d','ams_Function_d.fd_id','ams_UserAuthority.fd_id')->where('ams_UserAuthority.ud_guid',$ud_guid)->where('ams_UserAuthority.isflag','1')->get();
  }

  /**
   * 依傳入的ud_guid新增該使用者對於各網頁進入的權限
   * @param  string  $ud_guid  要設定權限的使用者guid
   */
  public function create($ud_guid){
    DB::beginTransaction();
    try {
      $boolean = true;
      $Function_m = new \App\Repositories\Function_mRepository;
      $fm = $Function_m->getDataAll();
      for($i = 0;$i < count($fm);$i++){
        $savedata['ud_guid'] = $ud_guid;
        $savedata['fm_id'] = $fm[$i]['fm_id'];
        $Function_d = new \App\Repositories\Function_dRepository;
        $fd = $Function_d->getDataByFmID($fm[$i]['fm_id']);
        $savedata['fd_id'] = $fd[0]['fd_id'];
        $savedata['uda_browse'] = 0;
        $savedata['create_user'] = AuthService::userName();
        $savedata['create_date'] = Carbon::now();
        $savedata['last_update_user'] = AuthService::userName();
        $savedata['last_update_date'] = Carbon::now();
        $num = UserAuthority::insert($savedata);
        if($num != 1){
          $boolean = false;
        }
      }
      DB::commit();
      return $boolean;
    } catch (Exception $e) {
      DB::rollBack();
      return false;
    }
  }

  /**
   * 依傳入的資料新增該使用者對於各網頁進入的權限
   * @param  array  $ud_guid  要設定權限的使用者guid
   */
  public function update(array $arraydata){
    DB::beginTransaction();
    try {
      $boolean = true;
      for($i = 0;$i < count($arraydata['ua']);$i++){
        $savedata['fd_id'] = $arraydata['ua'][$i]['fd_id'];
        $savedata['uda_browse'] = $arraydata['ua'][$i]['uda_browse'];
        $savedata['last_update_user'] = AuthService::userName();
        $savedata['last_update_date'] = Carbon::now();
        $num = UserAuthority::where('fd_id',$arraydata['ua'][$i]['fd_id'])->where('ud_guid',$arraydata['ud_guid'])->update($savedata);
        if($num != 1){
          $boolean = false;
        }
      }
      DB::commit();
      return $boolean;
    } catch (Exception $e) {
      DB::rollBack();
      return false;
    }
  }

}