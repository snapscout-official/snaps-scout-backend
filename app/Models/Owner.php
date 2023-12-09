<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use MongoDB\Laravel\Eloquent\Model;

class Owner extends Model
{
    protected $fillable = [
        'name',
        'age',
        'company_name',
        'position'  
    ];
    protected $connection = 'mongodb';
    protected $collection = 'merchants';
    public function products():HasMany
    {
        return $this->hasMany(MerchantProduct::class, 'product_name');
    }
    
}
