<?php
namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\Apiiolog;
use Carbon\Carbon;
use DB;

class ApiiologRepository {

	public function create(array $arraydata){
		echo 'create';
		$savedata['log_functionname'] = $arraydata['log_functionname'];
		$savedata['msg_no'] = $arraydata['msg_no'];
		$savedata['log_input'] = $arraydata['log_input'];
		$savedata['log_output'] = $arraydata['log_output'];
		$savedata['isflag'] = 1;
		$savedata['create_date'] = Carbon::now();
		$savedata['last_update_date'] = Carbon::now();

		return Apiiolog::insert($savedata);
	}

}