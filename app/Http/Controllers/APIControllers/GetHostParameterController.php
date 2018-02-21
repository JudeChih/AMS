<?php
namespace App\Http\Controllers\APIControllers;

use App\Http\Controllers\Controller;
use App\Library\CommonTools;
use Illuminate\Http\Request;

class GetHostParameterController extends Controller{
	/**
	 * 取得Host Agent執行時所需的參數
	 * @param [json] $inputData [內含host_guid]
	 * @return [json] $resultData []
	 */
	public function GetHostParameter(Request $inputData){
		$inputData = json_encode($inputData->all());
		$arraydata = CommonTools::convertJsonStringToArray($inputData);
		if(is_null($arraydata)){
			$error = 'C99001';
			return $this->uploadData($error,$inputData);
		}
		$boolean = $this->checkInputDataFormat($arraydata);
		if(!$boolean){
			$error = 'C99002';
			return $this->uploadData($error,$inputData);
		}
		$hostData = $this->createResult_HostData($arraydata['host_guid']);
		if(is_null($hostData)){
			$error = 'C03001';
			return $this->uploadData($error,$inputData);
		}else{
			$resultData = $hostData;
		}
		$taskData = $this->createResult_TaskData($arraydata['host_guid']);
		if(is_null($taskData)){
			$error = 'C03002';
			return $this->uploadData($error,$inputData);
		}else{
			$resultData['taskdata'] = $taskData;
		}
		$ftpData = $this->createResult_FtpData();
		if(is_null($ftpData)){
			$error = 'C03003';
			return $this->uploadData($error,$inputData);
		}else{
			$resultData['ftpdata'] = $ftpData;
		}
		$error = 'C00000';
		return $this->uploadData($error,$inputData,$resultData);
	}

	/**
	 * 上傳錯誤代碼，建檔
	 * @param  [string] $error      [錯誤代碼]
	 * @param  [array] $inputData  [description]
	 * @param  [array] $resultData [description]
	 * @return [type]             [description]
	 */
	private function uploadData($error,$inputData,$resultData=null){
		$resultData = CommonTools::createResultData($error,$resultData);
		CommonTools::writeApiLog('GetHostParameter',$error,$inputData,$resultData);
		return $resultData;
	}

	/**
	 * 檢查 InputData所有欄位值的格式
	 * @param  [array] $inputData [呼叫API所傳入的陣列]
	 * @return [boolean]            [檢查所有欄位的結果，全部正確回傳﹝TRUE﹞否則回傳﹝FALSE﹞]
	 */
	public function checkInputDataFormat($inputData){
		$boolean = CommonTools::checkArrayValueFormat($inputData,'host_guid');
		if(!$boolean){
			return false;
		}
		return true;
	}

	/**
	 * 建立回傳資料 〔主機資料〕
	 * @param  [string] $host_guid [主機代碼]
	 * @return [array]            [依查詢到的資料所建立的陣列，若查詢失敗回傳〈NULL〉]
	 */
	public function createResult_HostData($host_guid){
		$Ams_hostdata = new \App\Repositories\HostDataRepository;
		$data = $Ams_hostdata->getDataByHostGUID($host_guid);
		if(is_null($data)){
			return null;
		}
		$data = $data[0];
		$resultData['host_connect_interval'] = $data['host_connect_interval'];
		$resultData['host_update_interval'] = $data['host_update_interval'];
		return $resultData;
	}

	/**
	 * 建立回傳資料 〔排程資料〕
	 * @param  [string] $host_guid [主機代碼]
	 * @return [array]            [依查詢到的資料所建立的陣列，若查詢失敗回傳〈NULL〉]
	 */
	public function createResult_TaskData($host_guid){
		$Ams_hosttask = new \App\Repositories\HostTaskRepository;
		$data = $Ams_hosttask->getDataByHostGUID($host_guid);
		if(is_null($data)){
			return null;
		}
		for($i=0;$i<count($data);$i++){
			$arrayData['execute_type'] = $data[$i]['execute_type'];
			$arrayData['task_collect_interval'] = $data[$i]['task_collect_interval'];
			$arrayData['task_id'] = $data[$i]['task_id'];
			$arrayData['task_next_date'] = $data[$i]['task_next_date'];
			$resultData[$i] = $arrayData;
		}
		return $resultData;
	}

	/**
	 * 建立回傳資料 〔FTP資料〕
	 * @return [array] [依查詢到的資料所建立的陣列，若查詢失敗回傳〈NULL〉]
	 */
	public function createResult_FtpData(){
		$Ams_systemoption = new \App\Repositories\SystemOptionRepository;
		$data = $Ams_systemoption->getDataAll();
		if(is_null($data)){
			return null;
		}
		$data = $data[0];
		$resultData['ftp_url'] = $data['ftp_url'];
		$resultData['ftp_directory'] = $data['ftp_directory'];
		$resultData['ftp_user'] = $data['ftp_user'];
		$resultData['ftp_pwd'] = $data['ftp_pwd'];
		return $resultData;
	}
}