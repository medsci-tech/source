<?php

namespace App\Http\Model;
use Moloquent;

class User extends Moloquent {

    protected $connection = 'mongodb';
    protected $table = 'user';


}
