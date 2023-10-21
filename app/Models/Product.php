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
        'product_name',
        'sub_code',
        'third_code',
        'description'
    ];

    protected $primaryKey = 'product_id';
    public function getProductParent()
    {
        return $this->subCategory()->get()->parentCategory;
    }

    public function subCategory(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class, 'sub_code', 'sub_id');
    }
    public function thirdCategory(): BelongsTo
    {
        return $this->belongsTo(ThirdCategory::class, 'third_code', 'third_id');
    }
    public function specs(): BelongsToMany
    {
        return $this->belongsToMany(Spec::class, 'spec_value_intermediary', 'productid', 'spec_id', 'product_id', 'code')
            ->as('spec_values')
            ->using(SpecValuePivot::class)
            ->withPivot('spec_value_id');
    }

    // public function productSpecs(): HasMany
    // {
    //     return $this->hasMany(ProductSpecIntermediate::class, 'productid', 'product_id');
    // }
}
