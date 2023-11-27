<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class CharterOrders extends Model
{
    /**
     * @var string
     */
    protected $table = 'charter_orders';

    /**
     * @var array
     */
	public $timestamps = true;
	protected $fillable = array('user_id', 'charter_id', 'pnr',
        'status', 'delivered_by','price', 'phone', 'flight_class', 'note', 'commission',
        'email', 'flight_type', 'expire_at', 'open_end', 'open_duration','notiAt');

	protected $dates = ['expire_at', 'open_end','created_at','notiAt'];

	//protected $appends = ['price'];

	/*public function getPriceAttribute() {
		return $this->passengerRelated()->sum('price');
	}*/
	
  
        public static function findOrCreate($id)
      {
          $obj = static::find($id);
          return $obj ?: new static;
      }

    public function charter()
    {
        return $this->belongsTo(Charter::class, 'charter_id');
    }

    public function flights()
    {
        return $this->hasMany(CharterOrderFlights::class, 'order_id');
    }

    public function passengerRelated()
    {
        return $this->hasMany(CharterPassengersRelated::class, 'order_id');
    }

    public function cancelledFlights()
    {
        return $this->hasMany(CharterOrderFlights::class, 'order_id')->onlyTrashed();
    }

    public function history()
    {
        return $this->hasMany(CharterHistory::class, 'order_id')->orderBy('id', 'desc');
    }

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function passengers()
	{
		return $this->hasMany(CharterPassengers::class, 'order_id');
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