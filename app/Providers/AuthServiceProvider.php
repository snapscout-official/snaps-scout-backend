<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Role;
use App\Models\User;
use App\Models\Agency;
use App\Guard\JWTGuard;
use App\Models\Merchant;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Config;
use SebastianBergmann\CodeUnit\FunctionUnit;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

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
        Gate::define('view-merchant', function (Merchant $merchant) {
            return (auth()->user()->id === $merchant->merchant_id && auth()->user()->role_id === Role::MERCHANT);
        });

        Gate::define('view-agency', function () {
            return  auth()->user()->role_id === Role::AGENCY;
        });
        VerifyEmail::createUrlUsing(function ($notifiable) {
            $frontEndBaseUrl = 'http://localhost:5173/verify-email';
            $temporarySignedUrl = URL::temporarySignedRoute(
                'verification.verify',
                Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
                [
                    'id' => $notifiable->getKey(),
                    'hash' => sha1($notifiable->getEmailForVerification()),
                ]
            );
            $parsedUrl = parse_url($temporarySignedUrl);
            $id = $notifiable->getKey();
            $hash = sha1($notifiable->getEmailForVerification());
            $query = $parsedUrl['query'];

            return "{$frontEndBaseUrl}/{$id}/{$hash}?{$query}";
        });

        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->subject('Verify Email Address')
                ->line('Click the button below to verify your email address')
                ->action('Verify Email Address', $url);
        });

        ResetPassword::createUrlUsing(function (User $user, string $token) {
            return 'https://www.snap-scout.com/reset-password?token=' . $token;
        });
        $this->registerPolicies();
        $this->app['auth']->extend(
            'jwt-authentication',
            function($app, $name, array $config){
                $guard = new JWTGuard(
                    $app['tymon.jwt'],
                    $app['request']
                );
                $app->refresh('request', $guard, 'setRequest');
                return $guard;
            }
        );
    }
}
