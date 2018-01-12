<?php

namespace App\Http\Model;
use Moloquent;

use App\Http\Model\Material;
use App\Http\Model\Hospital;
use App\Http\Model\Recommend;
use App\Http\Model\Doctor;

class Report extends Moloquent {

    protected $connection = 'mongodb';
    protected $table = 'report';
    

    public function getReportList($pagesize = 6, $page = 1,$data=array()){
        //
        $handle2 =Material::orderBy('_id', 'desc');
        switch($data['searchType']){
            case 'all':
                if(isset($data['begin_time']) && isset($data['end_time']) && $data['begin_time'] && $data['end_time']){
                    $data['begin_time']=(string)strtotime($data['begin_time']);
                    $data['end_time']=(string)strtotime($data['end_time']);
                    $handle2->whereBetween('addtime', [$data['begin_time'], $data['end_time']]);
                }
                break;

            case 'material':
                $handle2 =Material::orderBy('_id', 'desc');
                if(isset($data['material_name']) && $data['material_name']) {
                    $handle2->where('material_name', 'like', "%{$data['material_name']}%");
                }
                if(isset($data['material_type_id']) && $data['material_type_id']  && $data['material_type_id']!='all') {
                    $handle2->where('material_type_id', $data['material_type_id']);
                }

                if(isset($data['check_status']) && $data['check_status'] && $data['check_status'] !='all') {
                    $handle2->where('check_status', $data['check_status']);
                }
                if(isset($data['pay_status']) && $data['pay_status'] && $data['pay_status']!='all') {
                    $handle2->where('pay_status', $data['pay_status']);
                }
                break;

            case 'doctor':
                $handle =Doctor::orderBy('_id', 'desc');
                if(isset($data['doctor_name']) &&  $data['doctor_name']) {
                    $handle->where('doctor_name', 'like', "%{$data['doctor_name']}%");
                }
                if(isset($data['doctor_mobile']) &&  $data['doctor_mobile']) {
                    $handle->where('doctor_mobile', 'like', "%{$data['doctor_mobile']}%");
                }
                if(isset($data['id_card']) &&  $data['id_card']) {
                    $handle->where('id_card', 'like', "%{$data['id_card']}%");
                }
                $result=$handle->get();
                if(count($result)>0){
                    foreach($result as $k=>$v){
                        $ids[]=$v->_id;
                    }
                    $handle2->whereIn('doctor_id', $ids);
                }else{
                    return array();
                }
                break;

            case 'recommend':
                $handle =Recommend::orderBy('_id', 'desc');
                if($data['company_id'] && $data['company_id'] !='all') {
                    $handle->where('company_id', $data['company_id']);
                }
                if($data['big_area_id'] && $data['big_area_id'] !='all') {
                    $handle->where('big_area_id', $data['big_area_id']);
                }
                if($data['area_id'] && $data['area_id'] !='all') {
                    $handle->where('area_id', $data['area_id']);
                }
                if($data['sales_id'] && $data['sales_id'] !='all') {
                    $handle->where('sales_id', $data['sales_id']);
                }
                if($data['recommend_name']) {
                    $handle->where('recommend_name', 'like', "%{$data['recommend_name']}%");
                }
                if($data['recommend_mobile']) {
                    $handle->where('recommend_mobile', 'like', "%{$data['recommend_mobile']}%");
                }
                $result=$handle->get();
                if(count($result)>0){
                    foreach($result as $k=>$v){
                        $ids[]=$v->_id;
                    }
                    $handle2->whereIn('recommend_id', $ids);
                }else{
                    return array();
                }
                break;
            case 'hospital':
                $handle =Hospital::orderBy('_id', 'desc');
                if(isset($data['hospital_name']) && $data['hospital_name']) {
                    $handle->where('hospital_name', 'like', "%{$data['hospital_name']}%");
                }
                if(isset($data['hospital_level_id']) && $data['hospital_level_id'] && $data['hospital_level_id'] !='all') {
                    $handle->where('hospital_level_id', $data['hospital_level_id']);
                }
                $result=$handle->get();
                if(count($result)>0){
                    foreach($result as $k=>$v){
                        $ids[]=$v->_id;
                    }
                    $handle2->whereIn('hospital_id', $ids);
                }else{
                    return array();
                }
                break;
        }


        $offset = 0;
        if ($page > 1)
            $offset = ($page - 1) * $pagesize;
        $totalrows = $handle2->count();
        $pagetotal = ceil($totalrows / $pagesize);
        $result=$handle2->skip($offset)->take($pagesize)->get();
        return array($totalrows, $result, $pagetotal);
    }

