<?php

namespace App\Providers;

use App\Test\MyService;
use Barryvdh\Debugbar\Facades\Debugbar;
use DebugBar\DebugBar as DebugBarDebugBar;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
       $this->app->singleton('myService', function($app)
       {
            return new MyService();
       });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Debugbar::disable();
    }
}
