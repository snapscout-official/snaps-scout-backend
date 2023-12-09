<?php

namespace App\Models;

use App\Models\Owner;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use MongoDB\Laravel\Eloquent\Model;

class MerchantProduct extends Model
{
    protected $fillable = [
        'product_name',
        'product_category',
        'quantity',
        'is_available',
        'price',
        'barcode',
        'specs'
    ];
    // protected $casts = [
    //     'specs' => 'array',
    // ];
    protected $connection = 'mongodb';
    protected $collection = 'merchant_products';
    
    public function merchant():BelongsTo
    {
        return $this->belongsTo(Merchant::class, "product_category");
    }

    public function owner():BelongsTo
    {
        return $this->belongsTo(Owner::class, 'product_name');
    }

}
