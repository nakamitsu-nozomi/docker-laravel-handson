<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->bind('App\Services\UserService');
        $this->app->bind('App\Services\WeatherService');
        $this->app->bind('App\Services\WeatherLocalizationService');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
    }
}
