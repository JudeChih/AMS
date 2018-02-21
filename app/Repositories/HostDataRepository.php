<?php
namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\HostData;
use App\Library\CommonTools;
use DB;
use Carbon\Carbon;

class HostDataRepository {
  /**
   * 抓取該用戶所有主機設備資料
   * @param  [string] $sort      排序的依據
   * @param  [string] $order     排序的方式
   * @return [array]             10筆為一個單位
   */
  public function getDataPage($sort,$order){
    if($sort == null){
      $sort='host_name';
    }
    if($order == null){
      $order='desc';
    }
    return HostData::where('isflag',1)->orderBy($sort,$order)->paginate(10);
  }

  /**
   * 抓取所有主機的host_guid，一次全抓，不分次抓取
   */
  public function getDataAll(){
    return HostData::where('isflag',1)->get();
  }

  /**
   * 根據host_guid抓取單筆主機資料
   * @param  [string] $host_guid
   */
  public function getDataByHostGUID($host_guid){
    return HostData::where('isflag',1)->where('host_guid',$host_guid)->get();
  }

  /**
   * 刪除[$host_guid]主機排程
   * @param  [type] $host_guid [host_guid]
   * @return int    $num        [判斷是否成功]
   */
  public function delete($host_guid) {
    $savedata['isflag'] = 0;
    $num = HostData::where('host_guid',$host_guid)->update($savedata);
    return $num;
  }

  /**
   * 建立主機資料
   * @param  array  $arraydata [host_name]
   * @return array  $savedata  [host_guid]
   */
  public function createGetId(array $arraydata){
    DB::beginTransaction();
    try {
      $savedata['host_name']= $arraydata['host_name'];
      $savedata['host_guid']= CommonTools::generateGUID(true);
      $num = HostData::insert($savedata);
      DB::commit();
      if($num){
        return $savedata['host_guid'];
      }else{
        return null;
      }
    } catch (Exception $e) {
      DB::rollBack();
      return false;
    }
  }

  public function updateBasicInfo($dataArray){
    echo 'updateBasicInfo';
    echo '<br>';
    $savedata['host_cpu'] = $dataArray['host_cpu'];
    $savedata['host_ram'] = $dataArray['host_ram'];
    $savedata['host_motherboard'] = $dataArray['host_motherboard'];
    $savedata['host_os'] = $dataArray['host_os'];
    $savedata['host_computername'] = $dataArray['host_computername'];
    return HostData::where('host_guid',$dataArray['host_guid'])->update($savedata);
  }

  /**
   * 更新最新的元件值
   * @param  string   $host_guid  [guid]
   * @param  array    $mosifyData [元件值]
   * @return [type]             [description]
   */
  public function update(array $modifyData){
    DB::beginTransaction();
    try {
      $savedata['last_app_version'] = $modifyData['last_app_version'];
      $savedata['last_change_date'] = Carbon::now();
      $num = HostData::where('host_guid',$modifyData['host_guid'])->update($savedata);
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