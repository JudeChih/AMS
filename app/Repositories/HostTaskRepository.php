<?php
namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\HostTask;
use Carbon\Carbon;
use DB;
use App\Services\AuthService;


class HostTaskRepository {

  private static $task_data;

  /**
   * 根據host_guid抓取該用戶所有主機排程
   * @param  [string] $host_guid 主機代碼
   * @param  [string] $sort      排序的依據
   * @param  [string] $order     排序的方式
   */
  public function getDataPage($sort,$order){
    if($sort == null){
      $sort = 'host_name';
      $order = 'desc';
    }

    return HostTask::join('ams_HostData','HostTask.host_guid','ams_HostData.host_guid')->where('HostTask.isflag',1)->orderBy($sort,$order)->paginate(10);
  }

  /**
   * 根據task_id抓取單筆主機排程
   * @param  [string] $task_id
   */
  public function getDataByPK($task_id){
    return HostTask::where('isflag',1)->where('task_id',$task_id)->get();
  }

  /**
   * 根據host_guid抓取單筆主機排程
   * @param  [string] $host_guid
   */
  public function getDataByHostGUID($host_guid){
    return HostTask::where('isflag',1)->where('host_guid',$host_guid)->get();
  }

  /**
   * 刪除[$primarykey]主機排程
   * @param  [type] $primarykey [task_id]
   * @return boolean  true or false  [判斷是否成功]
   */
  public function delete($primarykey) {
    $savedata['isflag'] = 0;
    $num = HostTask::where('task_id',$primarykey)->update($savedata);
    if($num == 1){
      return true;
    }else{
      return false;
    }
  }

  /**
   * 將運算出的task_next_date 存檔
   * @param  [num] $task_id [排程ID]
   * @return [boolean] true or false [是否成功]
   */
  public function updateNextDate($task_id){
    $task_data = $this->getDataByPK($task_id);
    $next_date = $this->getNextDate($task_data[0]);
    if($next_date == false){
      return false;
    }else{
      $savedata['task_next_date'] = $next_date;
      $savedata['last_update_date'] = Carbon::now();
      $savedata['last_update_user'] = AuthService::userName();
      $num = HostTask::where('task_id',$task_id)->update($savedata);
      if($num == 1){
        return true;
      }else{
        return false;
      }
    }
  }

  /**
   * 運算出task_next_date
   * @param  [json] $task_data [此排程所有資料]
   * @return [striing] $next_date [task_next_date]
   */
  public function getNextDate($task_data){
    // 抓到離現在最近的一次開始日(不超過現在)
    $task_data = $this->getStartTime($task_data);
    // 運算下次執行日的日期部份
    $task_data = $this->getPartOfDate($task_data);
    // 運算下次執行日的時間部份
    $next_date = $this->getPartOfTime($task_data);
    $end_date = $task_data->task_end_date;

    // 比較下次執行日是否超過結束日
    if(Carbon::parse($next_date) > Carbon::parse($end_date)){
      return false;
    }else{
      return $next_date;
    }
  }

  /**
   * 抓取資料中的task_start_date離現在時間最近的一次
   * @param  [json] $task_data [該task_id的所有資料]
   * @return [json] $task_data [修改資料中的task_start_date]
   */
  public function getStartTime($task_data){
    // 先將資料裡的時間字串轉成Carbon看得懂的時間
    $start_date = Carbon::parse($task_data->task_start_date);
    $now_date = Carbon::now();
    Carbon::setWeekStartsAt(Carbon::SUNDAY);
    Carbon::setWeekEndsAt(Carbon::SATURDAY);
    if($task_data->task_type == 1 || $task_data->task_type == 2){
      if($task_data->task_type == 2){
        // 先把task_interval每週都換成天數
        $task_data->task_interval = $task_data->task_interval*7;
        // 如果task_type是每週的話，將開始日改為一週的第一天(startOfWeek)
        $start_date = $start_date->startOfWeek();
      }
      if($task_data->task_interval != 0){
        // 將start_date & now_date 化為時間戳做比較
        if($start_date < $now_date){
          $diff = strtotime($now_date)-strtotime($start_date);
          $val = floor($diff/($task_data->task_interval*86400));
          $days = $val*$task_data->task_interval*86400;
          $start_date = date("Y-m-d H:i:s",strtotime($start_date)+$days);
        }
      }
      // 將資料中的task_start_date改為我們經過運算過離現在時間最近的日期
      $task_data->task_start_date = $start_date;
    }elseif($task_data->task_type == 3){
      // 將task_interval從字串轉為陣列
      $month = explode(';', $task_data->task_interval);
      $day = explode(';', $task_data->task_dayofmonth);
      if($start_date->year <= $now_date->year){
        $start_date->year = $now_date->year;
        for($i=0;$i<count($month);$i++){
          for($j=0;$j<count($day);$j++){
            $date = $start_date;
            $date->month = $month[$i];
            if($day[$j] == 99){
              $date->endOfMonth();
              $date->hour = 0;
              $date->minute = 0;
              $date->second = 0;
              $day[$j] = $date->day;
            }else{
              $date->day = $day[$j];
            }
            if($date < $now_date && $date->day == $day[$j] && $date->month == $month[$i]){
              $start_date = $date;
            }
          }
        }
        $task_data->task_start_date = $start_date->toDateTimeString();
      }
    }
    return $task_data;
  }

