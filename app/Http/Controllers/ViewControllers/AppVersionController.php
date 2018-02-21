<?php
namespace App\Http\Controllers\ViewControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\AppVersionRepository;
use File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;

class AppVersionController extends Controller {

  /**
   * View [ AppVersion ] Route 程式版本資料頁面
   */
	public function listData(){
  	if(isset($_GET['sort'])){
      $sort = $_GET['sort'];
      $order = $_GET['order'];
    }else{
      $sort = null;
      $order = null;
    }
  	$appversion = new AppVersionRepository();
  	$VersionData = $appversion->getDataPage($sort,$order);
  	return view('appversion',compact('order','sort','VersionData'));
  }

	/**
	 * View [ hosttask_create ] 新增程式版本頁面
	 */
  public function create(){
  	return view('appversion_create');
  }

  /**
   * @param [type] $request 透過裡面的formType做不同的存檔動作
   * formType == create => 新增頁面的存檔
   * formType == upDate => 新版改停用的存檔
   */
  public function save(Request $request){
    $data = $request->all();
    if($data['formType'] == 'create'){
      if($request->file('ver_filename') !== null){
        // 檔案格式
        $extension = $request->file('ver_filename')->getClientOriginalExtension();
        if ($extension != 'zip') {
           return redirect()->back()->withInput()->withErrors(['error' => '檔案格式錯誤！！']);
        }
        // 檔案內容
        $files = $request->file('ver_filename');
        echo $files;
        // 檔案名稱
        $dd = \Carbon\Carbon::now();
        $file_name = $dd->year.sprintf('%02d',$dd->month).sprintf('%02d',$dd->day).sprintf('%02d',$dd->hour).sprintf('%02d',$dd->minute).sprintf('%02d',$dd->second);
        // 檔案路徑
        $file_path = "/appversionZip/";

        // 開始upload檔案
        $file = Input::file('ver_filename');
        $file->move($file_path,$file_name.'.'.$extension);

        // 檔案名稱
        $data['ver_filename'] = $file_name.'.'.$extension;
        // 檔案路徑
        $data['ver_directory'] = $file_path;
        $appversion = new AppVersionRepository();

        $versionData = $appversion->getNewestVersion();
        if(count($versionData) > 0 ){
          $arraydata['ver_id'] = $versionData[0]->ver_id;
          $arraydata['ver_status'] = 2;
          $boolean = $appversion->update($arraydata);
        }
        $boolean = $appversion->create($data);
        if(isset($boolean)){
          $boolean == true ? $prompt = '新增成功！' : $prompt = '新增失敗！';
        }else{
          $prompt = '新增失敗！';
        }
        return redirect('/appversion')->withErrors(['error' => $prompt]);
      }else{
        return redirect()->back()->withInput()->withErrors(['error' => '檔案上傳失敗！！']);
      }
    }else if($data['formType'] == 'upDate'){
      $appversion = new AppVersionRepository();

      $arraydata['ver_id'] = $data['ver_id'];
      $arraydata['ver_status'] = 0;
      $boolean = $appversion->update($arraydata);

      $boolean == true ? $prompt = '停用成功！' : $prompt = '停用失敗！';
      return redirect('/appversion')->withErrors(['error' => $prompt]);
    }
  }
}