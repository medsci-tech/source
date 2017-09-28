<?php

namespace App\Http\Model;
use Moloquent;


class MaterialType extends Moloquent {

    protected $connection = 'mongodb';
    protected $table = 'material_type';


    public function getMaterialTypeList($pagesize = 6, $page = 1,$data=array()){
        $handle =SELF::orderBy('_id', 'desc');
        if($data['material_type_name']) {
            $handle->where('material_type_name', 'like', "%{$data['material_type_name']}%");
        }
        $offset = 0;
        if ($page > 1)
            $offset = ($page - 1) * $pagesize;
        $totalrows = $handle->count();
        $pagetotal = ceil($totalrows / $pagesize);
        $result=$handle->skip($offset)->take($pagesize)->get();
        return array($totalrows, $result, $pagetotal);
    }


    public function addMaterialType($data){

        $this->material_type_name =$data['material_type_name'];
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
