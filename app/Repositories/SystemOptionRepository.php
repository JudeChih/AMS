<?php
namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\SystemOption;
use Carbon\Carbon;
use DB;

class SystemOptionRepository {
  /**
   * 抓取所有的系統選項資料
   */
  public function getDataAll() {
    return SystemOption::where('option_id',1)->get();
  }

  /**
   * 透過PK抓取單一筆系統選單資料
   * @param  string  $option_id [PK]
   */
  public function getDataByPK($option_id){
  	return SystemOption::where('option_id',$option_id)->get();
  }

  /**
   * 更新系統設定
   * @param  array  $arraydata [要修改的資料]
   * @return boolean true or false [判斷是否成功]
   */
  public function update(array $arraydata){
    DB::beginTransaction();
    try {
      if(isset($arraydata['api_url'])){
        $savedata['api_url'] = $arraydata['api_url'];
      }else{
        return false;
      }
      if(isset($arraydata['ftp_url'])){
        $savedata['ftp_url'] = $arraydata['ftp_url'];
      }else{
        return false;
      }
      if(isset($arraydata['ftp_directory'])){
        $savedata['ftp_directory'] = $arraydata['ftp_directory'];
      }else{
        return false;
      }
      if(isset($arraydata['ftp_user'])){
        $savedata['ftp_user'] = $arraydata['ftp_user'];
      }else{
        return false;
      }
      if(isset($arraydata['ftp_pwd'])){
        $savedata['ftp_pwd'] = $arraydata['ftp_pwd'];
      }else{
        return false;
      }
      if(isset($arraydata['sunwai_api_url'])){
        $savedata['sunwai_api_url'] = $arraydata['sunwai_api_url'];
      }else{
        return false;
      }
      if(isset($arraydata['sunwai_connect_interval'])){
        $savedata['sunwai_connect_interval'] = $arraydata['sunwai_connect_interval'];
      }else{
        return false;
      }
      if(isset($arraydata['sunwai_upload_parameter'])){
        $savedata['sunwai_upload_parameter'] = $arraydata['sunwai_upload_parameter'];
      }else{
        return false;
      }

      $savedata['last_update_date'] = \Carbon\Carbon::now();
      $num = SystemOption::where('option_id',$arraydata['option_id'])->update($savedata);
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