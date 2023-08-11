<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MerchantCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];
    
    protected $table = 'merchant_category';
    public $timestamps = false;

    public function merchant():HasOne
    {
        return $this->hasOne(Merchant::class, 'category_id');
    }
}
