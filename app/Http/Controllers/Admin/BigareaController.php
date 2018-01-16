<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Bigarea;
use App\Http\Model\Company;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class BigareaController extends CommonController
{

    function __construct() {
        $this->bigarea=new Bigarea;
        $this->middleware('admin.login.admin');
    }

    public function index()
    {
        $company = Company::get();
        return view('admin.bigarea',compact('company'));
    }

    public function ajax(){
        $input = Input::all();
        switch($input['action']){
            case 'getlist':
                $pagesize=8;
                $input['page']=($input['page']==0 || $input['page']>100) ? 1 :$input['page'];
                $result=$this->bigarea->getBigareaList($pagesize,$input['page'],$input);
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
            case 'edit':
                $this->bigarea->big_area_name =$input['big_area_name'];
                $this->bigarea->company_id =$input['company_id'];
                $this->bigarea->status =$input['status'];
                if($input['id'] ==''){
                    if($this->bigarea->save()){
                        $returnInfo=array(
                            'status' => 1,
                            'msg' => '操作成功!',
                        );
                    }else{
                        $returnInfo=array(
                            'status' => 0,
                            'msg' => '操作失败!',
                        );
                    }
                }else{
                    $data['big_area_name'] =$input['big_area_name'];
					$data['company_id'] =$input['company_id'];
                    $data['status'] =$input['status'];
                    if($this->bigarea->where('_id',$input['id'])->update($data)){
                        $returnInfo=array(
                            'status' => 1,
                            'msg' => '操作成功!',
                        );
                    }else{
                        $returnInfo=array(
                            'status' => 0,
                            'msg' => '操作失败!',
                        );
                    }
                }
                return response()->json($returnInfo);
                break;
        }

    }

}
