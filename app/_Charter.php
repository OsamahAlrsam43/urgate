<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class _Charter extends Model
{
    /**
     * @var string
     */
    protected $table = 'charter';

    /**
     * @var array
     */
    protected $fillable = ['name', 'ticket', 'trip_information', 'class', 'price', 'locked', 'going_date',
        'coming_date', 'aircraft_operator', 'aircraft_logo', 'airplane_type', 'commission', 'is_percent', 'featured', 'flight_number', 'instructions', 'can_cancel', 'special_commission'];

    /**
     * @var array
     */
    protected $casts = [
        'name' => 'array',
        'trip_information' => 'array',
        'class' => 'array',
        'price' => 'array',
        'locked' => 'array',
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
        return $this->hasMany(CharterOrders::class, 'charter_id');
    }

    public function backs()
    {
        return $this->hasMany(CharterOrders::class, 'back_id');
    }
}
