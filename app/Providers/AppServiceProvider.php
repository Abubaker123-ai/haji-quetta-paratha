<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Force HTTPS for all generated URLs in production (Railway terminates SSL at the edge)
        if ($this->app->environment('production') || str_contains(request()->getHost(), 'railway.app')) {
            URL::forceScheme('https');
        }
    }
}
