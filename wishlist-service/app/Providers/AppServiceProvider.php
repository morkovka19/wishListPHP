<?php

namespace App\Providers;

use App\Models\WishTable;
use App\Services\RecomendApiClient;
use App\Services\WishService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(WishService::class, function ($app) {
            return new WishService(
                $app->make(WishTable::class),
                $app->make(RecomendApiClient::class)
            );
        });
    }

    public function boot(): void
    {
        //
    }
}
