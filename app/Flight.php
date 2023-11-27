<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    /**
     * @var string
     */
    protected $table = 'flights';

    /**
     * @var array
     */
    protected $fillable = ['name', 'ticket', 'trip_information', 'class', 'price', 'going_date',
        'coming_date', 'aircraft_operator', 'aircraft_logo', 'airplane_type', 'seat_type',
        'electric_port', 'display', 'thumb', 'best_offer', 'stop','cancellation_before_departure','cancellation_before_departure_price','cancellation_after_departure','cancellation_after_departure_price','absence','absence_price','change_before_departure','change_before_departure_price','change_after_departure','change_after_departure_price', 'commission', 'is_percent', 'special_commission'];

    /**
     * @var array
     */
    protected $casts = [
        'name' => 'array',
        'trip_information' => 'array',
        'class' => 'array',
        'price' => 'array',
        'aircraft_operator' => 'array',
        'airplane_type' => 'array',
        'seat_type' => 'array',
        'electric_port' => 'array',
        'display' => 'array',
        'special_commission' => 'array',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(FlightOrders::class, 'flight_id');
    }
}
