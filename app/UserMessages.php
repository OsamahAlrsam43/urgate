<?php

namespace App;


use Illuminate\Database\Eloquent\Model;


class UserMessages extends Model
{

	protected $table = 'users_messages';
	public $timestamps = true;

	protected $fillable = array('user_id','message_id');


 
}