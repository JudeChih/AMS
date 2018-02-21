<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class testApiController extends Controller {

	public function testApi(){
		return view('testAPI');
	}

		// $data = array('host_guid'=>'e507f559-9113-4d2e-bc49-f3f4a2c10e76','file_name'=>'e507f55991134d2ebc49f3f4a2c10e76-baseinfo-20170410140659.txt','update_type'=>0,'task_id'=>1);
    // $data = json_encode($data);
    // $up = new \App\Http\Controllers\API\UpdateHostDataController;
    // $up->UpdateHostData($data);
}