  /**
   * 運算下一次執行排程的日期
   * @param  json $task_data [該task_id的所有資料]
   * @return json $task_data [修改task_start_date並回傳]
   */
  public function getPartOfDate($task_data){
    $task_type = $task_data->task_type;
    if($task_type == 1){
      $task_data = $this->getDateForTaskTypeOne($task_data);
    }elseif($task_type == 2){
      $task_data = $this->getDateForTaskTypeTwo($task_data);
    }elseif($task_type == 3){
      $task_data = $this->getDateForTaskTypeThree($task_data);
    }
    return $task_data;
  }

  /**
   * task_type = 1 (每日) 的日期運算
   * @param  [type] $task_data
   * @return [type] $task_data
   */
  private function getDateForTaskTypeOne($task_data){
    $start_date = Carbon::parse($task_data->task_start_date);
    $now_date = Carbon::now();
    Carbon::setWeekStartsAt(Carbon::SUNDAY);
    Carbon::setWeekEndsAt(Carbon::SATURDAY);
    $task_interval = $task_data->task_interval;
    $datearray = [];
    do{
      $start_date->addDays($task_interval);
      $datearray[count($datearray)] = $start_date->toDateTimeString();
    } while (count($datearray) < 2);
    $task_data->task_start_date = $datearray;
    return $task_data;
  }

  /**
   * task_type = 2 (每週) 的日期運算
   * @param  [type] $task_data
   * @return [type] $task_data
   */
  private function getDateForTaskTypeTwo($task_data){
    $start_date = Carbon::parse($task_data->task_start_date);
    $now_date = Carbon::today();
    Carbon::setWeekStartsAt(Carbon::SUNDAY);
    Carbon::setWeekEndsAt(Carbon::SATURDAY);
    $task_interval = $task_data->task_interval;
    $dayofweek = explode(';',$task_data->task_dayofweek);
    $date = $start_date;
    $datearray = [];
    do{
      if($date->dayOfWeek == 0){
        $date->addDays($task_interval);
      }
      for($j=0;$j<count($dayofweek);$j++){
        if($date >= $now_date){
          if($date->dayOfWeek == $dayofweek[$j] && count($datearray) <2){
            $datearray[count($datearray)] = $date->toDateTimeString();
          }
        }
        if(count($datearray) == 2){
          break;
        }
      }
      if(count($datearray) < 2){
        $date->addDay();
      }
    } while (count($datearray) < 2);
    $task_data->task_start_date = $datearray;
    return $task_data;
  }

