<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Transaction extends Model
{
    /**
     * @var string
     */
    protected $table = 'transactions';

    /**
     * @var array
     */
    protected $fillable = ['from', 'to', 'amount','comment','pnr','type', 'creditBefore', 'creditAfter', 'connectedID', 'connectedTable'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function toUser()
    {
        return $this->belongsTo(User::class, 'to');
    }

    protected static function boot()
    {
        parent::boot();

        // auto-sets values on creation
        /*static::creating(function ($query) {
            $pnr = 'pnr';
            if (!Schema::hasColumn((new static)->getTable(), $pnr)) {
                Schema::table((new static)->getTable(), function ($table)use($pnr) {
                    $table->string($pnr,9);
                });
            }
            if (Schema::hasColumn((new static)->getTable(), $pnr)){
                $query->pnr = generatePNR();
            }
        });*/
    }
    
}
