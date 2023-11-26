<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AgencyCategories extends Model
{
    use HasFactory;
    protected $table = 'agency_categorized_document';
    protected $fillable = [

        'document_id',
        'agency_id',
        'data',
        'total_products',
        'categories_number',
    ];
    protected $casts = [
        'data' => 'array'
    ];

    // public function product(): HasOne
    // {
    //     return $this->hasOne(AgencyProduct::class);
    // }
}
