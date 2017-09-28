<?php

namespace App\Http\Model;
use Moloquent;


class Tools extends Moloquent {

    protected $connection = 'mongodb';
    protected $table = 'tools';


    public function getToolsList($pagesize = 6, $page = 1,$data=array()){
        $handle =SELF::orderBy('_id', 'desc');
        if($data['file_name']) {
            $handle->where('file_name', 'like', "%{$data['file_name']}%");
        }
        $offset = 0;
        if ($page > 1)
            $offset = ($page - 1) * $pagesize;
        $totalrows = $handle->count();
        $pagetotal = ceil($totalrows / $pagesize);
        $result=$handle->skip($offset)->take($pagesize)->get();
        return array($totalrows, $result, $pagetotal);
    }


    public function addTools($data){

        $this->tools_name =$data['tools_name'];
        $this->weight =$data['weight'];
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
