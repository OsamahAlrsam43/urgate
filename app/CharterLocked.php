<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CharterLocked extends Model 
{

    protected $table = 'charter_locked';
    public $timestamps = true;
    protected $fillable = array('charter_id', 'user_id', 'seats', 'price');

}