<?php

namespace App\Providers;

use App\Models\ItemTable;
use App\Models\TagTable;
use App\Services\RecomendApiClient;
use App\Services\RecomendService;
use App\Services\TagService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(RecomendService::class, function ($app) {
            return new RecomendService(
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
