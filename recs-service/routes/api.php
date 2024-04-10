<?php

use App\Http\Controllers\RecomendController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'tags'], function () {
    Route::get('/{id}', [TagController::class, 'get']);
    Route::get('/', [TagController::class, 'list']);
});

Route::group(['prefix' => 'recommendations'], function () {
    Route::get('/{id}', [RecomendController::class, 'get']);
    Route::get('/tag/{tagId}', [RecomendController::class, 'list']);
});
