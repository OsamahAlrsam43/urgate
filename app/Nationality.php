<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nationality extends Model
{
    /**
     * @var string
     */
    protected $table = 'nationality';

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
