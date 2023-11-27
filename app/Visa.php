<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visa extends Model
{
    /**
     * @var string
     */
    protected $table = 'visas';

    /**
     * @var array
     */
    protected $fillable = ['name', 'description', 'papers', 'visa_type', 'price', 'thumb', 'best_offer', 'commission', 'is_percent', 'special_commission'];

    /**
     * @var array
     */
    protected $casts = [
        'name' => 'array',
        'description' => 'array',
        'papers' => 'array',
        'visa_type' => 'array',
        'special_commission' => 'array',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(VisaOrders::class, 'visa_id');
    }
}
