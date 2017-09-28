<?php
/**
 * Created by ...
 * User: zhanghui
 * Date: 16/12/10
 * DesCription:...
 */


namespace App\Http\Controllers\Home;

use App\Http\Model\Material;
use App\Http\Model\MaterialType;
use App\Http\Model\Recommend;
use App\Http\Model\Bigarea;
use App\Http\Model\DoctorRecommend;
use App\Http\Model\MaterialLenove;

use Illuminate\Support\Facades\Input;
class UserFileController extends CommonController
{

    function __construct() {
        parent::__construct();
        $this->material=new Material;
    }

    public function index(){

        $materialType = MaterialType::get();
        return view('home.userfile.index',compact('materialType'));

    }

    public  function  addMaterial(){
        $msg='';
        if($input = Input::all()) {
            //素材类型
            $this->material->material_type_id = $input['material_type_id'];
            //素材名称
            $this->material->material_name = $input['material_name'];
            //公司附件数量
            $this->material->attachments = $input['attachments'];
            //推荐人id
            $this->material->recommend_id = $input['recommend_id'];
            //素材地址
            $this->material->material_url = $this->upload();
            //医生id
            $this->material->doctor_id = $this->doctor_id;

            $this->material->isshare = '0';
            $this->material->check_status = '0';
            $this->material->pay_status = '0';
            $this->material->pass_amount = '0';
            $this->material->comment = '暂无';
            //添加时间
            $this->material->addtime = (string)time();
            if($this->material->save()){
                $msg='发布成功!';
            }else{
                $msg='发布失败!';
            }

        }
        $doctorrecommend = DoctorRecommend::where('doctor_id',$this->doctor_id)->get();
        foreach($doctorrecommend as $k=>$v){
            $recommend = Recommend::where('_id',$v->recommend_id)->first();
            $doctorrecommend[$k]->recommend_name =$recommend->recommend_name;
        }
        $materialType = MaterialType::where('status','1')->get();
        $uuid=uuid();

        return view('home.userfile.addMaterial',compact('recommend','materialType','msg','doctorrecommend','lenovo','uuid'));

    }


    public  function downloadFile($material_id){

        $material = Material::where('_id',$material_id)->first();
        if(isset($material->_id )){
            return response()->download($material->material_url);
        }else{
            exit('服务器繁忙!');
        }

    }

    public function ajax(){
        $input = Input::all();
        switch($input['action']){
            case 'getlist':
                $pagesize=8;
                $input = Input::all();
                $input['page']=($input['page']==0 || $input['page']>100) ? 1 :$input['page'];
                $input['doctor_id'] =session('user')->_id;
                $input['isshare'] = '0';
                $result=$this->material->getMaterialList($pagesize,$input['page'],$input);
//                $lenovo=$this->getLenovoInfo();
                if(count($result[1])>0) {
                    foreach($result[1] as $k=>$v){
                        $materialtype = MaterialType::where('_id',$v->material_type_id)->first();
                        if($materialtype->material_type_name){
                            $result[1][$k]->material_type_name =$materialtype->material_type_name;
                        }

//                        $result[1][$k]['lenovoUrl']="https://content.box.lenovo.com/v2/files/databox/".$v->path."?X-LENOVO-SESS-ID=".$lenovo->{"X-LENOVO-SESS-ID"}."&path_type=".$v->path_type."&from=&neid=".$v->neid."&rev=".$v->rev."";

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
            case 'lenovo':
                $lenovo=$this->getLenovoInfo();


                //这里是回调地址
                $callBackUrl ="http://".$_SERVER['HTTP_HOST']."/callbackmaterial";

                $command =$input['material_type_id'].'@'.$input['material_name'].'@'.$input['attachments'].'@'.$input['recommend_id'].'@'.$this->doctor_id.'@'.$input['uuid'];

                $recommend = Recommend::where('_id',$input['recommend_id'])->first();
                $bigarea = Bigarea::where('_id',$recommend->big_area_id)->first();
                //这里是src里面的链接地址
                $src ="https://box.lenovo.com/uploadFrame/index.html?sessid=".$lenovo->{"X-LENOVO-SESS-ID"}."&url=https://content.box.lenovo.com/v2/files/databox/".urlencode($bigarea->big_area_name)."/{file}&dir=/collect&uid=".$lenovo->uid."&language=zh";

                $returnInfo=array(
                    'status' => 1,
                    'data' => $src,
                    'callBackUrl'=>$callBackUrl,
                    'command'=>$command,
                );
                return response()->json($returnInfo);
                break;
            case 'delete':
                $material = $this->material->where('_id',$input['id'])->where('doctor_id',$this->doctor_id)->first();
                if($material->delete()){
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
            case 'getuploadurllist':
                $condition['doctor_id']=$input['doctor_id'];
                $condition['upload_code']=$input['upload_code'];
                $materiallenove = MaterialLenove::where($condition)->get();
                if(count($materiallenove)>0){
                    $lenovo=$this->getLenovoInfo();
                    foreach($materiallenove as $k=>$v){
                        $result[$k]['filename']=$v->filename;
                        $result[$k]['lenovoUrl']="https://content.box.lenovo.com/v2/files/databox/".$v->path."?X-LENOVO-SESS-ID=".$lenovo->{"X-LENOVO-SESS-ID"}."&path_type=".$v->path_type."&from=&neid=".$v->neid."&rev=".$v->rev."";
                    }
                    $returnInfo=array(
                        'list' => $result,
                        'status' => 1,
                        'msg' => '操作成功!',
                    );

                }else{
                    $returnInfo=array(
                        'status' => 0,
                        'msg' => '操作失败!',
                    );
                }
                return response()->json($returnInfo);
                break;
        }

    }



}