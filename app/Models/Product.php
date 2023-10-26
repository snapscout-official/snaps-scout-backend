<?php

namespace App\Models;

use App\Models\SpecValuePivot;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Concerns\InteractsWithPivotTable;
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
}
