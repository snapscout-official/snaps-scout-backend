<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AgencyCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'agency_category_name'
    ];
    protected $table = 'agency_category';
    public $timestamps = false;


    public function agency():HasOne
    {
        return $this->hasOne(Agency::class, 'category_id');
    }
}
