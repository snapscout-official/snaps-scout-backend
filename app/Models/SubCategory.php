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
    protected $primaryKey = 'sub_id';

    public function thirdCategories():HasMany
    {
        return $this->hasMany(ThirdCategory::class, 'sub_id', 'sub_id');
    }
    public function parentCategory():BelongsTo
    {
        return $this->belongsTo(ParentCategory::class, 'parent', 'parent_id');
    }

    // public function products():HasMany
    // {
    //     return $this->hasMany(Product::class, 'sub_code', 'sub_id');
    // }
    public static function getSubCategoriesWithParent()
    {
        $subCategories = static::with('parentCategory')->get();
        foreach($subCategories as $subCategory)
        {
            
            $subCategory['parent_category'] = $subCategory->parentCategory->parent_name;
            unset($subCategory->parentCategory);
            unset($subCategory->parent);
        }
        return $subCategories;
    } 
    
}
