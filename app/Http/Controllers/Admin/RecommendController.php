<?php

namespace App\Http\Controllers\Admin;
use App\Http\Model\Recommend;

use App\Http\Model\User;
use App\Http\Model\Bigarea;
use App\Http\Model\Sales;
use App\Http\Model\Area;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class RecommendController extends CommonController
{
    function __construct() {
        $this->recommend=new Recommend;
        $this->middleware('admin.login.admin');
    }

    public function index()
    {
        $bigarea = Bigarea::where('status','1')->get();
        $area = Area::where('status','1')->get();
        $sales = Sales::where('status','1')->get();
        return view('admin.recommend',compact('bigarea','area','sales'));
    }


    public function ajax(){
        $input = Input::all();
        switch($input['action']){
            case 'getlist':
                $pagesize=8;
                $input = Input::all();
                $input['page']=($input['page']==0 || $input['page']>100) ? 1 :$input['page'];
                $result=$this->recommend->getRecommendList($pagesize,$input['page'],$input);
                if(count($result[1])>0) {
                    foreach($result[1] as $k=>$v){
                        $bigarea = Bigarea::where('_id',$v->big_area_id)->first();
                        $area = Area::where('_id',$v->area_id)->first();
                        $sales = Sales::where('_id',$v->sales_id)->first();
                        if($bigarea->big_area_name){
                            $result[1][$k]->big_area_name =$bigarea->big_area_name;
                        }
                        if(isset($area->area_name) && $area->area_name){
                            $result[1][$k]->area_name =$area->area_name;
                        }else{
                            $result[1][$k]->area_name = '暂无';
                        }
                        if($sales!=null && $sales->sales_name){
                            $result[1][$k]->sales_name =$sales->sales_name;
                        }
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
            case 'getRecommendInfo':
                $recommend=$this->recommend->where('_id',$input['recommend_id'])->first();
                if($recommend->recommend_name){
                    $returnInfo=array(
                        'list'=>$recommend,
                        'status' => 1,
                        'msg' => 'ok',
                    );
                }else{
                    $returnInfo=array(
                        'status' => 0,
                        'msg' => '没有查询到数据!',
                    );
                }
                return response()->json($returnInfo);
                break;

            case 'updateRecommend':
                if($input['recommend_id'] =='') {
                    $this->recommend->recommend_name =$input['recommend_name'];
                    $this->recommend->recommend_mobile =$input['recommend_mobile'];
                    $this->recommend->big_area_id =$input['big_area_id'];
                    $this->recommend->area_id =$input['area_id'];
                    $this->recommend->sales_id =$input['sales_id'];
                    $this->recommend->recommend_id_card =$input['recommend_id_card'];
                    $this->recommend->addtime =(string)time();
                        if($this->recommend->save()){
                            $returnInfo=array(
                                'status' => 1,
                                'msg' => '添加成功!',
                            );
                        }else {
                            $returnInfo = array(
                                'status' => 0,
                                'msg' => '添加失败!',
                            );
                        }

                }else{
                    $data['recommend_name'] = $input['recommend_name'];
                    $data['recommend_mobile'] = $input['recommend_mobile'];
                    $data['big_area_id'] = $input['big_area_id'];
                    $data['area_id'] = $input['area_id'];
                    $data['sales_id'] = $input['sales_id'];
                    $data['recommend_id_card'] = $input['recommend_id_card'];
                    if ($this->recommend->where('_id', $input['recommend_id'])->update($data)) {
                        $returnInfo = array(
                            'status' => 1,
                            'msg' => '编辑成功!',
                        );
                    } else {
                        $returnInfo = array(
                            'status' => 0,
                            'msg' => '编辑失败!',
                        );
                    }
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


}
