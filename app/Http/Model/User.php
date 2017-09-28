<?php

namespace App\Http\Model;
use Moloquent;

//use Illuminate\Database\Eloquent\Model;
//use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
//class User extends Model
//use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
//p(Eloquent);die;
//class User extends Eloquent
//{
////    protected $table='user';
////    protected $primaryKey='user_id';
////    public $timestamps=false;
////    protected $collection = 'user';
//    protected $connection = 'mongodb';
//    protected $table = 'user';
//
//}

class User extends Moloquent {

    protected $connection = 'mongodb';
    protected $table = 'user';


}
