<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_code',
        'sub_code',
        'third_code',
        'description'
    ];

    protected $primaryKey = 'product_id';
    // public function parentCategory():BelongsTo
    // {
    //     return $this->belongsTo(ParentCategory::class ,'parent_code', 'parent_id');
    // }
    
    public function subCategory():BelongsTo
    {
        return $this->belongsTo(subCategory::class, 'sub_code', 'sub_id');
    }
    public function thirdCategory():BelongsTo
    {
        return $this->belongsTo(ThirdCategory::class, 'third_code', 'third_id')->withDefault();
    }
    public function specs():BelongsToMany
    {
        return $this->belongsToMany(Spec::class,'product_specs_intermediary', 'product_id', 'spec_id', 'product_id', 'code')
                    ->as('product');
    }
    
}
