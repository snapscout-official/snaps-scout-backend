<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class SpecValuePivot extends Pivot
{
    public function spec_value(): BelongsTo
    {
        return $this->belongsTo(SpecValue::class, 'spec_value_id', 'id');
    }
}
