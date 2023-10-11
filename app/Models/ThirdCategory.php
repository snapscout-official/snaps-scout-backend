<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThirdCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'third_name',
        'sub_id'
    ];

    protected $table = 'third_category';

    public $timestamps = false;
    protected $primaryKey = 'third_id';
    public function products()
    {
        return $this->hasMany(Product::class, 'third_code', 'third_id');
    }
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_id', 'sub_id');
    }
    public static function returnThirdCategoryWithParentSub()
    {
        $thirdCategories = static::with('subCategory.parentCategory')->get();
        foreach($thirdCategories as $thirdCategory)
        {
            $thirdCategory['subName'] = $thirdCategory->subCategory->sub_name;
            $thirdCategory['parentName'] = $thirdCategory->subCategory->parentCategory->parent_name;
            unset($thirdCategory->subCategory);
        }
        return $thirdCategories;
    }
}
