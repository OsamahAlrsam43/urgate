<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    /**
     * @var string
     */
    protected $table = 'settings';

    /**
     * @var array
     */
    protected $fillable = ['about_title', 'about_content', 'contact', 'phone', 'address',
        'mail', 'facebook', 'instagram', 'twitter', 'youtube', 'linked', 'charter', 'create_charter'];

    protected $casts = [
        'about_title' => 'array',
        'create_charter' => 'array',
        'about_content' => 'array',
        'contact' => 'array',
    ];
}
