<?php
namespace App\Http\Controllers\APIControllers;

use App\Http\Controllers\Controller;
use App\Library\CommonTools;
use Illuminate\Http\Request;

class SignUpHostController extends Controller{
	/**
	 * 註冊Client端主機並回傳Host_GUID
	 * @param [json] $inputData [內含host_name]
	 * @return [json] $resultData [內含result_no,result_message,host_guid]
	 */
	public function SignUpHost(Request $inputData = null){
		$inputData = json_encode($inputData->all());
		if(is_object($inputData)){
			$inputData = (array)$inputData;
		}
		$arrayData = CommonTools::convertJsonStringToArray($inputData);
		if(is_null($arrayData)){
			$error = 'C99001';
			return $this->uploadData($error,$inputData);
		}

		$boolean = $this->checkInputDataFormat($arrayData);
		if(!$boolean){
			$error = 'C99002';
			return $this->uploadData($error,$inputData);
		}

		$host_guid = $this->createHostData($arrayData['host_name']);
		if(is_null($host_guid)){
			$error = 'C01001';
			return $this->uploadData($error,$inputData);
		}
		$error = 'C00000';
		$resultData['host_guid'] = $host_guid;
		return $this->uploadData($error,$inputData,$resultData);
	}

	/**
	 * 上傳錯誤代碼，建檔
	 * @param  [string] $error      [錯誤代碼]
	 * @param  [string] $inputData  [內含host_name]
	 * @param  [array]  $resultData [內含host_guid]
	 * @return [array]  $resultData [內含result_no,result_message,host_guid]
	 */
	private function uploadData($error,$inputData,$resultData=null){
		$resultData = CommonTools::createResultData($error,$resultData);
		CommonTools::writeApiLog('SignUpHost',$error,$inputData,$resultData);
		return $resultData;
	}

	/**
	 * 檢查 InputData所有欄位值的格式
	 * @param  [array] $inputData [呼叫API所傳入的陣列]
	 * @return [boolean] true or false [檢查所有欄位的結果，全部正確回傳﹝TRUE﹞否則回傳﹝FALSE﹞]
	 */
	private function checkInputDataFormat($inputData){
		$boolean = true;
		$result = CommonTools::checkArrayValueFormat($inputData,'host_name');
		if(!$result){
			$boolean = $result;
			return $boolean;
		}
		return $boolean;
	}

	/**
	 * 建立〔主機資料〕並取得〔host_guid〕
	 * @param  [string] $host_name [主機名稱]
	 * @return [array]             [依查詢到的資料所建立的陣列，若查詢失敗回傳〈NULL〉]
	 */
	private function createHostData($host_name){
		$modifyData['host_name'] = $host_name;
		$Ams_hostdata = new \App\Repositories\HostDataRepository;
		$host_guid = $Ams_hostdata->createGetId($modifyData);
		return $host_guid;
	}

}