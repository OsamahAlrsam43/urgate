<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CharterOrderFlights extends Model
{
	use SoftDeletes;

    protected $table = 'charter_order_flights';
    public $timestamps = false;
    protected $fillable = array('order_id', 'charter_id', 'price', 'price', 'commission', 'flight_class');

	public function charter()
	{
		return $this->belongsTo(Charter::class, 'charter_id');
	}
	
	public function order()
	{
		return $this->belongsTo(CharterOrders::class, 'order_id');
	}

}