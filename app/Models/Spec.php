<?php

namespace App\Models;

use Database\Factories\SpecNameFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Spec extends Model
{
    use HasFactory;

    protected $fillable = [
        'specs_name',
    ];
    protected $hidden = ['pivot', 'code'];
    protected $table = 'product_specs';
    public $timestamps = false;
    protected $primaryKey = 'code';


    public function values(): BelongsToMany
    {
        return $this->belongsToMany(SpecValue::class, 'products_specs_values', 'spec_name_id', 'spec_value_id', 'code', 'id');
    }
    public function products():BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_specs_intermediary','spec_name_id', 'product_id', 'code', 'product_id');
    }
    protected static function newFactory(): Factory
    {
        return SpecNameFactory::new();
    }
}
