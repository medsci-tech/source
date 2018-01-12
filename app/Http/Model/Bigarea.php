<?php

namespace App\Http\Model;
use Moloquent;


class Bigarea extends Moloquent {

    protected $connection = 'mongodb';
    protected $table = 'bigarea';
	protected $fillable = ['big_area_name','company_id','status'];

    public function getBigareaList($pagesize = 6, $page = 1,$data=array()){
        $handle =SELF::orderBy('_id', 'desc');
        if($data['company_id']) {
            $handle->where('company_id',$data['company_id']);
        }
        $offset = 0;
        if ($page > 1)
            $offset = ($page - 1) * $pagesize;
        $totalrows = $handle->count();
        $pagetotal = ceil($totalrows / $pagesize);
        $result=$handle->skip($offset)->take($pagesize)->get();
        foreach ($result as &$v){
        	$v->company = SELF::getCompany($v->company_id);
		}
        return array($totalrows, $result, $pagetotal);
    }


    public function addBigareaType($data){

        $this->material_type_name =$data['big_area_name'];
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

    public function getCompany($id){
    	$company = Company::where('_id',$id)->pluck('full_name');
    	try{
			return $company[0];
		}catch (\Exception $e){
			return '';
		}

	}
}
