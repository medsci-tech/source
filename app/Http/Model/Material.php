<?php

namespace App\Http\Model;
use Moloquent;


class Material extends Moloquent {

    protected $connection = 'mongodb';
    protected $table = 'material';

    public function getMaterialList($pagesize = 6, $page = 1,$data=array()){
//        $conditions = array();
////        if(isset($data['doctor_name']) && $data['doctor_name']) {
////            $keywords="%{$data['doctor_name']}%";
////            $conditions['doctor_name'] = array('LIKE',array($keywords));
////        }
////         p($conditions);die;
//        if(isset($data['doctor_moble']) && $data['doctor_moble']) {
//            $conditions['doctor_moble'] = $data['doctor_moble'];
//        }
//        if(isset($data['material_name']) && $data['material_name']) {
//            $conditions['material_name'] = $data['material_name'];
//        }
//        if(isset($data['material_type_id']) && $data['material_type_id']  && $data['material_type_id']!='all') {
//            $conditions['material_type_id'] = $data['material_type_id'];
//        }
//        if(isset($data['recommend_name']) && $data['recommend_name']) {
//            $conditions['recommend_name'] = $data['recommend_name'];
//        }
//        if(isset($data['recommend_mobile']) && $data['recommend_mobile']) {
//            $conditions['recommend_mobile'] = $data['recommend_mobile'];
//        }
//        if(isset($data['check_status']) && $data['check_status'] && $data['check_status'] !='all') {
//            $conditions['check_status'] = $data['check_status'];
//        }
//        if(isset($data['pay_status']) && $data['pay_status'] && $data['pay_status']!='all') {
//            $conditions['pay_status'] = $data['pay_status'];
//        }
//        $offset = 0;
//        if ($page > 1)
//            $offset = ($page - 1) * $pagesize;
//        $totalrows = SELF::count();
//        $pagetotal = ceil($totalrows / $pagesize);
//        if(isset($data['begin_time']) && isset($data['end_time']) && $data['begin_time'] && $data['end_time']){
//            $data['begin_time']=strtotime($data['begin_time']);
//            $data['end_time']=strtotime($data['end_time']);
//            $result=SELF::where($conditions)->whereBetween('addtime', [$data['begin_time'], $data['end_time']])->orderBy('_id', 'desc')->skip($offset)->take($pagesize)->get();
//        }else{
//            $result=SELF::where($conditions)->orderBy('_id', 'desc')->skip($offset)->take($pagesize)->get();
//        }
//        return array($totalrows, $result, $pagetotal);

        
        $handle =SELF::orderBy('_id', 'desc');
        if(isset($data['doctor_name']) && $data['doctor_name']) {
            $ids = Doctor::where('doctor_name',$data['doctor_name'])->pluck('_id')->toArray();
            //dd($ids);
            $handle->whereIn('doctor_id', $ids);
        }

		if(isset($data['doctor_id']) && $data['doctor_id']){
            $handle->where('doctor_id', $data['doctor_id']);
        }


        if(isset($data['isshare']) && $data['isshare']) {
            $handle->where('isshare', $data['isshare']);
        }

//        material_name
        if(isset($data['material_name']) && $data['material_name']) {
            $handle->where('material_name', 'like', "%{$data['material_name']}%");
        }
        if(isset($data['material_type_id']) && $data['material_type_id']  && $data['material_type_id']!='all') {
            $handle->where('material_type_id', $data['material_type_id']);
        }
        if(isset($data['recommend_name']) && $data['recommend_name']) {
            $handle->where('recommend_name', 'like', "%{$data['recommend_name']}%");
        }
        if(isset($data['recommend_mobile']) && $data['recommend_mobile']) {
            $handle->where('recommend_mobile', $data['recommend_mobile']);
        }
        if(isset($data['check_status']) && $data['check_status'] && $data['check_status'] !='all') {
            $handle->where('check_status', $data['check_status']);
        }
        if(isset($data['pay_status']) && $data['pay_status'] && $data['pay_status']!='all') {
            $handle->where('pay_status', $data['pay_status']);
        }
        if(isset($data['begin_time']) && isset($data['end_time']) && $data['begin_time'] && $data['end_time']){
            $data['begin_time']=(string)strtotime($data['begin_time']);
            $data['end_time']=(string)strtotime($data['end_time']);
            $handle->whereBetween('addtime', [$data['begin_time'], $data['end_time']]);
        }
        $offset = 0;
        if ($page > 1)
            $offset = ($page - 1) * $pagesize;
        $totalrows = $handle->count();
        $pagetotal = ceil($totalrows / $pagesize);
//        if(isset($data['begin_time']) && isset($data['end_time']) && $data['begin_time'] && $data['end_time']){
//            $data['begin_time']=strtotime($data['begin_time']);
//            $data['end_time']=strtotime($data['end_time']);
//            $result=$handle->where($conditions)->whereBetween('addtime', [$data['begin_time'], $data['end_time']])->orderBy('_id', 'desc')->skip($offset)->take($pagesize)->get();
//        }else{
            $result=$handle->skip($offset)->take($pagesize)->get();
//        }
        return array($totalrows, $result, $pagetotal);


    }


}
