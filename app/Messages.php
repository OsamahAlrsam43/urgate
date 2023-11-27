<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Messages extends Model 
{

    protected $table = 'messages';
    public $timestamps = true;

	public $fillable = ['message', 'user_id', 'admin_id', 'is_admin', 'title', 'read_at'];

    use SoftDeletes;

    protected $dates = ['deleted_at'];

}