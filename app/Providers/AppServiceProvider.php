<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS in production
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        // Force HTTPS if behind proxy (common in hosting environments)
        if (request()->server('HTTP_X_FORWARDED_PROTO') === 'https' ||
            request()->server('HTTP_X_FORWARDED_SSL') === 'on' ||
            request()->server('SERVER_PORT') == 443) {
            URL::forceScheme('https');
        }

        // Force HTTPS for all environments if APP_FORCE_HTTPS is true
        if (config('app.force_https', false)) {
            URL::forceScheme('https');
        }
    }
}
