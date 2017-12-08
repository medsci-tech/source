<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Material;
use App\Http\Model\Doctor;
use App\Http\Model\MaterialType;
use App\Http\Model\Recommend;
use App\Http\Model\Bigarea;
use App\Http\Model\Area;
use App\Http\Model\Sales;
use App\Http\Model\SalesMaterialType;
use App\Http\Model\MaterialLenove;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class MaterialController extends CommonController
{
    function __construct() {
        $this->material=new Material;
    }

    public function index()
    {
        $admin=session('admin');
        $username =$admin->user_name;
        $materialType = materialType::where('status','1')->get();
        return view('admin.material',compact('materialType','username'));
    }


    public  function downloadFile($material_id){

        $material = Material::where('_id',$material_id)->first();
        if(isset($material->_id )){
            return response()->download($material->material_url);
        }else{
            exit('服务器繁忙!');
        }

    }


    public function ajax(){
        $input = Input::all();
        switch($input['action']){
            case 'getlist':
                $pagesize=10;
                $input = Input::all();
                //$input['page']=($input['page']==0 || $input['page']>100) ? 1 :$input['page'];
                $input['page']=$input['page']==0 ? 1 :$input['page'];
                $result=$this->material->getMaterialList($pagesize,$input['page'],$input);
//                $lenovo=$this->getLenovoInfo();
                if(count($result[1])>0) {
                    foreach($result[1] as $k=>$v){
                        $doctor = Doctor::where('_id',$v->doctor_id)->first();
                        if(isset($doctor->doctor_name) && $doctor->doctor_name){
                            $result[1][$k]->doctor_name =$doctor->doctor_name;
                        }
                        if(isset($doctor->doctor_mobile) && $doctor->doctor_mobile){
                            $result[1][$k]->doctor_mobile =$doctor->doctor_mobile;
                        }
                        $materialtype = MaterialType::where('_id',$v->material_type_id)->first();

                        if(isset($materialtype->material_type_name) && $materialtype->material_type_name){
                            $result[1][$k]->material_type_name =$materialtype->material_type_name;
                        }
                        $recommend = Recommend::where('_id',$v->recommend_id)->first();
                        $bigarea = Bigarea::where('_id',$recommend->big_area_id)->first();
                        $area = Area::where('_id',$recommend->area_id)->first();
                        $sales = Sales::where('_id',$recommend->sales_id)->first();
                        $result[1][$k]->recommend_name = $recommend->recommend_name;
                        $result[1][$k]->recommend_mobile = $recommend->recommend_mobile;
//                        $SalesMaterialType = SalesMaterialType::where('sales_id',$recommend->sales_id)->where('material_type_id',$v->material_type_id)->first();
                        if(isset($bigarea->big_area_name)){
                            $result[1][$k]->big_area_name =$bigarea->big_area_name;
                        }
                        if(isset($area->area_name) && $area->area_name){
                            $result[1][$k]->area_name =$area->area_name;
                        }else{
                            $result[1][$k]->area_name = '暂无';
                        }
                        if(isset($sales->sales_name) &&$sales->sales_name){
                            $result[1][$k]->sales_name =$sales->sales_name;
                        }
                        $result[1][$k]->price =$v->pay_amount;
//                        if($SalesMaterialType->price){
//                            $result[1][$k]->price =$SalesMaterialType->price;
//                        }

//                        $result[1][$k]['lenovoUrl']="https://content.box.lenovo.com/v2/files/databox/".$v->path."?X-LENOVO-SESS-ID=".$lenovo->{"X-LENOVO-SESS-ID"}."&path_type=".$v->path_type."&from=&neid=".$v->neid."&rev=".$v->rev."";

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
            case 'check':
                $data['check_status']=$input['check_status'];
                $data['pass_amount']=$input['pass_amount'];
                if($input['comment']){
                    $data['comment']=$input['comment'];
                }
                $material = Material::where('_id',$input['id'])->first();
                $recommend = Recommend::where('_id',$material->recommend_id)->first();
                $SalesMaterialType = SalesMaterialType::where('sales_id',$recommend->sales_id)->where('material_type_id',$material->material_type_id)->first();
                if(isset($SalesMaterialType) && $SalesMaterialType->_id){
                    $data['pay_amount']=$SalesMaterialType->price;
                }else{
                    $returnInfo=array(
                        'status' => 0,
                        'msg' => '该销售组该类型的素材未填写价格,请先填写价格!',
                    );
                    return response()->json($returnInfo);

                }
                if($this->material->where('_id',$input['id'])->update($data)){
                    $returnInfo=array(
                        'status' => 1,
                        'msg' => '审核成功!',
                    );
                }else{
                    $returnInfo=array(
                        'status' => 0,
                        'msg' => '审核失败!',
                    );
                }
                return response()->json($returnInfo);
                break;
            case 'pay':
                $material = Material::where('_id',$input['id'])->first();
                if(isset($material->_id) && ($material->check_status==0)){
                    $returnInfo=array(
                        'status' => 0,
                        'msg' => '审核通过才能支付,请先审核!',
                    );
                    return response()->json($returnInfo);
                }elseif(isset($material->_id) && ($material->check_status==1)){


                }else{
                    $returnInfo=array(
                        'status' => 0,
                        'msg' => '非法的操作!',
                    );
                    return response()->json($returnInfo);
                }
                $data['pay_status'] =$input['pay_status'];
                if($input['pay_amount'] || $input['pay_amount'] ==0) {
                    $data['pay_amount'] = $input['pay_amount'];
                }
                if($data['pay_status'] ==1)
                $data['pay_time'] =(string)time();
                else
                    $data['pay_time'] ='0';
                if($this->material->where('_id',$input['id'])->update($data)){
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
                return response()->json($returnInfo);
                break;
            case 'delete':

                if($this->material->destroy($input['id'])){
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
            case 'getuploadurllist':
                $condition['doctor_id']=$input['doctor_id'];
                $condition['upload_code']=$input['upload_code'];
                $materiallenove = MaterialLenove::where($condition)->get();
                if(count($materiallenove)>0){
                    $lenovo=$this->getLenovoInfo();
                    foreach($materiallenove as $k=>$v){
                        $result[$k]['filename']=$v->filename;
                        $result[$k]['lenovoUrl']="https://content.box.lenovo.com/v2/files/databox/".$v->path."?X-LENOVO-SESS-ID=".$lenovo->{"X-LENOVO-SESS-ID"}."&path_type=".$v->path_type."&from=&neid=".$v->neid."&rev=".$v->rev."";
                    }
                    $returnInfo=array(
                        'list' => $result,
                        'status' => 1,
                        'msg' => '操作成功!',
                    );

                }else{
                    $returnInfo=array(
                        'status' => 0,
                        'msg' => '操作失败!',
                    );
                }
                return response()->json($returnInfo);
                break;
        }

    }


    public function importExcel(Request $request){
        if($request->isMethod('post')){
            //dd($request->file('excel'));
            $file = $request->file('excel');
            $arr = [];
            \Excel::load($file->getRealPath(),function($read) use (&$arr){
                $res = $read->getSheet(0);
                $arr = $res->toArray();
            });
//            dd($arr);
            $num = 0;
            $resArr =[];
            foreach ($arr as $key=>$val){
                if($key==0) continue;
                $id = Doctor::where('doctor_mobile',$val[2])->pluck('_id');
//                dd($id);
                $matrial = Material::where(['doctor_id'=>$id[0],'addtime'=>(string)strtotime($val[3])])->first();
//                dd($matrial);
                $matrial->pay_amount = intval($val[9]);
                $matrial->pay_status = 1;
                if(!$matrial->save()){
                    $num++;
                    $resArr[] = $matrial->_id;
                };
                echo '失败总数：',$num;
                dd( $resArr);
            }
        }
        return view('admin.importExcel');
    }
}
