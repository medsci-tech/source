<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Doctor;
use App\Http\Model\DoctorProtocol;
use App\Http\Model\Questions;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use Qiniu\Auth;
use Qcloud\Cos\Client;

class UserInfoController extends CommonController
{

    function __construct() {
        parent::__construct();
        $this->doctor=new Doctor;
    }

    public function index()
    {

        $doctor = Doctor::where('doctor_mobile',session('user')->doctor_mobile)->first();
        $doctorProtocol = DoctorProtocol::where('doctor_id',$doctor->_id)->first();//dd($doctorProtocol);
        /*if($doctorProtocol){
			$doctor->have_protocol = 1;
		}else{
			$doctor->have_protocol = 0;
		}*/
//		dd($doctor);
        return view('home.userinfo.index',compact('doctor','doctorProtocol'));
    }


    public function edit(){
		$doctor = Doctor::where('doctor_mobile',session('user')->doctor_mobile)->first();
        return view('home.userinfo.edit',compact('doctor'));
    }

    public function modifyPassword(){

        return view('home.userinfo.modifyPassword');
    }


    public function ajax(){
        $input = Input::all();
        switch($input['action']){
            case 'updateUserInfo':
                $data['doctor_name']=$input['doctor_name'];
                $data['id_card']=$input['id_card'];
                $data['province_name']=$input['province_name'];
                $data['city_name']=$input['city_name'];
                $data['region_name']=$input['region_name'];
                $data['province_id']=$input['province_id'];
                $data['city_id']=$input['city_id'];
                $data['region_id']=$input['region_id'];
                $data['hospital_name']=$input['hospital_name'];
                $data['bank_card_no']=$input['bank_card_no'];
                $data['bank_name']=$input['bank_name'];
                if($this->doctor->where('doctor_mobile',session('user')->doctor_mobile)->update($data)){
                    $returnInfo=array(
                        'status' => 1,
                        'msg' => 'ok',
                    );
                }else{
                    $returnInfo=array(
                        'status' => 0,
                        'msg' => 'error',
                    );
                }
                return response()->json($returnInfo);
                break;

            case 'modifyPassword':
                $input = Input::all();
                if(session('user')->password != trim($input['oldPassword'])){
                    $returnInfo=array(
                        'status' => 0,
                        'msg' => '您输入的原密码错误,请重新输入!',
                    );
                }
                if($this->doctor->where('doctor_mobile',session('user')->doctor_mobile)->update(array('password'=>trim($input['repPassword'])))){
                    $returnInfo=array(
                        'status' => 1,
                        'msg' => 'ok',
                    );
                }else{
                    $returnInfo=array(
                        'status' => 0,
                        'msg' => '密码修改失败,请稍后再试!',
                    );
                }
                return response()->json($returnInfo);
                break;

			case 'addProtocol':
				$doctorInfo = $input['doc_data'];
				$protocol = DoctorProtocol::where('doctor_id',$this->doctor_id)->first();
				if($protocol){//重新上传，更新数据
					$protocol->file_url = $doctorInfo['file'];
					$protocol->file_name = $doctorInfo['filename'];
//					$protocol->check_status = '0';
					$res = $protocol->save();

				}else{
					$res = DoctorProtocol::create([
						'doctor_id'=>$this->doctor_id,
						'file_url'=>$doctorInfo['file'],
						'file_name'=>$doctorInfo['filename'],
//						'check_status'=>'1' //协议审核状态 0.未上传 1.待审核 2.通过 3.驳回
					]);
				}
				$doctor = Doctor::find($this->doctor_id);
				$doctor->protocol_check_status='1';
				$doctor->save();
				if(!$res){
					$returnInfo=array(
						'status' => 0,
						'msg' => '文件保存失败',
					);
				}else{
					$returnInfo=array(
						'status' => 1,
						'msg' => '文件保存成功',
					);
				}
				return response()->json($returnInfo);

        }
    }

    public function questions(){
        $questions = Questions::where('is_show','1')->get();
//        dd($questions);
        return view('home/userinfo/questions',['questions'=>$questions]);
    }

	/**
	 * 七牛云上传
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
    public function uploadProtocol(){
		//用七牛云上传文件
		$accessKey = env('QN_AccessKey');
		$secretKey = env('QN_SecretKey');
		$bucket = env('QN_Bucket');
		$auth = new Auth($accessKey,$secretKey);
		// 生成上传 Token
		$token = $auth->uploadToken($bucket);

		return view('home/userinfo/protocol',compact('token'));
	}


	/**
	 * 腾讯云上传
	 *
	 */
	public function qcloudUpload(Request $request){
		$cosClient = new Client([
			'region'=>env('COS_REGION'),
			'credentials'=>[
				'secretId'=>env('COS_KEY'),
				'secretKey'=>env('COS_SECRET')
			]
		]);
		try {
			$result = $cosClient->putObject(array(
				//bucket的命名规则为{name}-{appid} ，此处填写的存储桶名称必须为此格式
				'Bucket' => env('COS_BUCKET'),
				'Key' => '11',
				'Body' => 'Hello World!'));
			print_r($result);
		} catch (\Exception $e) {
			echo "$e\n";
		}

	}
}