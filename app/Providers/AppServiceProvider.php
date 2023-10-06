<?php

namespace App\Providers;

use App\Services\Categories\CategoryService;
use App\Services\Products\ProductService;
use App\Test\MyService;
use Barryvdh\Debugbar\Facades\Debugbar;
use DebugBar\DebugBar as DebugBarDebugBar;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class AppServiceProvider extends ServiceProvider
{

    public $singletons = [

    ];
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(CategoryService::class, function(Application $app)
        {
            return new CategoryService();
        });

        $this->app->singleton(ProductService::class, function(Application $app)
        {
            return new ProductService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Debugbar::disable();
        // RateLimiter::for()
        // // HeadingRowFormatter::default('custom')
        // HeadingRowFormatter::extend('customized', function($value, $key){
        //     return 
        // })
    }
}
