<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SpecValue extends Model
{
    use HasFactory;
    protected $fillable = [
        'spec_value',
    ];
    protected $table = 'specs_value';
    public $timestamps = false;

    public function specNames(): BelongsToMany
    {
        return $this->belongsToMany(Spec::class, 'products_specs_values', 'spec_value_id', 'spec_name_id', 'id', 'code')
            ->withPivot('product_id');
    }
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_specs_intermediate', 'specs_value_id', 'product_id', 'id', 'product_id');
    }
}
