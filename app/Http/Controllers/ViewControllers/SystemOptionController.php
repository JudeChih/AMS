<?php
namespace App\Http\Controllers\ViewControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\SystemOptionRepository;
use File;

class SystemOptionController extends Controller {

  /**
   * View [ SystemOption ] Route 系統設定頁面
   */
  public function listData(){
  	$Ams_systemoption = new SystemOptionRepository();
  	$OptionData = $Ams_systemoption->getDataAll();
  	return view('systemoption',compact('OptionData'));
  }

  /**
   * View [ systemoption_modify ] 編輯系統設定頁面
   * @param [type] $request 透過裡面的option_id抓取資料
   */
  public function modify($option_id){
  	$Ams_systemoption = new SystemOptionRepository();
    $SystemOption = $Ams_systemoption->getDataByPK($option_id);
    return view('systemoption_modify', compact('SystemOption'));
  }

  /**
   * 下載客戶端 新安裝的[Host Config]檔
   * @return [json] [api_url & host_guid]
   */
  public function download($option_id){
    $Ams_systemoption = new SystemOptionRepository();
    $result = $Ams_systemoption->getDataAll();
    $data = array(
      'api_url' => $result[0]->api_url
    );
    $data = json_encode($data);
    $file = time() . '_file.txt';
    $destinationPath = public_path()."/upload/text/";
    if (!is_dir($destinationPath)) {  mkdir($destinationPath,0777,true);  }
    File::put($destinationPath.$file,$data);
    return response()->download($destinationPath.$file);
  }

	/**
   * @param  [type] $request 透過裡面的formType做不同的事情
   * formType == 'update' => 該資料修改完的存檔
   * @return string $prompt
   */
  public function save(Request $request){
  	$data = $request->all();
    if($data['formType'] == 'update'){
      $Ams_systemoption = new SystemOptionRepository();
      $boolean = $Ams_systemoption->update($data);
      $boolean == true ? $prompt = '修改成功！' : $prompt = '修改失敗！';
      return redirect('systemoption')->withErrors(['error' => $prompt]);
    }
  }
}