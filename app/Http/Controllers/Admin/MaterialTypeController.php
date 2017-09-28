<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\MaterialType;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class MaterialTypeController extends CommonController
{

    function __construct() {
        $this->materialtype=new MaterialType;
        $this->middleware('admin.login.admin');
    }

    public function index()
    {
//        $materialType = $this->materialtype->where('status',1)->get();
        return view('admin.materialtype');
    }


    public function ajax(){
        $input = Input::all();
        switch($input['action']){
            case 'getlist':
                $pagesize=8;
                $input = Input::all();
                $input['page']=($input['page']==0 || $input['page']>100) ? 1 :$input['page'];
                $result=$this->materialtype->getMaterialtypeList($pagesize,$input['page'],$input);
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
                $this->materialtype->material_type_name =$input['material_type_name'];
                $this->materialtype->status =$input['status'];
                if($input['id'] ==''){
                    if($this->materialtype->save()){
                        $returnInfo=array(
                            'status' => 1,
                            'msg' => '添加成功',
                        );
                    }else{
                        $returnInfo=array(
                            'status' => 0,
                            'msg' => '添加失败',
                        );
                    }
                }else{
                    $data['material_type_name'] =$input['material_type_name'];
                    $data['status'] =$input['status'];
                    if($this->materialtype->where('_id',$input['id'])->update($data)){
                        $returnInfo=array(
                            'status' => 1,
                            'msg' => '编辑成功',
                        );
                    }else{
                        $returnInfo=array(
                            'status' => 0,
                            'msg' => '编辑失败',
                        );
                    }
                }
                return response()->json($returnInfo);
                break;
        }

    }


}
