<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AgencyDocument extends Model
{
    use HasFactory;
    protected $fillable = [
        'document_name',
        'is_categorized'
    ];
    protected $table = 'agency_document';
    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class, 'agency_owner', 'agency_id');
    }
}
