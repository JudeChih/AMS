<?php
namespace App\Http\Controllers\ViewControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\UserDataRepository;
use SSH;

class UserDataListController extends Controller {
  /**
   * View [ userdatalist ] Route 所有使用者資料頁面
   */
  public function listData(){
    if(isset($_GET['sort'])){
      $sort = $_GET['sort'];
      $order = $_GET['order'];
    }else{
      $sort = null;
      $order = null;
    }
    $Ams_userdata = new UserDataRepository();
    $UserData = $Ams_userdata->getDataPage($sort,$order);
    return view('userdatalist',compact('UserData','sort','order'));
  }

  /**
   * View [ userdata_create ] Route 新增使用者資料頁面
   */
  public function create(){
    return view('userdatalist_create');
  }

  /**
   * 導到選定的使用者的詳細資料頁面
   * @param [type] $request 透過裡面的host_guid以及comp_guid抓取資料
   */
  public function modify(Request $request){
    $Ams_userdata = new \App\Repositories\UserDataRepository();
    $UserData = $Ams_userdata->getDataByPK($request->ud_guid);
    return view('userdatalist_modify', compact('UserData'));
  }

  /**
   * 對使用者設定頁面訪問權限
   */
  public function auth(Request $request){
    $Ams_userauth = new \App\Repositories\UserAuthorityRepository();
    $UserAuth = $Ams_userauth->getDataByUdGuid($request->ud_guid);
    $Ams_userdata = new UserDataRepository();
    $UserData = $Ams_userdata->getDataByPK($request->ud_guid);
		return view('userdatalist_auth', compact('UserAuth','UserData'));
  }

	/**
   * @param  [type] $request 透過裡面的formType做不同的事件
   * formType == 'updateType' => 修改使用者的資料
   *          == 'updateAuth' => 修改使用者對於各頁面的權限
   *          == 'remove'     => 刪除使用者
   *          == 'create'     => 新增使用者
   * @return string $prompt
   */
  public function save(Request $request){
  	$data = $request->all();
    $formType = $data['formType'];
    if($formType == 'updateData'){
      $Ams_userdata = new UserDataRepository();
      $boolean = $Ams_userdata->update($data);
      $boolean == true ? $prompt = '修改成功！' : $prompt = '修改失敗！';
      return redirect('userdatalist')->withErrors(['error' => $prompt]);
    }elseif($formType == 'updateAuth'){
      $Ams_userauthority = new \App\Repositories\UserAuthorityRepository();
      $boolean = $Ams_userauthority->update($data);
      $boolean == true ? $prompt = '修改成功！' : $prompt = '修改失敗！';
      return $prompt;
    }elseif($formType == 'remove'){
      $id = $data['ud_guid'];
      $Ams_userdata = new UserDataRepository();
      $boolean = $Ams_userdata->delete($id);
      $boolean == true ? $prompt = '刪除成功！' : $prompt = '刪除失敗！';
      return redirect('userdatalist')->withErrors(['error' => $prompt]);
    }elseif($formType == 'create'){
      $Ams_userdata = new UserDataRepository();
      $ud_guid = $Ams_userdata->create($data);
      if($ud_guid != false){
        $Ams_userauthority = new \App\Repositories\UserAuthorityRepository();
        $boolean = $Ams_userauthority->create($ud_guid);
      }else{
        $boolean = false;
      }
      if($boolean){
        $prompt = '新增成功！';
      }else{
        $prompt = '新增失敗！';
      }
      return redirect('userdatalist')->withErrors(['error' => $prompt]);
    }
  }
}