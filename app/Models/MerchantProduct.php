<?php

namespace App\Models;

use App\Models\Owner;
use MongoDB\Laravel\Eloquent\Model;

class MerchantProduct extends Model
{
    protected $fillable = [
        'product_name',
        'quantity',
        'description',
        'is_available',
        'price',
        'bar_code',
        'specs'
    ];
    protected $casts = [
        'specs' => 'array',
    ];
    protected $connection = 'mongodb';
    protected $collection = 'merchant_products';
    
    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }
    public function addSpecs($data)
    {
        $this->push('specs', $data);
    }

}
