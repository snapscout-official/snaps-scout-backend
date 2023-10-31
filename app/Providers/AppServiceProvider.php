<?php

namespace App\Providers;

use App\Http\Middleware\AdminMiddleware;
use App\Test\MyService;
use Illuminate\Support\Str;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\ServiceProvider;
use App\Services\Products\ProductService;
use DebugBar\DebugBar as DebugBarDebugBar;
use Illuminate\Support\Facades\RateLimiter;
use App\Services\Categories\CategoryService;
use Illuminate\Contracts\Foundation\Application;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class AppServiceProvider extends ServiceProvider
{

    public $singletons = [];
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(AdminMiddleware::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Debugbar::disable();
        // RateLimiter::for()

        HeadingRowFormatter::extend('custom', function ($value, $key) {
            return Str::slug($value);
        });
        HeadingRowFormatter::default('slug');
    }
}
