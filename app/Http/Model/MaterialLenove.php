<?php

namespace App\Http\Model;
use Moloquent;


class MaterialLenove extends Moloquent {

    protected $connection = 'mongodb';
    protected $table = 'material_lenove';
	protected $fillable = ['doctor_id','upload_code','material_url','path_type','filename','addtime'];

    public function getMaterialLenove(){



    }

    
}
