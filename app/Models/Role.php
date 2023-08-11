<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    public const MERCHANT = 1;
    public const AGENCY = 2;
    public const SUPERADMIN = 3;

    
    public $timestamps = false;
}
