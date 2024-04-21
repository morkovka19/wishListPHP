<?php

namespace App\Providers;

use App\Models\ItemTable;
use App\Models\TagTable;
use App\Services\RecomendApiClient;
use App\Services\TagService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(RecomendApiClient::class, function ($app) {
            return new RecomendApiClient(
                $app->make(ItemTable::class)
            );
        });

        $this->app->bind(TagService::class, function ($app) {
            return new TagService(
                $app->make(TagTable::class)
            );
        });
    }

    public function boot(): void
    {
        //
    }
}
