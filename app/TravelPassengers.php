<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TravelPassengers extends Model
{
    /**
     * @var string
     */
    protected $table = 'travel_passengers';

    /**
     * @var array
     */
    protected $fillable = ['order_id', 'first_name', 'last_name', 'birth_date', 'nationality',
        'passport_number', 'passport_expire_date', 'price', 'ticket_number', 'title', 'ticket_back', 'passport_image', 'personal_image'];

    /**
     * @var array
     */
    protected $casts = [
        'birth_date' => 'date',
        'passport_issuance_date' => 'date',
        'passport_expire_date' => 'date',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(TravelOrders::class, 'order_id');
    }
}