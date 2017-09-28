<?php
/**
 * Created by ...
 * User: zhanghui
 * Date: 16/12/10
 * DesCription:...
 */


namespace App\Http\Controllers\Home;

use App\Http\Model\Tools;
use Illuminate\Support\Facades\Input;

class ShareFileController extends CommonController
{
    function __construct() {
        parent::__construct();
        $this->tools=new Tools;
    }


    public function index()
    {
       

        return view('home.sharefile.index');
    }


    public  function downloadFile($tools_id){
        $tools = Tools::where('_id',$tools_id)->first();
        if(isset($tools->_id )){
            return response()->download($tools->tools_url);
        }else{
            exit('服务器繁忙!');
        }

    }


    public function ajax(){
        $input = Input::all();
        switch($input['action']){
            case 'getlist':
                $pagesize=8;
                $input = Input::all();
                $input['page']=($input['page']==0 || $input['page']>100) ? 1 :$input['page'];
                $input['doctor_id'] =session('user')->_id;
                $input['isshare'] = '1';
                $result=$this->tools->getToolsList($pagesize,$input['page'],$input);
                if(count($result[1])>0) {
                    $returnInfo=array(
                        'total_num' => $result[0],
                        'list' => $result[1],
                        'page_size' => $pagesize,
                        'page_total_num' => $result[2],
                        'status' => 1,
                        'msg' => 'ok',
                    );
                }else{
                    $returnInfo=array(
                        'status' => 0,
                        'msg' => '没有查询到数据',
                    );
                }
                return response()->json($returnInfo);
                break;
            case 'add':

                break;
        }

    }

}