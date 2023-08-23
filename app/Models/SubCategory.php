<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_name',
        'parent'
    ];
    protected $table = 'sub_category';

    public $timestamps = false;

    public function thirdCategories():HasMany
    {
        return $this->hasMany(ThirdCategory::class, 'sub_id', 'sub_id');
    }
    public function parentCategory():BelongsTo
    {
        return $this->belongsTo(ParentCategory::class, 'parent', 'parent_id');
    }

    public function products():HasMany
    {
        return $this->hasMany(Product::class, 'sub_code', 'sub_id');
    }
    
}
