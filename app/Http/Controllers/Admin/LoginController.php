<?php

namespace App\Http\Controllers\Admin;
use App\Http\Model\User;
use App\Http\Model\Material_type;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;

require_once 'resources/org/code/Code.class.php';

class LoginController extends CommonController
{
    function __construct() {
//        $this->doctor=new Doctor;
    }

//Request $request
    public function login(Request $request)
    {

        if(session('admin')){
            return redirect('admin/index');
        }
        if($request->isMethod('post')){
            $input = Input::all();
            $code = new \Code;
            $_code = $code->get();
            if(strtoupper($input['code'])!=$_code){
                return back()->with('msg','验证码错误！');
            }
            $user = User::where('user_name',trim($input['user_name']))->first();

            if(!$user || $user->user_pass != md5(trim($input['user_pass']))){
                return back()->with('msg','用户名或者密码错误！');
            }
            session(['admin'=>$user]);
            return redirect('admin/index');

        }else {

            return view('admin.login');
        }
    }

    public function quit()
    {
        session(['admin'=>null]);
        return redirect('admin/login');
    }

    public function code()
    {
        $code = new \Code;
        $code->make();
    }

}
