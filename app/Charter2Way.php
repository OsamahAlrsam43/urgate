<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Charter2Way extends Model
{

    protected $table = 'charter_2way';
    public $timestamps = false;
    protected $fillable = array('charter_id', 'flight_number', 'flight_date', 'departure_time', 'arrival_time');

}
