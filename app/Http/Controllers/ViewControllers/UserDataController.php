<?php
namespace App\Http\Controllers\ViewControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\UserDataRepository;
use SSH;
use Session;

class UserDataController extends Controller {

  /**
   * View [ userdata ] Route 使用者個人資料頁面
   */
  public function listData(){
    $ud_guid = Session::get('ud_guid');
    $Ams_userdata = new UserDataRepository();
    $UserData = $Ams_userdata->getDataByPK($ud_guid);
    return view('userdata',compact('UserData'));
  }

  /**
   * 導到選定的使用者的詳細資料頁面
   * @param [type] $request 透過裡面的host_guid以及comp_guid抓取資料
   */
  public function modifypwd(Request $request){
    $Ams_userdata = new \App\Repositories\UserDataRepository();
    $UserData = $Ams_userdata->getDataByPK($request->ud_guid);
    return view('userdata_modifypwd', compact('UserData'));
  }

	/**
   * @param  [type] $request 透過裡面的formType做不同的事
   * formType == 'update' => 該資料的修改並存檔
   * @return string $prompt
   */
  public function save(Request $request){
  	$data = $request->all();
    if($data['formType'] == 'update'){
      $Ams_userdata = new UserDataRepository();
      $boolean = $Ams_userdata->update($data);
      $boolean == true ? $prompt = '修改成功！' : $prompt = '修改失敗！';
      return redirect('userdata')->withErrors(['error' => $prompt]);
    }
  }

}