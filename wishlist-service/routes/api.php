<?php

use App\Http\Controllers\WishListController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/wishes', [WishListController::class, 'create']);
Route::put('/wishes/{id}', [WishListController::class, 'update']);
Route::get('/wishes/list/{userId}', [WishListController::class, 'getList']);
Route::delete('/wishes/{id}/{userId}', [WishListController::class, 'delete']);
Route::get('/wishes/{id}', [WishListController::class, 'get']);
