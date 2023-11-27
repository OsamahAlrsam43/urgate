<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceItems extends Model
{
    /**
     * @var string
     */
    protected $table = 'invoice_items';

    /**
     * @var array
     */
    protected $fillable = ['date', 'item_type', 'credit', 'details', 'credit_after', 'invoice_id'];
}
