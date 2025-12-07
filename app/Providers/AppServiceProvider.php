<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\RouteRepositoryInterface;
use App\Repositories\RouteRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(RouteRepositoryInterface::class, RouteRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
