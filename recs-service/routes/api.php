<?php

use App\Http\Controllers\RecomendController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'api','prefix' => 'tags'], function () {
    Route::get('/{id}', [TagController::class, 'get']);
    Route::get('/', [TagController::class, 'list']);
});

Route::group(['middleware' => 'api', 'prefix' => 'recommendations'], function () {
    Route::get('/{id}', [RecomendController::class, 'get']);
    Route::get('/tag/{tagId}', [RecomendController::class, 'list']);
});

Route::group(['middleware' => 'api', 'prefix' => 'test'], function () {
    Route::get('test', [TestController::class, 'test']);
});
