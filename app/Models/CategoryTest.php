<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryTest extends Model
{
    use HasFactory;
    protected $fillable = [
        'general_description',
        'unit_of_measure',
        'quantity'
    ];
}
