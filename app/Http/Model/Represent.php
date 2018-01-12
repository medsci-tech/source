<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Represent extends Model
{
    protected $connection = 'mysql';
    protected $table = 'mime_represent_info';
}
