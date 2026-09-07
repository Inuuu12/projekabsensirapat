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

        if (!app()->runningInConsole()) {
            $host = request()->getHost();
            $isLocal = in_array($host, ['localhost', '127.0.0.1', '::1'])
                || str_ends_with($host, '.test')
                || str_ends_with($host, '.local');

            if (!$isLocal && (app()->environment('production') || str_starts_with((string) config('app.url'), 'https://'))) {
                \Illuminate\Support\Facades\URL::forceScheme('https');
            }
        }
    }
}
