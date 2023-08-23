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
}
