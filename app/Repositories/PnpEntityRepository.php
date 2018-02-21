<?php
namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\PnpEntity;

class PnpEntityRepository {

  /**
   * 根據host_guid抓取單筆設備清單
   * @param  [string] $host_guid
   */
  public function getDataByHostGUID($host_guid){
    return PnpEntity::where('isflag',1)->where('host_guid',$host_guid)->orderBy('pnpclass','desc')->get();
  }

  /**
   * 編輯字串要回傳到view的
   * @param   $result  選定的主機的明細
   */
  public function classMenu($result){
    foreach($result as $data){
      $array[] = array($data->caption,$data->pnpclass);
    }

    $pnpclass = "";
    for($i=0;$i<count($array);$i++){
      if($array[$i][1]==$pnpclass){
        $str = $str."<li>".$array[$i][0]."</li>";
        if($i == count($array)-1){
          $str = $str."</ul></li></ul>";
        }
      }else{
        if($i == 0){
          $pnpclass = $array[$i][1];
          $str = "<ul><li><span>".$pnpclass."</span><ul class='test_height'><li>".$array[$i][0]."</li>";
        }else{
          $pnpclass = $array[$i][1];
          $str = $str."</ul></li>";
          $str = $str."<li><span>".$pnpclass."</span><ul class='test_height'><li>".$array[$i][0]."</li>";
        }
      }
    }
    return $str;
  }

  /**
   * 新增一筆隨插隨用設備清單
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
      if(isset($arraydata['classguid'])){
        $savedata['classguid'] = $arraydata['classguid'];
      }else{
        return false;
      }
      if(isset($arraydata['name'])){
        $savedata['name'] = $arraydata['name'];
      }else{
        return false;
      }
      if(isset($arraydata['deviceid'])){
        $savedata['deviceid'] = $arraydata['deviceid'];
      }else{
        return false;
      }
      if(isset($arraydata['manufacturer'])){
        $savedata['manufacturer'] = $arraydata['manufacturer'];
      }else{
        return false;
      }
      if(isset($arraydata['pnpclass'])){
        $savedata['pnpclass'] = $arraydata['pnpclass'];
      }else{
        return false;
      }
      if(isset($arraydata['pnpdeviceid'])){
        $savedata['pnpdeviceid'] = $arraydata['pnpdeviceid'];
      }else{
        return false;
      }
      $savedata['create_date'] = Carbon::now();
      $savedata['last_update_date'] = Carbon::now();
      $num = PnpEntity::insert($savedata);
      DB::commit();
      return $num;
    } catch (Exception $e) {
      DB::rollBack();
      return false;
    }
  }

}