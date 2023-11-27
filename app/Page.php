<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    /**
     * @var string
     */
    protected $table = 'pages';

    /**
     * @var array
     */
    protected $fillable = ['name', 'title', 'content', 'sticky', 'sticky_date', 'page_type'];

    /**
     * @var array
     */
    protected $casts = [
        'name' => 'array',
        'title' => 'array',
        'content' => 'array'
    ];
}
