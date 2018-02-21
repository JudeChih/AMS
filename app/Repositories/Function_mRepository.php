<?php
namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\Function_m;
use Carbon\Carbon;
use DB;
// use SSH;

class Function_mRepository {

  /**
   * 抓取所有功能主檔
   */
  public function getDataAll(){
  	return Function_m::where('isflag',1)->where('fm_type',2)->get();
  }
}