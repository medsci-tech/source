<?php

namespace App\Http\Model;
use Moloquent;


class Sales extends Moloquent {

    protected $connection = 'mongodb';
    protected $table = 'sales';

    public function getSalesList($pagesize = 6, $page = 1,$data=array()){
        $handle =SELF::orderBy('_id', 'desc');
        if(isset($data['company_id']) && $data['company_id'] && $data['company_id'] !='all') {
            $handle->where('company_id', $data['company_id']);
        }
        if(isset($data['big_area_id']) && $data['big_area_id'] && $data['big_area_id'] !='all') {
            $handle->where('big_area_id', $data['big_area_id']);
        }
        if(isset($data['area_id']) &&$data['area_id'] && $data['area_id'] !='all') {
            $handle->where('area_id', $data['area_id']);
        }
        if(isset($data['sales_name']) &&$data['sales_name']) {
            $handle->where('sales_name', 'like', "%{$data['sales_name']}%");
        }
        $offset = 0;
        if ($page > 1)
            $offset = ($page - 1) * $pagesize;
        $totalrows = $handle->count();
        $pagetotal = ceil($totalrows / $pagesize);
            $result=$handle->skip($offset)->take($pagesize)->get();
        return array($totalrows, $result, $pagetotal);
    }


    public function addSales($data){

        $this->big_area_name =$data['big_area_name'];
        $this->big_area_id =$data['big_area_id'];
        $this->area_name =$data['area_name'];
        $this->area_id =$data['area_id'];
        $this->sales_name =$data['sales_name'];
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
