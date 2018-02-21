<?php
namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\Function_d;
use Carbon\Carbon;
use DB;
// use SSH;

class Function_dRepository {

  /**
   *透過傳入的fm_id得到fd資料
   */
  public function getDataByFmID($fm_id){
    return Function_d::where('isflag',1)->where('fm_id',$fm_id)->get();
  }


}