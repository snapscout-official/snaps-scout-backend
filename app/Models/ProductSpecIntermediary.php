<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProductSpecIntermediary extends Model
{
    use HasFactory;
    protected $fillable = [
        'productid',
        'spec_id',
        'spec_value_id'
    ];

    protected $table = 'spec_value_intermediary';
    public $timestamps = false;
    public function specNames(): BelongsTo
    {
        return $this->belongsTo(Spec::class, 'spec_id', 'code');
    }
    public function specValues(): BelongsTo
    {
        return $this->belongsTo(SpecValue::class, 'spec_value_id', 'id');
    }
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_spec_intermediary', 'spec_value_id', 'product_id', 'id', 'product_id');
    }
}
