<?php
namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\ServiceList;
use Carbon\Carbon;
use DB;

class ServiceListRepository {

  /**
   * 新增一筆服務列表
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
      if(isset($arraydata['caption'])){
        $savedata['caption'] = $arraydata['caption'];
      }else{
        return false;
      }
      if(isset($arraydata['description'])){
        $savedata['description'] = $arraydata['description'];
      }else{
        return false;
      }
      if(isset($arraydata['displayname'])){
        $savedata['displayname'] = $arraydata['displayname'];
      }else{
        return false;
      }
      if(isset($arraydata['name'])){
        $savedata['name'] = $arraydata['name'];
      }else{
        return false;
      }
      if(isset($arraydata['pathname'])){
        $savedata['pathname'] = $arraydata['pathname'];
      }else{
        return false;
      }
      if(isset($arraydata['processid'])){
        $savedata['processid'] = $arraydata['processid'];
      }else{
        return false;
      }
      if(isset($arraydata['servicetype'])){
        $savedata['servicetype'] = $arraydata['servicetype'];
      }else{
        return false;
      }
      if(isset($arraydata['started'])){
        $savedata['started'] = $arraydata['started'];
      }else{
        return false;
      }
      if(isset($arraydata['startmode'])){
        $savedata['startmode'] = $arraydata['startmode'];
      }else{
        return false;
      }
      if(isset($arraydata['startname'])){
        $savedata['startname'] = $arraydata['startname'];
      }else{
        return false;
      }
      if(isset($arraydata['state'])){
        $savedata['state'] = $arraydata['state'];
      }else{
        return false;
      }
      $savedata['create_date'] = Carbon::now();
      $savedata['last_update_date'] = Carbon::now();
      $num = ServiceList::insert($savedata);
      DB::commit();
      return $num;
    } catch (Exception $e) {
      DB::rollBack();
      return false;
    }
  }
}