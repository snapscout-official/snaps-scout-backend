<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Variant extends Model
{
    use HasFactory;

    protected $fillable = [
        'variant_name',
        'product_code',
        'is_available',
    ];

    protected $timestamps = false;
    protected $table = 'variants';

    public function specs():BelongsToMany
    {
        return $this->belongsToMany(Spec::class, 'variant_specs', 'variant_id', 'specs_id', 'var_code', 'code');
    }
}
