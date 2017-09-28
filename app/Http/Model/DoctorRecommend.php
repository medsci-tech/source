<?php

namespace App\Http\Model;
use Moloquent;


class DoctorRecommend extends Moloquent {

    protected $connection = 'mongodb';
    protected $table = 'doctor_recommend';
    

}
