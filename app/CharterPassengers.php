<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CharterPassengers extends Model 
{

    protected $table = 'charter_passengers';
    public $timestamps = true;
    protected $fillable = array('order_id', 'title', 'first_name', 'last_name',
        'birth_date', 'nationality', 'passport_number', 'passport_expire_date', 'age');

    protected $appends = ['ticket_number', 'name', 'price', 'pnr', 'flight_class'];

	public function related()
	{
		return $this->hasMany(CharterPassengersRelated::class, 'passenger_id');
	}

	public function order() {
		return $this->belongsTo(CharterOrders::class, 'order_id');
	}

	public function getPnrAttribute() {
		return $this->order->pnr;
	}

	public function getFlightClassAttribute() {
		return $this->order->flight_class;
	}

	public function getPriceAttribute(){
		return $this->related()->sum("price");
	}

    public function getTicketNumberAttribute() {
		return $this->related()->pluck('ticket_number');
    }

    public function getNameAttribute() {
		return $this->title . ' ' . $this->first_name . ' ' . $this->last_name;
    }

    public function getPassengerNationalityAttribute() {
		return \App\Nationality::find( $this->nationality )->name['en'];
    }

}