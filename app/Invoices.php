<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoices extends Model
{
    /**
     * @var string
     */
    protected $table = 'invoices';

    /**
     * @var array
     */
    protected $fillable = ['user', 'company', 'from_date', 'to_date'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(InvoiceItems::class, 'invoice_id');
    }
}
