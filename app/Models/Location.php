<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'building_name',
        'street',
        'barangay',
        'city',
        'province',
        'country'
    ];
    public $timestamps = false;
    protected $primaryKey = 'location_id';

    public function merchant():HasOne
    {
        return $this->hasOne(Merchant::class, 'location_id', 'location_id');
    }
    public function agency():HasOne
    {
        return $this->hasOne(Agency::class, 'location_id', 'location_id');
    }
}
