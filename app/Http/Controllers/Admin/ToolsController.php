<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Tools;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ToolsController extends CommonController
{
    function __construct() {
        $this->tools=new Tools;
    }

    public function index()
    {
        
        return view('admin.tools');
    }


    public  function downloadFile($tools_id){

        $tools = Tools::where('_id',$tools_id)->first();
        if(isset($tools->_id )){
            return response()->download($tools->tools_url);
        }else{
            exit('服务器繁忙!');
        }

    }


    public function toolsAdd()
    {
        $msg='';
        if($input = Input::all()) {
            $this->tools->file_name = $input['file_name'];
            $this->tools->file_weight = $input['file_weight'];
            $this->tools->upload_status = '1';
            $this->tools->tools_url = $this->upload();
            $this->tools->addtime = (string)time();
            if ($this->tools->save()) {
                $msg = '发布成功!';
            } else {
                $msg = '发布失败!';
            }
        }
        return view('admin.toolsAdd',compact('msg'));
    }


    public function ajax(){
        $input = Input::all();
        switch($input['action']){
            case 'getlist':
                $pagesize=8;
                $input = Input::all();
                $input['page']=($input['page']==0 || $input['page']>100) ? 1 :$input['page'];
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
            case 'delete':

                if($this->tools->destroy($input['id'])){
                    $returnInfo=array(
                        'status' => 1,
                        'msg' => '删除成功!',
                    );

                }else{
                    $returnInfo=array(
                        'status' => 0,
                        'msg' => '删除失败!',
                    );
                }
                return response()->json($returnInfo);
                break;
        }

    }


}