  /**
   * task_type = 3 (每月) 的日期運算
   * @param  [type] $task_data
   * @return [type] $task_data
   */
  private function getDateForTaskTypeThree($task_data){
    $start_date = Carbon::parse($task_data->task_start_date);
    $now_date = Carbon::now();
    Carbon::setWeekStartsAt(Carbon::SUNDAY);
    Carbon::setWeekEndsAt(Carbon::SATURDAY);
    $task_interval = $task_data->task_interval;
    $datearray = [];
    $month = explode(';', $task_data->task_interval);
    $day = explode(';', $task_data->task_dayofmonth);
    for($i=0;$i<count($month);$i++){
      for($j=0;$j<count($day);$j++){
        $date = $start_date;
        $date->month = $month[$i];
        if($day[$j] == 99){
          $date->endOfMonth();
          $date->hour = 0;
          $date->minute = 0;
          $date->second = 0;
          $day[$j] = $date->day;
        }else{
          $date->day = $day[$j];
        }
        if($date->month == $month[$i] && $date->day == $day[$j] && $date >= $now_date && count($datearray) < 2){
          $start_date = $date;
          $datearray[count($datearray)] = $start_date->toDateTimeString();
        }
        if(count($datearray) == 2){
          break;
        }
      }
      if(count($datearray) == 2){
        break;
      }
    }
    $task_data->task_start_date = $datearray;
    return $task_data;
  }

  /**
   * 運算下一次執行排程時間
   * @param  json $task_data [該task_id的所有資料]
   * @return string $task_next_date [回傳運算出的task_next_date]
   */
  public function getPartOfTime($task_data){
    $datearray = $task_data->task_start_date;
    $now_date = Carbon::now();
    Carbon::setWeekStartsAt(Carbon::SUNDAY);
    Carbon::setWeekEndsAt(Carbon::SATURDAY);
    // 指定時間
    if($task_data->task_day_frequency == 1){
      $day_interval = explode(':', $task_data->task_day_interval);
      for($i=0;$i<count($datearray);$i++){
        $date = Carbon::parse($datearray[$i]);
        $date->hour = $day_interval[0];
        $date->minute = $day_interval[1];
        $date->second = 0;
        if($date > $now_date){
          $task_data->task_next_date = $date->toDateTimeString();
          break;
        }
      }
    }
    // 分鐘
    elseif($task_data->task_day_frequency == 2){
      $dayinterval = $task_data->task_day_interval;
      for($i=0;$i<count($datearray);$i++){
        $boolean = false;
        $date = Carbon::parse($datearray[$i]);
        $date->hour = 0;
        $date->minute = 0;
        $date->second = 0;
        for($j=1;$j<floor(1440/$task_data->task_day_interval);$j++){
          $date->minute = $j*$dayinterval;
          if($date > $now_date){
            $task_data->task_next_date = $date->toDateTimeString();
            $boolean = true;
            break;
          }
        }
        if($boolean){
          break;
        }
      }
    }
    // 小時
    elseif($task_data->task_day_frequency == 3){
      $dayintervel = $task_data->task_day_interval;
      for($i=0;$i<count($datearray);$i++){
        $date = Carbon::parse($datearray[$i]);
        for($j=1;$j<floor(24/$dayintervel);$j++){
          $date->hour = $j*$dayintervel;
          $date->minute = 0;
          $date->second = 0;
          if($date > $now_date){
            $task_data->task_next_date = $date->toDateTimeString();
            $boolean = true;
            break;
          }
        }
        if($boolean){
          break;
        }
      }
    }
    return $task_data->task_next_date;
  }

