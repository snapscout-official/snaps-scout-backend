<?php

namespace App\Providers;

use App\Events\CategoryDeleted;
use App\Events\PasswordReset;
use App\Events\UserRegistered;
use App\Listeners\DeleteCategoriesCache;
use App\Listeners\PasswordResetSuccess;
use App\Listeners\SendEmailNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        PasswordReset::class => [
            PasswordResetSuccess::class
        ],
        CategoryDeleted::class => [
            DeleteCategoriesCache::class
        ],     

    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        Event::listen(UserRegistered::class,
        [SendEmailNotification::class, 'handle']);
    }
}
