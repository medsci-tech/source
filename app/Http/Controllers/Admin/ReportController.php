<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Company;
use App\Http\Model\User;
use App\Http\Model\MaterialType;
use App\Http\Model\Material;
use App\Http\Model\Bigarea;
use App\Http\Model\Sales;
use App\Http\Model\Area;
use App\Http\Model\Report;
use App\Http\Model\Doctor;
use App\Http\Model\Recommend;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends CommonController
{

    function __construct() {
        $this->report=new Report;
        $this->middleware('admin.login.admin');
    }

    public function index()
    {
        $materialType = materialType::where('status','1')->get();
        $company= Company::get();

        return view('admin.report',compact('materialType','company'));
    }


    public function ajax(){
        $input = Input::all();
        Cache::put('report_request', $input, 86400);
        switch($input['action']){
            case 'getlist':
                $pagesize=8;
                $input['page']=($input['page']==0 || $input['page']>100) ? 1 :$input['page'];
                $result=$this->report->getReportList($pagesize,$input['page'],$input);
                if(!empty($result[1])) {
                    $hasPayAmount=0;
                    $waitPayAmount=0;
                    foreach($result[1] as $k=>$v){
                        if($v->pay_status ==1){
                            $hasPayAmount += $v->pay_amount;
                        }
                        if($v->pay_status ==0 && $v->check_status ==1){
                            $waitPayAmount += $v->pay_amount;
                        }
                        $doctor = Doctor::where('_id',$v->doctor_id)->first();
                        if($doctor){
                            $result[1][$k]->doctor_name =$doctor['doctor_name'];
							$result[1][$k]->doctor_mobile =$doctor['doctor_mobile'];
                        }else{
							$result[1][$k]->doctor_name = '';
							$result[1][$k]->doctor_mobile ='';
						}
                        $result[1][$k]['doctor_province'] = $doctor['province_name'];
                        $result[1][$k]['doctor_city'] = $doctor['city_name'];
                        $result[1][$k]['doctor_region'] = $doctor['region_name'];
                        $result[1][$k]['doctor_hospital'] = $doctor['hospital_name'];
                        $result[1][$k]['doctor_id_card'] = $doctor['id_card'];
                        $result[1][$k]['doctor_bank_name'] = $doctor['bank_name'];
                        $result[1][$k]['doctor_bank_card_no'] = $doctor['bank_card_no'];

                        $recommend = Recommend::where('_id',$v->recommend_id)->first();
                        if($recommend){
                            $result[1][$k]->recommend_name =$recommend['recommend_name'];
                            $result[1][$k]->recommend_mobile =$recommend['recommend_mobile'];
                        }else{
							$result[1][$k]->recommend_name ='';
							$result[1][$k]->recommend_mobile = '';
						}

                        $company = Company::where('_id',$recommend->company_id)->first();
                        $bigarea = Bigarea::where('_id',$recommend->big_area_id)->first();
                        $area = Area::where('_id',$recommend->area_id)->first();
                        $sales = Sales::where('_id',$recommend->sales_id)->first();
                        if($company){
                            $result[1][$k]->company_name =$company['full_name'];
                        }else{
							$result[1][$k]->company_name ='';
						}
						if($bigarea){
                            $result[1][$k]->big_area_name =$bigarea['big_area_name'];
                        }else{
							$result[1][$k]->big_area_name ='';
						}
                        if($area){
                            $result[1][$k]->area_name =$area['area_name'];
                        }else{
                            $result[1][$k]->area_name = '';
                        }
                        if($sales){
                            $result[1][$k]->sales_name =$sales['sales_name'];
                        }else{
							$result[1][$k]->sales_name = '';
						}
                        $materialtype = MaterialType::where('_id',$v->material_type_id)->first();

                        if($materialtype){
                            $result[1][$k]->material_type_name =$materialtype['material_type_name'];
                        }else{
							$result[1][$k]->material_type_name = '';
						}


                    }
                    $returnInfo=array(
                        'total_num' => $result[0],
                        'list' => $result[1],
                        'page_size' => $pagesize,
                        'page_total_num' => $result[2],
                        'hasPayAmount'=>$hasPayAmount,
                        'waitPayAmount'=>$waitPayAmount,
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
            case 'add':

                break;
        }

    }


    public function reportExcel(){

	set_time_limit(0);
	ini_set('memory_limit', '0');

        $report_request = Cache::get('report_request');
//        $material =Material::get();
//        ini_set('memory_limit', '526M');
        $material = $this->report->getReportExportList($report_request);
//        dd($material);
        $totalPayAmount=0;
        foreach($material as $k=>$v) {
            $totalPayAmount += $v->pay_amount;
            $doctor = Doctor::where('_id', $v->doctor_id)->first();
            if ($doctor) {
                $material[$k]->doctor_name = $doctor['doctor_name'];
				$material[$k]->doctor_mobile = $doctor['doctor_mobile'];
            }
            $material[$k]['doctor_province'] = $doctor['province_name'];
            $material[$k]['doctor_city'] = $doctor['city_name'];
            $material[$k]['doctor_region'] = $doctor['region_name'];
            $material[$k]['doctor_hospital'] = $doctor['hospital_name'];
            $material[$k]['doctor_id_card'] = $doctor['id_card'];
            $material[$k]['doctor_bank_name'] = $doctor['bank_name'];
            $material[$k]['doctor_bank_card_no'] = $doctor['bank_card_no'];

            $recommend = Recommend::where('_id', $v->recommend_id)->first();

            if ($recommend) {
                $material[$k]->recommend_name = $recommend['recommend_name'];
				$material[$k]->recommend_mobile = $recommend['recommend_mobile'];

			}

            $company = Company::where('_id', $recommend->company_id)->first();
            $bigarea = Bigarea::where('_id', $recommend->big_area_id)->first();
            $area = Area::where('_id', $recommend->area_id)->first();
            $sales = Sales::where('_id', $recommend->sales_id)->first();
            if ($company) {
                $material[$k]->big_area_name = $company['full_name'];
            }else{
				$material[$k]->full_name = '';
			}
			if ($bigarea) {
                $material[$k]->big_area_name = $bigarea['big_area_name'];
            }else{
				$material[$k]->big_area_name = '';
			}
            if ($area) {
                $material[$k]->area_name = $area['area_name'];
            } else {
                $material[$k]->area_name = '';
            }
            if ($sales) {
                $material[$k]->sales_name = $sales['sales_name'];
            }else{
				$material[$k]->sales_name = '';
			}
            $materialtype = MaterialType::where('_id', $v->material_type_id)->first();

            if ($materialtype) {
                $material[$k]->material_type_name = $materialtype['material_type_name'];
            }else{
				$material[$k]->material_type_name = '';
			}
        }

        $titleRow =array(
            '序号',
            '医生姓名',
            '医生手机号',
            '医生省份',
            '医生城市',
            '医生区县',
            '医生医院',
            '医生身份证号',
            '医生开户行',
            '医生银行卡号',
            '上传时间',
            '素材名称',
            '素材类型',
            '素材数量',
            '公司',
            '大区',
            '区域',
            '销售组',
            '推荐人姓名',
            '推荐人手机号',
            '审核状态	',
            '支付金额',
            '审核通过个数',
            '支付状态',
            '备注',
        );

        $cellData[0]=$titleRow;
        foreach($material as $k=>$v){
            $arr =array();
            $arr[] =$k+1;
            $arr[] =$v->doctor_name;
            $arr[] =$v->doctor_mobile;
            $arr[] =$v['doctor_province'];
            $arr[] =$v['doctor_city'];
            $arr[] =$v['doctor_region'];
            $arr[] =$v['doctor_hospital'];
            $arr[] =$v['doctor_id_card'].' ';
            $arr[] =$v['doctor_bank_name'];
            $arr[] =$v['doctor_bank_card_no'].' ';
            $arr[] =$v->created_at;
            $arr[] =$v->material_name;
            $arr[] =$v->material_type_name;
            $arr[] =$v->attachments;
            $arr[] =$v->company_name;
            $arr[] =$v->big_area_name;
            $arr[] =$v->area_name;
            $arr[] =$v->sales_name;
            $arr[] =$v->recommend_name;
            $arr[] =$v->recommend_mobile;
            if($v->check_status ==0){
                $arr[] ='未审核';
            }elseif($v->check_status ==1){
                $arr[] ='审核通过';
            }else{
                $arr[] ='审核未通过';
            }
            $arr[] =$v->pay_amount;
            $arr[] =$v->pass_amount;
            $arr[] =$v->pay_status ==1 ? '已支付' :'未支付';
            $arr[] =$v->comment;
            
            $cellData[]=$arr;
        }
        Excel::create('素材搜集支撑系统数据分析表'.date('Y-m-d',time()),function($excel) use ($cellData){
            $excel->sheet('score', function($sheet) use ($cellData){
                $sheet->setColumnFormat([
                    'H' => '@',
                    'J' => '@',
                ]);
                $sheet->rows($cellData);
            });
        })->export('xls');
}


}
