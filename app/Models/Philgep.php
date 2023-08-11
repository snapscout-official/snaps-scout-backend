<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Philgep extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'type'
    ];
    
    protected $table = 'philgeps';
    public $timestamps = false;

    public function merchant():HasOne
    {
        return $this->hasOne(Merchant::class, 'philgeps_id');
    }
}
