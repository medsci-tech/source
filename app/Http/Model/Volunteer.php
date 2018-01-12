<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Volunteer extends Model
{
    protected $connection = 'mysql';
    protected $table = 'mime_volunteers';

    public function Unit(){
    	return $this->belongsTo('App\Http\Model\Unit', 'unit_id');
	}
	public function represent()
	{
		return $this->belongsTo('App\Http\Model\Represent', 'number', 'initial');
	}
}
