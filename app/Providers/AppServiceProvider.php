<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    private const APP_TIMEZONE = 'Asia/Jakarta';

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
        config(['app.timezone' => self::APP_TIMEZONE]);
        date_default_timezone_set(self::APP_TIMEZONE);
    }
}
