<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Agency extends Model
{
    use HasFactory;

    protected $fillable = [
        'agency_id',
        'agency_name',
        'location_id',
        'category_id',
        'position'
    ];

    protected $table = 'agency';
    protected $primaryKey = 'agency_id';
    public $incrementing = false;
    public $timestamps = false;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'agency_id', 'id');  
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'location_id', 'location_id');
    }

    public function agencyCategory(): BelongsTo
    {
        return $this->belongsTo(AgencyCategory::class, 'category_id');
    }
    public function categorizedDocuments(): HasMany
    {
        return $this->hasMany(CategorizedDocument::class, 'agency_id', 'agency_id');
    }
    public function documents(): HasMany
    {
        return $this->hasMany(AgencyDocument::class, 'agency_owner', 'agency_id');
    }
}
