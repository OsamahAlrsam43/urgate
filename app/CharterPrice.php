<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CharterPrice extends Model {

	protected $table = 'charter_price';
	public $timestamps = false;
	protected $fillable = array(
		'charter_id',
		'flight_class',
		'price',
		'price_class',
		'seats',
		'available_seats',
		'price_inf_3_12',
		'price_inf_3_6',
		'price_inf_3_3',
		'price_inf_3_1',
		'price_child_3_12',
		'price_child_3_6',
		'price_child_3_3',
		'price_child_3_1',
		'price_adult_3_12',
		'price_adult_3_6',
		'price_adult_3_3',
		'price_adult_3_1',
		'price_adult_1',
		'price_adult_2',
		'price_child_1',
		'price_child_2',
		'price_inf_1',
		'price_inf_2',
	);

	public function charter() {
		return $this->belongsTo( 'Charter', 'charter_id' );
	}

}