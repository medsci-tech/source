<?php

namespace App\Http\Model;
use Moloquent;


class DoctorProtocol extends Moloquent {

    protected $table = 'doctor_protocol';
	protected $fillable = ['doctor_id','file_url','file_name','check_status'];

}
