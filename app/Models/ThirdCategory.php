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
}
