<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aircraft extends Model 
{

    protected $table = 'aircraft';
    public $timestamps = false;
    protected $fillable = array('name', 'logo', 'type');

}
