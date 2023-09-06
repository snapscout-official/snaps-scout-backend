<?php

namespace App\Models;

use App\Models\Product;
use App\Models\ThirdCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class ParentCategory extends Model
{
    use HasFactory;


    protected $fillable = [
        'parent_name'
    ];

    protected $table = 'parent_category';
    public $timestamps = false;
    protected $primaryKey = 'parent_id';
    public function products():HasManyThrough
    {
        return $this->hasManyThrough(Product::class, SubCategory::class, 'parent', 'sub_code', 'parent_id', 'sub_id');
    }

    public function subCategories():HasMany
    {
        return $this->hasMany(SubCategory::class, 'parent', 'parent_id' );
    }
    public function thirdCategories():HasManyThrough
    {
        return $this->HasManyThrough(ThirdCategory::class, SubCategory::class, 'parent', 'sub_id', 'parent_id', 'sub_id');
    }

    //a function that will return the desired output for the category

    public function categoryData()
    {
        $subCategories = $this->subCategories()->with();
        return $subCategories;
    }


    //creates third category base on the given parent category and subCategory on the request data
    public function createThirdCategory(string $subCategory, string $thirdCategory)
    {
           $subCategoryResult = $this->subCategories()
                                ->where('sub_name', $subCategory)
                                ->first();
            if (is_null($subCategoryResult))
            {
                return null;
            }
            return $subCategoryResult->thirdCategories()->create([
                'third_name' => $thirdCategory
            ]);
    }
    
}
