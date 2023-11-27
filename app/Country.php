<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    /**
     * @var string
     */
    protected $table = 'countries';

    /**
     * @var array
     */
    protected $fillable = ['name', 'code'];

    /**
     * @var array
     */
    protected $casts = [
        'name' => 'array'
    ];
}
