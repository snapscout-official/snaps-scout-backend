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
        //Gate that checks if the user that wants to retrieve the merchant info is the merchant itself.
        
        Gate::define('view-merchant', function(Merchant $merchant){
            return (auth()->user()->id === $merchant->merchant_id && auth()->user()->role_id === Role::MERCHANT);
        });

        //Gate that checks if the user that wants to retrieve the agency info is the agency itself.
        
        Gate::define('view-agency', function()
        {
            return  auth()->user()->role_id === Role::AGENCY;
        });

    //     VerifyEmail::toMailUsing(function(object $notifiable, string $url)
    // {
    //     $frontEndUrl = 'http://localhost:5173/verify-email';
    //     return (new MailMessage)
    //         ->subject('Verify email address')
    //         ->line('Click the button below to verify your email address.')
    //         ->action('Verify email address', $frontEndUrl);
    // });
        
    }
}
