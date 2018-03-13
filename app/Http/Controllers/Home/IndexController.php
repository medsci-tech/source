<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Doctor;
use App\Http\Model\DoctorProtocol;
use App\Http\Model\Recommend;
use App\Http\Model\DoctorRecommend;
use App\Http\Model\Bigarea;
use App\Http\Model\Area;
use App\Http\Model\Sales;
use App\Http\Model\Material;
use App\Http\Model\MaterialLenove;
use Illuminate\Support\Facades\Input;
use Log;
use Qiniu\Auth;

class IndexController extends CommonController
{
    function __construct() {
        parent::__construct();
        $this->doctor=new Doctor;
        $this->recommend=new Recommend;
        $this->doctorrecommend=new DoctorRecommend;
        $this->material=new Material;
        $this->materiallenove=new MaterialLenove;
    }

    public function index()
    {
        $user=session('user');
        return view('home.userfile.index',compact('user'));
    }


    public function agree()
    {
        return view('home.index.agree');
    }

    public function protocol()
    {
        return response()->download('uploads/MedSource_protocol.doc');
    }

    public  function register(){

//        $bigarea = Bigarea::where('status','1')->get();
        $bigarea = Bigarea::get();
        $area = Area::get();
        $sales = Sales::get();

		//用七牛云上传文件
//		$accessKey = env('QN_AccessKey');
//		$secretKey = env('QN_SecretKey');
//		$bucket = env('QN_Bucket');
//		$auth = new Auth($accessKey,$secretKey);
//		// 生成上传 Token
//		$token = $auth->uploadToken($bucket);
        return view('home.index.register',compact('bigarea','area','sales'));
    }



    public  function login(){

        if($input = Input::all()){
//            $code = new \Code;
//            $_code = $code->get();
//            if(strtoupper($input['code'])!=$_code){
//                return back()->with('msg','验证码错误！');
//            }
            $doctor = Doctor::where('doctor_mobile',trim($input['doctor_mobile']))->first();
            if(!$doctor || $doctor->password != trim($input['password'])){
                return back()->with('msg','用户名或者密码错误,请重新输入！');
            }
            session(['user'=>$doctor]);
            return redirect('home/userfile/index');

        }else {
            return view('home.index.login');
        }
    }



    public  function forget(){

        return view('home.index.forget');
    }