    public function getReportExportList($data=array()){
        //
        $handle2 =Material::orderBy('_id', 'desc');
        switch($data['searchType']){
            case 'all':
                if(isset($data['begin_time']) && isset($data['end_time']) && $data['begin_time'] && $data['end_time']){
                    $data['begin_time']=(string)strtotime($data['begin_time']);
                    $data['end_time']=(string)strtotime($data['end_time']);
                    $handle2->whereBetween('addtime', [$data['begin_time'], $data['end_time']]);
                }
                break;

            case 'material':
                $handle2 =Material::orderBy('_id', 'desc');
                if(isset($data['material_name']) && $data['material_name']) {
                    $handle2->where('material_name', 'like', "%{$data['material_name']}%");
                }
                if(isset($data['material_type_id']) && $data['material_type_id']  && $data['material_type_id']!='all') {
                    $handle2->where('material_type_id', $data['material_type_id']);
                }

                if(isset($data['check_status']) && $data['check_status'] && $data['check_status'] !='all') {
                    $handle2->where('check_status', $data['check_status']);
                }
                if(isset($data['pay_status']) && $data['pay_status'] && $data['pay_status']!='all') {
                    $handle2->where('pay_status', $data['pay_status']);
                }
                break;

            case 'doctor':
                $handle =Doctor::orderBy('_id', 'desc');
                if(isset($data['doctor_name']) &&  $data['doctor_name']) {
                    $handle->where('doctor_name', 'like', "%{$data['doctor_name']}%");
                }
                if(isset($data['doctor_mobile']) &&  $data['doctor_mobile']) {
                    $handle->where('doctor_mobile', 'like', "%{$data['doctor_mobile']}%");
                }
                if(isset($data['id_card']) &&  $data['id_card']) {
                    $handle->where('id_card', 'like', "%{$data['id_card']}%");
                }
                $result=$handle->get();
                if(count($result)>0){
                    foreach($result as $k=>$v){
                        $ids[]=$v->_id;
                    }
                    $handle2->whereIn('doctor_id', $ids);
                }else{
                    return array();
                }
                break;

            case 'recommend':
                $handle =Recommend::orderBy('_id', 'desc');
                if($data['big_area_id'] && $data['big_area_id'] !='all') {
                    $handle->where('big_area_id', $data['big_area_id']);
                }
                if($data['area_id'] && $data['area_id'] !='all') {
                    $handle->where('area_id', $data['area_id']);
                }
                if($data['sales_id'] && $data['sales_id'] !='all') {
                    $handle->where('sales_id', $data['sales_id']);
                }
                if($data['recommend_name']) {
                    $handle->where('recommend_name', 'like', "%{$data['recommend_name']}%");
                }
                if($data['recommend_mobile']) {
                    $handle->where('recommend_mobile', 'like', "%{$data['recommend_mobile']}%");
                }
                $result=$handle->get();
                if(count($result)>0){
                    foreach($result as $k=>$v){
                        $ids[]=$v->_id;
                    }
                    $handle2->whereIn('recommend_id', $ids);
                }else{
                    return array();
                }
                break;
            case 'hospital':
                $handle =Hospital::orderBy('_id', 'desc');
                if(isset($data['hospital_name']) && $data['hospital_name']) {
                    $handle->where('hospital_name', 'like', "%{$data['hospital_name']}%");
                }
                if(isset($data['hospital_level_id']) && $data['hospital_level_id'] && $data['hospital_level_id'] !='all') {
                    $handle->where('hospital_level_id', $data['hospital_level_id']);
                }
                $result=$handle->get();
                if(count($result)>0){
                    foreach($result as $k=>$v){
                        $ids[]=$v->_id;
                    }
                    $handle2->whereIn('hospital_id', $ids);
                }else{
                    return array();
                }
                break;
        }

        return $handle2->get();
    }

}
