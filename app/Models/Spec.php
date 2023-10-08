<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Spec extends Model
{
    use HasFactory;

    protected $fillable = [
        'specs_name',
        
    ];

    protected $table = 'product_specs';
    public $timestamps = false;
    protected $primaryKey = 'code';
    
    public function products():BelongsToMany
    {
        return $this->belongsToMany(Product::class,'product_spec_intermediary','spec_id', 'product_id', 'code', 'product_id')
                    ->as('product');
    }
}
