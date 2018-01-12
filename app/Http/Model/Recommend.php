<?php

namespace App\Http\Model;
use Moloquent;


class Recommend extends Moloquent {

    protected $connection = 'mongodb';
    protected $table = 'recommend';
	protected $fillable = ['recommend_mobile','recommend_name','big_area_id','area_id','sales_id'];

    public function getRecommendList($pagesize = 6, $page = 1,$data=array()){
        $handle =SELF::orderBy('_id', 'desc');
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
        $offset = 0;
        if ($page > 1)
            $offset = ($page - 1) * $pagesize;
        $totalrows = $handle->count();
        $pagetotal = ceil($totalrows / $pagesize);
        $result=$handle->skip($offset)->take($pagesize)->get();
        return array($totalrows, $result, $pagetotal);
    }


    public function addRecommend($data){

        $this->big_area_name =$data['big_area_name'];
        $this->big_area_id =$data['big_area_id'];

        $this->big_area_name =$data['area_name'];
        $this->big_area_id =$data['area_id'];

        $this->big_area_name =$data['sales_name'];
        $this->big_area_id =$data['sales_id'];

        $this->big_area_id =$data['recommend_name'];
        $this->big_area_id =$data['recommend_mobile'];

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
