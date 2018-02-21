<?php
namespace App\Http\Controllers\ViewControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\HosttaskRepository;
use Illuminate\Support\Facades\Storage;
use File;

class HosttaskController extends Controller {

  /**
   * View [ HostTask ] Route 主機排程設定頁面
   */
  public function listData(){
  	if(isset($_GET['sort'])){
      $sort = $_GET['sort'];
      $order = $_GET['order'];
    }else{
      $sort = null;
      $order = null;
    }
  	$Ams_hosttask = new HosttaskRepository();
  	$TaskData = $Ams_hosttask->getDataPage($sort,$order);
  	return view('hosttask',compact('order','sort','TaskData'));
  }

  /**
   * View [ hosttask_modify ] 編輯主機排程頁面
   * @param [type] $request 透過裡面的host_guid抓取資料
   */
  public function modify($guid,$task_id){
  	$Ams_hosttask = new HosttaskRepository();
    $HostTask = $Ams_hosttask->getDataByPK($task_id);
    return view('hosttask_modify', compact('HostTask'));
  }

  /**
   * View [ hosttask_create ] 新增主機排程頁面
   */
  public function create(){
    $Ams_hostdata = new \App\Repositories\HostDataRepository();
    $hostData = $Ams_hostdata->getDataAll();
    return view('hosttask_create',compact('hostData'));
  }

	/**
   * @param  [type] $request 透過裡面的formType做動作
   * @return string $prompt
   */
  public function save(Request $request){
  	$data = $request->all();
    if($data['formType'] == 'create'){
      $Ams_hosttask = new HosttaskRepository();
      $Ams_hostdata = new \App\Repositories\HostDataRepository();
      $task_id = $Ams_hosttask->create($data);
      $boolean = $Ams_hosttask->updateNextDate($task_id);
      $boolean == true ? $prompt = '新增成功！' : $prompt = '新增失敗！';
      return redirect('/hosttask')->withErrors(['error' => $prompt]);
    }elseif($data['formType'] == 'update'){
      $Ams_hosttask = new HosttaskRepository();
      $boolean = $Ams_hosttask->update($data);
      if($boolean){
        $boolean = $Ams_hosttask->updateNextDate($data['task_id']);
      }
      $boolean == true ? $prompt = '修改成功！' : $prompt = '修改失敗！';
      return redirect('/hosttask')->withErrors(['error' => $prompt]);
    }elseif($data['formType'] == 'remove'){
      $id = $request->task_id;
      $Ams_hosttask = new HosttaskRepository();
      $boolean = $Ams_hosttask->delete($id);
      $boolean == true ? $prompt = '刪除成功！' : $prompt = '刪除失敗！';
      return redirect('/hosttask')->withErrors(['error' => $prompt]);
    }
  }
}