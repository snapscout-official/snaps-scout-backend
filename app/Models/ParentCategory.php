<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ParentCategory extends Model
{
    use HasFactory;


    protected $fillable = [
        'parent_name'
    ];

    protected $table = 'parent_category';

    public $timestamps = false;

    public function products():HasMany
    {
        return $this->hasMany(Product::class,'parent_code', 'parent_id');
    }

    public function subCategories():HasMany
    {
        return $this->hasMany(SubCategory::class, 'parent', 'parent_id' );
    }
    
}
