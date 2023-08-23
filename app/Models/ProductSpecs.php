<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSpecs extends Model
{
    use HasFactory;

    protected $fillable = [
        'specs_name',
        'specs_value',
        'variant_code'
    ];

    protected $table = 'product_specs';
    protected $timestamps = false;
}
