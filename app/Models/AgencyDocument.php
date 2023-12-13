<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
    public function categorizedDocument():HasOne
    {
        return $this->hasOne(CategorizedDocument::class, 'document_id', 'id');
    }
}
