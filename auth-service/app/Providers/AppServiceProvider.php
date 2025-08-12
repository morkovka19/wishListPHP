<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\FriendService;
use App\Services\SearchService;
use App\Services\Interfaces\FriendServiceInterface;
use App\Services\Interfaces\SearchServiceInterface;

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
        
        $this->app->bind(
            SearchServiceInterface::class,
            SearchService::class
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
