<?php

use App\Http\Controllers\RecomendController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'api','prefix' => 'tags'], function () {
    Route::get('/{id}', [TagController::class, 'get']);
    Route::get('/', [TagController::class, 'list']);
});

Route::group(['middleware' => 'api', 'prefix' => 'recommendations'], function () {
    Route::get('/tag/{tagId}', [RecomendController::class, 'list']);
});
