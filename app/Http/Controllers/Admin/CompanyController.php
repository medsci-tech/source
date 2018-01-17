<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Model\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index(){
        $company = Company::paginate(10);
//        dd($questions);
        return view('admin/company',['company'=>$company]);
    }

    public function saveinfo(Request $request){
        if(!empty($request->id)){
			$company = Company::find($request->id);
//            dd($question);
        }else{
			$company = new Company();
        }

        if($request->isMethod('post')){

            $this->validate($request,[
                'full_name'=>'required',
                'short_name'=>'required',
            ],[
                'full_name.required'=>'请填写公司名称',
                'short_name.required'=>'请填写公司简称',
            ]);

			$company->full_name =$request->full_name;
			$company->short_name =$request->short_name;
//			$company->status =$request->status;
            if($company->save()){
                return response()->json(['status'=>1,'msg'=>'操作成功']);
            }else{
				return response()->json(['status'=>0,'msg'=>'操作失败']);
            };
        }
    }
}
