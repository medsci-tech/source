<?php
/**
 * Created by ...
 * User: zhanghui
 * Date: 16/12/3
 * DesCription:...
 */
namespace App\Http\Model;

use Moloquent;
use DB;

class Mongodb extends Moloquent {

    protected $collection = 'users';
    protected $connection = 'test';

    public static function test() {
        $users = DB::collection('users')->get();
        var_dump($users);
    }
}