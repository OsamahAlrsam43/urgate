<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpecialCommission extends Model
{

    protected $table = 'special_commission';
    public $timestamps = false;
    protected $fillable = array('user_id', 'charter_id', 'commission', 'is_percent');

}