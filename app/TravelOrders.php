<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TravelOrders extends Model
{
    /**
     * @var string
     */
    protected $table = 'travel_orders';

    /**
     * @var array
     */
    protected $fillable = ['travel_id', 'user_id', 'price', 'status', 'delivered_by', 'travel_pdf', 'pnr', 'type'];

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
    public function travel()
    {
        return $this->belongsTo(Travel::class, 'travel_id');
    }

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function passengers()
	{
		return $this->hasMany(TravelPassengers::class, 'order_id');
	}

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function deliveredBy()
    {
        return $this->belongsTo(User::class, 'delivered_by');
    }
}
