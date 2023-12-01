<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
class MerchantProduct extends Model
{
    protected $fillable = [
        'product_name',
        'quantity',
    ];
    protected $connection = 'mongodb';
    protected $collection = 'merchant_products';
    
}
