<?php

namespace App\Http\Model;
use Moloquent;
use phpDocumentor\Reflection\Types\Self_;


class Doctor extends Moloquent {

    protected $connection = 'mongodb';
    protected $table = 'doctor';

	public function getProtocol(){
		return $this->hasOne('App\Http\Model\DoctorProtocol');
	}
    //添加修改
    public function updateDoctor($obj){

        if(isset($obj->_id) && $obj->_id){
            if($this->save()){
                return true;
            }
        }
        //$user->name = 'John';
        if($this->create($obj)){
            return true;
        }
        return false;

    }


    //获取一条数据
    public function getOneDoctor($condition){

        return SELF::where(current(array_keys($condition)),end(array_values($condition)))->first();
    }


    //获取多条数据
    public function getDoctor($condition){

        return SELF::where(current(array_keys($condition)),end(array_values($condition)))->get();
    }

    public function deleteDoctor(){

        $user = SELF::first()->delete();
        return $user;
//        $user->delete();
    }


    public function getDoctorList($pagesize = 6, $page = 1,$data=array()){
        $handle =SELF::orderBy('_id', 'desc');
        if(isset($data['protocol_status']) &&  $data['protocol_status']!=='') {
        	/*$ids = DoctorProtocol::where('check_status',$data['protocol_status'])->pluck('doctor_id')->toArray();
            $handle->whereIn('_id', $ids);*/
	        $handle->where('protocol_check_status', $data['protocol_status']);
        }
        if(isset($data['province_id']) &&  $data['province_id']) {
            $handle->where('provice_id', $data['provice_id']);
        }
        if(isset($data['city_id']) &&  $data['city_id']) {
            $handle->where('city_id', $data['city_id']);
        }
        if(isset($data['region_id']) &&  $data['region_id']) {
            $handle->where('region_id', $data['region_id']);
        }
        if(isset($data['doctor_name']) &&  $data['doctor_name']) {
            $handle->where('doctor_name', 'like', "%{$data['doctor_name']}%");
        }
        if(isset($data['doctor_mobile']) &&  $data['doctor_mobile']) {
            $handle->where('doctor_mobile', 'like', "%{$data['doctor_mobile']}%");
        }
        if(isset($data['id_card']) &&  $data['id_card']) {
            $handle->where('id_card', 'like', "%{$data['id_card']}%");
        }
        $offset = 0;
        if ($page > 1)
            $offset = ($page - 1) * $pagesize;
        $totalrows = $handle->count();
        $pagetotal = ceil($totalrows / $pagesize);
        $result=$handle->skip($offset)->take($pagesize)->get();
        return array($totalrows, $result, $pagetotal);
    }


    public function addDoctor($data){

        $this->doctor_name =$data['doctor_name'];
        $this->doctor_moble =$data['doctor_moble'];
        $this->provice_id =$data['provice_id'];
        $this->provice_name =$data['provice_name'];
        $this->city_id =$data['city_id'];
        $this->city_name =$data['city_name'];
        $this->region_id =$data['region_id'];
        $this->region_name =$data['region_name'];

        $this->hospital_name =$data['hospital_name'];
        $this->id_catd =$data['id_catd'];
        $this->bank_name =$data['bank_name'];
        $this->bank_card_no =$data['bank_card_no'];
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
