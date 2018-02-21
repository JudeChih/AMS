<?php
namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\SoftwareList;
use Carbon\Carbon;
use DB;
// use SSH;

class SoftwareListRepository {

  /**
   * 新增一筆軟體資料
   * @param  array  $arraydata [要新增的資料]
   * @return boolean  true or false  [判斷是否成功]
   */
  public function create(array $arraydata){
    DB::beginTransaction();
    try {
      if(isset($arraydata['file_id'])){
        $savedata['file_id'] = $arraydata['file_id'];
      }else{
        return false;
      }
      if(isset($arraydata['host_guid'])){
        $savedata['host_guid'] = $arraydata['host_guid'];
      }else{
        return false;
      }
      if(isset($arraydata['publisher'])){
        $savedata['publisher'] = $arraydata['publisher'];
      }else{
        return false;
      }
      if(isset($arraydata['displayname'])){
        $savedata['displayname'] = $arraydata['displayname'];
      }else{
        return false;
      }
      if(isset($arraydata['displayversion'])){
        $savedata['displayversion'] = $arraydata['displayversion'];
      }else{
        return false;
      }
      if(isset($arraydata['installdate'])){
        $savedata['installdate'] = $arraydata['installdate'];
      }else{
        return false;
      }
      if(isset($arraydata['architecture'])){
        $savedata['architecture'] = $arraydata['architecture'];
      }else{
        return false;
      }
      $savedata['create_date'] = Carbon::now();
      $savedata['last_update_date'] = Carbon::now();
      $num = SoftwareList::insert($savedata);
      DB::commit();
      return $num;
    } catch (Exception $e) {
      DB::rollBack();
      return false;
    }
  }

}