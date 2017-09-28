<?php

namespace App\Http\Model;
use Moloquent;


class Hospital extends Moloquent {

    protected $connection = 'mongodb';
    protected $table = 'hospital';

    public function getHospitalList($pagesize = 6, $page = 1,$data=array()){
        $handle =SELF::orderBy('_id', 'desc');
        if(isset($data['province_id']) && $data['province_id']) {
            $handle->where('province_id', $data['province_id']);
        }
        if(isset($data['city_id']) &&  $data['city_id']) {
            $handle->where('city_id', $data['city_id']);
        }
        if(isset($data['region_id']) && $data['region_id']) {
            $handle->where('region_id', $data['region_id']);
        }
        if(isset($data['hospital_name']) && $data['hospital_name']) {
            $handle->where('hospital_name', 'like', "%{$data['hospital_name']}%");
        }
        if(isset($data['hospital_level_id']) && $data['hospital_level_id'] && $data['hospital_level_id'] !='all') {
            $handle->where('hospital_level_id', $data['hospital_level_id']);
        }
        $offset = 0;
        if ($page > 1)
            $offset = ($page - 1) * $pagesize;
        $totalrows = $handle->count();
        $pagetotal = ceil($totalrows / $pagesize);
        $result=$handle->skip($offset)->take($pagesize)->get();
        return array($totalrows, $result, $pagetotal);
    }


    public function addHospital($data){

        $this->hospital_name =$data['hospital_name'];
        $this->hospital_level =$data['hospital_level'];
        $this->hospital_level_id =$data['hospital_level_id'];
        $this->provice_id =$data['provice_id'];
        $this->city_id =$data['city_id'];
        $this->region_id =$data['region_id'];
        $this->status =0;
        $this->addtime =time();
        if(!$data['_id'] && $this->save()){
            return true;
        }
        if($data['_id'] && SELF::where('_id',$data['_id'])->update($data)){
            return true;
        }
        return false;

    }
}
