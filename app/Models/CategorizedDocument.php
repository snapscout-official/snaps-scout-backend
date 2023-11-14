<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CategorizedDocument extends Model
{
    use HasFactory;
    protected $table = 'agency_categorized_document';
    protected $fillable = [
        'agency_id',
        'total_products',
        'data',
    ];
    protected $casts = [
        'data' => 'array'
    ];
    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class, 'agency_id', 'agency_id');
    }
}
