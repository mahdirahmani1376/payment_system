<?php

namespace App\Providers;

use App\Support\Storage\Contracts\SessionStorage;
use App\Support\Storage\Contracts\StorageInterface;
use Illuminate\Support\ServiceProvider;

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
        $this->app->bind(StorageInterface::class,function ($app) {
            return new SessionStorage('card');
        });
    }
}
