<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Company;
use App\Http\Model\Sales;
use App\Http\Model\Bigarea;
use App\Http\Model\Area;
use App\Http\Model\SalesMaterialType;
use App\Http\Model\MaterialType;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
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
        $company = Company::get();
//        $area = Area::where('status','1')->get();
        $materialType = materialType::where('status','1')->get();
        return view('admin.sales',compact('company','materialType'));
    }


    public function ajax(){
        $input = Input::all();
        switch($input['action']){
            case 'getlist':
                $pagesize=8;
                $input['page']=($input['page']==0 || $input['page']>100) ? 1 :$input['page'];
                $result=$this->sales->getSalesList($pagesize,$input['page'],$input);
                if(count($result[1])>0) {
                    foreach($result[1] as $k=>$v) {
                        $company = Company::where('_id', $v->company_id)->first();
                        $bigarea = Bigarea::where('_id', $v->big_area_id)->first();
                        $area = Area::where('_id', $v->area_id)->first();
                        if ($company) {
                            $result[1][$k]->company_name = $company['full_name'];
                        }else {
                            $result[1][$k]->company_name = '';
                        }
                        if ($bigarea) {
                            $result[1][$k]->big_area_name = $bigarea['big_area_name'];
                        }else {
                            $result[1][$k]->big_area_name = '';
                        }
                        if ($area) {
                            $result[1][$k]->area_name = $area['area_name'];
                        } else {
                            $result[1][$k]->area_name = '';
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
                $this->sales->company_id =$input['company_id'];
                $this->sales->big_area_id =$input['big_area_id'];
                $this->sales->area_id =$input['area_id'];
                $this->sales->sales_name =$input['sales_name'];
                $this->sales->status =$input['status'];
                $this->sales->addtime =(string)time();
                if($input['sales_id'] ==''){
                    if($this->sales->save()){
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
					$this->sales->company_id =$input['company_id'];
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
			case 'getBigArea':
				$company_id = $input['id'];
				$bigarea = Bigarea::where(['status'=>'1','company_id'=>$company_id])->select('_id','big_area_name')->get();
				return response()->json($bigarea);
			case 'getArea':
				$id = $input['id'];
				$area = Area::where(['status'=>'1','big_area_id'=>$id])->select('_id','area_name')->get();
				return response()->json($area);
			case 'getSales':
				$id = $input['id'];
				$sales = Sales::where(['status'=>'1','area_id'=>$id])->select('_id','sales_name')->get();
				return response()->json($sales);
        }

    }


}
