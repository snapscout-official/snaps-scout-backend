<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Agency;
use App\Models\Merchant;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];
    
    public function boot(): void
    {        
        Gate::define('view-merchant', function(Merchant $merchant){
            return (auth()->user()->id === $merchant->merchant_id && auth()->user()->role_id === Role::MERCHANT);
        });
    
        Gate::define('view-agency', function()
        {
            return  auth()->user()->role_id === Role::AGENCY;
        });
       
    }
}
