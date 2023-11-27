<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Travel extends Model
{
    /**
     * @var string
     */
    protected $table = 'travels';

    /**
     * @var array
     */
    protected $fillable = ['name', 'from_date', 'to_date', 'from_country', 'to_country', 'price', 'thumb',
        'period', 'description', 'best_offer', 'commission', 'is_percent', 'special_commission', 'from_time', 'flight_number', 'class', 'aircraft_operator', 'aircraft_logo', 'instructions'];

    /**
     * @var array
     */
    protected $casts = [
        'name' => 'array',
        'from_date' => 'date',
        'to_date' => 'date',
        'period' => 'array',
        'price' => 'array',
        'description' => 'array',
        'special_commission' => 'array',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany(TravelImage::class, 'travel_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(TravelOrders::class, 'travel_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fromCountry()
    {
        return $this->belongsTo(Nationality::class, 'from_country');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function toCountry()
    {
        return $this->belongsTo(Nationality::class, 'to_country');
    }
}
