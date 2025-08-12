<?php

namespace App\Providers;

use App\Repositories\FriendRequestsRepository;
use App\Repositories\Interfaces\FriendRequestsRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            FriendRequestsRepositoryInterface::class,
            FriendRequestsRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
