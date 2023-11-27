<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CharterPassengersRelated extends Model 
{
	use SoftDeletes;

    protected $table = 'charter_passengers_related';
    public $timestamps = false;
    protected $fillable = array('passenger_id', 'flight_id', 'ticket_number', 'price', 'order_id');

}