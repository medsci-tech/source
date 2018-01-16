<?php

namespace App\Http\Model;
use Moloquent;


class DoctorRecommend extends Moloquent {

    protected $connection = 'mongodb';
    protected $table = 'doctor_recommend';
    protected $fillable = ['doctor_id','recommend_id'];

}
