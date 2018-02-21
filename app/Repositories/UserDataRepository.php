<?php
namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\UserData;
use Carbon\Carbon;
use DB;
use App\Services\AuthService;

class UserDataRepository {

  /**
   * 根據host_guid抓取該用戶所有主機排程
   * @param  [string] $host_guid 主機代碼
   * @param  [string] $sort      排序的依據
   * @param  [string] $order     排序的方式
   */
  public function getDataPage($sort,$order){
    if($sort == null){
      $sort = 'ud_name';
      $order = 'desc';
    }
    return UserData::where('isflag',1)->orderBy($sort,$order)->paginate(10);
  }

  /**
   * 透過帳號密碼或取會員資料
   * @param  [type] $userName     [帳號]
   * @param  [type] $userPassword [密碼]
   * @return [type] $userData     [會員資料]
   */
  public function getDataByPK($pk){
    return UserData::where('ud_guid',$pk)->get();
  }

  /**
   * 透過帳號密碼或取會員資料
   * @param  [type] $userName     [帳號]
   * @param  [type] $userPassword [密碼]
   * @return [type] $userData     [會員資料]
   */
  public function getDataByNickPass($userName,$userPassword){
    return UserData::where('ud_loginname',$userName)->where('ud_loginpwd',$userPassword)->where('ud_status',1)->get();
  }

  /**
   * 刪除[$primarykey]使用者資料
   * @param  [type] $primarykey [ud_guid]
   * @return int    $num        [判斷是否成功]
   */
  public function delete($primarykey) {
    $savedata['isflag'] = 0;
    $num = UserData::where('ud_guid',$primarykey)->update($savedata);
    return $num;
  }

  /**
   * 新增一筆使用者資料
   * @param  array  $arraydata [要新增的資料]
   * @return int    $num       [判斷是否成功]
   */
  public function create(array $arraydata){
    $check = UserData::where('ud_loginname',$arraydata['ud_loginname'])->get();
    if(count($check) == 0){
      DB::beginTransaction();
      try {
        if(isset($arraydata['ud_loginname']) && $arraydata['ud_loginname'] != ''){
          $savedata['ud_loginname'] = $arraydata['ud_loginname'];
        }else{
          return false;
        }
        if(isset($arraydata['ud_loginpwd']) && $arraydata['ud_loginpwd'] != ''){
          $savedata['ud_loginpwd'] = $arraydata['ud_loginpwd'];
        }else{
          return false;
        }
        if(isset($arraydata['ud_name']) && $arraydata['ud_name'] != ''){
          $savedata['ud_name'] = $arraydata['ud_name'];
        }else{
          return false;
        }

        $commonTools = new \App\Library\CommonTools;
        $savedata['ud_guid'] = $commonTools->generateGUID(true);
        $ud_guid = $savedata['ud_guid'];
        $savedata['isflag'] = '1';
        $savedata['ud_status'] = '0';
        $savedata['create_user'] = AuthService::userName();
        $savedata['create_date'] = Carbon::now();
        $savedata['last_update_user'] = AuthService::userName();
        $savedata['last_update_date'] = Carbon::now();
        $num = UserData::insert($savedata);
        DB::commit();
        if($num == 1){
          return $ud_guid;
        }else{
          return false;
        }
      } catch (Exception $e) {
        DB::rollBack();
        return false;
      }
    }else{
      return false;
    }
  }

  /**
   * 更新一筆主機排程
   * @param  array  $arraydata [要修改的資料]
   * @return int    $num       [判斷是否成功]
   */
  public function update(array $arraydata){
    $check = UserData::where('ud_name',$arraydata['ud_name'])->where('ud_guid','!=',$arraydata['ud_guid'])->get();
    if(isset($arraydata['ud_loginpwd_old'])){
      $checkpwd = UserData::where('ud_guid',$arraydata['ud_guid'])->where('ud_loginpwd',$arraydata['ud_loginpwd_old'])->where('isflag',1)->get();
      if(count($checkpwd) == 0){
        return false;
      }
    }
    if(count($check) == 0){
      DB::beginTransaction();
      try {
        if(isset($arraydata['ud_loginpwd']) && $arraydata['ud_loginpwd'] != '' && $arraydata['ud_loginpwd'] == $arraydata['ud_loginpwd_confirm']){
          $savedata['ud_loginpwd'] = $arraydata['ud_loginpwd'];
        }
        if(isset($arraydata['ud_name']) && $arraydata['ud_name'] != ''){
          $savedata['ud_name'] = $arraydata['ud_name'];
        }else{
          return false;
        }
        if(isset($arraydata['ud_status'])){
          $savedata['ud_status'] = $arraydata['ud_status'];
        }

        $savedata['last_update_user'] = AuthService::userName();
        $savedata['last_update_date'] = Carbon::now();
        $num = UserData::where('ud_guid',$arraydata['ud_guid'])->update($savedata);
        DB::commit();
        if($num == 1){
          return true;
        }else{
          return false;
        }
      } catch (Exception $e) {
        DB::rollBack();
        return false;
      }
    }else{
      return false;
    }
  }

}