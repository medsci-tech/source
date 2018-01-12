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
use Illuminate\Support\Facades\Input;

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


	public  function downloadSource(Request $request,$material_url){
    	$material = MaterialLenove::find($material_url);
//		dd(($material));
		$filename=env('QN_Url').$material->material_url;
		$file  =  fopen($filename, "rb");
		$name = $material->filename;
		Header( "Content-type:  application/octet-stream ");
		Header( "Accept-Ranges:  bytes ");
		Header( "Content-Disposition:  attachment;  filename= {$name}");
		$contents = "";
		while (!feof($file)) {
			$contents .= fread($file, 8192);
		}
		echo $contents;
		fclose($file);
		exit;
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
                //dd($result);
//                $lenovo=$this->getLenovoInfo();
                if(count($result[1])>0) {
                    foreach($result[1] as $k=>$v){
                        $doctor = Doctor::where('_id',$v->doctor_id)->first();
                        if(isset($doctor->doctor_name) && $doctor->doctor_name){
                            $result[1][$k]->doctor_name =$doctor->doctor_name;
                        }else{
							$result[1][$k]->doctor_name = '';
						}
                        if(isset($doctor->doctor_mobile) && $doctor->doctor_mobile){
                            $result[1][$k]->doctor_mobile =$doctor->doctor_mobile;
                        }else{
							$result[1][$k]->doctor_mobile = '';
						}
                        $materialtype = MaterialType::where('_id',$v->material_type_id)->first();

                        if(isset($materialtype->material_type_name) && $materialtype->material_type_name){
                            $result[1][$k]->material_type_name =$materialtype->material_type_name;
                        }else{
							$result[1][$k]->material_type_name = '';
						}
                        $recommend = Recommend::where('_id',$v->recommend_id)->first();
                        $bigarea = Bigarea::where('_id',$recommend->big_area_id)->first();
                        $area = Area::where('_id',$recommend->area_id)->first();
                        $sales = Sales::where('_id',$recommend->sales_id)->first();
                        $result[1][$k]->recommend_name = $recommend->recommend_name;
                        $result[1][$k]->recommend_mobile = $recommend->recommend_mobile;
//                        $SalesMaterialType = SalesMaterialType::where('sales_id',$recommend->sales_id)->where('material_type_id',$v->material_type_id)->first();
                        if(isset($bigarea->big_area_name)){
                            $result[1][$k]->big_area_name =$bigarea->big_area_name."({$bigarea->unit})";
                        }else{
							$result[1][$k]->big_area_name = '';
						}
                        if(isset($area->area_name) && $area->area_name){
                            $result[1][$k]->area_name =$area->area_name;
                        }else{
                            $result[1][$k]->area_name = '';
                        }
                        if(isset($sales->sales_name) &&$sales->sales_name){
                            $result[1][$k]->sales_name =$sales->sales_name;
                        }else{
							$result[1][$k]->sales_name = '';
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
				$data['comment']=$input['comment']?:'';

                $material = Material::where('_id',$input['id'])->first();
                $recommend = Recommend::where('_id',$material->recommend_id)->first();

                 //查询销售组自定义的价格，如果不存在，使用素材类型默认价格
                $SalesMaterialType = SalesMaterialType::where('sales_id',$recommend->sales_id)->where('material_type_id',$material->material_type_id)->first();
                if(isset($SalesMaterialType) && $SalesMaterialType->_id){
                    $data['pay_amount']=$SalesMaterialType->price * $data['pass_amount'];
                }else{
					$data['pay_amount'] = MaterialType::where('_id',$material->material_type_id)->first()->price * $data['pass_amount'];
                    /*$returnInfo=array(
                        'status' => 0,
                        'msg' => '该销售组该类型的素材未填写价格,请先填写价格!',
                    );
                    return response()->json($returnInfo);*/

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
            	// 单个支付
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
			case 'option_all':
				$lists = $input['option_data'];//所有要更新记录的id
				if($input['option'] === 'confirm_check'){//通过
					foreach ($lists as $list){
						$material = Material::where('_id',$list)->first();
						$recommend = Recommend::where('_id',$material->recommend_id)->first();
						//查询销售组自定义的价格，如果不存在，使用素材类型默认价格
						$SalesMaterialType = SalesMaterialType::where('sales_id',$recommend->sales_id)->where('material_type_id',$material->material_type_id)->first();
						if(isset($SalesMaterialType) && $SalesMaterialType->_id){
							$pay_amount =$SalesMaterialType->price * $material->attachments;
						}else{
							$pay_amount = MaterialType::where('_id',$material->material_type_id)->first()->price * $material->attachments;
						}
						Material::where('_id',$list)->update( ['check_status'=>'1','pass_amount'=>$material->attachments,'pay_amount'=>$pay_amount]); //返回更新的记录数
					}
				}elseif($input['option'] === 'pay_all'){//支付
					//查看是否有未通过审核的数据
					$check = Material::whereIn('_id',$lists)->where('check_status','<>','1')->first();
					if($check){
						return response()->json(['status'=>0,'msg'=>'操作失败，请检查所选数据是否已经通过审核']);
					}
					Material::whereIn('_id',$lists)->update(['pay_status'=>'1']);
				}
				return response()->json(['status'=>1,'msg'=>'操作成功']);
            case 'getuploadurllist':
            	//获取素材下载列表
                $condition['doctor_id']=$input['doctor_id'];
                $condition['upload_code']=$input['upload_code'];
                $materiallenove = MaterialLenove::where($condition)->get();
                if(count($materiallenove)>0){
                    $lenovo=$this->getLenovoInfo();
                    foreach($materiallenove as $k=>$v){
                    	if($v->path_type == 'QN'){
//                    		$downloadUrl = url("admin/material/downloadSource",$v->_id);
//							$result[$k]['url'] = $downloadUrl;
							$result[$k]['url'] = env('QN_Url').$v->material_url;
						}else{
							$result[$k]['url']="https://content.box.lenovo.com/v2/files/databox/".$v->path."?X-LENOVO-SESS-ID=".$lenovo->{"X-LENOVO-SESS-ID"}."&path_type=".$v->path_type."&from=&neid=".$v->neid."&rev=".$v->rev."";
						}
                        $result[$k]['filename']=$v->filename;
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
            $total = 0;
            $resArr =[];
            foreach ($arr as $key=>$val){
                if($key==0) continue;
                //echo $key,$val[2];
                $id = Doctor::where('doctor_mobile',$val[2])->pluck('_id');
                //dd($id);
                $matrial = Material::where(['doctor_id'=>$id[0],'addtime'=>(string)strtotime($val[3])])->first();
//                dd($matrial);
                $matrial->pay_amount = intval($val[9]);
                $matrial->pay_status = 1;
                if(!$matrial->save()){
                    $num++;
                    $resArr[] = $matrial->_id;
                };

                $total++;
            }
            echo '总数：'.$total.'失败总数：',$num;
            dd( $resArr);
        }
        return view('admin.importExcel');
    }
}
