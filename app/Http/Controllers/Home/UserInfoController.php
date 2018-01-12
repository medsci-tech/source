<?php
/**
 * Created by ...
 * User: zhanghui
 * Date: 16/12/10
 * DesCription:...
 */


namespace App\Http\Controllers\Home;

use App\Http\Model\Doctor;
use App\Http\Model\DoctorProtocol;
use App\Http\Model\Questions;
use Illuminate\Support\Facades\Input;
use Qiniu\Auth;


class UserInfoController extends CommonController
{

    function __construct() {
        parent::__construct();
        $this->doctor=new Doctor;
    }

    public function index()
    {

        $doctor = Doctor::where('doctor_mobile',session('user')->doctor_mobile)->first();
        $doctorProtocol = DoctorProtocol::where('doctor_id',$doctor->_id)->first();
        if($doctorProtocol){
			$doctor->have_protocol = 1;
		}else{
			$doctor->have_protocol = 0;
		}
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
				$protocol = DoctorProtocol::where('doctor_id',$this->doctor->_id)->first();
				if($protocol){
					$protocol->file_url = $doctorInfo['file'];
					$protocol->file_name = $doctorInfo['file_name'];
					$protocol->check_status = '0';
					$res = $protocol->save();
				}else{
					$res = DoctorProtocol::create([
						'doctor_id'=>$this->doctor->_id,
						'file_url'=>$doctorInfo['file'],
						'file_name'=>$doctorInfo['filename'],
						'check_status'=>'0' //审核状态 0.未审核 1.通过 2.驳回
					]);
				}
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

}