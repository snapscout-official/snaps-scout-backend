<?php

namespace App\Providers;

use App\Models\AgencyDocument;
use App\Models\Product;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use League\CommonMark\Node\Block\Document;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api/v1')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });

        //global patterns
        Route::pattern('spec', '[0-9]+');
        Route::pattern('product', '[0-9]+');
        Route::pattern('specValueId', '[0-9]+');
        //bind for product route parameter
        Route::bind('productWithSpecs', function (string $value) {
            return Product::with('specs.values')->find($value);
        });
        // Route::bind('document', function(string $value)
        // {
        //     return AgencyDocument::find($value);
        // });
    }
}
