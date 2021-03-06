<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->app->bind(
            \App\Repositories\User\UserDataAccessRepositoryInterface::class,
            \App\Repositories\User\UserDataAccessEQRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
    }
}
