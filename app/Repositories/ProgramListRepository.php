<?php
namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\ProgramList;
use Carbon\Carbon;
use DB;
// use SSH;

class ProgramListRepository {

  /**
   * 新增一筆程序資料
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
      if(isset($arraydata['owner'])){
        $savedata['owner'] = $arraydata['owner'];
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
      if(isset($arraydata['executablepath'])){
        $savedata['executablepath'] = $arraydata['executablepath'];
      }else{
        return false;
      }
      if(isset($arraydata['maximumworkingsetsize'])){
        $savedata['maximumworkingsetsize'] = $arraydata['maximumworkingsetsize'];
      }else{
        return false;
      }
      if(isset($arraydata['minimumworkingsetsize'])){
        $savedata['minimumworkingsetsize'] = $arraydata['minimumworkingsetsize'];
      }else{
        return false;
      }
      if(isset($arraydata['name'])){
        $savedata['name'] = $arraydata['name'];
      }else{
        return false;
      }
      if(isset($arraydata['processid'])){
        $savedata['processid'] = $arraydata['processid'];
      }else{
        return false;
      }
      if(isset($arraydata['sessionid'])){
        $savedata['sessionid'] = $arraydata['sessionid'];
      }else{
        return false;
      }
      if(isset($arraydata['status'])){
        $savedata['status'] = $arraydata['status'];
      }else{
        return false;
      }
      if(isset($arraydata['threadcount'])){
        $savedata['threadcount'] = $arraydata['threadcount'];
      }else{
        return false;
      }
      if(isset($arraydata['workingsetprivate'])){
        $savedata['workingsetprivate'] = $arraydata['workingsetprivate'];
      }else{
        return false;
      }
      $savedata['create_date'] = Carbon::now();
      $savedata['last_update_date'] = Carbon::now();
      $num = ProgramList::insert($savedata);
      DB::commit();
      return $num;
    } catch (Exception $e) {
      DB::rollBack();
      return false;
    }
  }
}