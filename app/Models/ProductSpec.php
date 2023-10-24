<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductSpec extends Pivot
{

    protected $table = 'spec_value_intermediary';
    public $timestamps = false;
    public function products(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'productid', 'product_id');
    }
}
