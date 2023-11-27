<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Threads extends Model 
{

    protected $table = 'threads';
    public $timestamps = true;

    public $fillable = ['user_id'];
    public $appends = ['lastMessage', 'unreadMessages'];

    public function messages()
    {
        return $this->hasMany(Messages::class, 'thread_id');
    }

    public function getUnreadMessagesAttribute() {
    	return $this->messages()->whereNull("read_at")->where('is_admin', '>', 0)->count();
    }

    public function user() {
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function getLastMessageAttribute() {
    	return $this->messages()->where("is_admin", 1)->select(["title", "read_at"])->orderBy("id", 'desc')->first();
    }
}
