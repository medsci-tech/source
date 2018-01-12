<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Sales;
use App\Http\Model\Bigarea;
use App\Http\Model\Area;
use App\Http\Model\SalesMaterialType;
use App\Http\Model\MaterialType;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class SalesController extends CommonController
{
    function __construct() {
        $this->sales=new Sales;
        $this->salesmaterialtype=new SalesMaterialType;
        $this->middleware('admin.login.admin');
    }

    public function index()
    {
        $bigarea = Bigarea::where('status','1')->get();
        $area = Area::where('status','1')->get();
        $materialType = materialType::where('status','1')->get();
        return view('admin.sales',compact('bigarea','area','materialType'));
    }


    public function ajax(){
        $input = Input::all();
        switch($input['action']){
            case 'getlist':
                $pagesize=8;
                $input = Input::all();
                $input['page']=($input['page']==0 || $input['page']>100) ? 1 :$input['page'];
                $result=$this->sales->getSalesList($pagesize,$input['page'],$input);
                if(count($result[1])>0) {
                    foreach($result[1] as $k=>$v) {
                        $bigarea = Bigarea::where('_id', $v->big_area_id)->first();
                        $area = Area::where('_id', $v->area_id)->first();
                        if (isset($bigarea->big_area_name) &&$bigarea->big_area_name) {
							$company =$bigarea->getCompany($bigarea->company_id);
                            $result[1][$k]->big_area_name = $bigarea->big_area_name."({$company})";
                        }else {
                            $result[1][$k]->big_area_name = '暂无';
                        }
                        if (isset($area->area_name) && $area->area_name) {
                            $result[1][$k]->area_name = $area->area_name;
                        } else {
                            $result[1][$k]->area_name = '暂无';
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
            case 'editSales':
                $input = Input::all();
                $this->sales->big_area_id =$input['big_area_id'];
                $this->sales->area_id =$input['area_id'];
                $this->sales->sales_name =$input['sales_name'];
                $this->sales->status =$input['status'];
                $this->sales->addtime =(string)time();
                if($input['sales_id'] ==''){
                    if($this->sales->save()){
//                        $sales = $this->sales->where('big_area_id', $input['big_area_id'])->where('area_id', $input['area_id'])->where('sales_name', $input['sales_name'])->first();
//                        p($sales);die;
//                        $this->salesmaterialtype->sales_id =$sales->_id;
//                        $this->salesmaterialtype->material_type_id =$input['material_type_id'];
//                        $this->salesmaterialtype->price =$input['price'];
//                        $this->salesmaterialtype->save();
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
                    $data['area_id'] =$input['area_id'];
                    $data['sales_name'] =$input['sales_name'];
                    $data['status'] =$input['status'];
                    if($this->sales->where('_id',$input['sales_id'])->update($data)){
//                        $data['price'] =$input['price'];
//                        $this->sales->where('sales_id',$input['sales_id'])->where('material_type_id',$input['material_type_id'])->update($data);
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
            case 'editPrice':
                $salesmaterialtype = $this->salesmaterialtype->where('sales_id', $input['sales_id'])->where('material_type_id', $input['material_type_id'])->first();
                if(isset($salesmaterialtype->_id) && $salesmaterialtype->_id) {
                    $data['price'] = $input['price'];
                    if($this->salesmaterialtype->where('sales_id', $input['sales_id'])->where('material_type_id', $input['material_type_id'])->update($data)){
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
                }else{
                    $this->salesmaterialtype->price = $input['price'];
                    $this->salesmaterialtype->sales_id = $input['sales_id'];
                    $this->salesmaterialtype->material_type_id = $input['material_type_id'];
                    if($this->salesmaterialtype->save()){
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
