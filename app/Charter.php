<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;

class Charter extends Model {

	protected $table = 'charter';
	public $timestamps = true;

	use SoftDeletes;

	protected $dates = [ 'deleted_at', 'flight_date' ];
	protected $fillable = array(
		'name',
		'from_where',
		'to_where',
		'flight_type',
		'flight_number',
		'available_seats',
		'aircraft_id',
		'flight_date',
		'departure_time',
		'arrival_time',
		'economy_seats',
		'business_seats',
		'can_cancel',
		'show_in_home',
		'business_adult',
		'business_child',
		'business_baby',
		'price_adult',
		'price_child',
		'price_baby',
		'business_2way_adult',
		'business_2way_child',
		'business_2way_baby',
		'price_business_2way',
		'price_adult_2way',
		'price_child_2way',
		'price_baby_2way',
		'commission',
		'is_percent',
		'instructions',
      	'info',
		'pay_later_max',
		'cancel_fees',
		'cancel_fees_1',
		'cancel_fees_2',
		'cancel_fees_3',
		'cancel_days_1',
		'cancel_days_2',
		'cancel_days_3',
		'change_fees_1',
		'change_fees_2',
		'change_fees_3',
		'change_days_1',
		'change_days_2',
		'change_days_3',
		'void_max',
		'can_change',
		'change_fees',
		'seat_increase',
		'open_return_1month_adult',
		'open_return_3month_adult',
		'open_return_6month_adult',
		'open_return_12month_adult',
		'open_return_business_1month_adult',
		'open_return_business_3month_adult',
		'open_return_business_6month_adult',
		'open_return_business_12month_adult',
		'open_return_1month_child',
		'open_return_3month_child',
		'open_return_6month_child',
		'open_return_12month_child',
		'open_return_business_1month_child',
		'open_return_business_3month_child',
		'open_return_business_6month_child',
		'open_return_business_12month_baby',
		'open_return_1month_baby',
		'open_return_3month_baby',
		'open_return_6month_baby',
		'open_return_12month_baby',
		'open_return_business_1month_baby',
		'open_return_business_3month_baby',
		'open_return_business_6month_baby',
		'open_return_business_12month_baby',
      'arrival_day',
      'status_charter'
	);

	protected $appends = [ 'flight_day' ];

	public function orders() {
		return $this->hasMany( CharterOrders::class, 'charter_id' );
	}

	public function prices() {
		return $this->hasMany( CharterPrice::class, 'charter_id' );
	}

	public function getFlightDayAttribute() {
		return __( 'days.' . date( 'l', strtotime( $this->flight_date ) ) );
	}


	public function getBusinessSoldSeatsAttribute() {
        $soldSeats = 0;
        $business_orders              = $this->orders()->where( 'status', '!=', 'cancelled' )->where( 'flight_class', 'Business' )->get();
        foreach ( $business_orders as $business_order ) {
            $soldSeats += $business_order->passengers()->count();
        }
        return $soldSeats;
    }
    public function getEconomySoldSeatsAttribute() {
        $soldSeats = 0;
        $economy_orders= $this->orders()->where( 'status', '!=', 'cancelled' )->where( 'flight_class', 'Economy' )->get();
        foreach ( $economy_orders as $economy_order ) {
            $soldSeats += $economy_order->passengers()->count();
        }
        return $soldSeats;
    }
    public function getAllSoldSeatsAttribute() {
        $soldSeats = 0;
        $economy_orders= $this->orders()
            ->where( 'status', '!=', 'cancelled' )
            ->where( 'flight_class', 'Economy' )
            ->orWhere( 'flight_class', 'Business' )

            ->get();
        foreach ( $economy_orders as $economy_order ) {
            $soldSeats += $economy_order->passengers()->count();
        }
        return $soldSeats;
    }

	public function aircraft() {
		return $this->belongsTo( Aircraft::class, 'aircraft_id' );
	}

	public function from() {
		return $this->belongsTo( Country::class, 'from_where' );
	}

	public function to() {
		return $this->belongsTo( Country::class, 'to_where' );
	}

	public function roundtrip() {
		return $this->hasOne( Charter2Way::class, 'charter_id' );
	}

}