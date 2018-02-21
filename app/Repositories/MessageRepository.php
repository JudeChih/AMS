<?php
namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\Message;
use Carbon\Carbon;
use DB;
// use SSH;

class MessageRepository {

	/**
	 * 藉由$msg_no抓取資料
	 * @param  [int] $msg_no [description]
	 * @return [array]         [description]
	 */
	public function getDataByPK($msg_no){
		return Message::where('isflag',1)->where('msg_no',$msg_no)->get();
	}
}