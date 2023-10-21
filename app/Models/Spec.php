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

    protected $table = 'product_specs';
    public $timestamps = false;
    protected $primaryKey = 'code';

    // public function products(): BelongsToMany
    // {
    //     return $this->belongsToMany(Product::class, 'product_spec_intermediary', 'spec_id', 'product_id', 'code', 'product_id')
    //         ->as('product_spec')
    //         ->withPivot('spec_value_id')
    //         ->using(SpecValuePivot::class);
    // }
    // public function values(): BelongsToMany
    // {
    //     return $this->belongsToMany(SpecValue::class, 'spec_value_intermediary', 'spec_id', 'spec_value_id', 'code', 'id');
    // }
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'spec_value_intermediary', 'spec_id', 'productid', 'code', 'product_id')
            ->as('spec_values')
            ->withPivot('spec_value_id')
            ->using(SpecValuePivot::class);
    }
    protected static function newFactory(): Factory
    {
        return SpecNameFactory::new();
    }
}
