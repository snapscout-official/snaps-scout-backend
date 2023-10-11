<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SpecValue extends Model
{
    use HasFactory;
    protected $fillable = [
        'spec_value',
    ];
    protected $table = 'specs_value';
    public $timestamps = false;

    public function spec_name():BelongsToMany
    {
        return $this->belongsToMany(Spec::class, 'spec_value_intermediary', 'spec_value_id', 'spec_id', 'id', 'code');
    }
}
