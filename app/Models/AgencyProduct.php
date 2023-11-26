<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AgencyProduct extends Model
{
    use HasFactory;
    protected $table = 'agency_sampleproduct';
    protected $fillable = [

        'parentCategoryName',
        'products',
        'productNumber',
        'totalQuantity'
    ];

    protected $casts = [
        'products' => 'array'
    ];

    // public function product(): BelongsTo
    // {
    //     return $this->belongsTo(AgencyCategories::class);
    // }
}
