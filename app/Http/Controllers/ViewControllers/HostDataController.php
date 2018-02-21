<?php
namespace App\Http\Controllers\ViewControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\HostDataRepository;
use SSH;
use File;

class HostDataController extends Controller {

  /**
   * View [ HostData ] Route 主機列表頁面
   */
  public function listData(){
    if(isset($_GET['sort'])){
      $sort = $_GET['sort'];
      $order = $_GET['order'];
    }else{
      $sort = null;
      $order = null;
    }
    $HostData = new HostDataRepository();
    $HostData = $HostData->getDataPage($sort,$order);
    return view('hostdata',compact('HostData','sort','order'));
  }

  /**
   * @param [type] $request 透過裡面的host_guid以及comp_guid抓取資料
   */
  public function detail($guid){
    $HostData = new HostDataRepository();
    $HostData = $HostData->getDataByHostGUID($guid);
    $pnpentity = new \App\Repositories\PnpentityRepository();
    $result = $pnpentity->getDataByHostGUID($guid);
    if(count($result) == 0){
      return view('hostdata_detail', compact('HostData'));
    }
    $ListData = $pnpentity->classMenu($result);
    return view('hostdata_detail', compact('ListData','HostData'));
  }

  /**
   * @param [type] [$request] 透過裡面的formType做不同的事情
   * formType == 'remove' => 刪除選擇資料
   * @return string $prompt
   */
  public function save(Request $request){
    $data = $request->all();
    if($data['formType'] == 'remove'){
      $id = $request->host_guid;
      $HostData = new HostDataRepository();
      $boolean = $HostData->delete($id);
      $boolean == true ? $prompt = '刪除成功！' : $prompt = '刪除失敗！';
      return redirect('/hostdata')->withErrors(['error' => $prompt]);
    }
  }

  /**
   * 下載客戶端重新安裝的[Host Config]檔
   * @return [json] [api_url & host_guid]
   */
  public function download($guid){
    $systemoption = new \App\Repositories\SystemOptionRepository();
    $result = $systemoption->getDataAll();

    $data = array(
      'api_url' => $result[0]->api_url,
      'host_guid' => $guid
    );
    $data = json_encode($data);
    $file = time() . '_file.txt';
    $destinationPath = public_path()."/upload/text/";
    if (!is_dir($destinationPath)) {  mkdir($destinationPath,0777,true);  }
    File::put($destinationPath.$file,$data);
    return response()->download($destinationPath.$file);
  }


}