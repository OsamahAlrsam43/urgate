<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TravelImage extends Model
{
    /**
     * @var string
     */
    protected $table = 'travel_images';

    /**
     * @var array
     */
    protected $fillable = ['travel_id', 'image'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function travel()
    {
        return $this->belongsTo(Travel::class, 'travel_id');
    }
}
