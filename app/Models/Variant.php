<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    use HasFactory;

    protected $fillable = [
        'variant_name',
        'product_code',
        'is_available',
        'price'
    ];

    protected $timestamps = false;
    protected $table = 'variants';
}
