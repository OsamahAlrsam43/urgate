<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar', 'type', 'balance', 'activation', 'company', 'address', 'phone', 'showInvoices', 'parent'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

	public $appends = ['unreadMessages', 'lastMessage'];

    public function getBalanceAttribute($value) {

            if ($this->parent !== 0) {
                if (User::find($this->parent)->type != 'GSA') {
                    return User::find($this->parent)->balance;
                }
            }

    	return $value;
    }

    /**
     * @param $role
     * @return bool
     */
    public function hasRole($role)
    {
        return $this->type === $role;
    }

    public function specialCommission()
    {
        return $this->hasMany(SpecialCommission::class, 'user_id');
    }

    public function adminTransactions()
    {
        return $this->hasMany(Transaction::class, 'from');
    }

    public function userTransactions()
    {
	    if($this->parent !== 0) {
		    return $this->hasMany(Transaction::class, 'to', 'parent');
	    }

        return $this->hasMany(Transaction::class, 'to');
    }

    public function invoices()
    {
        return $this->hasMany(Invoices::class, 'user');
    }

    public function hasParent() {
	    if($this->parent !== 0) return true;
	    return false;
    }

    public function parent_company() {
	    return $this->belongsTo(User::class, 'parent');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function travelPurchases()
    {
    	if($this->parent !== 0) {
		    return $this->hasMany(TravelOrders::class, 'user_id', 'parent');
	    }

        return $this->hasMany(TravelOrders::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function flightPurchases()
    {
	    if($this->parent !== 0) {
		    return $this->hasMany(FlightOrders::class, 'user_id', 'parent');
	    }

	    return $this->hasMany(FlightOrders::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function charterPurchases()
    {
	    if($this->parent !== 0) {
		    return $this->hasMany(CharterOrders::class, 'user_id', 'parent');
	    }

	    return $this->hasMany(CharterOrders::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function visaPurchases()
    {
	    if($this->parent !== 0) {
		    return $this->hasMany(VisaOrders::class, 'user_id', 'parent');
	    }

        return $this->hasMany(VisaOrders::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function travelOrderReceived()
    {
        return $this->hasMany(TravelOrders::class, 'delivered_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function flightOrderReceived()
    {
        return $this->hasMany(FlightOrders::class, 'delivered_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function visaOrderReceived()
    {
        return $this->hasMany(VisaOrders::class, 'delivered_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lockedCharter()
    {
        return $this->hasMany(Locked::class, 'user_id');
    }

	public function messages()
	{
		return $this->hasMany(Messages::class, 'user_id');
	}

    public function getUnreadMessagesAttribute() {
    	return $this->messages()->whereNull("read_at")->count();
    }

	public function getLastMessageAttribute() {
		return $this->messages()->orderBy("id", 'desc')->first();
	}
}
