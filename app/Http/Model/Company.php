<?php

namespace App\Http\Model;
use Moloquent;

class Company extends Moloquent
{
    protected $table = 'company';
	protected $fillable = ['full_name','short_name'];

}
