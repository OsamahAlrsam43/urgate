<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    /**
     * @var string
     */
    protected $table = 'news';

    /**
     * @var array
     */
    protected $fillable = ['content'];

    /**
     * @var array
     */
    protected $casts = [
        'content' => 'array'
    ];
}
