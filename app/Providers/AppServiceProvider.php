<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    private const APP_TIMEZONE = 'Asia/Jakarta';
    private const APP_LOCALE = 'id';

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
        config(['app.locale' => self::APP_LOCALE]);
        config(['app.fallback_locale' => self::APP_LOCALE]);

        app()->setLocale(self::APP_LOCALE);
        Carbon::setLocale(self::APP_LOCALE);

        date_default_timezone_set(self::APP_TIMEZONE);
    }
}
