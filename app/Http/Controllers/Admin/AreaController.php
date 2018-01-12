<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Area;
use App\Http\Model\Bigarea;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class AreaController extends CommonController
{
    function __construct() {
        $this->area=new Area;
        $this->middleware('admin.login.admin');
    }

    public function index()
    {
        $bigArea=Bigarea::where('status','1')->get();
        return view('admin.area',compact('bigArea'));
    }



    public function ajax(){
        $input = Input::all();
        switch($input['action']){
            case 'getlist':
                $pagesize=8;
                $input = Input::all();
                $input['page']=($input['page']==0 || $input['page']>100) ? 1 :$input['page'];
                $result=$this->area->getAreaList($pagesize,$input['page'],$input);
                if(count($result[1])>0) {
                    foreach($result[1] as $k=>$v){
                        $bigarea = BigArea::where('_id',$v->big_area_id)->first();
                        if(isset($bigarea->big_area_name) && $bigarea->big_area_name){
							$company =$bigarea->getCompany($bigarea->company_id);
							$result[1][$k]->big_area_name =$bigarea->big_area_name."({$company})";
                        }
                    }
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
                $this->area->big_area_id =$input['big_area_id'];
                $this->area->area_name =$input['area_name'];
                $this->area->status =$input['status'];
                if($input['id'] ==''){
                    if($this->area->save()){
                        $returnInfo=array(
                            'status' => 1,
                            'msg' => '添加成功!',
                        );
                    }else{
                        $returnInfo=array(
                            'status' => 0,
                            'msg' => '添加失败!',
                        );
                    }
                }else{
                    $data['big_area_id'] =$input['big_area_id'];
                    $data['area_name'] =$input['area_name'];
                    $data['status'] =$input['status'];
                    if($this->area->where('_id',$input['id'])->update($data)){
                        $returnInfo=array(
                            'status' => 1,
                            'msg' => '编辑成功!',
                        );
                    }else{
                        $returnInfo=array(
                            'status' => 0,
                            'msg' => '编辑失败!',
                        );
                    }
                }
                return response()->json($returnInfo);
                break;

        }

    }


}