  /**
   * 新增一筆主機排程
   * @param  array  $arraydata [要新增的資料]
   * @return boolean  true or false  [判斷是否成功]
   */
  public function create(array $arraydata){
    $check = HostTask::where('task_name',$arraydata['task_name'])->where('host_guid',$arraydata['host_guid'])->get();
    if(count($check) == 0){
      DB::beginTransaction();
      try {
        if(isset($arraydata['task_name']) || $arraydata['task_name'] == ''){
          $savedata['task_name'] = $arraydata['task_name'];
        }else{
          return false;
        }
        if(isset($arraydata['host_guid']) || $arraydata['host_guid'] == ''){
          $savedata['host_guid'] = $arraydata['host_guid'];
        }else{
          return false;
        }
        if(isset($arraydata['execute_type']) || $arraydata['execute_type'] == ''){
          $savedata['execute_type'] = $arraydata['execute_type'];
        }else{
          return false;
        }
        if(isset($arraydata['task_start_date'])){
          $savedata['task_start_date'] = $arraydata['task_start_date'];
        }else{
          return false;
        }
        if(isset($arraydata['task_end_date'])){
          $savedata['task_end_date'] = $arraydata['task_end_date'];
        }else{
          return false;
        }
        if(isset($arraydata['task_enable'])){
          $savedata['task_enable'] = $arraydata['task_enable'];
        }else{
          return false;
        }
        if(isset($arraydata['task_type'])){
          $savedata['task_type'] = $arraydata['task_type'];
        }else{
          return false;
        }
        if(isset($arraydata['task_interval'])){
          $savedata['task_interval'] = $arraydata['task_interval'];
        }else{
          return false;
        }
        if(isset($arraydata['task_day_frequency'])){
          $savedata['task_day_frequency'] = $arraydata['task_day_frequency'];
        }else{
          return false;
        }
        if(isset($arraydata['task_day_interval'])){
          $savedata['task_day_interval'] = $arraydata['task_day_interval'];
        }else{
          return false;
        }
        if(isset($arraydata['task_dayofweek'])){
          $savedata['task_dayofweek'] = $arraydata['task_dayofweek'];
        }else{
          return false;
        }
        if(isset($arraydata['task_weekofmonth'])){
          $savedata['task_weekofmonth'] = $arraydata['task_weekofmonth'];
        }else{
          return false;
        }
        if(isset($arraydata['task_dayofmonth'])){
          $savedata['task_dayofmonth'] = $arraydata['task_dayofmonth'];
        }else{
          return false;
        }

        $savedata['isflag'] = '1';
        $savedata['create_date'] = Carbon::now();
        $savedata['create_user'] = AuthService::userName();
        $task_id = HostTask::insertGetId($savedata);
        DB::commit();
        return $task_id;
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
   * @return boolean  true or false  [判斷是否成功]
   */
  public function update(array $arraydata){
    $check = HostTask::where('task_name',$arraydata['task_name'])->where('task_id','!=',$arraydata['task_id'])->get();
    if(count($check) == 0){
      DB::beginTransaction();
      try {
        if(isset($arraydata['task_name']) || $arraydata['task_name'] == ''){
          $savedata['task_name'] = $arraydata['task_name'];
        }else{
          return false;
        }
        if(isset($arraydata['host_guid']) || $arraydata['host_guid'] == ''){
          $savedata['host_guid'] = $arraydata['host_guid'];
        }else{
          return false;
        }
        if(isset($arraydata['execute_type']) || $arraydata['execute_type'] == ''){
          $savedata['execute_type'] = $arraydata['execute_type'];
        }else{
          return false;
        }
        if(isset($arraydata['task_start_date'])){
          $savedata['task_start_date'] = $arraydata['task_start_date'];
        }else{
          return false;
        }
        if(isset($arraydata['task_end_date'])){
          $savedata['task_end_date'] = $arraydata['task_end_date'];
        }else{
          return false;
        }
        if(isset($arraydata['task_enable'])){
          $savedata['task_enable'] = $arraydata['task_enable'];
        }else{
          return false;
        }
        if(isset($arraydata['task_type'])){
          $savedata['task_type'] = $arraydata['task_type'];
        }else{
          return false;
        }
        if(isset($arraydata['task_interval'])){
          $savedata['task_interval'] = $arraydata['task_interval'];
        }else{
          return false;
        }
        if(isset($arraydata['task_day_frequency'])){
          $savedata['task_day_frequency'] = $arraydata['task_day_frequency'];
        }else{
          return false;
        }
        if(isset($arraydata['task_day_interval'])){
          $savedata['task_day_interval'] = $arraydata['task_day_interval'];
        }else{
          return false;
        }
        if(isset($arraydata['task_dayofweek'])){
          $savedata['task_dayofweek'] = $arraydata['task_dayofweek'];
        }else{
          return false;
        }
        if(isset($arraydata['task_weekofmonth'])){
          $savedata['task_weekofmonth'] = $arraydata['task_weekofmonth'];
        }else{
          return false;
        }
        if(isset($arraydata['task_dayofmonth'])){
          $savedata['task_dayofmonth'] = $arraydata['task_dayofmonth'];
        }else{
          return false;
        }
        $savedata['last_update_user'] = AuthService::userName();
        $savedata['last_update_date'] = \Carbon\Carbon::now();
        $num = HostTask::where('task_id',$arraydata['task_id'])->update($savedata);
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