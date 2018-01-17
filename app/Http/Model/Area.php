<?php

namespace App\Http\Model;
use Moloquent;


class Area extends Moloquent {

    protected $connection = 'mongodb';
    protected $table = 'area';

    public function getAreaList($pagesize = 6, $page = 1,$data=array()){
        $handle =SELF::orderBy('_id', 'desc');
        if($data['big_area_id'] && $data['big_area_id'] !='all') {
            $handle->where('big_area_id', $data['big_area_id']);

        }
        if($data['area_name']) {
            $handle->where('area_name', 'like', "%{$data['area_name']}%");
        }
        $offset = 0;
        if ($page > 1)
            $offset = ($page - 1) * $pagesize;
        $totalrows = $handle->count();
        $pagetotal = ceil($totalrows / $pagesize);
        $result=$handle->skip($offset)->take($pagesize)->get();
        return array($totalrows, $result, $pagetotal);
    }

    public function getCompany(){
		return $this->belongsTo('App\Http\Model\Company');
	}

	public function getBigArea(){
		return $this->belongsTo('App\Http\Model\Bigarea');
	}

    public function addArea($data){

        $this->big_area_id =$data['big_area_id'];
        $this->big_area_name =$data['big_area_name'];
        $this->area_name =$data['area_name'];
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
