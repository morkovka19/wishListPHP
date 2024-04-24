<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\FriendService;
use App\Services\Interfaces\FriendServiceInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            FriendServiceInterface::class,
            FriendService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
