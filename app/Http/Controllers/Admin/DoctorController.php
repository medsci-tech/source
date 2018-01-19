<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Area;
use App\Http\Model\Doctor;
use App\Http\Model\DoctorProtocol;
use App\Http\Model\Recommend;
use App\Http\Model\DoctorRecommend;
use App\Http\Model\Bigarea;
use App\Http\Model\Sales;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class DoctorController extends CommonController
{

    function __construct() {
        $this->doctor=new Doctor;
        $this->recommend=new Recommend;
        $this->doctorrecommend =new DoctorRecommend;
        $this->middleware('admin.login.admin');
    }

    public function index()
    {

        return view('admin.doctor');
    }



    public function recommendadd($doctor_id){
        $bigarea = Bigarea::where('status','1')->get();
        $sales = Sales::where('status','1')->get();
        return view('admin.recommendAdd',compact('bigarea','sales','doctor_id'));
    }

    public function ajax(){
        $input = Input::all();
        switch($input['action']){
            case 'getlist':
                $pagesize=5;
                $input = Input::all();
                $input['page']=($input['page']==0 || $input['page']>100) ? 1 :$input['page'];
                $result=$this->doctor->getDoctorList($pagesize,$input['page'],$input);
                if(count($result[1])>0) {
                	$list = $result[1];
                	foreach ($list as &$v){
                		if($v->getProtocol){
							$v['protocol_status'] = $v->getProtocol->check_status;
							$v['protocol_url'] = env('QN_Url').$v->getProtocol->file_url;
							$v['protocol_id'] = $v->getProtocol->_id;
						}else{
							$v['protocol_status'] = '-1';
							$v['protocol_url'] = '';
							$v['protocol_id'] = '';
						}
					}
                    $returnInfo=array(
                        'total_num' => $result[0],
                        'list' => $list,
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
            case 'docotrEdit':
                $input = Input::all();
                $this->doctor->doctor_name =$input['doctor_name'];
                $this->doctor->doctor_mobile =$input['doctor_mobile'];
                $this->doctor->password =$input['password'];
                $this->doctor->id_card =$input['id_card'];
                $this->doctor->province_id =$input['province_id'];
                $this->doctor->city_id =$input['city_id'];
                $this->doctor->region_id =$input['region_id'];
                $this->doctor->province_name =$input['province_name'];
                $this->doctor->city_name =$input['city_name'];
                $this->doctor->region_name =$input['region_name'];
                $this->doctor->hospital_name =$input['hospital_name'];
                $this->doctor->bank_name =$input['bank_name'];
                $this->doctor->bank_card_no =$input['bank_card_no'];
                if($input['id'] ==''){
                    if($this->doctor->save()){
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

                    $doctor=$this->doctor->where('doctor_mobile',$input['doctor_mobile'])->where('_id','!=',$input['id'])->first();
                    if(isset($doctor) && $doctor->_id) {
                        $returnInfo = array(
                            'status' => 0,
                            'msg' => '该手机号已经被其它用户占用!',
                        );
                        return response()->json($returnInfo);
                    }
                    $data['doctor_name'] =$input['doctor_name'];
                    $data['doctor_mobile'] =$input['doctor_mobile'];
                    $data['password'] =$input['password'];
                    $data['id_card'] =$input['id_card'];
                    $data['province_id'] =$input['province_id'];
                    $data['city_id'] =$input['city_id'];
                    $data['region_id'] =$input['region_id'];
                    $data['province_name'] =$input['province_name'];
                    $data['city_name'] =$input['city_name'];
                    $data['region_name'] =$input['region_name'];
                    $data['hospital_name'] =$input['hospital_name'];
                    $data['bank_name'] =$input['bank_name'];
                    $data['bank_card_no'] =$input['bank_card_no'];
                    if($this->doctor->where('_id',$input['id'])->update($data)){
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
            case 'getRecommend':
                $condition['doctor_id'] =$input['doctor_id'];
//                $condition['recommend_id'] =$input['recommend_id'];
                $doctorRecommend=DoctorRecommend::where($condition)->get();
                if(!(count($doctorRecommend)>0)){
                    $returnInfo=array(
                        'status' => 0,
                        'msg' => '没有推荐人!',
                    );
                    return response()->json($returnInfo);
                }
                foreach($doctorRecommend as $k=>$v){

                    $recommend=Recommend::where('_id',$v->recommend_id)->first();
                    $bigarea = BigArea::where('_id',$recommend->big_area_id)->first();
                    if($bigarea){
                        $doctorRecommend[$k]->big_area_name =$bigarea->big_area_name;
                    }else{
						$doctorRecommend[$k]->big_area_name = '';
					}
					$area = Area::where('_id',$recommend->area_id)->first();
					if($area){
						$doctorRecommend[$k]->area_name =$area->area_name;
                    }else{
						$doctorRecommend[$k]->area_name = '';
					}
                    $sales = Sales::where('_id',$recommend->sales_id)->first();
                    if($sales){
                        $doctorRecommend[$k]->sales_name =$sales['sales_name'];
                    }else{
						$doctorRecommend[$k]->sales_name = '';
					}
                    $doctorRecommend[$k]->recommend_name =$recommend->recommend_name;
                    $doctorRecommend[$k]->recommend_mobile =$recommend->recommend_mobile;

                }
                $returnInfo=array(
                    'list' =>$doctorRecommend,
                    'status' => 1,
                    'msg' => 'ok',
                );
                return response()->json($returnInfo);
                break;
            case 'addRecommend':
                $condition['recommend_mobile']=$input['recommend_mobile'];
                $condition['recommend_name']=$input['recommend_name'];
                $condition['big_area_id']=$input['big_area_id'];
                $condition['sales_id']=$input['sales_id'];
                $condition['recommend_id_card']=$input['recommend_id_card'];
                $result = $this->recommend->where($condition)->first();
                if(isset($result->recommend_name)){
                    $condition2['recommend_id']=$result->_id;
                    $condition2['doctor_id']=$input['doctor_id'];
                    $doctorrecommend = $this->doctorrecommend->where($condition2)->first();
                    if(isset($doctorrecommend->_id)) {
                        $returnInfo = array(
                            'status' => 0,
                            'msg' => '您已经添加过该推荐人了!',
                        );
                        return response()->json($returnInfo);
                    }
                }else{
                    $this->recommend->recommend_mobile=$input['recommend_mobile'];
                    $this->recommend->recommend_name=$input['recommend_name'];
                    $this->recommend->big_area_id=$input['big_area_id'];
                    $this->recommend->sales_id=$input['sales_id'];
                    $this->recommend->recommend_id_card=$input['recommend_id_card'];
                    $this->recommend->save();
                    $result = $this->recommend->where($condition)->first();
                }
                $this->doctorrecommend->doctor_id =$input['doctor_id'];
                $this->doctorrecommend->recommend_id =$result->_id;
                if($this->doctorrecommend->save()){
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
                return response()->json($returnInfo);
                break;

            case 'getRecommendInfo':
                $condition['recommend_mobile'] =$input['recommend_mobile'];
                $result=$this->recommend->where($condition)->first();
                if(isset($result->recommend_name)){
                    $returnInfo=array(
                        'data' => $result,
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

            case 'delRecommend':
                $condition['doctor_id'] =$input['doctor_id'];
                $condition['recommend_id'] =$input['recommend_id'];
                $result=DoctorRecommend::where($condition)->first();
                if($result->delete()){
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
			case 'checkProtocol':
				$protocol = DoctorProtocol::find($input['pid']);
				if(!$protocol){
					$returnInfo=array(
						'status' => 0,
						'msg' => '非法操作',
					);
					return response()->json($returnInfo);
				}
				$protocol->check_status = $input['status']?:'0';
				if($input['status'] == 2){
					$protocol->comment = $input['comment'];
				}
				$protocol->save();
				$returnInfo=array(
					'status' => 1,
					'msg' => '审核成功',
				);
				return response()->json($returnInfo);
        }

    }


}
