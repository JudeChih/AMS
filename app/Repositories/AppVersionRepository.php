<?php
namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\AppVersion;
use Carbon\Carbon;
use DB;

class AppVersionRepository {
  /**
   * 抓取該用戶所有主機設備資料
   * @param  [string] $sort      排序的依據
   * @param  [string] $order     排序的方式
   * @return [array]             10筆為一個單位抓取
   */
  public function getDataPage($sort,$order){
    if($sort == null){
      $sort='ver_id';
    }
    if($order == null){
      $order='desc';
    }
    return AppVersion::where('isflag',1)->orderBy($sort,$order)->paginate(10);
  }

  /**
   * 抓取最新版的元件值
   * @return [array] [最新版的元件值資料]
   */
  public function getNewestVersion(){
    return AppVersion::where('ver_status',1)->where('isflag',1)->get();
  }

  /**
   * 刪除選定的程式版本資料
   * @param  [type] $primarykey [ver_id]
   * @return [type]             [判斷是否成功]
   */
  public function delete($primarykey){
    $savedata['isflag'] = 0;
    $num = AppVersion::where('ver_id',$primarykey)->update($savedata);
    if($num == 1){
      return true;
    }else{
      return false;
    }
  }

  /**
   * 新增一筆程式版本
   * @param  array  $arraydata [要新增的資料]
   * @param  array  $savedata  [要儲存的檔案路徑和檔案名字]
   * @return boolean true or false [判斷是否成功]
   */
  public function create(Array $arraydata){
    DB::beginTransaction();
    try {
      if(isset($arraydata['ver_filename'])){
        $savedata['ver_filename'] = $arraydata['ver_filename'];
      }else{
        return false;
      }
      if(isset($arraydata['ver_directory'])){
        $savedata['ver_directory'] = $arraydata['ver_directory'];
      }else{
        return false;
      }
      if(isset($arraydata['ver_major'])){
        $savedata['ver_major'] = $arraydata['ver_major'];
      }else{
        return false;
      }
      if(isset($arraydata['ver_minor'])){
        $savedata['ver_minor'] = $arraydata['ver_minor'];
      }else{
        return false;
      }
      if(isset($arraydata['ver_build'])){
        $savedata['ver_build'] = $arraydata['ver_build'];
      }else{
        return false;
      }
      if(isset($arraydata['ver_revision'])){
        $savedata['ver_revision'] = $arraydata['ver_revision'];
      }else{
        return false;
      }
      // 版本設定為新版
      $savedata['ver_status'] = '1';
      $savedata['isflag'] = '1';
      $savedata['create_date'] = Carbon::now();

      $num = AppVersion::insert($savedata);

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
  }

  /**
   * 針對啟用中的版本做變更
   * @param  array $arraydata 透過action判斷要做的變更
   * @return boolean true or false 提示是否變更成功
   */
  public function update(Array $arraydata){
    DB::beginTransaction();
    try {

      $savedata['ver_status'] = $arraydata['ver_status'];
      $savedata['last_update_date'] = Carbon::now();
      $num = AppVersion::where('ver_id',$arraydata['ver_id'])->update($savedata);

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
  }

}