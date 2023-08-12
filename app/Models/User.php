<?php

namespace App\Models;


use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'birth_date',
        'tin_number',
        'gender',
        'phone_number',
        'email',
        'password',
        'role_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function hasRole(string $role)
    {
        
        if ($this->role->role_name === $role)
        {
            return true;
        }
        return false;
    }

   public function merchant():HasOne
   {
    return $this->hasOne(Merchant::class, 'merchant_id', 'id');
   }

   public function agency():HasOne
   {
    return $this->hasOne(Agency::class, 'agency_id', 'id');
   }

   public function role():BelongsTo
   {
    return $this->belongsTo(Role::class, 'role_id');
   }
}
