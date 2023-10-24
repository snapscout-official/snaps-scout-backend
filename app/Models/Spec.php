<?php

namespace App\Models;

use Database\Factories\SpecNameFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Spec extends Model
{
    use HasFactory;

    protected $fillable = [
        'specs_name',

    ];

    protected $table = 'product_specs';
    public $timestamps = false;
    protected $primaryKey = 'code';


    public function values(): HasMany
    {
        return $this->hasMany(SpecValue::class, 'spec_name_id', 'code');
    }
    protected static function newFactory(): Factory
    {
        return SpecNameFactory::new();
    }
}
