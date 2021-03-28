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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
    }
}
