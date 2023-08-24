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
        'specs_value'
    ];

    protected $table = 'product_specs';
    public $timestamps = false;
    protected $primaryKey = 'code';
    public function variants():BelongsToMany
    {
        return $this->belongsToMany(Variant::class,'variant_specs','specs_id','variant_id','code','var_code');
    }
}
