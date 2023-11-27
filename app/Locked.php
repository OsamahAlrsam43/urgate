<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Locked extends Model
{
    /**
     * @var string
     */
    protected $table = 'charter_locked';

    /**
     * @var array
     */
    protected $fillable = ['charter_id', 'user_id', 'seats', 'price', 'seat_price'];

    public function charter() {
    	return $this->belongsTo(Charter::class, 'charter_id');
    }
}
