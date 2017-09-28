<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\User;
use App\Http\Model\Material;


use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class IndexController extends CommonController
{


    function __construct() {
        $this->material=new Material;
    }
    
    public function index()
    {
        $admin=session('admin');
        $username =$admin->user_name;
        return view('layouts.admin',compact('username'));
    }

    public function addMaterial()
    {
//        if($input = Input::all()) {
            $materrial = new Material;
            $materrial->doctor_name = 'zhanghui2';
            $materrial->doctor_moble = '15327377557';
            $materrial->material_name = '测试素材名称';
            $materrial->material_type_name = '视频';
            $materrial->attachments = 5; //附件个数
            $materrial->material_type_id = 1;

            $materrial->recommend_name = '测试推荐人';
            $materrial->recommend_mobile = '15327377666';
            $materrial->check_status = 0;//0:未审核,1:审核通过,2:审核未通过
            $materrial->pass_amont = 5;

            $materrial->pay_status = 0;//0:未支付,1:支付comments  Attachments
            $materrial->comment = '审核备注';

            $materrial->id_catd = '422202198908107052';
            $materrial->bank_name = '测试银行';
            $materrial->bank_card_name = '8888888888888888';
            $materrial->addtime = time();
            $materrial->save();die;
//        }else{
//            return view('admin.info');
//        }

    }














    //更改超级管理员密码
    public function pass()
    {
        if($input = Input::all()){

            $rules = [
                'password'=>'required|between:6,20|confirmed',
            ];

            $message = [
                'password.required'=>'新密码不能为空！',
                'password.between'=>'新密码必须在6-20位之间！',
                'password.confirmed'=>'新密码和确认密码不一致！',
            ];

            $validator = Validator::make($input,$rules,$message);

            if($validator->passes()){
                $user = User::first();
                $_password = Crypt::decrypt($user->user_pass);
                if($input['password_o']==$_password){
                    $user->user_pass = Crypt::encrypt($input['password']);
                    $user->update();
                    return back()->with('errors','密码修改成功！');
                }else{
                    return back()->with('errors','原密码错误！');
                }
            }else{
                return back()->withErrors($validator);
            }

        }else{
            return view('admin.pass');
        }
    }
}