    public function ajax(){
        $input = Input::all();
        switch($input['action']){
			case 'checkPhoneExist':
				$result = $this->doctor->where('doctor_mobile',$input['doctor_mobile'])->first();
				if(isset($result->doctor_mobile)){
					$returnInfo=array(
						'status' => 0,
						'msg' => '该手机号码已注册!',
					);
				}else{
					$returnInfo=array(
						'status' => 1,
						'msg' => '该手机号码可用!',
					);
				}
				return response()->json($returnInfo);
            case 'addDoctor':
//              dd($input);
				$doctorInfo = $input['doc_data'];
                $this->doctor->doctor_name   = $doctorInfo['doctor_name'];
                $this->doctor->doctor_mobile = $doctorInfo['doctor_mobile'];
                $this->doctor->password      = $doctorInfo['password'];
                $this->doctor->id_card       = $doctorInfo['id_card'];
                $this->doctor->province_name = $doctorInfo['province_name'];
                $this->doctor->city_name     = $doctorInfo['city_name'];
                $this->doctor->region_name   = $doctorInfo['region_name'];
                $this->doctor->province_id   = $doctorInfo['province_id'];
                $this->doctor->city_id       = $doctorInfo['city_id'];
                $this->doctor->region_id     = $doctorInfo['region_id'];
                $this->doctor->hospital_name = $doctorInfo['hospital_name'];
                $this->doctor->bank_card_no  = $doctorInfo['bank_card_no'];
                $this->doctor->bank_name     = $doctorInfo['bank_name'];
                $this->doctor->protocol_check_status     = '0';//协议审核状态 0.未上传 1.待审核 2.通过 3.驳回

                if($this->doctor->save()){
					$docotr = $this->doctor->where('doctor_mobile',$doctorInfo['doctor_mobile'])->first();
					session(['user'=>$docotr]);
                	//如果上传了协议，保存文件
                	if(isset($doctorInfo['file'])){
						DoctorProtocol::create([
							'doctor_id'=>$docotr->_id,
							'file_url'=>$doctorInfo['file'],
							'file_name'=>$doctorInfo['filename'],
//							'check_status'=>'0' //协议审核状态 0.未上传 1.待审核 2.通过 3.驳回
						]);
					}

       //             $this->registerUserCenter($input);
                    $returnInfo=array(
                        'status' => 1,
                        'msg' => '恭喜您,注册成功!',
                    );
                }else{
                    $returnInfo=array(
                        'status' => 0,
                        'msg' => '注册失败!',
                    );
                }
                return response()->json($returnInfo);
                break;

            case 'getRecommendInfo':
                $condition['recommend_mobile'] =$input['recommend_mobile'];
                $result=$this->recommend->where($condition)->first();
                if(isset($result->recommend_name)){
                    $area = Area::where('_id',$result->area_id)->first();
                    $sales = Sales::where('_id',$result->sales_id)->first();
                    $result->area_name =$area->area_name;
                    $result->sales_name =$sales->sales_name;
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

            case 'resetPassword':
                $condition['doctor_mobile'] =$input['doctor_mobile'];
                $condition['id_card'] =$input['id_card'];
                $doctor=$this->doctor->where($condition)->first();
                if(isset($doctor->doctor_name)){
                    $doctor->password =$input['repPassword'];
                    if($doctor->save()){
                        $returnInfo=array(
                            'status' => 1,
                            'msg' => '找回密码成功!',
                        );
                    }else{
                        $returnInfo=array(
                            'status' => 1,
                            'msg' => '服务器繁忙,请稍后再试!',
                        );
                    }
                }else{
                    $returnInfo=array(
                        'status' => 0,
                        'msg' => '身份验证失败!',
                    );
                }
                return response()->json($returnInfo);
                break;
            case 'getArea':
                $condition['big_area_id'] =$input['big_area_id'];
                $area=Area::where($condition)->get();
                $returnInfo=array(
                    'data'=>$area,
                    'status' => 1,
                    'msg' => 'ok!',
                );
                return response()->json($returnInfo);
                break;
            case 'getSales':
                $condition['area_id'] =$input['area_id'];
                $sales=Sales::where($condition)->get();
                $returnInfo=array(
                    'data'=>$sales,
                    'status' => 1,
                    'msg' => 'ok!',
                );
                return response()->json($returnInfo);
                break;
        }




    }

    public function quit()
    {
        session(['user'=>null]);
        return redirect('login');
    }


    public function callBackMaterial(){



        $input = Input::all();
        //file_get_contents('lenove.txt',var_export($input,true),8);
        //Log::debug($input);

        $params=explode('@',urldecode($input['command']));
//        Log::info($params);
        $condition['upload_code'] =$params[5];
        $material=$this->material->where($condition)->first();
        if(isset($material) && $material->_id) {

        }else{
            //素材类型
            $this->material->material_type_id = $params[0];
            //素材名称
            $this->material->material_name = $params[1];
            //公司附件数量
            $this->material->attachments = $params[2];
            //推荐人id
            $this->material->recommend_id = $params[3];
            //医生id
            $this->material->doctor_id = $params[4];

            $this->material->upload_code = $params[5];

            $this->material->isshare = '0';
            $this->material->check_status = '0';
            $this->material->pay_status = '0';
            $this->material->pay_amount = '0';
            $this->material->pass_amount = '0';
            $this->material->comment = '暂无';
            //添加时间
            $this->material->addtime = (string)time();
            $this->material->save();
        }
        //素材地址 素材信息
        $data =json_decode($input['data']);
        $file =json_decode($input['file']);
//        Log::info($input);
//        Log::info($params);
//        Log::info($data);

        $this->materiallenove->doctor_id = $params[4];
        $this->materiallenove->upload_code = $params[5];
        $this->materiallenove->material_url = $data->path;
        $this->materiallenove->path_type = $data->path_type;
        $this->materiallenove->from = $data->from;
        $this->materiallenove->neid = $data->neid;
        $this->materiallenove->rev = $data->rev;
        $this->materiallenove->filename = $file->name;
        //添加时间
        $this->materiallenove->addtime = (string)time();
        $this->materiallenove->save();
        echo  1;
    }



    public function callBackTools(){



    }

    public function test(){
        return phpinfo();
    }


}
