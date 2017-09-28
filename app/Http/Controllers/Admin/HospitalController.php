<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Hospital;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class HospitalController extends CommonController
{
    function __construct() {
        $this->hospital=new Hospital;
        $this->middleware('admin.login.admin');
    }

    public function index()
    {
        
        return view('admin.hospital');
    }


    public function ajax(){
        $input = Input::all();
        switch($input['action']){
            case 'getlist':
                $pagesize=8;
                $input = Input::all();
                $input['page']=($input['page']==0 || $input['page']>100) ? 1 :$input['page'];
                $result=$this->hospital->getHospitalList($pagesize,$input['page'],$input);
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
                $input = Input::all();
                $this->hospital->hospital_name =$input['hospital_name'];
                $this->hospital->hospital_level_id =$input['hospital_level_id'];
                $this->hospital->hospital_level_name =$input['hospital_level_name'];
                $this->hospital->province_id =$input['province_id'];
                $this->hospital->city_id =$input['city_id'];
                $this->hospital->region_id =$input['region_id'];
                $this->hospital->province_name =$input['province_name'];
                $this->hospital->city_name =$input['city_name'];
                $this->hospital->region_name =$input['region_name'];
                $this->hospital->status =$input['status'];
                if($input['id'] ==''){
                    if($this->hospital->save()){
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
                    $data['hospital_name'] =$input['hospital_name'];
                    $data['hospital_level_id'] =$input['hospital_level_id'];
                    $data['hospital_level_name'] =$input['hospital_level_name'];
                    $data['province_id'] =$input['province_id'];
                    $data['city_id'] =$input['city_id'];
                    $data['region_id'] =$input['region_id'];
                    $data['province_name'] =$input['province_name'];
                    $data['city_name'] =$input['city_name'];
                    $data['region_name'] =$input['region_name'];
                    $data['status'] =$input['status'];
                    if($this->hospital->where('_id',$input['id'])->update($data)){
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
