<?php
namespace App\Http\Controllers\APIControllers;

use App\Http\Controllers\Controller;
use App\Library\CommonTools;
use Illuminate\Http\Request;

class CheckClientVersionController extends Controller{
	/**
	 * 回報版本編號，檢查是否需更新程式，若需更新則回傳檔案下載路徑
	 * @param [json] $inputData [內含host_guid,ver_major,ver_minor,ver_build,ver_revision]
	 * @return [json] $resultData []
	 */
	public function CheckClientVersion(Request $inputData){
		$inputData = json_encode($inputData->all());
		if(is_object($inputData)){
			$inputData = (array)$inputData;
		}
		$arraydata = CommonTools::convertJsonStringToArray($inputData);
		if(is_null($inputData)){
			$error = 'C99001';
			return $this->uploadData($error,$inputData);
		}
		$boolean = $this->checkInputDataFormat($arraydata);
		if(!$boolean){
			$error = 'C99002';
			return $this->uploadData($error,$inputData);
		}
		$boolean = $this->updateHostLastVersion($arraydata['host_guid'],$arraydata['ver_major'],$arraydata['ver_minor'],$arraydata['ver_build'],$arraydata['ver_revision']);
		if(!$boolean){
			$error = 'C02001';
			return $this->uploadData($error,$inputData);
		}
		$version_url = $this->getNewestVersionUrl($arraydata['ver_major'],$arraydata['ver_minor'],$arraydata['ver_build'],$arraydata['ver_revision']);
		if(is_null($version_url)){
			$error = 'C00000';
			return $this->uploadData($error,$inputData);
		}
		$error = 'C02002';
		$resultData['new_version_url'] = $version_url;
		return $this->uploadData($error,$inputData,$resultData);
	}

	/**
	 * 上傳錯誤代碼，建檔
	 * @param  [string] $error      [錯誤代碼]
	 * @param  [string] $inputData  [內含host_guid,ver_major,ver_minor,ver_build,ver_revision]
	 * @param  [array] $resultData
	 * @return [type]  $resultData
	 */
	private function uploadData($error,$inputData,$resultData=null){
		$resultData = CommonTools::createResultData($error,$resultData);
		CommonTools::writeApiLog('CheckClientVersion',$error,$inputData,$resultData);
		return $resultData;
	}

	/**
	 * 檢查 InputData所有欄位值的格式
	 * @param  [array] $inputData [呼叫API所傳入的陣列]
	 * @return [boolean] true or false [檢查所有欄位的結果，全部正確回傳﹝TRUE﹞否則回傳﹝FALSE﹞]
	 */
	//$arraydata['ver_major'],$arraydata['ver_minor'],$arraydata['ver_build'],$arraydata['ver_revision']
	public function checkInputDataFormat($inputData){
		$boolean = CommonTools::checkArrayValueFormat($inputData,'ver_major',5);
		if(!$boolean){
			return false;
		}
		$boolean = CommonTools::checkArrayValueFormat($inputData,'ver_minor',5);
		if(!$boolean){
			return false;
		}
		$boolean = CommonTools::checkArrayValueFormat($inputData,'ver_build',5);
		if(!$boolean){
			return false;
		}
		$boolean = CommonTools::checkArrayValueFormat($inputData,'ver_revision',5);
		if(!$boolean){
			return false;
		}
		$boolean = CommonTools::checkArrayValueFormat($inputData,'host_guid');
		if(!$boolean){
			return false;
		}
		return true;
	}

	/**
	 * 更新主機目前版本編號
	 * @param  [type] $host_guid    [主機代碼]
	 * @param  [type] $ver_major    [版本號碼的主要元件值]
	 * @param  [type] $ver_minor    [版本號碼的次要元件值]
	 * @param  [type] $ver_build    [版本號碼之組建元件值]
	 * @param  [type] $ver_revision [版本號碼的修訂元件值]
	 * @return [boolean] true or false [執行結果]
	 */
	public function updateHostLastVersion($host_guid,$ver_major,$ver_minor,$ver_build,$ver_revision){
		$modifyData['last_app_version'] = $ver_major.'.'.$ver_minor.'.'.$ver_build.'.'.$ver_revision;
		$modifyData['host_guid'] = $host_guid;
		$Ams_hostdata = new \App\Repositories\HostDataRepository;
		$result = $Ams_hostdata->update($modifyData);
		return $result;
	}

	/**
	 * 取得大於傳入的版本編號的最新版本下載位置
	 * @param  [string] $ver_major    [版本號碼的主要元件值]
	 * @param  [string] $ver_minor    [版本號碼的次要元件值]
	 * @param  [string] $ver_build    [版本號碼之組建元件值]
	 * @param  [string] $ver_revision [版本號碼的修訂元件值]
	 * @return [string]               [最新的版本下載位置，若無較新的資料則回傳﹝NULL﹞]
	 */
	public function getNewestVersionUrl($ver_major,$ver_minor,$ver_build,$ver_revision){
		$Ams_appversion = new \App\Repositories\AppVersionRepository;
		$resultData = $Ams_appversion->getNewestVersion();
		$systemOption = new \App\Repositories\SystemoptionRepository;
		$systemData = $systemOption->getDataAll();
		// 檔案下載位置
		$url = $systemData[0]['api_url'].$resultData['ver_directory'].$resultData['ver_filename'];

		if(is_null($resultData)){
			return null;
		}
		$resultData = $resultData[0];
		if($resultData['ver_major'] > $ver_major){
			return $url;
		}
		if($resultData['ver_minor'] > $ver_minor){
			return $url;
		}
		if($resultData['ver_build'] > $ver_build){
			return $url;
		}
		if($resultData['ver_revision'] > $ver_revision){
			return $url;
		}
		return null;
	}
}