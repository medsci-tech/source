<?php
/**
 * Created by ...
 * User: zhanghui
 * Date: 16/12/10
 * DesCription:...
 */


namespace App\Http\Controllers\Home;

use App\Http\Model\Company;
use App\Http\Model\DoctorProtocol;
use App\Http\Model\Material;
use App\Http\Model\MaterialType;
use App\Http\Model\Recommend;
use App\Http\Model\Bigarea;
use App\Http\Model\DoctorRecommend;
use App\Http\Model\MaterialLenove;

use App\Http\Model\Volunteer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;

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

    public function addMaterial(Request $request){
    	//检测协议是否通过
		$protocol = DoctorProtocol::where('doctor_id',$this->doctor_id)->first();
		if(!$protocol || $protocol->check_status === '2'){
			return redirect('home/userinfo/protocol');
		}elseif($protocol->check_status === '0'){
			return redirect('home/userinfo/index');
		}
        if($request->isMethod('post')) {
//			$file = $request->all();dd($file);
//            $this->validate($request,[
//                'material_type_id'=>'required',
//                'material_name'=>'required',
//                'recommend'=>'required|digits:11',
////                'files'=>'required',
//            ],[
//                'required'=>':attribute 不能为空',
//                'digits'=>':attribute 长度必须为11位数字',
//            ],[
//                'material_type_id'=>'素材类型',
//                'material_name'=>'素材名称',
//                'recommend'=>'推荐人手机号',
////                'files'=>'上传的文件',
//            ]);
            $input = $request->all();
//			$files = $input['files'];
//			dd($files);
//			if(!count($files)){
//				return response()->json(['code'=>400,'msg'=>'请上传文件']);
//			}
			//推荐人手机号
			$rec_phone= $input['recommend'];
			/*
			 * 查看推荐人是否存在
			 * 如果存在，新增素材记录；
			 * 如果不存在，添加推荐人，新增素材记录
			 */
			$recommend = Recommend::where('recommend_mobile',$rec_phone)->first();
			if(!$recommend){
				try {
					$vol = Volunteer::where('phone', $rec_phone)->first();
					//代表所在公司
					$unit = $vol->unit;
					// 如果公司记录不存在，添加
					$company = Company::where('full_name', $unit->full_name)->first();
					if (!$company) {
						$company = Company::create(['full_name'=>$unit->full_name, 'short_name'=>$unit->short_name]);
					}

					//如果公司销售大区不存在，添加
					$represent = $vol->represent;
					$bigarea = Bigarea::where(['big_area_name'=>$represent->belong_area,'company_id'=>$company->_id])->first();
					if(!$bigarea){
						$bigarea = Bigarea::create(['big_area_name'=>$represent->belong_area,'company_id'=>$company->_id,'status'=>'1']);
					}

					//添加销售人员信息
					$recommend = Recommend::create(['recommend_mobile'=>$rec_phone,'recommend_name'=>$vol->name,'company_id'=>$company->_id,'big_area_id'=>$bigarea->_id,'area_id'=>'','sales_id'=>'']);
					//添加推荐关系
					DoctorRecommend::firstOrCreate(['recommend_id'=>$recommend->_id,'doctor_id'=>$this->doctor_id]);
				}catch (\Exception $e){
					return response()->json(['code'=>400,'msg'=>'添加推荐人失败']);
				}
			}
			$uuid = $input['uuid'];
            //素材类型
            $this->material->material_type_id = $input['material_type_id'];
            //素材名称
            $this->material->material_name = $input['material_name'];
            //公司附件数量
            $this->material->attachments = $input['attachments'];
            //医生id
            $this->material->doctor_id = $this->doctor_id;
            $this->material->recommend_id = $recommend->_id;
            //素材标识
			$this->material->upload_code = $uuid;

            $this->material->isshare = '0';
            $this->material->check_status = '0';
            $this->material->pay_status = '0';
            $this->material->pay_amount = '0';
            $this->material->pass_amount = '0';
            $this->material->comment = '';
            $this->material->location = 'qiniu';
            //添加时间
            $this->material->addtime = (string)time();
            if(!$this->material->save()){
				return response()->json(['code'=>400,'msg'=>'发布失败']);
            }

			return response()->json(['code'=>200,'msg'=>'上传成功']);
        }

		$vol = Volunteer::select('name','phone')->get();
        $materialType = MaterialType::where('status','1')->get();
		$uuid=uuid();//素材标识唯一码
		header('Access-Control-Allow-Origin:*');
        return view('home.userfile.addMaterial',compact('materialType','vol','uuid'));

    }

	/**
	 * 上传素材文件
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function uploadFiles(Request $request){
    	//dd($request->file());
		$uuid = $request->uuid;
		$files = $request->file('files');
		//用七牛云上传文件
		$accessKey = env('QN_AccessKey');
		$secretKey = env('QN_SecretKey');
		$bucket = env('QN_Bucket');
		$auth = new Auth($accessKey,$secretKey);
		// 生成上传 Token
		$token = $auth->uploadToken($bucket);

		$uploadMgr = new UploadManager();

		$uploadResult = array();
		foreach($files as $file){
			$filePath = $file->getRealPath();//真实文件地址
			$originalName = $file->getClientOriginalName();
//			$ext = $file->getClientOriginalExtension();//文件后缀名
//				echo $key;
//				dd($filePath);
			$key = uuid();
			// 调用 UploadManager 的 putFile 方法进行文件的上传。
			list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
			if ($err !== null) {
				return response()->json(['code'=>500,'msg'=>$err]);
			} else {
				$ret['originalName'] = $originalName;
				$uploadResult[] =$ret;
			}
		}

//			dd($res);
		//添加
		foreach ($uploadResult as $res) {
			MaterialLenove::create(['doctor_id' => $this->doctor_id, 'upload_code' => $uuid, 'material_url' => $res['key'], 'path_type' => 'QN', 'filename' => $res['originalName'], 'addtime' => (string)time()]);
		}
		return response()->json(['code'=>200,'msg'=>'文件上传成功']);
	}

    public function downloadFile($material_id){

        $material = Material::where('_id',$material_id)->first();
        if(isset($material->_id )){
            return response()->download($material->material_url);
        }else{
            exit('服务器繁忙!');
        }

    }
	public  function downloadSource(Request $request,$material_url){
		$material = MaterialLenove::find($material_url);
//		dd(($material));
		$filename=env('QN_Url').$material->material_url;
		$file  =  fopen($filename, "rb");
		$name = $material->filename;
		Header( "Content-type:  application/octet-stream ");
		Header( "Accept-Ranges:  bytes ");
		Header( "Content-Disposition:  attachment;  filename= {$name}");
		$contents = "";
		while (!feof($file)) {
			$contents .= fread($file, 8192);
		}
		echo $contents;
		fclose($file);
		exit;
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
                        'msg' => '暂无数据',
                    );
                }
                return response()->json($returnInfo);
                break;
            case 'lenovo':

                $lenovo=$this->getLenovoInfo();
                //dd($lenovo);

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
						if($v->path_type == 'QN'){
							$downloadUrl = url("home/userfile/downloadSource",$v->_id);
							$result[$k]['url'] = $downloadUrl;
						}else{
							$result[$k]['url']="https://content.box.lenovo.com/v2/files/databox/".$v->path."?X-LENOVO-SESS-ID=".$lenovo->{"X-LENOVO-SESS-ID"}."&path_type=".$v->path_type."&from=&neid=".$v->neid."&rev=".$v->rev."";
						}
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
			case 'checkProtocol':
				//用户是否有上传协议，如果有，则进行素材上传，否则先上传协议
				$protocol = DoctorProtocol::where('doctor_id',$this->doctor_id)->first();
				if($protocol){
					if($protocol->check_status === '0'){
						$returnInfo=array(
							'url'=>url('home/userinfo/index'),
							'status' => 0,
							'msg' => '您的协议正在审核中，请耐心等待...',
						);
					}elseif($protocol->check_status === '2'){
						$returnInfo=array(
							'url'=>url('home/userinfo/protocol'),
							'status' => 0,
							'msg' => '您的协议审核未通过，请修改后重新上传',
						);
					}else{
						$returnInfo=array(
							'url'=>url('home/userfile/addmaterial'),
							'status' => 1,
							'msg' => '您的协议已通过审核，可以开始上传素材啦...',
						);
					}
				}else{
					$returnInfo=array(
						'url'=>url('home/userinfo/protocol'),
						'status' => 0,
						'msg' => '您还未上传协议，请先上传',
					);
				}
				return response()->json($returnInfo);
        }

    }



}