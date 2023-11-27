<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class FlightOrders extends Model
{
    /**
     * @var string
     */
    protected $table = 'flight_orders';

    /**
     * @var array
     */
    protected $fillable = ['flight_id', 'user_id', 'first_name', 'last_name', 'birth_place', 'birth_date', 'nationality',
        'passport_number', 'passport_issuance_date', 'passport_expire_date', 'father_name',
        'mother_name', 'price', 'passport_image', 'personal_image', 'status', 'delivered_by', 'flight_pdf'];

    /**
     * @var array
     */
    protected $casts = [
        'birth_date' => 'date',
        'passport_issuance_date' => 'date',
        'passport_expire_date' => 'date',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function flight()
    {
        return $this->belongsTo(Flight::class, 'flight_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function deliveredBy()
    {
        return $this->belongsTo(User::class, 'delivered_by');
    }

    protected static function boot()
    {
        parent::boot();

        // auto-sets values on creation
        static::creating(function ($query) {
            $pnr = 'pnr';
            if (!Schema::hasColumn((new static)->getTable(), $pnr)) {
                Schema::table((new static)->getTable(), function ($table)use($pnr) {
                    $table->string($pnr,9);
                });
            }
            if (Schema::hasColumn((new static)->getTable(), $pnr)){
                $query->pnr = generatePNR();
            }
        });
    }
}