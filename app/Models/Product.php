<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_code',
        'sub_code',
        'third_code',
        'description'
    ];

    // public function parentCategory():BelongsTo
    // {
    //     return $this->belongsTo(ParentCategory::class ,'parent_code', 'parent_id');
    // }
    
    public function subCategory():BelongsTo
    {
        return $this->belongsTo(subCategory::class, 'sub_code', 'sub_id');
    }
}
