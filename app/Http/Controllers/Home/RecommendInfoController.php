<?php
/**
 * Created by ...
 * User: zhanghui
 * Date: 16/12/10
 * DesCription:...
 */


namespace App\Http\Controllers\Home;

use App\Http\Model\Doctor;
use App\Http\Model\Recommend;
use App\Http\Model\DoctorRecommend;
use App\Http\Model\Bigarea;
use App\Http\Model\Sales;
use App\Http\Model\Area;
use Illuminate\Support\Facades\Input;

class RecommendInfoController extends CommonController
{

    function __construct() {
        parent::__construct();
        $this->doctorrecommend=new DoctorRecommend;
        $this->recommend=new Recommend;
    }


    public function index()
    {


        $doctorrecommend=$this->doctorrecommend->where('doctor_id',$this->doctor_id)->get();
        foreach($doctorrecommend as $k=>$v){
            $recommend = $this->recommend->where('_id',$v->recommend_id)->first();
            $bigarea = Bigarea::where('_id',$recommend->big_area_id)->first();
            $area = Area::where('_id',$recommend->area_id)->first();
            $sales = Sales::where('_id',$recommend->sales_id)->first();
            $doctorrecommend[$k]->recommend_name =$recommend->recommend_name;
            $doctorrecommend[$k]->recommend_mobile =$recommend->recommend_mobile;
            $doctorrecommend[$k]->big_area_name =$bigarea->big_area_name;
            $doctorrecommend[$k]->area_name =$area?$area->area_name:'';
            $doctorrecommend[$k]->sales_name =$sales?$sales->sales_name:'';
        }

        return view('home.recommendinfo.index',compact('doctorrecommend'));
    }


    public function addRecommend(){
        $bigarea = Bigarea::where('status','1')->get();
        $area = Area::where('status','1')->get();
        $sales = Sales::where('status','1')->get();
        return view('home.recommendinfo.addRecommend',compact('bigarea','sales','area'));
    }



    public function ajax(){
        $input = Input::all();
        switch($input['action']){
            case 'getlist':
                $pagesize=8;
                $input = Input::all();
                $input['page']=($input['page']==0 || $input['page']>100) ? 1 :$input['page'];
//                $input['doctor_id'] =session('user')->_id;
//                $input['isshare'] = '0';
                $result=$this->material->getMaterialList($pagesize,$input['page'],$input);
                if(count($result[1])>0) {
                    foreach($result[1] as $k=>$v){
                        $materialtype = MaterialType::where('_id',$v->material_type_id)->first();
                        if($materialtype->material_type_name){
                            $result[1][$k]->material_type_name =$materialtype->material_type_name;
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
            case 'addRecommend':
                $condition['recommend_mobile']=$input['recommend_mobile'];
                $condition['recommend_name']=$input['recommend_name'];
                $condition['big_area_id']=$input['big_area_id'];
                $condition['sales_id']=$input['sales_id'];
                $condition['area_id']=$input['area_id'];
//                $condition['recommend_id_card']=$input['recommend_id_card'];
                $result = $this->recommend->where($condition)->first();
                if(isset($result->recommend_name)){
                    $condition2['recommend_id']=$result->_id;
                    $condition2['doctor_id']=$this->doctor_id;
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
                    $this->recommend->area_id=$input['area_id'];
//                    $this->recommend->recommend_id_card=$input['recommend_id_card'];
                    $this->recommend->save();
                    $result = $this->recommend->where($condition)->first();
                }
                $this->doctorrecommend->doctor_id =$this->doctor_id;
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
