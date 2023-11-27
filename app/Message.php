<?php

namespace App;


use Illuminate\Database\Eloquent\Model;


class Message extends Model
{

	protected $table = 'messages';
	public $timestamps = true;

	protected $fillable = array('title_en','details_en','title_ar','details_ar');


 
}