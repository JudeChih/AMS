<?php
namespace App\Library;

use Illuminate\Http\Request;

class CommonTools {

	/**
	 * 將傳入的「Json格式字串」轉為〔Array〕
	 * @param  [string] $jsonString [呼叫API所傳入的字串]
	 * @return [array]             [轉換後的陣列，若轉換失敗則回傳Null]
	 */
	public static function convertJsonStringToArray($jsonString){
		echo 'convertJsonStringToArray';
		echo '<br>';
		if(is_null($jsonString) || strlen($jsonString) == 0){
			return null;
		}
		$jsonString = str_replace("'",'"',$jsonString);
		$jsonString = json_decode($jsonString,true);
		if(is_array($jsonString)){
			return $jsonString;
		}else{
			return null;
		}
	}

	/**
	 * 檢查陣列中指定Key是否存在，並檢查Vaule格式是否正確
	 * @param  [array]   $arrayData [資料陣列]
	 * @param  [string]  $key       [要檢查的key]
	 * @param  [int]     $maxLength [限制長度，若為0則不限制]
	 * @param  [boolean] $canEmpty  [可否〔不填值〕或〔空值〕]
	 * @param  [boolean] $canSpace  [可否包含〔空白〕]
	 * @return [boolean]             [檢查結果]
	 */
	public static function checkArrayValueFormat($arrayData,$key,$maxLength=0,$canEmpty=false,$canSpace=false){
		echo 'checkArrayValueFormat';
		echo '<br>';
		if(!is_array($arrayData)){
			return false;
		}
		if(array_key_exists($key,$arrayData) && is_null($arrayData[$key])){
			if(!$canEmpty){
				return false;
			}else{
				return true;
			}
		}
		if($maxLength != 0){
			if(strlen($arrayData[$key]) > $maxLength){
				return false;
			}
		}
		if(!$canSpace){
			if(preg_replace('/\s(?=)/', '', $arrayData[$key]) != $arrayData[$key]){
				return false;
			}
		}
		return true;
	}

	/**
	 * 依照傳入的「MessageCode」取得「回傳訊息」並建立回傳資料
	 * @param  [string] $msg_no    [訊息代碼]
	 * @param  [array]  $dataArray [要回傳的資料]
	 * @return [array]            [要回傳給Client的資料，若〔msg_no〕有問題則回傳﹝NULL﹞]
	 */
	public static function createResultData($msg_no,$dataArray=null){
		echo 'createResultData';
		echo '<br>';
		if(is_null($msg_no) || strlen($msg_no) == 0){
			return null;
		}
		$Ams_message = new \App\Repositories\MessageRepository;
		$data = $Ams_message->getDataByPK($msg_no);
		if(count($data) == 0 || $data == null){
			return null;
		}
		$msgArray = array("result_no"=>$data->msg_no,"result_message"=>$data->msg_content);
		if(!is_null($dataArray)){
			$msgArray = array_merge($msgArray,$dataArray);
		}
		return $msgArray;
	}

  /**
   * 取得隨機GUID字串, 依「$havedash」決定是否包含Dash
   * @param type $havedash 是否包含Dash
   * @return type GUID字串
   */
  public static function generateGUID($havedash) {
  	echo 'generateGUID';
		echo '<br>';
    if ($havedash) {
      $formatstring = '%04x%04x-%04x-%04x-%04x-%04x%04x%04x';
    } else {
      $formatstring = '%04x%04x%04x%04x%04x%04x%04x%04x';
    }

    return sprintf($formatstring,
            // 32 bits for "time_low"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            // 16 bits for "time_mid"
            mt_rand(0, 0xffff),
            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand(0, 0x0fff) | 0x4000,
            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand(0, 0x3fff) | 0x8000,
            // 48 bits for "node"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    );
  }

  /**
   * 對陣列中所有值執行「rawurlencode」，將陣列轉換成 字串
   * @param  [array] $dataArray [陣列]
   * @return [string]           [字串]
   */
	public static function urlEncodeArray($dataArray){
		echo 'urlEncodeArray';
		echo '<br>';
		if(!is_array($dataArray)){
			return rawurlencode($dataArray);
		}else{
      foreach ($dataArray as $key => $value) {
          $dataArray[$key] = Commontools::UrlEncodeArray($value);
      }
			return $dataArray;
		}
	}

	/**
	 * 寫入API執行記錄
	 * @param  [string] $functionName [所使用的功能名稱]
	 * @param  [string] $msgg_no      [回傳訊息代碼]
	 * @param  [string] $input        [呼叫API所傳入的值]
	 * @param  [array] $output       [執行結束回傳的值，使用 json_decode轉為字串後再存入]
	**/
	public static function writeApiLog($functionName,$msg_no,$input,$output){
		echo 'writeApiLog';
		echo '<br>';
		if(strlen($functionName) == 0 || strlen($msg_no) == 0 || strlen($input) == 0 || !is_array($output) ){
			return false;
		}
		$arraydata = array("log_functionname"=>$functionName,"msg_no"=>$msg_no,"log_input"=>$input,"log_output"=>json_decode($output));

		$Apiiplog = new \App\Repositories\ApiiologRepository;
		$boolean = $Apiiplog->create($arraydata);
		if($boolean){
			return true;
		}else{
			return false;
		}
	}
}