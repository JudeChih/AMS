<?php
namespace App\Http\Controllers\APIControllers;

use App\Http\Controllers\Controller;
use App\Library\CommonTools;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class UpdateHostDataController extends Controller{
	/**
	 * 更新主機資料
	 * @param [json] $inputData [內含host_guid,file_name,update_type,task_id]
	 * @return [json] $resultData [內含result_no,result_message,task_next_date]
	 */
	public function UpdateHostData(Request $inputData){
		$inputData = json_encode($inputData->all());
		if(is_object($inputData)){
			$inputData = (array)$inputData;
		}
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

		$boolean = $this->checkFileNameFormat($arraydata['file_name'],$arraydata['update_type']);
		if(!$boolean){
			$error = 'C04001';
			return $this->uploadData($error,$inputData);
		}

		$ftp = new \App\Services\FtpService;
		// 初始化FTP設定
		$boolean = $ftp->_initialize();
		if(!$boolean){
			$error = 'C99999';
			return $this->uploadData($error,$inputData);
		}

		$boolean = $ftp->checkExist($arraydata['file_name']);
		if(!$boolean){
			$error = 'C04002';
			return $this->uploadData($error,$inputData);
		}

		$fileFullName = $ftp->download($arraydata['file_name']);
		if(is_null($fileFullName)){
			$error = 'C04003';
			return $this->uploadData($error,$inputData);
		}

		$dataArray = $this->readFileStringToArray($fileFullName);
		if(is_null($dataArray)){
			$error = 'C04004';
			return $this->uploadData($error,$inputData);
		}

		$boolean = $this->checkAndSaveFileData($dataArray,$arraydata['update_type']);
		if(is_null($boolean)){
			$error = 'C04005';
			return $this->uploadData($error,$inputData);
		}
		if(!$boolean){
			$error = 'C04006';
			return $this->uploadData($error,$inputData);
		}

		$ams_hosttask = new \App\Repositories\HostTaskRepository;
		$boolean = $ams_hosttask->updateNextDate($arraydata['task_id']);
		if($boolean){
			$data = $ams_hosttask->getDataByPK($arraydata['task_id']);
			$task_next_date = $data[0]['task_next_date'];
		}
		$error = 'C00000';
		return $this->uploadData($error,$inputData,$resultData);
	}

	/**
	 * [uploadData description]
	 * @param  [string] $error
	 * @param  [array] $inputData
	 * @param  [array] $resultData
	 * @return [array] $resultData
	 */
	private function uploadData($error,$inputData,$resultData=null){
		$resultData = CommonTools::createResultData($error,$resultData);
		CommonTools::writeApiLog('UpdateHostData',$error,$inputData,$resultData);
		return $resultData;
	}

	/**
	 * 檢查 InputData所有欄位值的格式
	 * @param  [array] $inputData [呼叫API所傳入的陣列]
	 * @return [boolean]          [檢查所有欄位的結果，全部正確回傳﹝TRUE﹞否則回傳﹝FALSE﹞]
	 */
	public function checkInputDataFormat($inputData){
		$boolean = CommonTools::checkArrayValueFormat($inputData,'host_guid');
		if(!$boolean){
			return false;
		}
		$boolean = CommonTools::checkArrayValueFormat($inputData,'file_name');
		if(!$boolean){
			return false;
		}
		$boolean = CommonTools::checkArrayValueFormat($inputData,'update_type');
		if(!$boolean){
			return false;
		}
		$boolean = CommonTools::checkArrayValueFormat($inputData,'task_id');
		if(!$boolean){
			return false;
		}
		return true;
	}

	/**
	 * 檢查檔案名稱格式是否與更新類別相符
	 * @param  [string] $file_name   [檔案名稱]
	 * @param  [string] $update_type [更新類別]
	 * @return [boolean]             [TRUE：相符、FALSE：不相符]
	 */
	public function checkFileNameFormat($file_name,$update_type){
		$arrayFileName = explode('-', $file_name);
		if(count($arrayFileName) != 3){
			return false;
		}
		if($arrayFileName[1] == 'baseinfo'){
			$fileNameNum = 0;
		}elseif($arrayFileName[1] == 'software'){
			$fileNameNum = 1;
		}elseif($arrayFileName[1] == 'program'){
			$fileNameNum = 2;
		}elseif($arrayFileName[1] == 'service'){
			$fileNameNum = 3;
		}elseif($arrayFileName[1] == 'phpentity'){
			$fileNameNum = 4;
		}else{
			return false;
		}
		if($fileNameNum != $update_type){
			return false;
		}
		return true;
	}

	/**
	 * 讀取檔案資料並轉為陣列
	 * @param  [string] $fileFullName [檔案路徑＋檔案名稱＋副檔名]
	 * @return [array]                [檔案中字串轉成的資料陣列]
	 */
	public function readFileStringToArray($fileFullName){
		$data = Storage::disk('public')->get($fileFullName);
		$dataArray = json_decode($data);
		if(count($dataArray) == 1){
			return $dataArray;
		}else{
			return null;
		}
	}

	/**
	 * 檢查檔案資料格式並儲存資料
	 * @param  [array] $dataArray    [資料陣列]
	 * @param  [string] $update_type [更新類別]
	 * @return [boolean]             [執行結果。TRUE：執行成功、FALSE：執行失敗]
	 */
	public function checkAndSaveFileData(Array $dataArray,$update_type){
		$dataArray = $dataArray[0];
		if(is_object($dataArray)){
			$dataArray = (array)$dataArray;
		}
		if($update_type == 0){
			if(is_null($dataArray['host_guid'])){ return null; }
			if(is_null($dataArray['host_name'])){ return null; }
			if(is_null($dataArray['host_type'])){ return null; }
			if(is_null($dataArray['host_parent'])){ return null; }
			if(is_null($dataArray['last_app_version'])){ return null; }
			if(is_null($dataArray['last_connect_date'])){ return null; }
			if(is_null($dataArray['last_update_date'])){ return null; }
			if(is_null($dataArray['host_connect_interval'])){ return null; }
			if(is_null($dataArray['host_collect_interval'])){ return null; }
			if(is_null($dataArray['host_cpu'])){ return null; }
			if(is_null($dataArray['host_ram'])){ return null; }
			if(is_null($dataArray['host_motherboard'])){ return null; }
			if(is_null($dataArray['host_os'])){ return null; }
			if(is_null($dataArray['host_computername'])){ return null; }
			$ams_hostdata = new \App\Repositories\HostDataRepository;
			return $ams_hostdata->updateBasicInfo($dataArray);
		}elseif($update_type == 1){
			if(is_null($dataArray['soft_id'])){ return null; }
			if(is_null($dataArray['file_id'])){ return null; }
			if(is_null($dataArray['host_guid'])){ return null; }
			if(is_null($dataArray['publisher'])){ return null; }
			if(is_null($dataArray['displayname'])){ return null; }
			if(is_null($dataArray['displayversion'])){ return null; }
			if(is_null($dataArray['installdate'])){ return null; }
			if(is_null($dataArray['architecture'])){ return null; }
			$ams_software = new \App\Repositories\SoftwareListRepository;
			return $ams_software->create($dataArray);
		}elseif($update_type == 2){
			if(is_null($dataArray['program_id'])){ return null; }
			if(is_null($dataArray['file_id'])){ return null; }
			if(is_null($dataArray['host_guid'])){ return null; }
			if(is_null($dataArray['owner'])){ return null; }
			if(is_null($dataArray['caption'])){ return null; }
			if(is_null($dataArray['description'])){ return null; }
			if(is_null($dataArray['executablepath'])){ return null; }
			if(is_null($dataArray['maximumworkingsetsize'])){ return null; }
			if(is_null($dataArray['minimumworkingsetsize'])){ return null; }
			if(is_null($dataArray['name'])){ return null; }
			if(is_null($dataArray['processid'])){ return null; }
			if(is_null($dataArray['sessionid'])){ return null; }
			if(is_null($dataArray['status'])){ return null; }
			if(is_null($dataArray['threadcount'])){ return null; }
			if(is_null($dataArray['workingsetprivate'])){ return null; }
			$ams_program = new \App\Repositories\ProgramListRepository;
			return $ams_program->create($dataArray);
		}elseif($update_type == 3){
			if(is_null($dataArray['service_id'])){ return null; }
			if(is_null($dataArray['file_id'])){ return null; }
			if(is_null($dataArray['host_guid'])){ return null; }
			if(is_null($dataArray['displayname'])){ return null; }
			if(is_null($dataArray['caption'])){ return null; }
			if(is_null($dataArray['description'])){ return null; }
			if(is_null($dataArray['name'])){ return null; }
			if(is_null($dataArray['pathname'])){ return null; }
			if(is_null($dataArray['processid'])){ return null; }
			if(is_null($dataArray['servicetype'])){ return null; }
			if(is_null($dataArray['started'])){ return null; }
			if(is_null($dataArray['startmode'])){ return null; }
			if(is_null($dataArray['startname'])){ return null; }
			if(is_null($dataArray['state'])){ return null; }
			$ams_service = new \App\Repositories\ServiceListRepository;
			return $ams_service->create($dataArray);
		}elseif($update_type == 4){
			if(is_null($dataArray['pnp_id'])){ return null; }
			if(is_null($dataArray['file_id'])){ return null; }
			if(is_null($dataArray['host_guid'])){ return null; }
			if(is_null($dataArray['caption'])){ return null; }
			if(is_null($dataArray['classguid'])){ return null; }
			if(is_null($dataArray['description'])){ return null; }
			if(is_null($dataArray['deviceid'])){ return null; }
			if(is_null($dataArray['manufacturer'])){ return null; }
			if(is_null($dataArray['name'])){ return null; }
			if(is_null($dataArray['pnpclass'])){ return null; }
			if(is_null($dataArray['pnpdeviceid'])){ return null; }
			$ams_phpentity = new \App\Repositories\PnpEntityRepository;
			return $ams_phpentity->create($dataArray);
		}
	}
}