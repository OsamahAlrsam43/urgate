<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CharterHistory extends Model
{
    /**
     * @var string
     */
    protected $table = 'charter_history';
	public $timestamps = true;
	use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = ['order_id', 'user_id', 'ip', 'action'];

	public function user()
	{
		return $this->belongsTo(User::class, 'user_id');
	}
}
