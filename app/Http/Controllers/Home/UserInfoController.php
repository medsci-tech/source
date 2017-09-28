<?php
/**
 * Created by ...
 * User: zhanghui
 * Date: 16/12/10
 * DesCription:...
 */


namespace App\Http\Controllers\Home;

use App\Http\Model\Doctor;
use Illuminate\Support\Facades\Input;


class UserInfoController extends CommonController
{

    function __construct() {
        parent::__construct();
        $this->doctor=new Doctor;
    }

    public function index()
    {

        $doctor = Doctor::where('doctor_mobile',session('user')->doctor_mobile)->first();
        return view('home.userinfo.index',compact('doctor'));
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
        }




    }


}